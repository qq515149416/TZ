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
	$helpTagModel = new HelpTagModel();
	return view("wap/help_center",[
		"nav_main" => HelpCategoryModel::where([
			"parent_id" => 0,
			"status" => 1,
		])->get(),
		"nav" 	=> HelpCategoryModel::where($where)->latest('created_at')->paginate(10),
		"page"	=> 'help_center',
	]);
	}
}