<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $ticket;
    public $users;
    public $code;
    public function __construct($ticket , $users,$code)
    {
        $this->ticket = $ticket;
        $this->users = $users;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Ticket-user@yabane.ir')
            ->subject('تیکت شما دریافت شد')
            ->view('mails.ticket')->with([
                'tickettitle'=> $this->ticket->title ,
                'ticketmessage'=>$this->ticket->message ,
                'ticketname'=> $this->users->name,
                'usercode'=> $this->users->code,
                'ticketcode' =>$this->code
            ]);
    }
}
