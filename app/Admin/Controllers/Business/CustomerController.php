<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\CustomerModel;
use App\Admin\Requests\Business\BusinessRequest;
use Illuminate\Http\Request;

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
     * 业务员查看自己客户的信息
     * @return json 返回相关的数据信息和状态提示及信息
     */
    public function clerkCustomer(){
        $clerk = new CustomerModel();
        $clerk_customer = $clerk->clerkCustomer();
        return tz_ajax_echo($clerk_customer['data'],$clerk_customer['msg'],$clerk_customer['code']);
    }

    /**
     * 后台手动将客户拉入黑名单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function pullBlackCustomer(Request $request){
        if($request->isMethod('post')){
            $status = $request->only(['status','id']);
            $black = new CustomerModel();
            $pull = $black->pullBlackCustomer($data);
            return tz_ajax_echo($pull,$pull['msg'],$pull['code']);
        } else {
            return tz_ajax_echo('','无法将该客户拉黑',0);
        }
    }

    /**
     * 后台手动替客户重置密码
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resetPassword(Request $request){
        if($request->isMethod('post')){
            $password = $request->only(['password','id']);
            $reset = new CustomerModel();
            $reset_password = $reset->resetPassword($password);
            return tz_ajax_echo($reset_password,$reset_password['msg'],$reset_password['code']);
        } else {
            return tz_ajax_echo('','无法重置密码',0);
        }
    }
}