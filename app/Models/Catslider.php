<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catslider extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title','slug','catslider_id','meta_description','meta_keywords','photo_id'];

    public function sumcatorder()
    {
        return $this->hasOne(Catorder::class , 'id' , 'catslider_id')->withDefault(['title'=>'---']);
    }
    public function getChidorder()
    {
        return $this->hasMany(Catorder::class , 'catslider_id');
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
