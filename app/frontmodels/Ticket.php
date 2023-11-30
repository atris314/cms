<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = array('title','user_id','status','ticket_id','catorder_id','priority','message');

    public function catorder()
    {
        return $this->belongsTo(Catorder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
