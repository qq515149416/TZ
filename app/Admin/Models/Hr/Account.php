<?php

namespace App\Admin\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class Account extends Model
{

   	protected $table = 'admin_users';
   	public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['id','username','password','name'];

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

      /**
       * 修改账户信息
       * @param  array $edit_data --id账户id --username账户名 --账户密码
       * @return array            返回相关的状态提示及信息
       */
      public function editAccount($edit_data){
        if($edit_data){
            $row = $this->where('id',$edit_data['id'])->update($edit_data);
            if($row != false){
               $return['code'] = 1;
               $return['msg'] = '修改账户信息成功';
            } else {
               $return['code'] = 0;
               $return['msg'] = '修改账户信息失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg'] = '无法修改账户信息';
        }
        return $return;
      }

      /**
       * 重置密码操作
       * @param  array $reset_pass --usernam账户名(作为重置后的密码) --id对应账户的id
       * @return [type]             [description]
       */
    public function resetAccountPass($reset_pass){
        if($reset_pass){
           $reset['password'] = Hash::make($reset_pass['username']);
           $row = $this->where('id',$reset_pass['id'])->update($reset);
           if($row != false){
              $return['code'] = 1;
              $return['msg'] = '密码重置成功，密码为登录账号';
           } else {
              $return['code'] = 0;
              $return['msg'] = '密码重置失败';
           }
        } else {
            $return['code'] = 0;
            $return['msg'] = '密码无法重置';
        }
        return $return;
    }

      /**
       * 修改密码
       * @param  array $edit_data --id 对应账户id --password 新密码
       * @return [type]            [description]
       */
    public function editPassword($edit_data){
        if($edit_data){
            $edit_data['password'] = Hash::make($edit_data['password']);
            $row = $this->where('id',$edit_data)->update($edit_data);
            if($row != false){
               $return['code'] = 1;
               $return['msg'] = '密码修改成功';
            } else {
               $return['code'] = 0;
               $return['msg'] = '密码修改失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg'] = '密码无法修改';
        }
        return $return;
    }

    /**
     * 人事添加账户
     * @param  [type] $insert_data [description]
     * @return [type]              [description]
     */
    public function insertAccount($insert_data){
        if(!$insert_data){
            $return['data'] = [];
            $return['code'] = 0;
            $return['msg'] = '无法添加账户信息';
            return $return;
        }
        // dd($insert_data);
        $insert_data['password'] = Hash::make($insert_data['username']);
        $row = $this->create($insert_data);
        if($row != false){
            $return['data'] = $row->id;
            $return['code'] = 1;
            $return['msg'] = '账户添加成功,登陆账号为:'.$row->username.',密码为登陆账号';
        } else {
            $return['data'] = [];
            $return['code'] = 0;
            $return['msg'] = '添加账户失败';
        }
        return $return;
    }



}
