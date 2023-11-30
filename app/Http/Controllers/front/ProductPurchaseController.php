<?php

namespace App\Http\Controllers\front;

use App\frontmodels\PurchasedProduct;
use App\frontmodels\Transaction;
use App\Http\Controllers\Controller;
use App\frontmodels\Product;
use App\Models\User;
use App\Notifications\ProductAdd;
use App\Notifications\ProductPurchaseAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Exception;
use Shetabit\Payment\Facade\Payment;
use SoapFault;
use SuperClosure\Serializer;



class ProductPurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function purchase(Product $product)
    {
        /* چک میکنیم کاربر قبلا اگه پرداخت انجام داده اخطار میدیم*/
        $productexist =PurchasedProduct::where('user_id',Auth::id())->where('product_id',$product->id)->exists();
        if ($productexist){
            $msg = 'شما قبلا این سفارش را پرداخت کرده اید!' ;
            return redirect()->route('productshow',$product->id)->with('warning',$msg);
        }
        try{
            $invoice = new Invoice(); /* ساخت صورت حساب*/
            $invoice->amount(intval($product->totalamount));
            $invoice->detail('detail1', 'Value1');
            $invoice->detail('detail2', 'Value2');
            $user = Auth::user();
            $paymentId = md5(uniqid());

            $transaction =$user->transactions()->create([
                'product_id'=>$product->id,
                'paid' => $invoice->getAmount(),
                'invoice_details' => $invoice,
                'payment_id' => $paymentId,
            ]);

            $callbackUrl = route('purchase.result',[$product->id, 'payment_id'=>$transaction->payment_id]);
            $payment= Payment::callbackUrl($callbackUrl); /* آدرسی که بعد از پرداخت کاربر برمیگرده*/
            $payment->config('description', ' پرداخت هزینه منبع یابی :  ' . $product->title );

            $serializer = new Serializer();

            $pre_payment = function ($driver , $transaction_id) use ($transaction) {
                $transaction->transaction_id = $transaction_id;
                $transaction->save();
            };
//            $serialized = $serializer->serialize($pre_payment);
//            $unserialized = $serializer->unserialize($serialized);


            $payment->purchase($invoice,$pre_payment); /* دسترسی به اطلاعاتی که از درگاه میاد*/
            return $payment->pay()->render();
        }
      catch (PurchaseFailedException $e){
            $transaction->transaction_result = $e;
            $transaction->status = Transaction::STATUS_FAILED;
          $msg= 'صورت حساب با خطا مواجه شد';
            return redirect(route('productshow',$product->id))->with(['warning',$e,$msg]);
        }
        catch (Exception $e){
            $transaction->transaction_result = $e;
            $transaction->status = Transaction::STATUS_FAILED;
            $msg= 'صورت حساب با خطا مواجه شد';
            return redirect(route('productshow',$product->id))->with(['warning',$e,$msg]);
        }
        catch (SoapFault $e){
            $transaction->transaction_result = $e;
            $transaction->status = Transaction::STATUS_FAILED;
            $msg= 'صورت حساب با خطا مواجه شد';
            return redirect(route('productshow',$product->id))->with(['warning',$e,$msg]);
        }


    }
    public function result(Request $request, Product $product)
    {

        if (empty($request->payment_id)){
            $msg1 = 'اطلاعات ناقص است.' ;
            return redirect()->route('productshow',$product->id)->with('warning' ,$msg1);
        }
        $transaction = Transaction::where('payment_id', $request->payment_id)->first();

        if (empty($transaction)){
            $msg2 = 'تراکنش خالی است.' ;
            return redirect()->route('productshow',$product->id)->with('warning',$msg2);
        }
        if($transaction->user_id <> Auth::user()->id){
            $msg3 = 'کاربری که درخواست فرستاده با کاربری که لاگین کرده برابر نیست!' ;
            return redirect()->route('productshow',$product->id)->with('warning' ,$msg3);
        }
        if ($transaction->product_id <> $product->id){
            $msg4 = 'شناسه سفارش با شناسه سفارش پرداختی برابر نیست!' ;
            return redirect()->route('productshow',$product->id)->with('warning' ,$msg4);
        }
        if ($transaction->status <> '1'){
            $msg5 = ' پردازش تراکنش با خطا مواجه شد!' ;
            return redirect()->route('productshow',$product->id)->with('warning' ,$msg5);
        }


        try{
            $receipt = Payment::amount($transaction->paid)
                ->transactionId($transaction->transaction_id)
                ->verify();

            $transaction->transaction_result = $receipt;
            $transaction->status = '2';

            Auth::user()->purchasedproducts()->create([
                'product_id' => $product->id
            ]);

            $product->status = 2;
            $product->update();


            $users = User::whereHas('roles' , function($q){
                $q->where('role_id', '1' );
            })->get();
            Notification::send($users , new ProductPurchaseAdd($product->title));
            $reference_id = $receipt->getReferenceId();
            $transaction->save();
        }
        catch (InvalidPaymentException $e){
            if ($e->getCode() < 0 ){
                $transaction->status = Transaction::STATUS_FAILED;
                $transaction->transaction_result = [
                    'message' =>$e->getMessage(),
                    'code' => $e->getCode(),
                ];
                $transaction->save();
                $errormsg = 'خطایی رخ داده است! پرداخت ناموفق!';
                return redirect(route('productshow',['id' => $product->id,'product' => $product,$errormsg,'code' => $e->getCode()]))->with('warning',$errormsg);
            }
        }
        catch (Exception $exception){
            if ($exception->getCode() < 0 ){
                $transaction->status =  Transaction::STATUS_FAILED;
                $transaction->transaction_result = [
                    'message' =>$exception->getMessage(),
                    'code' => $exception->getCode(),
                ];
                $transaction->save();
                $errormsg = 'خطایی رخ داده است! پرداخت ناموفق!';
                return redirect(route('productshow',['id' => $product->id,'product' => $product,'code' => $exception->getCode()]))->with('warning',$errormsg);
            }
        }
        catch (SoapFault $soapFault){
            if ($soapFault->getCode() < 0 ){
                $transaction->status =  Transaction::STATUS_FAILED;
                $transaction->transaction_result = [
                    'message' =>$soapFault->getMessage(),
                    'code' => $soapFault->getCode(),
                ];
                $transaction->save();
                $errormsg = 'خطایی رخ داده است! پرداخت ناموفق!';
                return redirect(route('productshow',['id' => $product->id,'product' => $product,'code' => $soapFault->getCode()]))->with('warning',$errormsg);
            }
        }
        $msg = 'متشکرم ! پرداخت شما با موفقیت انجام شد. شناسه پیگیری تراکنش : '.$reference_id ;
        return redirect(route('productshow',[$product->id,$reference_id]))->with('success', $msg);
    }



    public function productPurchase()
    {
        $user = Auth::user();
//        $transactions = Auth::user()->transactions;
//        $transactions->transaction_result->getReferenceId();
//        dd($transactions);
        $transactionset = Transaction::where('user_id',$user->id)->first();
        $transactions = Transaction::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(20);
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.productpurchaseresult',compact('user','transactions','transactionset','productcount'));
    }

    public function show(Transaction $transaction)
    {
        $user = Auth::user();
        if ($transaction->transaction_result){
            $receipt = $transaction->transaction_result;
            if ($receipt->getReferenceId()){
                $reference_id = $receipt->getReferenceId();
            }
            elseif(!$receipt->getReferenceId())
                $reference_id = null;
        }else {
            $receipt = null;
            $reference_id = null;
        }
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.productpurchaseshow',compact('transaction','reference_id','receipt','user','productcount'));
    }

    public function index()
    {
        $user =Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.transactions',compact('user','productcount'));
    }
    public function unresult()
    {
        return view('front.dashboard.purchase.unresult');
    }



}
