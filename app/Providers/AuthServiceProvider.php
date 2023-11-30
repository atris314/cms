<?php

namespace App\Providers;

use App\frontmodels\Coupon;
use App\Models\Role;
use App\Notifications\Couponsent;
use Ghasedak\GhasedakApi;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\Facades\Notification;


class

AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
         'App\Models\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerAccessGate();

//        VerifyEmail::toMailUsing(function ($notifiable,$url){
//            return (new MailMessage)
//                ->from('yabane-verify@yabane.ir')
//                ->subject('ایمیل فعال سازی حساب کاربری')
//                ->view('notification.verification' ,compact('url'));
//        });





        Gate::define('post-edit',function ($user,$post){
            $username = $user->roles->pluck('name')->first();
            $userrole = $username == 'مدیر';
            $userpost = $user->id == $post->user_id;
            return [$userrole, $userpost];

        });
        Gate::define('isAdmin',function ($user){
            $username = $user->roles->pluck('name')->first();
            return $username == 'مدیر';
        });

        Gate::define('isClient',function ($user){
            $username = $user->roles->pluck('name')->first();
            return $username == 'کاربر عادی';
        });
        Gate::define('isSupport',function($user){
            $username = $user->roles->pluck('name')->first();
            return $username == 'پشتیبان';
        });
        Gate::define('isTeam',function($user){
            $username = $user->roles->pluck('name')->first();
            return $username == 'کارشناس دورکار';
        });

        Gate::define('isAuthor',function($user){
            $username = $user->roles->pluck('name')->first();
            return $username == 'نویسنده';
        });

        Gate::define('isFalse',function($user){
            $username = $user->roles->pluck('name')->first();
            return $username == '';
        });
    }

    private function registerAccessGate()
    {
    }
}
