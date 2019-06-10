<?php

namespace App\Admin\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\Idc\Ips;

class StoreModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_defenseip_store';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['ip', 'status','site','protection_value'];

	// public function insert($ip,$protection_value,$site){
	// 	//DB::beginTransaction();
	// 	$fail_arr = [];
	// 	for ($i=0; $i < count($ip); $i++) { 
		
	// 		$ip_arr = [
	// 			'ip'			=> $ip[$i],
	// 			'status'			=> 0,
	// 			'protection_value'	=> $protection_value,
	// 			'site'			=> $site,
	// 		];
	// 		$res = $this->create($ip_arr);
	// 		if($res == false){
	// 			$fail_arr[] = $ip[$i];
	// 		}
	// 	}
	// 	if(count($fail_arr) != 0){
	// 		$return = [
	// 			'data' 	=> $fail_arr,
	// 			'msg'	=> '以下ip录入失败!',
	// 			'code'	=> 0,
	// 		];
	// 	}else{
	// 		$return = [
	// 			'data' 	=> '',
	// 			'msg'	=> '录入成功!',
	// 			'code'	=> 1,
	// 		];
	// 	}
	// 	return $return;
	// }

	public function insert($ip_id,$protection_value){
		//ip库模型
		$idc_ip_model = new Ips();

		//获取没锁定未使用的指定ip
		$idc_ip = $idc_ip_model
			->whereIn('id',$ip_id)
			->where('ip_lock',0)
			->where('ip_status',0)
			->get()
			->toArray();
		//如果数量对不上,就证明有不符合条件ip,返回错误
		if (count($idc_ip) != count($ip_id) ) {
			//找出不符合的
			for ($i=0; $i < count($idc_ip); $i++) { 
				$key = array_search($idc_ip[$i]['id'],$ip_id);
				if(isset($key)){
					unset($ip_id[$key]);
				}
			}
			$msg = '';
			foreach ($ip_id as $k => $v) {
				$msg.= " {$v} , ";
			}
			//返回错误
			return [
				'data' 	=> '',
				'msg'	=> $msg.'这些id的ip 已锁或者使用中或者不存在!',
				'code'	=> 0,
			];
		}
		//如果没错,就开事务,改状态锁定
		DB::beginTransaction();

		//把符合状态的状态给改掉
		$data = [
			'ip_lock'		=> 1,
			// 'ip_note'	=> '已转入高防ip库,锁定中',
		];	
		$lock_res = $idc_ip_model
			->whereIn('id',$ip_id)
			->where('ip_lock',0)
			->where('ip_status',0)
			->update($data);

		if(!$lock_res != count($ip_id) ){
			DB::rollBack();
			return [
				'data' 	=> '',
				'msg'	=> '锁ip失败',
				'code'	=> 0,
			];
		}
		
		for ($j=0; $j < count($idc_ip); $j++) { 
			
			$ip_arr = [
				// 'ip'			=> $idc_ip[$j]['ip'],
				'status'			=> 0,
				'protection_value'	=> $protection_value,
				'site'			=> $idc_ip[$j]['ip_comproom'],
			];
			$res = $this->updateOrCreate(['ip' => $idc_ip[$j]['ip'] ], $ip_arr);
			if($res == false){
				DB::rollBack();
				return [
					'data' 	=> '',
					'msg'	=> '高防ip录入失败',
					'code'	=> 0,
				];
			}
		}
		DB::commit();
		return [
			'data' 	=> '',
			'msg'	=> '录入成功',
			'code'	=> 1,
		];
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
		DB::beginTransaction();

		$del = $ip->delete();
		
		if($del == true){		//删除成功后,要到ip库那解锁
			$idc_ip_model = new Ips();
			$idc_ip = $idc_ip_model->where('ip',$ip->ip)->first();
			if($idc_ip == null){
				DB::rollBack();
				return [
					'data'	=> [],
					'msg'	=> '获取ip库ip失败',
					'code'	=> 0,
				];
			}
			$idc_ip->ip_lock = 0;
			if(!$idc_ip->save()){
				DB::rollBack();
				return [
					'data'	=> [],
					'msg'	=> 'ip库ip解锁失败',
					'code'	=> 0,
				];
			}
			DB::commit();

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

	//编辑只修改防御值
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

		//编辑的话,把ip库的也改

		// DB::beginTransaction();
		// if($ip_model->site != $par['site']){
		// 	$ip_model->site 		= $par['site'];

		// 	$idc_ip_model = new Ips();
		// 	$idc_ip = $idc_ip_model->where('ip',$ip_model->ip)->first();
		// 	if($idc_ip == null){
		// 		DB::rollBack();
		// 		return [
		// 			'data'	=> [],
		// 			'msg'	=> '获取ip库ip失败',
		// 			'code'	=> 0,
		// 		];
		// 	}
		// 	$idc_ip->ip_comproom = $par['site'];
		// 	if(!$idc_ip->save()){
		// 		DB::rollBack();
		// 		return [
		// 			'data'	=> [],
		// 			'msg'	=> '编辑ip库ip所属机房失败',
		// 			'code'	=> 0,
		// 		];
		// 	}
		// }
		
		$ip_model->protection_value 		= $par['protection_value'];
		$res = $ip_model->save();
	
		if(!$res){
			// DB::rollBack();
			$return['msg']	= '修改失败';
			$return['code']	= 0;
		}else{
			// DB::commit();
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
		->whereIn('status',[1,2,4,5])
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
				$user = DB::table('tz_users')->select(['name','nickname','email'])->where('id',$business->user_id)->first();
				if($user->email != null){
					$ip['user'] = $user->email;
				}else{
					$ip['user'] = $user->name;
				}
				
				if($user->nickname != null){
					$ip['nickname']	= $user->nickname;
				}else{
					$ip['nickname']	= '未设置昵称';
				}	
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
				$ip['status'] = '正在使用';
				break;
			case '2':
				$ip['status'] = '申请下架';
				break;
			case '3':
				$ip['status'] = '已下架';
				break;
			case '4':
				$ip['status'] = '试用';
				break;
			case '5':
				$ip['status'] = '待审核';
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
		$id = $this->where('ip',$ip)->whereNull('deleted_at')->exists();
		if($id == true){
			return [
				'data'	=> [],
				'code'	=> 0,
			];
		}else{
			return [
				'data'	=> [],
				'code'	=> 1,
			];
		}
	}
}
