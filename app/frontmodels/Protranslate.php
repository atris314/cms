<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protranslate extends Model
{
    use HasFactory;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }




}
