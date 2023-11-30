<?php

namespace App\Models;

use App\frontmodels\Coupon;
use App\models\Protranslate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['status'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function photos()
    {
        return $this->belongsToMany(Photo::class);
    }

    public function catorder()
    {
        return $this->belongsTo(Catorder::class);
    }
    public function resid()
    {
        return $this->belongsTo(Resid::class);
    }
    public function message()
    {
        return $this->belongsTo(Message::class);
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

    public function present()
    {
        return $this->belongsTo(Present::class);
    }
    public function cancel()
    {
        return $this->belongsTo(Cancel::class);
    }

    public function producttracking()
    {
        return $this->belongsTo(Producttracking::class);
    }
}
