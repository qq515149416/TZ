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

class TimeController extends Controller
{

    /**
     * 测试当前时间
     */
    public function time()
    {
        dd(date("Y-m-d H:i:s",time()));
    }

}
