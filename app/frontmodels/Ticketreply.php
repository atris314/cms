<?php

namespace App\frontmodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketreply extends Model
{
    use HasFactory;

    public function catorder()
    {
        return $this->belongsTo(Catorder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function teamticket()
    {
        return $this->belongsTo(Teamticket::class);
    }
}
