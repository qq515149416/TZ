<?php

namespace App\Console\Commands;

use App\Admin\Models\Business\BusinessModel;
use App\Http\Models\TzUser;
use Illuminate\Console\Command;
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
            $userData = $tzUserModel->find($value['client_id']);   //获取用户数据  (主要是用户邮箱)


        }


//        $this->sendEmail();

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
//        $businessModel = new BusinessModel(); //实例化
//        $tzUserModel   = new TzUser();

        //===================测试数据================
        $sendData['subject'] = '腾正科技';

        //===================================


        Mail::send('emails.test', [
            //发送内容
//            'userName'    => $data['userName'],     //用户名
//            'exampleType' => $data['exampleType'],  //实例类型
//            'exampleId'   => $data['exampleId'],    //实例ID
//            'deadLine'    => $data['deadLine '],    //到期时间
        ], function ($message) use ($sendData) {
            $message->to($sendData['email'])->subject($sendData['subject']);
        });


    }
}
