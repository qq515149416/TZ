<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Admin\Models\Idc\Ips;
use App\Admin\Models\Idc\Cpu;
use App\Admin\Models\Idc\Harddisk;
use App\Admin\Models\Idc\Memory;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Session;
/**
 * 后台订单模型
 */
class OrdersModel extends Model
{
	use SoftDeletes;
	protected $table = 'tz_orders';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

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

	/**
	 * 财务人员和管理人员查看订单
	 * @param  array $where 订单的状态
	 * @return array        返回相关的数据信息和提示状态及信息
	 */
	//['id','order_sn','customer_name','business_sn','business_name','before_money','after_money','resource_type','order_type','resource','price','duration','payable_money','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at']
	public function financeOrders($where){
		$result = DB::table('tz_orders')
					->leftJoin('tz_orders_flow','tz_orders.serial_number','=','tz_orders_flow.serial_number')
					->where($where)
                    ->whereNull('tz_orders.deleted_at')
					->orderBy('tz_orders.created_at','desc')
					->select('tz_orders.id','tz_orders.order_sn','tz_orders.customer_name','tz_orders.business_sn','tz_orders.business_name','tz_orders.resource_type','tz_orders.order_type','tz_orders.resource','tz_orders.price','tz_orders.duration','tz_orders.payable_money','tz_orders.end_time','tz_orders.serial_number','tz_orders.pay_time','tz_orders.order_status','tz_orders.order_note','tz_orders.created_at','tz_orders_flow.before_money','tz_orders_flow.after_money')
					->get();
		//$this->where($where)
					//->get(['id','order_sn','customer_name','business_sn','business_name','resource_type','order_type','resource','price','duration','payable_money','end_time','serial_number','pay_time','order_status','order_note','created_at']);
		// 'before_money','after_money','pay_type','pay_price',
		if(!empty($result)){
			$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP'];
			$order_type = [1=>'新购',2=>'续费'];
			$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成'];
			foreach($result as $okey=>$ovalue){
				$ovalue->type = $ovalue->resource_type;
				$ovalue->resource_type = $resource_type[$ovalue->resource_type];
				$ovalue->order_type = $order_type[$ovalue->order_type];
				$ovalue->order_status = $order_status[$ovalue->order_status];
			}
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '订单获取成功';
		} else {
			$return['data'] = '暂无订单';
			$return['code'] = 0;
			$return['msg'] = '暂无对应订单';
		}

		return $return;
	}

	/**
	 * 业务员和管理人员通过业务查看订单
	 * @param  array $where 订单的状态
	 * @return array        返回相关的数据信息和提示状态及信息
	 */
	public function clerkOrders($where){
		// ['tz_orders.business_sn'=>$where['business_sn'],'tz_orders.resource_type'=>$where['resource_type']]
		$result = DB::table('tz_orders')
					->leftJoin('tz_orders_flow','tz_orders.serial_number','=','tz_orders_flow.serial_number')
					->where($where)
                    ->whereNull('tz_orders.deleted_at')
					->orderBy('tz_orders.created_at','desc')
					->select('tz_orders.id','tz_orders.order_sn','tz_orders.customer_name','tz_orders.business_sn','tz_orders.business_name','tz_orders.resource_type','tz_orders.order_type','tz_orders.resource','tz_orders.price','tz_orders.duration','tz_orders.payable_money','tz_orders.end_time','tz_orders.serial_number','tz_orders.pay_time','tz_orders.order_status','tz_orders.order_note','tz_orders.created_at','tz_orders_flow.before_money','tz_orders_flow.after_money')
					->get();

		if(!$result->isEmpty()){
			$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn'];
			$order_type = [1=>'新购',2=>'续费'];
			$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成'];
			foreach($result as $okey=>$ovalue){
				$ovalue->type = $ovalue->resource_type;
				$ovalue->resourcetype = $resource_type[$ovalue->resource_type];
				$ovalue->order_type = $order_type[$ovalue->order_type];
				$ovalue->order_status = $order_status[$ovalue->order_status];
			}
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '订单获取成功';
		} else {
			$return['data'] = '暂无订单';
			$return['code'] = 0;
			$return['msg'] = '暂无对应订单';
		}

		return $return;
	}

	/**
	 * 返回对应要增加的资源数据
	 * @param  array $resource_data 资源类型
	 * @return array                返回对应的资源数据和状态及提示信息
	 */
	public function resource($resource_data){
		if(!$resource_data){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法获取资源数据';
			return $return;
		}
		switch ($resource_data['resource_type']) {
			case 4:
				$ips = new Ips();
				$result = $ips->selectIps($resource_data['machineroom'],$resource_data['company']);
				$return['data'] = $result;
				$return['code'] = 1;
				$return['msg'] = 'IP资源数据获取成功';
				break;
			case 5:
				$cpu = new Cpu();
				$result = $cpu->selectCpu($resource_data['machineroom']);
				$return['data'] = $result;
				$return['code'] = 1;
				$return['msg'] = 'CPU资源数据获取成功';
				break;
			case 6:
				$harddisk = new Harddisk();
				$result = $harddisk->selectHarddisk($resource_data['machineroom']);
				$return['data'] = $result;
				$return['code'] = 1;
				$return['msg'] = '硬盘资源数据获取成功';
				break;
			case 7:
				$memory = new Memory();
				$result = $memory->selectMemory($resource_data['machineroom']);
				$return['data'] = $result;
				$return['code'] = 1;
				$return['msg'] = '内存资源数据获取成功';
				break;
			default:
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '无该资源数据';
				break;
		}

		return $return;

	}

	/**
	 * 增加资源生成订单数据
	 * @param  array $insert_data 部分要增加的数据
	 * @return array              返回相关的订单号及状态提示及信息
	 */
	public function insertResource($insert_data){
		if(!$insert_data){
			// 如果资源数据为空
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '资源无法增加！！';
			return $return;
		}
		//业务到期时间和资源到期时间比较
		$end_time = Carbon::parse('+'.$insert_data['duration'].' months')->toDateTimeString();
		$endding_time = DB::table('tz_business')->where('business_number',$insert_data['business_sn'])->value('endding_time');
		if($end_time > $endding_time){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '资源到期时间超业务到期时间，无法添加资源!';
			return $return;
		}
		$insert_data['end_time'] = $end_time;
		// 订单号的生成规则：前两位（4-6的随机数）+ 年月日（如:20180830） + 时间戳的后2位数 + 1-3随机数
		$order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(1,3);
		$insert_data['order_sn'] = $order_sn;
		if($insert_data['resource_type'] == 8){//带宽的时候生成专属的带宽序号
			$insert_data['machine_sn'] = 'BW'.date("Ymd",time()).substr(time(),8,2);
		} elseif($insert_data['resource_type'] == 9){//防护的时候生成专属的防护序号
			$insert_data['machine_sn'] = 'DEF'.date("Ymd",time()).substr(time(),8,2);
		}
		$insert_data['order_type'] = 1;
		$insert_data['payable_money'] = bcmul((string)$insert_data['price'],(string)$insert_data['duration'],2);//计算价格
		$sales_id = Admin::user()->id;
		$insert_data['business_id'] = $sales_id;
		$insert_data['business_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
		// $insert_data['month'] = (int)date('Ym',time());
		$insert_data['created_at'] = Carbon::now()->toDateTimeString();
		DB::beginTransaction();//开启事务处理
		$row = DB::table('tz_orders')->insert($insert_data);
		if($row == false){
			// 资源订单生成失败
			DB::rollBack();
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '资源增加失败';
			return $return;
		}
		// 'business_sn','customer_id','customer_name','resource_type','machine_sn','resource','price','duration'
		if($insert_data['price'] == '0.00'){
			$order_flow['serial_number'] = 'tz_'.time().'_'.$insert_data['customer_id'];
			$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn'];
			$order_flow['subject'] = '赠送'.$resource_type[$insert_data['resource_type']];
			$order_flow['customer_id'] = $insert_data['customer_id'];
			$order_flow['business_id'] = Admin::user()->id;
			$order_flow['payable_money'] = $insert_data['price'];
			$order_flow['actual_payment'] = $insert_data['price'];
			$order_flow['preferential_amount'] = '0.00';
			$order_flow['pay_status'] = 1;
			$order_flow['pay_time'] = date('Y-m-d H:i:s',time());
			$money = DB::table('tz_users')->where(['id'=>$insert_data['customer_id']])->value('money');
			$order_flow['before_money'] = $money;
			$order_flow['after_money'] = bcsub($money,$insert_data['price'],2);
			// $order_flow['month'] = (int)date('Ym',time());
			$order_flow['created_at'] = date('Y-m-d H:i:s',time());
			$flow_row = DB::table('tz_orders_flow')->insert($order_flow);
			if($flow_row == 0){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '资源增加失败';
			}

		}
		$machine['business_end'] = $insert_data['end_time'];
		switch ($insert_data['resource_type']) {
			case 4:
				//更新IP表的所属业务编号，资源状态和到期时间
				$machine['own_business'] = $insert_data['business_sn'];
				$machine['ip_status'] = 1;
				$result = DB::table('idc_ips')->where('ip',$insert_data['machine_sn'])->update($machine);
				break;
			case 5:
				//更新CPU表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $insert_data['business_sn'];
				$machine['cpu_used'] = 1;
				$result = DB::table('idc_cpu')->where('cpu_number',$insert_data['machine_sn'])->update($machine);
				break;
			case 6:
			   //更新硬盘表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $insert_data['business_sn'];
				$machine['harddisk_used'] = 1;
				$result = DB::table('idc_harddisk')->where('harddisk_number',$insert_data['machine_sn'])->update($machine);
				break;
			case 7:
				//更新内存表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $insert_data['business_sn'];
				$machine['memory_used'] = 1;
				$result = DB::table('idc_memory')->where('memory_number',$insert_data['machine_sn'])->update($machine);
				break;
			default:
				$result = 1;
				break;
		}
		if($result != 0){
			//所对应资源表的业务编号和到期时间，状态修改成功后进行事务提交
			DB::commit();
			$return['data'] = $order_sn;
			$return['code'] = 1;
			$return['msg'] = '资源增加成功，请提醒客户及时支付，订单号:'.$order_sn;
		} else {
			DB::rollBack();
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '资源增加失败';
		}
		return $return;
	}



	/**
	 * 删除订单
	 * @param  [type] $delete_id [description]
	 * @return [type]            [description]
	 */
	public function deleteOrders($delete_id){
		// 根据订单id查找对应的订单和关联的业务编号
		$delete_data = DB::table('tz_orders')
						->join('tz_business','tz_orders.business_sn','=','tz_business.business_number')
						->where('tz_orders.id',$delete_id['delete_id'])
						->whereNull('tz_orders.deleted_at')
						->select('tz_business.business_number','tz_business.endding_time','tz_orders.order_sn','tz_orders.machine_sn','tz_orders.order_type','tz_orders.end_time','tz_orders.order_status','tz_orders.resource_type','tz_orders.duration')
						->first();
		// 不存在需要删除的数据，直接返回
		if(!$delete_data){
			$return['code'] = 0;
			$return['msg'] = '无对应的订单数据!';
			return $return;
		}
        if($delete_data->order_status == 5){
            $delete_row = $this->where(['id'=>$delete_id['delete_id']])->delete();
            if($delete_row != false){
                $return['code'] = 1;
                $return['msg'] = '删除订单记录成功!';
            } else {
                $return['code'] = 0;
                $return['msg'] = '删除订单记录失败!';
            }
            return $return;
        } else {
            DB::beginTransaction();//开启事务处理
            if($delete_data->order_status == 0){//当订单为未支付的时候删除同时需要对其相关的业务/对应的资源信息进行更新
                switch ($delete_data->resource_type) {//当资源类型为租用主机/托管主机/租用机柜时，对业务的到期时间进行更改
                    case 1://租用机器
                        $end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
                        $business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update(['endding_time'=>$end_time]);
                        if($business == 0){//更新业务到期时间失败
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
                            return $return;
                        }
                        $row = DB::table('idc_machine')->where(['machine_num'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number,'business_type'=>1])->update(['own_business'=>$delete_data->business_number,'business_end'=>$end_time]); 
                        if($row == 0){
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
                            return $return;
                        }
                        break;
                    case 2://托管机器
                        $end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
                        $business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update(['endding_time'=>$end_time]);
                        if($business == 0){//更新业务到期时间失败
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
                            return $return;
                        }
                        $row = DB::table('idc_machine')->where(['machine_num'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number,'business_type'=>2])->update(['own_business'=>$delete_data->business_number,'business_end'=>$end_time]); 
                        if($row == 0){
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
                            return $return;
                        }
                        break;
                    case 3://租用机柜
                        $end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
                        $business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update(['endding_time'=>$end_time]);
                        if($business == 0){//更新业务到期时间失败
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
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
                                $return['msg'] = '删除失败!';
                                return $return;
                            }
                            $ip['own_business'] = $delete_data->business_number;
                            $ip['business_end'] = empty($end_time)?Null:$end_time->end_time;
                        }
                        
                        $row = DB::table('idc_ips')->where(['ip'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number])->update($ip);
                        if($row == 0){//更新业务到期时间失败
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
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
                                $return['msg'] = '删除失败!';
                                return $return;
                            }
                            $cpu['service_num'] = $delete_data->business_number;
                            $cpu['business_end'] = empty($end_time)?Null:$end_time->end_time;
                        }
                        
                        $row = DB::table('idc_cpu')->where(['cpu_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($cpu);
                        if($row == 0){//更新业务到期时间失败
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
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
                                $return['msg'] = '删除失败!';
                                return $return;
                            }
                            $harddisk['service_num'] = $delete_data->business_number;
                            $harddisk['business_end'] = empty($end_time)?Null:$end_time->end_time;
                        }
                        
                        $row = DB::table('idc_harddisk')->where(['harddisk_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($harddisk);
                        if($row == 0){//更新业务到期时间失败
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
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
                                $return['msg'] = '删除失败!';
                                return $return;
                            }
                            $memory['service_num'] = $delete_data->business_number;
                            $memory['business_end'] = empty($end_time)?Null:$end_time->end_time;
                        }
                        
                        $row = DB::table('idc_memory')->where(['memory_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($memory);
                        if($row == 0){//更新业务到期时间失败
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '删除失败!';
                            return $return;
                        }
                        break;
                    default:
                        break;
                }
            }
            //删除对应业务数据
            $result = DB::table('tz_orders')->where(['id'=>$delete_id['delete_id']])->update(['order_status'=>5]);
            if($result == 0){
                DB::rollBack();
                $return['code'] = 0;
                $return['msg'] = '删除失败!';
                return $return;
            }
            // 删除成功返回
            DB::commit();
            $return['msg'] = '删除数据成功,关联业务号为:'.$delete_data->business_number;
            $return['code'] = 1;
            return $return;
        }	
	}

	/**
	 * 查找某一资源在某一业务下的最新的到期时间（本身除外）
	 * @param  [type] $exclude_order 要排除的资源订单（即要删除的订单）
	 * @param  [type] $resource_sn   要查找的资源
	 * @param  [type] $business      要查找的业务
	 * @return [type]                返回到期时间
	 */
	public function findResource($exclude_order,$resource_sn,$business){
		$end = $this->where(['business_sn'=>$business,'machine_sn'=>$resource_sn,'order_status'=>3])->where('order_sn','<>',$exclude_order)->orderBy('end_time','desc')->select('end_time','order_sn')->first();
		return $end;
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
			$return['msg']  = '无法获取该业务下的所有资源信息';
			return $return;
		}
		$all = $this->where($business)->where('price','>','0.00')->where('resource_type','>',3)->orderBy('end_time','desc')->get(['order_sn','resource_type','machine_sn','resource','price','end_time'])->groupBy('machine_sn')->toArray();
		$all_keys = array_keys($all);//获取分组后的资源编号
		foreach($all_keys as $key=>$value){
			$business['machine_sn'] = $value;
			$resource[$key] = $this->where($business)->where('order_status','<',3)->orderBy('end_time','desc')->select('order_sn','resource_type','machine_sn','resource','price','end_time','order_status')->first();
		}
		// dd($resource);
		if(!empty($resource)){
			foreach($resource as $key=>$value){
				$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn','11'=>'高防IP'];
				$resource[$key]['resourcetype'] = $resource_type[$value['resource_type']];
			}
			$orders = ['IP'=>$this->filter($resource,4),'cpu'=>$this->filter($resource,5),'harddisk'=>$this->filter($resource,6),'memory'=>$this->filter($resource,7),'bandwidth'=>$this->filter($resource,8),'protected'=>$this->filter($resource,9),'cdn'=>$this->filter($resource,10)];
			$return['data'] = $orders;
			$return['code'] = 1;
			$return['msg']  = '该业务下的其他资源信息获取成功';
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']  = '该业务下暂无其他资源信息';
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
			$return['msg']  = '无法进行续费,请确认后重新操作';
			return $return;
		}
		$order_str = '';//用于记录创建的续费订单的订单号
		$renew_order = [];//用于存储新增的订单的id，用于存储进session，方便后续调用订单
		DB::beginTransaction();//开启事务处理
		if(isset($renew['business_number'])){//传递了业务编号的进行业务查找和续费
			$business_where = [
				'business_number'=>$renew['business_number'],
			];
			$business = DB::table('tz_business')->where($business_where)->select('business_number','business_type','client_id','client_name','business_type','machine_number','endding_time','length','money','business_status','remove_status')->first();
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
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg']  = '该业务'.$business_status[$business->business_status].'无法进行续费,业务可能已到期未续费下架';
                return $return;
            }
			//续费订单号的生成规则：前两位（4-6的随机数）+ 年月日 + 时间戳的后2位数 + 4-6的随机数
			$order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(4,6);//续费订单号
			$order['order_sn'] = $order_sn;
			//对业务进行到期时间的更新
			$endding_time = Carbon::parse($business->endding_time)->modify('+'.$renew['length'].' months')->toDateTimeString();
			// 对业务的累计时长进行更新
			$length = bcadd($business->length,$renew['length'],0);
			$order['end_time'] = $endding_time;//订单到期时间
			$order['duration'] = $renew['length'];//订单时长
			$order['business_sn'] = $renew['business_number'];//订单关联业务
			$order['customer_id'] = $business->client_id;//订单关联客户
			$order['customer_name'] = $business->client_name;
			$order['business_id'] = Admin::user()->id;//订单绑定业务员
			$order['business_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
			$order['resource_type'] = $business->business_type;//资源类型
			$order['order_type'] = 2;//订单类型为续费
			$order['machine_sn'] = $business->machine_number;//订单机器编号
			$order['resource'] = $business->machine_number;//订单机器详情
			$order['price'] = $business->money;//订单单价
			$order['payable_money'] = bcmul($business->money,$renew['length'],2);//订单应付金额
			$order['order_note'] = $renew['order_note'];//订单备注
			$order['order_status'] = 0;//订单状态为未支付
			// $order['month'] = date('Ym',time());//订单创建月份
			$order['created_at'] = date('Y-m-d H:i:s',time());//订单创建时间
			$business_order = DB::table('tz_orders')->insertGetId($order);

			if($business_order == 0){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '业务续费失败';
				return $return;
			}
			$business_row = DB::table('tz_business')->where($business_where)->update(['endding_time'=>$endding_time,'length'=>$length,'business_status'=>1]);
			if($business_row == 0){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '业务续费失败!';
				return $return;
			}

			switch ($order['resource_type']) {
				case 1:
					$machine = [];
					$machine['business_end'] = $order['end_time'];
					//如果是租用机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
					$machine['own_business'] = $order['business_sn'];
					$machine['used_status'] = 1;
					$where = ['own_business'=>$order['business_sn'],'machine_num'=>$order['machine_sn']];
					$result = DB::table('idc_machine')->where($where)->update($machine);
					break;
				case 2:
					$machine = [];
					$machine['business_end'] = $order['end_time'];
					//如果是托管机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
					$machine['own_business'] = $order['business_sn'];
					$machine['used_status'] = 1;
					$where = ['own_business'=>$order['business_sn'],'machine_num'=>$order['machine_sn']];
					$result = DB::table('idc_machine')->where($where)->update($machine);
					break;
				case 3:
					$machine = [];
					$machine['business_end'] = $order['end_time'];
					//如果是租用机柜的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
					$cabinet = DB::table('idc_cabinet')->where(['cabinet_id'=>$order['machine_sn']])->value('own_business');
					$business = strpos($cabinet,$order['business_sn']);
					if(!$business){
						DB::rollBack();
                        $return['data'] = '';
                        $return['code'] = 0;
                        $return['msg'] = '资源续费失败,请确认您此前购买过该机柜';
                        return $return;
					}
                    $result = 1;
					break;
			}
			if($result == 0){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '资源续费失败!!';
				return $return;
			}
			$order_str = $order['order_sn'].','.$order_str;
			array_push($renew_order,$business_order);
		}
		if(isset($renew['orders'])){
			foreach($renew['orders'] as $key=>$value){
                if($value != 0){
                    $order_where['order_sn'] = $value;
                    $order_result = $this->where($order_where)->select('business_sn','customer_id','customer_name','resource_type','machine_sn','resource','price','end_time','order_status')->first();
                    if($order_result->order_status < 1 || $order_result->order_status > 2){
                        $order_status = [0=>'待支付',1=>'支付',2=>'支付',3=>'续费过',4=>'到期',5=>'取消',6=>'申请退款',8=>'退款完成'];
                        DB::rollBack();
                        $return['data'] = '';
                        $return['code'] = 0;
                        $return['msg'] = '资源编号:'.$order_result->machine_sn.'的资源'.$order_result->resource.','.'无法续费,原因:'.$order_status[$order_result->order_status];
                        return $return;
                    }
                    //续费订单号的生成规则：前两位（4-6的随机数）+ 年月日 + 时间戳的后2位数 + 4-6的随机数
                    $order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(4,6);//续费订单号
                    $order['order_sn'] = $order_sn;
                    //到期时间
                    $end_time = Carbon::parse($order_result->end_time)->modify('+'.$renew['length'].' months')->toDateTimeString();
                    $order['end_time'] = $end_time;
                    $order['duration'] = $renew['length'];//订单时长
                    $order['business_sn'] = $order_result->business_sn;//订单关联业务
                    $order['customer_id'] = $order_result->customer_id;//订单关联客户
                    $order['customer_name'] = $order_result->customer_name;
                    $order['business_id'] = Admin::user()->id;//订单绑定业务员
                    $order['business_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
                    $order['resource_type'] = $order_result->resource_type;//资源类型
                    $order['order_type'] = 2;//订单类型为续费
                    $order['machine_sn'] = $order_result->machine_sn;//订单机器编号
                    $order['resource'] = $order_result->resource;//订单机器详情
                    $order['price'] = $order_result->price;//订单单价
                    $order['payable_money'] = bcmul($order_result->price,$renew['length'],2);//订单应付金额
                    $order['order_note'] = $renew['order_note'];//订单备注
                    $order['order_status'] = 0;//订单状态为未支付
                    // $order['month'] = date('Ym',time());//订单创建月份
                    $order['created_at'] = date('Y-m-d H:i:s',time());//订单创建时间
                    $business_order = DB::table('tz_orders')->insertGetId($order);

                    if($business_order == 0){
                        DB::rollBack();
                        $return['data'] = '';
                        $return['code'] = 0;
                        $return['msg'] = '业务续费失败!';
                        return $return;
                    }
                    $old_order = DB::table('tz_orders')->where($order_where)->update(['order_status'=>3]);
                    if($old_order == 0){
                        DB::rollBack();
                        $return['data'] = '';
                        $return['code'] = 0;
                        $return['msg'] = '业务续费失败!请重新操作';
                        return $return;
                    }

                    switch ($order['resource_type']) {
                        case 4:
                            $resource = [];
                            $resource['business_end'] = $order['end_time'];
                            //更新IP表的所属业务编号，资源状态和到期时间
                            $resource['own_business'] = $order['business_sn'];
                            $resource['ip_status'] = 1;
                            $where = ['own_business'=>$order['business_sn'],'ip'=>$order['machine_sn']];
                            $result = DB::table('idc_ips')->where($where)->update($resource);
                        break;
                        case 5:
                            $resource = [];
                            $resource['business_end'] = $order['end_time'];
                            //更新CPU表的所属业务编号，资源状态和到期时间
                            $resource['service_num'] = $order['business_sn'];
                            $resource['cpu_used'] = 1;
                            $where = ['service_num'=>$order['business_sn'],'cpu_number'=>$order['machine_sn']];
                            $result = DB::table('idc_cpu')->where($where)->update($resource);
                            break;
                        case 6:
                            $resource = [];
                            $resource['business_end'] = $order['end_time'];
                            //更新硬盘表的所属业务编号，资源状态和到期时间
                            $resource['service_num'] = $order['business_sn'];
                            $resource['harddisk_used'] = 1;
                            $where = ['service_num'=>$order['business_sn'],'harddisk_number'=>$order['machine_sn']];
                            $result = DB::table('idc_harddisk')->where($where)->update($resource);
                            break;
                        case 7:
                            $resource = [];
                            $resource['business_end'] = $order['end_time'];
                            //更新内存表的所属业务编号，资源状态和到期时间
                            $resource['service_num'] = $order['business_sn'];
                            $resource['memory_used'] = 1;
                            $where = ['service_num'=>$order['business_sn'],'memory_number'=>$order['machine_sn']];
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
                        $return['msg'] = '资源续费失败!!';
                        return $return;
                    }
                    $order_str = $order['order_sn'].','.$order_str;
                    array_push($renew_order,$business_order);
                    $business = DB::table('tz_business')->where(['business_number'=>$order_result->business_sn])->select('business_status')->first();
                    if($business->business_status == 2){//当业务的状态为付款使用时且续费资源成功，将业务状态修改为未付款使用，作为欠费标记，代表业务下有未付款的订单
                        $businessRow = DB::table('tz_business')->where(['business_number'=>$order_result->business_sn])->update(['business_status'=>1]);
                        if($businessRow == 0){
                            DB::rollBack();
                            $return['data'] = '';
                            $return['code'] = 0;
                            $return['msg'] = '资源续费失败!!';
                            return $return;
                        }
                    }
                }
				
			}
            
		}
		//所对应资源表的业务编号和到期时间，状态修改成功后进行事务提交
		Session::put([Admin::user()->id=>$renew_order]);
		Session::save();
		DB::commit();
		$return['data'] = $renew_order;
		$return['code'] = 1;
		$return['msg'] = '资源续费订单创建成功,订单号:'.rtrim($order_str,',');//为了不影响使用请及时支付,您的续费单号:'.$order_sn;
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
			$return['msg']  = '无法获取支付信息';
			return $return;
		}
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


	public function payOrderByBalance($business_number,$coupon_id){
		$return['data'] = '';
		$admin_user_id = Admin::user()->id;

		$unpaidOrder = $this
				->where('order_status',0)
				->where('business_sn',$business_number)
				->get()
				->toArray();
		if(count($unpaidOrder) == 0){
			$return['msg']  = '无此业务未付款订单';
			$return['code'] = 0;
			return $return;
		}

		$serial_number = 'tz_'.time().'_admin_'.$admin_user_id;
		$payable_money = '0.00';
		$pay_time = date("Y-m-d h:i:s");
		$order_id_arr = [];
		$idc_arr = array(1,2,3,4,5,6,7,8,9);
		$defenseip_arr = array(11);
		
		DB::beginTransaction();//开启事务处理

		for ($i=0; $i < count($unpaidOrder); $i++) {
			$business_id = DB::table('tz_users')->where('id',$unpaidOrder[$i]['customer_id'])->value('salesman_id');
			if($business_id != $admin_user_id){
				$return['msg']  = '该业务所属客户不属于您';
				$return['code'] = 0;
				return $return;
			}


			$checkCoupon = $this->checkCoupon($unpaidOrder[$i]['id'],$coupon_id);
			if($checkCoupon != true){
				$return['msg']  = '该优惠券不可用';
				$return['code'] = 0;
				return $return;
			}

			$processing = $this->paySuccess($unpaidOrder[$i]['id'],$pay_time);
			if($processing['code'] != 1){
				DB::rollBack();
				return $processing;
			}

			//更新订单内信息
			$updateInfo['serial_number'] = $serial_number;
			$updateInfo['order_status'] = 1;
			$updateInfo['pay_time'] = $pay_time;
			if(isset($processing['data']['end'])){
				$updateInfo['end_time'] = $processing['data']['end'];
			}
			//重新计算单一订单应付金额
			/*
			*如需添加单一商品优惠券,在此添加计算
			*/
			$updateInfo['payable_money'] = bcmul($unpaidOrder[$i]['price'],$unpaidOrder[$i]['duration'],2);

			//计算这次支付总共的应付金额
			$payable_money = bcadd($payable_money,$updateInfo['payable_money'],2);
			$business_id = $unpaidOrder[$i]['business_id'];

			$update = DB::table('tz_orders')->where('id',$unpaidOrder[$i]['id'])->update($updateInfo);
			if($update == 0){
				DB::rollBack();
				$return['msg'] = '更新支付状态失败';
				$return['code'] = 0;
				return $return;
			}
			$order_id_arr[] = $unpaidOrder[$i]['id'];

			if(in_array($unpaidOrder[$i]['resource_type'], $idc_arr)){
				$type = 1;
			} elseif(in_array($unpaidOrder[$i]['resource_type'], $defenseip_arr)){
				$type = 2;
			}else{
				$type = 3;
			}
		}

		switch ($type) {
			case '1':
				$customer_id = DB::table('tz_business')->where('business_number',$business_number)->value('client_id'); 
				break;
			case '2':
				$customer_id = DB::table('tz_defenseip_business')->where('business_number',$business_number)->value('user_id'); 
				break;
			default:
				$return['msg']  = '获取业务类型失败';
				$return['code'] = 0;
				return $return;
				break;
		}
		
		if($customer_id == null){
			$return['msg']  = '客户id获取失败';
			$return['code'] = 0;
			return $return;
		}
		//计算实际支付金额
		$actual_payment = $this->countCoupon($payable_money,$coupon_id);
		//优惠券抵扣了的金额
		$preferential_amount = bcsub($payable_money,$actual_payment,2);
		//获取余额
		$before_money = DB::table('tz_users')->where('id',$customer_id)->value('money');
		//计算扣除应付金额后余额
		$after_money = bcsub((string)$before_money,(string)$actual_payment,2);
		
		if( $after_money < 0 ){
			$return['msg']  = '余额不足,请充值';
			$return['code'] = 0;
			return $return;
		}

		$flow = [
			'serial_number'     => $serial_number,
			'order_id'      => json_encode($order_id_arr),
			'customer_id'       => $customer_id,
			'payable_money' => $payable_money,
			'actual_payment'    => $actual_payment,
			'preferential_amount'   => $preferential_amount,
			'coupon_id'     => $coupon_id,
			'created_at'        => date('Y-m-d H:i:s',time()),
			'business_id'       => $business_id,
			'before_money'      => $before_money,
			'after_money'       => $after_money,
			'pay_time'      => $pay_time,
			'business_number'	=> $business_number,
		];
		$creatFlow = DB::table('tz_orders_flow')->insert($flow);

		if($creatFlow == false){
			DB::rollBack();
			$return['msg'] = '创建支付流水失败';
			$return['code'] = 0;
			return $return;
		}

		// 订单支付成功后对客户的余额进行修改
		$payMoney = DB::table('tz_users')->where('id',$customer_id)->update(['money' => $after_money ]);
		if($payMoney == false){
			// 修改客户余额失败，进行事务回滚
			DB::rollBack();
			$return['msg']  = '扣除余额失败,支付失败';
			$return['code'] = 0;
			return $return;
		}
		DB::commit();
		$return['msg']  = '余额支付成功';
		$return['code'] = 1;

		return $return;
	}


	/**
	 * 预留的检测优惠券是否可用方法
	 * @param  $order_id[]      -订单id的数组; $coupon_id    -优惠券id
	 * @return true/false
	 */
	public function checkCoupon($order_id,$coupon_id){

		return true;

	}

	/**
	 * 预留的优惠券使用计算方法
	 * @param  $payable_money       -订单应付金额; $coupon_id -优惠券id
	 * @return true/false
	 */
	public function countCoupon($payable_money,$coupon_id){
		//if($coupon_id == 0){
			$youhuizhekou = '0.00';
		// }else{
		//  $youhuizhekou = '20.00';
		// }

		$actual_payment = bcsub($payable_money,$youhuizhekou,2);
		if($actual_payment < 0){
			$actual_payment = 0;
		}
		return $actual_payment;

	}

	/**
	*支付订单改状态方法
	**/
	protected function paySuccess($order_id,$pay_time){
		$return['data'] = '';
		$row = $this->find($order_id)->toArray();

		if($row['resource_type'] < 4) {
			// 资源类型如果是机柜/主机，查找对应的业务状态
			$business_status = DB::table('tz_business')->where('business_number',$row['business_sn'])->value('business_status');
			if($business_status > 0 && $business_status < 4 && $business_status != 2){
				// 业务状态是审核通过且是使用状态将状态修改为付款使用即2
				$business['business_status'] = 2;
				$businessUp = DB::table('tz_business')->where('business_number',$row['business_sn'])->update($business);
				if($businessUp == 0) {
					$return['msg']  = '更改资源使用状态失败,订单可能为正在付款使用中状态,支付失败';
					$return['code'] = 3;
					return $return;
				}
			}
		} elseif($row['resource_type'] == 11){
			//如果是高防IP
			if($row['order_type'] == 1){
				//如果是新购的高防IP
				$checkBusiness = DB::table('tz_defenseip_business')
					->where('business_number',$row['business_sn'])
					->first();
				//如果存在该业务
				if($checkBusiness != null){
					//如果该业务是试用
					if ($checkBusiness->status == 4 ) {
						$business = [
							'status'            => 1,
							'end_at'            => $row['end_time'],
						];
						$update_business = DB::table('tz_defenseip_business')
									->where('business_number',$row['business_sn'])
									->update($business);

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
					$package = DB::table('tz_defenseip_package')
					->select(['site','protection_value','price'])
					->where('id',$row['machine_sn'])
					->first();
					if($package == null){
						$return['msg']  = '该套餐已下架!';
						$return['code'] = 2;
						return $return;
					}
					$sale_ip = DB::table('tz_defenseip_store')
							->select(['id','ip'])
							->where('site',$package->site)
							->where('protection_value',$package->protection_value)
							->where('status',0)
							->first();
					if($sale_ip == null){
						$return['msg']  = '该套餐IP库存不足!';
						$return['code'] = 2;
						return $return;
					}
					$update_ip =  DB::table('tz_defenseip_store')->where('id',$sale_ip->id)->update(['status' => 1]);
					if($update_ip == 0){
						$return['msg']  = '更新ip使用状态失败!';
						$return['code'] = 3;
						return $return;
					}
					$end = Carbon::now()->addMonth($row['duration'])->toDateTimeString();

					$business = [
						'business_number'   => $row['business_sn'],
						'user_id'       => $row['customer_id'],
						'package_id'        => $row['machine_sn'],
						'ip_id'         => $sale_ip->id,
						'price'         => $package->price,
						'status'            => 1,
						'end_at'            => $end,
						'created_at'        => date("Y-m-d H:i:s"),
					];
					$build_business = DB::table('tz_defenseip_business')->insert($business);

					if($build_business != true){
						$return['msg']  = '创建高防ip业务失败!';
						$return['code'] = 3;
						return $return;
					}
					$relevance = [
						'type'		=> 2,
						'business_id'	=> $business['business_number'],
					];
					$build_relevance = DB::table('tz_business_relevance')->insert($relevance);
					if($build_relevance != true){
						$return['msg'] 	= '创建高防ip业务关联失败!';
						$return['code']	= 3;
						return $return;
					}
					$update_order = DB::table('tz_orders')
						->where('id',$row['id'])
						->update([
							'resource'  => $sale_ip->ip,
							]);
					if($update_order == 0){
						$return['msg']  = '更新订单状态失败!';
						$return['code'] = 3;
						return $return;
					}
					$return['data'] = ['end' => $end];
				}
			}else{
				$business = DB::table('tz_defenseip_business')
						->where('business_number',$row['business_sn'])
						->first();
				//判断业务是否已下架
				if($business->status == 2||$business->status == 3)
				{
					$return['msg']  = '业务已下架,无法续费!';
					$return['code'] = 4;
					return $return;
				}

				$end = Carbon::parse($business->end_at)->addMonth($row['duration'])->toDateTimeString();
				$upEnd = DB::table('tz_defenseip_business')
						->where('business_number',$row['business_sn'])
						->update(['end_at'=>$end]);

				if($upEnd != 1){
					$return['msg']  = '更新业务结束时间失败!';
					$return['code'] = 3;
					return $return;
				}
				$return['data'] = ['end' => $end];
			}	
		}

		$return['msg'] = '更新成功!!';
		$return['code'] = 1;
		return $return;
	}

}
