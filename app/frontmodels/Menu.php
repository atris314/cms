<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['title','sort','url','post_id','status'];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function submenu()
    {
        return $this->hasOne(  Menu::class, 'id','post_id');
    }

    public function getChid()
    {
        return $this->hasMany(Menu::class,'post_id');
    }
    public function getChidtow()
    {
        return $this->hasMany(Menu::class,'post_id');
    }
}
