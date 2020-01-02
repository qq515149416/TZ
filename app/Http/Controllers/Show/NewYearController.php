<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class NewYearController extends Controller
{
    public function index()
    {
        return view("http/new_year",[
            "tdk" => [
                "title" => "IDC服务提供商腾正科技2020迎新感恩回馈：企业级物理机-高防服务器-云主机低至99[腾正科技]",
                "keywords" => "高防服务器,服务器最新活动，云主机，经济型云主机，企业级物理机,游戏专配服务器，平台网站服务器，服务器价格",
                "description" => "IDC服务提供商腾正科技2020迎新感恩回馈，重重大礼贺新响不停！大礼1）经济型、高防型云主机低至99元/月，买3月送1月，多买多送；大礼2）企业级、平台网站、棋牌、手游、端游等游戏高配物理服务器、高防服务器买9月送3月送产权，价格低至888元/月。超值聚划算，点击查看活动详情！"
            ]
        ]);
    }
}
