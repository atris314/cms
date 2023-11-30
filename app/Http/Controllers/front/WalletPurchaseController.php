<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Walletaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use SoapFault;

class WalletPurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        $users= Auth::user();
//        dd($request);
        try{
//            dd($request->wallet_amount);
            $invoice = new Invoice();
            $invoice->amount(intval($request->wallet_amount));
            $invoice->detail('detail1', 'Value1');
            $invoice->detail('detail2', 'Value2');
            //dd($invoice);

            $user = Auth::user();
            $paymentId = md5(uniqid());

            $transaction =$user->walletactions()->create([
                'paid' => $invoice->getAmount(),
                'invoice_details' => $invoice,
                'payment_id' => $paymentId,
            ]);

            $callbackUrl = route('wallet.purchase.result',[$user->id,'payment_id'=>$paymentId]);
            $payment= Payment::callbackUrl($callbackUrl);
            $payment->config('description', ' افزایش موجودی کیف پول ');

            $payment->purchase($invoice, function ($driver , $transactionId) use ($transaction){
                $transaction->transaction_id = $transactionId;
                $transaction->save();

            });
//            dd($transaction);
            return $payment->pay()->render();

        }catch (PurchaseFailedException $e){
            $transaction->transaction_result = $e;
            $transaction->status = Transaction::STATUS_FAILED;
            $transaction->save();
            return redirect(route('front.wallet'))->with(['warning',$e->getCode()]);
        }
    }
    public function result(Request $request, User $user)
    {

        if ($request->missing('payment_id')){
            $msg = 'اطلاعات ناقص است.' ;
            return view('front.dashboard.purchase.walletresult')->with('warning' ,$msg);
        }

        $transaction = Walletaction::where('payment_id', $request->payment_id)->first();

        if (empty($transaction)){
            $msg = 'تراکنش خالی است.' ;
            return view('front.dashboard.purchase.walletresult')->with('warning',$msg);
        }

        if($transaction->user_id <> Auth::id()){
            $msg = 'کاربری که درخواست فرستاده با کاربری که لاگین کرده برابر نیست!' ;
            return view('front.dashboard.purchase.walletresult')->with('warning' ,$msg);
        }

        if ($transaction->status <> '1'){
            $msg = ' تراکنش در حال پردازش نیست!' ;
            return view('front.dashboard.purchase.walletresult')->with('warning' ,$msg);
        }

        try{
            $receipt = Payment::amount($transaction->paid)
                ->transactionId($transaction->transaction_id)
                ->verify();

            $transaction->transaction_result = $receipt;
            $transaction->status = '2';
            $transaction->save();

            Auth::user()->purchasedwallets()->create([
                'user_id' => $user->id
            ]);

            $user->wallet_amount += $transaction->paid;
            $user->update();

            $transaction = Transaction::where('user_id',$user->id)->first();
            $reference_id = $receipt->getReferenceId();


            $msg = 'متشکرم ! کیف پول شما شارژ شد.' ;
            return view('front.dashboard.purchase.walletresult',compact('transaction','reference_id','user'))->with([
                'success',
                $msg,
                'status' => 1,
                'reference_id' => $receipt->getReferenceId(),
                'user' => $user
            ]);

        }catch (InvalidPaymentException $e){
            if ($e->getCode() < 0){
                $transaction->status = '0';
                $transaction->transaction_result = [
                    'message' =>$e->getMessage(),
                    'code' => $e->getCode(),
                ];
                $transaction->save();
                return view('front.dashboard.purchase.unwalletresult')->with([
                    'warning',
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'user' => $user
                ]);
            }
        }
        catch (Exception $exception){
            $msg = 'تراکنش ناموفق' ;
            return view('front.dashboard.purchase.unwalletresult')->with(['warning',$exception->getCode(),$msg,'user' => $user]);
        }
        catch (SoapFault $soapFault){
            $msg = 'تراکنش ناموفق' ;
            return view('front.dashboard.purchase.unwalletresult')->with(['warning',$soapFault->getCode(),$msg,'user' => $user]);
        }
    }
}
