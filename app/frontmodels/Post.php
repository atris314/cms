<?php

namespace App\frontmodels;

use App\Models\Photo;
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
        return $this->belongsTo(User::class);
    }


    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class , 'post_category');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class , 'post_category');
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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function post()
    {
        return $this->hasOne(Post::class,'id','post_id');
    }
}
