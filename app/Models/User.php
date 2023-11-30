<?php

namespace App\Models;

use App\Models\PurchasedPresent;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
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
        'code',
        'checkid',
        'mobileverified',
        'checktime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
//        'password',
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

    public function walletactions()
    {
        return $this->hasMany(Walletaction::class,'user_id');
    }
    public function purchasedwallets()
    {
        return $this->hasMany(PurchasedWallet::class,'user_id');
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

    public function present()
    {
        return $this->belongsTo(Present::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }
    public function couponpresents()
    {
        return $this->belongsToMany(Couponpresent::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function teammate()
    {
        return $this->belongsTo(Teammate::class);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
   public function subscribes()
   {
       return $this->hasMany(Subscribe::class);
   }
    public function resid()
    {
        return $this->belongsTo(Resid::class);
    }
    public function cancel()
    {
        return $this->belongsTo(Cancel::class);
    }
    public function orderpresent()
    {
        return $this->belongsTo(Orderpresent::class);
    }

    public function change()
    {
        return $this->belongsTo(Change::class);
    }

    public function footballpre()
    {
        return $this->belongsTo(Footballpre::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function isAdmin()
    {
        foreach ($this->roles()->get() as $role){
            if ($role->name == 'مدیر' ){
                return true;
            }
//            if ( $this->status == 1){
//                return true;
//            }
        }
        return false;
    }

    public function isRole()
    {
        foreach ($this->roles()->get() as $role){
            if($role->name == 'پشتیبان' && $this->status == 1){
                return true;
            }
        }
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

//    public function isMobile()
//    {
//        foreach ($this->user as $user){
//            if ($user->mobile){
//                return true;
//            }
//        }
//        return false;
//    }
}
