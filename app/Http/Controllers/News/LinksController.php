<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 use App\Http\Models\News\LinksModel;
/**
 * 友情链接控制器
 */
class LinksController extends Controller
{

	/**
	 * 获取友情链接
	 * @param  
	 * @return json          
	 */
	public function getLinks(){
		$model = New LinksModel();

		$link = $model->getLinks();

		return tz_ajax_echo($link['data'] , $link['msg'] , $link['code']);
	}
  
}
