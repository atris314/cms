<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Rerequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $product;
    public function __construct($user, $product)
    {
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Order-Rerequest@yabane.ir')
            ->subject('درخواست مجدد سفارش قبلی')
            ->view('mails.rerequest')->with([
                'usercode' =>$this->user->code ,
                'code' =>$this->product->codepro,
                'faproducttitle' =>$this->product->title,
                'description'=>$this->product->description,
                'product'=>$this->product,
            ]);
    }
}
