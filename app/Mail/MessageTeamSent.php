<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageTeamSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $products;
    public $user;
    public $request;
    public $product;
    public $msg;
    public function __construct($products , $user , $request , $product ,$msg)
    {
        $this->products = $products;
        $this->user = $user;
        $this->request = $request;
        $this->product = $product;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->msg->message);
        return $this->from('checking-Order@yabane.ir')
            ->subject('تکمیل اطلاعات سفارش')
            ->view('mails.messagepro')->with([
                'username' => $this->user->name ,
                'lastname' =>$this->user->lastname ,
                'code' =>$this->user->code,
                'procode' =>$this->request->codepro,
                'product' =>$this->product->id,
                'textbody' =>$this->msg->message,
            ]);

    }
}
