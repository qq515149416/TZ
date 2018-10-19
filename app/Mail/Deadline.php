<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Deadline extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * 创建一个新的消息实例
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     * 构建消息
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.test');
    }


}
