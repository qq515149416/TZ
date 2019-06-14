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
	 * 添加促销活动
	 * @param  Request $request [description]
	 *$img 	-图片路径(用那个上传接口获取路径)	$link 	-活动链接 	$title 	-活动标题 	$top 	-置顶状态
	 *$digest 	-活动摘要 	$end_at 	-结束时间 	$pro_order 	-排序 	$start_at 	-开始时间
	 * @return json          
	 */
	public function insert(PromotionRequest $request){
		//获取信息
		$par = $request->only(['img', 'link','title','top','digest','end_at','pro_order','start_at']);

		$par['img'] = json_encode($par['img']);
		$par['link'] = json_encode($par['link']);

		if($par['end_at']<date('Y-m-d H:i:s')){
			return tz_ajax_echo([],'结束时间需比当前时间大',0);
		}
		if($par['end_at']<$par['start_at']){
			return tz_ajax_echo([],'结束时间需比开始时间大',0);
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
	 * @param  Request $del_id 	-要删除的id
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
	 * @param  Request  $edit_id 	-需编辑的id  ; 其余同上
	 * @return json    
	 */
	public function edit(PromotionRequest $request){
		$par = $request->only(['img', 'link','title','top','digest','end_at','pro_order','edit_id','start_at']);

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
	 * @param  Request  
	 * @return json           返回所有促销活动信息
	 */
	public function show(PromotionRequest $request){
	
		$links_model = new PromotionModel();
		$return = $links_model->show();

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}
  
}
