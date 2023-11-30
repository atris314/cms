<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Emailmarke extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $emailmarketing;
    public $photo;

    /**
     * Create a new message instance.
     *
     * @param $emailmarketing
     */
    public function __construct($emailmarketing,$photo)
    {
        $this->emailmarketing = $emailmarketing;

        $this->photo = $photo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('marketing@yabane.ir',$this->emailmarketing->fromname)
            ->subject($this->emailmarketing->subject)
            ->view('mails.emailmarketing')->with([
                'photo' => $this->photo ,
                'title' =>$this->emailmarketing->title,
                'body'=>$this->emailmarketing->body,
            ]);
    }
}
