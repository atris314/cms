<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifySubscribers
{
    private $reply;

    /**
     * Create the event listener.
     *
     * @param $reply
     */
    public function __construct($reply)
    {

        $this->reply = $reply;
    }


    public function handle(ThreadReceivedNewReply $event)
    {
        $this->reply->thread->subscriptions
            ->where('user_id' , '!=' , $this->reply->user_id)
            ->each
            ->notify($this->reply);
    }
}
