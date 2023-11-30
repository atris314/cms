<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $contact;
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Contact-form@yabane.ir')
            ->subject('تماس شما دریافت شد')
            ->view('mails.contact')->with([
                'contactsubject' => $this->contact->subject ,
                'contactbody' =>$this->contact->body ,
                'contactname' =>$this->contact->name ,
            ]);
    }
}
