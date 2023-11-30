<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailResetPasswordToken extends Notification
{
    use Queueable;
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
                    ->from('yabane-reset-password@yabane.ir', 'سامانه ثبت سفارش یابانه')
                    ->subject("بازیابی رمز عبور")
                    ->greeting('کاربر گرامی سلام!')
                    ->line('برای بازیابی رمز عبور بر روی دکمه زیر کلیک کنید')
                    ->action('بازیابی رمز عبور', url('password/reset',$this->token))
                    ->line('از اینکه وب سایت یابانه را انتخاب نموده اید سپاسگزاریم!');
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
