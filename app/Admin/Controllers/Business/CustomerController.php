<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\CustomerModel;

use Illuminate\Http\Request;
use App\Admin\Requests\Business\BusinessRequest;

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
    public function adminCustomer() {
        $admin = new CustomerModel();
        $admin_customer = $admin->adminCustomer();
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
     * 后台手动替客户充值余额
     * @param  Request $request [description]
     * @return 
     */
    public function rechargeByAdmin(BusinessRequest $request){
        $data = $request->only(['user_id','recharge_amount','voucher','remarks']);
        $model = new CustomerModel();
        $res = $model->rechargeByAdmin($data);
        return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
    }

    /**
     * 转移业务员时选择业务员
     * @return [type] [description]
     */
    public function selectClerk(){
        $clerk = new CustomerModel();
        $clerk_result = $clerk->selectClerk();
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
        $edit_result = $edit->editClerk();
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }

    /**
     * 绑定业务员(业务员直接输入客户提供的Email)
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertClerk(Request $request){
        $customer = $request->only(['email']);
        $insert = new CustomerModel();
        $insert_result = $insert->insertClerk($customer);
        return tz_ajax_echo($insert_result,$insert_result['msg'],$insert_result['code']); 
    }
}
