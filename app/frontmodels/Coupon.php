<?php

namespace App\frontmodels;

use App\frontmodels\Product;
use App\frontmodels\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
//    public $totalprice = 0;
//    public $totaldiscountprice = 0;
//    public $coupondiscount =null;
//    public $price = 0;

    public function user()
    {
        return $this->belongsToMany(User::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

//    public function addcoupon($coupon)
//    {
//        $coupondiscount = ['price'=> $coupon->price, 'coupon' =>$coupon];
//        $this->totalprice -= $coupon->price;
//        $this->coupondiscount += $coupondiscount->totalprice;
//
//    }
}
