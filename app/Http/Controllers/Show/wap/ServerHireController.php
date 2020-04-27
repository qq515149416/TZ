<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;

use App\Admin\Models\News\NavModel;
use App\Admin\Models\News\MachineRoomModel;
use App\Admin\Models\News\RentServerModel;
use App\Admin\Models\News\RecommendServerModel;
use App\Admin\Models\News\ForeignModel;
use Illuminate\Http\Request;

class ServerHireController extends Controller
{
	public function index($page,$room = "",Request $request)
	{

		$tdk = [
            "title" => "高防服务器-高防云服务器-游戏高防服务器-东莞高防服务器[腾正科技]",
            "keywords" => "高防服务器，高防云服务器，游戏高防服务器，高防服务器价格,东莞高防服务器，百G清洗高防服务器,西安高防服务器，BGP高防服务器",
            "description" => "腾正高防服务器，为您提供优质独享大宽带防御高防物理服务器，高防云服务器，游戏高防服务器租用，网站高防服务器托管、租用、配置及价格等信息服务咨询热线0769-22226555"
        ];
        if($page!=='gaofang') {
            $tdk = NavModel::where('url','like','%'.$request->path().'%')->select("seo_title as title","seo_keywords as keywords","seo_description as description")->first();
		}
		// if($page=="HKT") {
        //     $nav_id = NavModel::where('alias','like','%'.$page.'%')->first()->id;
        //     $nav_data = NavModel::find($nav_id);
        //     if(!$room) {
        //         $room = $nav_data->machineRooms()->first()->alias;
        //     }
        //     $current_room = $nav_data->machineRooms()->where("alias",$room)->first();
        //     return view("wap/server_hire",[
        //         "page" => $page,
        //         "son_nav" => NavModel::where('parent_id',$nav_data->parent_id['id'])->get(),
        //         "machine_rooms" => $nav_data->machineRooms()->get(),
        //         "room" => $room,
        //         "current_room" => $current_room,
        //         "data" => ForeignModel::where("machine_room_id",$current_room->id)->where("nav_id",$nav_data->id)->get()
        //     ]);
        // }
        $template = "wap/server_hire";
        $productData = [
            "title" => "服务器租用",
            "description" => "自主准T4、T3机房，从服务器设备、环境到维护的一站式服务，为您提供定制化硬件采购解决方案<br/>以租用的方式独享专用高性能服务器及全完自主管理权限，满足您不同时期业务发展需求！",
            "data" => RecommendServerModel::all()
        ];
        $machine_rooms = MachineRoomModel::all();
        $machine_room = [];
        $data = [];
        if($page!=='index'&&$page!=='gaofang') {
            $nav_id =  NavModel::where('alias',$page)->first()['id'];
            $machine_rooms = NavModel::find($nav_id)->machineRooms()->get();
        }
        if($room) {
            $machine_room_id = MachineRoomModel::where('alias',$room)->first()['id'];
            $machine_room = MachineRoomModel::find($machine_room_id);
            $data = RentServerModel::where([
                'machine_room_id' => MachineRoomModel::find($machine_room_id)->id,
                'nav_id' => NavModel::where('alias',$page)->first()['id']
            ])->get();
            $tdk = [
                "title" => $machine_room->name.$machine_room->navs()->first()->seo_title,
                "keywords" => $machine_room->name.$machine_room->navs()->first()->seo_keywords,
                "description" => $machine_room->name.$machine_room->navs()->first()->seo_description
            ];
		}
		// if($page!=="index"&&$page!=="gaofang") {
        //     $template = "wap/server_hire";
		// }
		


		$product = '服务器租用';

		$category_model = new HelpCategoryModel();
		$help_arr = $category_model->getIdByProduct($product);
		//dd($help_arr);
		if (count($help_arr) > 0) {
		
			$category_id = [];
			for ($i=0; $i < count($help_arr); $i++) { 
				$category_id = array_merge($category_id , $help_arr[$i]['id_arr']);
			}
			$help = HelpContentsModel::whereIn('category_id', $category_id)
							->where('state' , 1)
							 ->inRandomOrder()
							->take(5)
							->get();
			$help_id = $category_id[0];
		}else{
			$help = HelpContentsModel::where('state' , 1)
							 ->inRandomOrder()
							->take(5)
							->get();
			$help_id = 0;
		}
		// return view("wap/server_hire",[

		// 	"help"			=> $help,
		// 	"help_template"	=> 'wap.product.help',
		// 	"help_id"		=> $help_id,
		// 	"page" 			=> "server_hire"
		// ]);
		return view($template,[
			"help"			=> $help,
			"help_template"	=> 'wap.product.help',
			"help_id"		=> $help_id,
			// "page" 			=> "server_hire",
            "page" => $page,
            "data" => $data,
            "productData" => $productData,
            "room" => $room,
            "tdk" => $tdk,
            "nav" => NavModel::where('parent_id',3)->get(),
            "machine_rooms" => $machine_rooms,
            "machine_room" => $machine_room
        ]);

	}
}
