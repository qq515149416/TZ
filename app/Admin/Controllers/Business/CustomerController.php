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
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 业务员查看自己客户的信息
     * @return json 返回相关的数据信息和状态提示及信息
     */
    public function clerkCustomer(){
        $clerk = new clerkCustomer();
        $clerk_customer = $clerk->clerkCustomer();
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }
}
