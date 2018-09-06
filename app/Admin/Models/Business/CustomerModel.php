<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * 所有客户信息
 */
class CustomerModel extends Model
{
    use  SoftDeletes;
    protected $table = 'tz_users';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

	/**
	 * 管理人员查看客户信息
	 * @return array 返回客户信息和状态提示及信息
	 */
    public function adminCustomer(){
    	$admin_customer = $this->get(['id','status','name','email','money','salesman_id','created_at','updated_at']);
    	if($admin_customer->isEmpty()){
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
     * 业务员查看对应客户
     * @return array 返回客户信息和状态提示及信息
     */
    public function clerkCustomer(){
    	$clerk_id = Admin::user()->id;
    	$where['salesman_id'] = $clerk_id;
    	$clerk_customer = $this->where($where)->get(['id','status','name','email','money','created_at','updated_at'])
    	if($clerk_customer->isEmpty()){
    		$status = [0=>'拉黑',1=>'未验证',2=>'正常'];
    		foreach($clerk_customer as $key=>$value){
    			$$clerk_customer[$key]['status'] = $status[$value['status']];
    		}
    		$return['data'] = $clerk_customer;
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
}
