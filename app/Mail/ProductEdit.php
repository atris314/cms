<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductEdit extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $product;
    public $pack;
    public $catorder;
    public function __construct($user, $product ,$pack ,$catorder)
    {
        $this->user = $user;
        $this->product = $product;
        $this->pack = $pack;
        $this->catorder = $catorder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Order-Edit@yabane.ir')
            ->subject('سفارش شما ویرایش شد')
            ->view('mails.productedit')->with([
                'usercode' =>$this->user->code,
                'username' =>$this->user->name,
                'code' =>$this->product->codepro,
                'producttitle' =>$this->product->title,
                'description'=>$this->product->description,
                'packname' => $this->pack->title,
                'packdes' => $this->pack->description,
                'catorder' => $this->catorder,
            ]);
    }
}
