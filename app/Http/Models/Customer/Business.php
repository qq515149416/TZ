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

namespace App\Http\Models\Customer;

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
		
		$business = $this->where('client_id',$user_id)
						->where('business_status','>','-1')
						->where('business_status','<',5)
						->where('remove_status','<',2)
						->get(['id','business_number','business_type','machine_number','resource_detail','business_status','money','length','business_note','endding_time','remove_status']);
		$business_status = [0=>'审核中',1=>'未付款使用',2=>'正常',3=>'正常',4=>'锁定中'];
		$business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
		$remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
		if(!$business->isEmpty()){
			foreach ($business as $key => $value) {
				$business[$key]['business_status'] = $business_status[$value['business_status']];
				$business[$key]['type'] = $value['business_type'];
				$business[$key]['business_type'] = $business_type[$value['business_type']];	
				$business[$key]['remove_status'] = $remove_status[$value['remove_status']];	
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
	 * 客户端获取绑定业务员信息
	 * @param  [type] $sales_id [description]
	 * @return [type]           [description]
	 */
	public function getSales($sales_id){
		if(!$sales_id){
			return [
	            'data'=>'',
				'code'=>0,
				'msg'=>'无法获取业务员的信息'
			];
		}
		if($sales_id != 0){
			$sales = DB::table('admin_users as admin')
					->join('oa_staff as staff','admin.id','=','staff.admin_users_id')
					->where(['admin.id'=>$sales_id])
					->select('admin.id','admin.name as sale_name','staff.phone','staff.QQ','staff.wechat','staff.email')
					->first();
			
		} else {
			return [
				'data'=>'',
				'code'=>0,
				'msg'=>'您暂未绑定业务员'
			];
		}
		return [
			'data'=>$sales,
			'code'=>1,
			'msg'=>'业务员信息获取成功'
		];


	}


}