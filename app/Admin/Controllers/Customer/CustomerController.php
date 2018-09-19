<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 客户管理的控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-31 14:20:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\Customer;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Customer\Customer;
use App\Admin\Requests\Customer\CustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Encore\Admin\Facades\Admin;


class CustomerController extends Controller
{
	use ModelForm;

	/**
	* 查找当前登录账号所属的客户信息
	* @return json 返回相关的信息
	*/
	public function showCustomerList(){
		$admin_id = Admin::user()->id;
		$customerModel = new Customer();
		$list = $customerModel->showCustomerList($admin_id);
		if(count($list) == 0){
			return tz_ajax_echo([],'此用户无客户',0);
		}
		return tz_ajax_echo($list,'获取成功',1);
	}



	
}
