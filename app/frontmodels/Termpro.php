<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termpro extends Model
{
    use HasFactory;
    protected $fillable=['title','body'];
}
