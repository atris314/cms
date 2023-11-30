<?php

namespace App\frontmodels;

use App\frontmodels\Catwork;
use App\frontmodels\Group;
use App\frontmodels\Pack;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teammate extends Model
{
    use HasFactory;
    protected $fillable =[ 'borndate' , 'major' ,'residence' , 'resume' , 'education' , 'status' ,
        'description' ,'catwork_id','photo_id','user_id','fathername','codemeli',
        'mobile', 'phone' ,'maritalstatus' ,'skill' ,'lasteducation' ,'catorder_id' ,'product_id' ,'termcheck','address',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
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
    public function product()
    {
        return $this->belongsTo(Product::class);
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
