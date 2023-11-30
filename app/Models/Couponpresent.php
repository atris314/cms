<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couponpresent extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function present()
    {
        return $this->belongsTo(Present::class);
    }
    public function coins()
    {
        return $this->belongsToMany(Coin::class);
    }

    public function change()
    {
        return $this->belongsTo(Change::class);
    }
}
