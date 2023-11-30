<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogcat extends Model
{
    use HasFactory;
    use Sluggable;

    public function sumcatwork()
    {
        return $this->hasOne(Catalogcat::class , 'id' , 'catalogcat_id')->withDefault(['title'=>'---']);
    }
    public function getChidwork()
    {
        return $this->hasMany(Catalogcat::class , 'catalogcat_id');
    }


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }
}
