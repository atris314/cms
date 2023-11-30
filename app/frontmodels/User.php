<?php

namespace App\frontmodels;

use App\frontmodels\Coupon;
use App\frontmodels\Product;
use App\frontmodels\PurchasedProduct;
use App\frontmodels\Role;
use App\frontmodels\PurchasedPresent;
use App\frontmodels\Finaltranaction;
use App\Models\Ticket;
use App\frontmodels\Transaction;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'lastname',
        'email',
        'password',
        'mobile',
        'phone',
        'jobs',
        'companyname',
        'postcode',
        'address',
        'rate',
        'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class,'user_id');
    }
    public function purchasedproducts()
    {
        return $this->hasMany(PurchasedProduct::class,'user_id');
    }

    public function presentactions()
    {
        return $this->hasMany(Presentaction::class,'user_id');
    }

    public function purchasedpresents()
    {
        return $this->hasMany(PurchasedPresent::class,'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function teammate()
    {
        return $this->belongsTo(Teammate::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function teamticket()
    {
        return $this->belongsTo(Teamticket::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function isAdmin()
    {
        foreach ($this->roles()->get() as $role){
            if ($role->name == 'مدیر' && $this->status == 1){
                return true;
            }
        }
        return false;
    }
    public function isClient()
    {
        foreach ($this->roles()->get() as $role){
            if ($role->name == 'کاربر عادی'){
                return true;
            }
        }
        return false;
    }
}
