<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Customer\WhiteListModel;
use App\Http\Requests\Customer\WhiteListRequest;
use Illuminate\Support\Facades\Auth;


/**
 * 前台客户有关的白名单的控制器
 */
class WhiteListController extends Controller
{
	//
	/**
	 * 根据白名单对应的状态进行查询
	 * @param  Request $request [description]
	 * @return json           返回相关的数据和状态信息
	 */
	public function showWhiteList(WhiteListRequest $request){
		$white_status = $request->only(['white_status']);
		$show_white_list  = new WhiteListModel();
		$return = $show_white_list->showWhiteList($white_status);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 白名单信息的提交
	 * @param  Request $request [description]
	 * @return json           返回相关的数据和状态提示及信息
	 */
	public function insertWhiteList(WhiteListRequest $request){
		$insert_white = $request->only(['white_ip','domain_name','record_number','binding_machine','submit_note']);
		$insert = new WhiteListModel();
		$insert_result = $insert->insertWhiteList($insert_white);
		return tz_ajax_echo($insert_result['data'],$insert_result['msg'],$insert_result['code']);
	}

	/**
	 * 对要提交的域名进行提交前查询该用户是否提交过
	 * @param  Request $request [description]
	 * @return json           返回相关的状态提示及信息
	 */
	public function checkDomainName(WhiteListRequest $request){
		$domain_name = $request->only(['domain_name']);
		$check = new WhiteListModel();
		$check_result = $check->checkDomainName($domain_name);
		return tz_ajax_echo($check_result,$check_result['msg'],$check_result['code']);	
	}

	/**
	 * 提交白名单前对绑定的IP进行查询
	 * @param  Request $request [description]
	 * @return json           返回查询相关的状态及提示信息
	 */
	public function checkIp(WhiteListRequest $request){
		$white_ip = $request->only(['white_ip']);
		$check_ip = new WhiteListModel();
		$ip_result = $check_ip->checkIp($white_ip);
		return tz_ajax_echo($ip_result['data'],$ip_result['msg'],$ip_result['code']);	
	}

	/**
	 * 取消白名单操作
	 * @param  Request $request [description]
	 * @return json           返回取消时的相关状态及提示信息
	 */
	public function cancelWhiteList(Request $request){
		$id = $request->only(['cancel_id']);
		$cancel = new WhiteListModel();
		$cancel_result = $cancel->cancelWhiteList($id);
		return tz_ajax_echo($cancel_result,$cancel_result['msg'],$cancel_result['code']);
	}

	public function test(Request $request){
		$id = $request->only(['cancel_id']);
		$cancel = new WhiteListModel();
		$cancel_result = $cancel->test();
		return tz_ajax_echo($cancel_result,$cancel_result['msg'],$cancel_result['code']);
	}

	/**
	 * 高防业务提交白名单申请
	 * @param  Request $request [description]
	 * @return json           返回提交结果及提示信息
	 */
	public function insertWhiteListForDIP(WhiteListRequest $request){
		$par = $request->only([ 'b_num'	, 'domain_name'	 , 'record_number' , 'submit_note']);
		$model = new WhiteListModel();
		$insert_res = $model->insertWhiteListForDIP($par);
		return tz_ajax_echo($insert_res['data'],$insert_res['msg'],$insert_res['code']);
	}

}
