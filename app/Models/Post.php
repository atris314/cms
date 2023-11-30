<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

//    protected $casts = ['category_id' => 'array'];

//    protected $fillable = array('title','slug','status','user_id','description','photo_id','meta_description','meta_keywords','category_id');

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class,'post_category','post_id','category_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
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
