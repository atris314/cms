<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $fillable= ['name','email'];

    public function present()
    {
        return $this->belongsTo(Present::class);
    }


}
