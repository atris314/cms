<?php

namespace App\frontmodels;

use App\Models\Email;
use App\Models\Resid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Present extends Model
{
    use HasFactory;
    protected $fillable=['deliverytime','price','description','product_id','user_id','productcode'];

    public function photos()
    {
        return $this->belongsTomany(Photo::class);
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
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

    public function presentresid()
    {
        return $this->belongsTo(Presentresid::class);
    }
}
