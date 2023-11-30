<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamConfirm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $team;
    public $user;
    public function __construct($team , $user)
    {
        $this->user = $user;
        $this->team = $team;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Resume-Sent@yabane.ir')
            ->subject('درخواست همکاری شما تایید شد')
            ->view('mails.confirm')->with([
                'username' => $this->user->name ,
                'lastname' =>$this->user->lastname ,
                'code' =>$this->user->code,
            ]);
    }
}
