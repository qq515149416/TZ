<?php


namespace App\Admin\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;

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

	public function buyNow($package_id,$buy_time,$customer_id){
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
		$check_time = $this->where('status',4)->where('user_id',$customer_id)->where('created_at','>',$second_buy_time)->value('id');
		if($check_time != null){
			return[
				'data'	=> '',
				'msg'	=> '1分钟内只能创建一个',
				'code'	=> 0,
			];
		}

		$package = DB::table('tz_defenseip_package')->select(['site','protection_value','price'])->where('id',$package_id)->first();

		$check_ip = DB::table('tz_defenseip_store')
				->select(['id','ip'])
				->where('site',$package->site)
				->where('protection_value',$package->protection_value)
				->where('status',0)
				->first();	
		if($check_ip == NULL){
			return[
				'data'	=> '',
				'msg'	=> '该套餐IP库存不足',
				'code'	=> 0,
			];
		}
		$data['business_number']	= 'G_'.time().'_admin_'.$user_id;
		$data['user_id']			= $customer_id;
		$data['package_id']		= $package_id;
		$data['ip_id']			= $check_ip->id;
		$data['price']			= $package->price;
		$data['status']			= 4;
		$data['created_at']		= date("Y-m-d H:i:s");
		
		DB::beginTransaction();	
		//因为可先使用后付款,创建业务
		$insert = $this->create($data);
		if($insert == false){
			return[
				'data'	=> '',
				'msg'	=> '业务创建失败',
				'code'	=> 0,
			];
		}
		//业务更新到tz_business_relevance关联表
		$relevance = DB::table('tz_business_relevance')->insert(['type' => 2 , 'business_id' => $insert->id , 'created_at' => date("Y-m-d H:i:s")]);
		if($relevance != true){
			DB::rollBack();
			return[
				'data'	=> '',
				'msg'	=> '业务关联创建失败',
				'code'	=> 0,
			];
		}

		//更新高防IP使用状态
		$update_ip = DB::table('tz_defenseip_store')->where('id',$data['ip_id'])->update(['status' => 1]);
		if($update_ip != 1){
			DB::rollBack();
			return[
				'data'	=> '',
				'msg'	=> 'IP更新使用状态失败',
				'code'	=> 0,
			];
		}

		DB::commit();
		return[
			'data'	=> '',
			'msg'	=> '创建高防IP业务成功',
			'code'	=> 1,
		];
	}

	public function renew($business_id,$buy_time){
		$user_id = Admin::user()->id;
		$business = DB::table('tz_defenseip_business')->where("id",$business_id)->first();
		dd($business);
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
		$checkOrder = $this
				->where('business_sn',$business->business_number)
				->where('order_type',2)
				->where('order_status',0)
				->first();
				
		if($checkOrder != null){
			$checkOrder->duration 	= $buy_time;
			$checkOrder->payable_money 	= bcmul($checkOrder->price,$checkOrder->duration,2);
			$res = $checkOrder->save();
			if($res == true){
				return [
					'data'	=> '',
					'msg'	=> '续费订单已存在,更新成功',
					'code'	=> 1,
				];
			}else{
				return [
					'data'	=> '',
					'msg'	=> '续费订单已存在,更新失败',
					'code'	=> 0,
				];
			}
		}	
		

		$second_buy_time = bcsub( time() , 60);
		$second_buy_time = date("Y-m-d H:i:s",$second_buy_time); 

		$check_time = $this->where('order_type',2)->where('resource_type',11)->where('customer_id',$user_id)->where('created_at','>',$second_buy_time)->value('id');                     

		if($check_time != null){
			return[
				'data'	=> '',
				'msg'	=> '1分钟内只能创建一个订单',
				'code'	=> 0,
			];
		}

		$data['order_sn'] 		= 'GO'.'_'.time().'_'.$user_id;
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
		$data['order_type']		= 2;
		$data['price']			= $business->price;
		$data['machine_sn']		= $business->package_id;
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

	

}