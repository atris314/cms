<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $reply;
    public $users;
    public $tickets;
    public $user;
    public function __construct($reply , $users ,$tickets,$user)
    {
        $this->reply = $reply;
        $this->users = $users;
        $this->tickets = $tickets;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Ticket-user-reply@yabane.ir')
            ->subject('پاسخ تیکت ارسال شد')
            ->view('mails.replyticket')->with([
                'tickettitle'=> $this->tickets->title ,
                'ticketmessage'=>$this->reply->message ,
                'ticketname'=> $this->users->name,
                'ticketcode' =>$this->tickets->ticket_id,
                'ticketreply' =>$this->user->lastname,
            ]);
    }
}
