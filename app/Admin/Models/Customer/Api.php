<?php 
 
 
namespace App\Admin\Models\Customer; 
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Facades\DB; 
 
class Api extends Model 
{ 
	use SoftDeletes; 
	 
 
	protected $table = 'tz_api'; //表 
	protected $primaryKey = 'id'; //主键 
	public $timestamps = true; 
	protected $dates = ['deleted_at']; 
	protected $fillable = ['user_id', 'state','api_key','api_secret']; 
 
	/** 
	 * 获取api申请用户相关信息
	 */ 
	public function show($state){ 
		$res = $this->leftJoin('tz_users as b' , 'b.id' , '=' ,'tz_api.user_id')
			->where('tz_api.state',$state)
			->select(['tz_api.state' , 'tz_api.api_key' , 'tz_api.api_secret' , 'b.name' , 'b.email' , 'b.nickname'])
			->get();
		if ($res->isEmpty()) {
			return [
 				'data'	=> [],
 				'msg'	=> '无数据',
 				'code'	=> 1,
 			];
		}
		$state = [ 0 => '不通过' , 1 => '通过' , 2 => '审核中'];
		for ($i=0; $i < count($res); $i++) { 
			$res[$i]->state = $state[$res[$i]->state];
			$res[$i]->name = $res[$i]->nickname ?: $res[$i]->email ?: $res[$i]->name;
		}
		
		return [
			'data'	=> $res,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	} 

	/** 
	 * 获取api申请用户相关信息
	 */ 
	public function examine($examine_res,$apply_id){ 
		//获取审核单
		$apply = $this->find($apply_id);
		if (!$apply) {
			return [
 				'data'	=> [],
 				'msg'	=> '审核单不存在',
 				'code'	=> 0,
 			];
		}
		if ($apply->state != 2) {
			return [
 				'data'	=> [],
 				'msg'	=> '已审核完毕,请勿重复提交审核',
 				'code'	=> 0,
 			];
		}
		//更新审核状态
		$apply->state = $examine_res;

		if ($examine_res == 0) {
			if ($apply->save()) {
				return [
	 				'data'	=> [],
	 				'msg'	=> '驳回成功',
	 				'code'	=> 1,
	 			];
			}else{
				return [
	 				'data'	=> [],
	 				'msg'	=> '驳回失败',
	 				'code'	=> 0,
	 			];
			}
		}

		$time = DB::table('tz_users')->where('id',$apply->user_id)->value('created_at');
		if (!$time) {
			return [
 				'data'	=> [],
 				'msg'	=> '生成key失败,请重试',
 				'code'	=> 0,
 			];
		}

		$user_str = $apply->user_id.$time;
		$key = md5($user_str);
		$secret = '';
		$str = 'abcdefghijklmnopqrstuvwxyz0123456789';
		for ($i=0; $i < 32; $i++) { 
			$secret.= $str[rand(0,35)];
		}
		
		$apply->api_key = $key;
		$apply->api_secret = $secret;


		if ($apply->save()) {
			return [
 				'data'	=> [],
 				'msg'	=> '审核成功,已分配秘钥',
 				'code'	=> 1,
 			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '审核失败',
				'code'	=> 0,
			];
		}
		
	} 


}