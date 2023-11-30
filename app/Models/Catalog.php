<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;
    use Sluggable;

    public function catalogcat()
    {
        return $this->belongsTo(Catalogcat::class);
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
    public function catuser()
    {
        return $this->belongsTo(Catuser::class);
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
}
