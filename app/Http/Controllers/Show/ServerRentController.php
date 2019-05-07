<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ServerRentController extends Controller
{
    public function index($page)
    {
        // $leng = 4;
        // $currteme = strtotime("2019-01-20 17:28:00");
        // $now = date("Y-m",$currteme);
        // // $now = date("Y-m",strtotime("2019-01"));
        // $date = date("t",strtotime("$now +1 month"));
        // $xfts = 0;
        // for($i = 0;$i<$leng;$i++) {

        // }
        // dump($date);
        $template = "http/serverRent";
        $data = [
            "sanxian" => [
                "hunan" => [
                    "room" => "湖南衡阳机房",
                    "overview" => "湖南衡阳机房，国家AAAA级机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
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
                    "overview" => "惠州机房，运营级别为国家AAAAA级机房，机房面积8000平方米，可部署2800个42U国际标准机柜；采用百万兆级别480G集群防火墙和云堤独立清洗400G，和网络攻击说拜拜；在出口总带宽上，总带宽1600G，直连中国华南地区国际出口电信骨干网，网络环境优良，带宽充足；不仅如此，机房拥有两路电力供应、市电线路的冗余备份和智能 UPS 系统冗余备份的柴油发电组，确保机房持续稳定运行。",
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
                    "overview" => "陕西西安机房，国家AAAA级机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
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
                            "monthlyPay" => 1100,
                            "annualFee" => 1100 * 12
                        ],
                        [
                            "line" => "西安三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口100M",
                            "ip" => "3个",
                            "defense" => "160G",
                            "monthlyPay" => 1800,
                            "annualFee" => 1800 * 12
                        ],
                        [
                            "line" => "西安三线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口200M",
                            "ip" => "3个",
                            "defense" => "300G",
                            "monthlyPay" => 3300,
                            "annualFee" => 3300 * 12
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
                    "overview" => "湖南衡阳机房，国家AAAA级机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
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
                            "monthlyPay" => 850,
                            "annualFee" => 850 * 12
                        ],
                        [
                            "line" => "衡阳双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1对",
                            "defense" => "40G",
                            "monthlyPay" => 850,
                            "annualFee" => 850 * 12
                        ],
                        [
                            "line" => "衡阳双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1对",
                            "defense" => "80G",
                            "monthlyPay" => 1250,
                            "annualFee" => 1250 * 12
                        ],
                        [
                            "line" => "衡阳双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "16G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口20M",
                            "ip" => "1对",
                            "defense" => "120G",
                            "monthlyPay" => 1950,
                            "annualFee" => 1950 * 12
                        ]
                    ]
                ],
                "huizhou" => [
                    "room" => "惠州机房信息",
                    "overview" => "惠州机房，运营级别为国家AAAAA级机房，机房面积8000平方米，可部署2800个42U国际标准机柜；采用百万兆级别480G集群防火墙和云堤独立清洗400G，和网络攻击说拜拜；在出口总带宽上，总带宽1600G，直连中国华南地区国际出口电信骨干网，网络环境优良，带宽充足；不仅如此，机房拥有两路电力供应、市电线路的冗余备份和智能 UPS 系统冗余备份的柴油发电组，确保机房持续稳定运行。",
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
                            "monthlyPay" => 950,
                            "annualFee" => 950 * 12
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
                    "overview" => "陕西西安机房，国家AAAA级机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
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
                            "monthlyPay" => 950,
                            "annualFee" => 950 * 12
                        ],
                        [
                            "line" => "西安双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口100M",
                            "ip" => "1对",
                            "defense" => "160G",
                            "monthlyPay" => 1650,
                            "annualFee" => 1650 * 12
                        ],
                        [
                            "line" => "西安双线",
                            "format" => "8核16线程（E5530*2）",
                            "ram" => "32G",
                            "disk" => "240G SSD/500G SATA/1T SATA",
                            "bandwidth" => "G口200M",
                            "ip" => "1对",
                            "defense" => "300G",
                            "monthlyPay" => 3150,
                            "annualFee" => 3150 * 12
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
                    "overview" => "湖南衡阳机房，国家AAAA级机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
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
                    "overview" => "惠州机房，运营级别为国家AAAAA级机房，机房面积8000平方米，可部署2800个42U国际标准机柜；采用百万兆级别480G集群防火墙和云堤独立清洗400G，和网络攻击说拜拜；在出口总带宽上，总带宽1600G，直连中国华南地区国际出口电信骨干网，网络环境优良，带宽充足；不仅如此，机房拥有两路电力供应、市电线路的冗余备份和智能 UPS 系统冗余备份的柴油发电组，确保机房持续稳定运行。",
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
                    "overview" => "陕西西安机房，国家AAAA级机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
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
                    "overview" => "湖南衡阳机房，国家AAAA级机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
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
                            "monthlyPay" => 700,
                            "annualFee" => 700 * 12
                        ],
                        [
                            "line" => "衡阳电信",
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
                            "line" => "衡阳电信",
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
                            "line" => "衡阳电信",
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
                    "overview" => "惠州机房，运营级别为国家AAAAA级机房，机房面积8000平方米，可部署2800个42U国际标准机柜；采用百万兆级别480G集群防火墙和云堤独立清洗400G，和网络攻击说拜拜；在出口总带宽上，总带宽1600G，直连中国华南地区国际出口电信骨干网，网络环境优良，带宽充足；不仅如此，机房拥有两路电力供应、市电线路的冗余备份和智能 UPS 系统冗余备份的柴油发电组，确保机房持续稳定运行。",
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
                    "overview" => "陕西西安机房，国家AAAA级机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
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
                            "monthlyPay" => 800,
                            "annualFee" => 800 * 12
                        ],
                        [
                            "line" => "西安电信",
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
                            "line" => "西安电信",
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
        // dump($data[$page]);
        return view($template,[
            "page" => $page,
            "data" => array_key_exists($page,$data) ? $data[$page] : []
        ]);
    }
}
