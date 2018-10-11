<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class Email implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     * 创建任务
     *
     * @return void
     */
    public function __construct($podcast)
    {
        //
        $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     * 执行任务
     *
     * 邮件参数:
     *  emailTemplate:  选用的邮箱模板
     *  email:         目标邮箱
     *  subject        :邮件主题
     *  data:[       模板中的参数
     *      userName     : 用户名
     *      exampleType  : 实例类型
     *      exampleId    : 实例ID
     *      deadLine     : 到期时间
     * ]
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->podcast;  //获取邮件参数

        //发送邮件
        Mail::send('emails.' . $data['emailTemplate'], [
            //发送内容
//            'token' => $token,
//            'userName'    => $data['userName'],     //用户名
//            'exampleType' => $data['exampleType'],  //实例类型
//            'exampleId'   => $data['exampleId'],    //实例ID
//            'deadLine'    => $data['deadLine '],    //到期时间
        ], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['subject']);
        });


    }
}
