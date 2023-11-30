<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $uploads = '/images/';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function work()
    {
            return $this->belongsTo(Work::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function presentresids()
    {
        return $this->belongsToMany(Presentresid::class);
    }
    public function presents()
    {
        return $this->belongsToMany(Product::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }
    public function resid()
    {
        return $this->belongsTo(Resid::class);
    }
    public function presentresid()
    {
        return $this->belongsTo(Presentresid::class);
    }
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }
    public function aunderwidget()
    {
        return $this->belongsTo(Aunderwidget::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function slideshow()
    {
        return $this->belongsTo(Slideshow::class);
    }
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }
//   public function pack()
//   {
//       return $this->belongsTo(Pack::class);
//   }

    public function getPathAttribute($photo)
    {
        return $this->uploads . $photo;
    }
}
