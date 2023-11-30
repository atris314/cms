<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RepresentationConfirm extends Mailable
{
    use Queueable, SerializesModels;
    private $representation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($representation)
    {
        //
        $this->representation = $representation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('yabane-representation-confirm@yabane.ir')
            ->subject('درخواست نمایندگی شما تایید شد.')
            ->view('mails.representation')->with([
                'email' =>$this->representation->email,
                'name' =>$this->representation->name,
                'phone' =>$this->representation->phone,
                'description' =>$this->representation->description,
            ]);
    }
}
