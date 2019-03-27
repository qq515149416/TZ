<?php
/**
 * Redis 测试
 */

namespace App\Http\Controllers\Test;

use App\Jobs\Demo;
use App\Jobs\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class RedisController extends Controller
{

    /**
     * 测试Redis Controller
     */
    public function test()
    {
        //存入Redis   键:name   值:123456

//        Redis::set('name', '123456        $data = Redis::get('name');
//        $data2 = Redis::info();
//        dump($data);
//        dump($data2);
//        dump('Redis');
//        dump('Test');//
//        $info = Auth::user();
//        dump($info['name']);
//        $podcast=99999999;

        $podcast['emailTemplate'] = 'deadline';
        $podcast['email']         = '1227680727@qq.com';
        $podcast['subject']       = '腾正科技【续费提醒】';
        $podcast['data']          = null;

//        Demo::dispatch($podcast)->delay(now()->addMinutes(1));
//        Demo::dispatch($podcast);
//        for ($x=0; $x<=100; $x++) {
//            Email::dispatch($podcast);
//        }

        Email::dispatch($podcast);


    }


    /**
     * 测试Redis
     */
    public function test2()
    {

        $redis = Redis::connection('host_flow');
//        dump($redis->info());



//        $redis->hset('hash1:001', 'key1', 'v1');  //将key为'key1' value为'v1'的元素存入hash1表


        die();

        $mkv = array(
            'a:0001' => 'First user',
            'a:0002' => 'Second user',
            'a:0003' => 'Third user'
        );
        $redis->mset($mkv);  // 存储多个 key 对应的 value
        $retval = $redis -> mget (array_keys( $mkv));  //获取多个key对应的value

        dump($retval);

//        $redis->set('name', 'guwenjie');
//        $values = $redis->get('name');
//        dd($values);

    }


}
