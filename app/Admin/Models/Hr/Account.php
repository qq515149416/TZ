<?php

namespace App\Admin\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
class Account extends Model
{

   	protected $table = 'admin_users';
   	public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * 人事查看有关人员账号信息的数据查询
     * @return json 相关的数据和提示信息
     */
   	public function showAccount(){
   		// 查找数据
   		$result = $this->get(['id','username','name','created_at','updated_at']);
   		if(!$result->isEmpty()){

   			foreach($result as $accounts => $account) {
   				// 查找对应的角色名称
   				$role = $this->roles($account['id']);
   				$result[$accounts]['role'] = $role;
   			}
   			$return['data'] = $result;
   			$return['msg'] = '获取信息成功！！';
   			$return['code'] = 1;
   		} else {
   			$return['data'] = '';
   			$return['msg'] = '暂无数据';
   			$return['code'] = 0;
   		}

   		return $return;
   	}

   	/**
   	 * 个人账号查询
   	 * @param  [type] $user_id [description]
   	 * @return [type]          [description]
   	 */
   	public function personalAccount($user_id){
   		$result = $this->where('id',$user_id)->get(['id','username','name','created_at','updated_at']);
   		if(!$result->isEmpty()){

   			foreach($result as $accounts => $account) {
   				// 查找对应的角色名称
   				$role = $this->roles($account['id']);
   				$result[$accounts]['role'] = $role;
   			}
   			$return['data'] = $result;
   			$return['msg'] = '获取信息成功！！';
   			$return['code'] = 1;
   		} else {
   			$return['data'] = '';
   			$return['msg'] = '暂无数据';
   			$return['code'] = 0;
   		}

   		return $return;
   	}


   	/**
   	 * 查找对应账号的角色
   	 * @param  int $id admin_role_users的user_id
   	 * @return      相关数据或提示信息
   	 */
   	public function roles($id) {
   		if($id){
   			$roles =  collect(DB::table('admin_role_users')
   						->join('admin_roles','admin_role_users.role_id', '=', 'admin_roles.id')
   						->where('admin_role_users.user_id',$id)
   						->select('admin_roles.id as roleid', 'admin_roles.name as rolename')
   						->get())->all();
   			$string = '';
   			$str = '';
            // dump($roles);
            // exit;
   			foreach($roles as $rolekey =>  $rolevalue){
   				// 将对应的角色名转换为一个一维数组
   				$array = explode(',', $rolevalue->rolename);
   				// 将对应的一维数组的角色名转换为对应的字符串拼接
   				$str .= implode(',',$array).' ';
   			}
   			// 剔除最右边的空格
   			$string = rtrim($str,' ');
   			return $string;
   		} else {
   			return tz_ajax_echo('','信息错误',0);
   		}
   	}
}
