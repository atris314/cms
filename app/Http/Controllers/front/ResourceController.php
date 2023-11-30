<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Catorder;
use App\Models\Resource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ResourceController extends Controller
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
        $product->title = $request->input('title');
        $product->number = $request->input('number');
        $product->description = $request->input('description');
        $product->catorder_id = $request->input('catorder_id');
        $product->pack_id = $request->input('pack_id');
        $product->termcheck = $request->input('termcheck');
        $product->isiran = $request->input('isiran');
        $product->partnumber = $request->input('partnumber');


        try{
            $product->save();
        }
        catch (Exception $exception){
            return redirect(route('product'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! سفارش شما در انتظار پرداخت هزینه منبع یابی می باشد.' ;
        return redirect(route('productshow',$product->id))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        //
    }
}
