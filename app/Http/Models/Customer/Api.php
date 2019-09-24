<?php 
 
 
namespace App\Http\Models\Customer; 
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth; 
 
class Api extends Model 
{ 
	use SoftDeletes; 
	 
 
	protected $table = 'tz_api'; //表 
	protected $primaryKey = 'id'; //主键 
	public $timestamps = true; 
	protected $dates = ['deleted_at']; 
	protected $fillable = ['user_id', 'state','api_key','api_secret']; 
 
	/** 
	 * 登录中用户 申请api权限
	 */ 
	public function apiApply(){ 
		$user = Auth::user();
 		$user_id = $user->id;		//获取用户id
 		if($user->money < 2000){	//判断余额是否足够
 			return [
 				'data'	=> [],
 				'msg'	=> '开通api权限需有2000元余额',
 				'code'	=> 0,
 			];
 		}
 		$check1 = $this->where('user_id' , $user_id)
 				->whereIn('state' , [1,2])
 				->exists();

 		if($check1){			//判断是否存在正在审核或已通过的审核
 			return [
 				'data'	=> [],
 				'msg'	=> '已开通api权限或正在审核',
 				'code'	=> 0,
 			];
 		}
 		$res = $this->create([	//生成申请单
 				'user_id'		=> $user_id,
 				'state'		=> 2,		// 0-不通过 ; 1-通过 ; 2-审核中;
 			]);
 		if($res){
 			return [
 				'data'	=> [],
 				'msg'	=> '已提交申请,等待审核',
 				'code'	=> 1,
 			];
 		}else{
 			return [
 				'data'	=> [],
 				'msg'	=> '提交申请失败',
 				'code'	=> 0,
 			];
 		}
	} 

	/** 
	 *  展示登录中用户的申请
	 */ 
	public function show(){ 
		$user = Auth::user();
 		$user_id = $user->id;		//获取用户id

 		$apply = $this->where('user_id' , $user_id)
 				->select(['state' , 'created_at'])
 				->get();
 		if ($apply->isEmpty()) {
 			return [
 				'data'	=> [],
 				'msg'	=> '尚未提交申请',
 				'code'	=> 1,
 			];
 		}
 		$state = [ 0 => '不通过' , 1 => '通过' , 2 => '审核中'];
 		foreach ($apply as $k => $v) {
 			$apply[$k]['state'] = $state[$apply[$k]['state']];
 		}
 		return [
			'data'	=> $apply,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	} 

	/** 
	 *  展示登录中用户的秘钥
	 */ 
	public function showKey(){ 
		$user = Auth::user();
 		$user_id = $user->id;		//获取用户id

 		$apply = $this->where('user_id' , $user_id)
 				->where('state' , 1)
 				->select([ 'api_key' , 'api_secret'])
 				->first();

 		if (!$apply) {
 			return [
 				'data'	=> [],
 				'msg'	=> '暂无已通过的申请',
 				'code'	=> 0,
 			];
 		}
 		return [
			'data'	=> $apply,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}
}