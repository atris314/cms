<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Couponsent extends Mailable
{
    use Queueable, SerializesModels;
    private $coupon;
    private $user;

    /**
     * Create a new message instance.
     *
     * @param $coupon
     * @param $user
     */
    public function __construct($coupon,$user)
    {
        //
        $this->coupon = $coupon;
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
            ->subject('کد تخفیف یابانه')
            ->view('mails.coupons')->with([
                'coupontitle' => $this->coupon->title ,
                'couponcode' => $this->coupon->code ,
                'couponprice' =>$this->coupon->price ,
                'username' =>$this->user->name ,
                'usercode' =>$this->user->code ,
            ]);
    }
}
