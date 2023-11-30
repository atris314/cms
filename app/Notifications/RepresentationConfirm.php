<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RepresentationConfirm extends Notification
{
    use Queueable;
    private $representation;

    /**
     * Create a new notification instance.
     *
     * @param $representation
     */
    public function __construct($representation)
    {
        //
        $this->representation = $representation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->from('yabane-representation-confirm@yabane.ir', 'سامانه ثبت سفارش یابانه')
            ->subject("تایید درخواست نمایندگی")
            ->greeting('کاربر گرامی سلام!')
            ->line('درخواست نمایندگی شما توسط مدیر یابانه تایید شد. می توانید وارد بخش کاربری شوید.')
            ->action('ورود/ثبت نام', url('/'))
            ->line('ایمیل شما: ' . $this->representation->email)
            ->line('از اینکه یابانه را انتخاب کرده اید، متشکریم.');
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
            //
        ];
    }
}
