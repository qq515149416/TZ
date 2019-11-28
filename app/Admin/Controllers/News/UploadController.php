<?php

// +----------------------------------------------------------------------
// | Author: 街"角．回 忆 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 处理IP的控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:20:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\News;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\News\Upload;
use App\Admin\Requests\News\UploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UploadController extends Controller
{
	use ModelForm;

	public function putImages(UploadRequest $request){
		$par = $request->only(['images']);

		if( !is_array($par['images']) ){
			return json_encode(['errno' => 1]);
		}

		$model = new Upload();
		$res = $model->putImages($par['images']);
		if($res['code'] != 1){
			return json_encode(['errno' => 1 , 'data' => $res['data'], 'msg' => $res['msg'] ]);
		}else{
			return json_encode(['errno' => 0 , 'data' => $res['data'] ]);
		}
		
	}

	public function showImages(){
		$model = new Upload();
		$res = $model->showImages();

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	public function del(UploadRequest $request){

		
		$par = $request->only(['file_id']);
		$model = new Upload();
		$res = $model->del($par['file_id']);
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
