<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Demo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '这是一个demo';

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
        //
        $this->send();
    }

    public function send()
    {


        $data['email']   = '568171152@qq.com';
        $data['subject'] = '腾正科技';

        Mail::send('emails.test', [
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
