<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchResultsController extends Controller
{
	public function index(Request $request)
	{
		$par = $request->only(['keyword' , 'page']);
		if (isset($par['keyword'])) {
			$keyword = $par['keyword'];
		}else{
			$keyword = '';
		}
		if (isset($par['page'])) {
			$page = $par['page'];
		}else{
			$page = 1;
		}
		
		$per_page = 8;
		$current_page = $page;
		$offset = ($current_page - 1) * $per_page;
		$total = HelpTagModel::where("name","like","%$keyword%")->count();
		$result = HelpTagModel::where("name","like","%$keyword%")->orderBy('created_at','desc')->offset($offset)->limit($per_page)->get();
		$last_page = ceil($total/$per_page);

		$data = [];
		foreach($result as $key=>$val)
		{
			array_push($data,$val->content);
		}

		$page_members = [
			'current_page'	=> $current_page,
			'max_page'	=> $last_page,
		];

		$helpTagModel = new HelpTagModel();
		return view("wap/search_results",[
			"nav_main" 		=> HelpCategoryModel::where([
							"parent_id" => 0,
							"status" => 1
							])->get(),
			"keyword" 		=> $keyword,
			"data" 			=> $data,
			"tags" 			=> $helpTagModel->orderBy("search_count","desc")->limit(5)->get(),	
			"page"			=> $page,
			"page_members"	=> $page_members,
		]);

	}
}