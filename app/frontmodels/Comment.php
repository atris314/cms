<?php

namespace App\frontmodels;

use App\frontmodels\Post;
use App\frontmodels\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','email','status'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'id','parent_id');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
