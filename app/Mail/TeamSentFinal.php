<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamSentFinal extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $work;
    public $user;
    public function __construct($work , $user)
    {
        $this->user = $user;
        $this->work = $work;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Resume-Sent@yabane.ir')
            ->subject('فرم استخدام دریافت شد')
            ->view('mails.teams')->with([
                'username' => $this->user->name ,
                'lastname' =>$this->user->lastname ,
                'code' =>$this->user->code,
                'email' =>$this->user->email ,
                'mobile' =>$this->user->mobile ,
                'phone' =>$this->user->phone ,
                'password' => $this->user->password ,
                'jobs' =>$this->user->jobs ,
                'companyname' =>$this->user->companyname ,
                'postcode' =>$this->user->postcode ,
                'address' =>$this->work->address ,
                'borndate' =>$this->work->borndate,
                'residence' =>$this->work->residence,
                'major' =>$this->work->major,
                'resume' =>$this->work->resume,
                'education' =>$this->work->education,
                'description' =>$this->work->description,
                'fathername' =>$this->work->fathername ,
                'codemeli' =>$this->work->codemeli ,
                'skill' =>$this->work->skill ,
            ]);
    }
}
