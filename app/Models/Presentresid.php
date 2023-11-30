<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentresid extends Model
{
    use HasFactory;
    protected $fillable=['user_id','present_id'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
    public function present()
    {
        return $this->belongsTo(Present::class,'present_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function photos()
    {
        return $this->belongsToMany(Photo::class);
    }
}
