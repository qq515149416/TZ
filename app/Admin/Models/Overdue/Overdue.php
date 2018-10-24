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
	public function showOverdueCabinet(){
		$return['data'] 	= '';
		$return['code']	= 0;
		//获取查询提醒过期天数时间
		$end_time = date('Y-m-d H:i:s',$this->overtime*24*60*60+time());
		// 查询已到提醒日期的业务
		$list = $this
		->select('business_number','client_name','endding_time','machine_number')		
		->leftjoin('idc_cabinet as b','tz_business.machine_number','=','b.cabinet_id')
		->leftjoin('idc_machineroom as c','b.machineroom_id','=','c.id')
		->where('tz_business.business_type',3)
		->where('tz_business.endding_time','<',$end_time)
		->select(DB::raw('tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number as cabinet_number,c.machine_room_name'))
		->orderBy('tz_business.endding_time','asc')
		->get();		
		if($list->isEmpty()){
			$return['msg']	= '暂无过期机柜';
			return $return;
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
	public function showUnpaidCabinet(){
		$return['data'] 	= '';
		$return['code']	= 0;
		// 查询已到提醒日期的业务
		$list = $this
		->select('business_number','client_name','endding_time','machine_number')		
		->leftjoin('idc_cabinet as b','tz_business.machine_number','=','b.cabinet_id')
		->leftjoin('idc_machineroom as c','b.machineroom_id','=','c.id')	
		->select(DB::raw('tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number as cabinet_number,c.machine_room_name,tz_business.start_time'))
		->where('tz_business.business_type',3)
		->where('tz_business.business_status',3)
		->orderBy('tz_business.endding_time','asc')
		->get();		
		if($list->isEmpty()){
			$return['msg']	= '暂无过期机柜';
			return $return;
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
	public function showOverdueMachine(){
		$return['data'] 	= '';
		$return['code']	= 0;
		//获取查询提醒过期天数时间
		$end_time = date('Y-m-d H:i:s',$this->overtime*24*60*60+time());
		// 查询已到提醒日期的业务
		$list = $this		
		->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
		->leftjoin('idc_ips as c','b.ip_id','=','c.id')
		->select(DB::raw('c.ip,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number'))
		->where('tz_business.business_type',2)
		->orWhere('tz_business.business_type',1)
		->where('tz_business.endding_time','<',$end_time)
		->orderBy('tz_business.endding_time','asc')
		->get();	
		if($list->isEmpty()){
			$return['msg']	= '暂无过期机器';
			return $return;
		}

		$return['data'] 	= $list;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		return $return;
	}


	public function showOverdueRes($way,$resource_type=0){
		$return['data'] 	= '';
		$return['code']	= 0;
		//获取查询提醒过期天数时间
		if($way == 'overdue'){
			$end_time = date('Y-m-d H:i:s',$this->overtime*24*60*60+time());
		}elseif($way == 'xiajia'){
			$end_time = date('Y-m-d H:i:s',time());
		}else{
			return false;
		}
		
		// 查询已到提醒日期的业务
		if($resource_type == 0){
			$list = DB::table('tz_orders as a')	
			->leftjoin('idc_machine as b','a.business_sn','=','b.own_business')		
			->leftjoin('idc_cabinet as c','b.cabinet','=','c.id')		
			->select(DB::raw('a.id,a.business_sn,a.resource_type,a.customer_name,a.machine_sn as self_number,a.resource,a.end_time,b.machine_num,c.cabinet_id as cabinet_num'))		
			->where('a.end_time','<',$end_time)
			->where('a.resource_type','>',3)
			->orderBy('a.end_time','asc')
			->get();	
		}else{
			$list = DB::table('tz_orders as a')	
			->leftjoin('idc_machine as b','a.business_sn','=','b.own_business')		
			->leftjoin('idc_cabinet as c','b.cabinet','=','c.id')		
			->select(DB::raw('a.id,a.business_sn,a.resource_type,a.customer_name,a.machine_sn as self_number,a.resource,a.end_time,b.machine_num,c.cabinet_id as cabinet_num'))		
			->where('a.end_time','<',$end_time)
			->where('a.resource_type','=',$resource_type)
			->orderBy('a.end_time','asc')
			->get();	
		}
		
		
		if($list->isEmpty()){
			if($way == 'overdue'){
				if($resource_type == 0){
					$return['msg']	= '暂无接近过期资源';
				}else{
					$return['msg']	= '暂无此类型接近过期资源';
				}	
			}elseif($way == 'xiajia'){
				$return['msg']	= '暂无下架资源';
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
			10	=> 'cdn',
		];
		for ($i = 0; $i < count($list); $i ++) { 
			$list[$i]['resource_type'] = $type_list[$list[$i]['resource_type']];
		}
		
		$return['data'] 	= $list;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		return $return;
	}


	/**
	* 查找未付款使用中主机
	* @param  
	* @return  
	*/
	public function showUnpaidMachine(){
		$return['data'] 	= '';
		$return['code']	= 0;
		// 查询已到提醒日期的业务
		$list = $this		
		->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
		->leftjoin('idc_ips as c','b.ip_id','=','c.id')
		->select(DB::raw('c.ip,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number,tz_business.business_type,tz_business.start_time'))
		->where('tz_business.business_status',3)
		->where('tz_business.business_type','!=',3)
		->orderBy('tz_business.start_time','desc')
		->get();	
		if($list->isEmpty()){
			$return['msg']	= '暂无未付款使用中机器';
			return $return;
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
	public function showXiaJiaMachine(){
		$return['data'] 	= '';
		$return['code']	= 0;
		// 查询已到提醒日期的业务
		$list = $this		
		->leftjoin('idc_machine as b','tz_business.machine_number','=','b.machine_num')
		->leftjoin('idc_ips as c','b.ip_id','=','c.id')
		->select(DB::raw('c.ip,tz_business.id,tz_business.business_number,tz_business.client_name,tz_business.endding_time,tz_business.machine_number,tz_business.business_type,tz_business.start_time'))
		->where('tz_business.business_type','!=',3)
		->where('tz_business.remove_status','!=',0)
		->orderBy('tz_business.start_time','desc')
		->get();	
		if($list->isEmpty()){
			$return['msg']	= '暂无最近下架机器';
			return $return;
		}
		$return['data'] 	= $list;
		$return['msg'] 	= '获取成功';
		$return['code']	= 1;

		return $return;
	}
}