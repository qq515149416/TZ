<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 不知道啥
// +----------------------------------------------------------------------
// | Description: 用户订单表模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Customer\Business;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class Order extends Model
{

	use SoftDeletes;

	protected $table = 'tz_orders'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['order_sn', 'business_sn','customer_id','before_money','after_money','business_id','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','refund_money','refund_time','refund_note','order_note','created_at','payable_money'];

	/*
	*根据不同需求获取对应订单列表
	*
	*/
	public function getList($type)
	{
		$user_id = Auth::user()->id;
		if(isset($type['status'])) {
			$where['tz_orders.order_status'] = $type['status'];
		}
		if(!isset($type['business_sn']) && !isset($type['resource_type'])){//从个人订单入口,不区分资源类型
			$where['tz_orders.customer_id'] = $user_id;
			
		} elseif(!isset($type['business_sn']) && isset($type['resource_type'])) {//从个人订单入口，区分资源类型
			$where['tz_orders.customer_id'] = $user_id;
			$where['tz_orders.resource_type'] = $type['resource_type'];
			
		} elseif(isset($type['business_sn']) && !isset($type['resource_type'])){//从业务入口进入，对应业务的不区分资源类型
			$where['tz_orders.customer_id'] = $user_id;
			$where['tz_orders.business_sn'] = $type['business_sn'];
			
		} elseif(isset($type['business_sn']) && isset($type['resource_type'])){//从业务入口对应业务的对应类型资源
			$where['tz_orders.customer_id'] = $user_id;
			$where['tz_orders.business_sn'] = $type['business_sn'];
			$where['tz_orders.resource_type'] = $type['resource_type'];
			
		}
		
		$order = $this
			->leftJoin('tz_orders_flow','tz_orders.serial_number','=','tz_orders_flow.serial_number')
			->where($where)
			->whereBetween('tz_orders.remove_status',[0,3])
			->whereNull('tz_orders.deleted_at')
			->orderBy('tz_orders.created_at','desc')
			->select('tz_orders.id','tz_orders.order_sn','tz_orders.business_sn','tz_orders.business_id','tz_orders.end_time','tz_orders.resource_type','tz_orders.order_type','tz_orders.machine_sn','tz_orders.resource','tz_orders.price','tz_orders.duration','tz_orders.payable_money','tz_orders.end_time','tz_orders.serial_number','tz_orders.pay_time','tz_orders.order_status','tz_orders.order_note','tz_orders.created_at','tz_orders_flow.before_money','tz_orders_flow.after_money','tz_orders.remove_status')
			->get();
		
		if(count($order) == 0){
			return false;
		}

		//转换状态
		$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn' , '11' => '高防IP' , '12' => '流量叠加包'];
		

		$order_type = [ '1' => '新购' , '2' => '续费' ];
		$order_status = [ '0' => '待支付' , '1' => '已支付' , '2' => '已支付' , '3' => '订单完成' , '4' => '到期' , '5' => '取消' , '6' => '申请退款', '8' => '退款完成'];
		$remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
		$info = $this->getName('*');
		$admin_name = [];
		foreach ($info as $k => $v) {
			$admin_name[$v->id] = $v->username;
		}

		foreach ($order as $key => $value) {
			$value->remove_status 		= $remove_status[$value->remove_status];
			$value->type 			= $value->resource_type;
			$value->order_type 		= $order_type[$value->order_type];
			$value->status 			= $value->order_status;
			$value->order_status 		= $order_status[$value->order_status];
			$value->business_name		= $admin_name[$value->business_id];
			$value->machine_number = Business::where(['business_number'=>$value->business_sn])->value('machine_number');
			//这个是属于主机的分类数组
			$machine_arr = [ 1 , 2 , 4 , 5 , 6 , 7 , 8 , 9 ];
			//机柜的数组
			$cabinet_arr = [ 3 ];
			//cdn的数组
			$cdn_arr = [ 10 ];
			//高防的数组
			$defenseip_arr = [ 11 ];
			//叠加包的数组
			$overlay_arr = [ 12 ];
			//因为不同类型的订单要从不同的表里找机房信息
			switch ($value->resource_type) {
				case 1:
				case 2:
				case 4:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
					//如果是属于主机类业务
					//获取对应业务,从业务处找机房信息
					$machine_room = DB::table('tz_business as a')
						->leftJoin('idc_machine as b','a.machine_number','=','b.machine_num')
						->leftJoin('idc_machineroom as c','b.machineroom','=','c.id')
						->where(['a.business_number'=>$value->business_sn])
						->whereNull('a.deleted_at')
						->whereNull('b.deleted_at')
						->first(['c.id as machineroom_id' , 'c.machine_room_name as machineroom_name']);
	
					break;
				case 3:
					//如果是机柜类业务
					$machine_room = $this
								->leftJoin('idc_cabinet as b' , 'tz_orders.machine_sn' , '=' , 'b.cabinet_id')
								->leftJoin('idc_machineroom as c' , 'b.machineroom_id' , '=' , 'c.id')
								->where(['tz_orders.business_sn' => $value->business_sn])
								->whereNull('b.deleted_at')
								->first(['c.id as machineroom_id' , 'c.machine_room_name as machineroom_name']);
					break;
				case 10:
					//如果是cdn业务
					break;
				case 11:
					//如果是高防类业务
					$machine_room = $this
								->leftJoin('tz_defenseip_package as b' , 'tz_orders.machine_sn' , '=' , 'b.id')
								->leftJoin('idc_machineroom as c' , 'b.site' , '=' , 'c.id')
								->where(['tz_orders.business_sn' => $value->business_sn])
								->first(['c.id as machineroom_id' , 'c.machine_room_name as machineroom_name']);
					break;
				case 12:
					//如果是叠加包类业务
					$machine_room = $this
								->leftJoin('tz_overlay as b' , 'tz_orders.machine_sn' , '=' , 'b.id')
								->leftJoin('idc_machineroom as c' , 'b.site' , '=' , 'c.id')
								->where(['tz_orders.business_sn' => $value->business_sn])
								->first(['c.id as machineroom_id' , 'c.machine_room_name as machineroom_name']);
					break;
				default:
					//dd('no');
					break;	
			}
			$value->machineroom_id 	= isset($machine_room->machineroom_id)?$machine_room->machineroom_id:0;
			$value->machineroom_name 	= isset($machine_room->machineroom_name)?$machine_room->machineroom_name:'';
			$value->resource_type 		= $resource_type[$value->resource_type];

		}

		return $order;
	}

	
	

	public function getOrderById($order_id)
	{
		$list = $this->find($order_id);
		if($list == null){
			return false;
		}
		switch ($list->order_status) {
			case '0':
				$list->order_status = '待支付';
				break;
			case '1':
				$list->order_status = '已支付';
				break;
			case '2':
				$list->order_status = '财务确认';
				break;
			case '3':
				$list->order_status = '订单完成';
				break;
			case '4':
				$list->order_status = '到期';
				break;
			case '5':
				$list->order_status = '取消';
				break;
			case '6':
				$list->order_status = '申请退款,';
				break;
			case '8':
				$list->order_status = '退款完成';
				break;
			default:
				$list->order_status = '无此状态,请核对数据库';
				break;
		}
		switch ($list->order_type) {
			case '1':
				$list->order_type = '新购';
				break;
			case '2':
				$list->order_type = '续费';
				break;
			default:
				$list->order_type = '无此状态,请核对数据库';
				break;
		}
		switch ($list->resource_type) {
			case '1':
				$list->resource_type = '租用主机';
				break;
			case '2':
				$list->resource_type = '托管主机';
				break;
			case '3':
				$list->resource_type = '租用机柜';
				break;
			case '4':
				$list->resource_type = 'IP';
				break;
			case '5':
				$list->resource_type = 'CPU';
				break;
			case '6':
				$list->resource_type = '硬盘';
				break;
			case '7':
				$list->resource_type = '内存';
				break;
			case '8':
				$list->resource_type = '带宽';
				break;
			case '9':
				$list->resource_type = '防护';
				break;
			case '10':
				$list->resource_type = 'cdn';
				break;
			case '11':
				$package = DB::table('tz_defenseip_package')
						->select(['protection_value','site'])
						->where('id',$list->machine_sn)
						->first();
				if($package == null){
					return false;
				}
				switch ($package->site) {
					case '1':
						$list->site = '西安';
						break;
					default:
						$list->site = '套餐地区错误,请核对数据库';
						break;
				}
				$list->protection_value = $package->protection_value;
				$list->resource_type = '高防IP';
				break;
			case '12':
				$list->resource_type = '流量叠加包';
				break;
			default:
				$list->resource_type = '无此类型,请核对数据库';
				break;
		}
		return $list;
	}

	/**
	 * 取消订单
	 * @param  [type] $user_id [description]
	 * @param  [type] $id      [description]
	 * @return [type]          [description]
	 */
	public function delOrder($user_id,$id){
		// 根据订单id查找对应的订单和关联的业务编号
		$delete_data = DB::table('tz_orders')
						->join('tz_business','tz_orders.business_sn','=','tz_business.business_number')
						->where(['tz_orders.id'=>$id,'tz_orders.customer_id'=>$user_id])
						->whereNull('tz_orders.deleted_at')
						->select('tz_business.business_number','tz_business.endding_time','tz_orders.order_sn','tz_orders.order_type','tz_orders.machine_sn','tz_orders.end_time','tz_orders.order_status','tz_orders.resource_type','tz_orders.duration','tz_orders.created_at')
						->first();
		// 不存在需要删除的数据，直接返回
		if(!$delete_data){
			$return['code'] = 0;
			$return['msg'] = '(#101)无对应的订单数据/已删除!';
			return $return;
		}
		if($delete_data->order_status == 5){//当订单为取消时，无须再次操作
			$return['code'] = 0;
			$return['msg'] = '(#102)订单已取消，无须再次操作!';
			return $return;
		}
		$created_at = Carbon::parse($delete_data->created_at)->addDays(7)->toDateTimeString();//获取订单创建7天后的时间
		$now = Carbon::now()->toDateTimeString();//获取当前时间
		if($now > $created_at){//当前时间如果大于订单创建后的七天时间，代表订单已超过7天，无法再进行取消
			$return['code'] = 0;
			$return['msg'] = '(#103)该订单已超过七天无法取消';
			return $return;
		}
		DB::beginTransaction();//开启事务处理
		if($delete_data->order_status == 0){//当订单为未支付的时候删除同时需要对其相关的业务/对应的资源信息进行更新
			switch ($delete_data->resource_type) {//当资源类型为租用主机/托管主机/租用机柜时，对业务的到期时间进行更改
				case 1://租用机器
					$end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
					if($delete_data->order_type == 1){//当为新购订单取消时同时对对应的机器状态等修改为未使用
						$update['business_status'] = '-1';
						$rent['own_business'] = Null;
						$rent['business_end'] = Null;
						$rent['used_status'] = 0;
					} else {
						$rent['own_business'] = $delete_data->business_number;
						$rent['business_end'] = $end_time;
					}
					$update['endding_time'] = $end_time;
					$business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update($update);
					if($business == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '(#104)取消订单失败!!';
						return $return;
					}
					$row = DB::table('idc_machine')->where(['machine_num'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number,'business_type'=>1])->update($rent);
					if($row == 0){
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '(#105)取消订单失败!';
						return $return;
					}
					break;
				case 2://托管机器
					$end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
					if($delete_data->order_type == 1){//当为新购订单取消时同时对对应的机器状态等修改为未使用
						$update_io['business_status'] = '-1';
						$hosting['own_business'] = Null;
						$hosting['business_end'] = Null;
						$hosting['used_status'] = 0;
					} else {
						$hosting['own_business'] = $delete_data->business_number;
						$hosting['business_end'] = $end_time;
					}
					$update_io['endding_time'] = $end_time;
					$business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update($update_io);
					if($business == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '(#106)取消订单失败!';
						return $return;
					}
					$row = DB::table('idc_machine')->where(['machine_num'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number,'business_type'=>2])->update($hosting);
					if($row == 0){
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '(#107)取消订单失败!';
						return $return;
					}
					break;
				case 3://租用机柜
					if($delete_data->order_type == 1){//当为新购订单取消时同时对对应的机器状态等修改为未使用
						$cabinet['business_status'] = '-1';
						$cabinets = DB::table('idc_cabinet')->where(['cabinet_id'=>$delete_data->machine_sn])->select('own_business')->first();
						$array = explode(',',$cabinets->own_business);//先将原本的业务数据转换为数组
						$key = array_search($delete_data->business_number,$array);//查找要删除的业务编号在数组的位置的键
						array_splice($array,$key,1);//根据查找的对应键进行删除
						$own_business = implode(',',$array);//将数组转换为字符串
						$row = DB::table('idc_cabinet')->where(['cabinet_id'=>$delete_data->machine_sn])->update(['own_business'=>$own_business]);
						if($row == 0){
							DB::rollBack();
							$return['code'] = 0;
							$return['msg'] = '(#108)取消订单失败!';
							return $return;
						}

					}
					$end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
					$cabinet['endding_time'] = $end_time;
					$business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update($cabinet);
					if($business == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '(#109)取消订单失败!';
						return $return;
					}
					break;
				 case 4://IP
						if($delete_data->order_type == 1){
							$ip['own_business'] = Null;
							$ip['business_end'] = Null;
							$ip['ip_status'] = 0;
						} else {
							$end_time = $this->findResource($delete_data->order_sn,$delete_data->machine_sn,$delete_data->business_number);
							$order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>2]);
							if($order_status == 0){
								DB::rollBack();
								$return['code'] = 0;
								$return['msg'] = '(#110)删除失败!';
								return $return;
							}
							$ip['own_business'] = $delete_data->business_number;
							$ip['business_end'] = empty($end_time)?Null:$end_time->end_time;
						}

						$row = DB::table('idc_ips')->where(['ip'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number])->update($ip);
						if($row == 0){//更新业务到期时间失败
							DB::rollBack();
							$return['code'] = 0;
							$return['msg'] = '(#111)删除失败!';
							return $return;
						}

						break;
				case 5://CPU
					if($delete_data->order_type == 1){
						$cpu['service_num'] = Null;
						$cpu['business_end'] = Null;
						$cpu['cpu_used'] = 0;
					} else {
						$end_time = $this->findResource($delete_data->order_sn,$delete_data->machine_sn,$delete_data->business_number);
						$order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>2]);
						if($order_status == 0){
							DB::rollBack();
							$return['code'] = 0;
							$return['msg'] = '(#112)删除失败!';
							return $return;
						}
						$cpu['service_num'] = $delete_data->business_number;
						$cpu['business_end'] = empty($end_time)?Null:$end_time->end_time;
					}

					$row = DB::table('idc_cpu')->where(['cpu_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($cpu);
					if($row == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '(#113)删除失败!';
						return $return;
					}

					break;
				case 6://硬盘
					if($delete_data->order_type == 1){
						$harddisk['service_num'] = Null;
						$harddisk['business_end'] = Null;
						$harddisk['harddisk_used'] = 0;
					} else {
						$end_time = $this->findResource($delete_data->order_sn,$delete_data->machine_sn,$delete_data->business_number);
						$order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>2]);
						if($order_status == 0){
							DB::rollBack();
							$return['code'] = 0;
							$return['msg'] = '(#114)删除失败!';
							return $return;
						}
						$harddisk['service_num'] = $delete_data->business_number;
						$harddisk['business_end'] = empty($end_time)?Null:$end_time->end_time;
					}

					$row = DB::table('idc_harddisk')->where(['harddisk_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($harddisk);
					if($row == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '(#115)删除失败!';
						return $return;
					}

					break;
				case 7://内存
					if($delete_data->order_type == 1){
						$memory['service_num'] = Null;
						$memory['business_end'] = Null;
						$memory['memory_used'] = 0;
					} else {
						$end_time = $this->findResource($delete_data->order_sn,$delete_data->machine_sn,$delete_data->business_number);
						$order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>2]);
						if($order_status == 0){
							DB::rollBack();
							$return['code'] = 0;
							$return['msg'] = '(#116)删除失败!';
							return $return;
						}
						$memory['service_num'] = $delete_data->business_number;
						$memory['business_end'] = empty($end_time)?Null:$end_time->end_time;
					}

					$row = DB::table('idc_memory')->where(['memory_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($memory);
					if($row == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '(#117)删除失败!';
						return $return;
					}
					break;

				default:
					break;
			}
		}
		//取消对应业务数据
		$result = DB::table('tz_orders')->where(['id'=>$id])->update(['order_status'=>5]);
		if($result == 0){
			DB::rollBack();
			$return['code'] = 0;
			$return['msg'] = '(#118)取消订单失败!';
			return $return;
		}
		// 取消成功返回
		DB::commit();
		$return['msg'] = '取消订单成功,关联业务号为:'.$delete_data->business_number;
		$return['code'] = 1;
		return $return;
	}

	/**
	 * 查找某一资源在某一业务下的最新的到期时间（本身除外）
	 * @param  [type] $exclude_order 要排除的资源订单（即要删除的订单）
	 * @param  [type] $resource_sn   要查找的资源
	 * @param  [type] $business      要查找的业务
	 * @return [type]                返回到期时间
	 */
	public function findResource($exclude_order,$resource_sn,$business){
		$end = $this->where(['business_sn'=>$business,'machine_sn'=>$resource_sn,'order_status'=>3])
					->where('order_sn','<>',$exclude_order)
					->orderBy('end_time','desc')
					->select('end_time','order_sn')
					->first();
		return $end;
	}

	/**
	* 查询user表的余额数据
	*@param $user_id
	* @return 余额
	*/
	public function getMoney($user_id)
	{
		$money = DB::table('tz_users')->find($user_id,['money']);
		return $money;
	}

	/**
	* 查询业务员的名字
	*@param $admin_id
	* @return 名字
	*/
	public function getName($admin_id)
	{
		if($admin_id == '*'){
			$name = DB::table('admin_users')->get(['id','username']);
		}else{
			$name = DB::table('admin_users')->find($admin_id,['id','username']);
		}

		return $name;
	}


	/**
	 * 查找对应业务的增加的资源
	 * @param  array $where 业务编号和资源类型
	 * @return array        返回相关的资源数据和状态提示及信息
	 */
	public function resourceOrders($where){
		if($where){
			$resource_orders = $this->where($where)->get(['id','customer_id','customer_name','order_sn', 'business_sn','before_money','after_money','business_id','business_name','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_price','serial_number','pay_time','order_status','order_note','created_at','payable_money']);
			if($resource_orders->isEmpty()){
				//转换状态
				$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn','11'=>'高防IP' , '12' => '流量叠加包'];
				$order_type = [ '1' => '新购' , '2' => '续费' ];
				$order_status = [ '0' => '待支付' , '1' => '已支付' , '2' => '已支付' , '3' => '订单完成' , '4' => '取消' , '5' => '申请退款' , '6' => '退款完成' , '7' => '正在付款','8' => '退款完成'];
				foreach($resource_orders as $resource_key => $resource_value){
					$resource_orders[$resource_key]['resource_type'] = $resource_type[$resource_value['resource_type']];
					$resource_orders[$resource_key]['order_type'] = $order_type[$resource_value['order_type']];
					$resource_orders[$resource_key]['order_status'] = $order_status[$resource_value['order_status']];
				}
				$return['data'] = $resource_orders;
				$return['code'] = 1;
				$return['msg'] = '获取对应增加的资源数据成功';
			} else {
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '暂无对应增加的资源数据';
			}
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法获取增加的资源数据';
		}
		return $return;
	}

	public function checkOrder($serial_number){

		$order = $this->where('serial_number',$serial_number)->get(['order_status','pay_type','id']);

		if(!$order->isEmpty()){
			$return['data'] 	= $order;
			$return['code'] 	= 1;
			$return['msg']	= '获取订单信息成功';
		}else{
			$return['data'] 	= '';
			$return['code'] 	= 0;
			$return['msg']	= '获取订单信息失败';
		}

		return $return;
	}

	/**
	 * 获取当前业务下的所有其他资源订单信息
	 * @param  [type] $business [description]
	 * @return [type]           [description]
	 */
	public function allRenew($business){
		if(!$business){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']	= '无法获取该业务下的所有资源信息';
			return $return;
		}
		$business['remove_status']=0;
		//以资源编号为键的资源数组
		$all = $this->where($business)->where('resource_type','>',3)->orderBy('end_time','desc')->get(['order_sn','resource_type','machine_sn','resource','price','end_time','business_sn'])->groupBy('machine_sn');
		$resource = $all->map(function($item,$key){//根据资源编号获取对应资源的最新一条订单（$key为$all的键）,map参考laravel模型的集合的可用方法
			return $this->where(['machine_sn'=>$key,'business_sn'=>$item[0]['business_sn']])->where('order_status','<',3)->orderBy('end_time','desc')->select('order_sn','resource_type','machine_sn','resource','price','end_time','order_status')->first();	
		});
		if(!empty($resource)){
			$orders = [//filter和values参考laravel模型的集合的可用方法
				'IP'=>$resource->filter(function($value,$key){return $value->resource_type == 4;})->values(),
				'cpu'=>$resource->filter(function($value,$key){return $value->resource_type == 5;})->values(),
				'harddisk'=>$resource->filter(function($value,$key){return $value->resource_type == 6;})->values(),
				'memory'=>$resource->filter(function($value,$key){return $value->resource_type == 7;})->values(),
				'bandwidth'=>$resource->filter(function($value,$key){return $value->resource_type == 8;})->values(),
				'protected'=>$resource->filter(function($value,$key){return $value->resource_type == 9;})->values(),
				'cdn'=>$resource->filter(function($value,$key){return $value->resource_type == 10;})->values()
			];
			$return['data'] = $orders;
			$return['code'] = 1;
			$return['msg']  = '该业务下的其他资源信息获取成功';
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']	= '该业务下暂无其他资源信息';
		}
		return $return;
	}

	/**
	 * 新版客户端获取对应业务下的所有资源订单信息
	 * @param  array $sn_array 相关的资源编号数组
	 * @return [type]           [description]
	 */
	public function newAllRenew($id){
		$business_where[] = ['remove_status',0];
		$business_where[] = ['business_status','>','-1'];
		$business_where[] = ['business_status','<','5'];
		$business_where[] = ['id',$id];
		$business = Business::where($business_where)->select('id','business_number','machine_number')->first();
		$number = $business->business_number;
		$machine = $business->machine_number;
		
		$where[] = ['remove_status',0];//未下架
		$where[] = ['resource_type','>',3];//资源类型为非主机/机柜的资源(4.IP，5.CPU，6.硬盘，7.内存，8.带宽，9.防护)
		$where[] = ['resource_type','<',10];//资源类型为非主机/机柜的资源(4.IP，5.CPU，6.硬盘，7.内存，8.带宽，9.防护)
		
		$where[] = ['business_sn',$number];//资源绑定的业务
		//以资源编号为键的资源数组
		$all = $this->where($where)->orderBy('end_time','desc')->get(['machine_sn','end_time'])->groupBy('machine_sn');
		
		$resource_where[] = ['order_status','<',3];//资源的订单状态小于3 
		//根据资源编号获取对应资源的最新一条订单（$key为$all的键）,map参考laravel模型的集合的可用方法
		$resource =  $all->map(function($item,$key) use ($number,$machine){
			$resource_where[] = ['machine_sn',$key];//资源编号
			$resource_where[] = ['business_sn',$number];//资源对应绑定的业务
			$order = $this->where($resource_where)->orderBy('end_time','desc')->select('id','business_sn','order_sn','resource_type','machine_sn','resource','price','end_time','order_status')->first()->toArray();
			$order['machine_sn'] = $machine;
			return $order;
		});
		return $resource;
		
	}
	
	/**
	 * 续费订单的创建
	 * @param  [type] $renew [description]
	 * @return [type]        [description]
	 */
	public function renewResource($renew){
		if(!$renew){//未传递任何参数，无法进行续费
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']  = '无法进行续费,请确认后重新操作';
			return $return;
		}
		$order_str = '';//用于记录创建的续费订单的订单号
		$primary_key = '';
		$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn'];
		if(isset($renew['business_number'])){//传递了业务编号的进行业务查找和续费
			$renew_order = [];//用于存储新增的订单的id，用于存储进redis，方便后续调用订单
			$business_where = [
				'business_number'=>$renew['business_number'],
			];
			$business = DB::table('tz_business')->where($business_where)->select('id','business_number','sales_name','sales_id','business_type','client_id','client_name','business_type','machine_number','endding_time','length','money','business_status','remove_status','order_number','resource_detail')->first();
			if(!$business){
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']  = '无查找到对应的业务,无法续费';
				return $return;
			}
			if($business->business_status < 1 || $business->business_status > 3){
				$business_status = ['-1'=>'取消','-2'=>'审核不通过',0=>'审核中',1=>'审核通过',2=>'付款使用中',3=>'未付款使用',4=>'锁定中',5=>'到期',6=>'退款'];
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']  = '该业务'.$business_status[$business->business_status].'无法进行续费';
				return $return;
			}
			if($business->remove_status != 0){
				$remove_status = [0=>'正常',1=>'下架申请中',2=>'等待机房处理',3=>'清空下架中',4=>'下架完成'];
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']  = '该业务'.$remove_status[$business->remove_status].'无法进行续费,业务可能已到期未续费下架';
				return $return;
			}
			//对业务进行到期时间的更新
			$endding_time = time_calculation($business->endding_time,$renew['length'],'month');
			// 对业务的累计时长进行更新
			$length = bcadd($business->length,$renew['length'],0);
			$order['end_time'] = $endding_time;//订单到期时间
			$order['duration'] = $renew['length'];//订单时长
			$order['length'] = $renew['length'];//接收续费的时长
			$order['order_sn'] = $this->ordersn();//订单关联业务
			$order['order_number'] = $business->order_number;
			$order['customer_name'] = Auth::user()->email?Auth::user()->email:Auth::user()->name;
			$order['business_name'] = $business->sales_name;
			$order['resource_type'] = $business->business_type;//资源类型
			$order['resourcetype'] = $resource_type[$order['resource_type']];
			$order['machine_sn'] = $business->machine_number;//订单机器编号
			$resource_detail = json_decode($business->resource_detail);
			$order['id']=$business->id;
			$order['resource'] = isset($resource_detail->ip)?$resource_detail->ip:$business->machine_number;//订单机器详情
			$order['price'] = $business->money;//订单单价
			$order['payable_money'] = bcmul($business->money,$renew['length'],2);//订单应付金额
			$order['order_status'] = 0;//订单状态为未支付
			$order['created_at'] = date('Y-m-d H:i:s',time());//订单创建时间
			$order['client_id'] = Auth::user()->id;//记录客户的id
			$renew_order['O'.$order['order_sn']] = json_encode($order);
			if(empty($primary_key)){
				$primary_key = $this->redisPrimaryKey($business->id,$business->business_type);
			}
			$this->setRenewRedis($primary_key,$renew_order);
			$business_end = $endding_time;
		}
		if(isset($renew['orders'])){
			foreach($renew['orders'] as $key=>$value){
				if($value != 0){
					$renew_order = [];//用于存储新增的订单的id，用于存储进redis，方便后续调用订单
					$order_where['order_sn'] = $value;
					$order_result = $this->where($order_where)->select('id','business_sn','customer_id','customer_name','business_name','resource_type','machine_sn','resource','price','end_time','order_status')->first();
					if($order_result->order_status < 1 || $order_result->order_status > 2){
						$order_status = [0=>'待支付',1=>'支付',2=>'支付',3=>'续费过',4=>'到期',5=>'取消',6=>'申请退款',8=>'退款完成'];
						$return['data'] = '';
						$return['code'] = 0;
						$return['msg'] = '资源编号:'.$order_result->machine_sn.'的资源'.$order_result->resource.','.'无法续费,原因:'.$order_status[$order_result->order_status];
						return $return;
					}
					if(!isset($business_end)){
                    	$business_end = DB::table('tz_business')->where('business_number',$order_result->business_sn)->value('endding_time');
                    } 
                    
					//到期时间
					$end_time = time_calculation($order_result->end_time,$renew['length'],'month');
					if(date('Y-m-d',strtotime($end_time)) > date('Y-m-d',strtotime($business_end))){
                    	$order['end_time'] = $business_end;
                    	if(date('Y-m-d',strtotime($order['end_time'])) <= date('Y-m-d',strtotime($order_result->end_time))){
                    		$return['data'] = '';
	                        $return['code'] = 0;
	                        $return['msg'] = '(#103)资源编号:'.$order_result->machine_sn.'的资源'.$order_result->resource.','.'无法续费,原因:续费后到期时间与原到期时间相等或小于';
	                        return $return;
                    	}
						$day_money = bcdiv($order_result->price,30,2);//一天的价格
						$day = date_diff(date_create($order_result->end_time),date_create($business_end))->format('%a');//到期时间跟现在时间相隔的天数
						$order['payable_money'] = bcmul($day_money,$day,2);//应付金额
						$order['duration'] = $day;//订单时长
						$order['note'] = '资源到期时间跟主业务到期时间一致，不足月按实际使用天数收费';
						$order['length'] = $renew['length'];//接收续费的时长
						$order['price'] = $day_money;//订单单价
                    } else {
						$order['end_time'] = $end_time;
						$order['payable_money'] = bcmul($order_result->price,$renew['length'],2);//订单应付金额
						$order['duration'] = $renew['length'];//订单时长
						$order['length'] = $renew['length'];//接收续费的时长
						$order['price'] = $order_result->price;//订单单价
					}
					
					$order['order_sn'] = $this->ordersn();//订单关联业务
					$order['order_number'] = $value;
					$order['customer_name'] = Auth::user()->email?Auth::user()->email:Auth::user()->name;
					$order['business_name'] = $order_result->business_name;
					$order['resource_type'] = $order_result->resource_type;//资源类型
					$order['resourcetype'] = $resource_type[$order['resource_type']];
					$order['machine_sn'] = $order_result->machine_sn;//订单机器编号
					$order['resource'] = $order_result->resource;//订单机器详情
					$order['order_status'] = 0;//订单状态为未支付
					$order['created_at'] = date('Y-m-d H:i:s',time());//订单创建时间
					$order['id']=$order_result->id;
					$order['client_id'] = Auth::user()->id;
					$renew_order['O'.$order['order_sn']] = json_encode($order);
					if(empty($primary_key)){
						$primary_key = $this->redisPrimaryKey($order_result->id,$order_result->resource_type);
					}
					$this->setRenewRedis($primary_key,$renew_order);   
				}	
			}    
		}
		$return['data'] = $primary_key;
		$return['code'] = 1;
		$return['msg'] = '续费已经创建,支付后即代表续费成功!';
		return $return;

	}

	/**
 	* 新客户端进行续费操作 
	* @param array 所需续费的资源相关数据
	* 格式:['resource'=>[['id'=>1,'resource_type'=>1]],'length'=>1]
	* resource是资源的集合(id是资源所绑定的业务id,resource_type是资源类型) 
	* @return: 
	*/
	public function newRenewResource($renew_data){
		$resource = $renew_data['resource'];//获取需要续费的资源的集合
		$length = $renew_data['length'];//获取续费时长
		usort($resource,function($first,$second){//对传递的资源集合进行重新排列
			return $first["resource_type"] - $second["resource_type"];
		});
		
		foreach($resource as $value){//循环取出对应需要续费资源数据
			/**
			 * 进行验证，需要续费的资源数据是否传递完整
			 */
			$rules = ['id'=>'required|integer','resource_type'=>'required|integer'];
			$messages = [
				'id.required'=>'需要续费的资源数据不完整',
				'id.integer'=>'需要续费的资源数据有误',
				'resource_type.required'=>'需要续费的资源类型不完整',
				'resource_type.integer'=>'需要续费的资源类型有误',
			];
			$validator = Validator::make($value,$rules,$messages);
			if($validator->messages()->first()){
				$return['data'] = '';
				$return['msg'] = $validator->messages()->first();
				$return['code'] = 0;
				return $return;
			}

			$id = $value['id'];//对应要续费的资源业务的id
			$type = $value['resource_type'];//对应要续费的资源类型

			/**
			 * 主机/机柜资源的业务续费
			 */
			if($type < 4){
				$where = [];//每进一次区间清空上一次条件
				$where[] = ['business_status','>',0];//业务状态为正常
				$where[] = ['business_status','<',4];//业务状态为正常
				$where[] = ['remove_status',0];//下架状态为正常
				$where[] = ['id',$id];//根据业务id
				$resource_data = Business::where($where)->select('id','business_number','sales_name as business_name','sales_id','client_id','client_name','business_type','machine_number as machine_sn','endding_time','length','money as price','order_number as order_sn','resource_detail')->first();
				
				if(!$resource_data){//数据不存在
					$return['data'] = '';
					$return['msg'] = '您续费的'.resource_type($type).'业务可能已下架或业务状态异常,请确认无误或联系您的专属业务员解决';
					$return['code'] = 0;
					return $return;
				}

				/**
				 * 获取resouce,方便后面展示
				 */
				$resource_detail = json_decode($resource_data->resource_detail);
				$resource_data->resource = isset($resource_detail->ip)?$resource_detail->ip:$resource_data->machine_number;

				$end_str = 'end'.$resource_data->business_number;//生成带业务号的字符串
				$end_time = time_calculation($resource_data->endding_time,$length,'month');//计算到期时间
				$$end_str = $end_time;//用于带业务号的变量用于接收续费后新的到期时间
				$order['duration'] = $length;//订单时长
				$order['payable_money'] = bcmul($resource_data->price,$length,2);//订单应付金额
				$order['note'] = '资源到期时间跟主业务到期时间一致，不足月按实际使用天数收费';
				$order['price'] =$resource_data->price;//订单单价
				$order['machineroom_name'] = $resource_detail->machineroom_name;
			}

			/**
			 * //4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护'资源续费
			 */
			if($type > 3 && $type < 10){
				$order_where = [];//每进一次区间清空上一次条件
				$order_where[] = ['order_status','>',0];//资源业务状态为正常
				$order_where[] = ['order_status','<',3];//资源业务状态为正常
				$order_where[] = ['remove_status',0];//资源业务未下架
				$order_where[] = ['id',$id];//资源业务的id
				$resource_data = $this->where($order_where)->select('id','order_sn','business_sn','customer_id','customer_name','business_name','resource_type','machine_sn','resource','price','end_time')->first();
				
				if(!$resource_data){//资源信息是否存在
					$return['data'] = '';
					$return['msg'] = '您续费的'.resource_type($type).'业务可能已下架或业务状态异常,请确认无误或联系您的专属业务员解决';
					$return['code'] = 0;
					return $return;
				}

				$business = Business::where(['business_number'=>$resource_data->business_sn])->select('resource_detail','endding_time')->first();
				/**
				 * 接收关联主机业务的到期时间
				 */
				$end_str = 'end'.$resource_data->business_sn;//生成带业务号的字符串
				// $$end_str = $$end_str?$$end_str:Business::where(['business_number'=>$resource_data->business_sn])->value('endding_time');
				$$end_str = $$end_str?$$end_str:$business->endding_time;
				$business_detail = json_decode($business->resource_detail);
				$end_time = time_calculation($resource_data->end_time,$length,'month');//到期时间计算

				/**	
				 * 判断续费后资源的到期时间是否超过绑定主机业务的到期时间
				 */
				if(date('Y-m-d',strtotime($end_time)) > date('Y-m-d',strtotime($$end_str))){//超过主机业务到期时间
					$end_time = $$end_str;//资源到期时间与主机业务到期时间统一
					
					if(date('Y-m-d',strtotime($end_time)) <= date('Y-m-d',strtotime($resource_data->end_time))){//到期时间小于/等于原到期时间
						$return['data'] = '';
						$return['code'] = 0;
						$return['msg'] = '资源编号:'.$resource_data->machine_sn.'的资源'.$resource_data->resource.','.'无法续费,原因:续费后到期时间与原到期时间相等或小于';
						return $return;
					}

					$day_money = bcdiv($resource_data->price,30,2);//一天的价格
					$day = date_diff(date_create($resource_data->end_time),date_create($$end_str))->format('%a');//到期时间跟现在时间相隔的天数
					$order['payable_money'] = bcmul($day_money,$day,2);//应付金额
					$order['duration'] = $day;//订单时长
					$order['note'] = '资源到期时间跟主业务到期时间一致，不足月按实际使用天数收费';
					$order['price'] = $day_money;//订单单价
					$order['machineroom_name'] = $business_detail->machineroom_name;

				} else {
					$order['payable_money'] = bcmul($resource_data->price,$length,2);//订单应付金额
					$order['duration'] = $length;//订单时长
					$order['price'] = $resource_data->price;//订单单价
					$order['machineroom_name'] = $business_detail->machineroom_name;
				}

			}

			/**
			 * 续费的共同数据生成
			 */
			$order['order_sn'] = $this->ordersn();//生成的续费订单号
			$order['length'] = $length;//接收续费的时长
			$order['order_number'] = $resource_data->order_sn;//原本的订单号
			$order['customer_name'] = Auth::user()->email?Auth::user()->email:Auth::user()->name;
			$order['business_name'] = $resource_data->business_name;
			$order['resource_type'] = $type;//资源类型
			$order['resourcetype'] = resource_type($type);//转换后的资源类型
			$order['machine_sn'] = $resource_data->machine_sn;//订单机器编号
			$order['resource'] = $resource_data->resource;//订单机器详情
			$order['order_status'] = 0;//订单状态为未支付
			$order['created_at'] = date('Y-m-d H:i:s',time());//订单创建时间
			$order['id']=$resource_data->id;//原id
			$order['client_id'] = Auth::user()->id;//客户id
			$order['end_time'] = $end_time;//订单到期时间

			/**	
			 * 将订单丢进redis队列中
			 */
			$renew_order['O'.$order['order_sn']] = json_encode($order);
			if(!isset($primary_key)){
				$primary_key = $this->redisPrimaryKey($resource_data->id,$type);
			}
			$this->setRenewRedis($primary_key,$renew_order);
		}

		$return['data'] = $primary_key;
		$return['code'] = 1;
		$return['msg'] = '续费已经创建,支付后即代表续费成功!';
		return $return;
		
	}

	/**
	 * 展示刚刚续费的订单
	 * @param  array $renew_order 刚刚续费的订单id
	 * @return array              返回获取数据的信息
	 */
	public function showRenewOrder($renew_order){
		if(!$renew_order){//session也未找到新续费的订单id数据时，直接返回
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']	= '无法获取支付信息';
			return $return;
		}
		$renew_order['customer_id'] = Auth::user()->id;
		$renew_order['order_status'] = 0;
		$order = $this->where($renew_order)->select('id','order_sn','resource_type','order_type','machine_sn','resource','price','duration','end_time','order_status','order_note','created_at')->get();
		$all_price = 0;
		if(!$order->isEmpty()){
			foreach($order as $renew_key=>$renew_value){//对订单进行一一获取
				$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP'];
				$order_type = [1=>'新购',2=>'续费'];
				$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成'];
				$renew_value->resource_type = $resource_type[$renew_value->resource_type];
				$renew_value->order_type = $order_type[$renew_value->order_type];
				$renew_value->order_status = $order_status[$renew_value->order_status];
				$total_price = bcmul($renew_value->price,$renew_value->duration,2);
				$all_price = bcadd($all_price,$total_price,2);
			}
		}

		$orders['all_price'] = $all_price;
		$orders['orders'] =  $order;
		$return['data'] = $orders;
		$return['code'] = 1;
		$return['msg'] = '资源续费订单获取成功';
		return $return;
	}



	/**
	 * 创建订单号
	 * @return [type] [description]
	 */
	public function ordersn($resource_id=100,$resource_type=1){
		// $time = bcadd(time(),$resource_id,0);
	 //    $order_sn = mt_rand(4, 6) . date("Ymd", time()) . substr($time, 6, 4) . $resource_id .mt_rand(1, 3).'1';
		$order_sn = create_number();//调用创建单号的公共函数
		// $order_sn = mt_rand(4,6).date('YmdHis').$time.mt_rand(10,99).'1'.$resource_type;
		$order = DB::table('tz_orders')->where('order_sn',$order_sn)->select('order_sn','machine_sn')->first();
		$redis = Redis::connection('orders');
		if(!empty($order)){
			$this->ordersn($resource_id,$resource_type);
		}
		if($redis->exists('O'.$order_sn) != 0){
			$this->ordersn($resource_id,$resource_type);
		}
		return $order_sn;
	}

	/**
	 * 生成支付流水号
	 * @return [type] [description]
	 */
	public function serialNumber($id){
		// sleep(1);
		// $business_id = Admin::user()->id;
		$time = bcadd(time(),$id,0);
		// $serial_number = 'tz_'.chr(mt_rand(97,122)).$time.mt_rand(10,50).'_admin_'.$business_id;
		$serial_number = 'tz_'.chr(mt_rand(97,122)).$time.mt_rand(51,99).'_'.Auth::user()->id;
		if(empty($serial_number)){

			$this->serialNumber($id);
		}
		$serial = DB::table('tz_orders_flow')->where(['serial_number'=>$serial_number])->select('id','business_number')->first();
		if(!empty($serial)){
			$this->serialNumber($id);

		} 
		return $serial_number;
		
	}

	/**
	 * 生成队列的主键
	 * @return [type] [description]
	 */
	public function redisPrimaryKey($id,$type){
		if(!isset($id)){
			$id = mt_rand(10000,20000);
		}
		if(!isset($type)){
			$type = mt_rand(11,20);
		}
		$order_sn = 'TRZ'.$this->ordersn($id,$type);
		$redis = Redis::connection('orders');
		if($redis->exists($order_sn) != 0  || $redis->exists('M'.$order_sn) != 0 || $redis->exists('C'.$order_sn) != 0){
			$this->redisPrimaryKey($id,$type);
		}
		return $order_sn;
	}

	/**
	 * 续费订单的支付
	 * @param  array $pay_key 续费订单的session键
	 * @return [type]          [description]
	 */
	public function payRenew($pay_key){
		if(!$pay_key){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']  = '(#101)无法获取需要支付的续费信息';
			return $return;
		}
		$redis_length = $this->renewRedisLength('P'.$pay_key['pay_key']);
		if(!$redis_length > 0){
			$return['data'] = $redis_length;
			$return['code'] = 0;
			$return['msg']  = '(#102)无对应续费信息，请确认无误后操作';
			return $return;
		}
		$redis = Redis::connection('orders');
		$total_money = $redis->get('M'.$pay_key['pay_key']);
		// $client = $redis->get('C'.$pay_key['pay_key']);
		$client_money = DB::table('tz_users')->where(['id'=>Auth::user()->id])->value('money');//获取客户的余额
		if(bccomp($client_money,$total_money,2) < 0){//当余额小于需支付的金额时为-1，小于0，无法进行续费
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']  = '(#103)余额不足，无法进行支付，续费失败，请充值后再续费';
			return $return;
		}
		DB::beginTransaction();
		$serial_number = '';
		$client_id = '';
		for($get_pay = 0;$get_pay < $redis_length;$get_pay++){
			$renew_value = $this->getRenewRedis('P'.$pay_key['pay_key'],'pay');
			if(empty($renew_value)){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']  = '(#104)无对应的续费订单,请确认!';
				return $return;
			}
			if(isset($client_id) && empty($client_id)){
				$client_id = $renew_value['client_id'];
			}
			if($client_id != $renew_value['client_id']){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']  = '(#105)续费的订单不是同一客户,请核查!';
				return $return;
			}
			$order = DB::table('tz_orders')->where(['order_sn'=>$renew_value['order_number']])->select('id','order_sn','business_id','business_sn','machine_sn','duration')->first();//查找对应的订单数据
			if(empty($order)){//当无法找到对应的订单数据
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']  = '(#106)该资源不存在无法进行续费，请确认!';
				return $return;
			}
			if($renew_value['resource_type'] < 4){//当业务类型是租用主机/托管主机/租用机柜时需进一步对本身的业务数据的到期时间进行更新
				$business = DB::table('tz_business')->where(['business_number'=>$order->business_sn])->select('id','machine_number','length')->first();
				if(empty($business)){//未找到对应的业务数据
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg']  = '(#107)该业务资源不存在无法进行续费，请确认!';
					return $return;
				}
				$length = bcadd($renew_value['length'],$business->length);//更新累计时长
				$update_business = DB::table('tz_business')->where(['business_number'=>$order->business_sn])->update(['length'=>$length,'endding_time'=>$renew_value['end_time']]);
				if($update_business == 0){//更新业务到期时间和累计时长失败
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg']  = '(#108)该业务资源续费失败，请确认!';
					return $return;
				}
			}
			$duration = bcadd($renew_value['length'],$order->duration);//更新累计时长
			$pay_time = date('Y-m-d H:i:s',time());//更新支付时间
			$update_order = DB::table('tz_orders')->where(['order_sn'=>$renew_value['order_number']])->update(['duration'=>$duration,'end_time'=>$renew_value['end_time']]); 
			if($update_order == 0){//更新累计时长，到期时间，支付时间失败
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']  = '(#109)该资源续费失败，请确认!';
				return $return;
			}
			switch ($renew_value['resource_type']) {
				case 1:
					$machine = [];
					$machine['business_end'] = $renew_value['end_time'];
					//如果是租用机器的，在续费支付成功时，将业务编号和到期时间及资源状态进行更新
					$machine['own_business'] = $order->business_sn;
					$machine['used_status'] = 2;
					$where = ['own_business'=>$order->business_sn,'machine_num'=>$order->machine_sn];
					$result = DB::table('idc_machine')->where($where)->update($machine);
					break;
				case 2:
					$machine = [];
					$machine['business_end'] = $renew_value['end_time'];
					//如果是托管机器的，在续费支付成功时，将业务编号和到期时间及资源状态进行更新
					$machine['own_business'] = $order->business_sn;
					$machine['used_status'] = 2;
					$where = ['own_business'=>$order->business_sn,'machine_num'=>$order->machine_sn];
					$result = DB::table('idc_machine')->where($where)->update($machine);
					break;
				case 3:
					$machine = [];
					// $machine['business_end'] = $order->end_time;
					//如果是租用机柜的，在续费支付成功时，将业务编号和到期时间及资源状态进行更新
					$cabinet = DB::table('idc_cabinet')->where(['cabinet_id'=>$order->machine_sn])->value('own_business');
					$business = strpos($cabinet,$order->business_sn)+1;
					if(!$business){
						DB::rollBack();
						$return['data'] = '';
						$return['code'] = 0;
						$return['msg'] = '(#110)资源续费失败,请确认您此前购买过该机柜';
						return $return;
					}
					$result = 1;
					break;
				case 4:
					$resource = [];
					$resource['business_end'] = $renew_value['end_time'];
					//更新IP表的所属业务编号，资源状态和到期时间
					$resource['own_business'] = $order->business_sn;
					$resource['ip_status'] = 1;
					$where = ['own_business'=>$order->business_sn,'ip'=>$order->machine_sn];
					$result = DB::table('idc_ips')->where($where)->update($resource);
					break;
				case 5:
					$resource = [];
					$resource['business_end'] = $renew_value['end_time'];
					//更新CPU表的所属业务编号，资源状态和到期时间
					$resource['service_num'] = $order->business_sn;
					$resource['cpu_used'] = 1;
					$where = ['service_num'=>$order->business_sn,'cpu_number'=>$order->machine_sn];
					$result = DB::table('idc_cpu')->where($where)->update($resource);
					break;
				case 6:
					$resource = [];
					$resource['business_end'] = $renew_value['end_time'];
					//更新硬盘表的所属业务编号，资源状态和到期时间
					$resource['service_num'] = $order->business_sn;
					$resource['harddisk_used'] = 1;
					$where = ['service_num'=>$order->business_sn,'harddisk_number'=>$order->machine_sn];
					$result = DB::table('idc_harddisk')->where($where)->update($resource);
					break;
				case 7:
					$resource = [];
					$resource['business_end'] = $renew_value['end_time'];
					//更新内存表的所属业务编号，资源状态和到期时间
					$resource['service_num'] = $order->business_sn;
					$resource['memory_used'] = 1;
					$where = ['service_num'=>$order->business_sn,'memory_number'=>$order->machine_sn];
					$result = DB::table('idc_memory')->where($where)->update($resource);
					break;
				default:
					$result = 1;
					break;
			}
			if($result == 0){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '(#111)资源续费失败!!';
				return $return;
			}

			$money = DB::table('tz_users')->where(['id'=>Auth::user()->id])->value('money');//获取客户的余额
			$total = bcmul($renew_value['price'],$renew_value['duration'],2);//计算需要支付的金额
			$over_money = bcsub($money,$total,2);//进行余额扣除
			if($total != 0.00){
				$users = DB::table('tz_users')->where(['id'=>Auth::user()->id])->update(['money'=>$over_money]);//更新余额到对应的客户
				if($users == 0){//更新客户余额失败
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg']  = '(#112)支付失败，续费失败';
					return $return;
				}
			}
			$room = DB::table('tz_business')->where(['business_number'=>$order->business_sn])->value('resource_detail');
			$room_id = json_decode($room)->machineroom_id;
			$pay_info = [
				'serial_number'=>$this->serialNumber($renew_value['id']),
				'order_id'=>$order->id,
				'business_id'=>$order->business_id,
				'customer_id'=>Auth::user()->id,
				'payable_money'=>$total,
				'business_number'=>$order->business_sn,
				'actual_payment'=>$total,
				'preferential_amount'=>0.00,
				'pay_time'=>date('Y-m-d H:i:s',time()),
				'before_money'=>$money,
				'after_money'=>$over_money,
				'coupon_id'=>0,
				'created_at'=>date('Y-m-d H:i:s',time()),
				'flow_type'=>2,
				'room_id'=>$room_id
			];
			if(isset($renew_value['note'])){//当资源跟主机到期时间调整一致时,增加支付流水备注
				$pay_info['note'] = $renew_value['note'];
			}
			$serial = DB::table('tz_orders_flow')->insert($pay_info);
			if($serial == 0){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '(#113)资源续费扣除失败!!!';
				return $return;
			}

		}
		DB::commit();
		return ['data'=>'','code'=>1,'msg'=>'资源续费成功,请及时确认信息'];
	}

	// /**
	//  * 生成支付流水号
	//  * @return [type] [description]
	//  */
	// public function serialNumber($id){
	// 	$time = bcadd(time(),$id,0);
	// 	$serial_number = 'tz_'.chr(mt_rand(97,122)).$time.mt_rand(51,99).'_'.Auth::user()->id;
	// 	if(empty($serial_number)){
 //   			$this->serialNumber();
 //   		}
	// 	$serial = DB::table('tz_orders_flow')->where(['serial_number'=>$serial_number])->select('id','business_number')->first();
	// 	if(!empty($serial)){
	// 		$this->serialNumber();
	// 	} else {
	// 		return $serial_number;
	// 	}
	// }

	/**
	 * 客户查看支付流水
	 * @param
	 * @return array        返回相关的数据信息和提示状态及信息
	 */
	public function flows(){
		$result = DB::table('tz_orders_flow as flow')
					->where(['flow.customer_id'=>Auth::user()->id])
					->whereNull('flow.deleted_at')
					->select('flow.id as flow_id','flow.business_number','flow.serial_number','flow.payable_money','flow.actual_payment','flow.preferential_amount','flow.pay_time','flow.before_money','flow.after_money','flow.created_at','flow.flow_type')
					->orderBy('flow.pay_time','desc')
					->get();
		if(!empty($result)){
			foreach($result as $key=>$value){
				$flow_type = [1=>'新购',2=>'续费',3=>'增值'];
				$value->type = $flow_type[$value->flow_type];
			}
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '账单流水获取成功！';
		} else {
			$return['data'] = $result;
			$return['code'] = 0;
			$return['msg'] = '账单流水获取失败！';
		}
		return $return;
	}

	/**
	 * 续费时调用redis存储
	 * @param string  $primary_key push的键
	 * @param array  $param       需要存储的数据的数组，
	 * @param integer $expire_time        过期时间默认2小时,以秒为计算单位
	 */
	public function setRenewRedis($primary_key,$param,$expire_time=7200){
		$redis = Redis::connection('orders');
		$has_key = array_keys($param);
		$key_count = count($has_key);
		for($time = 0;$time < $key_count; $time++){
			$key = $has_key[$time];
			$redis->set($key,$param[$key]);
			$redis->expire($key,$expire_time);
			$redis->lpush($primary_key,$key);
			$redis->expire($primary_key,$expire_time);
		}
	}

	/**
	 *续费时取出redis存储的续费订单
	 * @param  string  $primary_key push的键
	 * @return [type]               [description]
	 */
	public function getRenewRedis($parimary_key,$type = 'order'){
		$redis = Redis::connection('orders');
		if($type == 'order'){
			$orders = [];
			$length = $redis->llen($parimary_key);
			if(!$length > 0){
				return $orders;
			}
			$key = 0;
			$total = 0;
			$client_id = '';
			while($key<$length){
				$primar_value = $redis -> lindex ($parimary_key ,$key);
				$order = $redis->get($primar_value);
				if(!empty($order)){
					$order_array = json_decode($order);
					array_push($orders,$order_array);
					$pay_key = 'P'.$parimary_key;
					$pay_value = 'P'.$primar_value;
					$redis->lpush($pay_key,$pay_value);
					$redis->del($primar_value);
					$pay['order_number'] = $order_array->order_number;
					$pay['resource_type'] = $order_array->resource_type;
					$pay['duration'] = $order_array->duration;
					$pay['length'] = $order_array->length;
					$pay['end_time'] = $order_array->end_time;
					$pay['client_id'] = $order_array->client_id;
					$pay['price'] = $order_array->price;
					$pay['id'] = $order_array->id;
					$pay_data = json_encode($pay);
					$redis->set($pay_value,$pay_data);
					$total = bcadd($total,bcmul($pay['price'],$pay['duration'],2),2);
					if(isset($client_id) && empty($client_id)){
						$client_id = $pay['client_id'];
					}
					if($client_id != $pay['client_id']){
						$orders = [];
					}
					if(isset($order_array->note)){
		   				$pay['note'] = $order_array->note;
		   			}
				} 
				$key++;       
			}
			$redis->set('M'.$parimary_key,$total);
			$redis->set('C'.$parimary_key,$client_id);
		} elseif($type == 'pay'){
			$primar_value = $redis->rpop($parimary_key);
			$order = $redis->get($primar_value);
			$orders = (array)json_decode($order);
			$redis->del($primar_value);
		}
		
		return $orders;
	}

	/**
	 * 续费时获取队列的长度
	 * @param  [type] $parimary_key [description]
	 * @return [type]               [description]
	 */
	public function renewRedisLength($parimary_key){
		$redis = Redis::connection('orders');
		$length = $redis->llen($parimary_key);
		return $length;
	}

}
