<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Facades\Admin;
use App\Admin\Controllers\Work\ApiController;

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
		$return['code']	= 0;
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
		if($ip['ip_status'] != 2){
			//用获取的业务编号,前往业务表查找对应的机器编号及客户ID
			$business = DB::table('tz_business')->where('business_number',$ip['own_business'])->select('client_id','machine_number','business_status')->first();
			if($business == NULL){
				$return['msg']	= '业务编号不存在';		
				return $return;
			}
			$business_status		= $business->business_status;
			if($business_status != 2 && $business_status != 3 && $business_status != 4){
				$return['msg']	= '业务尚未启用';		
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
		}else{
			$machine_number = DB::table('idc_machine')->where('ip_id',$ip['id'])->value('machine_num');
			if($machine_number == null){
				return [
					'data'	=> '',
					'code'	=> 0,
					'msg'	=> 'ip未绑定机器',
				];
			}
			$return['data'] 	= [
				'customer_id'		=> 0,
				'customer_name'	=> '腾正自用',
				'machine_number'	=> $machine_number,
			];
			$return['msg']	= '内部用ip';
			$return['code']	= 1;
		}
		
		
		return $return;
	}
	
	/**
	 * 根据条件查出对应状态的白名单信息
	 * @param  array $where 白名单的状态条件
	 * @return [type]        [description]
	 */
	public function showWhiteList($where){
		//获取模型
		$result = $this->where($where)
			->orderBy('created_at','desc')
			->get(['id','white_ip','white_number','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit','submit_note','check_id','check_number','check_time','check_note','white_status','created_at']);
		//返回
		if(!$result->isEmpty()){
			//转换信息
			$submit = [1=>'客户提交',2=>'内部提交'];
			$white_status = [0=>'审核中',1=>'审核通过',2=>'审核不通过',3=>'黑名单',4=>'取消'];
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
		
		$check_domain = strstr($insertdata['domain_name'],'/');
		if($check_domain != false){
			return [
				'data'	=> '',
				'msg'	=> '域名格式错误,勿填 : http:// ; https ; www ; / ;',
				'code'	=> 0,
			];
		}
		// 创建白名单编号
		$whitenumber = create_number();
		$insertdata['white_number'] 	= $whitenumber;
		// 当前登陆用户的信息，作为提交者信息
		$check = $this->checkIP($insertdata['white_ip']);
		if($check['code'] != 1){
			return $check;
		}
		if($check['data']['customer_name'] == null){
			$insertdata['customer_name']	= $check['data']['email'];
		}else{
			$insertdata['customer_name']	= $check['data']['customer_name'];
		}		

		$insertdata['customer_id'] 	= $check['data']['customer_id'];
		$insertdata['binding_machine']	= $check['data']['machine_number'];
		$admin_id 			= Admin::user()->id;
		$fullname 			= Admin::user()->name?Admin::user()->name:Admin::user()->username;
		$insertdata['submit_id'] 	= $admin_id;			
		$insertdata['submit_name'] 	= $fullname;	
		$insertdata['submit'] 		= 2;			// 提交方
		$insertdata['white_status'] 	= 0;			//待审核
		//查找是否存在已提交过的申请单

		$check = $this->where('domain_name',$insertdata['domain_name'])->select(['white_status','white_ip'])->get();
		//根据审核状态返回信息
		foreach ($check as $k => $v) {
			$return = [
				'data'	=> '',
				'code'	=> 0,
			];
			//曾经被拉黑过就不能再提交
			if($v->white_status == 3){
				$return['msg']	= '该域名已被拉黑';
				return $return;
			}

			// if($v->white_status == 1 ){
			// 	if($v->white_ip == $insertdata['white_ip']){
			// 		$return['msg']	= '该域名审核申请单已通过,请勿重复提交';
			// 		return $return;	
			// 	}
			// }
			if($v->white_status == 0 ){
				if($v->white_ip == $insertdata['white_ip']){
					$return['msg']	= '该域名审核申请单正在审核中,请勿重复提交';
					return $return;	
				}
			}			
		}

		$row = $this->create($insertdata);
		
		if($row != false){
			$return['data'] = $row->id;
			$return['code'] = 1;
			$return['msg'] = '白名单审核申请提交成功';
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '白名单审核申请提交失败';
		}
		
		return $return;
	}

	/**
	 * 白名单审核
	 * @param  array $checkdata 审核的信息
	 * @return [type]            [description]
	 */
	public function checkWhiteList($checkdata){

		//获取审核单信息
		$row = $this->find($checkdata['id']);
		if($row == null){
			return [
				'data'	=> '',
				'msg'	=> '审核单不存在',
				'code'	=> 0,
			];
		}
		//如果审核单已经审核过
		if($row->white_status != 0){
			return [
				'data'	=> '',
				'msg'	=> '该单已审核',
				'code'	=> 0,
			];
		}

		//获取审核者信息
		$admin_id = Admin::user()->id;
		$fullname = (array)$this->staff($admin_id);
		if(count($fullname) == 0){
			return [
				'data'	=> '',
				'msg'	=> '审核人员信息不完整,请填写完整再进行审核',
				'code'	=> 0,
			];
		}
		//如果要通过审核,就要有备案编号
		if($row->record_number == null && $checkdata['white_status'] == 1 && !isset($checkdata['record_number'])){
			return [
				'data'	=> '',
				'msg'	=> '若需通过,请填写备案编号',
				'code'	=> 0,
			];
		}
		
		//更新审核单信息
		$row->check_id 	= $admin_id;
		$row->check_number	= $fullname['work_number'];

		$row->check_time 	= date('Y-m-d H:i:s',time());
		$row->white_status 	= $checkdata['white_status'];
		if(isset($checkdata['record_number'])){
			$row->record_number 	= $checkdata['record_number'];
		}
		if(isset($checkdata['check_note'])){
			$row->check_note 	= $checkdata['check_note'];
		}

		DB::beginTransaction();//开启事务处理

		$save_res = $row->save($checkdata);
		if(!$save_res){
			DB::rollBack();
			return [
				'data'	=> '',
				'msg'	=> '白名单审核失败',
				'code'	=> 1,
			];
			return $return;	
		}
		//判断审核状态,如果是不通过,就直接返回审核结果
		if($checkdata['white_status'] == 2){
			DB::commit();
			return [
				'data'	=> '',
				'msg'	=> '审核成功',
				'code'	=> 1,
			];		
		}
		$already = $this->where('domain_name','abc.abc')->get();

		//审核结果如果是通过
		if($checkdata['white_status'] == 1){
			//如果是通过的话,就检查是否已经添加过
			if(!$already->isEmpty()){
				$already = $already->toArray();
				for ($i=0; $i < count($already); $i++) { 
					if($already[$i]['white_status'] == 1 ){
						DB::rollBack();
						return[
							'data'	=> '',
							'msg'	=> '白名单已存在',
							'code'	=> 0,	
						];
					}elseif($already[$i]['white_status'] == 3 ){
						DB::rollBack();
						return[
							'data'	=> '',
							'msg'	=> '该域名已拉黑',
							'code'	=> 0,	
						];
					}

				}
			}
			//没添加过就开始添加通行证
			$api_controller = new ApiController();
			$room_id = DB::table('idc_ips')->where('ip',$row->white_ip)->value('ip_comproom');
			//$room_id = 78;
			if($room_id == null){
				DB::rollBack();
				return[
					'data'	=> '',
					'msg'	=> 'ip无绑定机房',
					'code'	=> 0,	
				];
			}

			//更改状态成功,开始调用API塞到白名单的数据库
			$domain = $row->domain_name;
			$insert_res = $api_controller->createWhiteList($domain,$room_id);
			if($insert_res['code'] != 1){
				DB::rollBack();
				return $insert_res;
			}
			DB::commit();
			$return = [
				'data'	=> '',
				'msg'	=> '审核成功,已为域名添加通行证',
				'code'	=> 1,
			];
			return $return;
		}elseif ($checkdata['white_status'] == 3) {
			//如果审核结果是拉黑的话
			
			//先检查审核单有没有已通过的审核单
			if(!$already->isEmpty()){
				$already = $already->toArray();
				for ($i=0; $i < count($already); $i++) { 
					if($already[$i]['white_status'] == 3 ){
						DB::rollBack();
						return[
							'data'	=> '',
							'msg'	=> '该域名已拉黑',
							'code'	=> 0,	
						];
					}elseif($already[$i]['white_status'] == 1 ){
						$api_controller = new ApiController();
						$room_id = DB::table('idc_ips')->where('ip',$already[$i]['white_ip'])->value('ip_comproom');
					
						if($room_id == null){
							DB::rollBack();
							return[
								'data'	=> '',
								'msg'	=> 'ip无绑定机房',
								'code'	=> 0,	
							];
						}
						// $del_res = $api_controller->delWhiteList($domain,$room_id);
						//这个正式上线需要替换
						$del_res = [
							'code'	=> 1,
						];
						if($del_res['code'] != 1){
							DB::rollBack();
							return[
								'data'	=> '',
								'msg'	=> '拉黑失败',
								'code'	=> 0,	
							];
						}	
					}
				}
				DB::commit();
				return[
					'data'	=> '',
					'msg'	=> '拉黑成功',
					'code'	=> 0,	
				];
			}
			//如果没有同样域名审核单,或者之前的审核单是驳回的
			DB::commit();
			return[
				'data'	=> '',
				'msg'	=> '拉黑成功',
				'code'	=> 1,	
			];	
			
		}
		
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
					->select('work_number')->first();
		return $staff;
	}
}
