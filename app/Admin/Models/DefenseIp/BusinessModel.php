<?php


namespace App\Admin\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\DefenseIp\OrderModel; //后台高防ip的订单模型
use App\Admin\Models\Business\OrdersModel; //后台的订单支付模型
use Carbon\Carbon;
use App\Admin\Models\Idc\Ips;
use App\Admin\Models\DefenseIp\StoreModel;

class BusinessModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_defenseip_business'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['business_number', 'user_id','package_id','ip_id','target_ip','price','status','end_at','created_at'];
	protected $time_limit = 60;//两次购买的时间限制

	/**
	 *  新购 高防IP 接口  /  选取购买信息后,生成订单信息 
	 */

	public function buyNow($package_id,$customer_id){
		$user_id = Admin::user()->id;
		$check_customer = DB::table('tz_users')->where('id',$customer_id)->value('salesman_id');
		if($user_id != $check_customer){
			return [
				'data'	=> '',
				'msg'	=> '客户不属于你',
				'code'	=> 0,
			];
		}
		//计算二次购买允许时间
		$second_buy_time = bcsub( time() , $this->time_limit);		//60秒只允许一次
		$second_buy_time = date("Y-m-d H:i:s",$second_buy_time); 
		//查找试用业务申请
		$check_time = $this->where('status',5)->where('user_id',$customer_id)->where('created_at','>',$second_buy_time)->value('id');
		if($check_time != null){
			return[
				'data'	=> '',
				'msg'	=> '1分钟内只能创建一个',
				'code'	=> 0,
			];
		}

		$check_ip = $this->checkStock($package_id);
		if($check_ip == false){
			return[
				'data'	=> '',
				'msg'	=> '该套餐IP库存不足',
				'code'	=> 0,
			];
		}

		$data['business_number']	= 'G_'.time().'_admin_'.$user_id;
		$data['user_id']			= $customer_id;
		$data['package_id']		= $package_id;
		// $data['ip_id']			= $check_ip->id;
		$data['price']			= $check_ip->price;
		$data['status']			= 5;
		$data['created_at']		= date("Y-m-d H:i:s");
	
		
		//因为可先使用后付款,创建待审核状态业务
		$insert = $this->create($data);
		if($insert == false){
			return[
				'data'	=> '',
				'msg'	=> '高防IP业务审核提交失败',
				'code'	=> 0,
			];
		}
		
		return[
			'data'	=> '',
			'msg'	=> '高防IP业务审核提交成功',
			'code'	=> 1,
		];
	}
	/**
	*	进行审核的方法	
	**/
	public function upExamineDefenseIp($business_id,$res){
		//建立业务模型
		$business = $this->find($business_id);
		if($business == null){
			return [
				'data'	=> '',
				'msg'	=> '没找到该业务',
				'code'	=> 0,
			];
		}
		if($business->status != 5){
			return [
				'data'	=> '',
				'msg'	=> '该业务无需上架审核',
				'code'	=> 0,
			];
		}
		if($res == 0){
			$business->status = 3;
			$res = $business->save();
			if($res != true){
				return [
					'data'	=> '',
					'msg'	=> '审核失败',
					'code'	=> 0,
				];
			}else{
				return [
					'data'	=> '',
					'msg'	=> '审核成功',
					'code'	=> 1,
				];
			}
		}elseif($res == 1){
			$check_ip = $this->checkStock($business->package_id);
			if($check_ip == false){
				return [
					'data'	=> '',
					'msg'	=> '该套餐IP库存不足',
					'code'	=> 0,
				];
			}
			$business->ip_id = $check_ip->id;
			$business->status = 4;
			$business->examine_time = date("Y-m-d H:i:s");

			DB::beginTransaction();
			$save_business = $business->save();
			if($save_business!=true){
				return [
					'data'	=> '',
					'msg'	=> '业务审核失败',
					'code'	=> 0,
				];
			}
			//业务更新到tz_business_relevance关联表
			$relevance = DB::table('tz_business_relevance')->insert(['type' => 2 , 'business_id' => $business->business_number , 'created_at' => date("Y-m-d H:i:s")]);
			if($relevance != true){
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> '业务关联创建失败',
					'code'	=> 0,
				];
			}

			//更新高防IP使用状态
			$d_ip 	= StoreModel::where('id',$business->ip_id)->first();
			if($d_ip == null){
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> '高防ip信息获取失败',
					'code'	=> 0,
				];
			}
			$idc_ip 	= Ips::where('ip',$d_ip->ip)->first();
			if($idc_ip == null){
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> 'ip资源库ip信息获取失败',
					'code'	=> 0,
				];
			}
			$d_ip->status = 1;
			$idc_ip->ip_status = 4;
			if (!$d_ip->save()) {
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> '高防ip使用状态更改失败',
					'code'	=> 0,
				];
			}
			if (!$idc_ip->save()) {
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> 'ip库ip使用状态更改失败',
					'code'	=> 0,
				];
			}
			// $update_ip = DB::table('tz_defenseip_store')->where('id',$business->ip_id)->update(['status' => 1]);
			// $update_idc_ip = DB::table('idc_ips')->where('id',$business->ip_id)->update(['ip_status' => 4]);

			// if($update_ip == 0 || $update_idc_ip == 0){
			// 	DB::rollBack();
			// 	return[
			// 		'data'	=> '',
			// 		'msg'	=> 'IP更新使用状态失败',
			// 		'code'	=> 0,
			// 	];
			// }

			DB::commit();
			return [
				'data'	=> '',
				'msg'	=> '审核成功',
				'code'	=> 1,
			];
		}
	}

	/**
	*查询库存
	*/
	public function checkStock($package_id){
		$package = DB::table('tz_defenseip_package')->select(['site','protection_value','price'])->where('id',$package_id)->first();

		$check_ip = DB::table('tz_defenseip_store')
				->select(['id','ip'])
				->where('deleted_at',null)
				->where('site',$package->site)
				->where('protection_value',$package->protection_value)
				->where('status',0)
				->first();	
		if($check_ip == NULL){
			return false;
		}else{
			$check_ip->price = $package->price;
			return $check_ip;
		}
	}

	public function showUpExamineDefenseIp(){
		$res = $this->where('status',5)->get();
		if($res->isEmpty()){
			return [
				'data'	=> '',
				'msg'	=> '无数据',
				'code'	=> 1,
			];		
		}
		for ($i=0; $i < count($res); $i++) { 
			$res[$i] = $this->transUp($res[$i]);
		}
		
		return [
				'data'	=> $res,
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
	}

	private function transUp($business){
		switch ($business->status) {
			case '5':
				$business->status = '待审核';
				break;	
			default:
				$business->status = '无需审核';
				break;
		}
		$user_info = DB::table('tz_users')->where('id',$business->user_id)->first();

		if($user_info == null){
			$business->user = '客户信息查找失败';
			$business->nick_name = '客户信息查找失败';
		}else{
			if($user_info->name != null){
				$business->user = $user_info->name;
			}else{
				$business->user = $user_info->email;
			}
			$business->nickname = $user_info->nickname;

			$admin_id = $user_info->salesman_id;
			$business->admin_user = DB::table('admin_users')->where('id',$admin_id)->value('name');
		}	

		return $business;
	}
	/**
	*续费
	* @param  $business_id  -业务id ; $buy_time  -购买时长 ;$start_time -试用业务转正需要用到,开始计费时间
	* @return 
	*/
	public function renew($business_id,$buy_time,$start_time='no'){
		//获取后台登录人员id
		$user_id = Admin::user()->id;
		//获取业务信息
		$business = $this->find($business_id);	
		if($business == null){
			return [
				'data'	=> '',
				'msg'	=> '没找到该业务',
				'code'	=> 0,
			];
		}
		//获取业务所属业务员
		$business_admin_user = DB::table('tz_users')->where('id',$business->user_id)->select(['salesman_id','email','name'])->first();
		//判断登录人员是否该业务所属业务员,或者是超级管理员
		if($user_id != $business_admin_user->salesman_id  && !Admin::user()->isAdministrator()){
			return [
				'data'	=> '',
				'msg'	=> '客户不属于您',
				'code'	=> 0,
			];
		}
		//判断业务使用状态
		if($business->status == 2|| $business->status == 3){
			return [
				'data'	=> '',
				'msg'	=> '业务已下架,无法续费',
				'code'	=> 0,
			];
		}
		if($business->status == 5){
			return [
				'data'	=> '',
				'msg'	=> '业务审核中,无法续费',
				'code'	=> 0,
			];
		}

		//判断计费开始时间是否符合区间

		if($start_time != 0){
			if($start_time < $business->examine_time || $start_time > date("Y-m-d H:i:s",time()) ){
				return [
					'data'	=> '',
					'msg'	=> '业务计费开始时间只能从 审核时间 到 当前时间内选择',
					'code'	=> 0,
				]; 
			}
		}

		//判断如果是试用业务的话,是否有传开始计费时间
		if($business->status == 4){
			if ($start_time == 'no') {
				return [
					'data'	=> '',
					'msg'	=> '业务为试用,请选择开始计费时间',
					'code'	=> 0,
				]; 
			}else{
				$business->start_time = $start_time;
				if(!$business->save()){
					return [
						'data'	=> '',
						'msg'	=> '业务开始计费时间录入失败',
						'code'	=> 0,
					]; 
				}
			}
		}
		//获取订单模型
		$orderModel = new OrderModel();
		DB::beginTransaction();	
		//查看是否有已存在未付款的订单
		$checkOrder = $orderModel
				->where('business_sn',$business->business_number)
				->where('order_status',0)
				->first();
		//如果存在未付款订单,则判断业务状态
		if($checkOrder != null){ 
			if($business->status == 4){	//如果是试用状态, 还要更新结束时间

				$end_time = time_calculation($start_time,$buy_time,'month');
				
				$end = strtotime($end_time);
				if($end < time()){	
					return [
						'data'	=> '',
						'msg'	=> '续费时长需比试用时间长',
						'code'	=> 0,
					];
				}
				$checkOrder->end_time = $end_time;
			}
			$checkOrder->duration 	= $buy_time;					//更新购买时长
			$checkOrder->payable_money 	= bcmul($checkOrder->price,$buy_time,2);	//更新价格
	
			$res = $checkOrder->save();
			if($res != true){
				DB::rollBack();
				return [
					'data'	=> $checkOrder->id,
					'msg'	=> '续费订单已存在,更新失败',
					'code'	=> 0,
				];
			}
		}else{
			if($business->status == 4){
				$order_type = 1;
				$order_sn = 'GS_'.time().'_admin_'.$user_id;

				$end_time = time_calculation($start_time,$buy_time,'month');

				$end = strtotime($end_time);
				if($end < time()){
					return [
						'data'	=> '',
						'msg'	=> '续费时长需比试用时间长',
						'code'	=> 0,
					];
				}
			}else{
				$order_sn = 'GO_'.time().'_admin_'.$user_id;
				$order_type = 2;
				$end_time = '';
			}
			if($business_admin_user->name == null){
				$business_admin_user->name = $business_admin_user->email;
			}
			
			$order = [
				'order_sn'		=> $order_sn,
				'business_sn'		=> $business->business_number,
				'customer_id'		=> $business->user_id,
				'customer_name'	=> $business_admin_user->name,
				'business_id'		=> $business_admin_user->salesman_id,
				'business_name'	=> DB::table('admin_users')->where('id',$business_admin_user->salesman_id)->value('name'),
				'resource_type'		=> 11,
				'order_type'		=> $order_type,
				'machine_sn'		=> $business->package_id,
				'resource'		=> DB::table('tz_defenseip_store')->where('id',$business->ip_id)->value('ip'),
				//价格是根据业务申请时的套餐价格而定,往后不会更改,除非你手动去改它
				'price'			=> $business->price,								
				'duration'		=> $buy_time,
				'payable_money'	=> bcmul($business->price,$buy_time,2),
				'end_time'		=> $end_time,
				'order_status'		=> 0,
				'order_note'		=> '业务员手动为客户高防ip续费',
			];	

			$create_order = $orderModel->renewOrder($order);
			if($create_order == false){
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> '创建订单失败',
					'code'	=> 0,
				];
			}
		}
		
		$pay_model = new OrdersModel();
		$pay_res = $pay_model->payOrderByBalance([ $create_order->id ],0);
		
		if($pay_res['code'] != 1){
			DB::rollBack();
			return $pay_res;
		}
		DB::commit();
		$return['data']	= '';
		$return['msg']	= '续费成功';
		$return['code']	= 1;
		
		return $return;
	}

	

}