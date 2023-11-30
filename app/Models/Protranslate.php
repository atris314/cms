<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protranslate extends Model
{
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function teammate()
    {
        return $this->belongsTo(Teammate::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
    public function present()
    {
        return $this->belongsTo(Present::class);
    }
}
