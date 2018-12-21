<?php


namespace App\Http\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderModel extends Model
{

	use SoftDeletes;


	protected $table = 'tz_orders'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['order_sn', 'business_sn','customer_id','customer_name','business_id','business_name','resource_type','order_type','machine_sn','resource','price','duration','payable_money','achievement','end_time','serial_number','pay_time'];

	/**
	 *  新购 高防IP 接口  /  选取购买信息后,生成订单信息
	 */

	public function buyNow($package_id,$buy_time){

		$user_id = Auth::id();
		$second_buy_time = bcsub( time() , 60);
		$second_buy_time = date("Y-m-d H:i:s",$second_buy_time);

		$check_time = $this->where('order_type',1)->where('resource_type',11)->where('customer_id',$user_id)->where('created_at','>',$second_buy_time)->value('id');
		if($check_time != null){
			return[
				'data'	=> '',
				'msg'	=> '1分钟内只能创建一个订单',
				'code'	=> 0,
			];
		}
		$package = DB::table('tz_defenseip_package')->select(['site','protection_value'])->where('id',$package_id)->first();

		$check_ip = DB::table('tz_defenseip_store')
				->select(['id','ip'])
				->where('site',$package->site)
				->where('protection_value',$package->protection_value)
				->where('status',0)
				->first();
		
		if($check_ip == null){
			$return['data'] 	= [];
			$return['msg'] 	= '该套餐IP库存不足!';
			$return['code']	= 0;
			return $return;
		}
		$time = time();
		$data['order_sn'] 		= 'GN_'.$time.'_'.$user_id;
		$data['business_sn']		= 'G_'.$time.'_'.$user_id;
		$data['customer_id']		= $user_id;
		$data['customer_name']	= Auth::user()->name;
		if($data['customer_name'] == null){
			$data['customer_name']	= Auth::user()->email;
		}
		$data['business_id']		= Auth::user()->salesman_id;
		$data['business_name']		= DB::table('admin_users')->where('id',$data['business_id'])->value('name');
		$data['resource_type']		= 11;
		$data['order_type']		= 1;
		$data['price']			= DB::table('tz_defenseip_package')->where('id',$package_id)->value('price');
		$data['machine_sn']		= $package_id;
		$data['duration']		= $buy_time;
		$data['payable_money']		= bcmul($data['price'],$data['duration'],2);
		$data['order_status']		= 0;
		$insert = $this->create($data);

		if($insert != false){
			$return['data']	= $insert->id;
			$return['msg']	= '创建订单成功';
			$return['code']	= 1;
		}else{
			$return['data']	= '';
			$return['msg']	= '创建订单失败';
			$return['code']	= 0;
		}
		return $return;
	}

	public function renew($business_id,$buy_time){
		$user_id = Auth::id();
		$business = DB::table('tz_defenseip_business')->where('user_id',$user_id)->where("id",$business_id)->first();

		if($business == null){
			return [
				'data'	=> '',
				'msg'	=> '没找到该业务',
				'code'	=> 0,
			];
		}
		if($business->status == 2|| $business->status == 3){
			return [
				'data'	=> '',
				'msg'	=> '业务已下架,无法续费',
				'code'	=> 0,
			];
		}

		//查看是否有已存在未付款的订单
		$checkOrder = $this
				->where('business_sn',$business->business_number)
				->where('order_status',0)
				->first();
		//如果存在未付款订单,则判断业务状态
		if($checkOrder != null){ 
			if($business->status == 4){	//如果是试用状态, 还要更新结束时间
				$end_time = Carbon::parse($business->created_at)->addMonth($buy_time)->toDateTimeString();
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
			if($res == true){
				return [
					'data'	=> $checkOrder->id,
					'msg'	=> '续费订单已存在,更新成功',
					'code'	=> 1,
				];
			}else{
				return [
					'data'	=> $checkOrder->id,
					'msg'	=> '续费订单已存在,更新失败',
					'code'	=> 0,
				];
			}
		}



		//检测 一分钟内是否生成过订单
		$second_buy_time = bcsub( time() , 60);
		$second_buy_time = date("Y-m-d H:i:s",$second_buy_time);

		$check_time = $this->where('resource_type',11)->where('customer_id',$user_id)->where('created_at','>',$second_buy_time)->value('id');

		if($check_time != null){
			return[
				'data'	=> '',
				'msg'	=> '1分钟内只能创建一个订单',
				'code'	=> 0,
			];
		}


		// 根据业务状态生成订单
		// 如果业务的状态是试用,订单的性质就是新购,结束时间也要填上,从试用开始时算起
		if($business->status == 4){	//试用续费
			$order_type = 1;
			$order_sn = 'GS'.'_'.time().'_'.$user_id;
			$end_time = Carbon::parse($business->created_at)->addMonth($buy_time)->toDateTimeString();
			$end = strtotime($end_time);
			if($end < time()){	
				return [
					'data'	=> '',
					'msg'	=> '续费时长需比试用时间长',
					'code'	=> 0,
				];
			}
		}else{	//普通续费
			$order_type = 2;
			$order_sn = 'GO'.'_'.time().'_'.$user_id;
			$end_time = '';
		}
		$data['order_sn'] 		= $order_sn;
		$data['business_sn']		= $business->business_number;
		$data['customer_id']		= $user_id;
		$data['customer_name']	= Auth::user()->name;
		if($data['customer_name'] == null){
			$data['customer_name']	= Auth::user()->email;
		}
		$data['business_id']		= Auth::user()->salesman_id;
		$data['business_name']		= DB::table('admin_users')->where('id',$data['business_id'])->value('name');
		$data['resource_type']		= 11;
		$data['resource']		= DB::table('tz_defenseip_store')->where('id',$business->ip_id)->value('ip');
		$data['order_type']		= $order_type;
		$data['price']			= $business->price;
		$data['machine_sn']		= $business->package_id;
		$data['duration']		= $buy_time;
		$data['payable_money']	= bcmul($data['price'],$data['duration'],2);
		$data['order_status']		= 0;
		$data['end_time']		= $end_time;
		
		$insert = $this->create($data);

		if($insert != false){
			$return['data']	= $insert->id;
			$return['msg']	= '创建订单成功';
			$return['code']	= 1;
		}else{
			$return['data']	= '';
			$return['msg']	= '创建订单失败';
			$return['code']	= 0;
		}
		return $return;
	}



}
