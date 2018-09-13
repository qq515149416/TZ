<?php

namespace App\Admin\Controllers\Hr;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Hr\Account;
use Encore\Admin\Facades\Admin;

class AccountController extends Controller
{
    use ModelForm;

    public function test(){
    	return 123;
    }

    /**
     * 展示有关的员工账户
     * @return json 返回相关的账户信息
     */
    public function showAccount(){
    	$show = new Account();
    	$account = $show->showAccount();
    	return tz_ajax_echo($account['data'],$account['msg'],$account['code']);
    }


    public function personalAccount(){
    	$user_id = Admin::user()->id;
    	if($user_id){
    		$infor = new Account();
    		$personal = $infor->personalAccount($user_id);
    		return tz_ajax_echo($personal['data'],$personal['msg'],$personal['code']);
    	} else {
    		return tz_ajax_echo([],'获取个人账号信息失败',0);
    	}
    }
}
