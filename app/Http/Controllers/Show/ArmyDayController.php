<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ArmyDayController extends Controller
{
    public function index() {
        $tdk = [
            "title" => "没有网络安全 就没有国家安全",
            "keywords" => "安全,网络,国家",
            "description" => "没有网络安全就没有国家安全,八一建军节92周年1927-2019,军民同庆，共筑强国,高防服务器·防御流量包低至70元起"
        ];
        return view("http/armyDay",[
            "tdk" => $tdk
        ]);
    }
}
