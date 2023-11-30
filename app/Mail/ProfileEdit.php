<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfileEdit extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Profile-complete@yabane.ir')
            ->subject('پروفایل شما تکمیل شد')
            ->view('mails.profile')->with([
                'username' => $this->user->username ,
                'name' =>$this->user->name ,
                'lastname' =>$this->user->lastname ,
                'code' =>$this->user->code ,
                'email' =>$this->user->email ,
                'mobile' =>$this->user->mobile ,
                'phone' =>$this->user->phone ,
                'password' => $this->user->password ,
                'jobs' =>$this->user->jobs ,
                'companyname' =>$this->user->companyname ,
                'postcode' =>$this->user->postcode ,
                'address' =>$this->user->address ,
            ]);
    }
}
