<?php

namespace App\Admin\Controllers\Hr;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Hr\Account;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    use ModelForm;

    public function test(){
    	return 123;
    }

    /**
     * 人事查看有关的员工账户
     * @return json 返回相关的账户信息
     */
    public function showAccount(){
    	$show = new Account();
    	$account = $show->showAccount();
    	return tz_ajax_echo($account['data'],$account['msg'],$account['code']);
        
    }

    /**
     * 员工个人账户信息
     * @return json 返回相关的账户信息
     */
    public function personalAccount(){
    	$user_id = Admin::user()->id;
		$infor = new Account();
		$personal = $infor->personalAccount($user_id);
		return tz_ajax_echo($personal['data'],$personal['msg'],$personal['code']);
    	
    }

    /**
     * 员工修改个人账户信息
     * @param  Request $request [description]
     * @return json           返回相关的账户修改状态提示及信息
     */
    public function editAccount(Request $request){
        $edit_data = $request->only(['username','id']);
        $edit = new Account();
        $edit_result = $edit->editAccount($edit_data);
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }

    /**
     * 重置密码操作(用户名为密码)
     * @param  Request $request [description]
     * @return json           返回重置密码操作的状态提示及信息
     */
    public function resetAccountPass(Request $request){
        $reset_pass =  $request->only(['username','id']);
        $reset = new Account();
        $reset_result = $reset->resetAccountPass($reset_pass);
        return tz_ajax_echo($reset_result,$reset_result['msg'],$reset_result['code']);
    }


    /**
     * 修改密码时确认两次的密码是否一致
     * @param  Request $request [description]
     * @return json           返回确认密码的
     */
    public function confirmPass(Request $request){
        $confirm_pass = $request->only(['password','confirm_pass']);
        if($confirm_pass['password'] == $confirm_pass['confirm_pass']){
            return tz_ajax_echo('','密码前后一致',1);
        } else {
            return tz_ajax_echo('','密码前后不一致',0);
        }
    }

    /**
     * 原密码验证
     * @param  Request $request [description]
     * @return json           返回相关的信息提示
     */
    public function oldPass(Request $request){
        $old_pass = $request->only(['oldpassword','id']);
        $password = Account::where('id',$old_pass)->select('password')->first();
        if(Hash::check($old_pass['oldpassword'],$password->password){
            return tz_ajax_echo('','原密码正确',1);
        } else {
            return tz_ajax_echo('','原密码错误',0);
        }
    }

    public function editPassword(Request $request){
        $edit_data = $request->only(['password','id']);
        $edit = new Account();
        $edit_result = $edit->editPassword($edit_data);
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }
}
