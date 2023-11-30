<?php

namespace App\Models;

use App\frontmodels\Teamticket;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catorder extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title','slug','catorder_id','meta_description','meta_keywords','photo_id'];

    public function sumcatorder()
    {
        return $this->hasOne(Catorder::class , 'id' , 'catorder_id')->withDefault(['title'=>'---']);
    }
    public function getChidorder()
    {
        return $this->hasMany(Catorder::class , 'catorder_id');
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function teamtickets()
    {
        return $this->belongsTo(Teamticket::class);
    }

    public function teammate()
    {
        return $this->belongsTo(Teammate::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
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
