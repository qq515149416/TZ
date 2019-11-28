<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Models\News\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| News Controller
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/

	
	public function getNewsList(Request $request)
	{
		$input = $request->all();
		if(!isset($input['tid'])){
			return tz_ajax_echo([],'获取文章列表失败!!请提供文章类型id',0);
		}	
		if(isset($input['home_status'])){
			$home_status = 1;
		}else{
			$home_status = 0;
		}

		$tid = $input['tid'];
		$newsModel = new News();
		$news = $newsModel->getNewsList($tid,$home_status);

		if($news == false){
			$return['data']	= '';
			$return['msg']	= '无此类型消息数据!';
			$return['code']	= 0;
		}else{
			$return['data']	= $news;
			$return['msg']	= '获取信息成功!!';
			$return['code']	= 1;
		}

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	public function getNewsDetails(Request $request)
	{
		 $input = $request->all();
		 if(!isset($input['id'])){
			return tz_ajax_echo([],'请提供文章id',0);
		}
		$id = $input['id'];
		$newsModel = new News();
		$news = $newsModel->getNewsDetails($id);

		if($news == NULL){
			$return['data']	= '';
			$return['msg']	= '无数据!';
			$return['code']	= 0;
		}else{
			$return['data']	= $news;
			$return['msg']	= '获取信息成功!!';
			$return['code']	= 1;
		}

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

}
