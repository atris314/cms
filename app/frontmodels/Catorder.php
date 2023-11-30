<?php

namespace App\frontmodels;

use App\Models\Group;
use App\Models\Ticket;
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


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function tickets()
    {
        return $this->belongsTo(Ticket::class);
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
