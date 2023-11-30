<?php

namespace App\frontmodels;

use App\frontmodels\Teammate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function catorder()
    {
        return $this->belongsTo(Catorder::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function teammates()
    {
        return $this->belongsToMany(Teammate::class);
    }

}
