<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class linkSurvey extends Mailable
{
    use Queueable, SerializesModels;
    private $linkSurvey;
    private $user;

    /**
     * Create a new message instance.
     *
     * @param $linkSurvey
     * @param $user
     */
    public function __construct($linkSurvey, $user)
    {
        //
        $this->linkSurvey = $linkSurvey;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('linkSurvey@yabane.ir')
            ->subject('نظر سنجی یابانه')
            ->view('mails.linkSurvey')->with([
                'linkSurvey' => $this->linkSurvey ,
                'username' =>$this->user->name ,
                'usercode' =>$this->user->code ,
            ]);
    }
}
