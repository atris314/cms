<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Product;
use App\frontmodels\Teammate;
use App\frontmodels\Termteam;
use App\Http\Controllers\Controller;
use App\Models\Confirmation;
use App\Models\Protranslate;
use App\Notifications\ProTranslateAdd;
use App\Notifications\TicketTeamAdd;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProtranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $messages = [
            'category.required' => ' لطفا ترجمه دسته بندی را وارد نمایید',
            'subject.required' => 'لطفا ترجمه عنوان سفارش را  وارد كنيد ',

        ];
        $validateData = $request->validate([
            'category' => 'required',
            'subject' => 'required',
        ],$messages);

        $protranslate = new Protranslate();

        $protranslate->category = $request->input('category');
        $protranslate->subject = $request->input('subject');
        $protranslate->description = $request->input('description');
        $protranslate->product_id = $request->product_id;
        $protranslate->user_id = Auth::id();
        $protranslate->status = 0;

        $product = Product::where('id',$protranslate->product_id)->first();
        $product->status = 7;
        $product->save();

        $time = $date1 = new DateTime("now");
        $protime = $product->created_at;
        $diff =$protime->diffInDays($time);

        $teammate = Teammate::where('user_id',Auth::id())->first();
        $teammate->rate +=5 ;
        $teammate->count +=1 ;
        $teammate->activity +=1;
        //$days = $protime->diffInDays($time);
        $teammate->save();
        //dd($teammate);
        $protranslate->time =$diff;
        //dd($protranslate);

        $users = \App\Models\User::whereHas('roles' , function($q){
            $q->where('role_id', '1' );
        })->get();
        Notification::send($users , new ProTranslateAdd($protranslate->subject));

        try{
            $protranslate->save();
            $confirmation = new Confirmation();
            $confirmation->protitle = $product->title;
            $confirmation->pronumber = $product->number;
            $confirmation->propack = $product->pack->title;
            $confirmation->procaorder = $product->catorder->title;
            $confirmation->prodes = $product->description;
            $confirmation->translatesubject = $protranslate->subject;
            $confirmation->translatecategory = $protranslate->category;
            $confirmation->translatedes = $protranslate->description;
            $confirmation->user_id = Auth::id();
            $confirmation->product_id = $product->id;
            $confirmation->protranslate_id = $protranslate->id;
            $confirmation->save();
        }catch (Exception $exception){
            return redirect(route('checkingPro'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! ترجمه سفارش ثبت و سفارش به مدیر ارسال شد.' ;
        return redirect(route('workProduct'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Protranslate  $protranslate
     * @return \Illuminate\Http\Response
     */
    public function show(Protranslate $protranslate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Protranslate  $protranslate
     * @return \Illuminate\Http\Response
     */
    public function edit(Protranslate $protranslate)
    {
        $user = Auth::user();
        $teammate = Teammate::where('user_id',Auth::id())->first();
        $team = Teammate::where('user_id',Auth::id())->first();
        $protranslatescount = Protranslate::count();
        return view('front.workboard.proTranslateEdit',compact('protranslate','user' , 'protranslatescount','teammate','team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Protranslate  $protranslate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Protranslate $protranslate)
    {
        $messages = [
            'category.required' => ' لطفا ترجمه دسته بندی را وارد نمایید',
            'subject.required' => 'لطفا ترجمه عنوان سفارش را  وارد كنيد ',

        ];
        $validateData = $request->validate([
            'category' => 'required',
            'subject' => 'required',
        ],$messages);

        $protranslate->category = $request->input('category');
        $protranslate->subject = $request->input('subject');
        $protranslate->description = $request->input('description');
//        $protranslate->product_id = $request->product_id;
//        $protranslate->user_id = Auth::id();


        //dd($protranslate);
        try{
            $protranslate->update();
        }catch (Exception $exception){
            return redirect(route('protranslate.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! ترجمه سفارش  ویرایش شد.' ;
        return redirect(route('protranslate'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Protranslate  $protranslate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protranslate $protranslate)
    {
        //
    }

    public function proTranslate()
    {
        $user = Auth::user();

        $teammates = Teammate::with('user')->where('user_id',$user->id)->first();
        if ($teammates){
            $teammate = $teammates->groups()->pluck('catorder_id')->all();
            $products = Product::whereIn('catorder_id',$teammate)->get();
        }
        else{
            $products = null;
        }
        $protranslates = Protranslate::orderBy('created_at','desc')->where('user_id',$user->id)->paginate(15);
        $protranslateset = Protranslate::where('user_id',$user->id)->first();

        $team = Teammate::where('user_id',Auth::id())->first();
        $protranslatescount = Protranslate::count();
        return view('front.workboard.protranslate',compact('user','protranslates','products','protranslateset','protranslatescount','team'));
    }

    public function workProtranslateCodeSearch(Request $request)
    {
        $query = $request->input('codepro');
        $user = Auth::user();
        $protranslates = Protranslate::whereHas('product' , function($q) use ($query) {
            $q->where('codepro', 'like' , '%'.$query.'%');
        })->where('user_id',$user->id)->paginate(20);
        //dd($protranslates);
        $protranslateset = Protranslate::where('user_id',$user->id)->first();
        $team = Teammate::where('user_id',Auth::id())->first();
        $protranslatescount = Protranslate::count();

        return view('front.workboard.protranslate-search',compact('user','protranslates','protranslateset','protranslatescount','team'));
    }
}
