<?php

namespace App\frontmodels;

use App\Models\Product;
use App\Models\Teammate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function teammates()
    {
        return $this->belongsToMany(Teammate::class);
    }
}
