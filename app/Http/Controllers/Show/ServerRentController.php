<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ServerRentController extends Controller
{
    public function index($page,$room = "")
    {
        $tdk = [
            "title" => "服务器租用-主机租用-服务器租用价格-高防服务器租用[腾正科技]",
            "keywords" => "服务器租用,主机租用，高防服务器租用,服务器租用价格,服务器常见问题,独立服务器租用",
            "description" => "腾正科技标准5A机房，为您提供全国BGP三线(电信、联通、移动)独立服务器、高防服务器、主机租用相关服务，价格优惠多种高性能组合套餐，满足不同应用场景的需求，Tel:0769-22226555"
        ];
        switch($page) {
            case "gaofang":
                $tdk = [
                    "title" => "高防服务器-高防云服务器-游戏高防服务器-东莞高防服务器[腾正科技]",
                    "keywords" => "高防服务器，高防云服务器，游戏高防服务器，高防服务器价格,东莞高防服务器，百G清洗高防服务器,西安高防服务器，BGP高防服务器",
                    "description" => "腾正高防服务器，为您提供优质独享大宽带防御高防物理服务器，高防云服务器，游戏高防服务器租用，网站高防服务器托管、租用、配置及价格等信息服务咨询热线0769-22226555"
                ];
            break;
            case "dianxin":
                if($room==="hunan") {
                    $tdk = [
                        "title" => "湖南电信服务器租用-长沙服务器租用-衡阳服务器租用价格[腾正科技]",
                        "keywords" => "湖南电信服务器租用,长沙服务器租用,衡阳服务器租用价格,湖南服务器租赁，湖南服务器租用，长沙服务器租用",
                        "description" => "湖南衡阳电信服务器机房为准T3机房，G口计入，独享宽带，直连电信骨干网，提供电信服务器服用、主机租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                } else if($room==="guangdong") {
                    $tdk = [
                        "title" => "广东电信服务器租用-广东服务器租用-东莞服务器租用-惠州服务器价格[腾正科技]",
                        "keywords" => "广东电信服务器租用,广东服务器租用,东莞服务器租用,惠州服务器价格,东莞电信服务器，深圳服务器租用价格",
                        "description" => "广东惠州电信服务器机房为准T3机房，G口计入，独享宽带，直连电信骨干网，提供电信服务器服用、主机租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                }  else if($room==="xian") {
                    $tdk = [
                        "title" => "西安电信服务器租用-西安高防服务器-西安物理服务器租用价格[腾正科技]",
                        "keywords" => "西安电信服务器租用,西安高防服务器,西安物理服务器租用价格,陕西电信服务器租用，陕西服务器租用",
                        "description" => "陕西西安电信服务器机房为准T4机房，G口计入，独享宽带，直连电信骨干网，提供电信服务器服用、主机租用、高防服务器租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                }
            break;
            case "liantong":
                if($room==="hunan") {
                    $tdk = [
                        "title" => "湖南联通服务器租用-长沙服务器租用-衡阳服务器租用价格[腾正科技]",
                        "keywords" => "湖南联通服务器租用,长沙服务器租用,衡阳服务器租用价格,湖南服务器租赁，湖南服务器租用，长沙服务器租用",
                        "description" => "湖南衡阳联通服务器机房为准T3机房，联通A级数据中心，G口计入，独享宽带，提供联通服务器服用、主机租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                } else if($room==="guangdong") {
                    $tdk = [
                        "title" => "广东联通服务器租用-广东服务器租用-东莞服务器租用-惠州服务器价格[腾正科技]",
                        "keywords" => "广东联通服务器租用,广东服务器租用,东莞服务器租用,惠州服务器价格,东莞联通服务器，深圳服务器租用价格",
                        "description" => "广东惠州联通服务器机房为准T3机房，联通A级数据中心，G口计入，独享宽带，提供电信服务器服用、主机租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                }  else if($room==="xian") {
                    $tdk = [
                        "title" => "西安联通服务器租用-西安高防服务器-西安物理服务器租用价格[腾正科技]",
                        "keywords" => "西安联通服务器租用,西安高防服务器,西安物理服务器租用价格,陕西联通服务器租用，陕西服务器租用",
                        "description" => "陕西西安联通服务器机房为准T4机房，联通A级数据中心，G口计入，独享宽带，提供电信服务器服用、主机租用、高防服务器租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                }
            break;
            case "shuangxian":
                if($room==="hunan") {
                    $tdk = [
                        "title" => "湖南双线服务器租用-长沙服务器租用-衡阳服务器租用价格[腾正科技]",
                        "keywords" => "湖南双线服务器租用,长沙服务器租用,衡阳服务器租用价格,湖南服务器租赁，湖南服务器租用，长沙服务器租用",
                        "description" => "湖南衡阳双线服务器机房为准T3机房，G口计入，独享宽带，直连核心骨干网，提供双线服务器服用、主机租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                } else if($room==="guangdong") {
                    $tdk = [
                        "title" => "广东双线服务器租用-广东服务器租用-东莞服务器租用-惠州服务器价格[腾正科技]",
                        "keywords" => "广东双线服务器租用,广东服务器租用,东莞服务器租用,惠州服务器价格,东莞双线服务器，深圳服务器租用价格",
                        "description" => "广东惠州双线服务器机房为准T3机房，G口计入，独享宽带，直连核心骨干网，提供双线服务器服用、主机租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                }  else if($room==="xian") {
                    $tdk = [
                        "title" => "西安双线服务器租用-西安高防服务器-西安物理服务器租用价格[腾正科技]",
                        "keywords" => "西安双线服务器租用,西安高防服务器,西安物理服务器租用价格,陕西双线服务器租用，陕西服务器租用",
                        "description" => "陕西西安双线服务器机房为准T4机房，G口计入，独享宽带，直连核心骨干网，提供双线服务器服用、主机租用、高防服务器租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                }
            break;
            case "sanxian":
                if($room==="hunan") {
                    $tdk = [
                        "title" => "湖南三线服务器租用-长沙服务器租用-衡阳服务器租用价格[腾正科技]",
                        "keywords" => "湖南三线服务器租用,长沙服务器租用,衡阳服务器租用价格,湖南服务器租赁，湖南服务器租用，长沙服务器租用",
                        "description" => "湖南衡阳三线服务器机房为准T3机房，G口计入，独享宽带，直连核心骨干网，提供三线服务器服用、主机租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                } else if($room==="guangdong") {
                    $tdk = [
                        "title" => "广东三线服务器租用-广东服务器租用-东莞服务器租用-惠州服务器价格[腾正科技]",
                        "keywords" => "广东三线服务器租用,广州服务器租用,东莞服务器租用,惠州服务器价格,东莞三线服务器，深圳服务器租用价格",
                        "description" => "广东惠州三线服务器机房为准T3机房，G口计入，独享宽带，直连核心骨干网，提供三线服务器服用、主机租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                }  else if($room==="xian") {
                    $tdk = [
                        "title" => "西安三线服务器租用-西安高防服务器-西安物理服务器租用价格[腾正科技]",
                        "keywords" => "西安三线服务器租用,西安高防服务器,西安物理服务器租用价格,陕西三线服务器租用，陕西服务器租用",
                        "description" => "陕西西安三线服务器机房为准T4机房，G口计入，独享宽带，直连核心骨干网，提供三线服务器服用、主机租用、高防服务器租用、物理服务器租赁价格、配置及机房详情等信息服务。"
                    ];
                }
            break;
        }
        $template = "http/serverRent";
        $productData = [
            "title" => "服务器租用",
            "description" => "为您提供定制化硬件采购解决方案，满足您不同时期业务发展需求！",
            "data" => [
                [
                    "name" => "惠州双线 50G防御",
                    "price" => 900,
                    "cpu" => "八核16线程 Xeon E5530 * 2",
                    "ram" => "8G",
                    "hardDisk" => "300G SAS/1T SATA",
                    "bandwidth" => "G口（20M独享）",
                    "defense" => 0,
                    "top" => false
                ],
                [
                    "name" => "衡阳双线 40G防御",
                    "price" => 900,
                    "cpu" => "Xeon E5530 * 2/L5630 * 2",
                    "ram" => "8G",
                    "hardDisk" => "1T SATA",
                    "bandwidth" => "G口（20M独享）",
                    "defense" => 0,
                    "top" => false
                ],
                [
                    "name" => "高防320G抗D+无限CC",
                    "price" => 3500,
                    "cpu" => "八核16线程 Xeon E5570 * 2",
                    "ram" => "16G",
                    "hardDisk" => "240G（固态硬盘）",
                    "bandwidth" => "G口（100M独享）",
                    "defense" => 0,
                    "top" => false
                ],
                [
                    "name" => "惠州电信(100M活动促销)",
                    "price" => 1299,
                    "cpu" => "八核16线程 Xeon E5530 * 2",
                    "ram" => "8G",
                    "hardDisk" => "300G SAS/1T SATA",
                    "bandwidth" => "G口（100M独享）",
                    "defense" => 0,
                    "top" => false
                ]
            ]
        ];
        $data = [
            "sanxian" => [
                "hunan" => [
                    "room" => "湖南衡阳机房",
                    "overview" => "湖南衡阳机房，准T4机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "衡阳三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "3个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 1000,
                            "annualFee" => 1000 * 12
                        ],
                        [
                            "line" => "衡阳三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "3个",
                            "defense" => "40G",
                            "monthlyPay" => 1000,
                            "annualFee" => 1000 * 12
                        ],
                        [
                            "line" => "衡阳三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "3个",
                            "defense" => "80G",
                            "monthlyPay" => 1400,
                            "annualFee" => 1400 * 12
                        ],
                        [
                            "line" => "衡阳三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "3个",
                            "defense" => "120G",
                            "monthlyPay" => 2100,
                            "annualFee" => 2100 * 12
                        ]
                    ]
                ],
                "huizhou" => [
                    "room" => "惠州机房信息",
                    "overview" => "惠州机房，运营级别为准T3机房，机房面积8000平方米，可部署2800个42U国际标准机柜；采用百万兆级别480G集群防火墙和云堤独立清洗400G，和网络攻击说拜拜；在出口总带宽上，总带宽1600G，直连中国华南地区国际出口电信骨干网，网络环境优良，带宽充足；不仅如此，机房拥有两路电力供应、市电线路的冗余备份和智能 UPS 系统冗余备份的柴油发电组，确保机房持续稳定运行。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "惠州三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "3个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 1100,
                            "annualFee" => 1100 * 12
                        ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "50G",
                        //     "monthlyPay" => "800",
                        //     "annualFee" => "8800"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "50G",
                        //     "monthlyPay" => "900",
                        //     "annualFee" => "9900"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "四核8线程 Xeon X5672",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1600",
                        //     "annualFee" => "17600"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1600",
                        //     "annualFee" => "17600"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1700",
                        //     "annualFee" => "18700"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "四核8线程 Xeon X5672",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2200",
                        //     "annualFee" => "24200"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2200",
                        //     "annualFee" => "24200"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2300",
                        //     "annualFee" => "25300"
                        // ]
                    ]
                ],
                "xian" => [
                    "room" => "陕西西安机房",
                    "overview" => "陕西西安机房，准T4机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "西安三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "3个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 1100,
                            "annualFee" => 1100 * 12
                        ],
                        [
                            "line" => "西安三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口50M",
                            "ip" => "3个",
                            "defense" => "80G",
                            "monthlyPay" => 1400,
                            "annualFee" => 12000
                        ],
                        [
                            "line" => "西安三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口100M",
                            "ip" => "3个",
                            "defense" => "160G",
                            "monthlyPay" => 2200,
                            "annualFee" => 20400
                        ],
                        [
                            "line" => "西安三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口200M",
                            "ip" => "3个",
                            "defense" => "300G",
                            "monthlyPay" => 3900,
                            "annualFee" => 38400
                        ],
                        [
                            "line" => "西安三线",
                            "format" => "定制",
                            "ram" => "定制",
                            "disk" => "定制",
                            "bandwidth" => "G口无限带宽",
                            "ip" => "3个",
                            "defense" => "500G+云堤",
                            "monthlyPay" => "定制",
                            "annualFee" => "定制"
                        ],
                        // [
                        //     "line" => "西安电信",
                        //     "format" => "E5530*2 8核",
                        //     "ram" => "16G",
                        //     "disk" => "300G SAS",
                        //     "bandwidth" => "50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "无防",
                        //     "monthlyPay" => 1799,
                        //     "annualFee" => 1799 * 12
                        // ],
                        // [
                        //     "line" => "西安电信",
                        //     "format" => "E5530*2 8核",
                        //     "ram" => "32G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "100M独享",
                        //     "ip" => "1个",
                        //     "defense" => "无防",
                        //     "monthlyPay" => 2399,
                        //     "annualFee" => 2399 * 12
                        // ]
                    ]
                ]
            ],
            "shuangxian" => [
                "hunan" => [
                    "room" => "湖南衡阳机房",
                    "overview" => "湖南衡阳机房，准T4机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "衡阳双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1对",
                            "defense" => "无（企业）",
                            "monthlyPay" => 1000,
                            "annualFee" => 9600
                        ],
                        [
                            "line" => "衡阳双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1对",
                            "defense" => "40G",
                            "monthlyPay" => 1000,
                            "annualFee" => 9600
                        ],
                        [
                            "line" => "衡阳双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1对",
                            "defense" => "80G",
                            "monthlyPay" => 1500,
                            "annualFee" => 14400
                        ],
                        [
                            "line" => "衡阳双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1对",
                            "defense" => "120G",
                            "monthlyPay" => 2200,
                            "annualFee" => 22800
                        ]
                    ]
                ],
                "huizhou" => [
                    "room" => "惠州机房信息",
                    "overview" => "惠州机房，运营级别为准T3机房，机房面积8000平方米，可部署2800个42U国际标准机柜；采用百万兆级别480G集群防火墙和云堤独立清洗400G，和网络攻击说拜拜；在出口总带宽上，总带宽1600G，直连中国华南地区国际出口电信骨干网，网络环境优良，带宽充足；不仅如此，机房拥有两路电力供应、市电线路的冗余备份和智能 UPS 系统冗余备份的柴油发电组，确保机房持续稳定运行。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "惠州双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 1200,
                            "annualFee" => 10800
                        ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "50G",
                        //     "monthlyPay" => "800",
                        //     "annualFee" => "8800"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "50G",
                        //     "monthlyPay" => "900",
                        //     "annualFee" => "9900"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "四核8线程 Xeon X5672",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1600",
                        //     "annualFee" => "17600"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1600",
                        //     "annualFee" => "17600"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1700",
                        //     "annualFee" => "18700"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "四核8线程 Xeon X5672",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2200",
                        //     "annualFee" => "24200"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2200",
                        //     "annualFee" => "24200"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2300",
                        //     "annualFee" => "25300"
                        // ]
                    ]
                ],
                "xian" => [
                    "room" => "陕西西安机房",
                    "overview" => "陕西西安机房，准T4机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "西安双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1对",
                            "defense" => "无（企业）",
                            "monthlyPay" => 950,
                            "annualFee" => 950 * 12
                        ],
                        [
                            "line" => "西安双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口50M",
                            "ip" => "1对",
                            "defense" => "80G",
                            "monthlyPay" => 1100,
                            "annualFee" => 10800
                        ],
                        [
                            "line" => "西安双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口100M",
                            "ip" => "1对",
                            "defense" => "160G",
                            "monthlyPay" => 1900,
                            "annualFee" => 19200
                        ],
                        [
                            "line" => "西安双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口200M",
                            "ip" => "1对",
                            "defense" => "300G",
                            "monthlyPay" => 3600,
                            "annualFee" => 37200
                        ],
                        [
                            "line" => "西安双线",
                            "format" => "定制",
                            "ram" => "定制",
                            "disk" => "定制",
                            "bandwidth" => "G口无限带宽",
                            "ip" => "1对",
                            "defense" => "500G+云堤",
                            "monthlyPay" => "定制",
                            "annualFee" => "定制"
                        ],
                        // [
                        //     "line" => "西安电信",
                        //     "format" => "E5530*2 8核",
                        //     "ram" => "16G",
                        //     "disk" => "300G SAS",
                        //     "bandwidth" => "50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "无防",
                        //     "monthlyPay" => 1799,
                        //     "annualFee" => 1799 * 12
                        // ],
                        // [
                        //     "line" => "西安电信",
                        //     "format" => "E5530*2 8核",
                        //     "ram" => "32G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "100M独享",
                        //     "ip" => "1个",
                        //     "defense" => "无防",
                        //     "monthlyPay" => 2399,
                        //     "annualFee" => 2399 * 12
                        // ]
                    ]
                ]
            ],
            "liantong" => [
                "hunan" => [
                    "room" => "湖南衡阳机房",
                    "overview" => "湖南衡阳机房，准T4机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "衡阳联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 700,
                            "annualFee" => 700 * 12
                        ],
                        [
                            "line" => "衡阳联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "40G",
                            "monthlyPay" => 700,
                            "annualFee" => 700 * 12
                        ],
                        [
                            "line" => "衡阳联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "80G",
                            "monthlyPay" => 1100,
                            "annualFee" => 1100 * 12
                        ],
                        [
                            "line" => "衡阳联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "120G",
                            "monthlyPay" => 1800,
                            "annualFee" => 1800 * 12
                        ]
                    ]
                ],
                "huizhou" => [
                    "room" => "惠州机房信息",
                    "overview" => "惠州机房，运营级别为准T3机房，机房面积8000平方米，可部署2800个42U国际标准机柜；采用百万兆级别480G集群防火墙和云堤独立清洗400G，和网络攻击说拜拜；在出口总带宽上，总带宽1600G，直连中国华南地区国际出口电信骨干网，网络环境优良，带宽充足；不仅如此，机房拥有两路电力供应、市电线路的冗余备份和智能 UPS 系统冗余备份的柴油发电组，确保机房持续稳定运行。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "惠州联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 800,
                            "annualFee" => 800 * 12
                        ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "50G",
                        //     "monthlyPay" => "800",
                        //     "annualFee" => "8800"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "50G",
                        //     "monthlyPay" => "900",
                        //     "annualFee" => "9900"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "四核8线程 Xeon X5672",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1600",
                        //     "annualFee" => "17600"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1600",
                        //     "annualFee" => "17600"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1700",
                        //     "annualFee" => "18700"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "四核8线程 Xeon X5672",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2200",
                        //     "annualFee" => "24200"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2200",
                        //     "annualFee" => "24200"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2300",
                        //     "annualFee" => "25300"
                        // ]
                    ]
                ],
                "xian" => [
                    "room" => "陕西西安机房",
                    "overview" => "陕西西安机房，准T4机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "西安联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 800,
                            "annualFee" => 800 * 12
                        ],
                        [
                            "line" => "西安联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口50M",
                            "ip" => "1个",
                            "defense" => "80G",
                            "monthlyPay" => 800,
                            "annualFee" => 800 * 12
                        ],
                        [
                            "line" => "西安联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口100M",
                            "ip" => "1个",
                            "defense" => "160G",
                            "monthlyPay" => 1500,
                            "annualFee" => 1500 * 12
                        ],
                        [
                            "line" => "西安联通",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口200M",
                            "ip" => "1个",
                            "defense" => "300G",
                            "monthlyPay" => 3000,
                            "annualFee" => 3000 * 12
                        ],
                        [
                            "line" => "西安联通",
                            "format" => "定制",
                            "ram" => "定制",
                            "disk" => "定制",
                            "bandwidth" => "G口无限带宽",
                            "ip" => "1个",
                            "defense" => "500G+云堤",
                            "monthlyPay" => "定制",
                            "annualFee" => "定制"
                        ],
                        // [
                        //     "line" => "西安电信",
                        //     "format" => "E5530*2 8核",
                        //     "ram" => "16G",
                        //     "disk" => "300G SAS",
                        //     "bandwidth" => "50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "无防",
                        //     "monthlyPay" => 1799,
                        //     "annualFee" => 1799 * 12
                        // ],
                        // [
                        //     "line" => "西安电信",
                        //     "format" => "E5530*2 8核",
                        //     "ram" => "32G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "100M独享",
                        //     "ip" => "1个",
                        //     "defense" => "无防",
                        //     "monthlyPay" => 2399,
                        //     "annualFee" => 2399 * 12
                        // ]
                    ]
                ]
            ],
            "dianxin" => [
                "hunan" => [
                    "room" => "湖南衡阳机房",
                    "overview" => "湖南衡阳机房，准T4机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "衡阳电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 800,
                            "annualFee" => 7200
                        ],
                        [
                            "line" => "衡阳电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "40G",
                            "monthlyPay" => 800,
                            "annualFee" => 7200
                        ],
                        [
                            "line" => "衡阳电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "80G",
                            "monthlyPay" => 1300,
                            "annualFee" => 12000
                        ],
                        [
                            "line" => "衡阳电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "120G",
                            "monthlyPay" => 2000,
                            "annualFee" => 20400
                        ]
                    ]
                ],
                "huizhou" => [
                    "room" => "惠州机房信息",
                    "overview" => "惠州机房，运营级别为准T3机房，机房面积8000平方米，可部署2800个42U国际标准机柜；采用百万兆级别480G集群防火墙和云堤独立清洗400G，和网络攻击说拜拜；在出口总带宽上，总带宽1600G，直连中国华南地区国际出口电信骨干网，网络环境优良，带宽充足；不仅如此，机房拥有两路电力供应、市电线路的冗余备份和智能 UPS 系统冗余备份的柴油发电组，确保机房持续稳定运行。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "惠州电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 1000,
                            "annualFee" => 8400
                        ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "50G",
                        //     "monthlyPay" => "800",
                        //     "annualFee" => "8800"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "50G",
                        //     "monthlyPay" => "900",
                        //     "annualFee" => "9900"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "四核8线程 Xeon X5672",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1600",
                        //     "annualFee" => "17600"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1600",
                        //     "annualFee" => "17600"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口20M独享",
                        //     "ip" => "1个",
                        //     "defense" => "100G",
                        //     "monthlyPay" => "1700",
                        //     "annualFee" => "18700"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "四核8线程 Xeon X5672",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2200",
                        //     "annualFee" => "24200"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "八核16线程 Xeon E5530*2",
                        //     "ram" => "8G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2200",
                        //     "annualFee" => "24200"
                        // ],
                        // [
                        //     "line" => "惠州电信",
                        //     "format" => "酷睿I7-3770",
                        //     "ram" => "8G",
                        //     "disk" => "240G SSD(固态)",
                        //     "bandwidth" => "G口50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "150G",
                        //     "monthlyPay" => "2300",
                        //     "annualFee" => "25300"
                        // ]
                    ]
                ],
                "xian" => [
                    "room" => "陕西西安机房",
                    "overview" => "陕西西安机房，准T4机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "西安电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1个",
                            "defense" => "无（企业）",
                            "monthlyPay" => 800,
                            "annualFee" => 800 * 12
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口50M",
                            "ip" => "1个",
                            "defense" => "80G",
                            "monthlyPay" => 900,
                            "annualFee" => 8400
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口100M",
                            "ip" => "1个",
                            "defense" => "160G",
                            "monthlyPay" => 1700,
                            "annualFee" => 16800
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口200M",
                            "ip" => "1个",
                            "defense" => "300G",
                            "monthlyPay" => 3400,
                            "annualFee" => 34800
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "定制",
                            "ram" => "定制",
                            "disk" => "定制",
                            "bandwidth" => "G口无限带宽",
                            "ip" => "1个",
                            "defense" => "500G+云堤",
                            "monthlyPay" => "定制",
                            "annualFee" => "定制"
                        ],
                        // [
                        //     "line" => "西安电信",
                        //     "format" => "E5530*2 8核",
                        //     "ram" => "16G",
                        //     "disk" => "300G SAS",
                        //     "bandwidth" => "50M独享",
                        //     "ip" => "1个",
                        //     "defense" => "无防",
                        //     "monthlyPay" => 1799,
                        //     "annualFee" => 1799 * 12
                        // ],
                        // [
                        //     "line" => "西安电信",
                        //     "format" => "E5530*2 8核",
                        //     "ram" => "32G",
                        //     "disk" => "300G SAS/1T SATA",
                        //     "bandwidth" => "100M独享",
                        //     "ip" => "1个",
                        //     "defense" => "无防",
                        //     "monthlyPay" => 2399,
                        //     "annualFee" => 2399 * 12
                        // ]
                    ]
                ]
            ]
        ];
        if($page!=="index"&&$page!=="gaofang") {
            $template = "http/product";
        }
        if($page==="gaofang") {
            $productData = [
                "title" => "高防服务器",
                "description" => "为您提供高级防御解决方案，T级流量清洗，为您业务保驾护航！",
                "data" => [
                    [
                        "name" => "百G清洗-游戏级",
                        "price" => 888,
                        "cpu" => "I7",
                        "ram" => "8G",
                        "hardDisk" => "240G（固态硬盘）",
                        "bandwidth" => "100M",
                        "defense" => "200G",
                        "top" => true
                    ],
                    [
                        "name" => "毫秒清洗-微端级",
                        "price" => 3500,
                        "cpu" => "E5530",
                        "ram" => "16G",
                        "hardDisk" => "240G（固态硬盘）",
                        "bandwidth" => "100M",
                        "defense" => "320G",
                        "top" => false
                    ],
                    [
                        "name" => "棋牌游戏-旗舰级",
                        "price" => "定制咨询",
                        "cpu" => "X5672",
                        "ram" => "32G",
                        "hardDisk" => "240G（固态硬盘）",
                        "bandwidth" => "100M",
                        "defense" => "1T",
                        "top" => false
                    ],
                    [
                        "name" => "T级高防IP-逆天级",
                        "price" => "在线购买",
                        "ddos" => "1024G峰值",
                        "top" => false
                    ]
                ]
            ];
        }
        // dump($data[$page]);
        return view($template,[
            "page" => $page,
            "data" => array_key_exists($page,$data) ? $data[$page] : [],
            "productData" => $productData,
            "room" => $room,
            "tdk" => $tdk
        ]);
    }
}
