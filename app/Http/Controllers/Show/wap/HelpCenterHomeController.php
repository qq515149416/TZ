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
		//活页页码,没有的就算第一页
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

		$per_page = 8;//每页显示数量
		$current_page = $page;//当前页
		$offset = ($current_page - 1) * $per_page;//跳过多少条
		$total = HelpContentsModel::where($content_where)->count();//总共多少条
		$result = HelpContentsModel::where($content_where)->orderBy('created_at','desc')->offset($offset)->limit($per_page)->get();//当前页的数据
		$last_page = ceil($total/$per_page);//计算最后一页
		//组个分页数组
		$page_members = [
			'category_id'	=> $category_id,
			'current_page'	=> $current_page,
			'max_page'	=> $last_page,
		];
		//拆关键词
		foreach ($result as $k => $v) {
			$result[$k]->keywords = explode(',', $result[$k]->keywords);
		}
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
