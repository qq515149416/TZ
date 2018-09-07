<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 不知道啥2.0
// +----------------------------------------------------------------------
// | Description: 用户业务表模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Business extends Model
{

	use SoftDeletes;

	protected $table = 'tz_business'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	/**
	 * 获取业务数据
	 * @param  int $user_id 客户的id
	 * @return array          返回相关的数据和状态提示信息
	 */
	public function getList($user_id)
	{	
		$where['client_id'] = $user_id;
		$where['business_status'] = ' < 3';
		$business = $this->where('client_id',$user_id)
						->where('business_status','> 1')
						->where('business_status','< 4')
						->get(['id','business_number','business_type','machine_number','resource_detail','business_status','money','length','business_note']);
		$business_status = [2=>'付款使用中',3=>'未付款使用'];
		$business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
		if($business->isEmpty()){
			foreach ($business as $key => $value) {
				$business[$key]['business_status'] = $business_status[$value['business_status']];
				$business[$key]['business_type'] = $business_type[$value['business_type']];
			}
			$return['data'] = $business;
			$return['code'] = 1;
			$return['msg'] = '相关的业务实例获取成功';
		} else {
			$return['data'] = '暂无相关的业务实例';
			$return['code'] = 0;
			$return['msg'] = '暂无相关的业务实例';
		}
		return $return;
	}

	/**
	 * 进行业务续费操作
	 * @param  array $where 续费的业务相关数据
	 * @return array        返回相关的状态信息及提示
	 */
	public function renewBusiness($where){
		if($where){
			'id','client_id','client_name','sales_id','slaes_name','business_number',
			'machine_number','resource_detail','money','length','renew_time',
			'start_time','end_time','business_status','business_note'
			// 续费订单的生成
			$ordersn = mt_rand(11,40).date('Ymd',time()).substr(time(),5,5).2;
			$renew['order_sn'] = (int)$ordersn;
			$renew['business_sn'] = $where['business_number'];
			$renew['customer_id'] = $where['client_id'];
			$renew['customer_name'] = $where['client_name'];
			$renew['business_id'] = $where['sales_id'];
			$renew['business_name'] = $where['sales_name'];
			$renew['resource_type'] = 1;
			$renew['order_type'] = $where['order_type'];
			$renew['machine_sn'] = $where['machine_number'];
			$renew['after_resource'] = $where['resource_detail'];
			$renew['price'] = $where['money'];
			$renew['duration'] = $where['length'];
			$renew['order_status'] = 0;
			//待转换到订单相关控制器
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法进行续费';
		}

		return $return;
	}


}