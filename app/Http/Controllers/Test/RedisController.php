<?php
/**
 * Redis 测试
 */

namespace App\Http\Controllers\Test;

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
        $info = Auth::user();
        dump($info['name']);

    }

}
