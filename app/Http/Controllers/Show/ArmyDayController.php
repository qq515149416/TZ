<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ArmyDayController extends Controller
{
    public function index() {
        $tdk = [
            "title" => "周年建军节：军民同庆，共筑强国-高防服务器-游戏专配服务器-防御流量包低至70元起[腾正科技]",
            "keywords" => "服务器租用,服务器最新活动，高防服务器,游戏专配服务器，防御流量包价格，流量叠加包价格",
            "description" => "八一建军节92周年,军民同庆，共筑强国！传奇、游戏、手游、端游专用服务器租用，高防服务器，流量叠加包三重防御大礼包直击全网最低价，网络安全企业首选腾正科技，点击查看活动详情。"
        ];
        return view("http/armyDay",[
            "tdk" => $tdk
        ]);
    }
}
