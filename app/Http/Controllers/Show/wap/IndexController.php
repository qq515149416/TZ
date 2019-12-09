<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;
use App\Http\Models\News\News;


class IndexController extends Controller
{
	public function index()
	{
		//orderByRaw("FIELD(status, " . implode(", ", [1, 0, 2, 3]) . ")")->orderBy("endTime",'desc')
		//$news = News::where('home_status',1)->limit(3)->get();
		$news = News::orderByRaw("FIELD(home_status, 1,0)")->orderBy('created_at' , 'desc')->limit(3)->get();
	
		return view("wap/index",[
			"page" 			=> "index",
			"news_template"	=> 'wap.index.news',
			"news"			=> $news,
		]);
	}
}
