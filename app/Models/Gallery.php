<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class,'photo_gallery','photo_id','gallery_id');
    }
}
