<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Product;
use App\Http\Controllers\Controller;
use App\Notifications\Couponsent;
use App\Mail\ProductSentUser;
use App\Models\Admin;
use App\Models\Catorder;
use App\Models\Coupon;
use App\Models\Email;
use App\Models\Pack;
use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $coupons = Coupon::orderBy('id','DESC')->paginate(20);
            return view('back.coupons.coupons',compact('coupons'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('isAdmin')){
            return view('back.coupons.create');
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }
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

        $coupon = new Coupon();

        $coupon->title = $request->input('title');
        $coupon->code = $request->input('code');
        $coupon->price = $request->input('price');
        $coupon->status = $request->input('status');


        $createTime= Carbon::parse(now());
        $expiretime= Carbon::parse($createTime->addHour(720));
        $coupon->expiry_date = $expiretime;
//        dd($expiretime);
        try{
            $coupon->save();
        }catch (Exception $exception){
            return redirect(route('back.coupons.create'))->with('warning',$exception->getCode());
        }
        $msg = ' کوپن تخفیف جدید با موفقیت ایجاد شد :)';
        return redirect(route('back.coupons'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return view('back.coupons.show',compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        if (Gate::allows('isAdmin')){
            return view('back.coupons.edit',compact('coupon'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon )
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'code.required' => ' لطفا فیلد توضیحات را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'code' => 'required',
        ],$messages);

        $coupon->title = $request->input('title');
        $coupon->code = $request->input('code');
        $coupon->price = $request->input('price');
        try{
            $coupon->update();
        }catch (Exception $exception){
            return redirect(route('back.coupons.edit'))->with('warning',$exception->getCode());
        }
        $msg = ' کوپن تخفیف با موفقیت ویرایش شد :)' ;
        return redirect(route('back.coupons'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if (Gate::allows('isAdmin')){
            try{
                $coupon->delete();
            }catch (Exception $exception){
                return redirect(route('back.coupons'))->with('warning',$exception->getCode());
            }
            $msg = 'کوپن مورد نظر حذف گردید :)' ;
            return redirect(route('back.coupons'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }

    }

    public function updatestatus(Coupon $coupon)
    {
        if (Gate::allows('isAdmin')){
            if ($coupon->status==1)
            {
                $coupon->status = 0;
            }else
            {
                $coupon->status = 1;
            }
            $coupon->save();
            $msg = "بروزرسانی با موفقیت انجام شد :)";
            return redirect(route('back.coupons'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند وضعیت را تغییر دهد.' ;
            return back()->with('info',$msg);
        }

    }
    public function deleteAll(Request $request)
    {
        $coupons = Coupon::findOrFail($request->checkBoxArray);
        foreach ($coupons as $coupon){
            $coupon->delete();
        }
        $msg = 'کوپن ها با موفقیت حذف شد' ;
        return redirect(route('back.coupons'))->with('success',$msg);
    }

    public function Sent(Coupon $coupon)
    {
        try{
            $develope = Admin::first();
            $user = User::where('rate' , '>=' ,  100)->get();
            //dd($user);
//            Mail::to([$develope->email,$user->email])
//                ->send(new Couponsent($coupon,$user));

            Notification::send($user , new Couponsent($coupon));

        }catch (Exception $exception){
            return redirect(route('back.coupons.show',$coupon->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! کد تخفیف برای کاربران ارسال شد.' ;
        return redirect(route('back.coupons.show',$coupon->id))->with('success',$msg);
    }
}
