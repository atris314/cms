<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Couponpresent;
use App\Models\User;
use App\Notifications\Couponsent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class CouponpresentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couponpresents = Couponpresent::orderBy('id','DESC')->paginate(20);
        return view('back.couponpresents.couponpresents',compact('couponpresents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.couponpresents.create');
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
            'title.required' => ' لطفا فیلد عنوان کدتخفیف را وارد نمایید',
            'code.required' => ' لطفا فیلد کد تخفیف را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
            'code' => 'required',
        ],$messages);

        $couponpresent = new Couponpresent();

        $couponpresent->title = $request->input('title');
        $couponpresent->code = $request->input('code');
        $couponpresent->price = $request->input('price');
        $couponpresent->status = $request->input('status');

        $createTime= Carbon::parse(now());
        $expiretime= Carbon::parse($createTime->addHour(720));
        $couponpresent->expiry_date = $expiretime;

        try{
            $couponpresent->save();
        }catch (Exception $exception){
            return redirect(route('back.couponpresents.create'))->with('warning',$exception->getCode());
        }
        $msg = ' کوپن تخفیف جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.couponpresents'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Couponpresent  $couponpresent
     * @return \Illuminate\Http\Response
     */
    public function show(Couponpresent $couponpresent)
    {
        return view('back.couponpresents.show',compact('couponpresent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Couponpresent  $couponpresent
     * @return \Illuminate\Http\Response
     */
    public function edit(Couponpresent $couponpresent)
    {
        return view('back.couponpresents.edit',compact('couponpresent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Couponpresent  $couponpresent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Couponpresent $couponpresent)
    {
        $messages = [
            'title.required' => ' لطفا فیلد عنوان کدتخفیف را وارد نمایید',
            'code.required' => ' لطفا فیلد کد تخفیف را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'code' => 'required',
        ],$messages);


        $couponpresent->title = $request->input('title');
        $couponpresent->code = $request->input('code');
        $couponpresent->price = $request->input('price');
        $couponpresent->status = $request->input('status');
        try{
            $couponpresent->save();
        }catch (Exception $exception){
            return redirect(route('back.couponpresents.edit'))->with('warning',$exception->getCode());
        }
        $msg = ' کوپن تخفیف جدید با موفقیت ویرایش شد :)' ;
        return redirect(route('back.couponpresents'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Couponpresent  $couponpresent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Couponpresent $couponpresent)
    {
        try{
            $couponpresent->delete();
        }catch (Exception $exception){
            return redirect(route('back.couponpresents'))->with('warning',$exception->getCode());
        }
        $msg = 'کوپن مورد نظر حذف گردید :)' ;
        return redirect(route('back.couponpresents'))->with('success',$msg);
    }
    public function updatestatus(Couponpresent $couponpresent)
    {
        if ($couponpresent->status==1)
        {
            $couponpresent->status = 0;
        }else
        {
            $couponpresent->status = 1;
        }
        $couponpresent->update();
        $msg = "بروزرسانی با موفقیت انجام شد :)";
        return redirect(route('back.couponpresents'))->with('success',$msg);

    }
    public function deleteAll(Request $request)
    {
        $couponpresents = Couponpresent::findOrFail($request->checkBoxArray);
        foreach ($couponpresents as $couponpresent){
            $couponpresent->delete();
        }
        $msg = 'کوپن ها با موفقیت حذف شد' ;
        return redirect(route('back.couponpresents'))->with('success',$msg);
    }


}
