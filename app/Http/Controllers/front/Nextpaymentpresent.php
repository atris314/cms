<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Nextpayment;
use App\Models\Ordernextpay;
use App\Models\Product;
use App\Models\Transaction;
use App\Repositories\OrderRepositoryInterface;
use Carbon\Carbon;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Nextpaymentpresent extends Controller
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
        $result = $this->curl_post('https://nextpay.org/nx/gateway/token', [
            'order_id'     => $order->id,
            'api_key'      => $request->api_key,
            'amount'       => $amount,
            'callback_uri'     => $callback,
            'customer_phone'        => $request->phone,
            'payer_desc'  => $request->desc,
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'payer_name' => $request->name,
        ]);
        $result = json_decode($result);
//        dd($result);
        if (isset($result)) {
            $createOrder = $this->createOrder($amount, $result->trans_id, 'pay');
//            dd($createOrder);
            if (array_key_exists('error', $createOrder)) {
                $msg = 'خطا در پردازش!';
                return redirect()->back()->with('warning',$msg);
            }
            $nextpayment = new Nextpayment();
            $nextpayment->user_id = auth()->id();
            $nextpayment->product_id = $request->product_id;
            $nextpayment->order_id = $order->id;
            $nextpayment->amount = $amount;
            $nextpayment->token = $result->trans_id;
            $nextpayment->save();
            $go = 'https://nextpay.org/nx/gateway/payment/'.$result->trans_id;
            // $go = "https://idpay.ir/p/ws-sandbox/$payment->token";
//            header("Location: $go");
//            dd(header("Location: $go"));
            return redirect($go);
        } else {
            $msg = 'تراکنش ایجاد نشد';
            return redirect()->back()->with('warning',$msg);
        }
    }

    public function nextpaymentVerify(Request $request)
    {
        $order_id = $request->order_id;
        $token = $request->trans_id;
        $amount = $request->amount;
        $result = json_decode($this->verify($order_id, $token,$amount));/*چک میکند که مقادیر اولیه که تراکنش ایجاد شده بود با مقادیر بانک برابر است یاخیر*/
        if ($result) {
//                $paymentTrackid=$request->payment;
            $nextpayment = Nextpayment::where('token', $request->trans_id)->firstOrFail();
            $nextpayment->status = 1;
            $nextpayment->track_id = $result->Shaparak_Ref_Id;
            $nextpayment->update();

            $ordernextpay = Ordernextpay::findOrFail($nextpayment->order_id);
            $ordernextpay->paystatus = 1;
            $ordernextpay->status = 1;
            $ordernextpay->update();

            $product = Product::findOrFail($nextpayment->product_id);
            if ($ordernextpay->payer_desc=='پرداخت هزینه منبع یابی'){
                $product->status = 2;
                $product->update();
                /*sms and email notification*/
                $user= Auth::user();
                $user->rate +=10;
                $user->update();

                $pack=$product->pack->id;
                if ($pack == 1 ){
                    $user->rate +=40;
                    $user->update();
                }
                elseif ($pack == 2 ){
                    $user->rate +=30;
                    $user->update();
                }
                elseif ($pack == 3 ){
                    $user->rate +=10;
                    $user->update();
                }



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
                if ($ordernextpay->customer_phone){
                    try {
                        $receptor = $ordernextpay->customer_phone;
                        $type = 1;
                        $template = "PaymentSourcing";
                        $param1 = $ordernextpay->payer_name;
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
            elseif($ordernextpay->payer_desc=='پرداخت نهایی'){
                $product->status = 4;
                $product->update();
                /*sms and email notification*/
                $user= Auth::user();
                $user->rate +=10;
                $user->update();

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
                if ($ordernextpay->customer_phone){
                    try {
                        $receptor = $ordernextpay->customer_phone;
                        $type = 1;
                        $template = "PresentPaymentSourcing";
                        $param1 = $ordernextpay->payer_name;
                        $param2 = $product->codepro;
                        $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                        $api->Verify($receptor, $type, $template, $param1,$param2);
                    } catch (\Ghasedak\Exceptions\ApiException $e){
                        echo $e->errorMessage();
                    } catch (\Ghasedak\Exceptions\HttpException $e){
                        echo $e->errorMessage();
                    }
                }
                if ($ordernextpay->customer_phone){
                    try {
                        $receptor = $ordernextpay->customer_phone;
                        $type = 1;
                        $template = "linkSurvey2";
                        $param1 = $ordernextpay->payer_name;
                        $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                        $api->Verify($receptor, $type, $template, $param1);
                    } catch (\Ghasedak\Exceptions\ApiException $e){
                        echo $e->errorMessage();
                    } catch (\Ghasedak\Exceptions\HttpException $e){
                        echo $e->errorMessage();
                    }
                }
            }

            $msg=' پرداخت با موفقیت انجام شد.شماره پیگیری تراکنش'.$nextpayment->track_id;
//                return redirect()->route('paymentResult')->with('success',$msg);
            return redirect(route('productshow',$product->id))->with('success',$msg);

        } else
            $msg = 'متاسفانه پرداخت انجام نشد! .شماره وضعیت' . $request->status;
        return redirect(route('oldproduct'))->with('danger',$msg);

    }

    public function send($api, $amount, $redirect, $mobile = null, $order_id = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'amount'       => $amount,
            'callback'     => $redirect,
            'phone'       => $mobile,
            'order_id'     => $order_id,
            'description'  => $description,
        ]);
    }
    public function curl_post($url, $params)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $params,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function verify($order_id, $token,$amount)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://nextpay.org/nx/gateway/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS => 'api_key=b11ee9c3-d23d-414e-8b6e-f2370baac97b&amount=74250&trans_id=f7c07568-c6d1-4bee-87b1-4a9e5ed2e4c1',
            CURLOPT_POSTFIELDS => 'api_key=c4233bf0-0a40-4bbf-8c56-e547f11130f4&amount='.$amount.'&trans_id='.$token,
        ));

        $response = curl_exec($curl);
        curl_close($curl);
//        dd($response);
        return $response;
//        return $this->curl_post('https://nextpay.org/nx/gateway/verify', [
//            'id'     => $id,/*کلید منحصر بفرد تراکنش که در مرحله ایجاد تراکنش دریافت شده است*/
//            'order_id' => $token, /*شماره سفارش پذیرنده که در مرحله ایجاد تراکنش ارسال شده است*/
//        ]);
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
    public function createOrder( $amount, $trans_id, $gateway_name)
    {

        try {
            DB::beginTransaction();

            $ordernextpay = Ordernextpay::create([
                'user_id' => auth()->id(),
                'amount' => $amount,
            ]);

            Transaction::create([
                'user_id' => auth()->id(),
                'order_id' => $ordernextpay->id,
                'amount' => $amount,
                'token' => $trans_id,
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
        $payments= Nextpayment::where('user_id',$user->id)->where('status',1)->orderBy('created_at','DESC')->paginate(50);
        return view('front.dashboard.paymentlist',compact('payments','user','productcount'));
    }
}
