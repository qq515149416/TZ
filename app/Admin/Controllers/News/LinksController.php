<?php

namespace App\Admin\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 use App\Admin\Models\News\LinksRequest;
 use App\Admin\Models\News\LinksModel;
/**
 * 友情链接控制器
 */
class LinksController extends Controller
{

	/**
	 * 添加友情链接
	 * @param  Request $request [description]
	 * @return json           返回对应机房的信息或者数据
	 */
	public function insert(Request $request){
		dd('666');
		$where = $request->only(['machineroom','business_type']);
		$machine = new MachineModel();
		$return = $machine->selectMachine($where);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 删
	 * @param  Request $request [description]
	 * @return json           返回对应机房的信息或者数据
	 */
	public function del(Request $request){
		$where = $request->only(['machineroom','business_type']);
		$machine = new MachineModel();
		$return = $machine->selectMachine($where);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 改
	 * @param  Request $request [description]
	 * @return json           返回对应机房的信息或者数据
	 */
	public function edit(Request $request){
		$where = $request->only(['machineroom','business_type']);
		$machine = new MachineModel();
		$return = $machine->selectMachine($where);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 查
	 * @param  Request $request [description]
	 * @return json           返回对应机房的信息或者数据
	 */
	public function show(Request $request){
		$where = $request->only(['machineroom','business_type']);
		$machine = new MachineModel();
		$return = $machine->selectMachine($where);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}
  
}
