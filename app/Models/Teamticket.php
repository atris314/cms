<?php

namespace App\Models;

use App\Models\Catorder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teamticket extends Model
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

    public function subticket()
    {
        return $this->hasMany(  Teamticket::class, 'id','subticket');
    }
}
