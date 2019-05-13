<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\CustomerModel;
use App\Admin\Models\Hr\DepartmentModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\CustomerRequest;

/**
 * 客户信息
 */
class CustomerController extends Controller
{
    use ModelForm;

    /**
     * 管理员查看客户信息接口
     * @return json 返回相关的数据信息及状态提示及信息
     */
    public function adminCustomer(Request $request) {
        $id = $request->only('id'); 
        $admin = new CustomerModel();
        $admin_customer = $admin->adminCustomer($id);
        return tz_ajax_echo($admin_customer['data'],$admin_customer['msg'],$admin_customer['code']);
    }


    /**
     * 后台手动将客户拉入黑名单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function pullBlackCustomer(Request $request){
        $status = $request->only(['status','id']);
        $black = new CustomerModel();
        $pull = $black->pullBlackCustomer($status);
       return tz_ajax_echo($pull,$pull['msg'],$pull['code']);     
    }

    /**
     * 后台手动替客户重置密码
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resetPassword(Request $request){
        $password = $request->only(['password','id']);
        $reset = new CustomerModel();
        $reset_password = $reset->resetPassword($password);
        return tz_ajax_echo($reset_password,$reset_password['msg'],$reset_password['code']);
    }

    /**
     * 转移业务员时选择部门
     * @return [type] [description]
     */
    public function depart(Request $request){
        $param = $request->only(['transfer']);
        $clerk = new DepartmentModel();
        $clerk_result = $clerk->showDepart($param);
        return tz_ajax_echo($clerk_result['data'],$clerk_result['msg'],$clerk_result['code']);
    }

     /**
     * 转移业务员时选择业务员
     * @return [type] [description]
     */
    public function selectClerk(Request $request){
        $depart_id = $request->only(['depart_id']);
        $clerk = new CustomerModel();
        $clerk_result = $clerk->selectClerk($depart_id);
        return tz_ajax_echo($clerk_result['data'],$clerk_result['msg'],$clerk_result['code']);
    }

    /**
     * 修改客户所绑定的业务员
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editClerk(Request $request){
        $clerk_id = $request->only(['clerk_id','customer_id']);
        $edit = new CustomerModel();
        $edit_result = $edit->editClerk($clerk_id);
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }

    /**
     * 绑定业务员(业务员直接输入客户提供的Email)
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertClerk(CustomerRequest $request){
        $customer = $request->only(['email']);
        $insert = new CustomerModel();
        $insert_result = $insert->insertClerk($customer);
        return tz_ajax_echo($insert_result,$insert_result['msg'],$insert_result['code']); 
    }

    /**
     * 后台注册客户
     * @param  CustomerRequest $request 'name'--用户名,'nickname'--昵称,'password'--密码,'password_confirmation'--确认密码,'msg_qq'--客户QQ,'msg_phone'--客户手机,'remarks'--备注
     * @return [type]                   [description]
     */
    public function registerClerk(CustomerRequest $request){
        $register_info = $request->only(['name','nickname','password','password_confirmation','msg_qq','msg_phone','remarks']);
        $register = new CustomerModel();
        $result = $register->registerClerk($register_info);
        return tz_ajax_echo($result,$result['msg'],$result['code']);
    }



}
