<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 后台人员处理用户列表的模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-31 17:21:37
// +----------------------------------------------------------------------
namespace App\Admin\Models\Overdue;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;

class  Overdue extends Model
{
	protected $table = 'tz_business';
	protected $overtime = 5;
	public $timestamps = true;

	// protected $fillable = ['name', 'email','money','created_at'];

	/**
	* 查找5天内到期或过期未续费的租用机柜
	* @param  
	* @return  
	*/
	public function showOverdueCabinet($need = 1){
		$sales_id	= Admin::user()->id;
		$return['data'] 	= '';
		$return['code']	= 0;
		//获取查询提醒过期天数时间
		$end_time = date('Y-m-d H:i:s',$this->overtime*24*60*60+time());
		// 查询已到提醒日期的业务
		if(Admin::user()->isAdministrator() == 1 || $need == '*'){
			$list = $this
			->select('business_number','client_name','endding_time','machine_number')		
			->leftjoin('idc_cabinet as b','tz_business.machine_number','=','b.cabinet_id')
			->leftjoin('idc_machineroom as c','b.machineroom_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')
			->where('tz_business.business_type',3)
			->where('tz_business.endding_time','<',$end_time)
			->where('tz_business.business_status','>=',0)
			->whereNull('tz_business.deleted_at')
			->select(DB::raw('tz_business.sales_name,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number as cabinet_number,c.machine_room_name,d.nickname,d.email,d.name'))	
			->orderBy('tz_business.endding_time','asc')
			->get();
		}else{
			$list = $this
			->select('business_number','client_name','endding_time','machine_number')		
			->leftjoin('idc_cabinet as b','tz_business.machine_number','=','b.cabinet_id')
			->leftjoin('idc_machineroom as c','b.machineroom_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')
			->where('tz_business.business_type',3)
			->where('tz_business.sales_id',$sales_id)
			->where('tz_business.endding_time','<',$end_time)
			->whereNull('tz_business.deleted_at')
			->where('tz_business.business_status','>=',0)
			->select(DB::raw('tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number as cabinet_number,c.machine_room_name,d.nickname,d.email,d.name'))
			->orderBy('tz_business.endding_time','asc')
			->get();	
		}
				
		if($list->isEmpty()){
			return [
				'data'	=> [], 
				'msg'	=> '暂无过期机柜',
				'code'	=> 1,
			];
		}
		foreach ($list as $k => $v) {
			if ($v->nickname == null) {
				if ($v->email == null) {
					if ($v->name == null) {
						$v->nickname = '客户信息不完整';
					}else{
						$v->nickname = $v->name;
					}
				}else{
					$v->nickname = $v->email;
				}
			}
		}
		$return['data'] 	= $list;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		//联表查询样板
// 		$data = User::store()
                // ->where('aid','=',$params['id'])
                // ->leftjoin('orders','users.id','=','orders.user_id')
                // ->select(DB::raw('sum(orders.trade_amount) as money, count(orders.trade_amount)as number,body'))
                // ->groupBy('user_id','body')
                // ->where('orders.pay_status','=','2')
                // ->get();

		return $return;
	}
	/**
	* 查找未付款使用中机柜
	* @param  
	* @return  
	*/
	public function showUnpaidCabinet($need = 1){
		$sales_id	= Admin::user()->id;
		$return['data'] 	= '';
		$return['code']	= 0;
		// 查询已到提醒日期的业务
		if(Admin::user()->isAdministrator() == 1 || $need == '*'){
			$list = $this
			->select('business_number','client_name','endding_time','machine_number')		
			->leftjoin('idc_cabinet as b','tz_business.machine_number','=','b.cabinet_id')
			->leftjoin('idc_machineroom as c','b.machineroom_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')	
			->select(DB::raw('tz_business.sales_name,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number as cabinet_number,c.machine_room_name,tz_business.start_time,d.nickname,d.email,d.name'))
			->where('tz_business.business_type',3)
			->where('tz_business.business_status',1)
			->whereNull('tz_business.deleted_at')
			->orderBy('tz_business.endding_time','asc')
			->get();	
		}else{
			$list = $this
			->select('business_number','client_name','endding_time','machine_number')		
			->leftjoin('idc_cabinet as b','tz_business.machine_number','=','b.cabinet_id')
			->leftjoin('idc_machineroom as c','b.machineroom_id','=','c.id')	
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')
			->select(DB::raw('tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number as cabinet_number,c.machine_room_name,tz_business.start_time,d.nickname,d.email,d.name'))
			->where('tz_business.business_type',3)
			->where('tz_business.business_status',1)
			->where('tz_business.sales_id',$sales_id)
			->whereNull('tz_business.deleted_at')
			->orderBy('tz_business.endding_time','asc')
			->get();	
		}

		foreach ($list as $k => $v) {
			if ($v->nickname == null) {
				if ($v->email == null) {
					if ($v->name == null) {
						$v->nickname = '客户信息不完整';
					}else{
						$v->nickname = $v->name;
					}
				}else{
					$v->nickname = $v->email;
				}
			}
		}

		if($list->isEmpty()){
			return [
				'data'	=> [], 
				'msg'	=> '暂无未付款机柜',
				'code'	=> 1,
			];
		}
		
		$return['data'] 	= $list;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		return $return;
	}

	/**
	* 查找5天内到期或过期未续费的主机
	* @param  
	* @return  
	*/
	public function showOverdueMachine($need = 1){
		$sales_id	= Admin::user()->id;

		$return['data'] 	= '';
		$return['code']	= 0;
		//获取查询提醒过期天数时间
		$end_time = date('Y-m-d H:i:s',$this->overtime*24*60*60+time());
		// 查询已到提醒日期的业务
		if(Admin::user()->isAdministrator() == 1 || $need == '*'){
			$list = $this		
			->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
			->leftjoin('idc_ips as c','b.ip_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')	
			->select(DB::raw('tz_business.sales_name,c.ip,tz_business.id,tz_business.sales_id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number,d.nickname,d.email,d.name'))
			->whereIn('tz_business.business_type',['1','2'])
			->where('tz_business.endding_time','<',$end_time)
			->where('tz_business.remove_status',0)
			->where('tz_business.business_status','>=',0)
			->whereNull('tz_business.deleted_at')
			->orderBy('tz_business.endding_time','asc')
			->get();	
		}else{
			$list = $this		
			->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
			->leftjoin('idc_ips as c','b.ip_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')	
			->select(DB::raw('c.ip,tz_business.id,tz_business.sales_id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number,d.nickname,d.email,d.name'))
			->whereIn('tz_business.business_type',['1','2'])
			->where('tz_business.sales_id',$sales_id)
			->where('tz_business.endding_time','<',$end_time)
			->where('tz_business.remove_status',0)
			->where('tz_business.business_status','>=',0)
			->whereNull('tz_business.deleted_at')
			->orderBy('tz_business.endding_time','asc')
			->get();	
		}

		foreach ($list as $k => $v) {
			if ($v->nickname == null) {
				if ($v->email == null) {
					if ($v->name == null) {
						$v->nickname = '客户信息不完整';
					}else{
						$v->nickname = $v->name;
					}
				}else{
					$v->nickname = $v->email;
				}
			}
		}

		if($list->isEmpty()){
			return [
				'data'	=> [], 
				'msg'	=> '暂无过期机器',
				'code'	=> 1,
			];
		}

		$return['data'] 	= $list;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		return $return;
	}


	public function showOverdueRes($way,$need = 1,$resource_type=0){
		$sales_id	= Admin::user()->id;
		$return['data'] 	= '';
		$return['code']	= 0;
		//获取查询提醒过期天数时间
		if($way == 'overdue'){
			$end_time = date('Y-m-d H:i:s',$this->overtime*24*60*60+time());
			$remove_status = [0,1];
		}elseif($way == 'xiajia'){
			$end_time = date('Y-m-d H:i:s',time());
			$remove_status = [2,3,4];
		}else{
			return false;
		} 
		
		// 查询已到提醒日期的业务

		if(Admin::user()->isAdministrator() || $need == '*'){
			if($resource_type == 0){
				$list = DB::table('tz_orders as a')	
				->leftjoin('idc_machine as b','a.business_sn','=','b.own_business')		
				->leftjoin('idc_cabinet as c','b.cabinet','=','c.id')	
				->leftjoin('tz_users as d','a.customer_id','=','d.id')		
				->select(DB::raw('a.business_name as sales_name,a.id,a.business_sn,a.resource_type,a.customer_name,a.machine_sn as self_number,a.resource,a.end_time as endding_time,b.machine_num,c.cabinet_id as cabinet_num,d.nickname,d.email,d.name'))		
				->where('a.end_time','<',$end_time)
				->where('a.resource_type','>',3)
				->where('a.resource_type','<=',9)
				->whereIn('a.order_status',[0,1,2])
				->whereIn('a.remove_status',$remove_status)		//还没下架的
				->whereNull('a.deleted_at')
				->orderBy('a.end_time','asc')
				->get();	
				
			}else{
				$list = DB::table('tz_orders as a')	
				->leftjoin('idc_machine as b','a.business_sn','=','b.own_business')		
				->leftjoin('idc_cabinet as c','b.cabinet','=','c.id')
				->leftjoin('tz_users as d','a.customer_id','=','d.id')			
				->select(DB::raw('a.business_name as sales_name,a.id,a.business_sn,a.resource_type,a.customer_name,a.machine_sn as self_number,a.resource,a.end_time as endding_time,b.machine_num,c.cabinet_id as cabinet_num,d.nickname,d.email,d.name'))		
				->where('a.end_time','<',$end_time)
				->where('a.resource_type','=',$resource_type)
				->whereIn('a.order_status',[0,1,2])
				->whereIn('a.remove_status',$remove_status)		//还没下架的
				->whereNull('a.deleted_at')
				->orderBy('a.end_time','asc')
				->get();	
			
			}
		}else{

			if($resource_type == 0){
				$list = DB::table('tz_orders as a')	
				->leftjoin('idc_machine as b','a.business_sn','=','b.own_business')		
				->leftjoin('idc_cabinet as c','b.cabinet','=','c.id')	
				->leftjoin('tz_users as d','a.customer_id','=','d.id')		
				->select(DB::raw('a.business_name as sales_name,a.id,a.business_sn,a.resource_type,a.customer_name,a.machine_sn as self_number,a.resource,a.end_time as endding_time,b.machine_num,c.cabinet_id as cabinet_num,d.nickname,d.email,d.name'))		
				->where('a.end_time','<',$end_time)
				->where('a.business_id',$sales_id)
				->where('a.resource_type','>',3)
				->where('a.resource_type','<=',9)
				->whereIn('a.order_status',[0,1,2])		//订单完成之前,意思为正在生效
				->whereIn('a.remove_status',$remove_status)		//还没下架的
				->whereNull('a.deleted_at')
				->orderBy('a.end_time','asc')
				->get();	
				
			}else{
				$list = DB::table('tz_orders as a')	
				->leftjoin('idc_machine as b','a.business_sn','=','b.own_business')		
				->leftjoin('idc_cabinet as c','b.cabinet','=','c.id')	
				->leftjoin('tz_users as d','a.customer_id','=','d.id')		
				->select(DB::raw('a.business_name as sales_name,a.id,a.business_sn,a.resource_type,a.customer_name,a.machine_sn as self_number,a.resource,a.end_time as endding_time,b.machine_num,c.cabinet_id as cabinet_num,d.nickname,d.email,d.name'))		
				->where('a.end_time','<',$end_time)
				->where('a.business_id',$sales_id)
				->where('a.resource_type','=',$resource_type)
				->whereIn('a.order_status',[0,1,2])
				->whereIn('a.remove_status',$remove_status)		//还没下架的
				->whereNull('a.deleted_at')
				->orderBy('a.end_time','asc')
				->get();	
			
			}
		}

		foreach ($list as $k => $v) {
			if ($v->nickname == null) {
				if ($v->email == null) {
					if ($v->name == null) {
						$v->nickname = '客户信息不完整';
					}else{
						$v->nickname = $v->name;
					}
				}else{
					$v->nickname = $v->email;
				}
			}
		}

		if($list->isEmpty()){
			if($way == 'overdue'){
				if($resource_type == 0){
					return [
						'data'	=> [], 
						'msg'	=> '暂无接近过期资源',
						'code'	=> 1,
					];
				}else{
					return [
						'data'	=> [], 
						'msg'	=> '暂无此类型接近过期资源',
						'code'	=> 1,
					];
				}	
			}elseif($way == 'xiajia'){
				return [
					'data'	=> [], 
					'msg'	=> '暂无下架资源',
					'code'	=> 1,
				];
			}
			return $return;
		}
		$list = json_decode(json_encode($list),true);
		$type_list = [
			4 	=> 'IP',
			5	=> 'CPU',
			6	=> '硬盘',
			7	=> '内存',
			8	=> '带宽',
			9	=> '防护',
		];
		$orr = [];
		
		for ($i = 0; $i < count($list); $i ++) { 
			if( !isset( $orr[ $list[$i]['self_number'] ]) ){
				$orr[ $list[$i]['self_number'] ] = [
					'sales_name'		=>  $list[$i]['sales_name'],
					'business_number'	=>  $list[$i]['business_sn'],
					'customer_name'	=>  $list[$i]['customer_name'],
					'cabinet_num'		=>  $list[$i]['cabinet_num'],
					'machine_num'		=>  $list[$i]['machine_num'],
					'endding_time'		=>  $list[$i]['endding_time'],
					'resource'		=>  $list[$i]['resource'],
					'resource_type'		=>  $type_list[ $list[$i]['resource_type'] ],
					'self_number'		=>  $list[$i]['self_number'],
					'nickname'		=> $list[$i]['nickname'],
				];
			}else{
				if($list[$i]['endding_time'] > $orr[ $list[$i]['self_number'] ]['endding_time']){
					$orr[ $list[$i]['self_number'] ] = [
						'sales_name'		=>  $list[$i]['sales_name'],
						'business_number'	=>  $list[$i]['business_sn'],
						'customer_name'	=>  $list[$i]['customer_name'],
						'cabinet_num'		=>  $list[$i]['cabinet_num'],
						'machine_num'		=>  $list[$i]['machine_num'],
						'endding_time'		=>  $list[$i]['endding_time'],
						'resource'		=>  $list[$i]['resource'],
						'resource_type'		=>  $type_list[ $list[$i]['resource_type'] ],
						'self_number'		=>  $list[$i]['self_number'],
						'nickname'		=>  $list[$i]['nickname'],
					];
				}
			}	
		}
		$arr = [];
		foreach ($orr as $k => $v) {
			$arr[] = $v;
		}
		$return['data'] 	= $arr;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		return $return;
	}


	/**
	* 查找未付款使用中主机
	* @param  
	* @return  
	*/
	public function showUnpaidMachine($need = 1){
		$sales_id	= Admin::user()->id;
		$return['data'] 	= '';
		$return['code']	= 0;
		// 查询已到提醒日期的业务
		if(Admin::user()->isAdministrator() == 1 || $need == '*'){
			$list = $this		
			->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
			->leftjoin('idc_ips as c','b.ip_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')
			->select(DB::raw('tz_business.sales_name,c.ip,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number,tz_business.business_type,tz_business.start_time,d.nickname,d.email,d.name'))
			->where('tz_business.business_status',1)
			->whereIn('tz_business.remove_status',[0,1])
			->where('tz_business.business_type','!=',3)
			->whereNull('tz_business.deleted_at')
			->orderBy('tz_business.start_time','desc')
			->get();	
		}else{
			$list = $this		
			->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
			->leftjoin('idc_ips as c','b.ip_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')	
			->select(DB::raw('c.ip,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number,tz_business.business_type,tz_business.start_time,d.nickname,d.email,d.name'))
			->where('tz_business.sales_id',$sales_id)
			->where('tz_business.business_status',1)
			->whereIn('tz_business.remove_status',[0,1])
			->where('tz_business.business_type','!=',3)
			->whereNull('tz_business.deleted_at')
			->orderBy('tz_business.start_time','desc')
			->get();	
		}
		
		if($list->isEmpty()){
			return [
				'data'	=> [], 
				'msg'	=> '暂无未付款使用中机器',
				'code'	=> 1,
			];
		}
		foreach ($list as $k => $v) {
			if ($v->nickname == null) {
				if ($v->email == null) {
					if ($v->name == null) {
						$v->nickname = '客户信息不完整';
					}else{
						$v->nickname = $v->name;
					}
				}else{
					$v->nickname = $v->email;
				}
			}
		}
		$return['data'] 	= $list;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		return $return;
	}

	
	/**
	* 查找最近下架主机
	* @param  
	* @return  
	*/
	public function showXiaJiaMachine($need = 1){
		$sales_id	= Admin::user()->id;
		$return['data'] 	= '';
		$return['code']	= 0;
		// 查询已到提醒日期的业务
		if(Admin::user()->isAdministrator() == 1 || $need == '*'){
			$list = $this		
			->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
			->leftjoin('idc_ips as c','b.ip_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')
			->select(DB::raw('tz_business.sales_name,c.ip,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number,tz_business.business_type,tz_business.start_time,d.nickname,d.email,d.name'))
			->where('tz_business.business_type','!=',3)
			->where('tz_business.remove_status','!=',0)
			->whereNull('tz_business.deleted_at')
			->orderBy('tz_business.start_time','desc')
			->get();		
		}else{
			$list = $this		
			->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
			->leftjoin('idc_ips as c','b.ip_id','=','c.id')
			->leftjoin('tz_users as d','tz_business.client_id','=','d.id')
			->select(DB::raw('c.ip,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number,tz_business.business_type,tz_business.start_time,d.nickname,d.email,d.name'))
			->where('tz_business.sales_id',$sales_id)
			->where('tz_business.business_type','!=',3)
			->where('tz_business.remove_status','!=',0)
			->whereNull('tz_business.deleted_at')
			->orderBy('tz_business.start_time','desc')
			->get();
		}
		
		if($list->isEmpty()){
			return [
				'data'	=> [], 
				'msg'	=> '暂无最近下架机器',
				'code'	=> 1,
			];
		}

		foreach ($list as $k => $v) {
			if ($v->nickname == null) {
				if ($v->email == null) {
					if ($v->name == null) {
						$v->nickname = '客户信息不完整';
					}else{
						$v->nickname = $v->name;
					}
				}else{
					$v->nickname = $v->email;
				}
			}
		}

		$return['data'] 	= $list;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		return $return;
	}
	/**
	* 查找试用中高防IP业务
	* @param  
	* @return  
	*/
	public function showTrialDefenseIp($need = 1){

		if(Admin::user()->isAdministrator() == 1 || $need == '*'){
			$list = DB::table('tz_defenseip_business')->where('status',4)->whereNull('deleted_at')->get()->toArray();
		}else{
			$list = DB::table('tz_defenseip_business')->where('status',4)->whereNull('deleted_at')->get()->toArray();
		}
		
		if(count($list) == 0){
			return [
				'data'	=> '',
				'msg'	=> '无试用高防IP业务',
				'code'	=> 1,
			];
		}
		$status = [ 0 => '预留状态' , 1 => '正在使用' , 2 => '申请下架' , 3 => '已下架' , 4 => '试用' ,5 => '待审核'];
		for ($i=0; $i < count($list); $i++) { 

			$user = DB::table('tz_users')->where('id',$list[$i]->user_id)->first();

			if($user == null){
				$list[$i]->nickname = '客户信息获取失败';
				$list[$i]->sales_name = '信息获取失败';
			}else{
				if ($user->nickname != null) {
					$list[$i]->nickname = $user->nickname;
				}else{
					if ($user->email != null) {
						$list[$i]->nickname = $user->email;
					}else{
						if ($user->name != null) {
							$list[$i]->nickname = $user->name;
						}else{
							$list[$i]->nickname = '客户信息获取失败';
						}
					}
				}
				$list[$i]->sales_name = DB::table('admin_users')->where('id',$user->salesman_id)->value('name');
				if ($list[$i]->sales_name == null) {
					$list[$i]->sales_name = '信息获取失败';
				}

			}

			$list[$i]->status =  $status[$list[$i]->status];
		}
		return [
			'data'	=> $list,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	/**
	* 查找未付款的idc业务订单
	* @param  
	* @return  
	*/
	public function showUnpaidIdcOrder($need = 1){
		$sales_id	= Admin::user()->id;
		if(Admin::user()->isAdministrator() == 1 || $need == '*'){
			$list = DB::table('tz_orders')
				->select('*','end_time as endding_time','business_name as sales_name')
				->where('order_status',0)
				->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
				->whereNull('deleted_at')
				->whereIn('remove_status',[0,1])
				->where('payable_money','>',0)
				->get()
				->toArray();
		}else{
			$list = DB::table('tz_orders')
				->select('*','end_time as endding_time','business_name as sales_name')
				->where('business_id',$sales_id)
				->where('order_status',0)
				->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
				->whereNull('deleted_at')
				->whereIn('remove_status',[0,1])
				->where('payable_money','>',0)
				->get()
				->toArray();
		}
		
		if(count($list) == 0){
			return [
				'data'	=> '',
				'msg'	=> '无未付款的idc业务订单',
				'code'	=> 1,
			];
		}


		$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn' , '11' => '高防IP'];
		$order_status = [ '0' => '待支付' , '1' => '已支付' , '2' => '已支付' , '3' => '订单完成' , '4' => '到期' , '5' => '取消' , '6' => '申请退款', '8' => '退款完成'];
		$order_type = [ '1' => '新购' , '2' => '续费'];
		for ($i=0; $i < count($list); $i++) { 
			$user = DB::table('tz_users')->where('id',$list[$i]->customer_id)->first();
			if($user == null){
				$list[$i]->nickname = '客户信息获取失败';
			}else{
				if ($user->nickname != null) {
					$list[$i]->nickname = $user->nickname;
				}else{
					if ($user->email != null) {
						$list[$i]->nickname = $user->email;
					}else{
						if ($user->name != null) {
							$list[$i]->nickname = $user->name;
						}else{
							$list[$i]->nickname = '客户信息获取失败';
						}
					}
				}
			}
			
			$list[$i]->order_status =  $order_status[$list[$i]->order_status];
			$list[$i]->resource_type =  $resource_type[$list[$i]->resource_type];
		}

		$list = $this->removeXiaJia($list);

		return [
			'data'	=> $list,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	public function removeXiaJia($list){
		$arr = [];
		for ($i=0; $i < count($list); $i++) { 
			$check = DB::table('tz_business')->where('business_number',$list[$i]->business_sn)->whereNull('deleted_at')->first();
			
			if($check->remove_status == 0 || $check->remove_status == 1 ){
				if($check->business_status == 1 || $check->business_status == 2 || $check->business_status == 5){
					$arr[] = $list[$i];
				}
			}
		}
		return $arr;
	}


	//获取近5天过期的高防业务
	public function showOverdueDIP($need = 1)
	{
		$now = time();
		$end = date("Y-m-d H:i:s",bcadd($now,5*24*60*60,0));
		$sales_id	= Admin::user()->id;
		//dd($sales_id);
		if(Admin::user()->isAdministrator() == 1 || $need == '*'){
			$list = DB::table('tz_defenseip_business')->where('end_at' , '<' , $end)->where('status', 1)->whereNull('deleted_at')->get()->toArray();
		}else{
			$list = DB::table('tz_defenseip_business as a')
			->leftjoin('tz_users as b','b.id','=','a.user_id')
			->where('a.end_at' , '<' , $end)
			->where('a.status', 1)
			->where('b.salesman_id' , $sales_id)
			->whereNull('a.deleted_at')
			->get()
			->toArray();
		}
		if(count($list) == 0){
			return [
				'data'	=> '',
				'msg'	=> '无临过期高防IP业务',
				'code'	=> 1,
			];
		}
		$status = [ 0 => '预留状态' , 1 => '正在使用' , 2 => '申请下架' , 3 => '已下架' , 4 => '试用' ,5 => '待审核'];
		for ($i=0; $i < count($list); $i++) { 

			$user = DB::table('tz_users')->where('id',$list[$i]->user_id)->first();

			if($user == null){
				$list[$i]->nickname = '客户信息获取失败';
				$list[$i]->sales_name = '信息获取失败';
			}else{
				if ($user->nickname != null) {
					$list[$i]->nickname = $user->nickname;
				}else{
					if ($user->email != null) {
						$list[$i]->nickname = $user->email;
					}else{
						if ($user->name != null) {
							$list[$i]->nickname = $user->name;
						}else{
							$list[$i]->nickname = '客户信息获取失败';
						}
					}
				}
				$list[$i]->sales_name = DB::table('admin_users')->where('id',$user->salesman_id)->value('name');
				if ($list[$i]->sales_name == null) {
					$list[$i]->sales_name = '信息获取失败';
				}

			}

			$list[$i]->status =  $status[$list[$i]->status];
		}
		return [
			'data'	=> $list,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	
	}

}
