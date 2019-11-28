<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    public function index($page)
    {
        switch($page) {
            case "index":
                $tdk = [
                    "title" => "公司介绍-关于我们-专业IDC服务商[腾正科技]",
                    "description" => "腾正科技，一家专注于互联网安全技术研究的现代网络综合服务性的高科技公司，产品线涵盖IDC数据中心，数据安全，云计算，DNS&CDN，系统研发，电商平台基础支撑等领域。建立了以华南的广东、华中的湖南、西部的西安、东北的浙江四大核心数据中心及多个IDC节点，服务的企业遍布各个行业。",
                    "keywords" => "IDC服务商，IDC数据中心，数据安全，云计算,DNS&CDN，系统研发,腾正科技"
                ];
            break;
            case "rongyu":
                $tdk = [
                    "title" => "荣誉资质-关于我们-专业IDC服务商[腾正科技]",
                    "description" => "腾正科技，坚持以客户为中心，以诚信为基础，以创新为发展的经营理念，先后获得IDC、ISP、CDN、VPN、云牌照、文网文等经营许可证，10余项软件著作权和专利权，十大IDC服务商及华为最佳行业合作伙伴奖等荣誉。",
                    "keywords" => "IDC牌照商，ISP牌照商，CDN牌照商，VPN牌照商，云牌照商，十大IDC服务商，腾正科技"
                ];
            break;
            case "wenhua":
                $tdk = [
                    "title" => "企业文化-关于我们-专业IDC服务商[腾正科技]",
                    "description" => "腾正科技，坚持以客户为中心，以诚信为基础，以创新为发展，为广大互联网同行与合作伙伴提供优质IDC产品和专业服务，为“互联网+”网络安全和信息化建设提供技术支持。",
                    "keywords" => "企业文化，腾正文化，腾正科技,IDC服务商"
                ];
            break;
            case "fazhang":
                $tdk = [
                    "title" => "发展历程-关于我们-专业IDC服务商[腾正科技]",
                    "description" => "腾正科技成立于2014年，位于东莞松山湖国际金融IT研发创新园，旗下全资拥有两家子公司，长沙正易网络科技有限公司、广东腾川网络科技有限公司和多家分公司，以及四大五星级数据中心。",
                    "keywords" => "发展历程,腾正科技，腾正发展史，正易网络科技,腾川网络科技,IDC服务商"
                ];
            break;
            case "lianxi":
                $tdk = [
                    "title" => "联系我们-关于我们-专业IDC服务商[腾正科技]",
                    "description" => "腾正科技专业IDC服务商,主营云主机，高防服务器，高防IP，服务器租用托管，机柜大带宽,CDN服务。总部：东莞松山湖科技十路国际金融IT研发中心2栋B座 0769-22226555",
                    "keywords" => "腾正科技，广东腾正计算机科技有限公司,IDC服务商"
                ];
            break;
            case "pay":
                $tdk = [
                    "title" => "支付中心-关于我们-专业IDC服务商[腾正科技]",
                    "description" => "腾正科技支付中心，支持线上线下公司对公账户转账、支付宝支付、微信支付等多种支付方式，相关汇款注意事项及退款注意事项请仔细阅读，Tel:0769-22226555",
                    "keywords" => "腾正科技，广东腾正计算机科技有限公司,IDC服务商"
                ];
            break;
        }
        return view("http/aboutUs",[
            "page" => $page,
            "tdk" => $tdk
        ]);
    }
}
