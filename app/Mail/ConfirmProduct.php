<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmProduct extends Mailable
{
    use Queueable, SerializesModels;
    private $users;
    private $product;
    private $pack;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($users, $product ,$pack)
    {
        //
        $this->users = $users;
        $this->product = $product;
        $this->pack = $pack;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@yabane.ir')
            ->subject('سفارش شما تایید شد')
            ->view('mails.confirmproduct')->with([
                'usercode' =>$this->users->code,
                'username' =>$this->users->name,
                'code' =>$this->product->codepro,
                'producttitle' =>$this->product->title,
                'packname' => $this->pack->title,
            ]);
    }
}
