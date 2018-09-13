<?php

namespace App\Admin\Controllers\Hr;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Hr\EmployeeInformation;
use App\Admin\Requests\Hr\EmployeeInformationRequest;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;

/**
 * 员工信息
 */
class EmployeeInformationController extends Controller
{
    use ModelForm;

    /**
     * 查找员工的个人信息
     * @return json 返回相关的数据和状态信息
     */
    public function showEmployee(){
    	$show = new EmployeeInformation();
    	$account = $show->showEmployee();
    	return tz_ajax_echo($account['data'],$account['msg'],$account['code']);
    }

    /**
     * 新增员工信息
     * @param  EmployeeInformationRequest $request 字段验证
     * @return json                              将相关的信息状态提示返回
     */
    public function insertEmployee(EmployeeInformationRequest $request){
    	if($request->isMethod('post')){
    		$data = $request->only(['admin_users_id', 'fullname','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','education','train','work','skill','detailed','family','note']);
    		$create = new EmployeeInformation();
    		$return = $create->insertEmployee($data);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    	    return tz_ajax_echo([],'新增员 工信息失败',0);
    	}
    }

    /**
     * 修改员工的信息
     * @param  EmployeeInformationRequest $request 字段验证
     * @return json                              返回相关的信息提示和状态
     */
    public function editEmployee(EmployeeInformationRequest $request){
    	if($request->isMethod('post')){
    		$edit = $request->only(['id','admin_users_id', 'fullname','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','education','train','work','skill','detailed','family','note']);
    		$editinfor = new EmployeeInformation();
    		$return = $editinfor->editEmployee($edit);
    		return tz_ajax_echo([],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'修改员工信息失败',0);
    	}
    }

    /**
     * 删除对应的操作
     * @param  Request $request 操作删除的条件
     * @return json           相关的提示信息和状态返回
     */
    public function deleteEmployee(Request $request){
    	if($request->isMethod('post')){
    		$id = $request->get('delete_id');
    		$delete = new EmployeeInformation();
    		$result = $delete->deleteEmployee($id);
    		return tz_ajax_echo('',$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'删除信息失败',0);
    	}
    }

    /**
     * 查找对应的登录用户的个人信息
     */
    public function employeePersonal() {
    	$user_id = Admin::user()->id;
    	if($user_id){
    		$infor = new EmployeeInformation();
    		$personal = $infor->employeePersonal($user_id);
    		return tz_ajax_echo($personal['data'],$personal['msg'],$personal['code']);
    	} else {
    		return tz_ajax_echo([],'获取个人信息失败',0);
    	}
    }

    /**
     * 获取员工的详情信息
     * @param  Request $request 
     * @return json           返回相关的提示信息和状态返回
     */
    public function employeeDetailed(Request $request){
    	if($request->isMethod('post')){
    		$detailed_id = $request->only(['detailed_id']);
    		$detail = new EmployeeInformation();
    		$detailed = $detail->employeeDetailed($detailed_id);
    		return tz_ajax_echo($detailed['data'],$detailed['msg'],$detailed['code']);
    	} else {
    		return tz_ajax_echo([],'无法获取对应信息失败！！',0);
    	}
    }

}
