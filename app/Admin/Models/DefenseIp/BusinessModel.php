<?php


namespace App\Admin\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\DefenseIp\OrderModel; //后台高防ip的订单模型
use App\Admin\Models\Business\OrdersModel; //后台的订单支付模型
use Carbon\Carbon;

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
		$relevance = DB::table('tz_business_relevance')->insert(['type' => 2 , 'business_id' => $insert->business_number , 'created_at' => date("Y-m-d H:i:s")]);
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
		$business = $this->find($business_id);	
		if($business == null){
			return [
				'data'	=> '',
				'msg'	=> '没找到该业务',
				'code'	=> 0,
			];
		}
		$business_admin_user = DB::table('tz_users')->where('id',$business->user_id)->select(['salesman_id','email','name'])->first();
		if($user_id != $business_admin_user->salesman_id){
			return [
				'data'	=> '',
				'msg'	=> '客户不属于您',
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

		if($business->status == 4){
			$order_type = 1;
			$end_time = Carbon::parse($business->created_at)->addMonth($buy_time)->toDateTimeString();
			$end = strtotime($end_time);
			if($end < time()){
				return [
					'data'	=> '',
					'msg'	=> '续费时长需比试用时间长',
					'code'	=> 0,
				];
			}
		}else{
			$order_type = 2;
			$end_time = '';
		}
		if($business_admin_user->name == null){
			$business_admin_user->name = $business_admin_user->email;
		}
		$order = [
			'order_sn'		=> 'GO_'.time().'_admin_'.$user_id,
			'business_sn'		=> $business->business_number,
			'customer_id'		=> $business->user_id,
			'customer_name'	=> $business_admin_user->name,
			'business_id'		=> $business_admin_user->salesman_id,
			'business_name'	=> DB::table('admin_users')->where('id',$business_admin_user->salesman_id)->value('name'),
			'resource_type'		=> 11,
			'order_type'		=> $order_type,
			'machine_sn'		=> $business->package_id,
			'resource'		=> DB::table('tz_defenseip_store')->where('id',$business->ip_id)->value('ip'),
			'price'			=> $business->price,
			'duration'		=> $buy_time,
			'payable_money'	=> bcmul($business->price,$buy_time,2),
			'end_time'		=> $end_time,
			'order_status'		=> 0,
			'order_note'		=> '业务员手动为客户高防ip续费',
		];	

		DB::beginTransaction();	
		$orderModel = new OrderModel();
		$create_order = $orderModel->renewOrder($order);
		if($create_order == false){
			return [
				'data'	=> '',
				'msg'	=> '创建订单失败',
				'code'	=> 0,
			];
		}
		$pay_model = new OrdersModel();
		$pay_res = $pay_model->payOrderByBalance($order['business_sn'],0);
		
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