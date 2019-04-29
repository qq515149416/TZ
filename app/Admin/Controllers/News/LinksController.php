<?php

namespace App\Admin\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 use App\Admin\Requests\News\LinksRequest;
 use App\Admin\Models\News\LinksModel;
/**
 * 友情链接控制器
 */
class LinksController extends Controller
{

	/**
	 * 添加友情链接
	 * @param  Request $request [description]
	 * @return json          
	 */
	public function insert(LinksRequest $request){
		
		$par = $request->only(['name','url','sort','description','user','order']);

		$links_model = new LinksModel();
		$return = $links_model->insert($par);

		if($return){
			return tz_ajax_echo([],'添加成功',1);
		}else{
			return tz_ajax_echo([],'添加失败',0);
		}
		
	}

	/**
	 * 删
	 * @param  Request $request [description]
	 * @return json         
	 */
	public function del(LinksRequest $request){
		$par = $request->only(['del_id']);

		$links_model = new LinksModel();
		$return = $links_model->del($par['del_id']);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 改
	 * @param  Request $request [description]
	 * @return json    
	 */
	public function edit(LinksRequest $request){
		$par = $request->only(['name','url','sort','description','user','order','edit_id']);

		$links_model = new LinksModel();

		$return = $links_model->edit($par);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 查
	 * @param  Request $request [description]
	 * @return json           返回对应机房的信息或者数据
	 */
	public function show(LinksRequest $request){
	
		$links_model = new LinksModel();
		$return = $links_model->show();

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}
  
}
