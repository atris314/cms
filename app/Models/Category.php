<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title','slug','category_id','meta_description','meta_keywords'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function sumcat()
    {
        return $this->hasOne(Category::class , 'id' , 'category_id')->withDefault(['title'=>'---']);
    }
    public function getChid()
    {
        return $this->hasMany(Category::class , 'category_id');
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
