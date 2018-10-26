<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Deadline extends Mailable
{
    use Queueable, SerializesModels;

    protected $sendData;

    /**
     * Create a new message instance.
     * 创建一个新的消息实例
     *
     * @return void
     */
    public function __construct($sendData)
    {
        //
        $this->sendData = $sendData;
    }

    /**
     * Build the message.
     * 构建消息
     *
     * @return $this
     */
    public function build()
    {


        return $this->view('emails.deadline')
            ->subject('腾正科技')
            ->with([
                'userName'  => $this->sendData['userName'],     //用户名
//            'exampleType' => $this->sendData['exampleType'],  //实例类型
                'exampleId' => $this->sendData['exampleId'],    //实例ID
                'deadline'  => $this->sendData['deadline'],    //到期时间
            ]);
    }
}
