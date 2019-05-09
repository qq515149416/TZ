<?php

namespace App\Admin\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 use App\Admin\Requests\News\PromotionRequest;
 use App\Admin\Models\News\PromotionModel;
/**
 * 促销活动控制器
 */
class PromotionController extends Controller
{

	/**
	 * 添加友情链接
	 * @param  Request $request [description]
	 * @return json          
	 */
	public function insert(PromotionRequest $request){
		
		$par = $request->only(['img', 'link','title','top','digest','end_at','order']);

		$par['img'] = json_encode($par['img']);
		$par['link'] = json_encode($par['link']);

		if($par['end_at']<date('Y-m-d H:i:s')){
			return tz_ajax_echo([],'结束时间需比当前时间大',0);
		}

		$links_model = new PromotionModel();
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
	public function del(PromotionRequest $request){
		$par = $request->only(['del_id']);

		$links_model = new PromotionModel();
		$return = $links_model->del($par['del_id']);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 改
	 * @param  Request $request [description]
	 * @return json    
	 */
	public function edit(PromotionRequest $request){
		$par = $request->only(['img', 'link','title','top','digest','end_at','order','edit_id','sale_status']);

		$links_model = new PromotionModel();
		if(isset($par['img'])){
			$par['img'] = json_encode($par['img']);
		}
		if(isset($par['link'])){
			$par['link'] = json_encode($par['link']);
		}

		$return = $links_model->edit($par);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 查
	 * @param  Request $request [description]
	 * @return json           返回对应机房的信息或者数据
	 */
	public function show(PromotionRequest $request){
	
		$links_model = new PromotionModel();
		$return = $links_model->show();

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}
  
}
