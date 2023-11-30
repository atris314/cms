<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resid extends Model
{
    use HasFactory;
    protected $fillable=['photo_id','user_id','resid_code'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
