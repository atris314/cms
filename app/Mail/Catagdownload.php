<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Catagdownload extends Mailable
{
    use Queueable, SerializesModels;
    private $catalog;

    /**
     * Create a new message instance.
     *
     * @param $catalog
     */
    public function __construct($catalog)
    {
        //
        $this->catalog = $catalog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@yabane.ir')
            ->subject('لینک دانلود:   '  .$this->catalog->title)
            ->view('mails.catalog-download')->with([
                'link' =>$this->catalog->link,
            ]);
    }
}
