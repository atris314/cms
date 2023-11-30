<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\frontmodels\Coupon;
use App\frontmodels\Product;
use App\Models\Couponpresent;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function addCoupon(Request $request , Product $product)
    {
        $messages = [
            'code.required' => ' لطفا اگر کوپن تخفیف دارید وارد نمایید',
        ];
        $validateData = $request->validate([
            'code' => 'required',
        ], $messages);
        $user = Auth::user();
        $users = User::where('id', $user->id)->first();
        $coupon = Coupon::where('code', $request->code)->first();

        if(isset($coupon->expiry_date)){
            $expitytime = $coupon->expiry_date;
            $createTime= Carbon::parse(today());
            $today = $expitytime <= $createTime;
            if ($today==true){
                $msg = 'کد تخفیف منقضی شده است';
                return back()->with('warning', $msg);
            }
        }
//        dd($expitytime);

        else{
            if($coupon == null){
                $couponpresent = Couponpresent::where('code', $request->code)->first();
                $check = $users->whereHas('coupons', function ($q) use ($couponpresent, $users) {
                    $q->where('coupon_id', $couponpresent->id)
                        ->where('status', 1)->where('user_id', $users->id);
                })->exists();
                if (!$check) {
                    $couponpresent = Couponpresent::where('code', $request->code)->first();
                    $couponpresent->status = 0;
                    $couponpresent->update();
                    $amount = $product->amount;
                    $discount = $couponpresent->price / 10;
                    $total = $amount - $discount;
                    $product->coupon_id = $couponpresent->id;
                    $product->amount = $amount;
                    $product->discountamount = $discount;
                    $product->totalamount = $total;
                    $product->status = 1;
                    $product->save();
                    $user = Auth::user();
                    $user->couponpresents()->attach($couponpresent);
                    $user->save();
                    $msg = 'کد تخفیف اعمال شد';
                    return back()->with('success', $msg);
                } else {
                    $msg = 'شما قبلا از این کد تخفیف استفاده کرده اید';
                    return back()->with('warning', $msg);
                }
            } elseif($coupon != null) {
                $check = $users->whereHas('coupons', function ($q) use ($coupon, $users) {
                    $q->where('coupon_id', $coupon->id)
                        ->where('status', 1)->where('user_id', $users->id);
                })->exists();
                if (!$check) {
                    $coupon = Coupon::where('code', $request->code)->first();
                    $amount = $product->amount;
                    $discount = $coupon->price;
                    $total = ($amount * $discount) / 100;
                    $totalamount = $amount - $total;
                    $product->coupon_id = $coupon->id;
                    $product->amount = $amount;
                    $product->discountamount = $discount;
                    $product->totalamount = $totalamount;
                    $product->status = 1;
                    $product->save();
                    $user = Auth::user();
                    $user->coupons()->attach($coupon);
                    $user->save();
                    $msg = 'کد تخفیف اعمال شد';
                    return back()->with('success', $msg);
                } else {
                    $msg = 'شما قبلا از این کد تخفیف استفاده کرده اید';
                    return back()->with('warning', $msg);
                }
            }
        }

//        dd($couponpresent);
//        dd($coupon);

//        $check = $users->whereHas('coupons', function ($q) use ($request) {
//            $q->where('code', $request->code)->where('status',1);
//        });

    }

}
