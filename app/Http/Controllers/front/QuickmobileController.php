<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Quickmobile;
use Exception;
use Illuminate\Http\Request;

class QuickmobileController extends Controller
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
            'mobile.required' => ' لطفا شماره موبایل خود را وارد نمایید',
        ];
        $validateData = $request->validate([
            'mobile' => 'required',
        ],$messages);

        $quickmobile = new Quickmobile();
        $quickmobile->mobile = $request->input('mobile');

        try{
            $quickmobile->save();
        }catch (Exception $exception){
            return redirect(route('home'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم! شماره شما در سیستم ثبت شد تیم پشتیبانی در اسرع وقت با شما تماس خواهند گرفت.' ;
        return redirect(route('home'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quickmobile  $quickmobile
     * @return \Illuminate\Http\Response
     */
    public function show(Quickmobile $quickmobile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quickmobile  $quickmobile
     * @return \Illuminate\Http\Response
     */
    public function edit(Quickmobile $quickmobile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quickmobile  $quickmobile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quickmobile $quickmobile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quickmobile  $quickmobile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quickmobile $quickmobile)
    {
        //
    }
}
