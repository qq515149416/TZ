<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class TzUser extends Authenticatable
{
	use Notifiable;

	protected $table = 'tz_users'; //表

	protected $primaryKey = 'id'; //主键

	public $timestamps = true;    //关闭自动写入时间戳

	/**
	 * The attributes that are mass assignable.
	 * 添加可模型可操作字段
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password','status','pwd_ver'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 * 隐藏字段
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function loginByVerZero($loginName, $password)
	{
		$check = $this->where('name',$loginName)->first();
		//判断密码版本是否为0
		if($check->pwd_ver != 0){
			return false;
		}
		$p = md5($password).'01?!010@$%203**';
		//比对密码
		if($p != $check->password){
			return false;
		}
		$new_pwd = Hash::make($password);
		$check->password = $new_pwd;
		$check->pwd_ver = 1;
		$res = $check->save();
		return $res;
	}
}
