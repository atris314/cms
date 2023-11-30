<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
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

    public function ticketreply()
    {
        return $this->belongsTo(Ticketreply::class);
    }

}
