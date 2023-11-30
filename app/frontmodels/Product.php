<?php

namespace App\frontmodels;

use App\frontmodels\Coupon;
use App\Models\Producttracking;
use App\Models\Resid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'title','number','description','catorder_id','pack_id','termcheck','codepro','user_id','status' ,'amount','totalamount','discountamount','isiran','partnumber'
    ];
//    protected $casts = [
//        'photo_id' => 'array',
//    ];

//    public $totalprice = 0;
//    public $totaldiscountprice = 0;
//    public $coupondiscount =null;
//    public $price = 0;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function photos()
    {
        return $this->belongsToMany(Photo::class,'photo_product','product_id','photo_id');
    }

    public function catorder()
    {
        return $this->belongsTo(Catorder::class);
    }
    public function resid()
    {
        return $this->belongsTo(Resid::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function teammate()
    {
        return $this->belongsTo(Teammate::class);
    }

    public function protranslate()
    {
        return $this->belongsTo(Protranslate::class);
    }
    public function group()
    {
        return $this->hasMany(Group::class);
    }
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    public function producttracking()
    {
        return $this->belongsTo(Producttracking::class);
    }
//    public function addcoupon($coupon)
//    {
//        $coupondiscount = ['price'=> $coupon->price, 'coupon' =>$coupon];
//        $this->totalprice -= $coupon['price'];
//        $this->coupondiscount += $coupondiscount['totalprice'];
//
//    }

}
