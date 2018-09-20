<?php

namespace App\Admin\Controllers\Work;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Work\WhiteListModel;
use App\Admin\Requests\Work\WhiteListRequest;
use Illuminate\Http\Request;

use Encore\Admin\Facades\Admin;

/**
 * 白(黑)名单
 */
class WhiteListController extends Controller
{
	use ModelForm;

	/**
	 * 根据对应的IP使用状态进行信息查询
	 * @param  $ip 		-需要检测的IP
	 * @return  json           	返回
	 */
	public function checkIP(WhiteListRequest $request)
	{
		$info = $request->only(['ip']);	
		$ip = $info['ip'];

		$model = new WhiteListModel();
		$res = $model->checkIP($ip);
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	/**
	 * 根据对应白名单状态进行信息查询
	 * @param  	Request 	$white_status
	 * @return  	json          	 返回相关的数据和状态信息
	 */	
 
	public function showWhiteList(WhiteListRequest $request){
		
			$where = $request->only(['white_status']);
			$showwhitelist = new WhiteListModel();
			$return = $showwhitelist->showWhiteList($where);
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
		
	}

	/**
	 * 白名单信息的提交
	 * @param  Request  	white_ip		-IP地址;domain_name	-域名;record_number	-备案编号;binding_machine	-IP绑定的机器编号
	 *			customer_id	-客户ID;customer_name	-客户姓名;submit_note	-备注;
	 * @return json           返回录入状态
	 */
	public function insertWhiteList(WhiteListRequest $request){
		
			$insertdata = $request->only(['white_ip','domain_name','record_number','binding_machine','customer_id','customer_name','submit_note']);
			
			$insert = new WhiteListModel();
			$return = $insert->insertWhiteList($insertdata);
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
		
	}

	/**
	 * 对白名单进行审核
	 * @param  Request 	white_status	-审核结果;check_note	-备注;id 	-被审核的申请单ID
	 * @return json           	返回审核结果录入状态
	 */
	public function checkWhiteList(WhiteListRequest $request){
		
			$checkdata = $request->only(['white_status','check_note','id']);
			$check = new WhiteListModel();
			$return = $check->checkWhiteList($checkdata);
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
		
	}

	/**
	 * 删除对应的白名单信息
	 * @param  Request 	delete_id	-需要删除的申请单ID
	 * @return   json           	返回删除结果
	 */
	public function deleteWhiteList(WhiteListRequest $request){
		
			$id = $request->get('delete_id');
			$delete = new WhiteListModel();
			$result = $delete->deleteWhiteList($id);
			return tz_ajax_echo('',$result['msg'],$result['code']);
		
	}
}
