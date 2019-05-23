<?php


namespace App\Http\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Customer\PayOrder;
use App\Admin\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\OverlayBelongModel; 
use Carbon\Carbon;
use App\Http\Controllers\DefenseIp\ApiController;

class OverlayModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_overlay'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'description','site','protection_value','price','validity_period','sell_status'];
	protected $time_limit = 60;//两次购买的时间限制

	
	public function showOverlay(){
		$overlay = $this->where('sell_status',1)->get();

		if ($overlay->isEmpty()) {
			return [
				'data'	=> [],
				'msg'	=> '无上架叠加包',
				'code'	=> 1,
			];
		}
		foreach ($overlay as $k => $v) {
			$v = $this->transO($v);
		}
		return [
			'data'	=> $overlay,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}
	protected function transO($overlay){
		$overlay->machine_room_name = DB::table('idc_machineroom')->where('id',$overlay->site)->value('machine_room_name');
		return $overlay;
	}


	public function buyNowByCustomer($par){
		//获取登录中用户id
		$user = Auth::user();
		$user_id = $user->id;
		//检测用户是否在时间限制内生成过订单
		$pay_model = new PayOrder();

		$check_time_limit = $pay_model->where('customer_id',$user_id)->max('created_at');
		if ($check_time_limit != null) {
			$check_time = strtotime($check_time_limit);
			if (bcsub(time(),$check_time,0) < $this->time_limit) {
				return [
					'data'	=> [],
					'msg'	=> $this->time_limit .'秒内只能创建一次订单',
					'code'	=> 0,
				];
			}
		}

		DB::beginTransaction();

		$overlay = $this->find($par['overlay_id']);
		if($overlay == null){
			return [
				'data'	=> [],
				'msg'	=> '叠加包信息获取失败',
				'code'	=> 0,
			];
		}

		if ($overlay->sell_status != 1) {
			return [
				'data'	=> [],
				'msg'	=> '该叠加包未上架',
				'code'	=> 0,
			];
		}

		$order = [
			'order_sn'		=> 'DJB_'.time().$user_id,
			'business_sn'		=> '叠加包',
			'customer_id'		=> $user_id,
			'customer_name'	=> $user->nickname,
			'business_id'		=> $user->salesman_id,
			'business_name'	=> DB::table('admin_users')->where('id',$user->salesman_id)->value('name'),
			'resource_type'		=> 12,
			'order_type'		=> 1,
			'machine_sn'		=> $par['overlay_id'],
			'resource'		=> $overlay->name,
			'price'			=> $overlay->price,
			'duration'		=> $par['buy_num'],
			'payable_money'	=> bcmul($overlay->price, $par['buy_num'],2),
			'order_status'		=> 0,
		];
		$make_order = $pay_model->create($order);

		if(!$make_order){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '订单创建失败',
				'code'	=> 0,
			];
		}

		
		$pay_res = $pay_model->payOrderByBalance([$make_order->id],0);

		if($pay_res['code'] != 1){
			DB::rollBack();
			return $pay_res;
		}
		
		DB::commit();
		return [
			'data'	=> [],
			'msg'	=> '购买成功',
			'code'	=> 1,
		];
	}

	public function showBelong($par){
		$user_id = Auth::user()->id;
		$belong_model = new OverlayBelongModel();
		switch ($par['status']) {
			case '*':
				$overlay = $belong_model
					->where('tz_overlay_belong.user_id',$user_id)
					->leftJoin('tz_overlay as b','b.id', '=' , 'tz_overlay_belong.overlay_id')
					->select(['tz_overlay_belong.*','b.name','b.protection_value','b.validity_period'])
					->get();
				break;
			case '1':
				$overlay = $belong_model
					->where('tz_overlay_belong.status',1)
					->where('tz_overlay_belong.user_id',$user_id)
					->leftJoin('tz_overlay as b','b.id', '=' , 'tz_overlay_belong.overlay_id')
					->select(['tz_overlay_belong.*','b.name','b.protection_value','b.validity_period'])
					->get();
				break;
			case '0':
				$overlay = $belong_model
					->where('tz_overlay_belong.status',0)
					->where('tz_overlay_belong.user_id',$user_id)
					->leftJoin('tz_overlay as b','b.id', '=' , 'tz_overlay_belong.overlay_id')
					->select(['tz_overlay_belong.*','b.name','b.protection_value','b.validity_period'])
					->get();
				break;
			default:
				return [
					'data'	=> [],
					'msg'	=> '无此状态',
					'code'	=> 0,
				];
				break;
		}
		if($overlay->isEmpty()){
			return [
				'data'	=> [],
				'msg'	=> '无叠加包',
				'code'	=> 0,
			];
		}
		foreach ($overlay as $k => $v) {
			$v = $this->transBelong($v);
		}
		
		return [
			'data'	=> $overlay,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	protected function transBelong($overlay){
		switch ($overlay->status) {
			case '2':
				$overlay->status = '已使用完毕';
				break;
			case '1':
				$overlay->status = '生效中';
				break;
			case '0':
				$overlay->status = '未使用';
				break;
			default:
				$overlay->status = '未知状态';
				break;
		}
		return $overlay;
	}

	public function useOverlayToDIP($par){
		//获取业务信息
		$business_model = new BusinessModel();
		$business = $business_model->where('business_number',$par['business_number'])->first();
		if($business == null){
			return [
				'data'	=> [],
				'msg'	=> '获取业务信息失败',
				'code'	=> 0,
			];
		}
		if ($business->status != 1) {
			return [
				'data'	=> [],
				'msg'	=> '正式使用中业务才能使用叠加包',
				'code'	=> 0,
			];
		}
		//获取叠加包归属信息
		$belong = OverlayBelongModel::find($par['belong_id']);
		if ($belong == null) {
			return [
				'data'	=> [],
				'msg'	=> '获取叠加包信息失败',
				'code'	=> 0,
			];
		}
		if ($belong->status != 0) {
			return [
				'data'	=> [],
				'msg'	=> '该叠加包已使用',
				'code'	=> 0,
			];
		}
		$user_id = Auth::user()->id;
		if ($belong->user_id != $user_id) {
			return [
				'data'	=> [],
				'msg'	=> '叠加包不属于您',
				'code'	=> 0,
			];
		}

		if($belong->user_id != $business->user_id){
			return [
				'data'	=> [],
				'msg'	=> '叠加包只能给自身业务使用',
				'code'	=> 0,
			];
		}

		

		//获取高防ip业务所在机房
		$d_ip = DB::table('tz_defenseip_store')->whereNull('deleted_at')->where('id',$business->ip_id)->first();
		if ($d_ip == null) {
			return [
				'data'	=> [],
				'msg'	=> '高防ip信息获取失败',
				'code'	=> 0,
			];
		}

		$d_ip_site = $d_ip->site;
		
		//获取叠加包信息
		$overlay = $this->withTrashed()->find($belong->overlay_id);
		if($overlay->site != $d_ip_site){
			return [
				'data'	=> [],
				'msg'	=> '叠加包与业务机房不匹配',
				'code'	=> 0,
			];
		}

		// $now = date("Y-m-d H:i:s");
		//现在的时间戳
		$now 		= time();
		//计算使用时长,  有效天数 X 24小时 X 3600秒
		$use_time 	= $overlay->validity_period*24*3600;
		//结束的时间
		$end_time 	= bcadd($now, $use_time,0);

		$belong_update_info = [
			'status'			=> 1,
			'use_time'		=> date("Y-m-d H:i:s",$now),
			'target_business'	=> $par['business_number'],
			'end_time'		=> date("Y-m-d H:i:s",$end_time),
		];
		DB::beginTransaction();

		$belong_update_res = $belong->update($belong_update_info);

		if(!$belong_update_res){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '更新叠加包状态失败',
				'code'	=> 0,
			];
		}

		//计算额外的叠加包流量峰值
		$after_extra_protection = bcadd($business->extra_protection, $overlay->protection_value,0);
		//计算业务该有的流量峰值
		
		$after_protection = bcadd($d_ip->protection_value, $after_extra_protection,0);
		
		$business_update_info = [
			'extra_protection'	=> $after_extra_protection,
		];
	
		$business_update_res = $business->update($business_update_info);

		if(!$business_update_res){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '更新业务额外防御峰值失败',
				'code'	=> 0,
			];
		}

		$api_model = new ApiController();

		//记得正式上线换回来
		//$set_res = $api_model->setProtectionValue($d_ip->ip, $after_protection);
	
		$set_res = $api_model->setProtectionValue('1.1.1.1', 0);
		
		if ($set_res != 'editok' && $set_res != 'ok') {
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '更新业务防御峰值失败',
				'code'	=> 0,
			];
		}

		DB::commit();
		return [
			'data'	=> [],
			'msg'	=> '使用成功',
			'code'	=> 1,
		];
	}
}