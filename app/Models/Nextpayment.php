<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nextpayment extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function present()
    {
        return $this->belongsTo(Present::class);
    }
    public function ordernextpay()
    {
        return $this->belongsTo(Ordernextpay::class,'order_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
