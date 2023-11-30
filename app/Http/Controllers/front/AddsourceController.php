<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Addsource;
use App\Models\Catorder;
use Exception;
use Illuminate\Http\Request;

class AddsourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catorders =Catorder::all()->pluck('title','id');
        return view('front.resources',compact('catorders'));
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
            'name.required' => ' لطفا نام خود را وارد نمایید',
            'lastname.required' => ' لطفا نام خانوادگی خود را وارد نمایید',
            'mobile.required' => ' لطفا شماره موبایل خود را وارد نمایید',
            'brandname.required' => ' لطفا نام شرکت یا نام برند خود را وارد نمایید',
            'job.required' => ' لطفا سِمَت کاری خود را وارد نمایید',
            'address.required' => ' لطفا آدرس خود را وارد نمایید',
            'activitytime.required' => ' لطفا مدت زمان فعالیت در این حوزه را بنویسید',
            'description.required' => ' لطفا فیلد "در چه زمینه ای و به چه صورت قصد همکاری با یابانه را دارید"، تکمیل بفرمایید',
            'catorder_id.required' => 'لطفا زمینه کاری خود را  تعيين كنيد ',
            'city_id.required' => 'لطفا شهر خود را انختب کنید ',
            'province_id.required' => 'لطفا استان خود را انختب کنید ',
        ];
        $validateData = $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'mobile' => 'required',
            'brandname' => 'required',
            'job' => 'required',
            'address' => 'required',
            'activitytime' => 'required',
            'description' => 'required',
            'catorder_id' => 'required',
            'city_id' => 'required',
            'province_id' => 'required',
        ],$messages);


        $addsource = new Addsource();
        
        $addsource->name = $request->input('name');
        $addsource->lastname = $request->input('lastname');
        $addsource->mobile = $request->input('mobile');
        $addsource->email = $request->input('email');
        $addsource->brandname = $request->input('brandname');
        $addsource->job = $request->input('job');
        $addsource->website = $request->input('website');
        $addsource->address = $request->input('address');
        $addsource->activitytime = $request->input('activitytime');
        $addsource->description = $request->input('description');

        $addsource->city_id = $request->input('city_id');
        $addsource->province_id = $request->input('province_id');
        $addsource->catorder_id = $request->input('catorder_id');

        try{
            $addsource->save();
        }
        catch (Exception $exception){
            return redirect(route('front.resources'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! درخواست شما برای همکاری به عنوان منبع ثبت شد.' ;
        return redirect(route('home'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addsource  $addsource
     * @return \Illuminate\Http\Response
     */
    public function show(Addsource $addsource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Addsource  $addsource
     * @return \Illuminate\Http\Response
     */
    public function edit(Addsource $addsource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Addsource  $addsource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Addsource $addsource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addsource  $addsource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addsource $addsource)
    {
        //
    }
}
