<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductSentUser extends Mailable
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
    public $photo;
    public $request;
    public function __construct($present , $user , $product , $photo ,$request)
    {
        $this->present = $present;
        $this->user = $user;
        $this->product = $product;
        $this->photo = $photo;
        $this->request = $request;
        //dd($this->present);
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Order-present@yabane.ir')
            ->subject('سفارش شما منبع یابی شد')
            ->view('mails.productsentuser')->with([
                'productphoto' => $this->request->photo_id ,
                'usercode' =>$this->user->code,
                'code' =>$this->product->codepro,
                'faproducttitle' =>$this->product->title,
                'description'=>$this->product->description,
                'deliverytime'=>$this->request->deliverytime,
                'description2'=>$this->request->description,
                'present' =>$this->present,
            ]);
    }
}
