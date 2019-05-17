<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class DataCenterController extends Controller
{
    public function index($page)
    {
        $data = [
            "huizhou" => [
                "level" => "国家<strong>AAAAA</strong>级机房",
                "area" => "8000 平方米",
                "total" => "1288 个，42U 国际标准机柜",
                "bandwidth" => "860G 直连中国电信骨干网"
            ]
        ];
        return view("http/datacenter");
    }
}
