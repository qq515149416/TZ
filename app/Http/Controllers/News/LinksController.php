<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\News\LinksRequest;
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
	public function getLinks(LinksRequest $request){
		$par = $request->only(['sort']);

		$model = New LinksModel();

		$link = $model->getLinks($par['sort']);

		return tz_ajax_echo($link['data'] , $link['msg'] , $link['code']);
	}
  
}
