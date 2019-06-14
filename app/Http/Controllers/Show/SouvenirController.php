<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class SouvenirController extends Controller
{
    public function index() {
        $tdk = [
            "title" => "同行五载，感恩钜惠[腾正科技]",
            "keywords" => "云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技",
            "description" => "特惠三重大礼畅游全网助力业务飞升"
        ];
        return view("http/souvenir",[
            "tdk" => $tdk
        ]);
    }
}
