<?php

namespace App\Http\Controllers\Test;

use App\Console\Commands\OverdueAlterStatus;
use App\Http\Models\TzUser;
use App\Mail\Deadline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{


    /**
     *
     */
    public function handle()
    {
//            dump(md5(123456));
//        $testM= new OverdueAlterStatus();
//        dump($testM->selectOverdue());

//        dump($testM->alterStatus());


        $sendData['test'] = 'susu';

        Mail::send('emails.' . 'test', [
            //发送内容
//            'token' => $token,
//            'userName'    => $data['userName'],     //用户名
//            'exampleType' => $data['exampleType'],  //实例类型
//            'exampleId'   => $data['exampleId'],    //实例ID
//            'deadLine'    => $data['deadLine '],    //到期时间
        ], function ($message) {
            $message->to('15812816866@qq.com')->subject('测试');
        });

//        Demo::dispatch('123');
//        die();
//         return '123';
//        Redis::set('name', 'guwenjie');
//        $values = Redis::get('name');
//        dd($values);

//       $data = array('jj'=>31);

//        $data->21321 = '234';
//        $data[]=3123;

//        $m = new Deadline(1);
//        $res = Mail::to('568171152@qq.com')
//            ->queue($m);
//        dump($res);
//        dump('su');
//        return '242';
    }


}