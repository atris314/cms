<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Catwork;
use App\frontmodels\Message;
use App\frontmodels\Product;
use App\frontmodels\Protranslate;
use App\frontmodels\User;
use App\frontmodels\Work;
use App\frontmodels\Teammate;
use App\Http\Controllers\Controller;
use App\frontmodels\Catorder;
use App\frontmodels\Group;
use App\frontmodels\Photo;
use App\Mail\ConfirmProduct;
use App\Mail\ProfileEdit;
use App\Mail\TeamSentFinal;
use App\Mail\WorkSent;
use App\frontmodels\Pack;
use App\frontmodels\Termteam;
use App\Models\Ad;
use App\Notifications\ProductPurchaseAdd;
use App\Notifications\TeamRequest;
use Carbon\Carbon;
use DateTime;
use Exception;
use Ghasedak\GhasedakApi;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class TeammateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $teammate = Teammate::where('user_id',$user->id)->first();
        $catworks = Catwork::all()->pluck('title','id');
        $protranslatescount = Protranslate::count();


        $teammates = Teammate::with('user')->where('user_id',$user->id)->first();
        if ($teammates){
            $teamitem = $teammates->groups()->pluck('catorder_id')->all();
            $ads = Ad::whereIn('catorder_id',$teamitem)->get();
        }
        else{
            $ads = null ;
        }

        //dd($ad);

        $team = Teammate::where('user_id',Auth::id())->first();

        $date1 = new DateTime("now");
        //dd($protranslatescount);
        return view('front.workboard.dashboard',compact('user','teammate','catworks','protranslatescount','team','ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $catworks =Catwork::all()->pluck('title','id');
        $termteame = Termteam::first();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.works',compact('user','catworks','termteame','productcount'));
    }

    public function teammate()
    {
        $user = Auth::user();
        $teammate = Teammate::where('user_id',$user->id)->first();
        $team = Teammate::where('user_id',Auth::id())->first();
        $catworks = Catwork::all()->pluck('title','id');
        $catorders = Catorder::all()->pluck('title','id');
        $termteame = Termteam::first();
        return view('front.workboard.teammatefinal',compact('catworks','user','teammate','catorders','termteame','team'));
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
            'major.required' => ' لطفا رشته تحصیلی خود را وارد نمایید',
            'catwork_id.required' => 'لطفا دسته بندی نوع همکاری را  تعيين كنيد ',
            'resume.required' => 'لطفا سوابق کاری خود را بنویسید ',
            'residence.required' => 'لطفا محدوده سکونت خود را وارد نمایید ',
            'education.required' => 'لطفا میزان تحصیلات خود را وارد نمایید ',
            'photo_id.required' => 'لطفا فایل رزومه خود را آپلود کنید ',
            'termcheck.required' => 'لطفا تیک شرایط و قوانین را بزنید.',
            'description.required' => 'لطفا توضیحی کوتاه در ارتباط با کارهایی که تاکنون انجام داده اید و در مورد مهارت هایتان بنویسید. ',

        ];
        $validateData = $request->validate([
            'major' => 'required',
            'catwork_id' => 'required',
            'photo_id' => 'required|mimes:pdf,doc,docx,zip',
            'residence' => 'required',
            'resume' => 'required',
            'education' => 'required',
            'description' => 'required',
            'termcheck' => 'required',
            recaptchaFieldName() => recaptchaRuleName()
        ],$messages);


        $teammate = new Teammate();
        $user = Auth::user();
        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $teammate->photo_id = $photo->id;
        }
        $borndate =date("H:i:s", strtotime($request->input('borndate')));

        $teammate->major = $request->input('major');
        $teammate->borndate = $request->input('borndate');
        $teammate->residence = $request->input('residence');
        $teammate->resume = $request->input('resume');
        $teammate->education = $request->input('education');
        $teammate->description = $request->input('description');
        $teammate->catwork_id = $request->input('catwork_id');
        $teammate->termcheck = $request->input('termcheck');
        $teammate->user_id = Auth::id();
        $teammate->status = 0 ;
        $teammate->fathername = null;
        $teammate->codemeli = null;
        $teammate->catorder_id = null;
        $teammate->product_id = null;
        if(isset($user->mobile)){
            $teammate->mobile = $user->mobile;
        }
        else{
            $teammate->mobile = null;
        }
        if(isset($user->phone)){
            $teammate->phone = $user->phone;
        }
        else{
            $teammate->phone = null;
        }
        if(isset($user->address)){
            $teammate->address = $user->address;
        }
        else{
            $teammate->address = null;
        }
        $teammate->maritalstatus = null;
        $teammate->skill = null;
        $teammate->lasteducation = null;
        //dd($request->input('borndate'));
        if (Auth::user())
        {
            $user = User::first();
            $user->rate +=5;
        }
        $user->save();
        //dd($teammate);


        $user = Auth::user();
            Mail::to(['farinaz.haghighi314@gmail.com',$user->email])
                ->send(new WorkSent($request , $user));

        $users = \App\Models\User::whereHas('roles' , function($q){
            $q->where('role_id', '1' );
        })->get();
        Notification::send($users , new TeamRequest($teammate->title));

        $site = 'yabane.ir';
//        if ($user->mobile){
//            try{
//                $receptor = $user->mobile;
//                $type = 1;
//                $template = "teammateSent";
//                $param1 = $user->name;
//                $param3 = $site;
//                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//                $api->Verify($receptor, $type, $template, $param1,$param3);
//            }
//            catch(\Ghasedak\Exceptions\ApiException $e){
//                echo $e->errorMessage();
//            }
//            catch(\Ghasedak\Exceptions\HttpException $e){
//                echo $e->errorMessage();
//            }
//        }
        try{
            if ($user->mobile){
                $receptor = $user->mobile;
                $type = 1;
                $template = "teammateSent";
                $param1 = $user->name;
                $param3 = $site;
                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                $api->Verify($receptor, $type, $template, $param1,$param3);
            }
            $teammate->save();
        }catch (Exception $exception){
            return redirect(route('works.create'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! رزومه شما با موفقیت ارسال شد، و بعد از تایید مدیر به شما اطلاع رسانی خواهد شد.' ;
        return redirect(route('profile'))->with('success',$msg);
    }



    public function teammateFinal(Request $request, Teammate $teammate)
    {
        $messages = [
            'lasteducation.required' => 'لطفا آخرین مدرک تحصیلی کاربر را انتخاب کنید. ',

        ];
        $validateData = $request->validate([
            'lasteducation' => 'required',
        ], $messages);

        //$user = User::where('id',$teammate->user_id)->first();
        //$teammates =  Teammate::where('user_id',$user->id)->first();

        $user = Auth::user();
        if ($file = $request->file('photo_id')) {
            $name = time() . $file->getClientOriginalName();
            $files = $file->move(public_path('images'), $name);
            $photo = new Photo();
            $photo->name = $files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo->save();
            $teammate->photo_id = $photo->id;
        }

        if ($request->input('mobile')) {
            $teammate->mobile = $request->input('mobile');
        }else{
            $teammate->mobile = $user->mobile;
        }

        if ($request->input('phone')) {
            $teammate->phone = $request->input('phone');
        }else{
            $teammate->phone = $user->phone;
        }

        if ($request->input('mobile')) {
            $teammate->mobile = $request->input('mobile');
        }else{
            $teammate->mobile = $user->mobile;
        }

        $teammate->update([
            'status' => 3,
            'fathername' => $request->input('fathername'),
//            'mobile' => $request->input('mobile'),
//            'phone' => $request->input('phone'),
            'codemeli' => $request->input('codemeli'),
            'residence' => $request->input('residence'),
            'address' => $request->input('address'),
            'resume' => $request->input('resume'),
            'education' => $request->input('education'),
            'maritalstatus' => $request->input('maritalstatus'),
            'lasteducation' => $request->input('lasteducation'),
            'catwork_id' => $request->input('catwork_id'),
            'catorder_id' => $request->input('catorder_id'),
            'skill' => $request->input('skill'),
            'description' => $request->input('description'),
            'user_id' => $user->id,
            'borndate' => $request->input('borndate')
        ]);
           //dd($teammate);
        $roles = $user->roles()->pluck('id')->all();
        $roles = 6 ;
        $user->roles()->attach($roles);



        foreach (['farinaz.haghighi314@gmail.com'] as $user->email) {
            Mail::to($user->email)
                ->send(new TeamSentFinal($request , $user));
        }


        try{
            $teammate->save();
        }catch (Exception $exception){
            return redirect(route('teammate-final.store',$teammate->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! فرم استخدام شما تکمیل شد.' ;
        return redirect(route('teammate'))->with('success',$msg);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function workProduct()
    {
        $user = Auth::user();
//        $teammate = Teammate::with('groups')->get()->pluck('group_id');
//        $group = Group::with('catorder')->where('id','=',$teammate)->pluck('catorder_id');
//        $products = Product::where('catorder_id',$group)->get();
        //////////فراخوانی سفارشاتی که دسته بندیشون با دسته بندی گروه همکاران برابر است/////////
        $team = Teammate::where('user_id',Auth::id())->first();
        $teammates = Teammate::with('user')->where('user_id',$user->id)->first();
        if ($teammates) {
            $teammate = $teammates->groups()->pluck('catorder_id')->all();
            $packs = $teammates->packs()->pluck('pack_id')->all();
        $protranslate = Protranslate::where('user_id',$user->id)->get();
        $products = Product::
            whereIn('catorder_id',$teammate)
            ->whereIn('pack_id',$packs)
            ->orderBy('created_at','DESC')
            ->where('status', '<>' ,7)
            ->where('status', '<>' ,3)
            ->where('status', '<>' ,4)
            ->where('status', '<>' ,5)
            ->where('status', '<>' ,8)
            ->where('status', '<>' ,9)
            ->where('status', '<>' ,10)
            ->where('status', '<>' ,11)
            ->where('status', '<>' ,13)
            ->where('status', '<>' ,0)
            ->where('status', '<>' ,1)
            ->where('status', '<>' ,15)
            ->paginate(10);
//            dd($products);
        $productset = Product::
        whereIn('catorder_id',$teammate)
            ->whereIn('pack_id',$packs)
            ->orderBy('pack_id','DESC')
            ->where('status', '<>' ,7)
            ->where('status', '<>' ,3)
            ->where('status', '<>' ,4)
            ->where('status', '<>' ,5)
            ->where('status', '<>' ,8)
            ->where('status', '<>' ,9)
            ->where('status', '<>' ,10)
            ->where('status', '<>' ,11)
            ->where('status', '<>' ,13)
            ->where('status', '<>' ,0)
            ->where('status', '<>' ,1)
            ->where('status', '<>' ,15)
            ->first();

        $check = $products->pluck('status')->first();
        $checkset =0;
        if ($check == 7)
        {
            $checkset ++;
        }
        }
        else{
            $products = null;
            $check = null;
            $checkset = null;
        }
        $protranslatescount = Protranslate::count();

        return view('front.workboard.workproduct',compact('user','products','protranslatescount','team','check','checkset','productset'));
    }


    public function workProductAll()
    {
        $user = Auth::user();
        $teammates = Teammate::with('user')->where('user_id', $user->id)->first();
        if ($teammates) {
            $teammate = $teammates->groups()->pluck('catorder_id')->all();
            $packs = $teammates->packs()->pluck('pack_id')->all();
            $protranslate = Protranslate::where('user_id', $user->id)->get();

            $products = Product::
            whereIn('catorder_id', $teammate)
                ->whereIn('pack_id', $packs)
                ->where('status', 7)
                ->orderBy('created_at', 'ASC')
                ->paginate(20);
        }
        else{
        $products = null;
        }
        //dd($products);
        $team = Teammate::where('user_id',Auth::id())->first();
        $protranslatescount = Protranslate::count();
        return view('front.workboard.workproduct-all',compact('user','products','protranslatescount','team'));
    }

    public function checkingPro(Product $product)
    {
        $user = Auth::user();
        $createTime =Carbon::parse($product->timepayment);

        $pack = Pack::where('id', $product->pack_id)->first();

        if ($pack->title == 'طلایی')
        {
            $createTime= Carbon::parse($createTime->addHour(24));
        }
        if ($pack->title == 'نقره ای')
        {
            $createTime= Carbon::parse($createTime->addHour(48));
        }
        if ($pack->title == 'برنز')
        {
            $createTime= Carbon::parse($createTime->addHour(72));
        }
//        dd($createTime= Carbon::parse($createTime->addDay(3)));
        $team = Teammate::where('user_id',Auth::id())->first();
        $protranslatescount = Protranslate::count();
        $messages = Message::where('product_id',$product->id)->where('user_id',$user->id)->get();
        $messageset = Message::where('product_id',$product->id)->where('user_id',$user->id)->first();

        return view('front.workboard.checkingPro',compact('user','product','createTime','protranslatescount','team','messages','messageset'));
    }
    public function confirmPro(Product $product)
    {

        $users = User::where('id',$product->user_id)->first();
        $user = Auth::user();
        $createTime = $product->created_at;
        $pack = Pack::where('id', $product->pack_id)->first();
        $team = Teammate::where('user_id',Auth::id())->first();
        $protranslatescount = Protranslate::count();

        $product->status = 11;

        Mail::to(['yabane.ir@gmail.com',$users->email])
            ->send(new ConfirmProduct($users, $product ,$pack));
        try{
            if ($users->mobile){
                $receptor = $users->mobile;
                $type = 1;
                $template = "confirmProduct";
                $param1 = $users->name;
                $param2 = $product->codepro;
                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                $api->Verify($receptor, $type, $template, $param1,$param2);
            }
            $product->update();
        }catch (Exception $exception){
            return redirect(route('front.workboard.dashboard'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم؛ سفارش تایید شد و از لیست انتظار خارج شد.';
//        return view('front.workboard.dashboard',compact('user','product','createTime','protranslatescount','team'))->with('success',$msg);
//        return view('front.workboard.dashboard',compact('user','users','product','createTime','protranslatescount','team'))->with('success',$msg);
        return redirect(route('teammate',compact('user','users','product','createTime','protranslatescount','team')))->with('success',$msg);
    }
    public function workProductCodeSearch(Request $request)
    {
        $query = $request->input('codepro');
        $user = Auth::user();
        $team = Teammate::where('user_id',Auth::id())->first();
        $teammates = Teammate::with('user')->where('user_id',$user->id)->first();
        if ($teammates) {
            $teammate = $teammates->groups()->pluck('catorder_id')->all();
            $packs = $teammates->packs()->pluck('pack_id')->all();
            $protranslate = Protranslate::where('user_id',$user->id)->get();

            $products = Product::
            whereIn('catorder_id',$teammate)
                ->whereIn('pack_id',$packs)
                ->where('codepro',$query)
                ->orderBy('created_at','ASC')
                ->where('status', '<>' ,7)
                ->where('status', '<>' ,3)
                ->where('status', '<>' ,4)
                ->where('status', '<>' ,5)
                ->where('status', '<>' ,8)
                ->where('status', '<>' ,9)
                ->where('status', '<>' ,10)
                ->where('status', '<>' ,12)
                ->where('status', '<>' ,13)
                ->where('status', '<>' ,0)
                ->where('status', '<>' ,1)
                ->where('status', '<>' ,15)
                ->paginate(20);
            //dd($products);
            $productset = Product::
            whereIn('catorder_id',$teammate)
                ->whereIn('pack_id',$packs)
                ->where('codepro',$query)
                ->orderBy('created_at','ASC')
                ->where('status', '<>' ,7)
                ->where('status', '<>' ,3)
                ->where('status', '<>' ,4)
                ->where('status', '<>' ,5)
                ->where('status', '<>' ,8)
                ->where('status', '<>' ,9)
                ->where('status', '<>' ,10)
                ->where('status', '<>' ,12)
                ->where('status', '<>' ,13)
                ->where('status', '<>' ,0)
                ->where('status', '<>' ,1)
                ->where('status', '<>' ,15)
                ->first();

            $check = $products->pluck('status')->first();
            $checkset =0;
            if ($check == 7)
            {
                $checkset ++;
            }

        }
        else{
            $products = null;
            $check = null;
            $checkset = null;
        }
        $protranslatescount = Protranslate::count();

        return view('front.workboard.workproduct-search',compact('user','products','protranslatescount','team','check','checkset','productset'));
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function notification()
    {
        $user = Auth::user();
        $notifications = auth()->user()->notifications;
        $notifications ->markAsread();
        // dd($notifications);
        $team = Teammate::where('user_id',Auth::id())->first();
        return view('front.workboard.notifications',compact('notifications','user','team'));
    }
}
