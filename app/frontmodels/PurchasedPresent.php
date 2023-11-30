<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedPresent extends Model
{
    use HasFactory;
    protected $fillable = [
        'present_id',
        'user_id'
    ];
}
