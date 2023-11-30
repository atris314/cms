<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class releasepriceSentUser extends Mailable
{
    use Queueable, SerializesModels;
    private $present;
    private $user;
    private $product;
    private $request;

    /**
     * Create a new message instance.
     *
     * @param $presents
     * @param $user
     * @param $product
     * @param $photos
     * @param $request
     */
    public function __construct($present , $user, $product , $request)
    {
        //
        $this->present = $present;
        $this->user = $user;
        $this->product = $product;
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
        return $this->from('Order-releasprice@yabane.ir')
            ->subject('هزینه ترخیص کالا')
            ->view('mails.releaspricesentuser')->with([
                'usercode' =>$this->user->code,
                'code' =>$this->product->codepro,
                'present' =>$this->present,
            ]);
    }
}
