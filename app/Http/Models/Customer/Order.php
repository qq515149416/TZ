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

class Order extends Model
{

	use SoftDeletes;

	protected $table = 'tz_orders'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['order_sn', 'business_sn','customer_id','before_money','after_money','business_id','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','refund_money','refund_time','refund_note','order_note','created_at','payable_money'];

	/**
	 * 用于在获取续费的资源时分类
	 * @param  array $array 需要分类的数据
	 * @param  int $state 分类的条件
	 * @return [type]        [description]
	 */
	private function filter($array,$state){
        $this->state = $state;
        $result = [];
        $arr = array_filter($array,function($var) {
            return $var['resource_type'] == $this->state;
        });
        foreach ($arr as $key => $value) {
        	array_push($result,$value);
        }
        return $result;
    }

	public function getList($type)
	{
		$user_id = Auth::user()->id;
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
		$order = DB::table('tz_orders')
                    ->leftJoin('tz_orders_flow','tz_orders.serial_number','=','tz_orders_flow.serial_number')
                    ->where($where)
                    ->whereNull('tz_orders.deleted_at')
                    ->orderBy('tz_orders.created_at','desc')
        			->select('tz_orders.id','tz_orders.order_sn','tz_orders.business_sn','tz_orders.business_id','tz_orders.end_time','tz_orders.resource_type','tz_orders.order_type','tz_orders.machine_sn','tz_orders.resource','tz_orders.price','tz_orders.duration','tz_orders.payable_money','tz_orders.end_time','tz_orders.serial_number','tz_orders.pay_time','tz_orders.order_status','tz_orders.order_note','tz_orders.created_at','tz_orders_flow.before_money','tz_orders_flow.after_money')
        			->get();

		if(count($order) == 0){
			return false;
		}

		//转换状态
		$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn' , '11' => '高防IP'];
		$order_type = [ '1' => '新购' , '2' => '续费' ];

		$order_status = [ '0' => '待支付' , '1' => '已支付' , '2' => '已支付' , '3' => '订单完成' , '4' => '到期' , '5' => '取消' , '6' => '申请退款', '8' => '退款完成'];

		$info = $this->getName('*');
		$admin_name = [];
		foreach ($info as $k => $v) {
			$admin_name[$v->id] = $v->username;
		}

		foreach ($order as $key => $value) {

			$value->type = $value->resource_type;
			$value->resource_type = $resource_type[$value->resource_type];
			$value->order_type = $order_type[$value->order_type];
			$value->order_status = $order_status[$value->order_status];
			$value->business_name	= $admin_name[$value->business_id];
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
				$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn','11'=>'高防IP'];
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
		$all = $this->where($business)->where('order_status','<',3)->where('resource_type','>',3)->orderBy('end_time','desc')->get(['order_sn','resource_type','machine_sn','resource','price','end_time'])->groupBy('machine_sn')->toArray();
		// ->where('price','>','0.00')
		$all_keys = array_keys($all);//获取分组后的资源编号
		foreach($all_keys as $key=>$value){
			$business['machine_sn'] = $value;
			$resource[$key] = $this->where($business)->where('order_status','<',3)->orderBy('end_time','desc')->select('order_sn','resource_type','machine_sn','resource','price','end_time','order_status')->first();
		}
		if(!empty($resource)){
			foreach($resource as $key=>$value){
				$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn',11=>'高防IP'];
				$resource[$key]['resourcetype'] = $resource_type[$value['resource_type']];
			}
			$orders = ['IP'=>$this->filter($resource,4),'cpu'=>$this->filter($resource,5),'harddisk'=>$this->filter($resource,6),'memory'=>$this->filter($resource,7),'bandwidth'=>$this->filter($resource,8),'protected'=>$this->filter($resource,9),'cdn'=>$this->filter($resource,10)];

			$return['data'] = $orders;
			$return['code'] = 1;
			$return['msg']	= '该业务下的其他资源信息获取成功';
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']	= '该业务下暂无其他资源信息';
		}
		return $return;
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
			$return['msg']	= '(#101)无法进行续费,请确认后重新操作';
			return $return;
		}
		$order_str = '';//用于记录创建的续费订单的订单号
		$renew_order = [];//用于存储新增的订单的id，用于存储进session，方便后续调用订单
		$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn'];
		DB::beginTransaction();//开启事务处理
		if(isset($renew['business_number'])){//传递了业务编号的进行业务查找和续费
			$business_where = [
				'business_number'=>$renew['business_number'],
				'client_id' => Auth::user()->id,
			];
			$business = DB::table('tz_business')->where($business_where)->select('id','business_number','order_number','business_type','sales_id','sales_name','sales_name','business_type','machine_number','endding_time','length','money','business_status','remove_status','resource_detail')->first();
			if(!$business){
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']	= '(#102)无查找到对应的业务,无法续费';
				return $return;
			}
			if($business->business_status < 1 || $business->business_status > 3){
				$business_status = ['-1'=>'取消','-2'=>'审核不通过',0=>'审核中',1=>'审核通过',2=>'付款使用中',3=>'未付款使用',4=>'锁定中',5=>'到期',6=>'退款'];
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']	= '(#103)该业务'.$business_status[$business->business_status].'无法进行续费';
				return $return;
			}
			if($business->remove_status != 0){
				$remove_status = [0=>'正常',1=>'下架申请中',2=>'等待机房处理',3=>'清空下架中',4=>'下架完成'];
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg']  = '(#104)该业务'.$remove_status[$business->remove_status].'无法进行续费,业务可能已到期未续费下架';
                return $return;
            }
			//对业务进行到期时间的更新
			$endding_time = Carbon::parse($business->endding_time)->modify('+'.$renew['length'].' months')->toDateTimeString();
			// 对业务的累计时长进行更新
			$length = bcadd($business->length,$renew['length'],0);
			$order['end_time'] = $endding_time;//订单到期时间
			$order['duration'] = $renew['length'];//订单时长
			$order['order_sn'] = $this->orderSn();//订单关联业务
			$order['order_number'] = $business->order_number;
			$order['customer_id'] = Auth::user()->id;//订单关联客户
			$order['customer_name'] = Auth::user()->name?Auth::user()->name:Auth::user()->email;
			$order['business_id'] = $business->sales_id;//订单绑定业务员
			$order['business_name'] = $business->sales_name;
			$order['resource_type'] = $business->business_type;//资源类型
			$order['resourcetype'] = $resource_type[$order['resource_type']];
			$order['machine_sn'] = $business->machine_number;//订单机器编号
			$resource_detail = json_decode($business->resource_detail);
			$order['resource'] = isset($resource_detail->ip)?$resource_detail->ip:$business->machine_number;//订单机器详情
			$order['machineroom_id'] = $resource_detail->machineroom_id;
			$order['machineroom_name'] = $resource_detail->machineroom_name;
			$order['price'] = $business->money;//订单单价
			$order['payable_money'] = bcmul($business->money,$renew['length'],2);//订单应付金额
			$order['order_status'] = 0;//订单状态为未支付
			$order['created_at'] = date('Y-m-d H:i:s',time());//订单创建时间
			$order['id'] = $business->id;
			$renew_order['client_id'] = Auth::user()->id;//记录客户的id
			array_push($renew_order,$order);
		}
		if(isset($renew['orders'])){
			$order_where = [
				'customer_id' => Auth::user()->id,
			];
			foreach($renew['orders'] as $key=>$value){
				if($value != 0){
					$order_where['order_sn'] = $value;
					$order_result = $this->where($order_where)->select('id','business_sn','business_id','customer_id','business_name','resource_type','machine_sn','resource','price','end_time','order_status')->first();
					if($order_result->order_status < 1 || $order_result->order_status > 2){
						$order_status = [0=>'待支付',1=>'支付',2=>'支付',3=>'续费过',4=>'到期',5=>'取消',6=>'申请退款',8=>'退款完成'];
						DB::rollBack();
						$return['data'] = '';
						$return['code'] = 0;
						$return['msg'] = '(#108)资源编号:'.$order_result->machine_sn.'的资源'.$order_result->resource.','.'无法续费,原因:'.$order_status[$order_result->order_status];
						return $return;
					}
					//到期时间
					$end_time = Carbon::parse($order_result->end_time)->modify('+'.$renew['length'].' months')->toDateTimeString();
					$order['end_time'] = $end_time;
					$order['duration'] = $renew['length'];//订单时长
					$order['order_sn'] = $this->orderSn();
					$order['order_number'] = $value;
					$order['customer_id'] = Auth::user()->id;//订单关联客户
					$order['customer_name'] = Auth::user()->name?Auth::user()->name:Auth::user()->email;
					$order['business_id'] = $order_result->business_id;//订单绑定业务员
					$order['business_name'] = $order_result->business_name;
					$order['resource_type'] = $order_result->resource_type;//资源类型
					$order['resourcetype'] = $resource_type[$order['resource_type']];
					$order['order_type'] = 2;//订单类型为续费
					$order['machine_sn'] = $order_result->machine_sn;//订单机器编号
					$order['resource'] = $order_result->resource;//订单机器详情
					$order['price'] = $order_result->price;//订单单价
					$order['payable_money'] = bcmul($order_result->price,$renew['length'],2);//订单应付金额
					$order['order_status'] = 0;//订单状态为未支付
					$order['created_at'] = date('Y-m-d H:i:s',time());//订单创建时间
					$order['id'] = $order_result->id;
					if(isset($renew_order['client_id']) && $order_result->customer_id != $renew_order['client_id']){
	                	$return['data'] = '';
	                    $return['code'] = 0;
	                    $return['msg'] = '续费的业务和订单不属于同一个客户';
	                    return $return;
	                } elseif(!isset($renew_order['client_id'])) {
	                	$renew_order['client_id'] = $order_result->customer_id;
	                }
	                switch ($order_result->resource_type) {
	                	case 4:
	                		$order['machineroom_id'] = DB::table('idc_ips')->where(['ip'=>$order['machine_sn']])->value('ip_comproom');
	                		break;
	                	case 5:
	                		$order['machineroom_id'] = DB::table('idc_cpu')->where(['cpu_number'=>$order['machine_sn']])->value('room_id');
	                		break;
	                	case 6:
	                		$order['machineroom_id'] = DB::table('idc_harddisk')->where(['harddisk_number'=>$order['machine_sn']])->value('room_id');
	                		break;
	                	case 7:
	                		$order['machineroom_id'] = DB::table('idc_memory')->where(['memory_number'=>$order['machine_sn']])->value('room_id');
	                		break;
	                	case 8:
	                	case 9:
	                		$business_detail = DB::table('tz_business')->where(['business_number'=>$order_result->business_sn])->value('resource_detail');	
	                		$resource_detail = json_decode($business_detail);
	                		$order['machineroom_id'] = $resource_detail->machineroom_id;
							$order['machineroom_name'] = $resource_detail->machineroom_name;
	                		break;
	                }
	                $order['machineroom_name'] = DB::table('idc_machineroom')->where(['id'=>$order['machineroom_id']])->value('machine_room_name');
	                array_push($renew_order,$order);
				}
				 
			}
			
		}
		//自动生成一串编码，作为session的键，防止前面覆盖后面的
		$id = mt_rand(10000,20000);
		$type = mt_rand(11,20);
		$order_sn = 'TRZ'.$this->ordersn($id,$type);
		session([$order_sn=>$renew_order]);
		$return['data'] = $order_sn;
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
        // $order_sn = mt_rand(4, 6) . date("Ymd", time()) . substr(time(), 6, 4) . mt_rand(1, 3).'1';
        // $time = bcadd(time(),$resource_id,0);
        // $order_sn = mt_rand(4,6).date('YmdHis').$time.mt_rand(10,99).'2'.$resource_type;
        $time = bcadd(time(),$resource_id,0);
        $order_sn = mt_rand(4, 6) . date("Ymd", time()) . substr($time, 6, 4) . $resource_id .mt_rand(1, 3).'2';
        $order = DB::table('tz_orders')->where('order_sn',$order_sn)->select('order_sn','machine_sn')->first();
        $session = session()->has('TRZ'.$order_sn);
        if(!empty($order)){
            $this->ordersn();
        }
        if($session == true){
        	$this->ordersn();
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
			$return['msg']  = '无法获取需要支付的续费信息';
			return $return;
		}
		$renew = session($pay_key['pay_key']);//获取续费订单数据
		// dd($renew);
		if(empty($renew)){
			$return['data'] = $renew;
			$return['code'] = 0;
			$return['msg']  = '无对应续费信息，请确认无误后操作';
			return $return;
		}
		$client_id = $renew['client_id'];
		unset($renew['client_id']);
		if($client_id != Auth::user()->id){
			$return['data'] = $pay_key['pay_key'];
			$return['code'] = 0;
			$return['msg']  = '此续费订单不是你的,请确认';
			return $return;
		}
		DB::beginTransaction();
		$serial_number = '';
		foreach($renew as $renew_key => $renew_value){
			$order = DB::table('tz_orders')->where(['order_sn'=>$renew_value['order_number']])->select('id','order_sn','business_sn','machine_sn','duration')->first();//查找对应的订单数据
			if(empty($order)){//当无法找到对应的订单数据
				DB::rollBack();
				$return['data'] = $pay_key['pay_key'];
				$return['code'] = 0;
				$return['msg']  = '该资源不存在无法进行续费，请确认!';
				return $return;
			}
			if($renew_value['resource_type'] < 4){//当业务类型是租用主机/托管主机/租用机柜时需进一步对本身的业务数据的到期时间进行更新
				$business = DB::table('tz_business')->where(['business_number'=>$order->business_sn])->select('id','machine_number','length')->first();
				if(empty($business)){//未找到对应的业务数据
					DB::rollBack();
					$return['data'] = $pay_key['pay_key'];
					$return['code'] = 0;
					$return['msg']  = '该业务资源不存在无法进行续费，请确认!';
					return $return;
				}
				$length = bcadd($renew_value['duration'],$business->length);//更新累计时长
				$update_business = DB::table('tz_business')->where(['business_number'=>$order->business_sn])->update(['length'=>$length,'endding_time'=>$renew_value['end_time']]);
				if($update_business == 0){//更新业务到期时间和累计时长失败
					DB::rollBack();
					$return['data'] = $pay_key['pay_key'];
					$return['code'] = 0;
					$return['msg']  = '该业务资源续费失败，请确认!';
					return $return;
				}
			}
			$duration = bcadd($renew_value['duration'],$order->duration);//更新累计时长
			$pay_time = date('Y-m-d H:i:s',time());//更新支付时间
			$update_order = DB::table('tz_orders')->where(['order_sn'=>$renew_value['order_number']])->update(['duration'=>$duration,'end_time'=>$renew_value['end_time'],'pay_time'=>$pay_time]); 
			if($update_order == 0){//更新累计时长，到期时间，支付时间失败
				DB::rollBack();
				$return['data'] = $pay_key['pay_key'];
				$return['code'] = 0;
				$return['msg']  = '该资源续费失败，请确认!';
				return $return;
			}
			switch ($renew_value['resource_type']) {
				case 1:
					$machine = [];
					$machine['business_end'] = $renew_value['end_time'];
					//如果是租用机器的，在续费支付成功时，将业务编号和到期时间及资源状态进行更新
					$machine['own_business'] = $order->business_sn;
					$machine['used_status'] = 1;
					$where = ['own_business'=>$order->business_sn,'machine_num'=>$order->machine_sn];
					$result = DB::table('idc_machine')->where($where)->update($machine);
					break;
				case 2:
					$machine = [];
					$machine['business_end'] = $renew_value['end_time'];
					//如果是托管机器的，在续费支付成功时，将业务编号和到期时间及资源状态进行更新
					$machine['own_business'] = $order->business_sn;
					$machine['used_status'] = 1;
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
                        $return['data'] = $pay_key['pay_key'];
                        $return['code'] = 0;
                        $return['msg'] = '资源续费失败,请确认您此前购买过该机柜';
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
			if($result==0) {
                DB::rollBack();
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '资源续费失败!!';
                return $return;
            }
   			
   			$money = DB::table('tz_users')->where(['id'=>Auth::user()->id])->value('money');//获取客户的余额
			$total = bcmul($renew_value['price'],$renew_value['duration'],2);//计算需要支付的金额
			if(bccomp($money,$total,2) < 0){//当余额小于需支付的金额时为-1，小于0，无法进行续费
				$return['data'] = $pay_key['pay_key'];
				$return['code'] = 0;
				$return['msg']  = '余额不足，无法进行支付，续费失败，请充值后再续费';
				return $return;
			}
			$over_money = bcsub($money,$total,2);//进行余额扣除
			if($total != 0.00){
				$users = DB::table('tz_users')->where(['id'=>Auth::user()->id])->update(['money'=>$over_money]);//更新余额到对应的客户
				if($users == 0){//更新客户余额失败
					$return['data'] = $pay_key['pay_key'];
					$return['code'] = 0;
					$return['msg']  = '支付失败，续费失败';
					return $return;
				}
			}
			$pay_info = [
				'serial_number'=>$this->serialNumber($renew_value['id']),
				'order_id'=>$order->id,
				'business_id'=>$renew_value['business_id'],
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
				'flow_type'=>2
			];
			$serial = DB::table('tz_orders_flow')->insert($pay_info);
			if($serial == 0){
				DB::rollBack();
                $return['data'] = $pay_key['pay_key'];
                $return['code'] = 0;
                $return['msg'] = '资源续费扣除失败!!!';
                return $return;
			}
			$business_sn  = $order->business_sn;
   			
		}//foreach
		DB::commit();
		session()->forget($pay_key['pay_key']);
		return ['data'=>$business_sn,'code'=>1,'msg'=>'资源续费成功,请及时确认信息'];
	}

	/**
	 * 生成支付流水号
	 * @return [type] [description]
	 */
	public function serialNumber($id){
		$time = bcadd(time(),$id,0);
		$serial_number = 'tz_'.chr(mt_rand(97,122)).$time.mt_rand(51,99).'_'.Auth::user()->id;
		if(empty($serial_number)){
   			$this->serialNumber();
   		}
		$serial = DB::table('tz_orders_flow')->where(['serial_number'=>$serial_number])->select('id','business_number')->first();
		if(!empty($serial)){
			$this->serialNumber();
		} else {
			return $serial_number;
		}
	}

	/**
	 * 客户查看支付流水
	 * @param  
	 * @return array        返回相关的数据信息和提示状态及信息
	 */
	public function flows(){
		$result = DB::table('tz_orders_flow as flow')
					->where(['flow.customer_id'=>Auth::user()->id])
					->select('flow.id as flow_id','flow.business_number','flow.serial_number','flow.payable_money','flow.actual_payment','flow.preferential_amount','flow.pay_time','flow.before_money','flow.after_money','flow.created_at','flow.flow_type')
					->get();
		if(!empty($result)){
			foreach($result as $key=>$value){
				$flow_type = [1=>'新购',2=>'续费'];
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

}
