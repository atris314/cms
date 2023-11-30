<?php

namespace App\Models;

use App\Models\Catorder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teammate extends Model
{
    use HasFactory;
    protected $fillable =[ 'borndate' , 'major' ,'residence' , 'resume' , 'education' , 'status' ,
        'description' ,'catwork_id','photo_id','user_id','fathername','codemeli',
        'mobile', 'phone' ,'maritalstatus' ,'skill' ,'lasteducation' ,'catorder_id' ,'product_id' ,'termcheck','address', 'validate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function catwork()
    {
        return $this->belongsTo(Catwork::class);
    }
    public function catorder()
    {
        return $this->belongsTo(Catorder::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function protranslate()
    {
        return $this->belongsTo(Protranslate::class);
    }
    public function present()
    {
        return $this->belongsTo(Present::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class , 'group_teammate' , 'teammate_id' , 'group_id');
    }
    public function packs()
    {
        return $this->belongsToMany(Pack::class , 'pack_teammate' , 'teammate_id' , 'pack_id');
    }
}
