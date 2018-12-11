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
						->select('tz_business.business_number','tz_business.endding_time','tz_orders.order_sn','tz_orders.machine_sn','tz_orders.end_time','tz_orders.order_status','tz_orders.resource_type','tz_orders.duration','tz_orders.created_at')
						->first();
		// 不存在需要删除的数据，直接返回
		if(!$delete_data){
			$return['code'] = 0;
			$return['msg'] = '无对应的订单数据/已删除!';
			return $return;
		}
		if($delete_data->order_status == 5){//当订单为取消时，无须再次操作
			$return['code'] = 0;
			$return['msg'] = '订单已取消，无须再次操作!';
			return $return;
		}
		$created_at = Carbon::parse($delete_data->created_at)->addDays(7)->toDateTimeString();//获取订单创建7天后的时间
		$now = Carbon::now()->toDateTimeString();//获取当前时间
		if($now > $created_at){//当前时间如果大于订单创建后的七天时间，代表订单已超过7天，无法再进行取消
			$return['code'] = 0;
			$return['msg'] = '该订单已超过七天无法取消';
			return $return;
		}
		DB::beginTransaction();//开启事务处理
		if($delete_data->order_status == 0){//当订单为未支付的时候删除同时需要对其相关的业务/对应的资源信息进行更新
			switch ($delete_data->resource_type) {//当资源类型为租用主机/托管主机/租用机柜时，对业务的到期时间进行更改
				case 1://租用机器
					$end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
					$business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update(['endding_time'=>$end_time]);
					if($business == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!!';
						return $return;
					}
					$row = DB::table('idc_machine')->where(['machine_num'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number,'business_type'=>1])->update(['own_business'=>$delete_data->business_number,'business_end'=>$end_time]); 
					if($row == 0){
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					break;
				case 2://托管机器
					$end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
					$business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update(['endding_time'=>$end_time]);
					if($business == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					$row = DB::table('idc_machine')->where(['machine_num'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number,'business_type'=>2])->update(['own_business'=>$delete_data->business_number,'business_end'=>$end_time]); 
					if($row == 0){
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					break;
				case 3://租用机柜
					$end_time = Carbon::parse($delete_data->endding_time)->modify('-'.$delete_data->duration.' months')->toDateTimeString();
					$business = DB::table('tz_business')->where(['business_number'=>$delete_data->business_number])->update(['endding_time'=>$end_time]);
					if($business == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					break;
				case 4://IP
					$end_time = $this->findResource($delete_data->order_sn,$delete_data->machine_sn,$delete_data->business_number);
					$ip['own_business'] = $delete_data->business_number;
					$ip['business_end'] = empty($end_time)?Null:$end_time->end_time;
					$row = DB::table('idc_ips')->where(['ip'=>$delete_data->machine_sn,'own_business'=>$delete_data->business_number])->update($ip);
					if($row == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					$order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>2]);
					if($order_status == 0){
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					break;
				case 5://CPU
					$end_time = $this->findResource($delete_data->order_sn,$delete_data->machine_sn,$delete_data->business_number);
					$cpu['service_num'] = $delete_data->business_number;
					$cpu['business_end'] = empty($end_time)?Null:$end_time->end_time;
					$row = DB::table('idc_cpu')->where(['cpu_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($cpu);
					if($row == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					$order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>2]);
					if($order_status == 0){
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					break;
				case 6://硬盘
					$end_time = $this->findResource($delete_data->order_sn,$delete_data->machine_sn,$delete_data->business_number);
					$harddisk['service_num'] = $delete_data->business_number;
					$harddisk['business_end'] = empty($end_time)?Null:$end_time->end_time;
					$row = DB::table('idc_harddisk')->where(['harddisk_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($harddisk);
					if($row == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					$order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>2]);
					if($order_status == 0){
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					break;
				case 7://内存
					$end_time = $this->findResource($delete_data->order_sn,$delete_data->machine_sn,$delete_data->business_number);
					$memory['service_num'] = $delete_data->business_number;
					$memory['business_end'] = empty($end_time)?Null:$end_time->end_time;
					$row = DB::table('idc_memory')->where(['memory_number'=>$delete_data->machine_sn,'service_num'=>$delete_data->business_number])->update($memory);
					if($row == 0){//更新业务到期时间失败
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
						return $return;
					}
					$order_status = DB::table('tz_orders')->where(['order_sn'=>$end_time->order_sn])->update(['order_status'=>2]);
					if($order_status == 0){
						DB::rollBack();
						$return['code'] = 0;
						$return['msg'] = '取消订单失败!';
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
			$return['msg'] = '取消订单失败!';
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
		$end = $this->where(['business_sn'=>$business,'machine_sn'=>$resource_sn])->where('order_sn','<>',$exclude_order)->orderBy('end_time','desc')->select('end_time','order_sn')->first();
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
				$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn',11=>'高防IP'];
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
		$all = $this->where($business)->where('price','>','0.00')->where('order_status','<',3)->where('resource_type','>',3)->orderBy('end_time','desc')->get(['order_sn','resource_type','machine_sn','resource','price','end_time'])->groupBy('machine_sn')->toArray();
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
			$return['msg']	= '无法进行续费,请确认后重新操作';
			return $return;
		}
		$order_str = '';//用于记录创建的续费订单的订单号
		$renew_order = [];//用于存储新增的订单的id，用于存储进session，方便后续调用订单
		DB::beginTransaction();//开启事务处理
		if(isset($renew['business_number'])){//传递了业务编号的进行业务查找和续费
			$business_where = [
				'business_number'=>$renew['business_number'],
				'client_id' => Auth::user()->id,
			];
			$business = DB::table('tz_business')->where($business_where)->select('business_number','business_type','sales_id','sales_name','sales_name','business_type','machine_number','endding_time','length','money','business_status','remove_status')->first();
			if(!$business){
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']	= '无查找到对应的业务,无法续费';
				return $return;
			}
			if($business->business_status < 1 || $business->business_status > 3){
				$business_status = ['-1'=>'取消','-2'=>'审核不通过',0=>'审核中',1=>'审核通过',2=>'付款使用中',3=>'未付款使用',4=>'锁定中',5=>'到期',6=>'退款'];
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg']	= '该业务'.$business_status[$business->business_status].'无法进行续费';
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
			$order['customer_id'] = Auth::user()->id;//订单关联客户
			$order['customer_name'] = Auth::user()->name?Auth::user()->name:Auth::user()->email;
			$order['business_id'] = $business->sales_id;//订单绑定业务员
			$order['business_name'] = $business->sales_name;
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
					$result = DB::table('idc_cabinet')->where($where)->update($machine);
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
			$order_where = [
				'customer_id' => Auth::user()->id,
			];
			foreach($renew['orders'] as $key=>$value){
				$order_where['order_sn'] = $value;
				$order_result = $this->where($order_where)->select('business_sn','business_id','business_name','resource_type','machine_sn','resource','price','end_time','order_status')->first();
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
				// if($end_time > $endding_time){

				// }
				$order['end_time'] = $end_time;
				$order['duration'] = $renew['length'];//订单时长
				$order['business_sn'] = $order_result->business_sn;//订单关联业务
				$order['customer_id'] = Auth::user()->id;//订单关联客户
				$order['customer_name'] = Auth::user()->name?Auth::user()->name:Auth::user()->email;
				$order['business_id'] = $order_result->business_id;//订单绑定业务员
				$order['business_name'] = $order_result->business_name;
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
			}
			$business = DB::table('tz_business')->where($business_where)->select('business_status')->first();
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
		//所对应资源表的业务编号和到期时间，状态修改成功后进行事务提交
		DB::commit();
		$return['data'] = $renew_order;
		$return['code'] = 1;
		$return['msg'] = '资源续费订单创建成功,订单号:'.rtrim($order_str,',').'七天内可取消';//为了不影响使用请及时支付,您的续费单号:'.$order_sn;
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
}
