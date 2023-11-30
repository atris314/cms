<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketTeamAdd extends Notification
{
    use Queueable;
    private $teamticket;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($teamticket)
    {
        //
        $this->teamticket = $teamticket;
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
            ->subject( 'تیکت کارشناس دورکار')
            ->greeting(' مدیر محترم یابانه، سلام؛')
            ->line('تیکت جدید توسط کارشناس دورکار ثبت شد' )
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
            'title' =>$this->teamticket
        ];
    }
}
