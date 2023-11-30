<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Coupon;
use App\frontmodels\Product;
use App\Http\Controllers\Controller;
use App\Mail\ChangeCoin;
use App\Models\Change;
use App\Models\Coin;
use App\Models\Confirmation;
use App\Models\Couponpresent;
use Exception;
use Ghasedak\GhasedakApi;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Couponpresent $couponpresent)
    {
        $user=Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $coins = Coin::orderBy('created_at','asc')->get();
        $coin = Coin::where('title',$couponpresent->title)->first();

//            $couponpresent= Couponpresent::where('title',$coin->title)->first();

//        if ($couponpresent){
//            $coupons = $couponpresent->whereHas('coins', function ($q) use ($coin) {
//                $q->where('coin_id', $coin->id);
//            })->get();
//            $couponset = $couponpresent->whereHas('coins', function ($q) use ($coin) {
//                $q->where('coin_id', $coin->id);
//            })->first();
//        }
        $changes = Change::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        $coupons = Couponpresent::whereIn('id',$changes)->get();
        $couponset = Couponpresent::whereIn('id',$changes)->first();


//        for($couponpresent_id=0; $couponpresent_id<count($change); $couponpresent_id++){
//            $coupons = Couponpresent::where('id',$change[$couponpresent_id])->get();
//            $couponset = Couponpresent::where('id',$change[$couponpresent_id])->first();
//        }
        $confirmations = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->get();
        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();
        return view('front.dashboard.yabanecoin',compact('user','productcount','coins','couponpresent','coupons','couponset','changes','confirmationset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function edit(Coin $coin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coin $coin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin $coin)
    {
        //
    }

    public function change(Coin $coin)
    {
        $user = Auth::user();
        $rate = $user->rate;
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $coins = Coin::orderBy('created_at','asc')->get();
        $cointitle = $coin->title;

        $rand = 'off'.rand(1000,90000);
        $srt = str_shuffle($user->username);
        $code = $rand.$srt;

//        if ($coin->title == '100 یابانه کوین')
//        {
//            $couponpresent->price =1000000; /*ریال*/
//            $couponpresent->title = $user->username.'-'.$coin->title;
//            $couponpresent->code = $code;
//            $couponpresent->status = 1;
//            $couponpresent->save();
//        }
//        elseif ($coin->title == '200 یابانه کوین')
//        {
//            $couponpresent->price =1500000; /*ریال*/
//            $couponpresent->title = $user->username.'-'.$coin->title;
//            $couponpresent->code = $code;
//            $couponpresent->status = 1;
//            $couponpresent->save();
//        }
//        elseif ($coin->title == '500 یابانه کوین')
//        {
//            $couponpresent->price =2000000; /*ریال*/
//            $couponpresent->title = $user->username.'-'.$coin->title;
//            $couponpresent->code = $code;
//            $couponpresent->status = 1;
//            $couponpresent->save();
//        }

        if ($coin->id == 1){
            if ($rate>=100){
                $couponpresent = new Couponpresent();
                $couponpresent->price =1000000; /*ریال*/
                $couponpresent->title = $user->username.'-'.$coin->title;
                $couponpresent->code = $code;
                $couponpresent->status = 1;
                $couponpresent->save();
                if ($user->email){
//                    Mail::to($user->email)
//                        ->send(new ChangeCoin($couponpresent,$user));
                    $code =$couponpresent->code;
                    if ($user->mobile){
                        try{
                            $receptor = $user->mobile;
                            $type = 1;
                            $template = "changeCoin";
                            $param1 = $code;
                            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                            $api->Verify($receptor, $type, $template, $param1);
                        }
                        catch(\Ghasedak\Exceptions\ApiException $e){
                            echo $e->errorMessage();
                        }
                        catch(\Ghasedak\Exceptions\HttpException $e){
                            echo $e->errorMessage();
                        }
                    }
                }
                $user->rate -= 100;
                $user->update();
                $change =new Change();
                $change->user_id = Auth::user()->id;
                $change->coin_id = $coin->id;
                $change->couponpresent_id = $couponpresent->id;
                $change->save();
                $msg = 'یابانه کوین با موفقیت به کد تخفیف یک بار مصرف تبدیل شد. کدتخفیف به ایمیل شما ارسال شد در صورتی که ایمیل مربوطه را در اینباکس مشاهده نکردید فولدر اسپم را چک کنید.' ;
                return redirect()->route('yabaneCoin',compact('couponpresent','user','productcount','coins'))->with('success',$msg);
            }
            elseif($rate<=100){
                $msg = 'کاربر گرامی یابانه کوین شما کمتر از حد نساب می باشد!';
                return redirect(route('yabaneCoin',$coin->id))->with('warning', $msg);
            }
        }
        elseif ($coin->id == 2) {
            if ($rate >= 200) {
                $couponpresent = new Couponpresent();
                $couponpresent->price =1500000; /*ریال*/
                $couponpresent->title = $user->username.'-'.$coin->title;
                $couponpresent->code = $code;
                $couponpresent->status = 1;
                $couponpresent->save();
                if ($user->email) {
//                    Mail::to($user->email)
//                        ->send(new ChangeCoin($couponpresent, $user));
                    $code = $couponpresent->code;
                    if ($user->mobile) {
                        try {
                            $receptor = $user->mobile;
                            $type = 1;
                            $template = "changeCoin";
                            $param1 = $code;
                            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                            $api->Verify($receptor, $type, $template, $param1);
                        } catch (\Ghasedak\Exceptions\ApiException $e) {
                            echo $e->errorMessage();
                        } catch (\Ghasedak\Exceptions\HttpException $e) {
                            echo $e->errorMessage();
                        }
                    }
                }
                $user->rate -= 200;
                $user->update();

                $change = new Change();
                $change->user_id = Auth::user()->id;
                $change->coin_id = $coin->id;
                $change->couponpresent_id = $couponpresent->id;
                $change->save();
                $msg = 'یابانه کوین با موفقیت به کد تخفیف یک بار مصرف تبدیل شد. کدتخفیف به ایمیل شما ارسال شد در صورتی که ایمیل مربوطه را در اینباکس مشاهده نکردید فولدر اسپم را چک کنید.';
                return redirect()->route('yabaneCoin', compact('couponpresent', 'user', 'productcount', 'coins'))->with('success', $msg);
            } elseif ($rate <= 200) {
                $msg = 'کاربر گرامی یابانه کوین شما کمتر از حد نساب انتخابی شما می باشد!';
                return redirect(route('yabaneCoin', $coin->id))->with('warning', $msg);
            }
        }
        elseif ($coin->id == 3) {
            if ($rate >= 500) {
                $couponpresent = new Couponpresent();
                $couponpresent->price =2000000; /*ریال*/
                $couponpresent->title = $user->username.'-'.$coin->title;
                $couponpresent->code = $code;
                $couponpresent->status = 1;
                $couponpresent->save();
                if ($user->email) {
//                    Mail::to($user->email)
//                        ->send(new ChangeCoin($couponpresent, $user));

                    $code = $couponpresent->code;
                    if ($user->mobile) {
                        try {
                            $receptor = $user->mobile;
                            $type = 1;
                            $template = "changeCoin";
                            $param1 = $code;
                            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                            $api->Verify($receptor, $type, $template, $param1);
                        } catch (\Ghasedak\Exceptions\ApiException $e) {
                            echo $e->errorMessage();
                        } catch (\Ghasedak\Exceptions\HttpException $e) {
                            echo $e->errorMessage();
                        }
                    }
                }
                $user->rate -= 500;
                $user->update();

                $change = new Change();
                $change->user_id = Auth::user()->id;
                $change->coin_id = $coin->id;
                $change->couponpresent_id = $couponpresent->id;
                $change->save();
                $msg = 'یابانه کوین با موفقیت به کد تخفیف یک بار مصرف تبدیل شد. کدتخفیف به ایمیل شما ارسال شد در صورتی که ایمیل مربوطه را در اینباکس مشاهده نکردید فولدر اسپم را چک کنید.';
                return redirect()->route('yabaneCoin', compact('couponpresent', 'user', 'productcount', 'coins'))->with('success', $msg);
            } elseif ($rate <= 500) {
                $msg = 'کاربر گرامی یابانه کوین شما کمتر از حد نساب انتخابی شما می باشد!';
                return redirect(route('yabaneCoin', $coin->id))->with('warning', $msg);
            }
        }

    }
}
