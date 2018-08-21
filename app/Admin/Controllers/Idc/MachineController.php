<?php

namespace App\Admin\Controllers\Idc;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\MachineModel;
use App\Admin\Requests\Idc\MachineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 机器的相关操作接口
 */
class MachineController extends Controller
{
    use ModelForm;
// Rent 租用
    /**
     * 查找业务类型为租用的机器
     * @return [type] [description]
     */
    public function showRentMachine(){
    	$showrentmachine = new MachineModel();
    	$return = $showrentmachine->showRentMachine();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }
// Deposit 托管
    /**
     * 查找业务类型为托管的机器
     * @return [type] [description]
     */
    public function showDepositMachine(){
    	$showdepositmachine = new MachineModel();
    	$return = $showdepositmachine->showDepositMachine();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }
//reserve储备，备用
	/**
     * 查找业务类型为托管的机器
     * @return [type] [description]
     */
    public function showReserveMachine(){
    	$showdepositmachine = new MachineModel();
    	$return = $showdepositmachine->showReserveMachine();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 根据传递的条件查找对应的机器
     * @return [type] [description]
     */
    public function showMachine(Request $request){
    	if($request->isMethod('get')){
    		$where = $request->only(['business_type']);
	    	$showmachine = new MachineModel();
	    	$return = $showmachine->showMachine($where);
	    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'获取机器信息失败',0);
    	}
    	
    }

    /**
     * 新增机器信息
     * @param  MachineRequest $request 字段验证
     * @return json                  将相关的状态和提示信息返回
     */
    public function insertMachine(MachineRequest $request){
    	if($request->isMethod('post')){
    		$data = $request->only(['machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note']);
    		$insertmachine = new MachineModel();
    		$return = $insertmachine->insertMachine($data);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'新增机器信息失败',0);
    	}
    }

    /**
     * 修改机器的信息
     * @param  MachineRequest $request 字段验证
     * @return json                  相关的提示信息和状态返回
     */
    public function editMachine(MachineRequest $request){
    	if($request->isMethod('post')){
    		$editdata = $request->only(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note'])
    		$editmachine = new MachineModel();
    		$return = $editmachine->editMachine($editdata);
    		return tz_ajax_echo($return,$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'修改机器信息失败',0);
    	}
    }

    /**
     * 删除对应的机器信息
     * @param  Request $request [description]
     * @return json           相关的信息提示和状态返回
     */
    public function deleteMachine(Request $request){
    	if($request->isMethod('post')){
    		$id = $request->get('delete_id');
    		$deletemachine = new MachineModel();
    		$result = $deletemachine->deleteMachine($id);
    		return tz_ajax_echo($result,$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'删除机器信息失败',0);
    	}
    }

    /**
     * 查找机房的接口
     * @return json 返回机房的相关的数据
     */
    public function machineroom(){

    	$machineroom = new MachineModel();
    	$result = $machineroom->machineroom();
    	return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 查找对应机房的机柜
     * @param  Request $request 机房的id
     * @return json           对应机房的机柜的数据
     */
    public function cabinets(Request $request){
    	if($request->idMethod('post')){
    		$roomid = $request->get('roomid');
    		$cabinet = new MachineModel();
    		$result = $cabinet->cabinets($roomid);
    		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'无法获取对应机房的机柜',0);
    	}
    }

    /**
     * 查找对应机房的IP地址数据
     * @param  Request $request 机房的id和IP所属的运营商
     * @return json           对应机房的IP信息
     */
    public function ips(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->only(['roomid','ip_company']);
    		$ips = new MachineModel();
    		$result = $ips->ips($data);
    		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'无法获取对应机房的机柜',0);
    	}
    }

}
