<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    public $fillable = [
        'step',
        'request',
        'response',
        'http_code',
        'request_time',
    ];

    /**
     * @return string
     */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function present()
    {
        return $this->belongsTo(Present::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
//    public function getMaskApiKeyAttribute(): string
//    {
//        return Str::mask($this->request->API_KEY, '*', 3, 30);
//    }
//
//    /**
//     * @param $value
//     *
//     * @return mixed
//     */
//    public function getRequestAttribute($value)
//    {
//        return json_decode($value);
//    }

}
