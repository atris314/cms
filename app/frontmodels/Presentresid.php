<?php

namespace App\frontmodels;

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
        return $this->belongsTo(Present::class);
    }
    public function photos()
    {
        return $this->belongsToMany(Photo::class);
    }
}
