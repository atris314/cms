<?php

namespace App\frontmodels;

use App\frontmodels\Catorder;
use App\frontmodels\User;
use App\frontmodels\Ticketreply;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teamticket extends Model
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
    public function ticketreply()
    {
        return $this->belongsTo(Ticketreply::class);
    }
}
