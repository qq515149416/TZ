<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;
use Illuminate\Http\Request;


class HelpCenterController extends Controller
{
	public function index($page=NULL)
	{
	$helpContentsModel = new HelpContentsModel();
	$where = [
		["parent_id", "<>" , 0],
		["status", "=", 1]
	];
	if($page) {
		$where = [
			["parent_id", "=" , $page],
			["status", "=", 1]
		];
	}
	$nav_main = HelpCategoryModel::where(["parent_id" => 0,"status" => 1,])->orderBy('created_at' , 'desc')->get();
	foreach ($nav_main as $k => $v) {
		$nav_arr[$k]['id_arr'] = [ $nav_main[$k]['id'] ];
		$son_id = HelpCategoryModel::where(["parent_id" => $nav_main[$k]['id'] , "status" => 1])->get(['id']);
		
		while (!$son_id->isEmpty()) {
			$son_arr = [];

			for ($i=0; $i < count($son_id); $i++) { 
				$son_arr[] = $son_id[$i]['id'];
				$nav_arr[$k]['id_arr'][]  = $son_id[$i]['id'];
			}

			$son_id = HelpCategoryModel::whereIn("parent_id" , $son_arr)
							->where("status" ,1)
							->get(['id']);
		}
		$nav_main[$k]['num'] = HelpContentsModel::whereIn("category_id" , $nav_arr[$k]['id_arr'] )
							->where('state' , 1)
							->count();
	}

	$helpTagModel = new HelpTagModel();
	return view("wap/help_center",[
		"nav_main" => $nav_main,
		"nav" 	=> HelpCategoryModel::where($where)->latest('created_at')->paginate(10),
		"page"	=> 'help_center',
	]);
	}
}