<?php

namespace App\Admin\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;


class StoreModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_defenseip_store';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['ip', 'status','site','protection_value'];

	public function insert($ip,$protection_value,$site){
		//DB::beginTransaction();
		$fail_arr = [];
		for ($i=0; $i < count($ip); $i++) { 
		
			$ip_arr = [
				'ip'			=> $ip[$i],
				'status'			=> 0,
				'protection_value'	=> $protection_value,
				'site'			=> $site,
			];
			$res = $this->create($ip_arr);
			if($res == false){
				$fail_arr[] = $ip[$i];
			}
		}
		if(count($fail_arr) != 0){
			$return = [
				'data' 	=> $fail_arr,
				'msg'	=> '以下ip录入失败!',
				'code'	=> 0,
			];
		}else{
			$return = [
				'data' 	=> '',
				'msg'	=> '录入成功!',
				'code'	=> 1,
			];
		}
		return $return;
	}

	public function del($del_id){
		$ip = $this->find($del_id);
	
		if($ip->status != 0){
			return [
				'data'	=> '',
				'msg'	=> '该ip正在使用',
				'code'	=> 0,
			];
		}
		
		$del = $ip->delete();
	
		if($del == true){
			return [
				'data'	=> '',
				'msg'	=> '删除成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> '',
				'msg'	=> '删除失败',
				'code'	=> 0,
			];
		}
	}

	public function edit($par){
		$return['data'] = '';
		$ip_model = $this->find($par['edit_id']);
		if($ip_model == null){
			$return['msg']	= '该id不存在';
			$return['code']	= 0;
			return $return;
		}
		if($ip_model->status != 0){
			$return['msg']	= '该ip正在使用';
			$return['code']	= 0;
			return $return;
		}

		// $ip_model->ip 		= $par['ip'];
		$ip_model->site 	= $par['site'];
		$ip_model->protection_value 		= $par['protection_value'];
		$res = $ip_model->save();
	
		if($res != true){
			$return['msg']	= '修改失败';
			$return['code']	= 0;
		}else{
			$return['msg']	= '修改成功';
			$return['code']	= 1;
		}
		return $return;
	}

	public function show($status,$site){
		if($status == '*'){
			if($site == '*'){
				$ip_list = $this
					->get()
					->toArray();
			}else{
				$ip_list = $this
					->where('site',$site)
					->get()
					->toArray();
			}	
		}else{
			if($site == '*'){
				$ip_list = $this
					->where('status',$status)
					->get()
					->toArray();
			}else{
				$ip_list = $this
					->where('status',$status)
					->where('site',$site)
					->get()
					->toArray();
			}
		}
		$return['data'] = '';
		if(count($ip_list) == 0){
			$return['msg'] 	= '无此状态ip';
			$return['code']	= 1;
			return $return;
		}

		for ($i=0; $i < count($ip_list); $i++) { 
			$ip_list[$i] = $this->trans($ip_list[$i]);
		}

		$return['data'] = $ip_list;
		$return['msg'] = '获取成功';
		$return['code']	=1;
		return $return;
	}

	public function showUse(){
		$ip_list = $this
		->where('status',1)
		->get()
		->toArray();
		if(count($ip_list) == 0){
			return [
				'data'	=> [],
				'msg'	=> '无此状态ip',
				'code'	=> 1,
			];
		}
		for ($i=0; $i < count($ip_list); $i++) { 
			$ip_list[$i] = $this->getUseInfo($ip_list[$i]);
			$ip_list[$i] = $this->trans($ip_list[$i]);
		}

		return [
			'data' => $ip_list,
			'msg' => '获取成功',
			'code' => 1,
		];
	}
	private function getUseInfo($ip){
		$business = DB::table('tz_defenseip_business')->where('ip_id',$ip['id'])->first();
		if($business == null){
			$ip['target_ip'] = '无业务信息';
			$ip['end_time'] = '无业务信息';	
			$ip['user'] = '无业务信息';
			$ip['nickname']	= '无业务信息';
		}else{
			if($business->target_ip == null){
				$ip['target_ip'] = '未绑定目标ip';
			}else{
				$ip['target_ip'] = $business->target_ip;
			}
			$ip['end_time'] = $business->end_at;
			if($business->user_id == null){
				$ip['user'] = '客户信息错误';
			}else{
				$user = DB::table('tz_users')->select(['name','nickname'])->where('id',$business->user_id)->first();
				$ip['user'] = $user->name;
				$ip['nickname']	= $user->nickname;
			}
			
		}
		return $ip;
	}

	private function trans($ip){
		switch ($ip['status']) {
			case '0':
				$ip['status'] = '未使用';
				break;
			case '1':
				$ip['status'] = '已使用';
				break;
			default:
				$ip['status'] = '未知状态';
				break;
		}
		$ip['site'] = DB::table('idc_machineroom')->where('id',$ip['site'])->value('machine_room_name');
		if($ip['site'] == null){
			$ip['site'] = '无此机房';
		}
		return $ip;
	}

	public function checkExist($ip){
		$id = $this->where('ip',$ip)->value('id');
		if($id != null){
			return [
				'data'	=> $id,
				'code'	=> 0,
			];
		}else{
			return [
				'data'	=> '',
				'code'	=> 1,
			];
		}
	}
}
