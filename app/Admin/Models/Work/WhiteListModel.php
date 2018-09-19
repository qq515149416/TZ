<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Facades\Admin;

class WhiteListModel extends Model
{
	use  SoftDeletes;
	protected $table = 'tz_white_list';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['white_number', 'white_ip','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit','submit_note','check_id','check_number','check_time','check_note','white_status'];

	/**
	 * 查询ip地址是否使用中
	 * @param  $ip
	 * @return [type]        [description]
	 */
	public function checkIP($ip){
		//前往IP库查找对应传入IP的状态
		$ip = DB::table('idc_ips')->where('ip',$ip)->select('id','ip_status','ip_lock','own_business')->first();
		$ip = json_decode(json_encode($ip),true);
		$return['data']	= '';
		$returm['code']	= 0;
		//判断IP的获取情况,返回失败信息
		if($ip == NULL){	
			$return['msg']	= 'IP地址不存在';		
			return $return;
		}
		if($ip['ip_lock'] == 1){
			$return['msg']	= '该IP已锁定';		
			return $return;
		}
		if($ip['ip_status'] == 0){
			$return['msg']	= '该IP尚未启用';		
			return $return;
		}
		//用获取的业务编号,前往业务表查找对应的机器编号及客户ID
		$business = DB::table('tz_business')->where('business_number',$ip['own_business'])->select('client_id','machine_number')->first();
		if($business == NULL){
			$return['msg']	= '业务编号不存在';		
			return $return;
		}
		$info['machine_number']	= $business->machine_number;
		$info['customer_id']		= $business->client_id;
		$customer_id 	= $business->client_id;
		//根据获得的客户ID查找客户可用信息
		$customer = DB::table('tz_users')->where('id',$customer_id)->select('name','email')->first();
		if($business == NULL){
			$return['msg']	= '客户id错误';		
			return $return;
		}
		$info['customer_name'] 	= $customer->name;
		$info['email']		= $customer->email;
		$return['data'] 	= $info;
		$return['msg']	= '获取成功';
		$return['code']	= 1;
		return $return;
	}
	
	/**
	 * 根据条件查出对应状态的白名单信息
	 * @param  array $where 白名单的状态条件
	 * @return [type]        [description]
	 */
	public function showWhiteList($where){
		//获取模型
		$result = $this->where($where)->get(['id','white_number','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit','submit_note','check_id','check_number','check_time','check_note','white_status','created_at']);
		//返回
		if(!$result->isEmpty()){
			//转换信息
			$submit = [1=>'客户提交',2=>'内部提交'];
			$white_status = [0=>'审核中',1=>'审核通过',2=>'审核不通过',3=>'黑名单'];
			foreach($result as $key=>$value){
				$result[$key]['submittran'] = $submit[$value['submit']];
				$result[$key]['status'] = $white_status[$value['white_status']];
			}
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '获取白名单信息成功';
		} else {
			$return['data'] = $result;
			$return['code'] = 0;
			$return['msg'] = '无信息';
		}
		return $return;

	}

	/**
	 *提交白名单信息
	 * @param  array $insertdata  要提交的白名单数据
	 * @return [type]             [description]
	 */
	public function insertWhiteList($insertdata){
		if($insertdata){
			// 创建白名单编号
			$whitenumber = mt_rand(71,99).substr(time(),5,5);
			$insertdata['white_number'] = (int)$whitenumber;
			// 当前登陆用户的信息，作为提交者信息
			$admin_id 			= Admin::user()->id;
			$fullname 			= Admin::user()->name;
			$insertdata['submit_id'] 		= $admin_id;			
			$insertdata['submit_name'] 	= $fullname;	
			$insertdata['submit'] 		= 2;			// 提交方
			$insertdata['white_status'] 	= 0;			//待审核

			//查找是否存在已提交过的申请单
			$check = $this->where('domain_name',$insertdata['domain_name'])->select('white_status')->get();
			//根据审核状态返回信息
			foreach ($check as $k => $v) {
				$return = [
					'data'	=> '',
					'code'	=> 0,
				];
				
				if($v->white_status == 0){
					$return['msg']	= '该域名审核申请单已提交,请勿重复提交,如需更换绑定IP请删除重新提交';
					return $return;
				}
				if($v->white_status == 3){
					$return['msg']	= '该域名已被拉黑';
					return $return;
				}
				if($v->white_status == 1){
					$return['msg']	= '该域名审核申请已通过,请勿重复提交';
					return $return;
				}		
			}
	
			$row = $this->create($insertdata);
			
			if($row != false){
				$return['data'] = $row->id;
				$return['code'] = 1;
				$return['msg'] = '白名单信息提交成功';
			} else {
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '白名单信息提交失败';
			}
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法提交白名单信息';
		}
		return $return;
	}

	/**
	 * 白名单审核
	 * @param  array $checkdata 审核的信息
	 * @return [type]            [description]
	 */
	public function checkWhiteList($checkdata){
		if($checkdata){
			//获取审核者信息
			$admin_id = Admin::user()->id;
			$checkdata['check_id'] = $admin_id;
			$fullname = (array)$this->staff($admin_id);
			$checkdata['check_number'] = $fullname['work_number'];
			$checkdata['check_time'] = date('Y-m-d H:i:s',time());
			//更新审核结果到申请单上
			$row = $this->where('id',$checkdata['id'])->update($checkdata);
			if($row != false) {
				$return['data'] = '';
				$return['code'] = 1;
				$return['msg'] = '白名单审核成功';
			} else {
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '白名单审核失败';
			}

		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法对白名单进行审核';
		}
		return $return;
	}

	/**
	 * 删除白名单信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteWhitelist($id){
		
		$row = $this->where('id',$id)->delete();
		if($row != false){
			$return['code'] = 1;
			$return['msg'] = '删除信息成功';
		} else {
			$return['code'] = 0;
			$return['msg'] = '删除信息失败';
		}
		return $return;
	}


	/**
	 * 内部提交时根据用户账号的id查找出对应的账户的真实姓名
	 * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
	 * @return string           返回对应账户的真实姓名
	 */
	public function staff($admin_id) {
		$staff = DB::table('oa_staff')->where('admin_users_id',$admin_id)
					->select('work_number','fullname')->first();
		return $staff;
	}
}
