<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\Cancelpro;
use App\Mail\linkSurvey;
use App\Mail\ProductSentUser;
use App\Models\Admin;
use App\Models\Catorder;
use App\Models\Confirmation;
use App\Models\Couponpresent;
use App\Models\Currency;
use App\Models\Orderpresent;
use App\Models\Pack;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Present;
use App\Models\Product;
use App\Models\Protranslate;
use App\Models\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PresentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $presents = Present::where('user_id',$user->id)
            ->where('status' , '!=' , '2')
            ->orderBy('created_at','DESC')
            ->paginate(20);
        //dd($presents);
        $presentset = Present::where('user_id',$user->id)->first();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.presents',compact('presents','user','presentset','productcount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $products = Product::all()->pluck('codepro','id');
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('back.presents.create',compact('products','productcount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'deliverytime.required' => ' لطفا زمان تحویل سفارش را وارد نمایید',
            'description.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'price.required' => ' لطفا فیلد مبلغ قابل پرداخت را وارد نمایید',
            'photo_id.required' => ' لطفا تصویر سفارش را وارد نماييد',
        ];
        $validateData = $request->validate([
            'deliverytime' => 'required',
            'description' => 'required',
            'price' => 'required',
            'photo_id' => 'required',
        ],$messages);
        $develope = Admin::first();
        $present = new Present();
        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $present->photo_id = $photo->id;
        }
        $value = $request->input('productcode');
        $product = Product::where('id',$value)->first();
        $productcode = $product->codepro;
        $user = User::where('id',$product->user_id)->first();
        $protranslate= Protranslate::where('product_id',$product->id)->first();

        $present->deliverytime = $request->input('deliverytime');
        $present->price = $request->input('price');
        $present->description = $request->input('description');
        $present->product_id = $request->input('productcode');
        $present->productcode=$productcode;
        $present->user_id= $user->id;
        $product->status = '3';
        $product->save();
        //dd($product);
        Mail::to(['yabane.managment.@gmail.com',$user->email])
            ->send(new ProductSentUser($protranslate , $user, $product , $photo,$request));
        try{
            $present->save();
        }catch (Exception $exception){
            return redirect(route('back.presents.create'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم! اطلاعات فرم با موفقیت ارسال شد' ;
        return redirect(route('back.presents'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function show(Present $present)
    {
        $user = Auth::user();
        $product = Product::where('id',$present->product_id)->first();
        $protranslate = Protranslate::where('product_id',$product->id)->first();
        $packprice = $product->pack->price;
        $price =$present->price;
        $releaseprice = $present->releaseprice;
        $totalprice = ($price+$releaseprice)-$packprice;
        if ($price == 0 ){
            $totalprice = $present->releaseprice;
        }
        $deliverytime =explode(' ', $present->deliverytime);
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.presentshow',compact('present','user','product','protranslate','releaseprice','totalprice','packprice','productcount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function edit(Present $present)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Present $present)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function destroy(Present $present)
    {
        try{
            $protranslate = Protranslate::where('product_id',$present->product_id)->first();
            //dd($protranslate);
            $present->delete();
            $protranslate->delete();

        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'کاربر گرامی شما از تکمیل و پرداخت سفارش انصراف دادین' ;
        return redirect(route('present'))->with('success',$msg);
    }

    public function status(Present $present)
    {
        $product = Product::where('id',$present->product_id)->first();
        $protranslate = Protranslate::where('product_id',$product->id)->first();

        $present->status = '2';
        $product->status = '13';
        $protranslate->status = '1';

        $develope = Admin::first();
        $user = Auth::user();

        Mail::to(['yabane.managment.@gmail.com',$user->email])
            ->send(new Cancelpro($present , $user, $product));

        try{
            $present->save();
            $product->save();
            $protranslate->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'کاربر گرامی! شما از ادامه فرایند خرید این سفارش انصراف دادید' ;
        return redirect()->back()->with('success',$msg);

    }

    public function select(Present $present)
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
//        dd($present);
        $orderpresent = Orderpresent::where('present_id',$present->id)->orderBy('created_at','DESC')->first();

        $product = Product::where('id',$present->product_id)->first();
        $confirmationset = Confirmation::where('confirm',null)->where('user_id',$user->id)->where('product_id',$product->id)->first();
//        dd($confirmationset);
        return view('front.dashboard.factor',compact('user','present','productcount','orderpresent','confirmationset'));
    }
    public function addCouponPresent(Request $request,Present $present)
    {
        if ($request->code){
            $user = Auth::user();
            $users = User::where('id', $user->id)->first();
            $couponpresent = Couponpresent::where('code', $request->code)->where('status', 1)->first();

//            dd($couponpresent);
            if ($couponpresent != null){
                if(isset($couponpresent->expiry_date)){
                    $expitytime = $couponpresent->expiry_date;
//                dd($expitytime);
                    $createTime= Carbon::parse(today());
                    $today = $expitytime <= $createTime;
                    if ($today==true){
                        $msg = 'کد تخفیف منقضی شده است';
                        return back()->with('warning', $msg);
                    }
                }

                else {
                    $check = $users->whereHas('couponpresents', function ($q) use ($couponpresent, $users) {
                        $q->where('couponpresent_id', $couponpresent->id)
                            ->where('user_id', $users->id);
                    })->exists();
                    if (!$check) {
                        $couponpresent = Couponpresent::where('code', $request->code)->where('status', 1)->first();
                        $descontamount = $couponpresent->price;
                        $present->discountamount = $descontamount;
                        $present->update();
                        $user = Auth::user();
                        $user->couponpresents()->attach($couponpresent);
                        $user->save();
                        $couponpresent->status = 0;
                        $couponpresent->update();
                        $msg = 'کد تخفیف اعمال شد';
                        return back()->with('success', $msg);
                    } else {
                        $msg = 'شما قبلا از این کد تخفیف استفاده کرده اید';
                        return back()->with('warning', $msg);
                    }
                }
            }
            elseif ($couponpresent == null) {
                $msg = 'اعتبار استفاده از این کد تخفیف به پایان رسیده است.';
                return redirect()->back()->with('warning', $msg);
            }


        }
    }

    public function quickSelect(Request $request,Present $present)
    {
        if (!isset($present->confirm)){
            $messages = [
                'confirm.required' => 'لطفا تیک تایید "اطلاعات ثبت شده توسط من با سفارش منبع یابی شده مطابقت دارد" را فعال کنید',
            ];
            $validateData = $request->validate([
                'confirm' => 'required',
            ],$messages);
        }

//        $url = "https://api.accessban.com/v1/widget/tmp?keys=775219";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
//        $resultdollarkh = curl_exec($ch);
//        curl_close($ch);
//        $arraya = json_decode($resultdollarkh,true);
//        if ($arraya)
//        {
//            $dollarkh = $arraya['response']['indicators'][0]['p'];
//        }
//        else
//            $dollarkh = '';

//        $url = "https://api.accessban.com/v1/widget/tmp?keys=775220";
        $url = "https://api.tgju.org/v1/widget/tmp?keys=523874";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        $resultdollarf = curl_exec($ch);
        curl_close($ch);
        $arrayb = json_decode($resultdollarf,true);
        if ($arrayb) {
            $dollarf = $arrayb['response']['indicators'][0]['p'];
        }
        else
            $dollarf = '';

//        $url = "https://api.accessban.com/v1/widget/tmp?keys=775217";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
//        $resultyorokh = curl_exec($ch);
//        curl_close($ch);
//        $arrayc = json_decode($resultyorokh,true);
//        if ($arrayc) {
//            $yorokh = $arrayc['response']['indicators'][0]['p'];
//        }
//        else
//            $yorokh = '';

//        $url = "https://api.accessban.com/v1/widget/tmp?keys=775218";
        $url = "https://api.tgju.org/v1/widget/tmp?keys=523876";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        $resultyorof = curl_exec($ch);
        curl_close($ch);
        $arrayd = json_decode($resultyorof,true);
        if ($arrayd) {
            $yorof = $arrayd['response']['indicators'][0]['p'];
        }
        else
            $yorof = '';

//        $url = "https://api.accessban.com/v1/widget/tmp?keys=137222";
        $url = "https://api.tgju.org/v1/widget/tmp?keys=137222";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        $resultyoan = curl_exec($ch);
        curl_close($ch);
        $arraye = json_decode($resultyoan,true);
        if ($arraye) {
            $yoan = $arraye['response']['indicators'][0]['p'];
        }
        else
            $yoan = '';

        $urls=['https://api.tgju.org/v1/widget/tmp?keys=523874','https://api.tgju.org/v1/widget/tmp?keys=523876','https://api.tgju.org/v1/widget/tmp?keys=137222'];
        if(isset($urls)){
            $currency = new Currency();
//        $currency->dollarkh = $dollarkh;
            $currency->dollarf = $dollarf;
            $currency->yorof = $yorof;
//        $currency->yorokh = $yorokh;
            $currency->yoan = $yoan;
            $currency->save();
        }
        else
            $currency = Currency::orderBY('created_at','desc')->first();

        $present->select = $request->select;
        $present->confirm = $request->confirm;
        $present->update();

        $price = $present->price;
        $packprice =($present->product->amount)*10;
        $quickprice = $present->quickprice;
        $releaseprice = $present->releaseprice;

        /*ترخیص فوری*/
        if ($request->select == 0){
            if ($present->currency==3){ /* واحد پول یوان چین*/
                if ($currency->yoan){
                    $price = $present->price*$currency->yoan; /* خرید کالا*/
                    $quickprice = $present->quickprice*$currency->yoan;/*  ترخیص فوری*/
                    $product = Product::where('id',$present->product_id)->first();
                    $productdiscount =$product->totalamount*10;

                    if (isset($product->discountamount)){
                        $pretotalprice =($price+$quickprice)-$productdiscount;
                        if($present->discountamount<=100){
                            $dis = $present->discountamount/100;
                            $distotal = $pretotalprice*$dis;
                            $totalprice = $pretotalprice-$distotal;
                        }
                        else{
                            $totalprice = $pretotalprice-$present->discountamount;
                        }
                    }

                    else{
                        $pretotalprice = ($price+$quickprice)-$packprice;
                        if($present->discountamount<=100){
                            $dis = $present->discountamount/100;
                            $distotal = $pretotalprice*$dis;
                            $totalprice = $pretotalprice-$distotal;
                        }
                        else{
                            $totalprice = $pretotalprice-$present->discountamount;
                        }
                    }

                    $orderpresent = new Orderpresent();
                    $orderpresent->user_id =Auth::user()->id;
                    $orderpresent->present_id =$present->id;
                    $orderpresent->price = $price;
                    $orderpresent->quickprice = $quickprice;
                    $orderpresent->totalprice = $totalprice;
                    $orderpresent->save();
                }
            }

            if ($present->currency==1){ /* واحد پول دلار آمریکا*/
                if ($currency->dollarf){
                    $price = $present->price*$currency->dollarf; /* خرید کالا*/
                    $quickprice = $present->quickprice*$currency->dollarf;/*  ترخیص فوری*/
                    $product = Product::where('id',$present->product_id)->first();
                    $productdiscount =$product->totalamount*10;
                    if (isset($product->discountamount)){
                        $pretotalprice =($price+$quickprice)-$productdiscount;
                        if($present->discountamount<=100){
                            $dis = $present->discountamount/100;
                            $distotal = $pretotalprice*$dis;
                            $totalprice = $pretotalprice-$distotal;
                        }
                        else{
                            $totalprice = $pretotalprice-$present->discountamount;
                        }
                    }
                    else{
                        $pretotalprice =($price+$quickprice)-$packprice;
                        if($present->discountamount<=100){
                            $dis = $present->discountamount/100;
                            $distotal = $pretotalprice*$dis;
                            $totalprice = $pretotalprice-$distotal;
                        }
                        else{
                            $totalprice = $pretotalprice-$present->discountamount;
                        }
                    }
                    $orderpresent = new Orderpresent();
                    $orderpresent->user_id =Auth::user()->id;
                    $orderpresent->present_id =$present->id;
                    $orderpresent->price = $price;
                    $orderpresent->quickprice = $quickprice;
                    $orderpresent->totalprice = $totalprice;
                    $orderpresent->save();
                }
            }

            if ($present->currency==2){ /*واحد پول یورو*/
                if ($currency->yorof){
                    $price = $present->price*$currency->yorof; /*خرید کالا*/
                    $quickprice = $present->quickprice*$currency->yorof;/*ترخیص فوری*/
                    $product = Product::where('id',$present->product_id)->first();
                    $productdiscount =$product->totalamount*10;
                    if (isset($product->discountamount)){
                        $pretotalprice =($price+$quickprice)-$productdiscount;
                        if($present->discountamount<=100){
                            $dis = $present->discountamount/100;
                            $distotal = $pretotalprice*$dis;
                            $totalprice = $pretotalprice-$distotal;
                        }
                        else{
                            $totalprice = $pretotalprice-$present->discountamount;
                        }
                    }
                    else{
                        $pretotalprice =($price+$quickprice)-$packprice;
                        if($present->discountamount<=100){
                            $dis = $present->discountamount/100;
                            $distotal = $pretotalprice*$dis;
                            $totalprice = $pretotalprice-$distotal;
                        }
                        else{
                            $totalprice = $pretotalprice-$present->discountamount;
                        }
                    }
                    $orderpresent = new Orderpresent();
                    $orderpresent->user_id = Auth::user()->id;
                    $orderpresent->present_id = $present->id;
                    $orderpresent->price = $price;
                    $orderpresent->quickprice = $quickprice;
                    $orderpresent->totalprice = $totalprice;
                    $orderpresent->save();
                }
            }
            if ($present->currency==0){ /* واحد پول ریال*/
                    $price = $present->price; /* خرید کالا*/
                    $quickprice = $present->quickprice;/*  ترخیص فوری*/
                $product = Product::where('id',$present->product_id)->first();
                $productdiscount =$product->totalamount*10;

                if (isset($product->discountamount)){
                    $pretotalprice =($price+$quickprice)-$productdiscount;
                    if($present->discountamount<=100){
                        $dis = $present->discountamount/100;
                        $distotal = $pretotalprice*$dis;
                        $totalprice = $pretotalprice-$distotal;
                    }
                    else{
                        $totalprice = $pretotalprice-$present->discountamount;
                    }
                }
                else{
                    $pretotalprice =($price+$quickprice)-$packprice;
                    if($present->discountamount<=100){
                        $dis = $present->discountamount/100;
                        $distotal = $pretotalprice*$dis;
                        $totalprice = $pretotalprice-$distotal;
                    }
                    else{
                        $totalprice = $pretotalprice-$present->discountamount;
                    }
                }
                    $orderpresent = new Orderpresent();
                    $orderpresent->user_id =Auth::user()->id;
                    $orderpresent->present_id =$present->id;
                    $orderpresent->price = $price;
                    $orderpresent->quickprice = $quickprice;
                    $orderpresent->totalprice = $totalprice;
                    $orderpresent->save();
            }
        }
        /*ترخیص عادی- غیرفوری*/
        if ($request->select == 1){
            if ($present->currency==3){ /* واحد پول یوان چین*/
                if ($currency->yoan){
                    $price = $present->price*$currency->yoan; /* خرید کالا*/
                    $releaseprice = $present->releaseprice*$currency->yoan;/*ترخیص عادی*/

                    $product = Product::where('id',$present->product_id)->first();
                    $productdiscount =$product->totalamount*10;

                    if (isset($product->discountamount)){
                        $pretotalprice =($price+$quickprice)-$productdiscount;
                        if($present->discountamount<=100){
                            $dis = $present->discountamount/100;
                            $distotal = $pretotalprice*$dis;
                            $totalprice = $pretotalprice-$distotal;
                        }
                        else{
                            $totalprice = $pretotalprice-$present->discountamount;
                        }
                    }
                    else{
                        $pretotalprice =($price+$quickprice)-$packprice;
                        if($present->discountamount<=100){
                            $dis = $present->discountamount/100;
                            $distotal = $pretotalprice*$dis;
                            $totalprice = $pretotalprice-$distotal;
                        }
                        else{
                            $totalprice = $pretotalprice-$present->discountamount;
                        }
                    }

                    $orderpresent = new Orderpresent();
                    $orderpresent->user_id =Auth::user()->id;
                    $orderpresent->present_id =$present->id;
                    $orderpresent->price = $price;
                    $orderpresent->releaseprice = $releaseprice;
                    $orderpresent->totalprice = $totalprice;
                    $orderpresent->save();
//                  dd($orderpresent);
                }
            }
            if ($present->currency==1){ /* واحد پول دلار آمریکا*/
                if ($currency->dollarf){
                    $price = $present->price*$currency->dollarf; /* خرید کالا*/
                    $releaseprice = $present->releaseprice*$currency->dollarf;/*  ترخیص عادی*/
                    $product = Product::where('id',$present->product_id)->first();
                    $productdiscount =$product->totalamount*10;

                    if (isset($product->discountamount)){
                        $pretotalprice =($price+$releaseprice)-$productdiscount;
                        $totalprice = $pretotalprice-$present->discountamount;
                    }
                    else{
                        $pretotalprice =($price+$releaseprice)-$packprice;
                        $totalprice = $pretotalprice-$present->discountamount;
                    }

                    $orderpresent = new Orderpresent();
                    $orderpresent->user_id =Auth::user()->id;
                    $orderpresent->present_id =$present->id;
                    $orderpresent->price = $price;
                    $orderpresent->releaseprice = $releaseprice;
                    $orderpresent->totalprice = $totalprice;
                    $orderpresent->save();
                }
            }
            if ($present->currency==2){ /* واحد پول یورو*/
                if ($currency->yorof){
                    $price = $present->price*$currency->yorof; /* خرید کالا*/
                    $releaseprice = $present->releaseprice*$currency->yorof;/*  ترخیص عادی*/
                    $product = Product::where('id',$present->product_id)->first();
                    $productdiscount =$product->totalamount*10;

                    if (isset($product->discountamount)){
                        $pretotalprice =($price+$releaseprice)-$productdiscount;
                        $totalprice = $pretotalprice-$present->discountamount;
                    }
                    else{
                        $pretotalprice =($price+$releaseprice)-$packprice;
                        $totalprice = $pretotalprice-$present->discountamount;
                    }

                    $orderpresent = new Orderpresent();
                    $orderpresent->user_id =Auth::user()->id;
                    $orderpresent->present_id =$present->id;
                    $orderpresent->price = $price;
                    $orderpresent->releaseprice = $releaseprice;
                    $orderpresent->totalprice = $totalprice;
                    $orderpresent->save();
                }
            }
            if ($present->currency==0){ /* واحد پول ریال*/
                $price = $present->price; /* خرید کالا*/
                $releaseprice = $present->releaseprice;/*  ترخیص عادی*/
                $product = Product::where('id',$present->product_id)->first();
                $productdiscount =$product->totalamount*10;

                if (isset($product->discountamount)){
                    $pretotalprice =($price+$releaseprice)-$productdiscount;
                    $totalprice = $pretotalprice-$present->discountamount;
                }
                else{
                    $pretotalprice =($price+$releaseprice)-$packprice;
                    $totalprice = $pretotalprice-$present->discountamount;
                }

                $orderpresent = new Orderpresent();
                $orderpresent->user_id =Auth::user()->id;
                $orderpresent->present_id =$present->id;
                $orderpresent->price = $price;
                $orderpresent->releaseprice = $releaseprice;
                $orderpresent->totalprice = $totalprice;
                $orderpresent->save();
            }

        }


//        dd($orderpresent);
//        try{
//
//        }catch (Exception $exception){
//            return back()->with('warning',$exception->getCode());
//        }
        $msg = 'محاسبات انجام شد فاکتور صادر شد.';
        return redirect()->back()->with('success',$msg,$orderpresent);
    }
    public function orderPresentPrint(Present $present)
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $orderpresent = Orderpresent::where('present_id',$present->id)->first();
        return view('front.dashboard.factorPrint',compact('present','user','productcount','orderpresent'));
    }

    public function presentQuickSelectBack(Present $present)
    {
//        dd($present);
        $present->select=null;
        $present->update();
        return redirect()->back();
    }


    public function storeUser(Request $request,Present $present)
    {
        dd($present);
        if (isset($request)){
            $user = User::where('id',Auth::user()->id)->first();
            $user->postcode = $request->postcode;
            $user->province_id = $request->province_id;
            $user->city_id = $request->city_id;
            $user->address = $request->address;
            $user->update();
        }

        $orderpresent = Orderpresent::where('present_id',$present->id)->first();
        $totalprice = $orderpresent->totalprice;
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $orderpresent = Orderpresent::where('present_id',$present->id)->first();
        return view('front.dashboard.factor',compact('user','present','totalprice','productcount','orderpresent'));
    }
    public function pardakht(Present $present)
    {
        $user = Auth::user();
        $product = Product::where('id',$present->product_id)->first();
        $packprice = $product->pack->price;
        $price =$present->price;
        $releaseprice = $present->releaseprice;
        $totalprice = ($price+$releaseprice)-$packprice;

        if ($price == 0 ){
            $totalprice = $present->releaseprice;
        }
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();


        $linkSurvey = 'https://docs.google.com/forms/d/e/1FAIpQLSeY8MHSa20HeZNrLJGvoeKxnQlax8RRkKwwremaWrCHF5x9RQ/viewform?usp=sf_link';
//        Mail::to($user->email)
//            ->send(new linkSurvey($linkSurvey, $user));
        if ($user->mobile){
            try {
                $receptor = $user->mobile;
                $type = 1;
                $template = "linkSurvey2";
                $param1 = $user->username;
                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                $api->Verify($receptor, $type, $template, $param1);
            } catch (\Ghasedak\Exceptions\ApiException $e){
                echo $e->errorMessage();
            } catch (\Ghasedak\Exceptions\HttpException $e){
                echo $e->errorMessage();
            }
        }

        return view('front.dashboard.pardakhtpresent',compact('user','present','totalprice','productcount'));
    }
}
