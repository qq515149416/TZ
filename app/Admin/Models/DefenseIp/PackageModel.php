<?php

namespace App\Admin\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;


class PackageModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_defenseip_package';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['name','description','site','protection_value','price'];

	public function insert($par){
		// DB::beginTransaction();
		$insert = $this->create($par);
		if($insert == false){
			return [
				'data' 	=> '',
				'msg'	=> '录入失败',
				'code'	=> 0,
			];
		}else{
			return [
				'data' 	=> '',
				'msg'	=> '录入成功',
				'code'	=> 1,
			];
		}
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
		$package_model = $this->find($par['edit_id']);
		if($package_model == null){
			$return['msg']	= '该id不存在';
			$return['code']	= 0;
			return $return;
		}
		$package_model->name 		= $par['name'];
		$package_model->description 		= $par['description'];
		$package_model->site 			= $par['site'];
		$package_model->protection_value 	= $par['protection_value'];
		$package_model->price 		= $par['price'];
		$res = $package_model->save();
	
		if($res != true){
			$return['msg']	= '修改失败';
			$return['code']	= 0;
		}else{
			$return['msg']	= '修改成功';
			$return['code']	= 1;
		}
		return $return;
	}

	public function show($site){
		
		if($site == '*'){
			$package_list = $this
				->get()
				->toArray();
		}else{
			$package_list = $this
				->where('site',$site)
				->get()
				->toArray();
		}
		
		$return['data'] = '';
		if(count($package_list) == 0){
			$return['msg'] 	= '无此地区套餐';
			$return['code']	= 0;
			return $return;
		}
		$site_list = [1 => '西安' , 2 => '测试'];
		for ($i=0; $i < count($package_list); $i++) { 
			$package_list[$i]['site'] = $site_list[$package_list[$i]['site']];
		}
		$return['data'] = $package_list;
		$return['msg'] = '获取成功';
		$return['code']	=1;
		return $return;
	}

	public function showById($id){
		$package_list = $this->find($id);
		if($package_list == null){
			return [
				'data'	=> $id,
				'code'	=> 0,
				'msg'	=> '无此套餐',
			];
		}
		return [
				'data'	=> $package_list,
				'code'	=> 1,
				'msg'	=> '获取成功',
			];
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
