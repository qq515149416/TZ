<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | @DateTime: 2019-2-20 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Customer\Business;

class UserCenter extends Model
{


	protected $table = 'tz_users'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	
	protected $fillable = ['nickname','name','updated_at'];

	public function resetNickName($user_id,$nick_name){
		$m = $this->find($user_id);
		$m->nickname = $nick_name;
		if($m->save()){
			return [
				'code'	=> 1,
				'data'	=> [],
				'msg'	=> '更新成功',
			];
		}else{
			return [
				'code'	=> 0,
				'data'	=> [],
				'msg'	=> '更新失败',
			];
		}
	}

	public function resetAcc($user_id,$user_name){
		$m = $this->find($user_id);
		
		if($m->name != null && $m->name != ''){
			return [
				'code'	=> 0,
				'data'	=> [],
				'msg'	=> '已拥有登录名,无法修改',
			];
		}
		$m->name = $user_name;

		if($m->save()){
			return [
				'code'	=> 1,
				'data'	=> [],
				'msg'	=> '更新成功',
			];
		}else{
			return [
				'code'	=> 0,
				'data'	=> [],
				'msg'	=> '更新失败',
			];
		}
	}
}
