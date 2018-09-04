<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * 后台获取业务数据（根据业务编号）
 */
class BusinessModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_business';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * 获取对应的业务数据
     * @param  array $where 业务编号条件查找
     * @return array        相关数据和状态及提示信息
     */
    public function showBusiness($where){
    	$result = $this->where($where)
    				->get(['id','client_id','client_name','sales_id','slaes_name','business_number','machine_number','resource_detail','money','length','renew_time','start_time','end_time','business_status','business_note']);
    	if(!$result->isEmpty()){
    		$business_status = [0=>'未付款使用',1=>'付款使用',2=>'锁定',3=>'到期',4=>'取消',5=>'退款'];
    		foreach($result as $business_key=>$business_value){
    			$result[$business_key]['business_status'] = $business_status[$business_value['business_status']];
    		}
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '相关业务数据获取成功';
    	} else {
    		$return['data'] = '暂无相关数据';
    		$return['code'] = 0;
    		$return['msg'] = '暂无相关业务数据';
    	}

    	return $return;
    }
}
