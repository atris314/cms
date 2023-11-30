<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
    public function couponpresent()
    {
        return $this->belongsTo(Couponpresent::class);
    }
}
