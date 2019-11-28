<?php
/**
 * Redis 测试
 */

namespace App\Http\Controllers\Test;

use App\Jobs\Demo;
use App\Jobs\Email;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class TimeController extends Controller
{

    /**
     * 测试当前时间
     */
    public function time()
    {

        dump(date('Y-m-d', strtotime('+1 month', strtotime('2019-01-30'))));

//        $nowTime  = new DateTime("2019-01-30");
        $nowTime = new \DateTime('2019-01-30');
        $interval = \DateInterval::createFromDateString('+1 month');
        $nowTime->add($interval);
        dump($nowTime->format('Y-m-d H:i:s'));

//        dd(date("Y-m-d H:i:s",time()));

        dump(Carbon::parse('2019-01-30')->addMonth(1));
        echo Carbon::now();
        $timeM = Carbon::now();
//        dump($dataM);
        dump($timeM);
    }

}
