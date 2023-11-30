<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function couponpresents()
    {
        return $this->belongsToMany(Couponpresent::class);
    }

    public function change()
    {
        return $this->belongsTo(Change::class);
    }
}
