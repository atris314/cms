<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Finaltranaction;
use App\frontmodels\PurchasedPresent;
use App\frontmodels\PurchasedProduct;
use App\frontmodels\Transaction;
use App\Http\Controllers\Controller;
use App\frontmodels\Product;
use App\frontmodels\Present;
use App\Models\Presentaction;
use App\Models\User;
use App\Notifications\PresentPurchaseAdd;
use App\Notifications\ProductPurchaseAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Exception;
use Shetabit\Payment\Facade\Payment;
use SoapFault;

class PresentPurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function purchase(Present $present)
    {
//        $presentexist =PurchasedPresent::where('user_id',Auth::id())->where('present_id',$present->id)->exists();
//        if ($presentexist){
//            $msg = 'شما قبلا این سفارش را پرداخت کرده اید!' ;
//            return redirect()->route('productshow',$present->id)->with('warning',$msg);
//        }
        if ($present->price == 0)
        {
            $amount = $present->releaseprice;
        }
        elseif($present->releaseprice == '')
        {
            $amount = $present->totalprice;
        }
        else
            $amount = $present->totalprice;
        try{
            $invoice = new Invoice();
            $invoice->amount($amount);
            $invoice->detail('detail1', 'Value1');
            $invoice->detail('detail2', 'Value2');

            $user = Auth::user();
            $paymentId = md5(uniqid());
            $transaction = $user->presentactions()->create([
                'present_id'=>$present->id,
                'paid' => $invoice->getAmount(),
                'invoice_details' => $invoice,
                'payment_id' => $paymentId,
            ]);

            $callbackUrl = route('present.purchase.result',[$present->id, 'payment_id'=>$paymentId]);
            $payment= Payment::callbackUrl($callbackUrl);
            $payment->config('description', ' پرداخت سفارش نهایی  ' . $present->title);

            $payment->purchase($invoice, function ($driver , $transactionId) use ($transaction){
                $transaction->transaction_id = $transactionId;
                $transaction->save();

            });
            return $payment->pay()->render();

        }catch (PurchaseFailedException $e){
            $transaction->transaction_result = $e;
            $transaction->status = Transaction::STATUS_FAILED;
            $msg= 'صورت حساب با خطا مواجه شد';
            return redirect(route('productshow',$present->id))->with(['warning',$e->getCode(),$msg]);
        }
        catch (Exception $e){
            $transaction->transaction_result = $e;
            $transaction->status = Transaction::STATUS_FAILED;
            $msg= 'صورت حساب با خطا مواجه شد';
            return redirect(route('productshow',$present->id))->with(['warning',$e,$msg]);
        }
        catch (SoapFault $e){
            $transaction->transaction_result = $e;
            $transaction->status = Transaction::STATUS_FAILED;
            $msg= 'صورت حساب با خطا مواجه شد';
            return redirect(route('productshow',$present->id))->with(['warning',$e,$msg]);
        }

    }
    public function result(Request $request, Present $present)
    {

        if ($request->missing('payment_id')){
            $msg = 'اطلاعات ناقص است.' ;
            return redirect()->route('productshow',$present->id)->with('warning' ,'failed',$msg);
        }
        $transaction = Presentaction::where('payment_id', $request->payment_id)->first();

        if (empty($transaction)){
            $msg = 'تراکنش خالی است.' ;
            return redirect()->route('productshow',$present->id)->with('warning' ,'failed',$msg);
        }

        if($transaction->user_id <> Auth::id()){
            $msg = 'کاربری که درخواست فرستاده با کاربری که لاگین کرده برابر نیست!' ;
            return redirect()->route('productshow',$present->id)->with('warning' ,'failed',$msg);
        }
        if ($transaction->present_id <> $present->id){
            $msg = 'شناسه سفارش با شناسه سفارش پرداختی برابر نیست!' ;
            return redirect()->route('productshow',$present->id)->with('warning' ,'failed',$msg);
        }
        if ($transaction->status <> '1'){
            $msg = ' تراکنش در حال پردازش نیست!' ;
            return redirect()->route('productshow',$present->id)->with('warning' ,'failed',$msg);
        }

        try{
            $receipt = Payment::amount($transaction->paid)
                ->transactionId($transaction->transaction_id)
                ->verify();

            $transaction->transaction_result = $receipt;
            $transaction->status = '2';
            $transaction->save();

            Auth::user()->purchasedpresents()->create([
                'present_id' => $present->id
            ]);

            if ($present->price == 0)
            {
                $present->status = 5;
            }
            elseif($present->releaseprice == '')
            {
                $present->status = 4;
            }
            else
                $present->status = 1;


            $present->update();

            $product = Product::where('id',$present->product_id)->first();

            if ($present->price == 0)
            {
                $product->status = 9;
            }
            elseif($present->releaseprice == '')
            {
                $product->status = 8;
            }
            else
                $product->status = 2;

            $product->update();


            $transaction = Presentaction::where('present_id',$present->id)->first();
            $reference_id = $receipt->getReferenceId();

            $users = User::whereHas('roles' , function($q){
                $q->where('role_id', '1' );
            })->get();
            Notification::send($users , new PresentPurchaseAdd($present->title));
        }
        catch (InvalidPaymentException $e){
                if ($e->getCode() < 0 ){
                    $transaction->status =  Transaction::STATUS_FAILED;
                    $transaction->transaction_result = [
                        'message' =>$e->getMessage(),
                        'code' => $e->getCode(),
                    ];
                    $transaction->save();
                    $errormsg = 'خطایی رخ داده است! پرداخت ناموفق!';
                    return redirect(route('productshow',['id' => $present->id,'product' => $present,'code' => $e->getCode()]))->with('warning',$errormsg);
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
                    return redirect(route('productshow',['id' => $present->id,'product' => $present,'code' => $exception->getCode()]))->with('warning',$errormsg);
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
                return redirect(route('productshow',['id' => $present->id,'product' => $present,'code' => $soapFault->getCode()]))->with('warning',$errormsg);
            }
        }
        $msg = 'متشکرم ! پرداخت شما با موفقیت انجام شد.' ;
        return redirect(route('productshow',['id' => $product->id,'present' => $present,$transaction,'reference_id' => $receipt->getReferenceId(),'status' => 1]))->with('success',$msg);

    }
    public function presentPurchase()
    {
        $user = Auth::user();
        $presentactionset = Presentaction::where('user_id',$user->id)->first();
        $presentactions = Presentaction::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(20);
        //dd($presentactions);
        return view('front.dashboard.presentpurchaseresult',compact('user','presentactions','presentactionset'));
    }

    public function show(Presentaction $presentaction)
    {
        $user = Auth::user();
        if ($presentaction->transaction_result){
            $receipt = $presentaction->transaction_result;
            if ($receipt->getReferenceId()){
                $reference_id = $receipt->getReferenceId();
            }
            elseif(!$receipt->getReferenceId())
                $reference_id = null;
        }else {
            $receipt = null;
            $reference_id = null;
        }
        return view('front.dashboard.presentpurchaseshow',compact('presentaction','reference_id','receipt','user'));
    }
}
