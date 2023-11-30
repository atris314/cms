<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pack extends Model
{
    use HasFactory;
    protected $fillable=['photo_id','price','title','description'];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
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
