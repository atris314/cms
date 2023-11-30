<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCoupon extends Notification
{
    use Queueable;
    private $coupon;

    /**
     * Create a new notification instance.
     *
     * @param $coupon
     */
    public function __construct($coupon)
    {
        //
        $this->coupon = $coupon;
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
            ->from('yabane-discount-coupon@yabane.ir', 'سامانه ثبت سفارش یابانه')
            ->subject("کد تخفیف منبع یابی")
            ->greeting('کاربر گرامی سلام!')
            ->line('کد تخفیف ثبت سفارش یابانه برای شما ارسال شد. توجه داشته باشید که کد تخفیف یک بار مصرف می باشد.')
            ->action($this->coupon->code, url('#'))
            ->line('کد تخفیف : ' . $this->coupon->code)
            ->line('مبلغ تخفیف : ' . $this->coupon->price)
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
