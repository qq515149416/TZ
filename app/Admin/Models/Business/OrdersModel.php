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
use App\Admin\Models\DefenseIp\OverlayBelongModel;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Session;
use XS;
use XSDocument;
use Illuminate\Support\Facades\Redis;
use App\Admin\Models\Business\BusinessModel;
use App\Admin\Models\DefenseIp\StoreModel;
use App\Admin\Models\Business\OrdersReviewModel;

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
	 * 财务人员和管理人员查看支付流水
	 * @param  array $where 订单的状态
	 * @return array        返回相关的数据信息和提示状态及信息
	 */
	public function financeOrders($data){
		$business = new BusinessModel();
		$time = $business->queryTime($data);
		
		$result = DB::table('tz_orders_flow as flow')
					->leftjoin('tz_users as users','flow.customer_id','=','users.id')
					->leftjoin('admin_users as admin','flow.business_id','=','admin.id')
					->whereBetween('flow.pay_time',[$time['start_time'],$time['end_time']])
					->whereNull('flow.deleted_at')

					->select('flow.id as flow_id','flow.order_id','flow.business_number','flow.serial_number','flow.payable_money','flow.actual_payment','flow.preferential_amount','flow.pay_time','flow.before_money','flow.after_money','flow.created_at','flow.flow_type','users.name as customer_name','users.email as customer_email','users.nickname as customer_nick_name','admin.name as business_name')

					->orderBy('flow.pay_time','desc')
					->get()
					->toArray();
					// dd($result);
		//应付金额
		$payable = DB::table('tz_orders_flow')
					->whereBetween('pay_time',[$time['start_time'],$time['end_time']])
					->whereNull('deleted_at')
					->sum('payable_money');
		//实际支付金额
		$paytrue = DB::table('tz_orders_flow')
					->whereBetween('pay_time',[$time['start_time'],$time['end_time']])
					->whereNull('deleted_at')
					->sum('actual_payment');
		//优惠金额
		$discount = DB::table('tz_orders_flow')
					->whereBetween('pay_time',[$time['start_time'],$time['end_time']])
					->whereNull('deleted_at')
					->sum('preferential_amount');
		//查询总量
		$total = DB::table('tz_orders_flow')
					->whereBetween('pay_time',[$time['start_time'],$time['end_time']])
					->whereNull('deleted_at')
					->count();
		// dd($result);
		if(!empty($result)){
			foreach($result as $key=>$value){
				$flow_type = [1=>'新购',2=>'续费'];
				$value->type = $flow_type[$value->flow_type];

				$value->customer_email = $value->customer_email?$value->customer_email:$value->customer_name;
				$value->customer_email = $value->customer_email?$value->customer_email:$value->customer_nick_name;
				
				
				$check = OrdersReviewModel::where('flow_id',$value->flow_id)->get(['status'])->toArray();
				//判断复核状态
				if (count($check) == 0){
					$value->review_status = '尚未复核';
					$value->is_review = 0;
				}else{
					foreach ($check as $k => $v) {
						
						if( $v['status'] == 0){
							$value->review_status = '已提交复核疑问,尚未处理';
							$value->is_review = 2;
						} 
					}
					if (!isset($value->review_status) ) {
						$value->review_status = '已复核完毕';
						$value->is_review = 1;
					}
				}				

				//取出流水包含的订单id
				$order_id = json_decode($value->order_id,true);
				
				$orr = [];//包含订单数组
				//解开后 , 有两种储存方式,一种数组形式一种int

				$type_arr = [1 => '租用主机' , 2 => '托管主机' , 3 => '租用机柜' , 4 => 'IP' , 5 => 'CPU' , 6 => '硬盘' , 7 => '内存' , 8 => '带宽' , 9 => '防护' , 10 => 'cdn' , 11 => '高防IP' , 12 => '流量叠加包'];
				$order_type_arr = [ 1 => '新购' , 2 => '续费'];
				if (is_array($order_id)) {	//数组类型的,从里面一个个找出来

					foreach ($order_id as $k => $v) {
						$order = DB::table('tz_orders')->find($v,['order_sn','business_sn','resource_type','order_type','payable_money']);
						if($order){
							if (isset($type_arr[$order->resource_type])) {
								$order->resource_type = $type_arr[$order->resource_type];
							}else{
								$order->resource_type = '未知类型';
							}
							if (isset($order_type_arr[$order->order_type])) {
								$order->order_type = $order_type_arr[$order->order_type];
							}else{
								$order->order_type = '未知类型';
							}
						}else{

						}
						$orr[] = $order;
					}
				}else{
					$order = DB::table('tz_orders')->find($order_id,['order_sn','business_sn','resource_type','order_type','payable_money']);
						if($order){
							if (isset($type_arr[$order->resource_type])) {
								$order->resource_type = $type_arr[$order->resource_type];
							}else{
								$order->resource_type = '未知类型';
							}
							if (isset($order_type_arr[$order->order_type])) {
								$order->order_type = $order_type_arr[$order->order_type];
							}else{
								$order->order_type = '未知类型';
							}
						}else{

						}
						$orr[] = $order;
				}
				$value->order_arr = $orr;		

			}

			$return['data'] = ['info'=>$result,'payable'=>$payable,'paytrue'=>$paytrue,'discount'=>$discount,'total'=>$total];
			$return['code'] = 1;
			$return['msg'] = '客户流水获取成功！';

		} else {
			$return['data'] = $result;
			$return['code'] = 0;
			$return['msg'] = '客户流水获取失败！';
		}
		return $return;
	}

	/**
	 * 业务员和管理人员通过业务查看订单
	 * @param  array $where 订单的状态
	 * @return array        返回相关的数据信息和提示状态及信息
	 */
	public function clerkOrders($where){
		if(isset($where['id'])){
			$where['tz_orders.id'] = $where['id'];
			unset($where['id']);
		}
		
		$result = DB::table('tz_orders')
					->leftJoin('tz_orders_flow','tz_orders.serial_number','=','tz_orders_flow.serial_number')
					->where($where)
					->whereBetween('tz_orders.remove_status',[0,3])
                    ->whereNull('tz_orders.deleted_at')
					->orderBy('tz_orders.created_at','desc')
					->select('tz_orders.id','tz_orders.order_sn','tz_orders.customer_id','tz_orders.business_sn','tz_orders.business_id','tz_orders.resource_type','tz_orders.order_type','tz_orders.resource','tz_orders.price','tz_orders.duration','tz_orders.machine_sn','tz_orders.payable_money','tz_orders.end_time','tz_orders.serial_number','tz_orders.pay_time','tz_orders.order_status','tz_orders.order_note','tz_orders.created_at','tz_orders_flow.before_money','tz_orders_flow.after_money','tz_orders.remove_status')
					->get();

		if(!$result->isEmpty()){
			$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP',12=>'流量叠加包'];
			$order_type = [1=>'新购',2=>'续费'];
			$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成'];
			$remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
			foreach($result as $okey=>$ovalue){
				$ovalue->type = $ovalue->resource_type;
				$ovalue->resourcetype = $resource_type[$ovalue->resource_type];
                $ovalue->order_type = $order_type[$ovalue->order_type];
                $ovalue->status = $ovalue->order_status;
				$ovalue->order_status = $order_status[$ovalue->order_status];
				$ovalue->remove_status = $remove_status[$ovalue->remove_status];
				$ovalue->business_name = DB::table('admin_users')->where(['id'=>$ovalue->business_id])->value('name');
                $client_name = DB::table('tz_users')->where(['id'=>$ovalue->customer_id])->value('nickname');
                $ovalue->customer_name = $client_name;
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
	 * @param  array $insert_data --business_sn-要绑定的业务号,--customer_id-客户id,--resource_type-资源类型,--price-单价,--duration--时长,--resource_id--资源id
	 * @return array              返回相关的订单号及状态提示及信息
	 */
	public function insertResource($insert_data){
		if(!$insert_data){
			// 如果资源数据为空
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#101)资源无法增加！！';
			return $return;
		}

		if(!isset($insert_data['business_sn'])){//未传递绑定的主业务
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#102)该资源所需绑定的主业务无法确定';
			return $return;
		}

		if(!isset($insert_data['customer_id'])){//未表明资源将会归属到哪位客户名下
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#103)请确认该资源将会归属到哪位客户名下';
			return $return;
		}

		if(!isset($insert_data['price'])){//单价未设置
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#104)请确认资源单价';
			return $return;
		}

		if(!isset($insert_data['duration'])){//时长未设置
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#105)请确认资源购买时长';
			return $return;
		}

		if(!isset($insert_data['resource_type'])){//资源类型不明确
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#106)请确认资源类型';
			return $return;
		}

		if(!isset($insert_data['resource_id'])){//资源不明确
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#107)请确认资源';
			return $return;
		}

		/**
		 * 根据传递的业务号进行主业务的查询
		 * @var [type]
		 */
		$business = DB::table('tz_business')->where('business_number',$insert_data['business_sn'])->value('business_status');
		if(empty($business)){//主业务不存在
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#108)该业务可能不存在/已取消/未审核';
			return $return;
		}
		if($business<1 || $business>4){//业务状态未通过审核/其他非正常状态
			$business_status = ['-1' => '取消', '-2' => '审核不通过', 0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#109)该业务无法添加资源,原因:'.$business_status[$business];
			return $return;
		}
		$insert['business_sn'] = $insert_data['business_sn'];//绑定的业务号

		/**
		 * 客户信息
		 */
		$client = DB::table('tz_users')->where(['id'=>$insert_data['customer_id'],'status'=>2])->select('nickname','salesman_id')->first();
		if(empty($client)){//客户信息未找到/账号异常
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#110)客户不存在或账号未验证/异常,请确认后再创建资源订单!';
			return $return;
		}
		$insert['business_id'] = $client->salesman_id;
		$insert['business_name'] = DB::table('admin_users')->where(['id'=>$client->salesman_id])->value('name');
		$insert['customer_id'] = $insert_data['customer_id'];
		$insert['customer_name'] = $client->nickname;

		/**
		 * 到期时间和应付价格
		 * @var [type]
		 */
		$end_time = time_calculation(date('Y-m-d H:i:s',time()),$insert_data['duration'],'month');
		$insert['end_time'] = $end_time;
		$insert['order_type'] = 1;
		$insert['payable_money'] = bcmul((string)$insert_data['price'],(string)$insert_data['duration'],2);//计算价格
		$insert['duration'] = $insert_data['duration'];
		$insert['price'] = $insert_data['price'];
		$machine['business_end'] = $end_time;
		DB::beginTransaction();//开启事务处理
		switch ($insert_data['resource_type']) {
			case 4:
				$ip = DB::table('idc_ips')->where(['id'=>$insert_data['resource_id'],'ip_status'=>0,'ip_lock'=>0])->whereNull('deleted_at')->select('ip','ip_company')->first();
				if(empty($ip)){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#111)该IP资源不存在/已被使用,请重新选择';
					return $return;
				}
				$ip_company = [0=>'电信公司',1=>'移动公司',2=>'联通公司',3=>'BGP'];
				$insert['machine_sn'] = $ip->ip;
				$insert['resource'] = $ip->ip.$ip_company[$ip->ip_company];
				//更新IP表的所属业务编号，资源状态和到期时间
				$machine['own_business'] = $insert_data['business_sn'];
				$machine['ip_status'] = 1;
				$result = DB::table('idc_ips')->where(['id'=>$insert_data['resource_id']])->update($machine);
				break;
			case 5:
				$cpu = DB::table('idc_cpu')->where(['id'=>$insert_data['resource_id'],'cpu_used'=>0])->whereNull('deleted_at')->select('cpu_number','cpu_param')->first();
				if(empty($cpu)){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#112)该CPU资源不存在/已被使用,请重新选择';
					return $return;
				}
				$insert['machine_sn'] = $cpu->cpu_number;
				$insert['resource'] = $cpu->cpu_param;
				//更新CPU表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $insert_data['business_sn'];
				$machine['cpu_used'] = 1;
				$result = DB::table('idc_cpu')->where(['id'=>$insert_data['resource_id']])->update($machine);
				break;
			case 6:
				$harddisk = DB::table('idc_harddisk')->where(['id'=>$insert_data['resource_id'],'harddisk_used'=>0])->whereNull('deleted_at')->select('harddisk_number','harddisk_param')->first();
				if(empty($harddisk)){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#113)该硬盘资源不存在/已被使用,请重新选择';
					return $return;
				}
				$insert['machine_sn'] = $harddisk->harddisk_number;
				$insert['resource'] = $harddisk->harddisk_param;
			   //更新硬盘表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $insert_data['business_sn'];
				$machine['harddisk_used'] = 1;
				$result = DB::table('idc_harddisk')->where(['id'=>$insert_data['resource_id']])->update($machine);
				break;
			case 7:
				$memory = DB::table('idc_memory')->where(['id'=>$insert_data['resource_id'],'memory_used'=>0])->whereNull('deleted_at')->select('memory_number','memory_param')->first();
				if(empty($memory)){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#114)该内存资源不存在/已被使用,请重新选择';
					return $return;
				}
				$insert['machine_sn'] = $memory->memory_number;
				$insert['resource'] = $memory->memory_param;
				//更新内存表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $insert_data['business_sn'];
				$machine['memory_used'] = 1;
				$result = DB::table('idc_memory')->where(['id'=>$insert_data['resource_id']])->update($machine);
				break;
			case 8://带宽
				$insert['machine_sn'] = 'BW'.date("Ymd",time()).substr(time(),8,2).chr(mt_rand(65,90));
				$insert['resource'] = $insert_data['resource_id'];
				$result = 1;
				break;
			case 9://防护
				$insert['machine_sn'] = 'DEF'.date("Ymd",time()).substr(time(),8,2).chr(mt_rand(65,90));
				$insert['resource'] = $insert_data['resource_id'];
				$result = 1;
				break;
			default:
				$result = 1;
				break;
		}
		if($result == 0){
			DB::rollBack();
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#115)资源增加失败';
			return $return;
		}

		$order_sn =$this->ordersn();
		$insert['order_sn'] = $order_sn;
		$insert['created_at'] = date('Y-m-d H:i:s',time());
		$insert['resource_type'] = $insert_data['resource_type'];	
		$row = DB::table('tz_orders')->insertGetId($insert);
		if($row == false){
			// 资源订单生成失败
			DB::rollBack();
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#116)资源增加失败';
			return $return;
		}
		//所对应资源表的业务编号和到期时间，状态修改成功后进行事务提交
		$xunsearch = new XS('orders');
	    $index = $xunsearch->index;
        $doc['id'] = strtolower($row);
		$doc['machine_sn'] = strtolower($insert['machine_sn']);
		$doc['business_sn'] = strtolower($insert['business_sn']);
		$doc['order_sn'] = strtolower($order_sn);
		$document = new \XSDocument($doc);
		$index->update($document);
		$index->flushIndex();
		DB::commit();
		$return['data'] = $order_sn;
		$return['code'] = 1;
		$return['msg'] = '资源增加成功，请提醒客户及时支付，订单号:'.$order_sn;
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
                            $return['msg'] = '取消订单失败!!';
                            return $return;
                        }
                        $row = DB::table('idc_machine')->where(['machine_num'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number,'business_type'=>1])->update($rent);
                        if($row == 0){
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '取消订单失败!';
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
                            $return['msg'] = '取消订单失败!';
                            return $return;
                        }
                        $row = DB::table('idc_machine')->where(['machine_num'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number,'business_type'=>2])->update($hosting);
                        if($row == 0){
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '取消订单失败!';
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
                                $return['msg'] = '取消订单失败!';
                                return $return;
                            }

                        }
                        $end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
                        $cabinet['endding_time'] = $end_time;
                        $business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update($cabinet);
                        if($business == 0){//更新业务到期时间失败
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg'] = '取消订单失败!';
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
                            $order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>1]);
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
                            $order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>1]);
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
                            $order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>1]);
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
                            $order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>1]);
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
		$orders = [];
		$business['remove_status']=0;
		$machine = DB::table('tz_business')->where(['business_number'=>$business['business_sn']])->whereNull('deleted_at')->select('id','business_type')->first();
		
		if(!empty($machine) && $machine->business_type == 3){//当是机柜时同时获取机柜业务下的机器
			$orders['machine'] = DB::table('tz_cabinet_machine')->where(['parent_business'=>$machine->id,'remove_status'=>0])->whereBetween('business_status',[1,2])->whereNull('deleted_at')->get();
		}

		//以资源编号为键的资源数组
		$all = $this->where($business)->where('resource_type','>',3)->orderBy('end_time','desc')->get(['order_sn','resource_type','machine_sn','resource','price','end_time','business_sn'])->groupBy('machine_sn');
		$resource = $all->map(function($item,$key){//根据资源编号获取对应资源的最新一条订单（$key为$all的键）,map参考laravel模型的集合的可用方法
			return $this->where(['machine_sn'=>$key,'business_sn'=>$item[0]['business_sn']])->where('order_status','<',3)->orderBy('end_time','desc')->select('order_sn','resource_type','machine_sn','resource','price','end_time','order_status')->first();	
		});
		if(!empty($resource)){
			$orders['IP'] = $resource->filter(function($value,$key){return $value->resource_type == 4;})->values();
			$orders['cpu'] = $resource->filter(function($value,$key){return $value->resource_type == 5;})->values();
			$orders['harddisk'] = $resource->filter(function($value,$key){return $value->resource_type == 6;})->values();
			$orders['memory'] = $resource->filter(function($value,$key){return $value->resource_type == 7;})->values();
			$orders['bandwidth'] = $resource->filter(function($value,$key){return $value->resource_type == 8;})->values();
			$orders['protected'] = $resource->filter(function($value,$key){return $value->resource_type == 9;})->values();
			$orders['cdn'] = $resource->filter(function($value,$key){return $value->resource_type == 10;})->values();
			
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
		$primary_key = '';
		$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP',12=>'流量叠加包'];
		
		/**
		 * 主业务的续费
		 */
		if(isset($renew['business_number'])){//传递了业务编号的进行业务查找和续费
			$renew_order = [];//用于存储新增的订单的id，用于存储进redis，方便后续调用订单
			$business_where = [
				'business_number'=>$renew['business_number'],
			];
			$business = DB::table('tz_business')->where($business_where)->select('id','business_number','business_type','client_id','client_name','business_type','machine_number','endding_time','length','money','business_status','remove_status','order_number','resource_detail')->first();
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
			$order['order_sn'] = $this->ordersn();//订单关联业务
			$order['order_number'] = $business->order_number;
			$order['customer_name'] = $business->client_name;
			$order['business_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
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
			$order['client_id'] = $business->client_id;//记录客户的id
			$order['parent_business'] = 0;
			$renew_order['O'.$order['order_sn']] = json_encode($order);
			if(empty($primary_key)){
				$primary_key = $this->redisPrimaryKey();
			}
			$this->setRenewRedis($primary_key,$renew_order);
		}

		/**
		 * 业务下的资源续费
		 */
		if(isset($renew['orders'])){
			foreach($renew['orders'] as $key=>$value){
                if($value != 0){
                	$renew_order = [];//用于存储新增的订单的id，用于存储进redis，方便后续调用订单
                    $order_where['order_sn'] = $value;
                    $order_result = $this->where($order_where)->select('id','business_sn','customer_id','customer_name','resource_type','machine_sn','resource','price','end_time','order_status')->first();
                    if($order_result->order_status < 1 || $order_result->order_status > 2){
                        $order_status = [0=>'待支付',1=>'支付',2=>'支付',3=>'续费过',4=>'到期',5=>'取消',6=>'申请退款',8=>'退款完成'];
                        $return['data'] = '';
                        $return['code'] = 0;
                        $return['msg'] = '资源编号:'.$order_result->machine_sn.'的资源'.$order_result->resource.','.'无法续费,原因:'.$order_status[$order_result->order_status];
                        return $return;
                    }
                    //到期时间
                    $end_time = time_calculation($order_result->end_time,$renew['length'],'month');
                    $order['end_time'] = $end_time;
                    $order['duration'] = $renew['length'];//订单时长
                    $order['order_sn'] = $this->ordersn();//订单关联业务
                    $order['order_number'] = $value;
                    $order['customer_name'] = $order_result->customer_name;
                    $order['business_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
                    $order['resource_type'] = $order_result->resource_type;//资源类型
                    $order['resourcetype'] = $resource_type[$order['resource_type']];
                    $order['machine_sn'] = $order_result->machine_sn;//订单机器编号
                    $order['resource'] = $order_result->resource;//订单机器详情
                    $order['price'] = $order_result->price;//订单单价
                    $order['payable_money'] = bcmul($order_result->price,$renew['length'],2);//订单应付金额
                    $order['order_status'] = 0;//订单状态为未支付
                    $order['created_at'] = date('Y-m-d H:i:s',time());//订单创建时间
                    $order['id']=$order_result->id;
                	$order['client_id'] = $order_result->customer_id;
                	$order['parent_business'] = 0;
                	$renew_order['O'.$order['order_sn']] = json_encode($order);
                    if(empty($primary_key)){
						$primary_key = $this->redisPrimaryKey();
					}
					$this->setRenewRedis($primary_key,$renew_order);   
                }	
			}    
		}

		/**
		 * 机柜业务下的机器续费
		 */
		if(isset($renew['cabinet_machine'])){
			foreach($renew['cabinet_machine'] as $key=>$item){
				$renew_order =[];//用于存储新增的订单的id，用于存储进redis，方便后续调用订单
				$machine_where['business_number'] = $item;
				$cabinet_machine = DB::table('tz_cabinet_machine')->where($machine_where)->whereNull('deleted_at')->select('id','business_number','customer','resource_type','resource_sn','price','endtime','ip_id','parent_business')->first();
				
				if(empty($cabinet_machine)){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '机柜业务下的机器业务'.$item.'不存在';
					return $return;
				}

				$end_time = time_calculation($cabinet_machine->endtime,$renew['length'],'month');
				$order['end_time'] = $end_time;
				$order['duration'] = $renew['length'];
				$order['order_sn'] = $this->ordersn();
				$order['order_number'] = $item;
				$order['customer_name'] = DB::table('tz_users')->where(['id'=>$cabinet_machine->customer])->value('nickanme');
				$order['business_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
				$order['resource_type'] = $cabinet_machine->resource_type;
				$order['resourcetype'] = $resource_type[$order['resource_type']];
				$order['machine_sn'] = $cabinet_machine->resource_sn;
				$order['resource'] = DB::table('idc_ips')->where(['id'=>$cabinet_machine->ip_id])->value('ip');
				$order['price'] = $cabinet_machine->price;
				$order['payable_money'] = bcmul($cabinet_machine->price,$renew['length'],2);
				$order['order_status'] = 0;
				$order['created_at'] = date('Y-m-d H:i:s',time());
				$order['id'] = $cabinet_machine->id;
				$order['client_id'] = $cabinet_machine->customer;
				$order['parent_business'] = $cabinet_machine->parent_business;
				$renew_order['O'.$order['order_sn']] = json_encode($order);
				if(empty($primary_key)){
					$primary_key = $this->redisPrimaryKey();
				}
				$this->setRenewRedis($parimary_key,$renew_order);
			}
		}

		$return['data'] = $primary_key;
		$return['code'] = 1;
		$return['msg'] = '续费已经创建,支付后即代表续费成功!';
		return $return;

	}

	/**
	 * 续费订单的支付
	 * @param  array $pay_key 续费订单的session键
	 * @return [type]          [description]
	 */
	public function renewPay($pay_key){
		if(!$pay_key){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg']  = '(#101)无法获取需要支付的续费信息';
			return $return;
		}
		$redis_length = $this->renewRedisLength('P'.$pay_key['session_key']);
		if(!$redis_length > 0){
			$return['data'] = $redis_length;
			$return['code'] = 0;
			$return['msg']  = '(#102)无对应续费信息，请确认无误后操作';
			return $return;
		}
		$redis = Redis::connection('orders');;
		$total_money = $redis->get('M'.$pay_key['session_key']);
		$client = $redis->get('C'.$pay_key['session_key']);
		$client_money = DB::table('tz_users')->where(['id'=>$client])->value('money');//获取客户的余额
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
			$renew_value = $this->getRenewRedis('P'.$pay_key['session_key'],'pay');
			
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

   			if($renew_value['parent_business'] != 0){//机柜业务下的机器业务存在
   				$order = DB::table('tz_cabinet_machine')->where(['business_number'=>$renew_value['order_number']])->select('id','business_number as business_sn','resource_sn as machine_sn','duration')->first();
   			} else {
   				$order = DB::table('tz_orders')->where(['order_sn'=>$renew_value['order_number']])->select('id','order_sn','business_sn','machine_sn','duration')->first();//查找对应的订单数据
   			}
			
			if(empty($order)){//当无法找到对应的订单数据
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']  = '(#106)该资源不存在无法进行续费，请确认!';
				return $return;
			}

			if($renew_value['resource_type'] < 4 && $renew_value['parent_business'] == 0){
				//当业务类型是租用主机/托管主机/租用机柜且非机柜业务下机器时需进一步对本身的业务数据的到期时间进行更新
				$business = DB::table('tz_business')->where(['business_number'=>$order->business_sn])->select('id','machine_number','length')->first();
				if(empty($business)){//未找到对应的业务数据
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg']  = '(#107)该业务资源不存在无法进行续费，请确认!';
					return $return;
				}
				$length = bcadd($renew_value['duration'],$business->length);//更新累计时长
				$update_business = DB::table('tz_business')->where(['business_number'=>$order->business_sn])->update(['length'=>$length,'endding_time'=>$renew_value['end_time']]);
				if($update_business == 0){//更新业务到期时间和累计时长失败
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg']  = '(#108)该业务资源续费失败，请确认!';
					return $return;
				}
			}
			$duration = bcadd($renew_value['duration'],$order->duration);//更新累计时长
			$pay_time = date('Y-m-d H:i:s',time());//更新支付时间
			
			if($renew_value['parent_business'] != 0){//机柜业务下机器业务存在
				$update_order = DB::table('tz_cabinet_machine')->where(['business_number'=>$renew_value['order_number']])->update(['duration'=>$duration,'endtime'=>$renew_value['end_time']]);
			} else {
				$update_order = DB::table('tz_orders')->where(['order_sn'=>$renew_value['order_number']])->update(['duration'=>$duration,'end_time'=>$renew_value['end_time']]);
			}
			 
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

            if($renew_value['parent_business'] == 0){//非机柜下业务,进行支付流水的生成
            	$money = DB::table('tz_users')->where(['id'=>$renew_value['client_id']])->value('money');//获取客户的余额
				$total = bcmul($renew_value['price'],$renew_value['duration'],2);//计算需要支付的金额
				$over_money = bcsub($money,$total,2);//进行余额扣除
				if($total != 0.00){
					$users = DB::table('tz_users')->where(['id'=>$renew_value['client_id']])->update(['money'=>$over_money]);//更新余额到对应的客户
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
					'business_id'=>Admin::user()->id,
					'customer_id'=>$renew_value['client_id'],
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
				$serial = DB::table('tz_orders_flow')->insert($pay_info);
				if($serial == 0){
					DB::rollBack();
	                $return['data'] = '';
	                $return['code'] = 0;
	                $return['msg'] = '(#113)资源续费扣除失败!!!';
	                return $return;
				}
            }
   			

		}
		DB::commit();
		return ['data'=>'','code'=>1,'msg'=>'资源续费成功,请及时确认信息'];
	}



	/**
	 * 计算续费订单需要支付的金额
	 * @param  array $pay 需要支付的续费订单的数据
	 * @return [type]      [description]
	 */
	public function totalPay($pay){
		$total = 0;
		if(!$pay){
		    $total = FALSE; 
		}
		foreach($pay as $pay_key =>$pay_value){
			$total = bcadd($total,$pay_value['payable_money'],2);
		}
		return $total;
	}

	/**
     * 创建订单号
     * @return [type] [description]
     */
    public function ordersn(){
    	$order_sn = create_number();//调用创建单号的公共函数
        $order = DB::table('tz_orders')->where('order_sn',$order_sn)->select('order_sn','machine_sn')->first();
        $redis = Redis::connection('orders');
        if(!empty($order)){
            $this->ordersn();
        }
        if($redis->exists('O'.$order_sn) != 0){
        	$this->ordersn();
        }
        return $order_sn;
    }

    /**
	 * 生成支付流水号
	 * @return [type] [description]
	 */
	public function serialNumber($id){
		$business_id = Admin::user()->id;
		$time = bcadd(time(),$id,0);
   		$serial_number = 'tz_'.chr(mt_rand(97,122)).$time.mt_rand(10,50).'_admin_'.$business_id;
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
	public function redisPrimaryKey(){
		$order_sn = 'R'.$this->ordersn();
		$redis = Redis::connection('orders');
		if($redis->exists($order_sn) != 0  || $redis->exists('M'.$order_sn) != 0 || $redis->exists('C'.$order_sn) != 0){
			$this->redisPrimaryKey();
		}
		return $order_sn;
	}

	public function payOrderByBalance($order_id,$coupon_id){
		$return['data'] = '';
		$admin_user_id = Admin::user()->id;

		$biaoshi = 0;
		foreach ($order_id as $k => $v) {
			//获取订单信息
			$c_order = $this->find($v);

			//判断订单是否存在
			if($c_order == null){		//如果没有
				return [
					'data'	=> [],
					'msg'	=> '订单不存在',
					'code'	=> 0,
				];
			}
			if($biaoshi == 0){
				$customer_id = $c_order->customer_id;
				$biaoshi = 1;
			}

			if($customer_id == null){
				return [
					'data'	=> [],
					'msg'	=> '客户id获取失败',
					'code'	=> 0,
				];
			}

			if ($c_order->customer_id != $customer_id) {

				return [
					'data'	=> [],
					'msg'	=> '订单不属于同一客户,请分开支付',
					'code'	=> 0,
				];
			}
			if ($c_order->order_status != 0) {

				return [
					'data'	=> [],
					'msg'	=> '订单已支付',
					'code'	=> 0,
				];
			}
			if ($c_order->remove_status != 0) {

				return [
					'data'	=> [],
					'msg'	=> '资源已下架,无法支付',
					'code'	=> 0,
				];
			}
		}

		$unpaidOrder = $this
				->where('order_status',0)
				->where('remove_status',0)
				->whereIN('id',$order_id)
				->get()
				->toArray();

		if(count($unpaidOrder) == 0){
			$return['msg']  = '订单不存在';
			$return['code'] = 0;
			return $return;
		}

		$serial_number = 'tz_'.time().'_admin_'.$admin_user_id;
		$payable_money = '0.00';
		$pay_time = date("Y-m-d h:i:s");
		$order_id_arr = [];
		$idc_arr = array(1,2,3,4,5,6,7,8,9);
		$defenseip_arr = array(11);
		$overlay_arr = array(12);

		DB::beginTransaction();//开启事务处理

		for ($i=0; $i < count($unpaidOrder); $i++) {

			$business_id = DB::table('tz_users')->where('id',$unpaidOrder[$i]['customer_id'])->value('salesman_id');
			$business_number = $unpaidOrder[$i]['business_sn'];
			if($business_id != $admin_user_id){
				$return['msg']  = '该业务所属客户不属于您';
				$return['code'] = 0;
				return $return;
			}

			// $checkCoupon = $this->checkCoupon($unpaidOrder[$i]['id'],$coupon_id);
			// if($checkCoupon != true){
			// 	$return['msg']  = '该优惠券不可用';
			// 	$return['code'] = 0;
			// 	return $return;
			// }

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
			$return['msg']  = '用户的余额为 ￥'.$before_money.',订单尚需支付 ￥'.$actual_payment.',余额不足,请充值';
			$return['code'] = 0;
			return $return;
		}
		
		$room_id = '';
		if(in_array($unpaidOrder[0]['resource_type'],$idc_arr) ){
			$room = DB::table('tz_business')->where(['business_number'=>$unpaidOrder[0]['business_sn']])->value('resource_detail');
			$room_id = json_decode($room)->machineroom_id;
		}elseif(in_array($unpaidOrder[0]['resource_type'],$defenseip_arr)) {
			$room_id = DB::table('tz_defenseip_package')->where('id',$unpaidOrder[0]['machine_sn'])->value('site');
		}elseif (in_array($unpaidOrder[0]['resource_type'],$overlay_arr)) {
			$room_id = DB::table('tz_overlay')->where('id',$unpaidOrder[0]['machine_sn'])->value('site');
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
			'room_id'		=> $room_id,
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
		if($payMoney == false && $before_money != $after_money){
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
			$business_status = DB::table('tz_business')->where('business_number',$row['business_sn'])->whereNull('deleted_at')->value('business_status');
			if($business_status > 0 && $business_status < 4 && $business_status != 2){
				// 业务状态是审核通过且是使用状态将状态修改为付款使用即2
				$business['business_status'] = 2;
				$businessUp = DB::table('tz_business')->where('business_number',$row['business_sn'])->whereNull('deleted_at')->update($business);
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
					->whereNull('deleted_at')
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
									->whereNull('deleted_at')
									->update($business);
						
						if($update_business == 0){
							$return['msg']  = '更新业务到期时间失败!';
							$return['code'] = 3;
							return $return;
						}
						$d_ip = StoreModel::find($checkBusiness->ip_id);
						if ($d_ip == null) {
							$return['msg']  = '高防ip信息获取失败';
							$return['code'] = 3;
							return $return;
						}
						$d_ip->status = 1;
						if (!$d_ip->save()) {
							$return['msg']  = '高防ip状态更新失败';
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
					->whereNull('deleted_at')
					->first();
					if($package == null){
						$return['msg']  = '该套餐已下架!';
						$return['code'] = 2;
						return $return;
					}
					$sale_ip = StoreModel::select(['id','ip'])
							->where('site',$package->site)
							->where('protection_value',$package->protection_value)
							->where('status',0)
							->whereNull('deleted_at')
							->first();
					if($sale_ip == null){
						$return['msg']  = '该套餐IP库存不足!';
						$return['code'] = 2;
						return $return;
					}
					$sale_ip->status = 1;
					$update_ip =  $sale_ip->save();
					if(!$update_ip){
						$return['msg']  = '更新ip使用状态失败!';
						$return['code'] = 3;
						return $return;
					}
					
					$idc_ip = Ips::where('ip',$sale_ip->ip)->first();
					if ($idc_ip == null) {
						$return['msg']  = 'ip资源库ip信息获取失败!';
						$return['code'] = 3;
						return $return;
					}
					$idc_ip->ip_note = '高防使用中!';
					$idc_ip->ip_status = 1;
					if (!$idc_ip->save()) {
						$return['msg']  = 'ip资源库ip状态更改失败!';
						$return['code'] = 3;
						return $return;
					}

					$end = time_calculation(date('Y-m-d H:i:s',time()),$row['duration'],'month');
					// Carbon::now()->addMonth($row['duration'])->toDateTimeString();

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
						->whereNull('deleted_at')
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
				$upEnd = DB::table('tz_defenseip_business')
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
		}elseif ($row['resource_type'] == 12) { //如果订单是叠加包的话
			//生成归属信息

			$belong = [
				'overlay_id'	=> $row['machine_sn'],
				'user_id'	=> $row['customer_id'],
				'buy_time'	=> $pay_time,
				'order_sn'	=> $row['order_sn'],
				'status'		=> 0
			];
			
			$belong_model = new OverlayBelongModel();
			//duration记录购买数量,买了多少个就生成多少个
			for ($i=0; $i < $row['duration']; $i++) { 
				if(!$belong_model->create($belong)){
					return [
						'data'	=> [],
						'msg'	=> '用户增加所属叠加包失败',
						'code'	=> 3,
					];
				}
			}
		}

		$return['msg'] = '更新成功!!';
		$return['code'] = 1;
		return $return;
	}

	/**
	 * 信安代为录入相关的资源数据
	 * @param  [type] $insert_data [description]
	 * @return [type]              [description]
	 */
	public function securityInsertOrders($insert_data){
		if(!$insert_data){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#101)资源无法代为录入增加！！';
			return $return;
		}
		$sales = DB::table('admin_users')->where(['id'=>$insert_data['sales_id']])->select('id','name','username')->first();//查找业务信息
        if(empty($sales)){//业务员信息不存在
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#102)该业务员不存在,请确认后再创建业务!';
            return $return;
        }
        $client = DB::table('tz_users')->where(['id'=>$insert_data['customer_id'],'status'=>2,'salesman_id'=>$insert_data['sales_id']])->value('nickname');//查找对应的客户信息
        if(empty($client)){//客户信息不存在/拉黑
            $return['data'] = '';
            $return['code'] = 0;
			$name = $sales->name?$sales->name:$sales->username;
            $return['msg']  = '(#103)客户不存在/客户不属于业务员:'.$name.'/账号未验证/异常,请确认后再创建业务!';
            return $return;
        }
        $business = DB::table('tz_business')->where(['id'=>$insert_data['business_id'],'client_id'=>$insert_data['customer_id'],'sales_id'=>$insert_data['sales_id'],'remove_status'=>0])->whereBetween('business_status',[0,3])->select('business_number','id','resource_detail')->first();
        if(empty($business)){
        	$return['data'] = '';
        	$return['code'] = 0;
        	$return['msg'] = '(#104)所选择的业务不存在/客户(业务员)不对应/业务已(正在)下架';
        	return $return;
        }
        $resource_detail = json_decode($business->resource_detail);
        DB::beginTransaction();
        switch ($insert_data['resource_type']) {
			case 4:
				$resource = DB::table('idc_ips')->where(['id'=>$insert_data['resource_id'],'ip_status'=>0,'ip_comproom'=>$resource_detail->machineroom_id,'ip_lock'=>0])->select('id','ip','ip_company')->first();
				if(empty($resource)){
					DB::rollBack();
					$return['data'] = $resource;
					$return['code'] = 0;
					$return['msg'] = '(#105)所选择的IP资源不存在/已被使用/与要绑定的业务不在同一机房';
					return $return;
				}
				$ip_company = [0=>'电信',1=>'移动',2=>'联通'];
				$insert['machine_sn'] = $resource->ip;
				$insert['resource'] = $resource->ip.$ip_company[$resource->ip_company];
				//更新IP表的所属业务编号，资源状态和到期时间
				$machine['own_business'] = $business->business_number;
				$machine['ip_status'] = 1;
				$result = DB::table('idc_ips')->where(['id'=>$insert_data['resource_id']])->update($machine);
				break;
			case 5:
				$resource = DB::table('idc_cpu')->where(['id'=>$insert_data['resource_id'],'cpu_used'=>0])->select('id','cpu_number','cpu_param')->first();
				if(empty($resource)){
					DB::rollBack();
					$return['data'] = $resource;
					$return['code'] = 0;
					$return['msg'] = '(#106)所选择的CPU资源不存在/已被使用/与要绑定的业务不在同一机房';
					return $return;
				}
				$insert['machine_sn'] = $resource->cpu_number;
				$insert['resource'] = $resource->cpu_param;
				//更新CPU表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $business->business_number;
				$machine['cpu_used'] = 1;
				$result = DB::table('idc_cpu')->where(['id'=>$insert_data['resource_id']])->update($machine);
				break;
			case 6:
				$resource = DB::table('idc_harddisk')->where(['id'=>$insert_data['resource_id'],'harddisk_used'=>0])->select('id','harddisk_number','harddisk_param')->first();
			   	if(empty($resource)){
			   		DB::rollBack();
			   		$return['data'] = $resource;
					$return['code'] = 0;
					$return['msg'] = '(#107)所选择的硬盘资源不存在/已被使用/与要绑定的业务不在同一机房';
					return $return;
			   	}
			   	$insert['machine_sn'] = $resource->harddisk_number;
			   	$insert['resource'] = $resource->harddisk_param;
			   //更新硬盘表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $business->business_number;
				$machine['harddisk_used'] = 1;
				$result = DB::table('idc_harddisk')->where(['id'=>$insert_data['resource_id']])->update($machine);
				break;
			case 7:
				$resource = DB::table('idc_memory')->where(['id'=>$insert_data['resource_id'],'memory_used'=>0])->select('id','memory_number','memory_param')->first();
				if(empty($resource)){
					DB::rollBack();
					$return['data'] = $resource;
					$return['code'] = 0;
					$return['msg'] = '(#108)所选择的内存资源不存在/已被使用/与要绑定的业务不在同一机房';
					return $return;
				}
				$insert['machine_sn'] = $resource->memory_number;
				$insert['resource'] = $resource->harddisk_param;
				//更新内存表的所属业务编号，资源状态和到期时间
				$machine['service_num'] = $business->business_number;
				$machine['memory_used'] = 1;
				$result = DB::table('idc_memory')->where(['id'=>$insert_data['resource_id']])->update($machine);
				break;
		}
		if($result == 0){
			DB::rollBack();
			$return['data'] = '';
        	$return['code'] = 0;
        	$return['msg'] = '(#109)资源添加失败';
        	return $return;
		}
		$insert['business_sn'] = $business->business_number;
		$resource_id = isset($insert_data['resource_id'])?$insert_data['resource_id']:mt_rand(1000,9999);
		$order_sn =$this->ordersn();
		$insert['order_sn'] = $order_sn;
		$insert['customer_id'] = $insert_data['customer_id'];
		$insert['customer_name'] =  $client;
		$insert['business_id'] = $insert_data['sales_id'];
		$insert['business_name'] = $sales->name?$sales->name:$sales->username;
		$insert['resource_type'] = $insert_data['resource_type'];
		$insert['price'] = $insert_data['price'];
		$insert['duration'] = $insert_data['duration'];
		$insert['payable_money'] = bcmul((string)$insert_data['price'],(string)$insert_data['duration'],2);//计算价格
		$insert['end_time'] = time_calculation(date('Y-m-d H:i:s',time()),$insert_data['duration'],'month');
		$insert['order_note'] = $insert_data['order_note'];
		$insert['created_at'] = date('Y-m-d H:i:s',time());
		$row = DB::table('tz_orders')->insertGetId($insert);
		if($row == false){
			// 资源订单生成失败
			DB::rollBack();
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#110)资源增加失败';
			return $return;
		}
		$xunsearch = new XS('orders');
	    $index = $xunsearch->index;
        $doc['id'] = strtolower($row);
		$doc['machine_sn'] = strtolower($insert['machine_sn']);
		$doc['business_sn'] = strtolower($insert['business_sn']);
		$doc['order_sn'] = strtolower($order_sn);
		$document = new \XSDocument($doc);
		$index->update($document);
		$index->flushIndex();
		DB::commit();
		$return['data'] = $order_sn;
		$return['code'] = 1;
		$return['msg'] = '资源增加成功，请提醒客户及时支付，订单号:'.$order_sn;
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
			        $pay['end_time'] = $order_array->end_time;
			        $pay['client_id'] = $order_array->client_id;
			        $pay['price'] = $order_array->price;
			        $pay['id'] = $order_array->id;
			        $pay['parent_business'] = $order_array->parent_business;
			        $pay_data = json_encode($pay);
			        $redis->set($pay_value,$pay_data);
			        $total = bcadd($total,bcmul($pay['price'],$pay['duration'],2),2);
			        if(isset($client_id) && empty($client_id)){
		            	$client_id = $pay['client_id'];
		            }
		   			if($client_id != $pay['client_id']){
						$orders = [];
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

	/**
	 * 获取更换的资源数据
	 * @param  array $get --order_id订单id，--resource_type--资源类型 --machineroom机房,--ip_company运营商
	 * @return [type]      [description]
	 */
	public function getResource($get){

		if(empty($get)){

			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#101)条件不足,无法进行相关操作';
			return $return;
		}

		if(!isset($get['resource_type'])){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#102)请确认数据无误';
			return $return;
		}

		if(!isset($get['order_id'])){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#103)请选择需要更换的资源';
			return $return;
		}

		/**
		 * 获取对应订单的数据
		 * @var [type]
		 */
		if(isset($get['parent_business'])){
			$order = DB::table('tz_cabinet_machine as machine')
						->join('tz_cabinet_machine_detail as detail','machine.id','=','detail.business_id')
						->where(['machine.id'=>$get['order_id']])
						->whereNull('machine.deleted_at')
						->whereBetween('machine.remove_status',[0,3])
						->select('detail as resource_detail','machine.id','resource_sn as machine_sn','resource_sn as resource','price','duration','endtime as end_time','resource_type','customer as customer_id')
						->first();

		} else {
			$order = DB::table('tz_orders')
		           ->join('tz_business','tz_orders.business_sn','=','tz_business.business_number')
		           ->where(['tz_orders.id'=>$get['order_id']])
		           ->whereNull('tz_orders.deleted_at')
		           ->whereBetween('tz_orders.remove_status',[0,3])
		           ->select('tz_business.resource_detail','tz_orders.id','tz_orders.order_sn','tz_orders.machine_sn','tz_orders.resource','tz_orders.price','tz_orders.duration','tz_orders.end_time','tz_orders.resource_type','tz_orders.customer_id')
		           ->first();
		}
		
		if(empty($order)){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#104)请确认需要更换的资源无误';
			return $return;
		}

		/**
		 * 获取业务所在机房
		 * @var [type]
		 */
		$resource_detail = json_decode($order->resource_detail);
		$machineroom = $resource_detail->machineroom_id;
		if($order->resource_type > 3){//当资源类型不是机器/机柜时
			
			if($get['resource_type'] != $order->resource_type){//资源类型与订单的资源类型不一致
				$return['data'] = [];
				$return['code'] = 0;
				$return['msg'] = '(#105)非法操作';
				return $return;
			}
			
		}
		if(!isset($get['parent_business'])){
			$machineroom = isset($get['machineroom'])?$get['machineroom']:$machineroom;
		}
		switch ($get['resource_type']) {//根据资源类型获取对应的可更换的资源数据
			case 1://租用机器
				$resource = DB::table('idc_machine')
							   ->leftjoin('idc_ips','idc_machine.ip_id','=','idc_ips.id')
							   ->leftjoin('idc_machineroom','idc_machine.machineroom','=','idc_machineroom.id')
							   ->leftjoin('idc_cabinet','idc_machine.cabinet','=','idc_cabinet.id')
							   ->where(['business_type'=>$get['resource_type'],'used_status'=>0,'machine_status'=>0,'machineroom'=>$machineroom])
							   ->whereNull('idc_machine.deleted_at')
							   ->get(['idc_machine.id','idc_machine.machine_num','idc_machine.cpu','idc_machine.memory','idc_machine.harddisk','idc_machine.cabinet','idc_machine.ip_id','idc_machine.machineroom','idc_machine.bandwidth','idc_machine.protect','idc_machine.loginname','idc_machine.loginpass','idc_machine.machine_type','idc_machineroom.id as machineroom_id','idc_machineroom.machine_room_name as machineroom_name','idc_cabinet.cabinet_id as cabinets','idc_ips.ip','idc_ips.ip_company']);
				break;
			case 2://托管机器
				$resource = DB::table('idc_machine')
							   ->join('tz_machine_customer','idc_machine.id','=','tz_machine_customer.machine_id')
							   ->leftjoin('idc_ips','idc_machine.ip_id','=','idc_ips.id')
							   ->leftjoin('idc_machineroom','idc_machine.machineroom','=','idc_machineroom.id')
							   ->leftjoin('idc_cabinet','idc_machine.cabinet','=','idc_cabinet.id')
							   ->where(['business_type'=>$get['resource_type'],'used_status'=>0,'machine_status'=>0,'machineroom'=>$machineroom,'customer_id'=>$order->customer_id])
							   ->whereNull('idc_machine.deleted_at')
							   ->whereNull('tz_machine_customer.deleted_at')
							   ->get(['idc_machine.id','idc_machine.machine_num','idc_machine.cpu','idc_machine.memory','idc_machine.harddisk','idc_machine.cabinet','idc_machine.ip_id','idc_machine.machineroom','idc_machine.bandwidth','idc_machine.protect','idc_machine.loginname','idc_machine.loginpass','idc_machine.machine_type','idc_machineroom.id as machineroom_id','idc_machineroom.machine_room_name as machineroom_name','idc_cabinet.cabinet_id as cabinets','idc_ips.ip','idc_ips.ip_company']);
				
				if(!$resource->isEmpty()){
					$ip_company = [0=>'电信',1=>'移动',2=>'联通',3=>'BGP',Null=>'未选择'];
					foreach($resource as $resource_key => $resource_value){
						$resource_value->ip = $resource_value->ip?$resource_value->ip:'0.0.0.0';
						$resource_value->ip_detail = $resource_value->ip.'('.$ip_company[$resource_value->ip_company].')';
						unset($resource_value->ip_company);
					}
				}
				break;
				
			case 3://租用机柜
				$resource = DB::table('idc_cabinet')
							   ->join('idc_machineroom','idc_cabinet.machineroom_id','=','idc_machineroom.id')
							   ->where(['idc_cabinet.machineroom_id'=>$machineroom])
							   ->whereNull('idc_cabinet.deleted_at')
							   ->get(['idc_cabinet.id','cabinet_id','idc_machineroom.id as machineroom_id','machine_room_name as machineroom_name']);
				break;
			case 4://IP
				$ip_company = isset($get['ip_company'])?$get['ip_company']:0;
				$resource = DB::table('idc_ips')
							  ->join('idc_machineroom','idc_ips.ip_comproom','=','idc_machineroom.id')
				              ->where(['ip_status'=>0,'ip_lock'=>0,'ip_comproom'=>$machineroom,'ip_company'=>$ip_company])
				              ->whereNull('idc_ips.deleted_at')
				              ->get(['idc_ips.id','ip','ip_company','idc_machineroom.id as machineroom_id','machine_room_name as machineroom_name']);
				break;
			case 5://CPU
				$resource = DB::table('idc_cpu')
							  ->join('idc_machineroom','idc_cpu.room_id','=','idc_machineroom.id')
				              ->where(['cpu_used'=>0,'room_id'=>$machineroom])
				              ->whereNull('idc_cpu.deleted_at')
				              ->get(['idc_cpu.id','cpu_number','cpu_param','idc_machineroom.id as machineroom_id','machine_room_name as machineroom_name']);
				break;
			case 6://硬盘
				$resource = DB::table('idc_harddisk')
 							  ->join('idc_machineroom','idc_harddisk.room_id','=','idc_machineroom.id')
				              ->where(['harddisk_used'=>0,'room_id'=>$machineroom])
				              ->whereNull('idc_harddisk.deleted_at')
				              ->get(['idc_harddisk.id','harddisk_number','harddisk_param','idc_machineroom.id as machineroom_id','machine_room_name as machineroom_name']);
				break;
			case 7://内存
				$resource = DB::table('idc_memory')
							  ->join('idc_machineroom','idc_memory.room_id','=','idc_machineroom.id')
				              ->where(['memory_used'=>0,'room_id'=>$machineroom])
				              ->whereNull('idc_memory.deleted_at')
				              ->get(['idc_memory.id','memory_number','memory_param','idc_machineroom.id as machineroom_id','machine_room_name as machineroom_name']);
				break;
			case 8:
			case 9:
				$resource = DB::table('idc_memory')
				              ->get(['id','memory_number','memory_param']);
			 	break;
		}
		if($resource->isEmpty()){
			$return['data'] = $resource;
			$return['code'] = 0;
			$return['msg'] = '无对应数据';
			return $return;
		} else {
			$return['data'] = $resource;
			$return['code'] = 1;
			$return['msg'] = '资源数据获取成功';
			return $return;
		}
	}

	/**
	 * 进行更换资源记录的生成及相关操作
	 * @param  array $change order_id--订单id，resource_type--资源类型, resource_id--更换为的资源id
	 * @return [type]         [description]
	 */
	public function changeResource($change){
		if(empty($change)){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#101)条件不足,无法进行相关操作';
			return $return;
		}
		if(!isset($change['order_id'])){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#102)需要更换的资源无法确定';
			return $return;
		}
		if(!isset($change['resource_type'])){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#103)请确认你需要更换的资源种类';
			return $return;
		}
		if(!isset($change['resource_id'])){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#104)更换的资源无法确定';
			return $return;
		}

		$changes = DB::table('tz_resource_change')
					->where(['business'=>$change['order_id']])
					->whereBetween('change_status',[0,2])
					->whereNull('deleted_at')
					->get();
		if(!$changes->isEmpty()){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#112)该订单资源存在更换未完成,不能重复提交,请等待完成后再申请';
			return $return;
		}

		/**
		 * 获取对应订单的数据
		 * @var [type]
		 */
		if(isset($change['parent_business'])){
			$order = DB::table('tz_cabinet_machine as machine')
						->join('tz_cabinet_machine_detail as detail','machine.id','=','detail.business_id')
						->where(['machine.id'=>$change['order_id']])
						->whereNull('machine.deleted_at')
						->whereBetween('machine.remove_status',[0,3])
						->select('detail as resource_detail','machine.id','business_number','resource_sn as machine_sn','resource_sn as resource','resource_type','customer as customer_id','sales as business_id')
						->first();
		} else {
			$order = DB::table('tz_orders')
		           ->join('tz_business','tz_orders.business_sn','=','tz_business.business_number')
		           ->where(['tz_orders.id'=>$change['order_id']])
		           ->whereNull('tz_orders.deleted_at')
		           ->whereBetween('tz_orders.remove_status',[0,3])
		           ->select('tz_business.resource_detail','tz_business.business_type','tz_business.business_number','tz_orders.resource_type','tz_orders.customer_id','tz_orders.business_id','tz_orders.resource','tz_orders.machine_sn','tz_orders.business_sn')
		           ->first();
		}
		
		if(empty($order)){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#105)请确认需要更换的资源无误';
			return $return;
		}
		/**
		 * 获取业务的所在机房，机柜，所绑定的机器IP
		 * @var [type]
		 */
		$resource_detail = json_decode($order->resource_detail);
		if($order->resource_type == 3){
			$cabinet = isset($resource_detail->cabinetid)?$resource_detail->cabinetid:0;
			$ip = 0;
		} else {
			$cabinet = isset($resource_detail->cabinet)?$resource_detail->cabinet:0;
			$ip = isset($resource_detail->ip_id)?$resource_detail->ip_id:0;
		}
		$machineroom = isset($resource_detail->machineroom_id)?$resource_detail->machineroom_id:0;
		
		/**
		 * 更换前的资源相关信息
		 */
		if($order->resource_type == 8 || $order->resource_type == 9){
			$change_data['before_resource_number'] = $order->resource;
		} else {
			$change_data['before_resource_number'] = $order->machine_sn;
		}
		
		$change_data['before_machineroom'] = $machineroom;
		$change_data['before_cabinet'] = $cabinet;
		$change_data['before_ip'] = $ip;
		$change_data['before_resource_type'] = $order->resource_type;

		$change_data['customer_id'] = $order->customer_id;
		$change_data['sales_id'] = $order->business_id;

		/**
		 * 进行对应要更换的资源锁定并生成更换记录表所需的字段数据
		 */
		DB::beginTransaction();
		switch ($change['resource_type']) {//根据资源类型进行更换资源的锁定并生成更换记录表所需的字段数据
			case 1:
			case 2:                      
				$resource = DB::table('idc_machine')
							   ->where(['id'=>$change['resource_id'],'business_type'=>$change['resource_type'],'used_status'=>0,'machine_status'=>0])
							   ->select('id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom') 
							   ->first();
				if(empty($resource)){
					$return['data'] = [];
					$return['code'] = 0;
					$return['msg'] = '(#106)资源可能已被使用,请更换';
					return $return;
				}
				$change_data['after_resource_number'] = $resource->machine_num;
				$change_data['after_machineroom'] = $resource->machineroom;
				$change_data['after_cabinet'] = $resource->cabinet;
				$change_data['after_ip'] = $resource->ip_id;
				$update = DB::table('idc_machine')
				            ->where(['id'=>$change['resource_id'],'business_type'=>$change['resource_type'],'used_status'=>0,'machine_status'=>0])
				            ->update(['used_status'=>1,'own_business'=>$order->business_number]);

				break;
			case 3:
				$resource = DB::table('idc_cabinet')
							  ->where(['id'=>$change['resource_id']])
							  ->select('id','cabinet_id','machineroom_id')
							  ->first();
				if(empty($resource)){
					$return['data'] = [];
					$return['code'] = 0;
					$return['msg'] = '(#107)所选资源不存在,请更换';
					return $return;
				}
				$change_data['after_resource_number'] = $resource->cabinet_id;
				$change_data['after_machineroom'] = $resource->machineroom_id;
				$change_data['after_cabinet'] = $resource->cabinet_id;
				$change_data['after_ip'] = 0;
				$update = 1;
				break;
			case 4://ip
				$resource = DB::table('idc_ips')
							->where(['ip_status'=>0,'ip_lock'=>0,'id'=>$change['resource_id']])
							->select('id','ip')
							->first();
				if(empty($resource)){
					$return['data'] = [];
					$return['code'] = 0;
					$return['msg'] = '(#108)所选资源不存在/已被使用,请更换';
					return $return;
				}
				$change_data['after_resource_number'] = $resource->ip;
				$change_data['after_machineroom'] = $machineroom;
				$change_data['after_cabinet'] = $cabinet;
				$change_data['after_ip'] = $ip;
				$update = DB::table('idc_ips')
							->where(['ip_status'=>0,'ip_lock'=>0,'id'=>$change['resource_id']])
							->update(['ip_lock'=>1,'own_business'=>$order->business_sn]);
				break;
			case 5://cpu
				$resource = DB::table('idc_cpu')
							  ->where(['cpu_used'=>0,'id'=>$change['resource_id']])
							  ->select('id','cpu_number')
							  ->first();
				if(empty($resource)){
					$return['data'] = [];
					$return['code'] = 0;
					$return['msg'] = '(#109)所选资源不存在/已被使用,请更换';
					return $return;
				}
				$change_data['after_resource_number'] = $resource->cpu_number;
				$change_data['after_machineroom'] = $machineroom;
				$change_data['after_cabinet'] = $cabinet;
				$change_data['after_ip'] = $ip;			  
				$update = DB::table('idc_cpu')
							->where(['cpu_used'=>0,'id'=>$change['resource_id']])
							->update(['cpu_used'=>1,'service_num'=>$order->business_sn]);
				break;
			case 6://硬盘
				$resource = DB::table('idc_harddisk')
							  ->where(['harddisk_used'=>0,'id'=>$change['resource_id']])
							  ->select('id','harddisk_number')
							  ->first();
				if(empty($resource)){
					$return['data'] = [];
					$return['code'] = 0;
					$return['msg'] = '(#109)所选资源不存在/已被使用,请更换';
					return $return;
				}
				$change_data['after_resource_number'] = $resource->harddisk_number;
				$change_data['after_machineroom'] = $machineroom;
				$change_data['after_cabinet'] = $cabinet;
				$change_data['after_ip'] = $ip;
				$update = DB::table('idc_harddisk')
							->where(['harddisk_used'=>0,'id'=>$change['resource_id']])
							->update(['harddisk_used'=>1,'service_num'=>$order->business_sn]);
				break;
			case 7://内存
				$resource = DB::table('idc_memory')
							  ->where(['memory_used'=>0,'id'=>$change['resource_id']])
							  ->select('id','memory_number')
							  ->first();
				if(empty($resource)){
					$return['data'] = [];
					$return['code'] = 0;
					$return['msg'] = '(#110)所选资源不存在/已被使用,请更换';
					return $return;
				}
				$change_data['after_resource_number'] = $resource->memory_number;
				$change_data['after_machineroom'] = $machineroom;
				$change_data['after_cabinet'] = $cabinet;
				$change_data['after_ip'] = $ip;
				$update = DB::table('idc_memory')
							->where(['memory_used'=>0,'id'=>$change['resource_id']])
							->update(['memory_used'=>1,'service_num'=>$order->business_sn]);
				break;
			case 8://带宽
			case 9://防护
				$change_data['after_resource_number'] = $change['resource_id'];
				$change_data['after_machineroom'] = $machineroom;
				$change_data['after_cabinet'] = $cabinet;
				$change_data['after_ip'] = $ip;
				$update = 1;
				break;
			default:
				$update = 1;
				break;
		}
		if($update == 0){
			DB::rollBack();
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#111)资源更换失败';
			return $return;
		}
		$change_data['after_resource_type'] = $change['resource_type'];
		$change_data['change_number'] = create_number();
		$change_data['created_at'] = date('Y-m-d H:i:s',time());
		$change_data['change_reason'] = $change['change_reason'];
		$change_data['business'] = $change['order_id'];
		if(isset($change['parent_business'])){
			$change_data['parent_business'] = $change['parent_business'];
		}
		$result = DB::table('tz_resource_change')->insert($change_data);
		if($result == 0){
			DB::rollBack();
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#112)资源更换失败';
			return $return;
		} else {
			DB::commit();
			$return['data'] = [];
			$return['code'] = 1;
			$return['msg'] = '资源更换成功,请在资源更换后注意其他绑定资源的机房一致';
			return $return;
		}

	}

	/**
	 * 对更换记录进行审核操作
	 * @param  array $check --change_id更换记录id,--change_status更换记录审核状态(1-通过/-1-不通过),--chenck_note审核不通过时的备注
	 * @return [type]        [description]
	 */
	public function checkChange($check){
		if(empty($check)){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#101)条件不足,无法进行审核操作';
			return $return;
		}

		if(!isset($check['change_id'])){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#102)请确认你要审核的记录';
			return $return;
		}

		/**
		 * 审核前获取对应的更换记录数据
		 * @var [type]
		 */
		$change = DB::table('tz_resource_change')
		            ->where(['id'=>$check['change_id']])
		            ->whereNull('deleted_at')
		            ->select('id','business','change_number','change_status','before_resource_type','before_resource_number','after_resource_type','after_resource_number','customer_id','parent_business')
		            ->first();
		if(empty($change)){
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#103)无对应的更换记录';
			return $return;
		}

		/**
		 * 获取原订单的数据
		 * @var [type]
		 */
		if($change->parent_business != 0){
			$order = DB::table('tz_cabinet_machine')
						->where(['id'=>$change->business])
						->whereBetween('remove_status',[0,3])
						->select('id','business_number as business_sn','resource_sn as machine_sn','endtime as end_time')
						->first();
		} else {
			$order = DB::table('tz_orders')
					->where(['id'=>$change->business])
					->whereBetween('remove_status',[0,3])
					->select('id','business_sn','order_sn','machine_sn','end_time')
					->first();
		}
		
		if(empty($order)){
			
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#104)无对应的资源订单';
			return $return;
		}

		/**
		 * 根据不同的情况进行审核操作
		 */
		DB::beginTransaction();
		if ($change->change_status == 0){//更换资源记录为待审核状态
			$check_note = isset($check['check_note'])?$check['check_note']:'';
			$change_status = isset($check['change_status'])?$check['change_status']:0;
			if($change_status == '-1'){//审核不通过时，对前期锁定的资源进行复位
				switch ($change->after_resource_type) {
					case 1:
					case 2:
						$after_update = DB::table('idc_machine')
									      ->where(['machine_num'=>$change->after_resource_number,'own_business'=>$order->business_sn])
									      ->update(['own_business'=>'','business_end'=>NULL,'used_status'=>0]);
						break;

					case 4://ip
						$after_update = DB::table('idc_ips')
									      ->where(['ip'=>$change->after_resource_number,'own_business'=>$order->business_sn])
									      ->update(['own_business'=>'','business_end'=>NULL,'ip_status'=>0,'ip_lock'=>0]);
						break;

					case 5://cpu
						$after_update = DB::table('idc_cpu')
									      ->where(['cpu_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
									      ->update(['service_num'=>'','business_end'=>NULL,'cpu_used'=>0]);
						break;

					case 6://硬盘
						$after_update = DB::table('idc_harddisk')
									      ->where(['harddisk_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
									      ->update(['service_num'=>'','business_end'=>NULL,'harddisk_used'=>0]);
						break;

					case 7://内存
						$after_update = DB::table('idc_memory')
									      ->where(['memory_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
									      ->update(['service_num'=>'','business_end'=>NULL,'memory_used'=>0]);
						break;

					default:
						$after_update = 1;
						break;

				}

				if($after_update == 0){
					DB::rollBack();
					$return['data'] = [];
					$return['code'] = 0;
					$return['msg'] = '(#105)审核失败';
					return $return;
				}
				$update = DB::table('tz_resource_change')
			            ->where(['id'=>$check['change_id']])
			            ->update(['change_status'=>$change_status,'check_note'=>$check_note,'updated_at'=>date('Y-m-d H:i:s',time()),'change_time'=>date('Y-m-d H:i:s',time())]);
			} else {//审核通过时直接更改记录单状态，进入下一环节
				$update = DB::table('tz_resource_change')
			            ->where(['id'=>$check['change_id']])
			            ->update(['change_status'=>$change_status,'check_note'=>$check_note,'updated_at'=>date('Y-m-d H:i:s',time())]);
			}
			

		} elseif ($change->change_status == 1){//当记录单为审核通过时，进行下一环节机房的处理

			$update = DB::table('tz_resource_change')
			            ->where(['id'=>$check['change_id']])
			            ->update(['change_status'=>2,'updated_at'=>date('Y-m-d H:i:s',time())]);

		} elseif ($change->change_status == 2){//当记录单已经为机房处理时，进行记录单的完成状态改变
			
			switch ($change->before_resource_type) {//根据更换前的资源类型对更换前的资源进行对应的解除使用状态
				case 1://租用机器
				case 2://托管机器
					$before = DB::table('idc_machine')
								->where(['machine_num'=>$change->before_resource_number,'own_business'=>$order->business_sn])
								->update(['own_business'=>'','business_end'=>NULL,'used_status'=>0]);
					break;

				case 3://租用机柜
					$cabinet = DB::table('idc_cabinet')->where(['cabinet_id' => $change->before_resource_number])->select('own_business')->first();//获取机柜原来的业务号
                    if (!empty($cabinet)) {
                        $array = explode(',', $cabinet->own_business);//先将原本的业务数据转换为数组
                    } else {
                        $array = [];
                    }
                    $key = array_search($order->business_sn, $array);//查找要删除的业务编号在数组的位置的键
                    array_splice($array, $key, 1);//根据查找的对应键进行删除
                    $own_business = implode(',', $array);//将数组转换为字符串
                    $before = DB::table('idc_cabinet')->where(['cabinet_id' => $change->before_resource_number])->update(['own_business'=>$own_business]);
					break;

				case 4://ip
					$before = DB::table('idc_ips')
								->where(['ip'=>$change->before_resource_number,'own_business'=>$order->business_sn])
								->update(['own_business'=>'','business_end'=>NULL,'ip_status'=>0]);
					break;

				case 5://cpu
					$before = DB::table('idc_cpu')
								->where(['cpu_number'=>$change->before_resource_number,'service_num'=>$order->business_sn])
								->update(['service_num'=>'','business_end'=>NULL,'cpu_used'=>0]);
					break;

				case 6://硬盘
					$before = DB::table('idc_harddisk')
								->where(['harddisk_number'=>$change->before_resource_number,'service_num'=>$order->business_sn])
								->update(['service_num'=>'','business_end'=>NULL,'harddisk_used'=>0]);
					break;

				case 7://内存
					$before = DB::table('idc_memory')
								->where(['memory_number'=>$change->before_resource_number,'service_num'=>$order->business_sn])
								->update(['service_num'=>'','business_end'=>NULL,'memory_used'=>0]);
					break;

				default:
					$before = 1;
					break;
			}
			if($before == 0){//更换前的资源复位失败，操作直接失败，事物回滚并返回
				DB::rollBack();
				$return['data'] = [];
				$return['code'] = 0;
				$return['msg'] = '(#106)更换资源审核操作失败';
				return $return;
			}
			switch ($change->after_resource_type) {//根据更换后的资源类型对相对应的更换后的资源进行使用锁定，并对相对应的订单/业务的数据进行更新
				case 1://租用机器
				case 2://托管机器
					/**
					 * 获取租用/托管机器的数据，判断是否存在该机器
					 * @var [type]
					 */
					$resource = get_object_vars(DB::table('idc_machine')
							   ->leftjoin('idc_ips','idc_machine.ip_id','=','idc_ips.id')
							   ->leftjoin('idc_machineroom','idc_machine.machineroom','=','idc_machineroom.id')
							   ->leftjoin('idc_cabinet','idc_machine.cabinet','=','idc_cabinet.id')
							   ->where(['machine_num'=>$change->after_resource_number,'idc_machine.own_business'=>$order->business_sn])
							   ->select('idc_machine.id','idc_machine.machine_num','idc_machine.cpu','idc_machine.memory','idc_machine.harddisk','idc_machine.cabinet','idc_machine.ip_id','idc_machine.machineroom','idc_machine.bandwidth','idc_machine.protect','idc_machine.loginname','idc_machine.loginpass','idc_machine.machine_type','idc_machineroom.id as machineroom_id','idc_machineroom.machine_room_name as machineroom_name','idc_cabinet.cabinet_id as cabinets','idc_ips.ip','idc_ips.ip_company')
							   ->first());	
					if(empty($resource)){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#107)无对应的资源可更换';
						return $return;
					}
					$ip_company = [0=>'电信',1=>'移动',2=>'联通',3=>'BGP',Null=>'未选择'];
					$resource['ip'] = $resource['ip']?$resource['ip']:'0.0.0.0';
					$resource['ip_detail'] = $resource['ip'].'('.$ip_company[$resource['ip_company']].')';
					unset($resource['ip_company']);
					/**
					 * 进行业务绑定的机器数据进行相对应的更新
					 * @var [type]
					 */
					if($change->parent_business != 0){
						$business_update = DB::table('tz_cabinet_machine')
												->where(['id'=>$order->id])
												->update(['resource_sn'=>$resource['machine_num'],'resource_id'=>$resource['id'],'resource_type'=>$change->after_resource_type]);
					} else {
						$business_update = DB::table('tz_business')
										->where(['business_number'=>$order->business_sn])
										->update(['machine_number'=>$resource['machine_num'],'resource_detail'=>json_encode($resource),'business_type'=>$change->after_resource_type]);
					}
					
					if($business_update == 0){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#108)资源更换失败';
						return $return;
					}
					/**
					 * 对应的订单数据进行更新
					 * @var [type]
					 */
					if($change->parent_business != 0){
						$order_update = DB::table('tz_cabinet_machine_detail')->where(['business_id'=>$order->id])->update(['detail'=>json_encode($resource)]);
					} else {
						$order_update = DB::table('tz_orders')
									  ->where(['id'=>$change->business])
									  ->update(['machine_sn'=>$resource['machine_num'],'resource'=>$resource['machine_num'],'resource_type'=>$change->after_resource_type]);
					}
					
					if($order_update == 0){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#109)资源更换失败';
						return $return;
					}
					/**
					 * 对应机器进行使用锁定
					 * @var [type]
					 */
					$after = DB::table('idc_machine')
								->where(['machine_num'=>$change->after_resource_number,'own_business'=>$order->business_sn])
								->update(['business_end'=>$order->end_time,'used_status'=>2]);
					/**
					 * 更新进对应的索引文件
					 * @var XS
					 */
					$xunsearch = new XS('business');
		            $index = $xunsearch->index;
		            $doc['ip'] = isset($resource['ip'])?strtolower($resource['ip']):'';
		            $doc['cpu'] = isset($resource['cpu'])?strtolower($resource['cpu']):'';
		            $doc['memory'] = isset($resource['memory'])?strtolower($resource['memory']):'';
		            $doc['harddisk'] = isset($resource['harddisk'])?strtolower($resource['harddisk']):'';
		            $doc['id'] = strtolower($order->id);
		            $doc['business_sn'] = strtolower($order->business_sn);
		            $doc['machine_number'] = strtolower($resource['machine_num']);
		            $doc['client'] = strtolower($change->customer_id);
		            $document = new \XSDocument($doc);
					break;
				case 3://租用机柜
					/**
					 * 是否存在该机柜
					 * @var [type]
					 */
					$cabinet = get_object_vars(DB::table('idc_cabinet')
								 ->join('idc_machineroom','idc_cabinet.machineroom_id','=','idc_machineroom.id')
					             ->where(['cabinet_id'=>$change->after_resource_number])
					             ->select('idc_cabinet.id as cabinetid','idc_cabinet.cabinet_id','idc_cabinet.machineroom_id','idc_machineroom.machine_room_name as machineroom_name','idc_cabinet.own_business')
					             ->first());
		            if(empty($cabinet)){
		            	DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#110)无对应资源更换';
						return $return;
		            }
		            $cabinet['id'] = $cabinet['cabinet_id'];
		            $own_business = trim($cabinet['own_business'].','.$order->business_sn,' '.',');
		            unset($cabinet['own_business']);
		            /**
		             * 对应机柜数据更新进对应的业务单
		             * @var [type]
		             */
		            $business_update = DB::table('tz_business')
										->where(['business_number'=>$order->business_sn])
										->update(['machine_number'=>$cabinet['cabinet_id'],'resource_detail'=>json_encode($cabinet),'business_type'=>$change->after_resource_type]);
					if($business_update == 0){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#111)资源更换失败';
						return $return;
					}
					/**
					 * 对应机柜数据更新进订单
					 * @var [type]
					 */
					$order_update = DB::table('tz_orders')
									  ->where(['id'=>$change->business])
									  ->update(['machine_sn'=>$cabinet['cabinet_id'],'resource'=>$cabinet['cabinet_id'],'resource_type'=>$change->after_resource_type]);
					if($order_update == 0){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#112)资源更换失败';
						return $return;
					}
					/**
					 * 更新对应机柜的使用状态
					 * @var [type]
					 */
		            $after = DB::table('idc_cabinet')->where(['cabinet_id'=>$change->after_resource_number])->update(['own_business'=>$own_business]);
		            /**
		             * 更新进对应的索引文件
		             * @var XS
		             */
		            $xunsearch = new XS('business');
		            $index = $xunsearch->index;
		            $doc['id'] = strtolower($order->id);
		            $doc['business_sn'] = strtolower($order->business_sn);
		            $doc['machine_number'] = strtolower($cabinet['cabinet_id']);
		            $doc['client'] = strtolower($change->customer_id);
		            $document = new \XSDocument($doc);
					break;
				case 4://ip
					/**
					 * 是否存在IP
					 * @var [type]
					 */
					$ip = DB::table('idc_ips')
							->where(['ip'=>$change->after_resource_number,'own_business'=>$order->business_sn])
							->select('ip','ip_company')
							->first();
					if(empty($ip)){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#113)无对应的IP资源';
						return $return;
					}
					$ip_company = [0=>'电信公司',1=>'移动公司',2=>'联通公司',3=>'BGP'];
					$ip_detail = $ip->ip.$ip_company[$ip->ip_company];
					/**
					 * 更新进对应订单
					 * @var [type]
					 */
					$order_update = DB::table('tz_orders')
									  ->where(['id'=>$change->business])
									  ->update(['machine_sn'=>$ip->ip,'resource'=>$ip_detail,'resource_type'=>$change->after_resource_type]);
					if($order_update == 0){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#114)资源更换失败';
						return $return;
					}
					/**
					 * 对应资源进行使用锁定
					 * @var [type]
					 */
					$after = DB::table('idc_ips')
							->where(['ip'=>$change->after_resource_number,'own_business'=>$order->business_sn])
							->update(['ip_status'=>1,'ip_lock'=>0,'business_end'=>$order->end_time]);
					/**
					 * 更新进对应的索引文件
					 * @var XS
					 */
					$xunsearch = new XS('orders');
		    		$index = $xunsearch->index;
		            $doc['id'] = strtolower($order->id);
					$doc['machine_sn'] = strtolower($ip->ip);
					$doc['business_sn'] = strtolower($order->business_sn);
					$doc['order_sn'] = strtolower($order->order_sn);
		    		$document = new \XSDocument($doc);
					break;
				case 5://cpu
					/**
					 * 查找对应的资源是否存在
					 * @var [type]
					 */
					$cpu = DB::table('idc_cpu')
							 ->where(['cpu_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
							 ->select('cpu_number','cpu_param')
							 ->first();
					if(empty($cpu)){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#115)无对应的CPU资源';
						return $return;
					}
					/**
					 * 将对应的资源信息更进对应的订单
					 * @var [type]
					 */
					$order_update = DB::table('tz_orders')
									  ->where(['id'=>$change->business])
									  ->update(['machine_sn'=>$cpu->cpu_number,'resource'=>$cpu->cpu_param,'resource_type'=>$change->after_resource_type]);
					if($order_update == 0){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#116)资源更换失败';
						return $return;
					}
					/**
					 * 锁定对应资源的使用状态
					 * @var [type]
					 */
					$after = DB::table('idc_cpu')
							   ->where(['cpu_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
							   ->update(['cpu_used'=>1,'business_end'=>$order->end_time]);
					/**
					 * 更进对应的索引文件
					 * @var XS
					 */
					$xunsearch = new XS('orders');
		    		$index = $xunsearch->index;
		            $doc['id'] = strtolower($order->id);
					$doc['machine_sn'] = strtolower($cpu->cpu_number);
					$doc['business_sn'] = strtolower($order->business_sn);
					$doc['order_sn'] = strtolower($order->order_sn);
		    		$document = new \XSDocument($doc);
					break;
				case 6://硬盘
					/**
					 * 查找对应的资源是否存在
					 * @var [type]
					 */
					$harddisk = DB::table('idc_harddisk')
							 ->where(['harddisk_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
							 ->select('harddisk_number','harddisk_param')
							 ->first();
					if(empty($harddisk)){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#117)无对应的硬盘资源';
						return $return;
					}
					/**
					 * 将对应的资源信息更进对应的订单
					 * @var [type]
					 */
					$order_update = DB::table('tz_orders')
									  ->where(['id'=>$change->business])
									  ->update(['machine_sn'=>$harddisk->harddisk_number,'resource'=>$harddisk->harddisk_param,'resource_type'=>$change->after_resource_type]);
					if($order_update == 0){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#118)资源更换失败';
						return $return;
					}
					/**
					 * 锁定对应资源的使用状态
					 * @var [type]
					 */
					$after = DB::table('idc_harddisk')
							   ->where(['harddisk_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
							   ->update(['harddisk_used'=>1,'business_end'=>$order->end_time]);
					/**
					 * 更进对应的索引文件
					 * @var XS
					 */
					$xunsearch = new XS('orders');
		    		$index = $xunsearch->index;
		            $doc['id'] = strtolower($order->id);
					$doc['machine_sn'] = strtolower($harddisk->harddisk_number);
					$doc['business_sn'] = strtolower($order->business_sn);
					$doc['order_sn'] = strtolower($order->order_sn);
		    		$document = new \XSDocument($doc);
					break;
				case 7://内存
					/**
					 * 查找对应的资源是否存在
					 * @var [type]
					 */
					$memory = DB::table('idc_memory')
							 ->where(['memory_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
							 ->select('memory_number','memory_param')
							 ->first();
					if(empty($memory)){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#119)无对应的内存资源';
						return $return;
					}
					/**
					 * 将对应的资源信息更进对应的订单
					 * @var [type]
					 */
					$order_update = DB::table('tz_orders')
									  ->where(['id'=>$change->business])
									  ->update(['machine_sn'=>$memory->memory_number,'resource'=>$memory->memory_param,'resource_type'=>$change->after_resource_type]);
					if($order_update == 0){
						DB::rollBack();
						$return['data'] = [];
						$return['code'] = 0;
						$return['msg'] = '(#120)资源更换失败';
						return $return;
					}
					/**
					 * 锁定对应资源的使用状态
					 * @var [type]
					 */
					$after = DB::table('idc_memory')
							   ->where(['memory_number'=>$change->after_resource_number,'service_num'=>$order->business_sn])
							   ->update(['memory_used'=>1,'business_end'=>$order->end_time]);
					/**
					 * 更进对应的索引文件
					 * @var XS
					 */
					$xunsearch = new XS('orders');
		    		$index = $xunsearch->index;
		            $doc['id'] = strtolower($order->id);
					$doc['machine_sn'] = strtolower($memory->memory_number);
					$doc['business_sn'] = strtolower($order->business_sn);
					$doc['order_sn'] = strtolower($order->order_sn);
		    		$document = new \XSDocument($doc);
					break;
				case 8://带宽
					/**
					 * 将对应的资源信息更进对应的订单
					 * @var [type]
					 */
					$after = DB::table('tz_orders')
									  ->where(['id'=>$change->business])
									  ->update(['resource'=>$change->after_resource_number,'resource_type'=>$change->after_resource_type]);
					$xunsearch = new XS('orders');
		    		$index = $xunsearch->index;
		    		$doc['id'] = strtolower($order->id);
		    		$document = new \XSDocument($doc);
					break;
				case 9://防护
					/**
					 * 将对应的资源信息更进对应的订单
					 * @var [type]
					 */
					$after = DB::table('tz_orders')
									  ->where(['id'=>$change->business])
									  ->update(['resource'=>$change->after_resource_number,'resource_type'=>$change->after_resource_type]);
					$xunsearch = new XS('orders');
		    		$index = $xunsearch->index;
		    		$doc['id'] = strtolower($order->id);
		    		$document = new \XSDocument($doc);
					break;
			}
			if($after == 0){
				DB::rollBack();
				$return['data'] = [];
				$return['code'] = 0;
				$return['msg'] = '(#121)资源更换失败';
				return $return;
			}

			/**
			 * 对应的记录单状态进行更新
			 * @var [type]
			 */
			$update = DB::table('tz_resource_change')
			            ->where(['id'=>$check['change_id']])
			            ->update(['change_status'=>3,'change_time'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())]);

		} else {

			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#122)此更换记录已完成/不通过,无法再操作';
			return $return;

		}

		if($update != 0){
			if($change->change_status == 2){
				$index->update($document);
    			$index->flushIndex();
			}
			
			DB::commit();
			$return['data'] = [];
			$return['code'] = 1;
			$return['msg'] = '资源更换审核操作成功';
			
		}  else {
			DB::rollBack();
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#123)更换资源审核操作失败';
		}
		return $return;
	}

	/**
	 * 获取更换申请记录表
	 * @return [type] [description]
	 */
	public function getChange($data){
		$where = [];
		$orwhere = [];
		if(Admin::user()->inRoles(['salesman'])){//业务员根据业务员id进行对应数据的获取
			$where = ['sales_id'=>Admin::user()->id];
			if(Admin::user()->inRoles(['CMO'])){
				$where = [];
			}
		} elseif(Admin::user()->inRoles(['operations'])){//运维根据所在机房获取
			$depart = DB::table('oa_staff')
						->join('idc_machineroom','oa_staff.department','=','idc_machineroom.list_order')
						->where(['admin_users_id'=>Admin::user()->id])
						->value('idc_machineroom.id');
			$where = ['before_machineroom'=>$depart];
			$orwhere = ['after_machineroom'=>$depart];
		}
		if(isset($data['order_id'])){//根据订单id获取
			$where['business'] = $data['order_id'];
		}

		/**
		 * 获取对应的更换记录单
		 * @var [type]
		 */
		$change = DB::table('tz_resource_change as change')
					->leftjoin('tz_users as user','change.customer_id','=','user.id')
					->leftjoin('admin_users as admin','change.sales_id','=','admin.id')
					->where($where)
					->orWhere($orwhere)
					->whereNull('change.deleted_at')
					->get(['change.id','change.change_number','change.before_resource_type','change.parent_business','change.business','change.before_resource_number','change.before_machineroom','change.before_cabinet','change.before_ip','change.after_resource_type','change.after_resource_number','change.after_machineroom','change.after_cabinet','change.after_ip','change.sales_id','change.customer_id','change.change_time','change.change_status','change.change_reason','change.check_note','change.created_at','change.parent_business','admin.name as sales_name','user.nickname as customer_name']);
		
		$change = $change->map(function($item,$key){
			if($item->parent_business != 0){
				$item->business_sn = DB::table('tz_cabinet_machine')->where(['id'=>$item->business])->value('business_number');
			} else {
				$order = DB::table('tz_orders')->where(['id'=>$item->business])->select('business_sn','order_sn')->first();
				$item->business_sn = $order->business_sn;
				$item->order_sn = $order->order_sn;
			}
			$item->before_machineroom_name = DB::table('idc_machineroom')->where(['id'=>$item->before_machineroom])->value('machine_room_name');
			$item->after_machineroom_name = DB::table('idc_machineroom')->where(['id'=>$item->after_machineroom])->value('machine_room_name');
			$item->before_cabinet_name = DB::table('idc_cabinet')->where(['id'=>$item->before_cabinet])->value('cabinet_id');
			$item->after_cabinet_name = DB::table('idc_cabinet')->where(['id'=>$item->after_cabinet])->value('cabinet_id');
			$item->before_ip_detail = DB::table('idc_ips')->where(['id'=>$item->before_ip])->value('ip');
			$item->after_ip_detail = DB::table('idc_ips')->where(['id'=>$item->after_ip])->value('ip');
			$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP',12=>'流量叠加包'];
			$item->before_type = $resource_type[$item->before_resource_type];
			$item->after_type = $resource_type[$item->after_resource_type];
			$status = ['-1'=>'审核不通过',0=>'待审核',1=>'待更换',2=>'机房处理中',3=>'完成'];
			$item->status = $status[$item->change_status];
			return $item; 
		});
		
		$return['data'] = $change;
		$return['code'] = 1;
		$return['msg'] = '数据获取成功';
		return $return;
	}

	/**
	 * 修改订单的价格/到期时间
	 * @param  array $update --id订单id,--price单价,--end_time到期时间
	 * @return [type]         [description]
	 */
	public function updateOrders($update){
		if(empty($update)){//没有传递任何参数的时候
			$return['code'] = 0;
			$return['msg'] = '(#101)无法修改订单相关信息';
			return $return;
		}

		if(!isset($update['id'])){//没有传递订单id的时候
			$return['code'] = 0;
			$return['msg'] = '(#102)无法找到订单相关信息';
			return $return;
		}

		if(isset($update['end_time'])){//传递了到期时间戳
			$end_time = date('Y-m-d H:i:s',$update['end_time']);
		}

		/**
		 * 根据订单id查找是否存在对应的订单
		 * @var [type]
		 */
		$order = $this->whereBetween('order_status',[0,3])
					->whereBetween('remove_status',[0,3])
				    ->select('id','price','end_time','resource_type','business_sn','order_status','duration','payable_money')
				    ->find($update['id']);
		if(empty($order)){
			$return['code'] = 0;
			$return['msg'] = '(#103)查无此订单信息,请确认';
			return $return;
		}

		/**
		 * 当价格和到期时间跟原数据相同时，直接不修改
		 * @var [type]
		 */
		if(isset($update['price']) && isset($end_time) && $update['price'] == $order->price && $end_time == $order->end_time){
			$return['code'] = 0;
			$return['msg'] = '(#104)无需更改订单信息';
			return $return;
		}

		DB::beginTransaction();
		if($order->resource_type < 4){//当类型是租用/托管主机/租用机柜时同时需要修改业务的相关单价和到期时间
			$business = DB::table('tz_business')
							->where(['business_number'=>$order->business_sn])
							->whereBetween('remove_status',[0,3])
							->whereNull('deleted_at')
							->select('id','business_number')
							->first();
			if(empty($business)){//不存在对应的业务
				$return['code'] = 0;
				$return['msg'] = '(#105)查无此订单信息,请确认';
				return $return;
			}
			$row = DB::table('tz_business')
					->where(['business_number'=>$order->business_sn])
					->update(['money'=>$update['price'],'endding_time'=>$end_time]);
			if($row == 0){//更新相关业务信息失败
				DB::rollBack();
				$return['code'] = 0;
				$return['msg'] = '(#106)修改订单信息失败';
				return $return;
			}
		}

		if($order->order_status == 0){
			$update['payable_money'] = bcmul($update['price'],$order->duration,2);
		} else {
			$update['payable_money'] = $order->payable_money;
		}
		$update['end_time'] = $end_time;
		$update = DB::table('tz_orders')
					->where(['id'=>$update['id']])
					->update($update);
		if($update == 0){//更新对应的订单信息失败
			DB::rollBack();
			$return['code'] = 0;
			$return['msg'] = '(#107)修改订单信息失败';
			
		} else {//更新对应的订单信息成功
			DB::commit();
			$return['code'] = 1;
			$return['msg'] = '修改订单信息成功';	
		}
		return $return;
	} 

	public function showOrderDetail($order_sn)
	{

		$order = $this->where('order_sn' , $order_sn)->first( ['business_sn','resource_type' , 'machine_sn' , 'price' , 'duration' ,'end_time' ,'pay_time','resource'] );

		if (!$order) {
			return [
				'data'	=> [],
				'msg'	=> '获取订单信息失败',
				'code'	=> 0,
			];
		}else{
			$order = $order->toArray();
		}
		$detail = [];
		//资源的类型(1.租用主机，2.托管主机，3.租用机柜，4.IP，5.CPU，6.硬盘，7.内存，8.带宽，9.防护，10.cdn , 11.高防IP ; 12.流量叠加包 )
		$detail['type'] = $order['resource_type'];
		if (in_array($order['resource_type'], [ 1,2,3,4,5,6,7,8,9]) ) {
			$business = DB::table('tz_business')
						->where('business_number' , $order['business_sn'])
						->first(['resource_detail']);
			if ($business == null) {
				return [
					'data'	=> [],
					'msg'	=> '获取详细信息失败',
					'code'	=> 0,
				];
			}
			$business = json_decode($business->resource_detail , true);
			if ($order['resource_type'] != 3) {
				$detail['machine_num'] 		= $business['machine_num'];
				$detail['machine_type'] 		= $business['machine_type'];
			}
			
			$detail['machineroom'] 		= $business['machineroom_name'];
		}

		switch ($order['resource_type']) {
			case '1':
			case '2':
				if ($order['resource_type'] == 1) {
					$detail['resource_type'] = '租用主机';
				}elseif ($order['resource_type'] == 2) {
					$detail['resource_type'] = '托管主机';
				}
				$detail['resource'] 		= [
					'cpu'			=> $business['cpu'],
					'memory'		=> $business['memory'],
					'harddisk'		=> $business['harddisk'],
					'bandwidth'		=> $business['bandwidth'],
					'protect'		=> $business['protect'],
					'machine_type'		=> $business['machine_type'],
				];	
				break;
			case '3':
				$detail['resource_type'] 		= '租用机柜';
				$detail['resource'] 		= $business['cabinet_id'];
				break;
			case '4':
				$detail['resource_type'] 		= 'IP';
				$detail['resource'] 		= $order['resource'];
				break;
			case '5':
				$detail['resource_type'] 		= 'CPU';
				$detail['resource'] 		= $order['resource'];
				break;
			case '6':
				$detail['resource_type'] 		= '硬盘';
				$detail['resource'] 		= $order['resource'];
				break;
			case '7':
				$detail['resource_type'] 		= '内存';
				$detail['resource'] 		= $order['resource'];
				break;
			case '8':
				$detail['resource_type'] 		= '带宽';
				$detail['resource'] 		= $order['resource'];
				break;
			case '9':
				$detail['resource_type'] 		= '防护';
				$detail['resource'] 		= $order['resource'];
				break;
			case '10':
				$detail['resource_type'] 		= 'CDN';
				$detail['resource'] 		= $order['resource'];
				break;
			case '11':
				$detail['resource_type'] 		= '高防IP';
				$package = DB::table('tz_defenseip_package as a')
						->leftJoin('idc_machineroom as b' , 'b.id' , '=' , 'a.site')
						->where('a.id',$order['machine_sn'])
						->first(['a.name' , 'a.description' , 'a.protection_value' , 'b.machine_room_name']);
				if ($package == null) {
					$detail['resource'] 	= [
						'name'			=> '获取高防信息失败',
						'description'		=> '获取高防信息失败',
						'protection_value'	=> '获取高防信息失败',
					];
					$detail['machineroom'] 	= '';
				}else{
					$detail['resource'] 	= [
						'name'			=> $package->name,
						'description'		=> $package->description,
						'protection_value'	=> $package->protection_value.'G',
					];
				
					$detail['machineroom'] 		= $package->machine_room_name;
				}
				break;
			case '12':
				$detail['resource_type'] 		= '流量叠加包';
				$package = DB::table('tz_overlay as a')
					->leftJoin('idc_machineroom as b' , 'b.id' , '=' , 'a.site')
					->where('a.id',$order['machine_sn'])
					->first(['a.name' , 'a.description' , 'b.machine_room_name']);
				if ($package == null) {
					$detail['resource'] 	= [
						'name'			=> '获取叠加包信息失败',
						'description'		=> '获取叠加包信息失败',
						'protection_value'	=> '获取叠加包信息失败',
					];
					$detail['machineroom'] 	= '';
				}else{
					$detail['resource'] 	= [
						'name'			=> $package->name,
						'description'		=> $package->description,
						'protection_value'	=> $package->protection_value.'G',
					];
					$detail['machineroom'] 		= $package->machine_room_name;

				}
				break;

			default:
				# code...
				break;
		}
		$detail['price'] 			= $order['price'];
		$detail['duration'] 		= $order['duration'];
		$detail['end_time'] 		= $order['end_time'];
		$detail['pay_time'] 		= $order['pay_time'];

		return [
			'data'	=> $detail,
			'msg'	=> '获取订单信息成功',
			'code'	=> 1,
		];
	}
}
