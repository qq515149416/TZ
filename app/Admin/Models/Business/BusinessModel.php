<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算

/**
 * 后台业务模型
 */
class BusinessModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_business';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * 创建业务数据
     * @param  array $insert 需要创建业务的数据
     * @return array         返回创建业务时的id和状态及提示信息
     */
    public function insertBusiness($insert){
    	if($insert){
    		//业务编号的生成规则：前两位（41-70的随机数）+ 年月日（如:20180830） + 时间戳的后5位数 + 3（业务编号产生）
    		$business_sn = mt_rand(41,70).date('Ymd',time()).substr(time(),5,5).3;
			$insert['business_number'] = (int)$business_sn;
			$insert['business_status'] = 0;
			// 对应业务员的信息
			$sales_id = Admin::user()->id;
			$insert['sales_id'] = $sales_id;
			$sales_name = (array)$this->staff($sales_id);
			$insert['sales_name'] = $sales_name['fullname'];
			$row = $this->create($insert);
			if($row != false){
				$return['data'] = $row->id;
    			$return['code'] = 1;
    			$return['msg'] = '业务创建成功，待审核';
			} else {
				$return['data'] = '';
    			$return['code'] = 0;
    			$return['msg'] = '业务创建失败';
			}
    	} else {
   			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '业务无法创建！！';
   		}
   		return $return;
    	
    }

    /**
     * 信安部门查看业务数据获取
     * @return array 返回相关的数据和状态及提示信息
     */
    public function securityBusiness(){
    	$result = $this->get(['id','client_id','client_name','sales_id','slaes_name','order_number','business_number','business_type','machine_number','resource_detail','business_status','money','length','business_note']);
    	if($result->isEmpty()){
    		$business_status = [-1=>'取消',-2=>'审核不通过',0=>'审核中',1=>'审核通过',2=>'付款使用中',3=>'未付款使用',4=>'锁定中',5=>'到期',6=>'退款'];
    		$business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
    		foreach($result as $check => $check_value){
    			$result[$check]['status'] = $business_status[$check_value['business_status']];
    			$result[$check]['type'] = $business_type[$check_value['business_type']];
    		}
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '相关业务数据获取成功';
    	} else {
    		$return['data'] = '暂无业务数据';
    		$return['code'] = 0;
    		$return['msg'] = '暂无业务数据';
    	}

    	return $return;
    }
// DB::beginTransaction();
// DB::rollBack();
// DB::commit();
    /**
     * 信安部门对业务进行审核操作
     * @param  array $where 业务的业务编号和业务的id
     * @return array        返回相关的数据和状态及提示信息
     */
    public function checkBusiness($where){
    	if($where){
    		// 业务表审核时更新的字段
    		$business['business_status'] = $where['business_status'];
    		$business['check_note'] = $where['check_note'];
    		if($where['business_status'] == 1){
    			// 如果审核为通过则继续进行订单表的生成
    			DB::beginTransaction();//开启事务处理
    			//业务开始时间
	    		$start_time = Carbon::now()->toDateTimeString();
	    		//到期时间的计算
	    		$end_time = Carbon::parse('+'.$data['duration'].' months')->toDateTimeString();
	    		// 订单号的生成规则：前两位（11-40的随机数）+ 年月日（如:20180830） + 时间戳的后5位数 + 1（新购）/2（续费）
   				$order_sn = mt_rand(11,40).date('Ymd',time()).substr(time(),5,5).1;
   				$business['order_number'] = (int)$order_sn;
	    		$business['start_time'] = $start_time;
	    		$business['endding_time'] = $end_time;
	    		$business['update_at'] = Carbon::now()->toDateTimeString();
    			$business_row = DB::table('tz_business')->where('id',$where['id'])->update($business);
    			if($business_row != 0){
    				// 业务审核成功继续进行订单表的生成
   					$order['order_sn'] = (int)$order_sn;
    				$order['business_sn'] = $where['business_number'];
    				$order['customer_id'] = $where['client_id'];
    				$order['customer_name'] = $where['client_name'];
    				$order['business_id'] = $where['sales_id'];
    				$order['business_name'] = $where['sales_name'];
    				$order['resource_type'] = $where['business_type'];
    				$order['order_type'] = 1;
    				$order['machine_sn'] = $where['machine_number'];
    				$order['price'] = $where['money'];//单价
    				$order['duration'] = $where['length'];//时长
    				$order['resource'] = $where['machine_number'];
    				$order['end_time'] = $end_time;
    				$order['payable_money'] = bcmul((string)$order['price'],(string)$order['duration'],2);//应付金额
    				$order['created_at']  = Carbon::now()->toDateTimeString();
    				$order_row = DB::table('tz_orders')->insert($order);//生成订单
    				if($order_row != 0){
    					// 订单生成成功，事务进行提交处理
    					DB::commit();
	    				$return['data'] = $order_sn;
			    		$return['code'] = 1;
			    		$return['msg'] = '审核成功,通知业务员及时联系客户进行支付单号:'.$order_sn;
    				} else {
    					DB::rollBack();
	    				$return['data'] = '审核失败';
			    		$return['code'] = 0;
			    		$return['msg'] = '审核失败';
    				}
    			} else {
    				DB::rollBack();
    				$return['data'] = '审核失败';
		    		$return['code'] = 0;
		    		$return['msg'] = '审核失败';
    			}	
    		} else {
    			// 审核为不通过时直接进行业务的状态更改
    			$row = $this->where('id',$where['id'])->update($business);
    			if($row != false){
    				$return['data'] = '';
		    		$return['code'] = 1;
		    		$return['msg'] = '审核成功';
    			} else {
    				$return['data'] = '审核失败';
		    		$return['code'] = 0;
		    		$return['msg'] = '审核失败';
    			}
    		}

    	} else {
    		$return['data'] = '无法进行审核';
    		$return['code'] = 0;
    		$return['msg'] = '无法进行审核';
    	}
    	return $return;
    }

    /**
     * 业务员手动对客户的业务进行启用状态，针对后付费客户群体
     * @param  [type] $enable [description]
     * @return [type]         [description]
     */
    public function enableBusiness($enable){
    	if($enable){
    		$row = $this->where('id',$enable['id'])->update($enable);
    		if($row != false){
	    		$return['code'] = 1;
	    		$return['msg'] = '业务启用成功';
    		} else {
    			$return['code'] = 1;
	    		$return['msg'] = '业务启用失败';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '无法启用该业务';
    	}
    	return $return;
    }


    /**
     * 给客户创建业务时查找对应业务员的真实姓名
     * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
     * @return string           返回对应账户的真实姓名
     */
    public function staff($admin_id) {
        $staff = DB::table('oa_staff')->where('admin_users_id',$admin_id)
                    ->select('work_number','fullname')->first();
        return $staff;
    }

    /**
     * 业务员和管理员查看对应客户的业务数据
     * @param  array $show 客户的id即业务表的client_id字段
     * @return array        返回相关的数据和状态提示及信息
     */
    public function showBusiness($show){
    	if($show){
    		$result = $this->where($show)->get(['id','client_id','client_name','sales_id','slaes_name','order_number','business_number','business_type','machine_number','resource_detail','business_status','money','length','start_time','endding_time','business_note']);
	    	if($result->isEmpty()){
	    		$business_status = [-1=>'取消',-2=>'审核不通过',0=>'审核中',1=>'审核通过',2=>'付款使用中',3=>'未付款使用',4=>'锁定中',5=>'到期',6=>'退款'];
	    		$business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
	    		foreach($result as $check => $check_value){
	    			$result[$check]['status'] = $business_status[$check_value['business_status']];
	    			$result[$check]['type'] = $business_type[$check_value['business_type']];
	    		}
	    		$return['data'] = $result;
	    		$return['code'] = 1;
	    		$return['msg'] = '相关业务数据获取成功';
	    	} else {
	    		$return['data'] = '暂无业务数据';
	    		$return['code'] = 0;
	    		$return['msg'] = '暂无业务数据';
	    	}

	    	return $return;
    	}
    }
}
