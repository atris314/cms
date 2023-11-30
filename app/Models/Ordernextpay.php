<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordernextpay extends Model
{
    use HasFactory;
    public $timestamps = true;

    public $table = 'ordernextpays';
    public $fillable = [
        'api_key',
        'user_id',
        'payer_name',
        'customer_phone',
        'amount',
        'callback_uri',
        'payer_desc',
        'uuid',
    ];
    public function nextpayments()
    {
        return $this->hasMany(Nextpayment::class, 'order_id', 'id');
    }
}
