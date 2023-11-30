<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['title','catorder_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function catorder()
    {
        return $this->belongsTo(Catorder::class);
    }
    public function teammates()
    {
        return $this->belongsToMany(Teammate::class);
    }

    /**
     * @return array
     */
}
