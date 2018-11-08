<?php

namespace App\Http\Controllers\DefenseIp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * 测试方法
     */
    public function test()
    {
        dump('susu');

        dump(config('tz_defense_ip.host'));

    }
}
