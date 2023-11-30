<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\linkSurvey;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use App\Repositories\OrderRepositoryInterface;
use App\Transformers\FailedPaymentView;
use App\Transformers\PaymentView;
use App\Transformers\VerifyTransformer;
use Carbon\Carbon;
use Ghasedak\GhasedakApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Support\Facades\Http;
use Throwable;

class PaymentController extends Controller
{
    protected $model;
    public $msg;
    /**
     * @var OrderRepositoryInterface
     */
    public function __construct(OrderRepositoryInterface $model)
    {
        $this->model = $model;
        $this->middleware('auth');
    }

    public function payment(Request $request)
    {

        $order = $this->model->create($request->toArray());
        $api = $request->api_key;
        $amount = $request->amount;
        $callback = $request->callback;
//        $result = $this->send($api, $amount, $redirect);
        $result = $this->curl_post('https://api.idpay.ir/v1.1/payment', [
            'order_id'     => $order->id,
            'API_KEY'      => $request->api_key,
            'amount'       => $amount,
            'callback'     => $callback,
            'customer_phone'        => $request->phone,
            'description'  => $request->desc,
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'mail' => $request->email,
        ]);
        $result = json_decode($result);
//        dd($result);
        if (isset($result)) {
            $createOrder = $this->createOrder($amount, $result->id, 'pay');
            if (array_key_exists('error', $createOrder)) {
                $msg = 'خطا در پردازش!';
                return redirect()->back()->with('warning',$msg);
            }
            $payment = new Payment();
            $payment->user_id = auth()->id();
            $payment->product_id = $request->product_id;
            $payment->order_id = $order->id;
            $payment->amount = $amount;
            $payment->token = $result->id;
            $payment->save();
            $go = $result->link;
            // $go = "https://idpay.ir/p/ws-sandbox/$payment->token";
            header("Location: $go");
//            dd($result);
        } else {
            $msg = 'تراکنش ایجاد نشد';
            return redirect()->back()->with('warning',$msg);
        }
    }
    public function paymentVerify(Request $request)
    {

        $id = $request->id;
        $token = $request->order_id;
        $result = json_decode($this->verify($id, $token));/*چک میکند که مقادیر اولیه که تراکنش ایجاد شده بود با مقادیر بانک برابر است یاخیر*/

        if (isset($result->status)) {
            if ($result->status == 100) {
                $paymentTrackid=$result->payment;
                $payment = Payment::where('token', $result->id)->firstOrFail();
                $payment->status = 1;
                $payment->track_id = $paymentTrackid->track_id;
                $payment->update();

                $order = Order::findOrFail($payment->order_id);
                $order->paystatus = 1;
                $order->status = 1;
                $order->update();

                $product = Product::findOrFail($payment->product_id);
                if ($order->desc=='پرداخت هزینه منبع یابی'){
                    $product->status = 2;
                    $product->update();
                    /*sms and email notification*/
                    $user= Auth::user();

                    if ($users = \App\Models\User::whereHas('roles' , function($q){
                        $q->where('role_id', '1' );
                    })->get());
                    for($i=0; $i<count($users); $i++){
                        $admin = $users[$i];
                        if ($admin->mobile){
                            try {
                                $receptor = $admin->mobile;
                                $type = 1;
                                $template = "adminPaymentSourcing";
                                $param1 = $admin->username;
                                $param2 = $product->codepro;
                                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                                $api->Verify($receptor, $type, $template, $param1,$param2);
                            } catch (\Ghasedak\Exceptions\ApiException $e){
                                echo $e->errorMessage();
                            } catch (\Ghasedak\Exceptions\HttpException $e){
                                echo $e->errorMessage();
                            }
                        }
                    }
                    if ($order->phone){
                        try {
                            $receptor = $order->phone;
                            $type = 1;
                            $template = "PaymentSourcing";
                            $param1 = $order->name;
                            $param2 = $product->codepro;
                            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                            $api->Verify($receptor, $type, $template, $param1,$param2);
                        } catch (\Ghasedak\Exceptions\ApiException $e){
                            echo $e->errorMessage();
                        } catch (\Ghasedak\Exceptions\HttpException $e){
                            echo $e->errorMessage();
                        }
                    }
                }
                elseif($order->desc=='پرداخت نهایی'){
                    $product->status = 4;
                    $product->update();

                    /*sms and email notification*/
                    $user= Auth::user();
                    if ($users = \App\Models\User::whereHas('roles' , function($q){
                        $q->where('role_id', '1' );
                    })->get());
                    for($i=0; $i<count($users); $i++){
                        $admin = $users[$i];
                        if ($admin->mobile){
                            try {
                                $receptor = $admin->mobile;
                                $type = 1;
                                $template = "adminPresentPaymentSourcing";
                                $param1 = $admin->username;
                                $param2 = $product->codepro;
                                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                                $api->Verify($receptor, $type, $template, $param1,$param2);
                            } catch (\Ghasedak\Exceptions\ApiException $e){
                                echo $e->errorMessage();
                            } catch (\Ghasedak\Exceptions\HttpException $e){
                                echo $e->errorMessage();
                            }
                        }
                    }
                    if ($order->phone){
                        try {
                            $receptor = $order->phone;
                            $type = 1;
                            $template = "PresentPaymentSourcing";
                            $param1 = $order->name;
                            $param2 = $product->codepro;
                            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                            $api->Verify($receptor, $type, $template, $param1,$param2);
                        } catch (\Ghasedak\Exceptions\ApiException $e){
                            echo $e->errorMessage();
                        } catch (\Ghasedak\Exceptions\HttpException $e){
                            echo $e->errorMessage();
                        }
                    }
                    if ($order->phone){
                        try {
                            $receptor = $order->phone;
                            $type = 1;
                            $template = "linkSurvey2";
                            $param1 = $order->name;
                            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                            $api->Verify($receptor, $type, $template, $param1);
                        } catch (\Ghasedak\Exceptions\ApiException $e){
                            echo $e->errorMessage();
                        } catch (\Ghasedak\Exceptions\HttpException $e){
                            echo $e->errorMessage();
                        }
                    }
                }

                $msg=' پرداخت با موفقیت انجام شد.شماره تراکنش'.$payment->track_id;
//                return redirect()->route('paymentResult')->with('success',$msg);
                return redirect(route('productshow',$product->id))->with('success',$msg);

            }
            else {
                $msg = 'پرداخت با خطا مواجه شد.شماره وضعیت'.$result->status;
                return redirect(route('oldproduct'))->with('danger',$msg);
            }
        } elseif ($request->status == 0)
                $msg = 'متاسفانه پرداخت انجام نشد! .شماره وضعیت' . $request->status;
                return redirect(route('oldproduct'))->with('danger',$msg);

    }

    public function send($api, $amount, $redirect, $mobile = null, $order_id = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'amount'       => $amount,
            'callback'     => $redirect,
            'customer_phone'       => $mobile,
            'order_id'     => $order_id,
            'description'  => $description,
        ]);
    }
    public function curl_post($url, $params)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-API-KEY: 0840e958-4117-46c3-8806-5ab3b72abb26',
            'X-SANDBOX: 1'
        ]);

        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    public function verify($id, $token)
    {
        return $this->curl_post('https://api.idpay.ir/v1.1/payment/verify', [
            'id'     => $id,/*کلید منحصر بفرد تراکنش که در مرحله ایجاد تراکنش دریافت شده است*/
            'order_id' => $token, /*شماره سفارش پذیرنده که در مرحله ایجاد تراکنش ارسال شده است*/
        ]);
    }

    function generateFileName($name)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $hour = Carbon::now()->hour;
        $minute = Carbon::now()->minute;
        $second = Carbon::now()->second;
        $microsecond = Carbon::now()->microsecond;
        return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' .$name;
    }

    public function result()
    {
        $user =Auth::user();
//        return $this->curl_post('https://api.idpay.ir/v1.1/payment/inquiry', [
//            'id'     => $id,/*کلید منحصر بفرد تراکنش که در مرحله ایجاد تراکنش دریافت شده است*/
//            'order_id' => $order_id, /*شماره سفارش پذیرنده که در مرحله ایجاد تراکنش ارسال شده است*/
//        ]);
        return view('front.dashboard.purchase.result',compact('user'));
    }
    public function createOrder( $amount, $token, $gateway_name)
    {

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'amount' => $amount,
            ]);

            Transaction::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'amount' => $amount,
                'token' => $token,
                'gateway_name' => $gateway_name
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['error' => $ex->getMessage()];
        }

        return ['success' => 'success!'];
    }

    public function paymentList()
    {
        $user = Auth::user();
        $productcount = \App\frontmodels\Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $payments= Payment::where('user_id',$user->id)->where('status',1)->orderBy('created_at','DESC')->paginate(50);
        return view('front.dashboard.paymentlist',compact('payments','user','productcount'));
    }
}
