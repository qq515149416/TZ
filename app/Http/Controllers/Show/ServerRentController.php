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
            "dianxin" => [
                "hunan" => [
                    "room" => "湖南衡阳机房",
                    "overview" => "湖南衡阳机房，国家AAAA级机房，出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。",
                    "grade" => "AAAA",
                    "detail" => "#",
                    "machines" => [
                        [
                            "line" => "衡阳电信",
                            "format" => "八核16线程Xeon E5530*2/L5630*2",
                            "ram" => "8G",
                            "disk" => "1T SATA",
                            "bandwidth" => "G口20M独享",
                            "ip" => "1个",
                            "defense" => "40G",
                            "monthlyPay" => "700",
                            "annualFee" => "7700"
                        ],
                        [
                            "line" => "衡阳电信",
                            "format" => "八核16线程Xeon E5530*2/L5630*2",
                            "ram" => "8G",
                            "disk" => "1T SATA",
                            "bandwidth" => "G口20M独享",
                            "ip" => "1个",
                            "defense" => "80G",
                            "monthlyPay" => "1200",
                            "annualFee" => "13200"
                        ],
                        [
                            "line" => "衡阳电信",
                            "format" => "八核16线程Xeon E5530*2/L5630*2",
                            "ram" => "8G",
                            "disk" => "1T SATA",
                            "bandwidth" => "G口50M独享",
                            "ip" => "1个",
                            "defense" => "120G",
                            "monthlyPay" => "1800",
                            "annualFee" => "19800"
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
                            "format" => "四核8线程 Xeon X5672",
                            "ram" => "8G",
                            "disk" => "240G SSD(固态)",
                            "bandwidth" => "G口20M独享",
                            "ip" => "1个",
                            "defense" => "50G",
                            "monthlyPay" => "800",
                            "annualFee" => "8800"
                        ],
                        [
                            "line" => "惠州电信",
                            "format" => "八核16线程 Xeon E5530*2",
                            "ram" => "8G",
                            "disk" => "300G SAS/1T SATA",
                            "bandwidth" => "G口20M独享",
                            "ip" => "1个",
                            "defense" => "50G",
                            "monthlyPay" => "800",
                            "annualFee" => "8800"
                        ],
                        [
                            "line" => "惠州电信",
                            "format" => "酷睿I7-3770",
                            "ram" => "8G",
                            "disk" => "240G SSD(固态)",
                            "bandwidth" => "G口20M独享",
                            "ip" => "1个",
                            "defense" => "50G",
                            "monthlyPay" => "900",
                            "annualFee" => "9900"
                        ],
                        [
                            "line" => "惠州电信",
                            "format" => "四核8线程 Xeon X5672",
                            "ram" => "8G",
                            "disk" => "240G SSD(固态)",
                            "bandwidth" => "G口20M独享",
                            "ip" => "1个",
                            "defense" => "100G",
                            "monthlyPay" => "1600",
                            "annualFee" => "17600"
                        ],
                        [
                            "line" => "惠州电信",
                            "format" => "八核16线程 Xeon E5530*2",
                            "ram" => "8G",
                            "disk" => "300G SAS/1T SATA",
                            "bandwidth" => "G口20M独享",
                            "ip" => "1个",
                            "defense" => "100G",
                            "monthlyPay" => "1600",
                            "annualFee" => "17600"
                        ],
                        [
                            "line" => "惠州电信",
                            "format" => "酷睿I7-3770",
                            "ram" => "8G",
                            "disk" => "240G SSD(固态)",
                            "bandwidth" => "G口20M独享",
                            "ip" => "1个",
                            "defense" => "100G",
                            "monthlyPay" => "1700",
                            "annualFee" => "18700"
                        ],
                        [
                            "line" => "惠州电信",
                            "format" => "四核8线程 Xeon X5672",
                            "ram" => "8G",
                            "disk" => "240G SSD(固态)",
                            "bandwidth" => "G口50M独享",
                            "ip" => "1个",
                            "defense" => "150G",
                            "monthlyPay" => "2200",
                            "annualFee" => "24200"
                        ],
                        [
                            "line" => "惠州电信",
                            "format" => "八核16线程 Xeon E5530*2",
                            "ram" => "8G",
                            "disk" => "300G SAS/1T SATA",
                            "bandwidth" => "G口50M独享",
                            "ip" => "1个",
                            "defense" => "150G",
                            "monthlyPay" => "2200",
                            "annualFee" => "24200"
                        ],
                        [
                            "line" => "惠州电信",
                            "format" => "酷睿I7-3770",
                            "ram" => "8G",
                            "disk" => "240G SSD(固态)",
                            "bandwidth" => "G口50M独享",
                            "ip" => "1个",
                            "defense" => "150G",
                            "monthlyPay" => "2300",
                            "annualFee" => "25300"
                        ]
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
                            "format" => "E5530*2 8核",
                            "ram" => "8G",
                            "disk" => "240G SSD/1T SATA",
                            "bandwidth" => "100M",
                            "ip" => "1个",
                            "defense" => "100G",
                            "monthlyPay" => 1399,
                            "annualFee" => 1399 * 12
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "E5530*2 8核",
                            "ram" => "8G",
                            "disk" => "300G SAS/1T SATA",
                            "bandwidth" => "100M",
                            "ip" => "1个",
                            "defense" => "200G",
                            "monthlyPay" => 2599,
                            "annualFee" => 2599 * 12
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "X5672*2 8核",
                            "ram" => "8G",
                            "disk" => "240G SSD/IT SATA",
                            "bandwidth" => "100M",
                            "ip" => "1个",
                            "defense" => "200G",
                            "monthlyPay" => 3099,
                            "annualFee" => 3099 * 12
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "X5672*2 8核",
                            "ram" => "32G",
                            "disk" => "240G SSD/IT SATA",
                            "bandwidth" => "100M",
                            "ip" => "1个",
                            "defense" => "300G",
                            "monthlyPay" => 4999,
                            "annualFee" => 4999 * 12
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "E5530*2 8核",
                            "ram" => "8G",
                            "disk" => "240G SSD",
                            "bandwidth" => "10M独享",
                            "ip" => "1个",
                            "defense" => "无防",
                            "monthlyPay" => 899,
                            "annualFee" => 899 * 12
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "E5530*2 8核",
                            "ram" => "16G",
                            "disk" => "300G SAS",
                            "bandwidth" => "50M独享",
                            "ip" => "1个",
                            "defense" => "无防",
                            "monthlyPay" => 1799,
                            "annualFee" => 1799 * 12
                        ],
                        [
                            "line" => "西安电信",
                            "format" => "E5530*2 8核",
                            "ram" => "32G",
                            "disk" => "300G SAS/1T SATA",
                            "bandwidth" => "100M独享",
                            "ip" => "1个",
                            "defense" => "无防",
                            "monthlyPay" => 2399,
                            "annualFee" => 2399 * 12
                        ]
                    ]
                ]
            ]
        ];
        if($page!=="index") {
            $template = "http/product";
        }
        // dump($data[$page]);
        return view($template,[
            "page" => $page,
            "data" => array_key_exists($page,$data) ? $data[$page] : []
        ]);
    }
}
