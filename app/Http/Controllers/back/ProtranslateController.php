<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Product;
use App\Http\Controllers\Controller;
use App\Mail\ProductConfirm;
use App\Mail\ProductSentUser;
use App\Models\Admin;
use App\Models\Catorder;
use App\Models\Email;
use App\Models\Pack;
use App\Models\Photo;
use App\Models\Present;
use App\Models\Protranslate;
use App\Models\Teammate;
use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ProtranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $protranslates = Protranslate::orderBy('created_at','DESC')->paginate(20);
//        $protranslate = Protranslate::with('product')->get();
//        $protranslate = Protranslate::first()->pluck('product_id');
//        $product = Product::whereIN('id',$protranslate)->pluck('user_id');
//
//        $user = User::whereIN('id',$product)->pluck('code');


        return view('back.protranslates.protranslates',compact('protranslates'));

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
        $protranslate->teammate_id = Auth::id();

        //dd($protranslate);
        try{
            $protranslate->save();
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
        return view('back.protranslates.show',compact('protranslate'));
    }

    public function productprint(Protranslate $protranslate)
    {
         $user = Auth::user();
         return view('back.protranslates.protranslatesprint',compact('protranslate','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Protranslate  $protranslate
     * @return \Illuminate\Http\Response
     */
    public function edit(Protranslate $protranslate)
    {
        return view('back.protranslates.edit',compact('protranslate'));
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
        ];
        $validateData = $request->validate([
        ],$messages);

        $protranslate->subject = $request->input('subject');
        $protranslate->category = $request->input('category');
        $protranslate->description = $request->input('description');

        try{
            $protranslate->update();
        }catch (Exception $exception){
            return redirect(route('back.protranslates.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'ترجمه ویرایش شد' ;
        return redirect(route('back.protranslates'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Protranslate  $protranslate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protranslate $protranslate)
    {
            try{
                $protranslate->delete();
            }catch (Exception $exception){
                return redirect(route('back.protranslates'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.protranslates'))->with('success',$msg);
    }

    public function prosent(Protranslate $protranslate)
    {
        $teammate = Teammate::where('user_id',$protranslate->user_id)->first();
        $teammate->count++;
        $teammate->activity++;
        $teammate->rate++;
        $develope = Admin::first();
        $product = Product::where('id',$protranslate->product_id)->first();
        $product['status'] = '5';

        $user = User::where('id',$product->user_id)->first();
        $chineemail = Email::pluck('email')->first();

        $photo = $product->Photos()->pluck('path')->all();

        $catorder = Catorder::where('id',$product->catorder_id)->first();
        $pack = Pack::where('id',$product->pack_id)->first();
        if ($pack->id == 1){
            $packtitle = "Delivery time to the customer is one week";
        }elseif ($pack->id == 2){
            $packtitle = "Delivery time to customer is 10 days";
        }elseif ($pack->id == 3) {
            $packtitle = "Delivery time to the customer is 15 days";
        }

        Mail::to(['yabane.ir@gmail.com',$chineemail])
            ->send(new ProductConfirm($protranslate , $user, $product , $photo ,$catorder,$pack , $packtitle ));
        try{
        $teammate->update();
        $product->save();
        }catch (Exception $exception){
            return redirect(route('back.protranslates.show',$protranslate->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! سفارش به چین ارسال شد.' ;
        return redirect(route('back.protranslates.show',$protranslate->id))->with('success',$msg);

    }

    public function proSentUser(Protranslate $protranslate)
    {
        try{
            $develope = Admin::first();
            $product = Product::where('id',$protranslate->product_id)->first();
            $user = User::where('id',$product->user_id)->first();
            $chineemail = Email::pluck('email')->first();
            $photo = Photo::where('id',$product->photo_id)->pluck('path')->first();
            $catorder = Catorder::where('id',$product->catorder_id)->first();
            $pack = Pack::where('id',$product->pack_id)->first();
            if ($pack->id == 1){
                $packtitle = "Delivery time to the customer is one week";
            }elseif ($pack->id == 2){
                $packtitle = "Delivery time to customer is 10 days";
            }elseif ($pack->id == 3) {
                $packtitle = "Delivery time to the customer is 15 days";
            }

            $product['status'] = '5';
            $product->save();

            //dd($product);


            Mail::to(['yabane.ir@gmail.com',$user->email,$chineemail])
                ->send(new ProductSentUser($protranslate , $user, $product , $photo ,$catorder,$pack , $packtitle));



        }catch (Exception $exception){
            return redirect(route('back.protranslates.show',$protranslate->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! سفارش به چین ارسال شد.' ;
        return redirect(route('back.protranslates.show',$protranslate->id))->with('success',$msg);

    }

    public function proCodeSearch(Request $request)
    {
        $query = $request->input('codepro');

        $packs = Pack::all()->pluck('title','id');

        $protranslates = Protranslate::whereHas('product' , function($q) use ($query) {
            $q->where('codepro', 'like' , '%'.$query.'%');
        })->paginate(20);

        //dd($protranslate);
        return view('back.protranslates.code-search',compact('protranslates','query','packs'));
    }


}
