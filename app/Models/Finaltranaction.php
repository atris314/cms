<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finaltranaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'user_id',
        'present_id',
        'paid',
        'status',
        'invoice_details',
        'transaction_id',
        'transaction_result',
    ];
    public function present()
    {
        return $this->belongsTo(Present::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function setInvoiceDetailsAttribute($value)
    {
        $this->attributes['invoice_details'] = serialize($value);
    }
    public function getInvoiceDetailsAttribute()
    {
        return unserialize($this->attributes['invoice_details']);
    }

    public function setTransactionResultAttribute($value)
    {
        $this->attributes['transaction_result'] = serialize($value);
    }
    public function getTransactionResultAttribute()
    {
        return unserialize($this->attributes['transaction_result']);
    }
}
