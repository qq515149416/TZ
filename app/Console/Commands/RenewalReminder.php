<?php

namespace App\Console\Commands;

use App\Admin\Models\Business\BusinessModel;
use App\Http\Models\TzUser;
use App\Mail\Deadline;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RenewalReminder extends Command
{
    /**
     * The name and signature of the console command.
     * php artisan  命令
     * @var string
     */
    protected $signature = 'business:send-email-notice';

    /**
     * The console command description.
     * 命令描述
     * @var string
     */
    protected $description = '向所有即将过期业务发送提醒邮件';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tzUserModel = new TzUser();    //实例化
        $data        = $this->selectOverdueBusiness(); //查询过期业务

        //遍历所有将要过期业务
        foreach ($data as $key => $value) {
            $userData = $tzUserModel->find($value['client_id']);   //获取用户数据  (主要是用户的邮箱)  $userData['email']

            //拼装发送邮件数组
            $sendData = [
                'email'     => $userData['email'], //发送用户的邮箱地址
                'subject'   => '腾正科技',   //邮件标题
                'userName'  => $userData['email'],     //用户名
//                'exampleType' => $userData['exampleType'],  //实例类型   (暂时不用)
                'exampleId' => $value['machine_number'],    //实例ID
                'deadline'  => $value['endding_time']   //到期时间
            ];

            $this->sendEmail($sendData); //发送邮件

        }
        Log::channel('RenewalReminder')->info('完成一次批量提醒');  //写入日志文件

    }

    /**
     * 查询过期业务
     */
    public function selectOverdueBusiness()
    {
        $businessModel = new BusinessModel(); //实例化
        return $businessModel->selectOverdueBusiness();

    }

    /**
     * 发送邮件
     */
    public function sendEmail($sendData = null)
    {
//        //发送邮件
//        Mail::send('emails.deadline', [
//            //发送内容
//            'userName'    => $sendData['userName'],     //用户名
////            'exampleType' => $sendData['exampleType'],  //实例类型
//            'exampleId'   => $sendData['exampleId'],    //实例ID
//            'deadline'    => $sendData['deadline'],    //到期时间
//        ], function ($message) use ($sendData) {
//            $message->to($sendData['email'])->subject($sendData['subject']);
//        });

        Mail::to($sendData['email'])
            ->queue(new Deadline($sendData));

    }
}
