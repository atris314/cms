<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PresentPurchaseAdd extends Notification
{
    use Queueable;
    private $present;

    /**
     * Create a new notification instance.
     *
     * @param $present
     */
    public function __construct($present)
    {
        //
        $this->present = $present;
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
            ->subject( 'پرداخت')
            ->greeting(' مدیر محترم یابانه، سلام؛')
            ->line('سفارش آماده شده، توسط کاربر پرداخت نهایی شد ' )
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
            'title' =>$this->present
        ];
    }
}
