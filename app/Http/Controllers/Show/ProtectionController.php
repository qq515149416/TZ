<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use App\Http\Models\DefenseIp\PackageModel;

class ProtectionController extends Controller
{
    public function index($page)
    {
        $tabs = [
            [
                "name" => "高防CDN",
                "href" => "/protection/high-defense-cdn"
            ],
            [
                "name" => "DDOS高防IP",
                "href" => "/dist/highDefense.html"
            ],
            [
                "name" => "防C盾",
                "href" => "/protection/c-shield"
            ],
            [
                "name" => "高防服务器",
                "href" => "/zuyong/gaofang"
            ]
        ];
        switch ($page) {
            case 'index':
                return view("http/protection/protection",[
                    "tabs" => $tabs
                ]);
                break;
            case 'high-defense-ip':
                // $model = new PackageModel();

                // $list = $model->showPackage();
                // return view("http/highDefenseIp",[
                //     "data" => $list['data']
                // ]);
                return redirect()->action('Show\ProtectionController@gaofang');
                break;
            case 'high-defense-cdn':
                return view("http/protection/highDefenseCdn",[
                    "tabs" => $tabs
                ]);
                break;
            case 'c-shield':
                return view("http/protection/cShield",[
                    "tabs" => $tabs
                ]);
                break;
        }
    }
    public function gaofang()
    {
        $tabs = [
            [
                "name" => "高防CDN",
                "href" => "/protection/high-defense-cdn"
            ],
            [
                "name" => "DDOS高防IP",
                "href" => "/dist/highDefense.html"
            ],
            [
                "name" => "防C盾",
                "href" => "/protection/c-shield"
            ],
            [
                "name" => "高防服务器",
                "href" => "/zuyong/gaofang"
            ]
        ];
        $model = new PackageModel();

		$list = $model->showPackage();
        return view("http/protection/highDefenseIp",[
            "data" => $list['data'],
            "tabs" => $tabs
        ]);
    }
    public function gaofangApi()
    {
        $model = new PackageModel();

        $list = $model->showPackage();
        
        return $list;
    }
}
