<?php


namespace App\Admin\Models\Waf;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\DefenseIp\OrderModel; //后台的订单模型,放错地方了
use App\Admin\Models\Business\OrdersModel; //后台的订单支付模型
// use App\Admin\Models\DefenseIp\BusinessModel;

use Carbon\Carbon;
//use App\Http\Controllers\DefenseIp\ApiController;


class WafBusinessModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_waf_business'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['business_number', 'user_id','package_id','price','status','end_at','examine_time','start_time'];
	protected $time_limit = 60;//两次购买的时间限制


	public function trans($pac){
		switch ($pac->sell_status) {
			case '0':
				$pac->sell_status = '下架中';
				break;
			case '1':
				$pac->sell_status = '上架中';
				break;
			default:
				$pac->sell_status = '未知状态';
				break;
		}

		return $pac;
	}

	protected function checkAdminUser($customer_id){
		$admin_user_id 	= Admin::user()->id;
		$customer = DB::table('tz_users')->where('id',$customer_id)->first();
		if ($customer == null) {
			return [
				'data'	=> [],
				'msg'	=> '客户信息获取失败',
				'code'	=> 0,
			];
		}
		if($admin_user_id != $customer->salesman_id)
		{
			return [
				'data'	=> [],
				'msg'	=> '该客户不属于您',
				'code'	=> 0,
			];
		}
		return [
			'data'	=> $customer,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	//后台工作人员购买防火墙
	public function buyNowByAdmin($par){
		//检查客户是否属于登录账号
		$admin_user_id 	= Admin::user()->id;
		$checkAdminUser = $this->checkAdminUser($par['user_id']);
		if ($checkAdminUser['code'] != 1) {
			return $checkAdminUser;
		}else{
			$customer = $checkAdminUser['data'];
			if ($customer->name == null) {
				$customer->name = $customer->nickname;
			}
		}
		
		//检查套餐是否存在并上架
		$check_pack = DB::table('tz_waf_package')->whereNull('deleted_at')->where('sell_status',1)->where('id',$par['package_id'])->value('price');
		if (!$check_pack) {
			return[
				'data'	=> '',
				'msg'	=> '套餐不存在或已下架',
				'code'	=> 0,
			];
		}
		DB::beginTransaction();
		
		//生成业务数据
		$data = [
			'business_number'	=> 'W_'.time().'_admin_'.substr(md5($admin_user_id.'tz'),0,4),
			'user_id'			=> $par['user_id'],
			'package_id'		=> $par['package_id'],
			'status'			=> 5,
		];
		//有传价格就按传过来的算,没传就按套餐原价算
		if (isset($par['price'])) {
			$data['price'] = $par['price'];
		}else{
			$data['price'] = $check_pack;
		}
		
		//因为可先使用后付款,创建待审核状态业务
		$insert = $this->create($data);
		if($insert == false){
			DB::rollBack();
			return[
				'data'	=> '',
				'msg'	=> '防火墙业务申请提交失败',
				'code'	=> 0,
			];
		}
		
		DB::commit();
		return[
			'data'	=> '',
			'msg'	=> '防火墙业务申请提交成功',
			'code'	=> 1,
		];

	}

	//获取待审核业务
	public function showExamine(){
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

	//渲染方法
	protected function transUp($business){
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
			
			$business->nickname = $user_info->nickname;

			$admin_id = $user_info->salesman_id;
			$business->admin_user = DB::table('admin_users')->where('id',$admin_id)->value('name');
		}	
		$business->package_name = DB::table('tz_waf_package')->where('id',$business->package_id)->value('name');

		return $business;
	}

	/**
	*	进行审核的方法	
	*	@param $business_id 	-待审核业务的id		$res 	-审核结果 : 3 - 不通过 ; 4 - 通过
	**/
	public function examine($business_id,$res){
		//建立业务模型
		$business = $this->find($business_id);

		if(!$business){
			return [
				'data'	=> '',
				'msg'	=> '没找到该业务',
				'code'	=> 0,
			];
		}

		if($business->status != 5){	//5是待审核,别的已经审核过了就不用再审核了
			return [
				'data'	=> '',
				'msg'	=> '该业务无需审核',
				'code'	=> 0,
			];
		}

		DB::beginTransaction();	
		$business->status = $res;
		$business->examine_time = date("Y-m-d H:i:s");
		$res = $business->save();

		if($res != true){
			DB::rollBack();
			return [
				'data'	=> '',
				'msg'	=> '审核失败',
				'code'	=> 0,
			];
		}

		$relevance = [
			'type'		=> 3,
			'business_id'	=> $business->business_number,
			'created_at'	=> $business->examine_time,
		];

		$build_relevance = DB::table('tz_business_relevance')->insert($relevance);
		if($build_relevance != true){
			
			DB::rollBack();
			return [
				'data'	=> '',
				'msg'	=> '创建防火墙业务关联失败',
				'code'	=> 0,
			];
		}
		DB::commit();
		return [
			'data'	=> '',
			'msg'	=> '审核成功',
			'code'	=> 1,
		];
			
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
		if(!$business){
			return [
				'data'	=> '',
				'msg'	=> '无此业务',
				'code'	=> 0,
			];
		}
		//获取业务所属业务员
		$business_admin_user = DB::table('tz_users')->where('id',$business->user_id)->select(['salesman_id','email','name','nickname'])->first();
		//判断登录人员是否该业务所属业务员,或者是超级管理员
		if($user_id != $business_admin_user->salesman_id  && !Admin::user()->isAdministrator()){
			return [
				'data'	=> '',
				'msg'	=> '客户不属于您',
				'code'	=> 0,
			];
		}
		//判断业务使用状态
		if($business->status == 2|| $business->status == 3){	//如果业务是下架或下架中状态
			return [
				'data'	=> '',
				'msg'	=> '业务已下架,无法续费',
				'code'	=> 0,
			];
		}
		if($business->status == 5){ //如果业务还没审核
			return [
				'data'	=> '',
				'msg'	=> '业务审核中,无法续费',
				'code'	=> 0,
			];
		}

		//判断计费开始时间是否符合区间

		// if($start_time != 0){
		// 	if($start_time < $business->examine_time || $start_time > date("Y-m-d H:i:s",time()) ){
		// 		return [
		// 			'data'	=> '',
		// 			'msg'	=> '业务计费开始时间只能从 审核时间 到 当前时间内选择',
		// 			'code'	=> 0,
		// 		]; 
		// 	}
		// }
		
		DB::beginTransaction();	
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
					DB::rollBack();
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
		
		//查看是否有已存在未付款的订单
		$checkOrder = $orderModel
				->where('business_sn',$business->business_number)
				->where('order_status',0)
				->first();
		//如果存在未付款订单,就更新已存在的订单,不存在就生成一个
		if($checkOrder != null){ 
			if($business->status == 4){	//判断业务状态,如果是试用状态, 要更新结束时间

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
			$order_id = $checkOrder->id;
		}else{
			if($business->status == 4){//如果是试用转正式的,算是新购
				$order_type = 1;
				$order_sn = 'WS_'.time().'_admin_'.substr(md5($user_id.'tz'),0,4);

				$end_time = time_calculation($start_time,$buy_time,'month');

				$end = strtotime($end_time);
				if($end < time()){
					return [
						'data'	=> '',
						'msg'	=> '续费时长需比试用时间长',
						'code'	=> 0,
					];
					
				}
			}else{//如果是普通续费
				$order_sn = 'WO_'.time().'_admin_'.substr(md5($user_id.'tz'),0,4);
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
				'customer_name'	=> $business_admin_user->nickname,
				'business_id'		=> $business_admin_user->salesman_id,
				'business_name'	=> DB::table('admin_users')->where('id',$business_admin_user->salesman_id)->value('name'),
				'resource_type'		=> 13,
				'order_type'		=> $order_type,
				'machine_sn'		=> $business->package_id,
				'resource'		=> DB::table('tz_waf_package')->where('id',$business->package_id)->value('name'),
				//价格是根据业务申请时的套餐价格而定,往后不会更改,除非你手动去改它
				'price'			=> $business->price,								
				'duration'		=> $buy_time,
				'payable_money'	=> bcmul($business->price,$buy_time,2),
				'end_time'		=> $end_time,
				'order_status'		=> 0,
				'order_note'		=> '业务员手动为客户防火墙续费',
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
			$order_id = $create_order->id;
		}
		
		$pay_model = new OrdersModel();

		$res = $this->paySuccess($order_id,time());

		//$pay_res = $pay_model->payOrderByBalance([ $order_id ],0);
		$pay_res = ['code' => 1] ;//这里!!!开发用,线上一定要关掉并打开上面那行!

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

	protected function paySuccess($order_id,$pay_time){
			$orderModel = new OrderModel();
			$order = $orderModel->find($order_id);
			$row = $order->toArray();
			//dd($order->toArray());
			if($row['order_type'] == 1){
				//如果是新购的防火墙,要区分前台新购的还是试用新购的
				$checkBusiness = DB::table('tz_waf_business')
					->where('business_number',$row['business_sn'])
					->whereNull('deleted_at')
					->first();
				//如果存在该业务
				if($checkBusiness != null){
					//如果该业务是试用
					if ($checkBusiness->status == 4 ) {
						$business_up = [
							'status'            => 1,
							'end_at'            => $row['end_time'],
						];
						$update_business = DB::table('tz_waf_business')
									->where('business_number',$row['business_sn'])
									->whereNull('deleted_at')
									->update($business_up);
						
						if($update_business == 0){
							$return['msg']  = '更新业务到期时间失败!';
							$return['code'] = 3;
							return $return;
						}
						
					}else{
						$return['msg']  = '业务已存在,请勿重复付款!';
						$return['code'] = 2;
						return $return;
					}
				}else{
					$package = DB::table('tz_waf_package')
					->select(['price'])
					->where('id',$row['machine_sn'])
					->where('sell_status',1)
					->whereNull('deleted_at')
					->first();
					if($package == null){
						$return['msg']  = '该套餐已下架!';
						$return['code'] = 2;
						return $return;
					}

					$now = date('Y-m-d H:i:s',time());
					$end = time_calculation($now,$row['duration'],'month');
					// Carbon::now()->addMonth($row['duration'])->toDateTimeString();


					$business = [
						'business_number'   => $row['business_sn'],
						'user_id'       => $row['customer_id'],
						'package_id'        => $row['machine_sn'],
						
						'price'         => $package->price,
						'status'            => 1,
						'end_at'            => $end,
						'start_time'	=> $now,
						'created_at'        => $now,
					];
					$build_business = DB::table('tz_waf_business')->insert($business);

					if($build_business != true){
						$return['msg']  = '创建防火墙业务失败!';
						$return['code'] = 3;
						return $return;
					}
					$relevance = [
						'type'		=> 3,
						'business_id'	=> $business['business_number'],
					];
					$build_relevance = DB::table('tz_business_relevance')->insert($relevance);
					if($build_relevance != true){
						$return['msg'] 	= '创建防火墙业务关联失败!';
						$return['code']	= 3;
						return $return;
					}
					
					$return['data'] = ['end' => $end];
				}
			}else{
				$business = DB::table('tz_waf_business')
						->where('business_number',$row['business_sn'])
						->whereNull('deleted_at')
						->first();
				//判断业务是否已下架
				if($business->status == 2||$business->status == 3)
				{
					$return['msg']  = '业务已下架,无法续费!';
					$return['code'] = 4;
					return $return;
				}

				$end = time_calculation($business->end_at,$row['duration'],'month');
				// Carbon::parse($business->end_at)->addMonth($row['duration'])->toDateTimeString();
				$upEnd = DB::table('tz_waf_business')
						->where('business_number',$row['business_sn'])
						->whereNull('deleted_at')
						->update(['end_at'=>$end]);

				if($upEnd != 1){
					$return['msg']  = '更新业务结束时间失败!';
					$return['code'] = 3;
					return $return;
				}
				$return['data'] = ['end' => $end];
			}
	}


	public function showBusiness($user_id){
		//判断客户所属业务员
		$business_admin_user = DB::table('tz_users')->where('id',$user_id)->value('salesman_id');
		if (Admin::user()->id != $business_admin_user) {
			return [
				'data'	=> [],
				'msg'	=> '客户不属于您',
				'code'	=> 0,
			];
		}
		
		$business = $this->where('user_id',$user_id)
				->leftJoin('tz_waf_package as b' , 'b.id' ,'=' ,'tz_waf_business.package_id')
				->select('tz_waf_business.*' , 'b.name as package_name')
				->get()
				->toArray();
		
		if (!$business) {
			return [
				'data'	=> [],
				'msg'	=> '无业务',
				'code'	=> 1,
			];
		}
		foreach ($business as $k => $v) {
			$status_arr = [ 1 => '正在使用' , 2 => '申请下架中' , 3 => '已下架' , 4 => '试用中' , 5 => '待审核'];
			$business[$k]['status_msg'] = $status_arr[$business[$k]['status']];
			if ($v['status'] == 4 || $v['status'] == 1) {
				$business[$k]['domain_name'] = DB::table('tz_waf_domain')->where('business_id' , $business[$k]['id'])->select('id' , 'domain_name')->get()->toArray();
			}
		}
		
		return [
			'data'	=> $business,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	public function showBelongBySite($par){
	
		$belong_model = new OverlayBelongModel();

		$overlay = $belong_model
			->leftJoin('tz_overlay as b','b.id', '=' , 'tz_overlay_belong.overlay_id')
			->leftJoin('idc_machineroom as c' , 'c.id' , '=' , 'b.site')
			->leftJoin('tz_users as d' , 'd.id' , '=' , 'tz_overlay_belong.user_id')
			->leftJoin('admin_users as e' , 'e.id' , '=' , 'd.salesman_id')
			->when($par['status'] ,function ($query, $role) {
					if ($role != '*') {
						return $query->where('tz_overlay_belong.status',$role);
					}
				},function ($query, $role) {
					if($role==="0") {
						return $query->where('tz_overlay_belong.status',$role);
					}
					return $query;
				})
			->when($par['site'], function ($query, $role) {
						if ($role != '*') {
							return $query->where('c.id',$role);
						}
					})
			->select(['tz_overlay_belong.*','b.name as overlay_name','b.protection_value','b.validity_period','c.machine_room_name','c.id as machine_room_id' , 'd.nickname' , 'd.email' , 'd.name' , 'e.name as clerk_name'])
			->get();
		
		if ($overlay->isEmpty()) {
			return [
				'data'	=> [],
				'msg'	=> '无此类叠加包',
				'code'	=> 1,
			];
		}
		//转化状态,获取使用对象ip
		foreach ($overlay as $k => $v) {
			if ($v->status == 0) {
				$v->ip = '';
			}else{
				//查查看在不在高防业务里
				$ip = BusinessModel::leftJoin('tz_defenseip_store as b' , 'b.id' , '=' , 'tz_defenseip_business.ip_id')
							->where('tz_defenseip_business.business_number' , $v->target_business)
							->first(['b.ip']);

				if ($ip != null) {	//在高防的话直接获取
					$v->ip = $ip['ip'];
				}else{		//不在高防就去找找idc
					//idc的从订单表处找,因为存的是订单号
					$idc = DB::table('tz_orders')->where('order_sn' , $v->target_business)->first(['machine_sn' , 'business_sn']);
					if ($idc != null) {
						if($idc->resource_type == 4){		//如果找出来是副ip,直接获取
							$v->ip = $idc->machine_sn;
						}elseif ($idc->resource_type == 1||$idc->resource_type == 2) {	//如果找出来是主机,去业务表的详情处找
							$business = DB::table('tz_business')->where('business_number',$idc->business_sn)->first(['resource_detail']);
							if ($business == null) {
								$v->ip = '信息有误';
							}else{
								$resource_detail = json_decode($business->resource_detail);
								$v->ip = $resource_detail['ip'];
							}
						}else{
							$v->ip = '信息有误';
						}
					}else{
						$v->ip = '信息有误';
					}
				}

			}
			$v->customer_name = $v->nickname;
			$v = $this->transBelong($v);
		}

		return [
			'data'	=> $overlay->toArray(),
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
		if($belong->user_id != $business->user_id){
			return [
				'data'	=> [],
				'msg'	=> '叠加包只能给自身业务使用',
				'code'	=> 0,
			];
		}

		//判断是否所属客户
		$checkAdminUser = $this->checkAdminUser($belong->user_id);
		if($checkAdminUser['code'] != 1){
			return $checkAdminUser;
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

		if ($business->end_at < $belong_update_info['end_time']) {
			if (!isset($par['is_ignore']) || $par['is_ignore'] != 1) {
				return [
					'data'	=> [],
					'msg'	=> '叠加包时长超过业务到期时间,是否继续使用?不使用请按取消',
					'code'	=> -1,
				];
			}	
		}

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
		
		//如果流量峰值超过300,不予通过
		if ($after_protection > 800) {
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '叠加包最高防御峰值不能超过800,请联系管理员调整',
				'code'	=> 0,
			];
		}

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
		$set_res = $api_model->setProtectionValue($d_ip->ip, $after_protection);

		//$set_res = $api_model->setProtectionValue('1.1.1.1', 0);
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

	/**
	 * 叠加包绑定对应的IDC业务
	 * @param  array $param --belong_id所属叠加包id,--order_id所需绑定叠加包的机器业务订单id
	 * @return [type]        [description]
	 */
	public function useOverlayToIDC($param){
		if(!isset($param['belong_id'])){//未设置流量包所属的id
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#101)无法确定需要绑定的叠加包';
			return $return;
		}

		if(!isset($param['order_id'])){//未设置需要绑定订单的id
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#102)无法确定你需要绑定叠加包的业务';
			return $return;
		}

		$belong = OverlayBelongModel::find($param['belong_id']);//查找流量包所属的数据

		if(empty($belong)){//不存在流量包所属数据
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#103)你需绑定的叠加包业务不存在';
			return $return;
		}

		if($belong->status != 0){//流量包已被使用
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#104)该叠加包已被使用,请重新选择';
			return $return;
		}

		$overlay = DB::table('tz_overlay')
					 ->where(['id'=>$belong->overlay_id])
					 ->select('id','site','protection_value','validity_period')
					 ->first();//查找对应的流量包的所对应的防护等参数
		
		if(empty($overlay)){//不存在
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#105)未找到对应的叠加套餐,请与管理员联系核实';
			return $return;
		}

		$protected_value = $overlay->protection_value;//叠加包的固定防御值

		$idc_orders = DB::table('tz_orders')
						->join('tz_business','tz_orders.business_sn','=','tz_business.business_number')
						->where(['tz_orders.id'=>$param['order_id']])
						->select('tz_orders.machine_sn','tz_orders.order_sn','tz_orders.resource_type','tz_business.resource_detail','tz_orders.customer_id','tz_business.endding_time','tz_orders.end_time')
						->first();//查找对应要绑定的订单

		if(empty($idc_orders)){//不存在对应的要绑定的订单
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#106)没有找到需要绑定叠加包的业务';
			return $return;
		}

		if($idc_orders->customer_id != $belong->user_id){//订单与流量包所属客户不一致
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#107)叠加包与需要绑定叠加包的业务不属于同一客户';
			return $return;
		}

		$resource_detail = json_decode($idc_orders->resource_detail);

		if($resource_detail->machineroom_id != $overlay->site){//机房不一致
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#108)叠加包与需要绑定叠加包的所属机房不一致';
			return $return;
		}

		if($idc_orders->resource_type == 1 || $idc_orders->resource_type == 2){//租用/托管机器默认使用主IP
			$ip = $resource_detail->ip;
			$protected_value = bcadd($protected_value,$resource_detail->protect);//主机默认使用主IP,并加上主机原本的防御值
			$the_end = $idc_orders->endding_time;

		} elseif ($idc_orders->resource_type == 4 ){//对应的IP资源
			$ip = $idc_orders->machine_sn;
			$the_end = $idc_orders->end_time;

		} else {//其他无IP的不给予绑定
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#109)请确定IP';
			return $return;
		}

		/**
		 * 查找对应订单在使用且未到期的叠加包防御，并进行相加
		 * @var [type]
		 */
		$use_overlay = DB::table('tz_overlay_belong as belong')
						->join('tz_overlay as overlay','belong.overlay_id','=','overlay.id')
						->where(['belong.target_business'=>$idc_orders->order_sn,'belong.status'=>1])
						->where('belong.end_time','>',date('Y-m-d H:i:s',time()))
						->sum('overlay.protection_value');
		
		$protected_value = bcadd($protected_value,$use_overlay);
		

		if($protected_value > 800){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#112)叠加包的累计流量不能超过800,如需更大流量请联系管理员进行咨询调整';
			return $return;
		}

		DB::beginTransaction();
		$update['use_time'] = date('Y-m-d H:i:s',time());
		$update['target_business'] = $idc_orders->order_sn;
		$update['status'] = 1;
		$use_time = $overlay->validity_period*24*3600;
		//结束的时间
		$update['end_time'] = date('Y-m-d H:i:s',bcadd(time(),$use_time,0));

		if ($the_end < $update['end_time'] ) {
			if (!isset($param['is_ignore']) || $param['is_ignore'] != 1) {
				return [
					'data'	=> [],
					'msg'	=> '叠加包时长超过业务到期时间,是否继续使用?不使用请按取消',
					'code'	=> -1,
				];
			}	
		}
		
		$belong_update = DB::table('tz_overlay_belong')->where(['id'=>$param['belong_id']])->update($update);//对应的订单号更新进流量包所属
		if($belong_update == 0){
			DB::rollBack();
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#110)叠加包绑定失败';
			return $return;
		}

		/**
		 * 将对应的IP根据对应的流量值进行api接口存入
		 * @var ApiController
		 */
		$api = new ApiController();

		$api_result = $api->setProtectionValue($ip, $protected_value);

		if($api_result != 'editok' && $api_result != 'ok') {//存入失败
			DB::rollBack();
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#111)叠加包绑定失败';
			return $return;
		}

		DB::commit();
		$return['data'] = [];
		$return['code'] = 1;
		$return['msg'] = '叠加包绑定成功';
		return $return;

	}
}