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
use App\Admin\Requests\Business\BusinessRequest;


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
		$where = $request->only(['machineroom','business_type','customer_id']);
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
    public function insertBusiness(BusinessRequest $request){
		$insert = $request->only(['client_id','machine_number','resource_detail','money','length','business_note','business_type']);
		$business = new BusinessModel();
		$return = $business->insertBusiness($insert);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 机柜业务下添加托管机器
     * @param  Request $request 'customer'--客户id,'parent_business'--机柜业务id,
     * 'resource_type'--资源类型,'resource_id'--资源id,'price'--价格,'duration'--时长,'business_note'--业务备注
     * @return [type]           [description]
     */
    public function cabinetMachine(Request $request){
        $param = $request->only(['customer','parent_business','resource_type','resource_id','price','duration','business_note']);
        $cabinet_machine = new BusinessModel();
        $return = $cabinet_machine->cabinetMachine($param);
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
		$data = $request->only(['business_number','business_status','check_note','parent_business']);
		$check = new BusinessModel();
		$return = $check->checkBusiness($data);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 业务员和管理员查看对应客户的业务数据
     * @param  Request $request [description]
     * @return json           返回相关操作的数据和状态及提示信息
     */
    public function showBusiness(Request $request){
		$show = $request->only(['client_id','business_type']);
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
                        // ->where('tz_department.sign',4)
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
        $client = DB::table('tz_users')->where($salesman_id)->select('id','name','email','nickname')->get();
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
    public function securityInsertBusiness(BusinessRequest $request){
        $insert = $request->only(['client_id','sales_id','resource_id','money','length','business_note','business_type']);
        $business = new BusinessModel();
        $result = $business->securityInsertBusiness($insert);
        return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 获取某个时间段的新增业务数据
     * @param  Request $request begin--查询时间段的开始时间 end--查询时间段的结束时间
     * @return json           返回相关的查询数据
     */
    public function newBusiness(Request $request){
        $time = $request->only(['begin','end']);
        $new_business = new BusinessModel();
        $new_result = $new_business->newBusiness($time);
        return tz_ajax_echo($new_result['data'],$new_result['msg'],$new_result['code']);
    }

    /**
     * 获取某个时间段的流失业务数据
     * @param  Request $request begin--查询时间段的开始时间 end--查询时间段的结束时间
     * @return json           返回相关的查询数据
     */
    public function underBusiness(Request $request){
        $time = $request->only(['begin','end']);
        $under_business = new BusinessModel();
        $under_result = $under_business->underBusiness($time);
        return tz_ajax_echo($under_result['data'],$under_result['msg'],$under_result['code']);
    }

    /**
     * 获取某个时间段的新注册客户数据
     * @param  Request $request begin--查询时间段的开始时间 end--查询时间段的结束时间
     * @return json           返回相关的查询数据
     */
    public function newRegistration(Request $request){
        $time = $request->only(['begin','end']);
        $registra_business = new BusinessModel();
        $registra_result = $registra_business->newRegistration($time);
        return tz_ajax_echo($registra_result['data'],$registra_result['msg'],$registra_result['code']);
    }

    /**
     * 获取市场的变化（统计订单的变化）
     * @param  Request $request begin--查询时间段的开始时间 end--查询时间段的结束时间 name--查询的对象是业务员/客户
     * @return json           返回相关的查询数据
     */
    public function changeMarket(Request $request){
        $search = $request->only(['begin','end','name','str']);
        $change = new BusinessModel();
        $change_result = $change->changeMarket($search);
        return tz_ajax_echo($change_result['data'],$change_result['msg'],$change_result['code']);
    }

    /**
     * 市场变化统计的时候统计充值记录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function marketRecharge(Request $request){
        $recharge = $request->only(['startTime','endTime']);
        $market = new BusinessModel();
        $recharge_result = $market->marketRecharge($recharge);
        return tz_ajax_echo($recharge_result['data'],$recharge_result['msg'],$recharge_result['code']);
    }

    /**
     * 根据业绩统计的业务员进行对应的业务订单查询
     * @param  Request $request --begin查询开始时间, --end查询结束时间,business_id业务员id
     * @return [type]           [description]
     */
    public function performanceOrder(Request $request){
        $data = $request->only(['begin','end','business_id']);
        $orders = new BusinessModel();
        $result = $orders->performanceOrder($data);
        return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }
}
