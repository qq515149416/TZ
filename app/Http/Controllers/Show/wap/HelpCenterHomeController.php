<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class HelpCenterHomeController extends Controller
{
    public function index($page)
    {
        $page_info = [
            "Linux_server" => [
                "name" => "Linux服务器"
            ],
            "Windows_server" => [
                "name" => "Windows服务器",
            ],
            "server_rent" => [
                "name" => "服务器租用"
            ],
            "server_hosting" => [
                "name" => "服务器托管"
            ],
            "high_server" => [
                "name" => "高防服务器"
            ],
            "DDOS_height_ip" => [
                "name" => "DDOS高防IP"
            ],
            "cabinet_rent" => [
                "name" => "机柜租用"
            ],
            "broadband_rent" => [
                "name" => "大带宽租用"
            ],
            "network_security" => [
                "name" => "网络安全"
            ],
            "CDN_speed" => [
                "name" => "CDN加速"
            ],
            "height_CDN" => [
                "name" => "高防CDN"
            ],
            "cloud_hosting" => [
                "name" => "云主机"
            ],
            "C_shield" => [
                "name" => "防C盾"
            ],
            "solution" => [
                "name" => "解决方案"
            ],
            "operations" => [
                "name" => "运维咨询"
            ],
            "online_game" => [
                "name" => "网游咨询"
            ],
            "web_site" => [
                "name" => "网站备案"
            ],
            "newbie_guide" => [
                "name" => "新手指南"
            ],
            "problem" => [
                "name" => "常见问题"
            ],
        ];
        return view("wap/help_center_home",[
            "page" => $page,
            "page_info" => $page_info
        ]);
    }
}
