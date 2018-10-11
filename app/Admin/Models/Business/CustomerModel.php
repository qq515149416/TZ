<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;

/**
 * 所有客户信息
 */
class CustomerModel extends Model
{
    
    protected $table = 'tz_users';
    public $timestamps = true;
    

	/**
	 * 管理人员查看客户信息
	 * @return array 返回客户信息和状态提示及信息
	 */
    public function adminCustomer(){
        $clerk_id = Admin::user()->id;
        $slug = (array)$this->role($clerk_id);
        if($slug['slug'] == 'salesman'){
            $where['salesman_id'] = $clerk_id;
        } else {
            $where = [];
        }
    	$admin_customer = $this->where($where)->get(['id','status','name','email','money','salesman_id','created_at','updated_at']);
    	if(!$admin_customer->isEmpty()){
    		$status = [0=>'拉黑',1=>'未验证',2=>'正常'];
    		foreach($admin_customer as $key=>$value){
    			$admin_customer[$key]['status'] = $status[$value['status']];
    			$admin_customer[$key]['clerk_name'] = $this->clerk($value['salesman_id']);
    		}
    		$return['data'] = $admin_customer;
    		$return['code'] = 1;
    		$return['msg'] = '获取客户信息成功';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '获取客户信息失败';
    	}

    	return $return;
    }

    /**
     * 查找业务员姓名
     * @param  int $id oa_staff表的admin_users_id字段的值
     * @return string     返回对应业务员的姓名
     */
    public function clerk($id){
    	$clerk = DB::table('oa_staff')->where('admin_users_id',$id)->value('fullname');
    	return $clerk;
    }

    /**
     * 后台手动将客户拉入黑名单
     * @param  array $data 需要加入黑名单的客户的id和黑名单的状态
     * @return array       返回相关的状态信息及提示
     */
    public function pullBlackCustomer($data){
        if($data){
            $row = $this->where('id',$data['id'])->update($data);
            if($row != false){
                $return['code'] = 1;
                $return['msg'] = '此客户已成功加入黑名单';
            } else {
                $return['code'] = 0;
                $return['msg'] = '此客户加入黑名单失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg'] = '无法将此客户加入黑名单';
        }

        return $return;
    }

    /**
     * 后台手动替客户重置密码
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function resetPassword($password){
        if($password){
            $reset['password'] = Hash::make($password['password']);
            $row = $this->where('id',$password['id'])->update($reset);
            if($row != false){
                $return['code'] = 1;
                $return['msg'] = '密码重置成功，密码为用户名'.$password['password'];
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
     * 查找当前登陆用户的角色标识和角色名称
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function role($user_id){
        $role = DB::table('admin_role_users')
                    ->join('admin_roles','admin_role_users.role_id','=','admin_roles.id')
                    ->where('user_id',$user_id)
                    ->select('admin_roles.id as roleid','admin_roles.slug','admin_roles.name')
                    ->first();
        return $role;
    }

    public function rechargeByAdmin($data){
        $clerk_id = Admin::user()->id;
        $cus = $this->find($data['user_id']);
        $yewuyuan_id = $cus->salesman_id;
        $return = [
        	'data'  => '',
	'msg'   => '',
	'code'  => 0,
        ];

        if($clerk_id != $yewuyuan_id){
        	$return['msg'] = '此客户不属于您';
        	return $return;
        }

        $data['recharge_way']       	= 3;
        $data['trade_no']               	= 'tz_'.time().'_'.$data['user_id'];
        $data['money_before']      	= $cus->money;
        $data['money_after']      	= bcadd($data['money_before'],$data['recharge_amount'],2);
        $data['trade_status']	= 1;
        $data['subject']		= '余额充值';
        $data['month']		= date("Ym");
        $data['timestamp']		= date("Y-m-d H:i:s");
        $data['salesman_id']	= $clerk_id;
        $data['created_at']		= $data['timestamp'];
        //开始事务
        DB::beginTransaction();
        $cus->money = $data['money_after'];
        $update = $cus->save();
        if($update != true){
        	DB::rollBack();
        	$return['msg'] = '更新余额失败';
        	return $return;
        }

        $res = DB::table('tz_recharge_flow')->insert($data);

        if($res != true){
        	DB::rollBack();
        	$return['msg'] = '充值流水记录创建失败';
        	return $return;
        }

        DB::commit();
        $return['msg'] = '充值成功!';
        $return['code'] = 1;
        return $return;
    }
}