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

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Customer\Business;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
use Illuminate\Support\Facades\Auth;

class Order extends Model
{

	use SoftDeletes;

	protected $table = 'tz_orders'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['order_sn', 'business_sn','customer_id','before_money','after_money','business_id','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','refund_money','refund_time','refund_note','order_note','created_at','payable_money'];


	public function getList($type)
	{	
		$user_id = Auth::user()->id;
		$type['customer_id'] = $user_id;
		//获取该用户的订单
		$order = $this->where($type)->orderby('created_at','desc')->get(['id','order_sn', 'business_sn','before_money','after_money','business_id','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at','payable_money']);

		if(count($order) == 0){
			return false;
		}

		//转换状态
		$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn'];
		$order_type = [ '1' => '新购' , '2' => '续费' ];
		$pay_type = [ '1' => '余额' , '2' => '支付宝' , '3' => '微信' , '4' => '其他'];
		$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成'];
		$info = $this->getName('*');
		$admin_name = [];
		foreach ($info as $k => $v) {
			$admin_name[$v->id] = $v->username;
		}
	
		foreach ($order as $key => $value) {
			$order[$key]['type'] = $order[$key]['resource_type'];
			$order[$key]['resource_type'] = $resource_type[$order[$key]['resource_type']];
			$order[$key]['order_type'] = $order_type[$order[$key]['order_type']];
			$order[$key]['pay_type'] = $order[$key]['pay_type'] ? $pay_type[$order[$key]['pay_type']]:"未支付";
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
	public function payOrderByBalance($user_id,$serial_number){
		
		// $serial_number = 'tz_'.time().'_'.$user_id;	 //支付流水号
		
		$row = $this->where('serial_number',$serial_number)->get(['customer_id','order_status','payable_money','pay_type','resource_type','business_sn']);

		$return['data']	= '';
		$return['code']	= 0;
		// 是否存在此支付流水
		if($row->isEmpty()){
			$return['msg'] 	= '无此支付流水号';
			$return['code']	= 0;
			return $return;
		}
		$row = json_decode(json_encode($row),true);
		// dd($row);
		$payable_money = '0.00';
		for ($i=0; $i < count($row); $i++) { 
			// 是否是客户自己的订单
			if($user_id != $row[$i]['customer_id']){	
				$return['msg'] 	= '只能支付自己的订单';
				return $return;
			}
			// 订单的状态是否为未支付
			if( $row[$i]['order_status'] != 7 ){
				$return['msg'] 	= '订单已支付或已取消';
				return $return;
			}
			$payable_money = bcadd((string)$payable_money,(string)$row[$i]['payable_money'],2);
		}
		//获取余额
		$before_money = $this->getMoney($user_id)->money;
		//计算扣除应付金额后余额
		$after_money = bcsub((string)$before_money,(string)$payable_money,2);
	
		if( $after_money < 0 ){
			$return['msg'] 	= '余额不足,请充值';
			return $return;
		}
		$pay_time = date("Y-m-d h:i:s");
		
		$pay_type = $row[0]['pay_type'];
		
		//事务开始
		DB::beginTransaction();
		$updateData['before_money'] 	= $before_money;
		$updateData['after_money']	= $after_money;
		$updateData['pay_type']		= 1;
		$updateData['pay_price']	= $payable_money;
		$updateData['pay_time']	= $pay_time;
		$updateData['order_status']	= 1;
		$updateData['serial_number']	= $serial_number;
		//对交易流水涉及的几条订单更新支付相关信息
		$updateRes = $this->where('serial_number',$serial_number)->update($updateData);	
		if($updateRes == false){
			//更新失败回滚
			DB::rollBack();
			$return['msg'] 	= '支付失败';
			$return['code']	= 2;
			return $return;
		}

		// 订单支付成功后对客户的余额进行修改
		$payMoney = DB::table('tz_users')->where('id',$user_id)->update(['money' => $after_money ]);
		if($payMoney == false){
			// 修改客户余额失败，进行事务回滚
			DB::rollBack();
			$return['msg'] 	= '扣除余额失败,支付失败';
			$return['code']	= 2;
			return $return;	
		}

		for ($j=0 ; $j < count($row); $j++) { 
			if($row[$j]['resource_type'] < 4) {
				// 资源类型如果是机柜/主机，查找对应的业务状态	
				$business_status = DB::table('tz_business')->where('business_number',$row[$j]['business_sn'])->value('business_status');
				if($business_status > 0 && $business_status < 4){
					// 业务状态是审核通过且是使用状态将状态修改为付款使用即2
					$business['business_status'] = 2;
					$businessUp = DB::table('tz_business')->where('business_number',$row[$j]['business_sn'])->update($business);
					if($businessUp == 0) {
						DB::rollBack();
						$return['msg'] 	= '更改资源使用状态失败,订单可能为正在付款使用中状态,支付失败';
						$return['code']	= 3;
						return $return;
					}
				} 
			} 
		}
		DB::commit();
		// 客户余额修改成功
		
		$return['data'] = $row;
		$return['code'] = 1;
		$return['msg'] = '支付成功!!';			 		
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
				$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成'];
				foreach($resource_orders as $resource_key => $resource_value){
					$resource_orders[$resource_key]['resource_type'] = $resource_type[$resource_value['resource_type']];
					$resource_orders[$resource_key]['order_type'] = $order_type[$resource_value['order_type']];
					$resource_orders[$resource_key]['pay_type'] = $resource_value['pay_type'] ? $pay_type[$resource_value['pay_type']]:"";
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
	 * @param  array $param 需要续费的资源数据
	 * @return array        返回相关的数据信息状态及提示
	 */
	public function renewResource($param){
		// 判断是否传递相关参数
		if(!$param){
			$return['code'] = 0;
			$return['msg'] = '无法进行续费';
			return $return;
		}
		// 根据业务编号进行对应数据的查询
		$business_where = ['business_number'=>$param['business_number'],'client_id'=>Auth::user()->id];
		$business = DB::table('tz_business')->where($business_where)->select('business_number','business_type','sales_id', 'business_number','sales_name','business_type','machine_number','endding_time','length','money')->first();
		// 没有对应业务编号的业务数据直接返回
		if(!$business){
			$return['code'] = 0;
			$return['msg'] = '无绑定业务,无法进行续费';
			return $return;
		}
		//续费订单号的生成规则：前两位（4-6的随机数）+ 年月日 + 时间戳的后2位数 + 4-6的随机数 
		$order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(4,6);//续费订单号
		$order['order_sn'] = $order_sn;
		if(isset($param['order_sn']) && $param['resource_type'] > 3){
			// 存在订单号并且资源类型除主机和机柜外的根据订单号进行续费订单数据的查询
			$order_where = ['customer_id'=>Auth::user()->id,'business_sn'=>$param['business_number'],'order_sn'=>$param['order_sn'],'resource_type'=>$param['resource_type']];
			$order_data = $this->where($order_where)->select('business_sn','business_id','business_name','machine_sn','resource','price','end_time')->first();
			// 查无对应订单，直接返回
			if(!$order_data){
				$return['code'] = 0;
				$return['msg'] = '无对应的资源续费订单,无法进行资源续费';
				return $return;
			}
			//在原到期时间基础上增加续费时长,生成新的到期时间
			$end_time = Carbon::parse($order_data->end_time)->modify('+'.$param['length'].' months')->toDateTimeString();
			//续费到期时间超业务到期时间直接返回 
			if($end_time > $business->endding_time){
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '资源到期时间超业务到期时间，无法续费资源!';
				return $return;
			}
			$order['business_sn'] = $order_data->business_sn;//对应业务编号
			$order['business_id'] = $order_data->business_id;//业务员id
			$order['business_name'] = $order_data->business_name;//业务员姓名
			$order['machine_sn'] = $order_data->machine_sn;//资源编号
			$order['resource'] = $order_data->resource;//资源数据
			$order['price'] = $order_data->price;//单价
		} else {
			//资源类型为主机和机柜的直接进行新订单数据的生成
			$order['business_sn'] = $business->business_number;//对应业务编号
			$order['machine_sn'] = $business->machine_number;//机器编号
			$order['resource'] = $business->machine_number;//机器数据
			$order['price'] = $business->money;//单价
			$order['business_id'] = $business->sales_id;//业务员id
			$order['business_name'] = $business->sales_name;//业务员姓名
			//在原到期时间基础上增加续费时长,生成新的到期时间
			$end_time = Carbon::parse($business->endding_time)->modify('+'.$param['length'].' months')->toDateTimeString();	
		}
		// 续费订单数据的组成
		$order['duration'] = $param['length'];//续费时长
		$order['payable_money'] = bcmul((string)$order['price'],(string)$order['duration'],2);//应付金额
		$order['customer_id'] = Auth::user()->id;//客户id
		$order['customer_name'] = Auth::user()->name?Auth::user()->name:'test';//客户姓名
		$order['resource_type'] = $param['resource_type'];//资源类型
		$order['order_type'] = 2;//订单类型续费
		$order['end_time'] = $end_time;//订单到期时间
		$order['order_status'] = 0;//订单状态未付款
		$order['month'] = (int)date('Ym',time());//下单日期
		$order['created_at'] = Carbon::now()->toDateTimeString();//创建时间
		$order['order_note'] = $param['order_note'];//订单备注
		DB::beginTransaction();//开启事务处理
		$order_row = DB::table('tz_orders')->insert($order);//生成续费订单
		//续费订单生成失败直接返回
		if($order_row == 0) {
			DB::rollBack();
			$return['code'] = 0;
			$return['msg'] = '续费失败，请重新操作';
			return $return;
		}
		//资源类型为主机和机柜的对原业务的到期时间和累计时长进行更新
		if($param['resource_type'] == 1 || $param['resource_type'] == 2 || $param['resource_type'] == 3) {
			$business_alert['length'] = (int)bcadd($business->length,$param['length'],0);
			$business_alert['endding_time'] = $end_time;
			$business_alert['business_status'] = 3;
			$alert_where = ['business_number'=>$business->business_number];
			$business_row = DB::table('tz_business')->where($alert_where)->update($business_alert);
			//更新失败，直接返回
			if($business_row == 0){
				DB::rollBack();
				$return['code'] = 0;
				$return['msg'] = '续费失败，请重新操作';
				return $return;
			}
		}
		$machine['business_end'] = $order['end_time'];
		switch ($param['resource_type']) {
			case 1:
				//如果是租用机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
				$machine['own_business'] = $order['business_sn'];
				$machine['used_status'] = 1;
				$where = ['own_business'=>$order['business_sn'],'machine_num'=>$order['machine_sn']];
				$result = DB::table('idc_machine')->where($where)->update($machine);
				break;
			case 2:
				//如果是托管机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
				$machine['own_business'] = $order['business_sn'];
				$machine['used_status'] = 1;
				$where = ['own_business'=>$order['business_sn'],'machine_num'=>$order['machine_sn']];
				$result = DB::table('idc_machine')->where($where)->update($machine);
				break;
			case 3:
				//如果是租用机柜的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
				$cabinet = DB::table('idc_cabinet')->where(['cabinet_id'=>$order['machine_sn']])->value('own_business');
				$business = strpos($cabinet,$order['business_sn']);
				if($business){
					$machine['own_business'] = $business;
				} else {
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '资源续费失败,请确认您此前购买过该机柜';
					return $return;
				}
				
				$machine['use_state'] = 1;
				$where = ['own_business'=>$order['business_sn'],'cabinet_id'=>$order['machine_sn']];
				$row = DB::table('idc_cabinet')->where($where)->update($machine);
				break;  
			case 4:
				//更新IP表的所属业务编号，资源状态和到期时间
				$machine['own_business'] = $order['business_sn'];
				$machine['ip_status'] = 1;
				$where = ['own_business'=>$order['business_sn'],'ip'=>$order['machine_sn']];
				$result = DB::table('idc_ips')->where($where)->update($machine);
				break;
			case 5:
				//更新CPU表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $order['business_sn'];
				$machine['cpu_used'] = 1;
				$where = ['service_num'=>$order['business_sn'],'cpu_number'=>$order['machine_sn']];
				$result = DB::table('idc_cpu')->where($where)->update($machine);
				break;
			case 6:
				//更新硬盘表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $order['business_sn'];
				$machine['harddisk_used'] = 1;
				$where = ['service_num'=>$order['business_sn'],'harddisk_number'=>$order['machine_sn']];
				$result = DB::table('idc_harddisk')->where($where)->update($machine);
				break;
			case 7:
				//更新内存表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $order['business_sn'];
				$machine['memory_used'] = 1;
				$where = ['service_num'=>$order['business_sn'],'memory_number'=>$order['machine_sn']];
				$result = DB::table('idc_memory')->where($where)->update($machine);
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
			$return['msg'] = '资源续费订单创建成功,为了不影响使用请及时支付,您的续费单号:'.$order_sn;
		} else {
			DB::rollBack();
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '资源续费失败';
		}
		return $return;
	}


	public function makeTrade($order_id = [],$user_id){
		$return['data'] = '';
		$return['code'] = 0;
		$serial_number = 'tz_'.time().'_'.$user_id;
		$order_status = 7;

		DB::beginTransaction();//开启事务处理

		for ($i=0; $i < count($order_id) ; $i++) { 
			$order = $this->find($order_id[$i]);
			if($order == NULL){
				DB::rollBack();
				$return['msg'] = '有订单不存在';
				return $return;
			}
			if($order->customer_id != $user_id){
				DB::rollBack();
				$return['msg'] = '有订单不属于您';
				return $return;
			}
			if($order->order_status != 0){
				DB::rollBack();
				$return['msg'] = '有订单已支付或正在支付或已取消';
				return $return;
			}
			$order->serial_number = $serial_number;
			$order->order_status = $order_status;
			$order->pay_type = 0;
			$update = $order->save();
			if($update != true){
				DB::rollBack();
				$return['msg'] = '创建订单失败';
				return $return;
			}
		}
		DB::commit();
		$return['data'] 	= $serial_number;
		$return['msg']	= '创建订单成功';
		$return['code']	= 1;

		
		return $return;
	}
}