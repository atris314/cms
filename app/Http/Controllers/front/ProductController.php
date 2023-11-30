<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Coupon;
use App\frontmodels\Present;
use App\frontmodels\Transaction;
use App\Http\Controllers\Controller;
use App\frontmodels\Product;
use App\frontmodels\User;
use App\Mail\Cancelpro;
use App\Mail\ProductConfirm;
use App\Mail\ProductEdit;
use App\Mail\ProductStore;
use App\Mail\Rerequest;
use App\Models\Admin;
use App\Models\Cancel;
use App\Models\Catorder;
use App\Models\Confirmation;
use App\Models\Editpro;
use App\Models\Message;
use App\Models\Orderpresent;
use App\Models\Pack;
use App\frontmodels\Photo;
use App\Models\Post;
use App\frontmodels\Termpro;
use App\Models\Presentaction;
use App\Models\Protranslate;
use App\Models\Role;
use App\Models\Subscribe;
use App\Models\Teammate;
use App\Models\Thread;
use App\Notifications\Couponsent;
use App\Notifications\NewReplySubmitted;
use App\Notifications\ProductAdd;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Compound;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
//        if (Auth::user())
//        {
//            $products = Product::with('user')->where('user_id',$user->id)->first();
//        }else
//        {
//            $msg = 'سفارشی ندارید' ;
//            return back()->with('success',$msg);
//        }

        $products = Product::with('user')->where('user_id',$user->id)->first();
        //dd($products);
        $packs = Pack::all();
        $catorders =Catorder::where('status', 0)->pluck('title','id')->all();
        $termpros = Termpro::first();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();

        $confirmations = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->get();
        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();

        return view('front.dashboard.product',compact('products','user','packs','catorders','termpros','productcount','confirmationset'));
    }
    public function store(Request $request)
    {
        $messages = [
            'title.required' => ' لطفا عنوان سفارش خود را وارد نمایید',
            'description.required' => ' لطفا توضیحی درباره سفارشتان بنویسید را وارد نمایید',
            'catorder_id.required' => 'لطفا دسته بندی را  تعيين كنيد ',
            'pack_id.required' => ' نوع منبع یابی را مشخص نکرده اید',
            'termcheck.required' => 'لطفا تیک شرایط و قوانین را بزنید.',
            'number.required' => 'لطفا تعداد سفارش را مشخص کنید',
            'isiran.required' => ' پاسخ سوال آیا در ایران موجود است؟ را وارد نمایید',
//            'photos.required' => 'لطفا تصاویر سفارش مورد نظر خود را آپلود نمایید.',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'catorder_id' => 'required',
            'pack_id' => 'required',
            'termcheck' => 'required',
            'number' => 'required',
            'isiran' => 'required',
//            'photos' => 'required|mimes:jpeg,jpg,png',
//            recaptchaFieldName() => recaptchaRuleName()
            'arcaptcha-token' => 'arcaptcha',
        ],$messages);


        $product = new Product();
        $codepro = rand(10000, 20000);

        //$product['photo_id'] = $request->input('photo_id');
        $product->title = $request->input('title');
        $product->number = $request->input('number');
        $product->description = $request->input('description');
        $product->catorder_id = $request->input('catorder_id');
        $product->pack_id = $request->input('pack_id');
        $product->termcheck = $request->input('termcheck');
        $product->isiran = $request->input('isiran');
        $product->partnumber = $request->input('partnumber');
        $product->codepro = $codepro;
        $product->user_id = Auth::id();
        if ($request->input('isiran') == 'yes'){
            $product->question = $request->input('question');
        }
        $product->status = 0;

        if ($pack_id = $request->input('pack_id'))
        {
            $amount = $product->pack()->pluck('price')->first();
        }
        $product->amount = $amount;
        $product->totalamount = $amount;
        $product->discountamount = 0;
        $photos = explode(',', $request->input('photos')[0]);

        $user = Auth::user();

//        dd($product);

        $develope = Admin::first();
        $pack = Pack::where('id',$product->pack_id)->first();
        $catorder = Catorder::where('id',$product->catorder_id)->pluck('title')->first();

        //dd($photos);

        try{
            $product->save();

            if (isset($request->input('photos')[0])) {
                $product->photos()->sync($photos);
            }

//            Mail::to([$user->email,'yabane.managment.@gmail.com'])
//                ->send(new ProductStore($user, $product ,$pack ,$catorder));

//            $site = route('productshow',$product->id);
//            if (isset($user->mobile)){
//                $receptor = $user->mobile;
//                $type = 1;
//                $template = "productSent";
//                $param1 = $codepro;
//                $param2 = $site;
//                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//                $api->Verify($receptor, $type, $template, $param1,$param2);
//            }


            if ($users = \App\Models\User::whereHas('roles' , function($q){
                $q->where('role_id', '1' );
            })->get()) {
                Notification::send($users, new ProductAdd($product->title));
            }

//            $user->rate +=10;
//            $user->update();
        }
        catch (Exception $exception){
            return redirect(route('product'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! سفارش شما در انتظار پرداخت هزینه منبع یابی می باشد.' ;
        return redirect(route('productshow',$product->id))->with('success',$msg);
    }
//    public function store(Request $request)
//    {
//
//        $messages = [
//            'title.required' => ' لطفا عنوان سفارش خود را وارد نمایید',
//            'description.required' => ' لطفا توضیحی درباره سفارشتان بنویسید را وارد نمایید',
//            'catorder_id.required' => 'لطفا دسته بندی را  تعيين كنيد ',
//            'pack_id.required' => ' نوع منبع یابی را مشخص نکرده اید',
//            'termcheck.required' => 'لطفا تیک شرایط و قوانین را بزنید.',
////            'photos.required' => 'لطفا تصاویر سفارش مورد نظر خود را آپلود نمایید.',
//
//        ];
//        $validateData = $request->validate([
//            'title' => 'required',
//            'description' => 'required',
//            'catorder_id' => 'required',
//            'pack_id' => 'required',
//            'termcheck' => 'required',
////            'photos' => 'required|mimes:jpeg,jpg,png',
//            recaptchaFieldName() => recaptchaRuleName()
//        ],$messages);
//
//
//        $product = new Product();
//        $codepro = rand(10000, 20000);
//
//            //$product['photo_id'] = $request->input('photo_id');
//            $product->title = $request->input('title');
//            $product->number = $request->input('number');
//            $product->description = $request->input('description');
//            $product->catorder_id = $request->input('catorder_id');
//            $product->pack_id = $request->input('pack_id');
//            $product->termcheck = $request->input('termcheck');
//            $product->codepro = $codepro;
//            $product->user_id = Auth::id();
//
//            $product->status = 0;
//
//        if ($pack_id = $request->input('pack_id'))
//        {
//            $amount = $product->pack()->pluck('price')->first();
//        }
//        $product->amount = $amount;
//        $product->totalamount = $amount;
//        $product->discountamount = 0;
//        $photos = explode(',', $request->input('photos')[0]);
//
//        $user = Auth::user();
//
//
//
//
//        //dd($userid->mobile);
////        try {
////            if (isset($userid->mobile)) {
////                $receptor = $userid->mobile;
////                $message = 'کاربر گرامی سفارش شما در سایت یابانه ثبت شد';
////                $lineNumber = 3000859959;
////                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
////                $api->SendSimple($receptor, $message, $lineNumber);
////            }
////        }
////        catch(\Ghasedak\Exceptions\ApiException $e){
////            echo $e->errorMessage();
////        }
////            catch(\Ghasedak\Exceptions\HttpException $e){
////            echo $e->errorMessage();
////        }
////        if (isset($user->mobile)){
////            try {
////                $receptor = $user->mobile;
////                $type = 1;
////                $template = "productSent";
////                $param1 = $user->name;
////                $param2 = $codepro;
////                $param3='https://yabane.ir';
////                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
////                $api->Verify($receptor, $type, $template, $param1, $param2,$param3);
////            } catch (\Ghasedak\Exceptions\ApiException $e) {
////                echo $e->errorMessage();
////            } catch (\Ghasedak\Exceptions\HttpException $e) {
////                echo $e->errorMessage();
////            }
////        }
//        if ($users = \App\Models\User::whereHas('roles' , function($q){
//            $q->where('role_id', '1' );
//        })->get()) {
//            Notification::send($users, new ProductAdd($product->title));
//        }
//        $develope = Admin::first();
//        $pack = Pack::where('id',$product->pack_id)->first();
//        $catorder = Catorder::where('id',$product->catorder_id)->pluck('title')->first();
//
//
//        Mail::to([$develope->email,$user->email,'yabane.ir@gmail.com'])
//            ->send(new ProductStore($user, $product ,$pack ,$catorder));
//        try{
//            $product->save();
//            if (isset($request->input('photos')[0])) {
//                $product->photos()->attach($photos);
//            }
//            $user->rate +=5;
//            $user->update();
//
//            if (isset($user->mobile)){
//                    $receptor = $user->mobile;
//                    $type = 1;
//                    $template = "productSent";
//                    $param1 = $codepro;
//                    $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//                    $api->Verify($receptor, $type, $template, $param1);
//            }
//        }catch (Exception $exception){
//            return redirect(route('product'))->with('info',$exception->getCode());
//        }
//
//        $msg = 'متشکرم ! سفارش شما با موفقیت ثبت شد هزینه منبع یابی را پرداخت نمایید تا در دست اقدام قرار گیرد.' ;
//        return redirect(route('oldproduct'))->with('success',$msg);
//    }



    public function show(Product $product)
    {
       // $user = Auth::user();
        $packs = Pack::all();
        $catorders =Catorder::all()->pluck('title','id');

        return view(route('front.dashboard.productshow',$product->id) ,compact('product', 'user','packs','catorders'));
    }

    public function productshow(Product $product)
    {
        $user = Auth::user();
        $packs = Pack::all();
        $catorders =Catorder::all()->pluck('title','id');
        //$product = Product::with('user')->where('user_id',$user->id)->latest('id')->first();
        $coupon = Coupon::where('status' , 1)->orderBy('created_at','DESC')->first();
        //$product->totalamount = $product->amount;
        $presents = Present::with('product')->where('product_id',$product->id)->orderBy('created_at','DESC')->paginate(20);
//        dd($presents);
        $presentset = Present::with('product')->where('product_id',$product->id)->first();
        $price = Present::where('product_id',$product->id)->pluck('price')->all();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();

//        if ($presents){
//            $packprice = $product->pack->price;
//            for($i=0; $i<count($presents); $i++){
//                $price =$presents->price[$i];
//                $releaseprice = $presents->releaseprice;
//                $totalprice = ($price+$releaseprice)-$packprice;
//                if ($price == 0 ){
//                    $totalprice = $presents->releaseprice;
//                }
//            }
//
//            $price =$presents->price;
//            $releaseprice = $presents->releaseprice;
//            $totalprice = ($price+$releaseprice)-$packprice;
//            if ($price == 0 ){
//                $totalprice = $presents->releaseprice;
//            }
//        }
//        else{
//            $packprice = null;
//            $releaseprice = null;
//            $totalprice = null;
//        }


        return view('front.dashboard.productshow',compact('user','packs','catorders','product','coupon','presents','presentset','productcount'));
    }

    public function oldproduct()
    {
         $user = Auth::user();
        $packs = Pack::all();
        $catorders =Catorder::all()->pluck('title','id');
        $productset = Product::with('user')->where('user_id',$user->id)->first();
        $products = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')
            ->orderBy('id','DESC')->paginate(24);
        $coupon = Coupon::where('status' , 1)->first();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();

        $confirmations = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->get();
        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();

        return view('front.dashboard.oldproduct',compact('user','packs','catorders','products','coupon','productset','productcount','confirmationset'));
    }

    public function edit(Product $product)
    {
        $user = Auth::user();
        $termpros = Termpro::first();
        $catorders =Catorder::all()->pluck('title','id');
        $packs =Pack::all()->pluck('title','id');
        $messages = Message::where('product_id',$product->id)->get();
        $messageset = Message::where('product_id',$product->id)->first();
//        dd($message);
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.productedit',compact('product','user','termpros','catorders','packs','messageset','messages','productcount'));
    }

    public function update(Request $request , Product $product)
    {

        $messages = [
            'description.required' => ' لطفا توضیحی درباره سفارشتان بنویسید را وارد نمایید',
            'photos.required' => 'لطفا تصاویر سفارشتان را آپلود کنید',
        ];
        $validateData = $request->validate([
            'description' => 'required',
            'photos' => 'required',
        ],$messages);

        $product->termcheck = 'yes';
        $product->number = $request->input('number');
        $product->description = $request->input('description');
        $product->title = $request->input('title');
        $product->number = $request->input('number');
        $product->description = $request->input('description');
        $product->catorder_id = $request->input('catorder_id');
        $product->pack_id = $request->input('pack_id');
        $product->partnumber = $request->input('partnumber');

        if ($pack_id = $request->input('pack_id'))
        {
            $amount = $product->pack()->pluck('price')->first();
        }
        $product->amount = $amount;
        $product->totalamount = $amount;
        $product->discountamount = 0;

        if (Auth::user())
        {
            $user = User::first();
//            $user->rate +=2;
        }
        $user->update();

        $users = User::where('id',$product->user_id)->first();

        //dd($photos);


        $develope = Admin::first();
        $pack = Pack::where('id',$product->pack_id)->first();
        $catorder = Catorder::where('id',$product->catorder_id)->pluck('title')->first();

//        dd($product);
        Mail::to([$develope->email,$user->email,$users->email])
            ->send(new ProductEdit($users, $product ,$pack ,$catorder));
        $editpro = new Editpro();
        if ($product->status == 12)
        {
            if ($request->input('photos')[0] or $request->input('description'))
            {
                $editpro->productphoto = $request->input('photos')[0];
                $editpro->productfield = $request->input('description');
            }
            $editpro->product_id = $product->id;
//            dd($editpro);
            $editpro->save();
        }
        try{
            $product->update();
            if ($request->input('photos')[0]){
                $photos = explode(',', $request->input('photos')[0]);
                $product->photos()->attach($photos);
            }
            $messages = Message::where('product_id',$product->id)->first();
            if ($messages)
            {
                $messages->read = 1;
                $messages->update();
            }


        }catch (Exception $exception){
            return redirect(route('product.edit',$product->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! سفارش شما با موفقیت ویرایش شد.' ;
        return redirect(route('oldproduct'))->with('success',$msg);
    }

    public function Rerequest(Product $product)
    {

        $product->status = '6';

        //dd($product);

        $develope = Admin::first();
        $user = Auth::user();


        Mail::to(['farinaz.haghighi314@gmail.com','yabane.managment.@gmail.com',$user->email])
            ->send(new Rerequest($user, $product));

        try{
            $product->save();

        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'کاربر گرامی! درخواست مجدد شما برای پیگیری سفارش ثبت شد.' ;
        return redirect(route('oldproduct'))->with('success',$msg);
    }
    public function destroy(Product $product)
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.product-cancel',compact('product','user','productcount'));
    }

    public function cancel(Request $request ,Product $product)
    {
        $messages = [
            'body.required' => 'لطفا توضیحی مختصر در مورد علت لغو سفارش بنویسید. باتشکر',
        ];
        $validateData = $request->validate([
            'body' => 'required',
        ],$messages);

        $cancel = new Cancel;
        $cancel->body = $request->input('body');
        $cancel->product_id = $product->id;
        $cancel->user_id = Auth::user()->id;
        $product->status = '14';
        $product->update();

        try{
            $cancel->save();
        }catch (Exception $exception){
            return redirect(route('product.destroy',$product->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! سفارش شما با موفقیت لغو شد.' ;
        return redirect(route('oldproduct'))->with('success',$msg);
    }


    public function InvoiceAccount()
    {
        $user = Auth::user();
        $transactionset = Transaction::where('user_id',$user->id)->where('status',2)->first();
        $transactions = Transaction::where('user_id',$user->id)->where('status',2)->orderBy('created_at','DESC')->paginate(20);
        //dd($presentactions);
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.invoice-account',compact('user','transactions','transactionset','productcount'));
    }

    public function InvoicePresentAccount()
    {
        $user = Auth::user();
        $presentactionset = Presentaction::where('user_id',$user->id)->where('status',2)->first();
        $presentactions = Presentaction::where('user_id',$user->id)->where('status',2)->orderBy('created_at','DESC')->paginate(20);
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        //dd($presentactions);
        return view('front.dashboard.invoice-present-account',compact('user','presentactions','presentactionset','productcount'));
    }

    public function InvoiceAccountShow(Transaction $transaction)
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
        $product = Product::where('id',$transaction->product_id)->where('user_id',$user->id)->first();
        $pack = Pack::where('id',$product->pack_id)->pluck('price')->first();
        if ($protranslate = Protranslate::where('product_id',$transaction->product_id)->first())
        {
            $protranslate = Protranslate::where('product_id',$transaction->product_id)->first();
        }
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.invoice-account-show',compact('user','transaction','reference_id','pack','protranslate','productcount'));
    }

    public function InvoicePresentAccountShow(Presentaction $presentaction)
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
        $present = Present::where('id',$presentaction->present_id)->where('user_id',$user->id)->first();
        $product = Product::where('id',$present->product_id)->where('user_id',$user->id)->first();
        $pack = Pack::where('id',$product->pack_id)->pluck('price')->first();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        //dd($product);
        return view('front.dashboard.invoice-present-account-show',compact('user','presentaction','reference_id','pack','present','product','productcount'));
    }

    public function MobileCheck()
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.mobilecheck',compact('user','productcount'));
    }

    public function MobileCheckStore(Request $request)
    {
        $user = Auth::user();
        $messages = [
            'mobile.required' => ' لطفا شماره موبایل خود را وارد نمایید',
            'mobile.unique' => 'خطا! این شماره موبایل قبلا در سیستم ثبت شده است!',
        ];
        $validateData = $request->validate([
            'mobile' => 'required|unique:users',
        ],$messages);


        $user->mobile = $request->input('mobile');
        $random = rand(10000 , 20000);
        $mobile = $request->input('mobile');

        try{
            $receptor = $request->input('mobile');
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
        //dd($user);
        try{
            $user->update();
        }catch (Exception $exception){
            return redirect(route('MobileCheck'))->with('danger',$exception->getCode());
        }
        $msg = 'متشکرم ! لطفا کد تایید دریافت شده را وارد نمایید' ;
        return view('front.dashboard.mobilecheck-sent',compact('user'))->with('success',$msg);
    }

    public function MobileCheckResent()
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
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
//        dd($user);
        try{
            $user->update();
        }catch (Exception $exception){
            return redirect(route('MobileCheck'))->with('danger',$exception->getCode());
        }
        $msg = 'متشکرم ! لطفا کد تایید دریافت شده را وارد نمایید' ;
        return view('front.dashboard.mobilecheck-sent',compact('user','productcount'))->with('success',$msg);
    }

    public function MobileCheckSent()
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.mobilecheck-sent',compact('user','productcount'));
    }

    public function MobileCheckOut(Request $request)
    {
        $user = Auth::user();
        $messages = [
            'checkid.required' => ' لطفا کد تایید دریافتی خود را وارد نمایید',
        ];
        $validateData = $request->validate([
            'checkid' => 'required',
        ],$messages);

        $checkid = $user->checkid;
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        if ($checkid == $request->input('checkid'))
        {
            $user->mobileverified = 1;
            $user->update();
            $msg = 'متشکرم ! شماره موبایل شما تایید شد' ;
            return redirect(route('product',compact('user','productcount')))->with('success',$msg);

        }
        else{
            $msg = 'کد وارد شده صحیح نیست' ;
            return redirect()->back()->with('waring',$msg);
        }
    }

    public function pardakht(Product $product)
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.pardakht',compact('user','product','productcount'));
    }


    public function productSearch(Request $request)
    {
        $query = $request->input('codepro');
        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('codepro','like' , "%".$query."%")
            ->paginate(20);
        $productset= Product::where('codepro','like' , "%".$query."%")
            ->first();
//        dd($products);
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.oldproduct',compact('products','query','packs','user','productset','productcount'));
    }
    public function productTracking(Product $product)
    {

        $createTime =Carbon::parse($product->timepayment);

        $pack = Pack::where('id', $product->pack_id)->first();

        if ($pack->title == 'طلایی')
        {
            $createTime= Carbon::parse($createTime->addHour(120));
        }
        if ($pack->title == 'نقره ای')
        {
            $createTime= Carbon::parse($createTime->addHour(240));
        }
        if ($pack->title == 'برنز')
        {
            $createTime= Carbon::parse($createTime->addHour(360));
        }

        $protranslate = Protranslate::where('product_id',$product->id)->pluck('status')->first();
        $present = Present::with('product')->where('product_id',$product->id)->get();
        $presentset = Present::with('product')->where('product_id',$product->id)->first();
//        dd($present);
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.order-tracking',compact('product','user','productcount','protranslate','present','presentset','createTime'));
    }

}
