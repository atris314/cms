<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\NotificationServiceProvider;

class LogVerifiedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $user;
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $this->user->where('user',Auth::user());
        Auth::check();
    }
}
