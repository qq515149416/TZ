<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use App\Admin\Models\News\NavModel;
use App\Admin\Models\News\RusteeshipServerModel;

use Illuminate\Http\Request;

class HostingController extends Controller
{
    public function index($page,Request $request)
    {
        $tdk = NavModel::where('url','like','%'.$request->path().'%')->select("id","seo_title as title","seo_keywords as keywords","seo_description as description")->first();
        $data = NavModel::find($tdk->id)->machineRooms()->first()->toArray();

        $data["data"] = RusteeshipServerModel::where([
            'machine_room_id' => $data["id"],
            'nav_id' => NavModel::where('alias', $page)->first()->id
        ])->get();
        // dd($data["data"]->toArray());
        // $data = [
        //     "hengyang" => [
        //         "name" => "湖南衡阳机房",
        //         "overview" => "腾正科技湖南衡阳机房总建筑面积约3000㎡，采用T3+标准机房，BGP三线（电信、联通、移动），1300余个机柜42U国际标准机柜，860G直连中国电信骨干网。",
        //         "grade" => "准T3机房",
        //         "detail_url" => "javascript:;",
        //         "customer_representative" => "",
        //         "data" => [
        //             [
        //                 "line" => "衡阳电信",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "40G",
        //                 "monthly_payment" => 450,
        //                 "annual_fee" => 4750,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "衡阳电信",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "40G",
        //                 "monthly_payment" => 550,
        //                 "annual_fee" => 5850,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "衡阳双线",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "40G",
        //                 "monthly_payment" => 550,
        //                 "annual_fee" => 5850,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "衡阳双线",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "40G",
        //                 "monthly_payment" => 700,
        //                 "annual_fee" => 7500,
        //                 "buy" => "javascript:;"
        //             ]
        //         ]
        //     ],
        //     "huizhou" => [
        //         "name" => "广东惠州机房",
        //         "overview" => "腾正科技广东惠州机房总建筑面积约8000㎡，采用T3+标准机房，BGP三线（电信、联通、移动），2800余个机柜42U国际标准机柜，1600G直连中国华南地区国际出口电信骨干网，300G+集群防火墙，毫秒级的网络连接实时数据备份管理。",
        //         "grade" => "准T3机房",
        //         "detail_url" => "javascript:;",
        //         "customer_representative" => "",
        //         "data" => [
        //             [
        //                 "line" => "惠州电信",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 500,
        //                 "annual_fee" => 5300,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "惠州电信",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 700,
        //                 "annual_fee" => 7500,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "惠州双线",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1对",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 600,
        //                 "annual_fee" => 6400,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "惠州双线",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1对",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 900,
        //                 "annual_fee" => 9700,
        //                 "buy" => "javascript:;"
        //             ]
        //         ]
        //     ],

        //     "xian" => [
        //         "name" => "陕西西安机房",
        //         "overview" => "国家AAAA级机房，机房建筑面积53851平方米，拥有5000个42U标准机柜；机房不仅采用直连互联网骨干点的10T总带宽，还采用320G 集群防火墙设置，为客户提供安全可靠、快速全面的数据存放业务及其它增值服务；在电力设备方面，西安机房从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统，系统自动切换，持续供电保障。",
        //         "grade" => "准T4机房",
        //         "detail_url" => "javascript:;",
        //         "customer_representative" => "",
        //         "data" => [
        //             [
        //                 "line" => "西安电信",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 500,
        //                 "annual_fee" => 5300,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安电信",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 700,
        //                 "annual_fee" => 7500,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安联通",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 500,
        //                 "annual_fee" => 5300,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安联通",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 700,
        //                 "annual_fee" => 7500,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安移动",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 500,
        //                 "annual_fee" => 5300,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安移动",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1个",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 700,
        //                 "annual_fee" => 7500,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安双线",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1对",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 600,
        //                 "annual_fee" => 6400,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安双线",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1对",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 900,
        //                 "annual_fee" => 9700,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安三线",
        //                 "specification" => "1U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1对",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 750,
        //                 "annual_fee" => 8200,
        //                 "buy" => "javascript:;"
        //             ],
        //             [
        //                 "line" => "西安三线",
        //                 "specification" => "2U",
        //                 "current" => "<0.7A",
        //                 "bandwidth" => "G口20M独享",
        //                 "ip" => "1对",
        //                 "defense" => "50G",
        //                 "monthly_payment" => 1050,
        //                 "annual_fee" => 11500,
        //                 "buy" => "javascript:;"
        //             ]
        //         ]
        //     ]

        // ];
        return view("http/hosting",[
            "page" => $page,
            "tdk" => $tdk,
            "data" => $data,
            "nav" => NavModel::where('parent_id',12)->get()
        ]);
    }
}
