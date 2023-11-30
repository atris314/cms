<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
