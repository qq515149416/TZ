<?php

namespace App\Admin\Controllers\Hr;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Hr\EmployeeInformation;
use App\Admin\Models\Hr\DepartmentModel;
use App\Admin\Models\Hr\JobsModel;
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
     * 展示对应账户的个人详细信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function showEmployee(Request $request){
        $admin_users_id = $request->only(['account_id']);
        $show = new EmployeeInformation();
        $show_result = $show->showEmployee($admin_users_id);
        return tz_ajax_echo($show_result['data'],$show_result['msg'],$show_result['code']);
    }

    /**
     * 添加员工个人信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertEmployee(EmployeeInformationRequest $request){
        $insert_data = $request->only(['admin_users_id','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','education','work','skill','detailed','note']);
        $insert = new EmployeeInformation();
        $insert_result = $insert->insertEmployee($insert_data);
        return tz_ajax_echo($insert_result['data'],$insert_result['msg'],$insert_result['code']);
    }

    /**
     * 修改员工个人信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editEmployee(Request $request){
        $edit_data = $request->only(['id','admin_users_id','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','education','work','skill','detailed','note']);
        $edit = new EmployeeInformation();
        $edit_result = $edit->editEmployee($edit_data);
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }

    /**
     * 获取个人信息
     * @return [type] [description]
     */
    public function employeePersonal(){
        $personal = new EmployeeInformation();
        $personal_result = $personal->showEmployee();
        return tz_ajax_echo($personal_result,$personal_result['msg'],$personal_result['code']);
    }

    /**
     * 删除个人信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteEmployee(Request $request){
        $delete_id = $request->only(['delete_id']);
        $delete = new EmployeeInformation();
        $delete_result = $delete->deleteEmployee($delete_id);
        return tz_ajax_echo($delete_result,$delete_result['msg'],$delete_result['code']);
    }

    /**
     * 获取部门数据
     * @return [type] [description]
     */
    public function department(){
        $depart = new DepartmentModel();
        $depart_result = $depart->showDepart();
        return tz_ajax_echo($depart_result['data'],$depart_result['msg'],$depart_result['code']);
    }

    /**
     * 获取对应部门职位
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function jobs(Request $request){
        $depart_id = $request->only(['depart_id']);
        $jobs = new JobsModel();
        $job_result = $jobs->showJobs($depart_id);
        return tz_ajax_echo($job_result['data'],$job_result['msg'],$job_result['code']);
    } 

}
