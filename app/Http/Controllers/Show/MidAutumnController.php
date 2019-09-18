<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class MidAutumnController extends Controller
{
    public function index()
    {
        return view("http/midAutumn",[
            "tdk" => [
                "title" => "迎中秋庆国庆，腾正科技四重大礼钜惠全网：高防服务器高防IP买一送一，新品一律5折 [腾正科技]",
                "keywords" => "高防服务器,高防IP，高防服务器价格,游戏专配服务器，防御流量包价格，流量叠加包价格",
                "description" => "迎中秋庆国庆，腾正科技四重大礼钜惠全网。优惠一：买高防IP，送WAF 1个月；优惠二：买高防服务器，送100G防御流量叠加包；优惠三：一键商城系统5折特惠，助力搭建属于你的电商平台；优惠四：新注册用户10G防御云主机66元包月，送20M带宽，续费价格不变。"
            ]
        ]);
    }
}
