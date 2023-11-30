<?php

namespace App\Models;

use App\frontmodels\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
