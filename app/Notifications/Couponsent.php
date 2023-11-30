<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\RayganSms\RayganSmsChannel;
use NotificationChannels\RayganSms\TextMessage;

class Couponsent extends Notification
{
    use Queueable;
    private $coupon;

    /**
     * Create a new notification instance.
     *
     * @return void
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
        return ['mail',RayganSmsChannel::class];
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
                    ->subject("کد تخفیف")
                    ->greeting('کاربر گرامی سلام!')
                    ->line('کد تخفیف ثبت سفارش یابانه برای شما ارسال شد. توجه داشته باشید که کد تخفیف یک بار مصرف می باشد.')
                    ->action($this->coupon->code, url('#',$this->coupon))
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


    public function toRayganSms($notifiable)
    {
        return (new TextMessage)
            ->content("پروفایل شما تکمیل شد");
    }
}
