<?php

namespace App\Http\Controllers\Idc;

use App\Http\Controllers\Controller;
use App\Http\Models\Idc\Business;
use App\Http\Requests\Idc\BusinessRequest;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Business Controller 		-业务表的前端控制器
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/

	
	public function getBusinessList(BusinessRequest $request)
	{
		return 123;
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
