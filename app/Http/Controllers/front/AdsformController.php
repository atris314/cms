<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\frontmodels\Adsform;
use App\Models\Ad;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdsformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.adsforms');
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
            'name.required' => 'لطفا نام خود را وارد نمایید',
            'phone.required' => 'لطفا شماره تلفن خود را جهت تماس وارد نمایید',
            'email.required' => 'لطفا ایمیل خود را وارد کنید',
            'subject.required' => 'لطفا موضوع درخواست را بنویسید',
            'description.required' => 'لطفا توضیحی کوتاه درباره درخواست خود بنویسید',


        ];
        $validateData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'description' => 'required',

        ],$messages);


        $adsform = new Adsform();

        $adsform->name = $request->input('name');
        $adsform->email = $request->input('email');
        $adsform->phone = $request->input('phone');
        $adsform->subject = $request->input('subject');
        $adsform->description = $request->input('description');
        //dd($adsform);

        try{
            $adsform->save();
        }catch (Exception $exception){
            return redirect(route('ads'))->with('warning',$exception->getCode());
        }
        $msg = ' درخواست شما با موفقیت ارسال شد. با تشکر' ;
        return redirect(route('ads'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adsform  $adsform
     * @return \Illuminate\Http\Response
     */
    public function show(Adsform $adsform)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adsform  $adsform
     * @return \Illuminate\Http\Response
     */
    public function edit(Adsform $adsform)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adsform  $adsform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adsform $adsform)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adsform  $adsform
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adsform $adsform)
    {
        //
    }
}
