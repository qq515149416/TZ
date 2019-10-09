<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class CompanyIntroductionController extends Controller
{
    public function index($page)
    {
        $page_info = [
            "company_introduction" => [
                "name" => "公司简介"
            ],
            "news" => [
                "name" => "新闻公告"
            ],
            "honor" => [
                "name" => "荣誉资质"
            ],
            "culture" => [
                "name" => "企业文化"
            ],
            "progress" => [
                "name" => "发展历程"
            ],
            "contact" => [
                "name" => "联系我们"
            ],
            "pay" => [
                "name" => "支付中心"
            ]
        ];
        return view("wap/company_introduction",[
            "page" => $page,
            "page_info" => $page_info
        ]);
    }
}
