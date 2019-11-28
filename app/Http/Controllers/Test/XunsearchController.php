<?php
/**
 * 迅搜测试测试
 */

namespace App\Http\Controllers\Test;

use App\Jobs\Demo;
use App\Jobs\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class XunsearchController extends Controller
{

    /**
     * 获取登陆用户状态
     */
    public function test()
    {
        dump('User');
    }
}
