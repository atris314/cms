<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductAdd extends Notification
{
    use Queueable;
    private $product;

    /**
     * Create a new notification instance.
     *
     * @param $product
     */
    public function __construct($product)
    {
        //
        $this->product = $product;
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
            ->from('yabane-ordersent@yabane.ir', 'وب سایت یابانه')
            ->subject( 'سفارش جدید')
            ->greeting(' مدیر محترم یابانه، سلام؛')
            ->line(' سفارش جدید ثبت شد.' )
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
            'title' => $this->product
        ];
    }
}
