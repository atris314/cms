<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamRequest extends Notification
{
    use Queueable;
    private $teammate;

    /**
     * Create a new notification instance.
     *
     * @param $teammate
     */
    public function __construct($teammate)
    {
        //
        $this->teammate = $teammate;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('info@yabane.ir', 'وب سایت یابانه')
            ->subject( 'درخواست همکاری')
            ->greeting(' مدیر محترم یابانه، سلام؛')
            ->line('رزومه جدید برای درخواست همکاری ثبت شد ' )
            ->line('وب سایت یابانه');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' =>$this->teammate
        ];
    }
}
