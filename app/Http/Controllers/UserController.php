<?php

namespace App\Http\Controllers;

use App\frontmodels\Pack;
use App\frontmodels\Photo;
use App\frontmodels\Present;
use App\Models\Bannerhome;
use App\Models\City;
use App\Models\Confirmation;
use App\Models\Football;
use App\Models\Footballpre;
use App\Models\Presentresid;
use App\frontmodels\Product;
use App\frontmodels\Coupon;
use App\frontmodels\Protranslate;
use App\Mail\ContactSent;
use App\Mail\ProductStore;
use App\Mail\ProfileEdit;
use App\frontmodels\Banneruser;
use App\frontmodels\Ad;
use App\Models\Catorder;
use App\Models\Message;
use App\Notifications\Couponsent;
use App\Notifications\ProductAdd;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Exception;
use Ghasedak\GhasedakApi;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\frontmodels\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Trez\RayganSms\Facades\RayganSms;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $coupon = Coupon::where('status' , 1)->first();
        return view('front.dashboard.dashboard',compact('user','coupon'));
    }
    public function getAllCities($province_id)
    {
        $cities = City::where('province_id',$province_id)->get();
//        dd($cities);
        $response =[
            'cities' => $cities
        ];
        return response()->json($response,200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function rateToCoupon(Request $request)
    {
        $messages = [
            'rate.required' => ' لطفا اگر کوپن تخفیف دارید وارد نمایید',
        ];
        $validateData = $request->validate([
            'rate' => 'required',
        ], $messages);

        $coupon = new Coupon();
        if (Auth::user()->rate>=50) {
            $user = Auth::user();
            $rate = $user->rate;
            $coupon->code = $rate+rand();
            $coupon->price = $rate*1000;
            $coupon->title = $user->name;
            $coupon->status = 1;

            //$coupon->user()->attach($coupon);
            //dd($coupon);
            try{
                $coupon->save();
            }catch (Exception $exception){
                return back()->with('warning',$exception->getCode());
            }
            $msg ='امتیاز شما با موفقیت به کد تخفیف تبدیل شد' ;
            return back()->with('success',$msg);
        }
        else{
            $msg = 'امتیاز شما برای تبدیل به کد تخفیف کم است' ;
            return back()->with('warning',$msg);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $pagetitle = 'ویرایش اطلاعات شخصی';
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $confirmations = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->get();
        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();
        return view('front.dashboard.profile',compact('pagetitle','user','productcount','confirmationset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        $messages = [
            'postcode.required' => 'برای تکمیل اطلاعات حساب کاربری لطفا کدپستی خود را وارد نمایید',
//            'city_id.required' => 'برای تکمیل اطلاعات حساب کاربری لطفا شهر خود را وارد نمایید',
//            'province_id.required' => 'برای تکمیل اطلاعات حساب کاربری لطفا استان خود را وارد نمایید',
            'postcode.min' => 'کد پستی وارد شده اشتباه است! کد پستی حداقل باید 10 رقم باشد',
            'postcode.max' => 'کد پستی وارد شده اشتباه است! کدپستی نمیتواند بیشتر از 10 رقم باشد',
            'postcode.integer' => 'کد پستی باید از نوع عدد باشد',
            'address.required' => 'برای تکمیل اطلاعات حساب کاربری لطفا آدرس خود را وارد نمایید',
            'phone.required' => 'برای تکمیل اطلاعات حساب کاربری لطفا شماره خود را وارد نمایید',
        ];
        $validateData = $request->validate([
            'address' => 'required',
//            'city_id' => 'required',
//            'province_id' => 'required',
            'phone' => 'required',
            'postcode' => 'required|integer|min:1111111111|max:9999999999',
        ], $messages);

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $user->photo_id = $photo->id;
        }
        if ($user->username = $request->username){
            $user->username = $request->username;
        }
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->mobile = $request->mobile;
        $user->phone = $request->phone;
        $user->jobs = $request->jobs;
        $user->companyname = $request->companyname;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->city_id = $request->city_id;
        $user->province_id = $request->province_id;
        $user->code = $request->code;
//        dd($user);
//        if (trim($request->input('password') != "")){
//            $user->password = bcrypt($request->input('password'));
//        }
        if ($request->input('password')){
            $user->password = bcrypt($request->input('password'));
        }

        $roles = $user->roles()->pluck('id')->all();
        $roles = 5 ;
        $user->roles()->attach($roles);


//        Mail::to($request->email)
//            ->send(new ProfileEdit($request));
//
//        $users = \App\Models\User::whereHas('roles' , function($q){
//            $q->where('role_id', '1' );
//        })->get();
//        $coupon = Coupon::where('title','تخفیف منبع یابی')->first();
//        Notification::send($users , new Couponsent($coupon));

//        $site = 'yabane.ir';
//        if ($user->mobile){
//            try{
//                $receptor = $user->mobile;
//                $type = 1;
//                $template = "Couponsent";
//                $param1 = $user->name;
//                $param2 = $coupon->code;
//
//                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//                $api->Verify($receptor, $type, $template, $param1,$param2);
//            }
//            catch(\Ghasedak\Exceptions\ApiException $e){
//                echo $e->errorMessage();
//            }
//            catch(\Ghasedak\Exceptions\HttpException $e){
//                echo $e->errorMessage();
//            }
//        }
//        dd($request);

        if ($request->session()->get('form-data')){
            $data = $request->session()->get('form-data');
            $product = new Product();
            $codepro = rand(10000, 20000);
            if ($pack_id = $data['data']['pack_id'])
            {
                $amount = Pack::where('id',$pack_id)->pluck('price')->first();
            }
            $photos = explode(',', $data['data']['photos'][0]);
            $product = Product::create([
                'title' => $data['data']['title'],
                'catorder_id' =>$data['data']['catorder_id'],
                'pack_id' =>$data['data']['pack_id'],
                'number' =>$data['data']['number'],
                'description' =>$data['data']['description'],
                'photos' =>$data['data']['photos'],
                'termcheck' =>$data['data']['termcheck'],
//                'g-recaptcha-response' =>$data['data']['g-recaptcha-response'],
                'user_id' =>Auth::id(),
                'codepro' =>$codepro,
                'amount' =>$amount,
                'status' =>0,
                'discountamount' =>0,
                'totalamount' =>$amount,
                'isiran' =>$data['data']['isiran'],
                'question' =>$data['data']['question'],
                'partnumber' =>$data['data']['partnumber'],
            ]);
            if (isset($data['data']['photos'][0])) {
                $product->photos()->sync($photos);
            }
            $pack = \App\Models\Pack::where('id',$product->pack_id)->first();
            $catorder = Catorder::where('id',$product->catorder_id)->pluck('title')->first();
            Mail::to([$user->email,'yabane.ir@gmail.com'])
                ->send(new ProductStore($user, $product ,$pack ,$catorder));
//            $site = route('productshow',$product->id);
            if (isset($user->mobile)){
                $receptor = $user->mobile;
                $type = 1;
                $template = "productSenttest";
                $param1 = $codepro;
//                $param2 = $site;
                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                $api->Verify($receptor, $type, $template, $param1);
            }
            if ($users = \App\Models\User::whereHas('roles' , function($q){
                $q->where('role_id', '1' );
            })->get()) {
                Notification::send($users, new ProductAdd($product->title));
            }
            $user->rate +=5;
            $user->update();
            $request->session()->forget('form-data');
        }
//        if ($request->session()->get('form-data')){
//            $data = $request->session()->get('form-data');
//            $presentresid = new Presentresid();
//            $photos = explode(',', $data['data']['photos'][0]);
//            $presentresid = Presentresid::create([
//                'user_id' =>$user->id,
//                'present_id' =>$data['data']['present_id'],
//                'photos' =>$data['data']['photos'],
//            ]);
//            if (isset($data['data']['photos'][0])) {
//                $presentresid->photos()->sync($photos);
//            }
//            $request->session()->forget('form-data');
//        }
        try{
            $user->update();
        }catch (Exception $exception) {
            return redirect(route('profileedite'))->with('warning', $exception->getCode());
        }
//        $msg = 'انجام شد' ;
//        return redirect(route('present-pardakht.store'))->with('success',$msg);
//        if (isset($product)){
//            $msg = 'متشکرم؛ اطلاعات کاربری تکمیل شد سفارش شما در انتظار پرداخت هزینه منبع یابی می باشد';
//            return redirect(route('productshow',$product->id))->with('success',$msg);
//        }
                $msg = 'عملیات با موفقیت انجام شد';
                return redirect(route('profile'))->with('success', $msg);

    }

    public function profile()
    {
        $user = Auth::user();
        $msg = 'ویرایش با موفقیت انجام شد' ;
        return view('front.dashboard.profilecheck',compact('user'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('photo_id',$id)->first();
        try{
            $photo = Photo::findOrFail($id);
//            unlink(('images'). $user->photo->path);
            $photo->delete();
        }catch (Exception $exception){
            return redirect(route('profile'))->with('warning',$exception->getCode());
        }
        $msg = 'تصویر پروفایل حذف شد' ;
        return redirect(route('profile'))->with('success',$msg);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $coupon = Coupon::where('status' , 1)->orderBy('created_at','DESC')->first();
        $bannerusers = Banneruser::first();
        $ads = Ad::orderBy('id','DESC')->paginate(2);
        $adset = Ad::first();

//        $messages = Message::where('read',0)->pluck('product_id')->all();
//        $products = Product::where('user_id',$user->id)->whereIn('id',$messages)->get();
//        $productset = Product::where('user_id',$user->id)->whereIn('id',$messages)->first();

        $products = Product::where('user_id',$user->id)->pluck('id')->all();

        $messages = Message::whereIn('product_id',$products)->orderby('created_at','DESC')->paginate(1);
        $messageset = Message::whereIn('product_id',$products)->first();
//        dd($messages);
        $product = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')
            ->orderBy('created_at','DESC')->first();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
//        dd($productcount);
        if(isset($product)){
            $protranslate = Protranslate::where('product_id',$product->id)->pluck('status')->first();
            $present = Present::where('product_id',$product->id)->get();
            $presentset = Present::with('product')->where('product_id',$product->id)->first();
        }
        else {
            $protranslate = null;
            $present = null;
            $presentset = null;
        }
//        $confirmations = Confirmation::where('confirm',null)->where('user_id',$user->id)->get();
//        $confirmationset = Confirmation::where('confirm',null)->where('user_id',$user->id)->first();


        $confirmations = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->get();
        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();

        //dd($confirmationset);
        $footballs = Football::orderBy('created_at','asc')->get();


        for ($i = 0; $i < count($footballs); $i++){
            $footb = $footballs[$i];
            $createTime=$footb->date;
            $today= Carbon::parse('today');
            $dateTime= Carbon::parse($createTime)->subHour(48);
            $explodetoday = explode(' ',$today);
            $explodedatetime = explode(' ',$dateTime);
            $result =( $explodedatetime[0] == $explodetoday[0] );
//            dd($result);
            if ($result==true){
                $resultdatetime= Carbon::parse($dateTime)->addHour(48)->addMinutes(45);
            }
            else $resultdatetime= null;

        }

        $footballpre = Footballpre::all()->pluck('answer');
        for ($i = 0; $i < count($footballpre); $i++){
            $footb = $footballpre[$i];
            $count = count(array($footb));
//            dd($count);
        }
//        dd($footballpre);

        $bannerhome=Bannerhome::orderBY('created_at','desc')->first();
        return view('front.dashboard.dashboard',compact('user','coupon','bannerusers','ads','adset','messages','messageset','product','productcount','protranslate','present','presentset','confirmationset','confirmations','footballs','footb','result','resultdatetime','bannerhome'));
    }
    public function notification()
    {
        $user = Auth::user();
        $notifications = auth()->user()->notifications;
        $notifications ->markAsread();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
       // dd($notifications);
        return view('front.dashboard.notifications',compact('notifications','user','productcount'));
    }

    //    public function userNotifications()
    //    {
    //        return response()->json(\auth()->user()->unreadNotification(), Response::HTTP_OK);
    //    }

    public function wallet()
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.wallets',compact('user','productcount'));
    }
    public function walletform()
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.wallets',compact('user','productcount'));
    }

    public function account(Request $request,User $user)
    {

        $messages = [
            'postcode.required' => 'برای تکمیل اطلاعات حساب کاربری لطفا کدپستی خود را وارد نمایید',
            'postcode.min' => 'کد پستی وارد شده اشتباه است! کد پستی حداقل باید 10 رقم باشد',
            'postcode.max' => 'کد پستی وارد شده اشتباه است! کدپستی نمیتواند بیشتر از 10 رقم باشد',
            'postcode.integer' => 'کد پستی باید از نوع عدد باشد',
            'address.required' => 'برای تکمیل اطلاعات حساب کاربری لطفا آدرس خود را وارد نمایید',
        ];
        $validateData = $request->validate([
            'address' => 'required',
            'postcode' => 'required|integer|min:1111111111|max:9999999999',
        ], $messages);

        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->city_id = $request->city;
        $user->province_id = $request->province;

        $roles = $user->roles()->pluck('id')->all();
        $roles = 5 ;
        $user->roles()->attach($roles);

        try{
            $user->update();
        }catch (Exception $exception) {
            return redirect()->back()->with('warning', $exception->getCode());
        }
        $msg = 'اطلاعات پستی شما ثبت شد';
        return redirect()->back()->with('success', $msg);

    }

    public function checkMobileUser()
    {
//        $checktime = Auth::user()->checktime;
//        $check=explode(" ", $checktime);
//        $timer = $check[1];
//        $timercheck=Carbon::parse($checktime);
//        $time = Carbon::parse(now()->addMinutes(120));
//        $user = User::where('id',Auth::user()->id)->first();
//        $user->checktime = $time;
//        $user->update();
//        dd($time);
//        dd($timercheck);
        return view('front.auth.mobilecheck');
    }
    public function MobileCheckOutUser(Request $request)
    {
        $user = Auth::user();
        $messages = [
            'checkid.required' => ' لطفا کد تایید دریافتی خود را وارد نمایید',
        ];
        $validateData = $request->validate([
            'checkid' => 'required',
        ], $messages);
//        dd($request);
        $checkid = $user->checkid;
        try{
            if ($checkid == $request->input('checkid')) {
                $user->mobileverified = 1;
                $user->update();
            }
        }catch (Exception $exception) {
            return redirect()->back()->with('warning', $exception->getCode());
        }
        $msg = 'متشکرم ! شماره موبایل شما تایید شد';
        return redirect(route('home'))->with('success', $msg);
    }
    public function MobileCheckResentUser()
    {
        $user = Auth::user();
        $random = rand(10000 , 20000);
        $mobile = $user->mobile;
        try{
            $receptor = $mobile;
            $type = 1;
            $template = "activeCode";
            $param1 = $random;
            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
            $api->Verify($receptor, $type, $template, $param1);
        }
        catch(\Ghasedak\Exceptions\ApiException $e){
            echo $e->errorMessage();
        }
        catch(\Ghasedak\Exceptions\HttpException $e){
            echo $e->errorMessage();
        }
        $user->checkid = $random;
        try{
            $user->update();
        }catch (Exception $exception){
            return redirect(route('MobileCheck'))->with('danger',$exception->getCode());
        }
        $msg = 'متشکرم ! لطفا کد تایید دریافت شده را وارد نمایید' ;
        return redirect(route('home'))->with('success', $msg);
    }
    /*for login controller*/
    public function LogincheckMobileUser()
    {
        return view('front.auth.LoginMobilecheck');
    }
    public function LoginMobileCheckOutUser(Request $request)
    {
        $messages = [
            'checkid.required' => ' لطفا کد تایید دریافتی خود را وارد نمایید',
        ];
        $validateData = $request->validate([
            'checkid' => 'required',
        ], $messages);

        try{
            $user = User::where('checkid',$request->checkid)->first();
            $checkid = $user->checkid;
            if ($checkid == $request->input('checkid')) {
                $user->mobileverified = 1;
                $user->update();
            }
        }catch (Exception $exception) {
            $msg = 'دقت کنید! کد تایید مطابقت ندارد!';
            return redirect()->back()->with('danger',$msg);
        }
        $msg = 'متشکرم ! شماره موبایل شما تایید شد';
        \Auth::login($user);
        return redirect(route('home'))->with('success', $msg);
    }
    public function LoginMobileCheckResentUser(Request $request)
    {
        $user = Auth::user();
        dd($request);
        $random = rand(10000 , 20000);
        $mobile = $user->mobile;
        try{
            $receptor = $mobile;
            $type = 1;
            $template = "activeCode";
            $param1 = $random;
            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
            $api->Verify($receptor, $type, $template, $param1);
        }
        catch(\Ghasedak\Exceptions\ApiException $e){
            echo $e->errorMessage();
        }
        catch(\Ghasedak\Exceptions\HttpException $e){
            echo $e->errorMessage();
        }
        $user->checkid = $random;
        try{
            $user->update();
        }catch (Exception $exception){
            return redirect(route('MobileCheck'))->with('danger',$exception->getCode());
        }
        $msg = 'متشکرم ! لطفا کد تایید دریافت شده را وارد نمایید' ;
        return redirect(route('home'))->with('success', $msg);
    }

}
