<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editpro extends Model
{
    use HasFactory;
    protected $casts = ['photos' => 'array'];
    public function photos()
    {
        return $this->belongsTo(Photo::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

}
