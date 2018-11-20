<?php

namespace App\Admin\Models\Defenseip;

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
		$del = $this->where('id',$del_id)->delete($del_id);
		$return['data'] = '';
		if($del == 1){
			$return['msg']	= '删除成功';
			$return['code']	= 1;
		}else{
			$return['msg']	= '删除失败';
			$return['code']	= 0;
		}
		return $return;
	}

	public function edit($par){
		$return['data'] = '';
		$ip_model = $this->find($par['edit_id']);
		if($ip_model == null){
			$return['msg']	= '该id不存在';
			$return['code']	= 0;
			return $return;
		}
		$ip_model->ip 		= $par['ip'];
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
			$return['code']	= 0;
			return $return;
		}
		$site_list = [1 => '西安'];
		$status_list = [0 => '未使用' , 1 => '已使用'];
		for ($i=0; $i < count($ip_list); $i++) { 
			$ip_list[$i]['status'] = $status_list[$ip_list[$i]['status']];
			$ip_list[$i]['site'] = $site_list[$ip_list[$i]['site']];
		}
		$return['data'] = $ip_list;
		$return['msg'] = '获取成功';
		$return['code']	=1;
		return $return;
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