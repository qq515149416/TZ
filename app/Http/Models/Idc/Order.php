<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 不知道啥2.0
// +----------------------------------------------------------------------
// | Description: 用户订单表模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Idc\Business;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算

class Order extends Model
{

	use SoftDeletes;

	protected $table = 'tz_orders'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['order_sn', 'business_sn','customer_id','before_money','after_money','business_id','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','refund_money','refund_time','refund_note','order_note','created_at','payable_money'];


	public function getList($user_id)
	{
		//获取该用户的订单
		$order = $this->where('customer_id',$user_id)->orderby('created_at','desc')->get(['id','order_sn', 'business_sn','before_money','after_money','business_id','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at','payable_money']);

		if(count($order) == 0){
			return false;
		}

		//转换状态
		$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn'];
		$order_type = [ '1' => '新购' , '2' => '续费' ];
		$pay_type = [ '1' => '余额' , '2' => '支付宝' , '3' => '微信' , '4' => '其他'];
		$order_status = [ '0' => '待支付' , '1' => '已支付' , '2' => '已支付' , '3' => '订单完成' , '4' => '取消' , '5' => '申请退款' , '6' => '退款完成'];
		$info = $this->getName('*');
		$admin_name = [];
		foreach ($info as $k => $v) {
			$admin_name[$v->id] = $v->username;
		}
	
		foreach ($order as $key => $value) {
			$order[$key]['resource_type'] = $resource_type[$order[$key]['resource_type']];
			$order[$key]['order_type'] = $order_type[$order[$key]['order_type']];
			$order[$key]['pay_type'] = $pay_type[$order[$key]['pay_type']];
			$order[$key]['order_status'] = $order_status[$order[$key]['order_status']];
			$order[$key]['business_name']	= $admin_name[$order[$key]['business_id']];
		}

		return $order;
	}

	public function delOrder($user_id,$id){
		//获取模型
		$row = $this->find($id);
		$return['data']	= '';

		if($row == NULL){	//如果没有
			$return['msg'] 	= '无此订单';
			$return['code']	= 0;
			return $return;
		}
		$customer_id = $row->customer_id;

		if($user_id != $customer_id){		//如果订单的客户id跟登录者不同
			$return['msg'] 	= '只能删除自己的订单';
			$return['code']	= 0;
			return $return;
		}
		$res = $row->delete();

		if(!$res){
			$return['msg'] 	= '删除失败';
			$return['code']	= 0;
		}else{
			$return['msg'] 	= '删除成功';
			$return['code']	= 1;
		}
		return $return;
	}

	/**
	 * 客户自主对订单进行支付
	 * @param  int $user_id 客户的id
	 * @param  int $id      订单的id
	 * @return array          返回相关的状态提示及信息
	 */
	public function payOrder($user_id,$id){
		
		$serial_number = $this->createNum($user_id.$id); //支付流水号
		$row = $this->find($id);
		$return['data']	= '';
		// 是否存在此订单
		if($row == NULL){
				$return['msg'] 	= '无此订单';
				$return['code']	= 0;
				return $return;
		}
		// 是否是客户自己的订单
		$customer_id = $row->customer_id;
		if($user_id != $customer_id){	
			$return['msg'] 	= '只能支付自己的订单';
			$return['code']	= 0;
			return $return;
		}
		// 订单的状态是否为未支付
		$order_status = $row->order_status;
		if( $order_status != 0 ){
			$return['msg'] 	= '订单已支付或已取消';
			$return['code']	= 0;
			return $return;
		}
		//获取余额
		$before_money = $this->getMoney($user_id)->money;
		$payable_money = bcmul( (string)$row->price , (string)$row->duration , 2 );
		$after_money = bcsub((string)$before_money,(string)$payable_money,2);
		if( $after_money < 0 ){
			$return['msg'] 	= '余额不足,请充值';
			$return['code']	= 0;
			return $return;
		}
		$pay_time = date("Y-m-d h:i:s");
		DB::beginTransaction();
		$row->before_money 	= $before_money;
		$row->after_money 	= $after_money;
		$row->pay_type		= 1;
		$row->pay_price	= $payable_money;
		$row->pay_time		= $pay_time;
		$row->order_status	= 1;
		$row->serial_number	= $serial_number;
		$row->payable_money	= $payable_money;
		$res = $row->save();			
		if(!$res){
			// 
			DB::rollBack();
			$return['msg'] 	= '支付失败';
			$return['code']	= 0;
			return $return;
		} else {
			// 订单支付成功后对客户的余额进行修改
			$pay_money = DB::table('tz_users')->where('id',$user_id)->update(['money' => $after_money ]);
			if($pay_money != 0){
				// 客户余额修改成功
				if($row->resource_type < 4) {
					// 资源类型如果是机柜/主机，查找对应的业务状态
					$business_status = DB::table('tz_business')->where('business_number',$row->business_sn)->value('business_status');
					if($business_status > 0 && $business_status < 4){
						// 业务状态是审核通过且是使用状态将状态修改为付款使用即2
						$business['business_status'] = 2;
						$business = DB::table('tz_business')->where('business_number',$row->business_sn)->update($business);
						if($business != 0) {
							// 修改使用状态成功，事务提交
							DB::commit();
						} else {
							DB::rollBack();
							$return['msg'] 	= '支付失败';
							$return['code']	= 0;
							return $return;
						}
					} else {
						// 业务状态为使用状态之外的直接事务提交，无须修改业务状态
						DB::commit();
					}
				} else {
					// 资源类型除机柜/主机外的直接进行事务提交
					DB::commit();
				}
				$return['data'] = $row;
				$return['code'] = 1;
				$return['msg'] = '支付成功!!';	
				
			} else {
				// 修改客户余额失败，进行事务回滚
				DB::rollBack()
				$return['msg'] 	= '支付失败';
				$return['code']	= 0;	
			}
		}	 		
		return $return;
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


	public function createNum($i){
		$f=date('Ym');
		$i+=1;
		if($i<10){
			return $f.'000'.$i;
		}else if($i<100){
			return $f.'00'.$i;
		}else if($i<1000){
			return $f.'0'.$i;
		}else{
			return $f.$i;
		}
	}

	/**
	 * 客户续费主机及机柜产生订单
	 * @param  array $renew 续费订单所需要的数据
	 * @return array        返回操作后的状态提示及信息
	 */
	public function renewOrders($renew){
		if($renew){
			//续费订单号的生成规则：前两位（11-40的随机数）+ 年月日 + 时间戳的后5位数 + 2（续费） 
			$order_sn = mt_rand(11,40).date('Ymd',time()).substr(time(),5,5).2;//续费订单号
			$order['order_sn'] = (int)$order_sn;
			$order['business_sn'] = $renew['business_number'];//续费的业务编号
			$order['customer_id'] = $renew['client_id'];//客户id
			$order['customer_name'] = $renew['client_name'];//客户
			$order['business_id'] = $renew['sales_id'];//业务员id
			$order['business_name'] = $renew['sales_name'];//业务员
			$order['resource_type'] = $renew['business_type'];//资源类型
			$order['order_type'] = $renew['order_type'];//订单类型
			$order['machine_sn'] = $renew['machine_number'];//机器编号
			$order['resource'] = $renew['machine_number'];//机器机柜等存储编号，其他资源存储对应数据
			$order['price'] = $renew['money'];//续费单价
			$order['duration'] = $renew['length'];//续费时长
			$order['payable_money'] = bcmul((string)$order['price'],(string)$order['duration'],2);//应付金额
			$order['order_status'] = 0;//续费订单状态
			$order['order_note'] = $renew['order_note'];//续费备注
			$end = (array)$this->endBusiness($renew['id']);//查找原来业务的到期时间
			$endding_time = Carbon::parse($end['endding_time'])->modify('+'.$order['duration'].' months')->toDateTimeString();//在原到期时间基础上增加续费时长
			$order['end_time'] = $endding_time;
			$order['month'] = (int)date('Ym',time());
			DB::beginTransaction();//开启事务处理
			$order_row = DB::table('tz_orders')->insert($order);//生成续费订单
			if($order_row != 0) {
				// 续费订单生成成功，继续对业务的到期时间和累计时长修改
				$business['length'] = (int)bcadd($end['length'],$renew['length'],0);
				$business['endding_time'] = $endding_time;
				$business['business_status'] = 3;
				$business_row = DB::table('tz_business')->where('id',$renew['id'])->update($business);
				if($business_row != 0){
					if($order['resource_type'] == 1 || $order['resource_type'] == 2){
                            // 如果是租用/托管机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
                            $machine['own_business'] = $order['business_sn'];
                            $machine['business_end'] = $order['end_time'];
                            $machine['used_status'] = 1;
                            $row = DB::table('idc_machine')->where('machine_num',$order['machine_sn'])->update($machine);
                        } else {
                            // 如果是租用机柜的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
                            $machine['own_business'] = $order['business_sn'];
                            $machine['business_end'] = $order['end_time'];
                            $machine['use_state'] = 1;
                            $row = DB::table('idc_cabinet')->where('cabinet_id',$order['machine_sn'])->update($machine);
                        }
                        if($row != 0){
                            // 订单生成成功且对应资源的业务编号及状态修改成功，事务进行提交处理
                            DB::commit();
							$return['code'] = 1;
							$return['msg'] = '续费订单创建成功,为了不影响使用请及时支付,您的续费单号:'.$order_sn;
                        } else {
                            DB::rollBack();
							$return['code'] = 0;
							$return['msg'] = '续费失败，请重新操作';
                        }
					
				} else {
					DB::rollBack();
					$return['code'] = 0;
					$return['msg'] = '续费失败，请重新操作';
				}
			} else {
				DB::rollBack();
				$return['code'] = 0;
				$return['msg'] = '续费失败，请重新操作';
			}
		} else {
			$return['code'] = 0;
			$return['msg'] = '无法进行续费';
		}
		return $return;
	}


	/**
	 * 查询对应业务的到期时间，方便在续费时对资源的到期时间重新计算
	 * @param  int $id 业务单的id
	 * @return array     返回业务单的到期时间和累计时长
	 */
	public function endBusiness($id){
		$end_time = DB::table('tz_business')->find($id,['endding_time','length']);
		return $end_time;
	}

	/**
	 * 查找对应业务的增加的资源
	 * @param  array $where 业务编号和资源类型
	 * @return array        返回相关的资源数据和状态提示及信息
	 */
	public function resourceOrders($where){
		if($where){
			$resource_orders = $this->where($where)->get(['id','customer_id','customer_name','order_sn', 'business_sn','before_money','after_money','business_id','business_name','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at','payable_money']);
			if($resource_orders->isEmpty()){
				//转换状态
				$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn'];
				$order_type = [ '1' => '新购' , '2' => '续费' ];
				$pay_type = [ '1' => '余额' , '2' => '支付宝' , '3' => '微信' , '4' => '其他'];
				$order_status = [ '0' => '待支付' , '1' => '已支付' , '2' => '已支付' , '3' => '订单完成' , '4' => '取消' , '5' => '申请退款' , '6' => '退款完成'];
				foreach($resource_orders as $resource_key => $resource_value){
					$resource_orders[$resource_key]['resource_type'] = $resource_type[$resource_value['resource_type']];
					$resource_orders[$resource_key]['order_type'] = $order_type[$resource_value['order_type']];
					$resource_orders[$resource_key]['pay_type'] = $pay_type[$resource_value['pay_type']];
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

	/**
	 * 资源续费订单的创建
	 * @param  array $renew 需要续费的资源数据
	 * @return array        返回相关的数据信息状态及提示
	 */
	public function renewResource($renew){
		if($renew){
			//续费订单号的生成规则：前两位（11-40的随机数）+ 年月日 + 时间戳的后5位数 + 2（续费）
			$order_sn = mt_rand(11,40).date('Ymd',time()).substr(time(),5,5).2;//续费订单号
			$renew['order_sn'] = (int)$order_sn;
			$renew['payable_money'] = bcmul((string)$order['price'],(string)$order['duration'],2);//应付金额
			$renew['order_type'] = 2;
			DB::beginTransaction();
			$insert = DB::table('tz_orders')->insert($renew);//生成续费订单
			if($insert != 0){
				$machine['business_end'] = $renew['end_time'];

                if($renew['resource_type'] == 4){
                    //更新IP表的所属业务编号，资源状态和到期时间
                    $machine['own_business'] = $renew['business_sn'];
                    $machine['ip_status'] = 1;
                    $result = DB::table('idc_ips')->where('ip',$renew['machine_sn'])->update($machine);
                } elseif($renew['resource_type'] == 5){
                    //更新CPU表的所属业务编号，资源状态和到期时间
                    $machine['service_num'] = $renew['business_sn'];
                    $machine['cpu_used'] = 1;
                    $result = DB::table('idc_cpu')->where('cpu_number',$renew['machine_sn'])->update($machine);
                } elseif($renew['resource_type'] == 6){
                    //更新硬盘表的所属业务编号，资源状态和到期时间
                    $machine['service_num'] = $renew['business_sn'];
                    $machine['harddisk_used'] = 1;
                    $result = DB::table('idc_harddisk')->where('harddisk_number',$renew['machine_sn'])->update($machine);
                } elseif($renew['resource_type'] == 7){
                    //更新内存表的所属业务编号，资源状态和到期时间
                    $machine['service_num'] = $insert_data['business_sn'];
                    $machine['memory_used'] = 1;
                    $result = DB::table('idc_memory')->where('memory_number',$renew['machine_sn'])->update($machine);
                }
                if($result != 0){
                    //所对应资源表的业务编号和到期时间，状态修改成功后进行事务提交
                    DB::commit();
                    $return['data'] = $order_sn;
                    $return['code'] = 1;
					$return['msg'] = '资源续费订单创建成功,为了不影响使用请及时支付,您的续费单号:'.$order_sn;
                } else {
                    DB::rollBack();
                    $return['data'] = '';
                    $return['code'] = 0;
                    $return['msg'] = '资源续费失败';
                }
				
			} else {
				DB::rollBack();
				$return['code'] = 0;
				$return['msg'] = '资源续费失败，请重新操作';
			}
		} else {
			$return['code'] = 0;
			$return['msg'] = '无法对资源进行续费';
		}
		return $return;	
	}

	/**
     * 比较资源到期时间和业务到期时间
     * @param  array $time 资源时长和业务到期时间
     * @return array       资源到期时间和状态提示及信息
     */
    public function endTime($time){
        if($time){
        	$endding_time = DB::table('tz_business')->where('business_number',$time['business_sn'])->value('endding_time');
            $end_time = Carbon::parse('+'.$time['duration'].' months')->toDateTimeString();
            if($end_time < $endding_time){
                $return['data'] = $end_time;
                $return['code'] = 1;
                $return['msg'] = '资源到期时间在业务到期时间内';
            } else {
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '资源到期时间超业务到期时间';
            }
        } else {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '无法比较资源到期时间和业务到期时间';
        }
        return $return;
    }

}