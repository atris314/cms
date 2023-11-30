<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductConfirm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $protranslate;
    public $user;
    public $product;
    public $photo;
    public $catorder;
    public $pack;
    public $packtitle;
    public function __construct($protranslate , $user , $product , $photo , $catorder,$pack , $packtitle)
    {
        $this->protranslate = $protranslate;
        $this->user = $user;
        $this->product = $product;
        $this->photo = $photo;
        $this->catorder = $catorder;
        $this->pack = $pack;
        $this->packtitle = $packtitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Order-Sent@yabane.ir','yabane Company')
            ->subject('Final Orders Were Sent')
            ->view('mails.productsent')->with([
                'productphoto' => $this->photo ,
                'code' =>$this->product->codepro,
                'number' =>$this->product->number,
                'pack' =>$this->pack->title,
                'description'=>$this->product->description,
                'endescription'=>$this->protranslate->description,
            ]);
    }
}
