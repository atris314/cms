<?php

namespace App\frontmodels;

use App\Models\Editpro;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable=['message','product_id'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function editpro()
    {
        return $this->belongsTo(Editpro::class);
    }
}
