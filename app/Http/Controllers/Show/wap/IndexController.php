<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use Jenssegers\Agent\Facades\Agent;

class IndexController extends Controller
{
    public function index()
    {
        // dd(Agent::isMobile());
        // return tz_ajax_echo(Agent::isMobile(),"是否是移动端设备",1);
        curl("https://api.github.com/applications/grants",[]);
        // return tz_ajax_echo($result,"github返回",1);
    }
}
