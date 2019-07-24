<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class DataCenterController extends Controller
{
    public function roomData($page)
    {
        $data = [
            "hengyang" => [
                "level" => "国家<strong>AAAAA</strong>级机房",
                "area" => "8000 平方米",
                "total" => "1288 个，42U 国际标准机柜",
                "bandwidth" => "860G 直连中国电信骨干网",
                "firewall" => "200G 集群防火墙",
                "power" => "两路市电，UPS 艾默生力博特 Hipluse 系统，美国卡特 2000KVA 柴油发电机组",
                "address" => "湖南省衡阳市石鼓区蒸水桥北互联网数据中心",
                "thumbnails" => [
                    "/images/room/hengyang01.jpg",
                    "/images/room/hengyang02.jpg",
                    "/images/room/hengyang03.jpg"
                ]
            ],
            "huizhou" => [
                "level" => "国家<strong>AAAAA</strong>级机房",
                "area" => "8000 平方米",
                "total" => "2800 个,42U 国际标准机柜",
                "bandwidth" => "1.6T，直连中国华南地区国际出口电信骨干网",
                "firewall" => "480G 集群防火墙（百万兆级别）+云堤独立清洗 400G",
                "power" => "独立引入两路电力供应，市电线路的冗余备份、智能UPS系统冗余备份的柴油发电组",
                "address" => "广东省惠州市惠城区东湖二街东平互联网数据中心",
                "thumbnails" => [
                    "/images/room/huizhou01.jpg",
                    "/images/room/huizhou02.jpg",
                    "/images/room/huizhou03.jpg"
                ]
            ],
            "xian" => [
                "level" => "国家<strong>AAAA</strong>级机房",
                "area" => "53851平方米",
                "total" => "5000个，42U标准机柜",
                "bandwidth" => "10T，直连互联网骨干点",
                "firewall" => "320G 集群防火墙",
                "power" => "从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统",
                "address" => "陕西省西咸新区沣西新城",
                "thumbnails" => [
                    "/images/room/xian01.jpg",
                    "/images/room/xian02.jpg",
                    "/images/room/xian03.jpg"
                ]
            ]
        ];
        return tz_ajax_echo($data[$page],"获取成功",1);
    }
    public function index($page)
    {
        $data = [
            "hengyang" => [
                "name" => "衡阳数据中心",
                "title" => "衡阳数据中心-新一代数据中心-IDC数据中心-服务器租用托管[腾正科技]",
                "keywords" => "衡阳数据中心,湖南新一代数据中心,湖南数据中心，衡阳电信数据中心，IDC数据中心，服务器租用托管",
                "description" => "衡阳数据中心,自主准T3级IDC机房,云数据中心,提供优质的服务器租用,主机托管,机柜大带宽租用相关服务，资深网络工程师机房7*24小时专业技术保障！",
                "level" => "国家<strong>AAAAA</strong>级机房",
                "area" => "8000 平方米",
                "total" => "1288 个，42U 国际标准机柜",
                "bandwidth" => "860G 直连中国电信骨干网",
                "firewall" => "200G 集群防火墙",
                "power" => "两路市电，UPS 艾默生力博特 Hipluse 系统，美国卡特 2000KVA 柴油发电机组",
                "address" => "湖南省衡阳市石鼓区蒸水桥北互联网数据中心",
                "thumbnails" => [
                    "/images/room/hengyang01.jpg",
                    "/images/room/hengyang02.jpg",
                    "/images/room/hengyang03.jpg"
                ]
            ],
            "huizhou" => [
                "name" => "惠州数据中心",
                "title" => "惠州数据中心-新一代数据中心-IDC数据中心-服务器租用托管[腾正科技]",
                "keywords" => "惠州数据中心,广东新一代数据中心,广东数据中心,东莞数据中心,东莞idc数据中心,IDC数据中心，服务器租用托管",
                "description" => "惠州数据中心,自主准T3级IDC机房,机房面积8000m²，全网骨干网络接入，双重防火墙+T级云堤清洗组合防御系统，为用户提供安全可靠的服务器租用,主机托管,机柜大带宽租用相关服务，资深网络工程师机房7*24小时专业技术保障！",
                "level" => "国家<strong>AAAAA</strong>级机房",
                "area" => "8000 平方米",
                "total" => "2800 个,42U 国际标准机柜",
                "bandwidth" => "1.6T，直连中国华南地区国际出口电信骨干网",
                "firewall" => "480G 集群防火墙（百万兆级别）+云堤独立清洗 400G",
                "power" => "独立引入两路电力供应，市电线路的冗余备份、智能UPS系统冗余备份的柴油发电组",
                "address" => "广东省惠州市惠城区东湖二街东平互联网数据中心",
                "thumbnails" => [
                    "/images/room/huizhou01.jpg",
                    "/images/room/huizhou02.jpg",
                    "/images/room/huizhou03.jpg"
                ]
            ],
            "xian" => [
                "name" => "西安数据中心",
                "title" => "西安数据中心-新一代数据中心-IDC数据中心-服务器租用托管[腾正科技]",
                "keywords" => "西安数据中心，陕西新一代数据中心，陕西数据中心,西安电信数据中心，IDC数据中心，服务器租用托管",
                "description" => "西安数据中心,自主准T4级IDC机房,云数据中心,提供优质的高防IP，高防服务器，服务器租用,主机托管及机柜大带宽租用相关服务，资深网络工程师机房7*24小时专业技术保障！",
                "level" => "国家<strong>AAAA</strong>级机房",
                "area" => "53851平方米",
                "total" => "5000个，42U标准机柜",
                "bandwidth" => "10T，直连互联网骨干点",
                "firewall" => "320G 集群防火墙",
                "power" => "从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统",
                "address" => "陕西省西咸新区沣西新城",
                "thumbnails" => [
                    "/images/room/xian01.jpg",
                    "/images/room/xian02.jpg",
                    "/images/room/xian03.jpg"
                ]
            ]
        ];
        return view("http/datacenter",[
            "data" => $data[$page],
            "page" => $page
        ]);
    }
}
