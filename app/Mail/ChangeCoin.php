<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeCoin extends Mailable
{
    use Queueable, SerializesModels;
    private $couponpresent;
    private $user;

    /**
     * Create a new message instance.
     *
     * @param $couponpresent
     * @param $user
     */
    public function __construct($couponpresent,$user)
    {
        //
        $this->couponpresent = $couponpresent;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('discount-coupon@yabane.ir')
            ->subject('کد تخفیف دریافت شد')
            ->view('mails.changecoin')->with([
                'coupontitle' => $this->couponpresent->title ,
                'couponcode' => $this->couponpresent->code ,
                'couponprice' =>$this->couponpresent->price ,
                'username' =>$this->user->name ,
                'usercode' =>$this->user->code ,
            ]);
    }
}
