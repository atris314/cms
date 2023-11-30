<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Postsent extends Notification
{
    use Queueable;
    private $post;

    /**
     * Create a new notification instance.
     *
     * @param $post
     */
    public function __construct($post)
    {
        //
        $this->post = $post;
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
            ->from('info@yabane.ir', 'سامانه ثبت سفارش یابانه')
            ->subject($this->post->title)
            ->greeting(' کاربر گرامی سلام!')
            ->line(' مطلب ' . $this->post->title . ' در سایت یابانه بارگزاری شد. شاید برایتان مفید باشد ')
            ->action($this->post->title, url('/posts/',$this->post->slug))
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
            'title' => $this->post
        ];
    }
}
