<?php
/**
 * 邮件验证队列
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EmailVerify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     * 创建任务
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * 执行任务
     *
     * @return void
     */
    public function handle()
    {
        $mail='568171152@qq.com';  //发送目标邮件地址

        //发送邮件
        Mail::send('emails.deadline', [
            //发送内容
//            'token' => $token,

        ], function ($message) use ($mail) {
            $message->to($mail)->subject('续费提醒');
        });

    }

}
