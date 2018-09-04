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
		$order = $this->where('customer_id',$user_id)->get(['order_sn', 'business_sn','before_money','after_money','business_id','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at','payable_money']);

		if(count($order) == 0){
			return false;
		}

		//转换状态
		$resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn'];
		$order_type = [ '1' => '新购' , '2' => '续费' ];
		$pay_type = [ '1' => '余额' , '2' => '支付宝' , '3' => '微信' , '4' => '其他'];
		$order_status = [ '0' => '待支付' , '1' => '已支付' , '2' => '已支付' , '3' => '订单完成' , '4' => '取消' , '5' => '申请退款' , '6' => '退款完成'];

		foreach ($order as $key => $value) {
			$order[$key]['resource_type'] = $resource_type[$order[$key]['resource_type']];
			$order[$key]['order_type'] = $order_type[$order[$key]['order_type']];
			$order[$key]['pay_type'] = $pay_type[$order[$key]['pay_type']];
			$order[$key]['order_status'] = $order_status[$order[$key]['order_status']];
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

	public function payOrder($user_id,$id){
		$row = $this->find($id);
		$return['data']	= '';
		if($row == NULL){
			$return['msg'] 	= '无此订单';
			$return['code']	= 0;
			return $return;
		}

		$customer_id = $row->customer_id;
		if($user_id != $customer_id){	
			$return['msg'] 	= '只能支付自己的订单';
			$return['code']	= 0;
			return $return;
		}

		$order_status = $row->order_status;
		if( $order_status != 0 ){
			$return['msg'] 	= '订单已支付或已取消';
			$return['code']	= 0;
			return $return;
		}
		//获取余额
		$before_money 	= $this->getMoney($user_id)->money;
		$payable_money = bcmul( (string)$row->price , (string)$row->duration , 2 );
		$after_money		= $before_money - $payable_money;
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
		$row->order_status	= 2;
		$res = $row->save();
		if(!$res){
			$return['msg'] 	= '支付失败';
			$return['code']	= 0;
			return $return;
		}
		$pay_money = DB::table('tz_users')->where('id',$user_id)->update(['money' => $after_money ]); 

		if(!$pay_money){
			//失败就回滚
			DB::rollBack();
			$return['code'] = 0;
			$return['msg'] = '扣款失败!!';
		}else{
			DB::commit();
			$return['data'] = $row;
			$return['code'] = 1;
			$return['msg'] = '支付成功!!';
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
}