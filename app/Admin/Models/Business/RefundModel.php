<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Encore\Admin\Facades\Admin;

/**
 * 后台退款相关模型
 */
class RefundModel extends Model
{
    use  SoftDeletes;
	protected $table = 'tz_refund';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
    protected $fillable = [];

    /**
     * 业务员/管理人员获取对应的退款详情
     * @param  array $order_num 对应的订单号
     * @return array            返回对应的相关状态及提示信息
     */
    public function showRefund($order_num){
    	if(!$order_num){
    		$return['code'] = 0;
    		$return['msg'] = '无法获取对应的退款详情!';
    		$return['data'] = '';
    	}
    	$where = ['refund_order'=>$order_num['refund_order'],'refund_clerk_id'=>Admin::user()->id];
    	$refund = $this->where($where)->get(['id','refund_order','refund_business','refund_num','refund_customer_id','refund_customer_name','refund_clerk_id','refund_clerk_name','refund_money','before_balance','after_balance','refund_serial_number','refund_time','refund_reason','refund_note','refund_status','created_at','updated_at']);
    	if(!$refund->isEmpty()){
    		$status = [0=>'处理中',1=>'成功',2=>'失败',3=>'取消'];
    		foreach($refund as $refund_key => $refund_value){
    			$refund[$refund_key]['status'] = $status[$refund_value['refund_status']];
    		}
    		$return['code'] = 1;
    		$return['msg'] = '获取退款详情成功';
    		$return['data'] = $refund;
    	} else {
    		$return['code'] = 1;
    		$return['msg'] = '暂无退款详情';
    		$return['data'] = [];
    	}
    }

    /**
     * 财务获取对应的退款详情
     * @param  array $order_num 对应的订单号
     * @return array            返回对应的相关状态及提示信息
     */
    public function fianceRefund($order_num){
        if(!$order_num){
            $return['code'] = 0;
            $return['msg'] = '无法获取对应的退款详情!';
            $return['data'] = '';
        }
        $where = ['refund_order'=>$order_num['refund_order']];
        $refund = $this->where($where)->get(['id','refund_order','refund_business','refund_num','refund_customer_id','refund_customer_name','refund_clerk_id','refund_clerk_name','refund_money','before_balance','after_balance','refund_serial_number','refund_time','refund_reason','refund_note','refund_status','created_at','updated_at']);
        if(!$refund->isEmpty()){
            $status = [0=>'处理中',1=>'成功',2=>'失败',3=>'取消'];
            foreach($refund as $refund_key => $refund_value){
                $refund[$refund_key]['status'] = $status[$refund_value['refund_status']];
            }
            $return['code'] = 1;
            $return['msg'] = '获取退款详情成功';
            $return['data'] = $refund;
        } else {
            $return['code'] = 1;
            $return['msg'] = '暂无退款详情';
            $return['data'] = [];
        }
    }

    /**
     * 申请退款
     * @param  array $refund_order 需退款的订单号
     * @return array               返回对应的相关状态及提示信息
     */
    public function insertRefund($refund_order){
    	if(!$refund_order){
    		$return['code'] = 0;
    		$return['msg'] = '无法申请退款';
    		return $return;
    	}
    	$order = DB::table('tz_orders')->where(['order_sn'=>$refund_order['refund_order']])->select('order_sn','price','duration','business_sn','order_status','business_id','business_name','resource_type','end_time','created_at')->first();
        if(!$order){//不存在此订单
            $return['code'] = 0;
            $return['msg'] = '无对应订单,无法申请退款';
            return $return;
        }
        if($order->order_status < 1 || $order->order_status > 2) {//订单状态处于待支付或者订单完成以上的，不给予退款
            $status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成']; 
            $return['code'] = 0;
            $return['msg'] = '该订单,无法申请退款,原因:已'.$status[$order->order_status];
            return $return;
        }
        //获取支付流水单
        $order_flow = DB::table('tz_orders_flow')->where(['serial_number'=>$order->serial_number])->select('actual_payment','preferential_amount','pay_status')->first();
        if(empty($order_flow)){//不存在支付流水单
            $return['code'] = 0;
            $return['msg'] = '该订单,无法申请退款,原因:无支付信息';
            return $return;
        }
        if($order_flow->pay_status == 0){//支付流水单未完成支付
            $return['code'] = 0;
            $return['msg'] = '该订单,无法申请退款,原因:订单未完成支付';
            return $return;
        }
        $order_flow_same = DB::table('tz_orders')->where(['serial_number'=>$order->serial_number])->where('order_sn','<>',$refund_order['refund_order'])->select('order_sn','business_sn','order_status','business_id','business_name','resource_type','end_time','created_at','serial_number')->get();
        if(!empty($order_flow_same)){
            foreach($order_flow_same as $same=>$value){
               $status[$same] = $value->order_status;
            }
        }
        
        /**
         * 计算可退款金额
         * @var [type]
         */
        $pay_price = bcmul($order->price,$order->duration,2);//计算单笔订单支付金额(乘法)
        $start = Carbon::parse($order->created_at);//订单的开始时间
        $end = Carbon::parse($order->end_time);//订单的到期时间
        $days = $end->diffInDays($start);//开始到结束的时间差
        $price_day = bcdiv($pay_price,$days,2);//每天的单价(除法)
        $now = Carbon::parse();//提交申请的时间
        $use_day = $now->diffInDays($start);//已使用的时间
        $use_money = bcmul($price_day,$use_day,2);//使用应支付的金额(乘法)
        $refund_money = bcsub($pay_price,$use_money,2);//可退款金额(减法)
        if(array_search(6, $status) == false || array_search(8, $status) == false && bccomp($refund_money,$order_flow->preferential_amount) > '-1'){
            //当不存在有订单退款,且剩余可退款金额不小于优惠额度时进行优惠扣除得到实际可退款金额
            $refund_money = bcsub($refund_money,$order_flow->preferential_amount,2);
        }

    	/**
    	 * 退款的数据
    	 * @var [type]
    	 */
    	//退款号:日期年-月-日+时间戳后两位+10~99的随机数
    	$refund_num = date('Ymd',time()).substr(time(),8,2).mt_rand(10,99);
    	$refund['refund_num'] = $refund_num;//退款号
    	$refund['refund_order'] = $order->order_sn;//退款订单
    	$refund['refund_business'] = $order->business_sn;//退款业务号
    	$refund['refund_customer_id'] = Auth::user()->id;//客户id
    	$refund['refund_customer_name'] = Auth::user()->name?Auth::user()->name:Auth::user()->email;//客户基本信息
    	$refund['refund_clerk_id'] = $order->business_id;//业务员id
    	$refund['refund_clerk_name']= $order->business_name;//业务员姓名
    	$refund['resource_type'] = $order->resource_type;//资源类型
    	$refund['refund_reason'] = $refund_order['refund_reason'];//退款原因
    	$refund['refund_status'] = 0;
    	$refund['created_at'] = $now;
    	$refund['refund_money'] = $refund_money;//可退款金额
    	DB::beginTransaction();//DB::rollBack();DB::commit();
    	$row = DB::table('tz_refund')->insertGetId($refund);
    	if($row == false){
    		DB::rollBack();
    		$return['code'] = 0;
    		$refund['msg'] = '申请退款失败,请确认后重新操作';
    	}
    	$where = [
    		'order_sn'=>$refund['refund_order'],
    		'resource_type'=>$refund['resource_type'],
    		'customer_id'=>Auth::user()->id,
    		'order_status' => 'in (1,3)';
    	];
    	$order_row = DB::table('tz_orders')->where($where)->update(['order_status'=>6]);
    	if($order_row != false){
    		DB::commit();
    		$return['code'] = 1;
    		$refund['msg'] = '申请退款成功,将退还到账户余额,请耐心等待工作人员处理!';
    	} else {
    		DB::rollBack();
    		$return['code'] = 0;
    		$refund['msg'] = '申请退款失败,请确认后重新操作';
    	}
    	return $return;
    }

    /**
     * 申请取消退款
     * @param  array $cancel_order 对应的退款单号
     * @return array               返回对应的状态及提示信息
     */
    public function cancelRefund($cancel_order){
    	// 未传递对应退款单号
    	if(!$cancel_order){
    		$return['code'] = 0;
    		$return['msg'] = '无法取消退款';
    		return $return;
    	}
    	// 查询对应退款单的信息
    	$where = ['refund_num'=>$cancel_order['cancel_refund'],'refund_status'=>0,'refund_customer_id'=>Auth::user()->id];
    	$refund = $this->where($where)->select('id','refund_order','resource_type')->first();
    	if(empty($refund)){//不存在退款单
    		$return['code'] = 0;
    		$return['msg'] = '无法取消,该退款已受理/您已取消过';
    		return $return;
    	}
    	DB::beginTransaction();
    	// 取消退款
    	$row = DB::table('tz_refund')->where($where)->update(['refund_status'=>3]);
    	if($row == false){//取消失败
    		DB::rollBack();
    		$return['code'] = 0;
    		$return['msg'] = '取消退款失败';
    		return $return;
    	}
    	// 更改订单状态
    	$order_where = ['order_sn'=>$refund->refund_order,'order_status'=>6,'customer_id'=>Auth::user()->id,'resource'=>$refund->resource_type];
    	$oreder_row = DB::table('tz_orders')->where($order_where)->update(['order_status'=>3]);
    	if($order_row != false){
    		DB::commit();
    		$return['code'] = 1;
    		$return['msg'] = '取消退款成功';
    		
    	} else {
    		DB::rollBack();
    		$return['code'] = 0;
    		$return['msg'] = '取消退款失败';
    		
    	}
    	return $return;
    }

    /**
     * 删除退款记录
     * @param  array $delete_refund 对应的退款号
     * @return array                返回对应的状态及信息提示
     */
    public function deleteRefund($delete_refund){
    	if(!$delete_refund){
    		$return['code'] = 0;
    		$return['msg'] = '无法删除退款记录';
    		return $return;
    	}
    	// 查询对应退款单的信息
    	$where = ['refund_num'=>$delete_refund['delete_refund'],'refund_status'=>3,'refund_customer_id'=>Auth::user()->id];
    	$refund = $this->where($where)->select('id')->first();
    	if(empty($refund)){
    		$return['code'] = 0;
    		$return['msg'] = '无法删除,该退款等待受理/已受理中';
    		return $return;
    	}
    	$row = $this->where($where)->delete();
    	if($row != false){
    		$return['code'] = 1;
    		$return['msg'] = '删除此退款记录成功!';
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '删除此退款记录失败!';
    	}
    	return $return;
    }
}
