<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class YunController extends Controller
{
    public function index($page)
    {
        $data = [
            "title" => "专业的云计算服务以及云解决方案提供商[腾正科技]",
            "keywords" => "云计算，云计算服务器,云解决方案提供商,云服务器租用,云主机租用,高防云服务器,CDN，云数据库，云存储",
            "description" => "腾正云专业的云计算服务及云解决方案提供商，为企业用户提供云服务器、云主机、高防云服务器、云服务器租用、云主机租用、CDN、云数据库、云存储、大数据等全方位服务"
        ];
        return view("http/yun",[
            "data" => $data,
            "page" => $page
        ]);
    }
}
