<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\BusinessModel;
// 选择机房时使用
use App\Admin\Models\Idc\MachineModel;
use App\Admin\Models\Idc\Cabinet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 后台业务控制器
 */
class BusinessController extends Controller
{
    use ModelForm;

    /**
     * 在产生业务时选择机房，根据机房去查找对应机房的机器/机柜(App\Admin\Models\Idc\MachineModel@machineroom)
     * @return json 返回机房相关的数据和状态信息
     */
    public function machineroom(){
    	$machineroom = new MachineModel();
    	$return = $machineroom->machineroom();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 在产生业务前根据选择的机房，查找对应机房的机器(App\Admin\Models\Idc\MachineModel@selectMachine)
     * @param  Request $request [description]
     * @return json           返回对应机房的信息或者数据
     */
    public function selectMachine(Request $request){
		$where = $request->only(['machineroom','business_type']);
		$machine = new MachineModel();
		$return = $machine->selectMachine($where);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 根据机房选择客户机柜(App\Admin\Models\Idc\Cabinet@selectCabinet)
     * @param  Request $request [description]
     * @return json           返回对应机房的机柜信息
     */
    public function selectCabinet(Request $request){
        $where = $request->only(['machineroom']);
        $cabinet = new Cabinet();
        $return = $cabinet->selectCabinet($where);
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 进行业务的创建
     * @param  Request $request [description]
     * @return json           返回订单创建的提示信息
     */
    public function insertBusiness(Request $request){
		$insert = $request->only(['client_id','machine_number','resource_detail','money','length','business_note','business_type']);
		$business = new BusinessModel();
		$return = $business->insertBusiness($insert);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }
// security安全
    /**
     * 信安部门查看业务数据获取
     * @return json 返回相关的数据和状态及提示信息
     */
    public function securityBusiness(){
		$security = new BusinessModel();
		$return = $security->securityBusiness();
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 信安部门对业务进行审核操作
     * @return json 返回相关操作的数据和状态及提示信息
     */
    public function checkBusiness(Request $request){
		$data = $request->only(['business_number','business_status','check_note']);
		$check = new BusinessModel();
		$return = $check->checkBusiness($data);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 业务员手动对客户的业务进行启用，针对后付费客户群体
     * @param  Request $request [description]
     * @return json 			返回相关操作的数据和状态及提示信息
     */
    public function enableBusiness(Request $request){
    		$enable = $request->only(['id','business_status']);
    		$enable_business = new BusinessModel();
    		$return = $enable_business->enableBusiness($enable);
    		return tz_ajax_echo($return,$return['msg'],$return['code']);
    }

    /**
     * 业务员和管理员查看对应客户的业务数据
     * @param  Request $request [description]
     * @return json           返回相关操作的数据和状态及提示信息
     */
    public function showBusiness(Request $request){
		$show = $request->only(['client_id']);
		$show_business = new BusinessModel();
		$return = $show_business->showBusiness($show);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 业务后台删除
     * @param  Request $request [description]
     * @return json           返回相关操作的数据和状态提示及信息
     */
    public function deleteBusiness(Request $request){
        $delete_id = $request->only(['delete_id']);
        $delete = new BusinessModel();
        $return = $delete->deleteBusiness($delete_id);
        return tz_ajax_echo($return,$return['msg'],$return['code']);
    }

    /**
     * 信安添加业务获取业务员信息
     * @return json [description]
     */
    public function selectSalesman(){
        $salesman = DB::table('admin_users')
                        ->join('oa_staff','admin_users.id','=','oa_staff.admin_users_id')
                        ->join('tz_department','oa_staff.department','=','tz_department.id')
                        ->where('tz_department.sign',4)
                        ->select('admin_users.id','admin_users.name')
                        ->distinct()
                        ->get();
        if(empty($salesman)){
            return tz_ajax_echo([],'无业务员信息',0);
        }
        return tz_ajax_echo($salesman,'业务员信息获取成功',1);
    }

    /**
     * 获取业务员名下的所有客户
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function selectUsers(Request $request){
        $salesman_id = $request->only(['salesman_id']);
        $client = DB::table('tz_users')->where($salesman_id)->select('id','name','email')->get();
        if(empty($client)){
            return tz_ajax_echo([],'该业务员名下暂无客户',0);
        }
        return tz_ajax_echo($client,'业务员名下客户信息获取成功',1);
    }
    
    /**
     * 信安录入业务数据
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function securityInsertBusiness(Request $request){
        $insert = $request->only(['client_id','sales_id','resource_id','money','length','business_note','business_type']);
        $business = new BusinessModel();
        $result = $business->securityInsertBusiness($insert);
        return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }
}
