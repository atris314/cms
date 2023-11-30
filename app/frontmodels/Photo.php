<?php

namespace App\frontmodels;

use App\frontmodels\Portfolio;
use App\frontmodels\Product;
use App\frontmodels\Work;
use App\frontmodels\Ad;
use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $fillable=['name','path','user_id'];

    protected $uploads = '/images/';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function presentresids()
    {
        return $this->belongsToMany(Presentresid::class);
    }
    public function teammate()
    {
        return $this->belongsTo(Teammate::class);
    }
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

    public function resid()
    {
        return $this->belongsTo(Resid::class);
    }
    public function presentresid()
    {
        return $this->belongsTo(Presentresid::class);
    }
    public function aunderwidget()
    {
        return $this->belongsTo(Aunderwidget::class);
    }

    public function getPathAttribute($photo)
    {
        return $this->uploads . $photo;
    }
}
