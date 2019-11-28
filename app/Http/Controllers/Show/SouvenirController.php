<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class SouvenirController extends Controller
{
    public function index() {
        $tdk = [
            "title" => "腾正科技5周年庆感恩钜惠-企业服务器租用，高防服务器，流量叠加包直击全网最低价",
            "keywords" => "服务器租用,服务器最新活动，高防服务器,游戏专配服务器，防御流量包价格，流量叠加包价格",
            "description" => "腾正科技5周年庆感恩钜惠,私服、游戏、企业专用服务器租用，高防服务器，流量叠加包三重大礼包直击全网最低价，本次活动一年仅有一次，错过再等一年，点击查看活动详情。"
        ];
        return view("http/souvenir",[
            "tdk" => $tdk
        ]);
    }
}
