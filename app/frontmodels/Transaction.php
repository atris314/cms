<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const STATE_NEW             = 'new';
    const STATE_PENDING_PAYMENT = 'pending_payment';
    const STATE_PROCESSING      = 'processing';
    const STATE_COMPLETE        = 'complete';
    const STATE_CLOSED          = 'closed';
    const STATE_CANCELED        = 'canceled';
    const STATE_HOLDED          = 'holded';
    const STATE_PAYMENT_REVIEW  = 'payment_review';
    const STATUS_PENDING        = 1;
    const STATUS_FAILED         = 0;
    const STATUS_SUCCESS        = 2;


    protected $fillable = [
      'payment_id',
      'user_id',
      'product_id',
      'paid',
      'status',
      'invoice_details',
      'transaction_id',
      'transaction_result',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
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
