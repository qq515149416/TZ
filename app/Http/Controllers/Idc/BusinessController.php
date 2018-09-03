<?php

namespace App\Http\Controllers\Idc;

use App\Http\Controllers\Controller;
use App\Http\Models\Idc\Business;
use App\Http\Requests\Idc\BusinessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Business Controller 		-业务表的前端控制器
	|--------------------------------------------------------------------------
	| Author 			kiri / 420541662@qq.com
	| --------------------------------------------------------------------------
	|
	|
	*/



	/**
	* 获取登录中用户的业务列表的接口
	* @return 订单的支付情况,
	*/
	public function getBusinessList()
	{
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();
		$businessModel = new Business();
		$list = $businessModel->getList($user_id);
		$list = json_decode(json_encode($list),true);
		echo "<pre>";
		print_r($list);

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
