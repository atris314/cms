<?php

namespace App\frontmodels;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catwork extends Model
{
    use HasFactory;
    use Sluggable;

    public function sumcatwork()
    {
        return $this->hasOne(Catwork::class , 'id' , 'catorder_id')->withDefault(['title'=>'---']);
    }
    public function getChidwork()
    {
        return $this->hasMany(Catwork::class , 'catorder_id');
    }

    public function teammates()
    {
        return $this->belongsToMany(Teammate::class);
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
