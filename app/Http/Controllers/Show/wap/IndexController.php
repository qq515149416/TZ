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
        // $result = curl("https://api.github.com/applications/grants",[],1,[
        //     "Accept: application/vnd.github.v3+json",
        //     "User-Agent: qq515149416",
        //     "Authorization: Basic ".base64_encode("qq515149416:as3238841104")
        // ]);
        curl("https://api.github.com/repos/qq515149416/yunfeiIDC",[],1,[
            "Accept: application/vnd.github.v3+json",
            "User-Agent: qq515149416",
            "Authorization: Basic ".base64_encode("qq515149416:as3238841104")
        ]);
        // return tz_ajax_echo($result,"github返回",1);
    }
}
