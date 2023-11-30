<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    public $timestamps = true;

    /**
     * @var string
     */
    public $table = 'orders';

    public $fillable = [
        'api_key',
        'sandbox',
        'name',
        'phone',
        'email',
        'amount',
        'reseller',
        'status',
        'return_id',
        'callback',
        'desc',
        'uuid',
    ];
//    public function getRouteKeyName()
//    {
//        return 'uuid';
//    }

    /**
     * @return HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }

//    /**
//     *  Generate uuid
//     */
//    public static function boot()
//    {
//        parent::boot();
//        self::creating(function ($model) {
//            $model->uuid = Str::uuid()->toString();
//        });
//    }
//
//    /**
//     * @param $value
//     * @return string
//     */
//    public function getApiKeyAttribute($value): string
//    {
//        return Str::mask($value, '*', 3, 30);
//    }
}
