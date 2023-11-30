<?php

namespace App\Listeners;

use App\Events\Activation;
use App\frontmodels\Coupon;
use App\Mail\Couponsent;
use Ghasedak\GhasedakApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserActivation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Activation  $event
     * @return void
     */
    public function handle(Activation $event)
    {
        $user = $event->user;
        $coupon = $event->coupon;
        Mail::to($user->email)->send(new Couponsent($coupon,$user));
        $site = 'yabane.ir';
        if ($user->mobile){
            try{
                $receptor = $user->mobile;
                $type = 1;
                $template = "activeCode";
//                $param1 = $user->name;
                $param1 = $user->checkid;
                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                $api->Verify($receptor, $type, $template, $param1);
            }
            catch(\Ghasedak\Exceptions\ApiException $e){
                echo $e->errorMessage();
            }
            catch(\Ghasedak\Exceptions\HttpException $e){
                echo $e->errorMessage();
            }
        }
    }
}
