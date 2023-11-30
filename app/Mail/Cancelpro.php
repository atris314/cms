<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Cancelpro extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $present;
    public $user;
    public $product;
    public function __construct($present , $user, $product)
    {
        $this->user = $user;
        $this->present = $present;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Order-Cancle@yabane.ir')
            ->subject('انصراف کاربر از پرداخت و تکمیل سفارش')
            ->view('mails.canclepro')->with([
                'usercode' =>$this->user->code ,
                'code' =>$this->product->codepro,
                'faproducttitle' =>$this->product->title,
            ]);
    }
}
