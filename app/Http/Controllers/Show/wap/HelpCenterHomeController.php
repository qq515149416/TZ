<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class HelpCenterHomeController extends Controller
{
	public function index($category_id,Request $request)
	{
		$par = $request->only(['page']);
		if (isset($par['page'])) {
			$page = $par['page'];
		}else{
			$page = 1;
		}
		
		

		$helpContentsModel = new HelpContentsModel();
		$where = [
			["parent_id", "<>" , 0],
			["status", "=", 1]
		];
		if($category_id) {
			$where = [
				["parent_id", "=" , $category_id],
				["status", "=", 1]
			];
		}
		$content_where = [
			['category_id' , "=" , $category_id],
			["state" , "=" , 1]
		];

		$per_page = 8;
		$current_page = $page;
		$offset = ($current_page - 1) * $per_page;
		$total = HelpContentsModel::where($content_where)->count();
		$result = HelpContentsModel::where($content_where)->orderBy('created_at','desc')->offset($offset)->limit($per_page)->get();
		$last_page = ceil($total/$per_page);

		$page_members = [
			'category_id'	=> $category_id,
			'current_page'	=> $current_page,
			'max_page'	=> $last_page,
		];
		//dd($members);
		// $son_nav = HelpCategoryModel::where($where)->get();
		// dd($son_nav->toArray());
		$helpTagModel = new HelpTagModel();
		return view("wap/help_center_home",[
			"nav_now"		=> HelpCategoryModel::where([
							"id" => $category_id,
						])->value('name'),
			"nav_main" 		=> HelpCategoryModel::where([
							"parent_id" => 0,
							"status" => 1,
						])->get(),
			"son_nav"   		=> HelpCategoryModel::where($where)->get(),
			"page"  			=> 'help_center',
			"content"		=> $result,
			"page_members"	=> $page_members,
		]);
	}


}
