<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loguser extends Model
{
    use HasFactory;
    protected $fillable = ['ip','agent','route','login','user_id'];
}
