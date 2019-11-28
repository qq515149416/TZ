<?php


namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\Customer\Customer;
use App\Admin\Models\Statistics\PfmStatistics;

class InvoiceModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_invoice'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['flow_id', 'total_amount' , 'tax'  ,'date' ,'type' , 'mail_state' , 'invoice_num' ,'address' ,'payable','salesman_id']  ;

	/**
	* 查询权限,是不是自己的客户或者是不是管理员
	*/
	public function checkAdmin($user_id)
	{
		if(Admin::user()->isAdministrator()){
			return true;
		}else{
			$admin_user = Admin::user();
			$customer_model = new Customer();
			$customer = $customer_model->find($user_id);
			if ($customer == null || $customer->salesman_id != $admin_user->id) {
				return false;
			}else{
				return true;
			}
		}
		

	}
	

	/**
	*为客户开发票申请
	* @param $flow_id	- 流水id ; $type 	- 发票种类 ; $address_id 	- 邮寄地址的id ; papyable_id 	- 发票抬头的id .
	* $type == 2时,是专票,需要的资料更多,所以要做判断.
	*/
	public function makeInvoice($flow_id , $type , $address_id , $payable_id )
	{
		//找到流水信息
		$flow_model = new PfmStatistics();
		$a 		= 0;//就是个下标
		$total_amount 	= 0;//计算流水的总价格
		foreach ($flow_id as $k => $v) {
			$flow[$a] = $flow_model->find($v);
			if(!$flow[$a]){
				return [
					'data'	=> [],
					'msg'	=> '订单不存在',
					'code'	=> 0,
				];
			}
			if ($flow[$a]->invoice_state != 0) {
				return [
					'data'	=> [],
					'msg'	=> '订单已提交发票申请,请勿重复提交',
					'code'	=> 0,
				];
			}
			if ($a != 0 && $flow[$a]->customer_id != $flow[$a-1]->customer_id ) {
				return [
					'data'	=> [],
					'msg'	=> '订单不属于同一客户',
					'code'	=> 0,
				];
			}
			$total_amount = bcadd($total_amount,$flow[$a]->actual_payment,2);
			$a++;
		}	

		//判断提交资格
		$check_admin = $this->checkAdmin($flow[0]->customer_id);
		if(!$check_admin){
			return [
				'data'	=> [],
				'msg'	=> '客户不存在或不属于您',
				'code'	=> 0,
			];
		}
		
		//获取邮寄地址及发票抬头信息
		$address = DB::table('tz_address')
			->where(['id' => $address_id , 'user_id' => $flow[0]->customer_id])
			->first(['address']);
		$payable = DB::table('tz_payable')
			->where(['id' => $payable_id , 'user_id' => $flow[0]->customer_id])
			->first();
		if(!$address){
			return [
				'data'	=> [],
				'msg'	=> '邮寄地址不存在',
				'code'	=> 0,
			];
		}
		if(!$payable){
			return [
				'data'	=> [],
				'msg'	=> '发票抬头不存在',
				'code'	=> 0,
			];
		}

		if ($type == 2 ) {		//要开专票时
			if (!$payable->address || !$payable->tel || !$payable->bank || !$payable->bank_acc) {	//抬头没填好专票必填选项
				return [
					'data'	=> [],
					'msg'	=> '发票抬头信息不完整,请填写完整后再开专票',
					'code'	=> 0,
				];
			}
		}
	
		//生成发票申请
		$data = [
			'flow_id'		=> json_encode($flow_id),		//将几个开票的流水单号转成json数组存起
			'salesman_id'	=> $flow[0]->business_id,		//业务员的id
			'total_amount'	=> $total_amount,			//总的价格
			'tax'		=> bcmul($total_amount, 0.06,2),	//计算税额
			'date'		=> date("Y-m-d H:i:s"),			//日期
			'type'		=> $type,				//票种类
			'mail_state'	=> 0,					//邮寄状态
			'address'	=> $address->address,			//邮寄地址
			'payable'	=> json_encode($payable),		//抬头打包
		];
		DB::beginTransaction();//开启事务处理

		$insert = $this->create($data);

		if(!$insert){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '发票申请提交失败',
				'code'	=> 0,
			];
		}
		//更新流水的发票状态
		foreach ($flow as $k => $v) {
			$v->invoice_state = 2;
			if(!$v->save()){
				DB::rollBack();
				return [
					'data'	=> [],
					'msg'	=> '流水发票状态更新失败',
					'code'	=> 0,
				];
			}	
		}

		DB::Commit();
		return [
				'data'	=> [],
				'msg'	=> '发票申请提交成功',
				'code'	=> 1,
			];
	}

	/**
	*为客户删除邮寄地址
	*/
	public function delPayable( $payable_id )
	{
		$payable = $this->find($payable_id);
		if (!$payable) {
			return [
				'data'	=> [],
				'msg'	=> '无此发票抬头',
				'code'	=> 0,
			];
		}

		// $check_admin = $this->checkAdmin($address->user_id);

		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不属于您',
		// 		'code'	=> 0,
		// 	];
		// }

		$del = $payable->delete();
		if($del){
			return [
				'data'	=> [],
				'msg'	=> '发票抬头删除成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '发票抬头删除失败',
				'code'	=> 0,
			];
		}
	}

	/**
	*为客户编辑邮寄地址
	*/
	public function editPayable( $par )
	{
		
		$payable = $this->find($par['payable_id']);

		if (!$payable) {
			return [
				'data'	=> [],
				'msg'	=> '无此发票抬头',
				'code'	=> 0,
			];
		}
		$data = [];
		foreach ($par as $k => $v) {
			if ($k != 'payable_id') {
				$payable->$k = $v;
			}	
		}
		// $check_admin = $this->checkAdmin($address->user_id);

		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不属于您',
		// 		'code'	=> 0,
		// 	];
		// }
		$edit = $payable->save();
		if($edit){
			return [
				'data'	=> [],
				'msg'	=> '发票抬头编辑成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '发票抬头编辑失败',
				'code'	=> 0,
			];
		}
	}

	/**
	*为客户编辑邮寄地址
	*/
	public function showPayable( $user_id  )
	{

		// $check_admin = $this->checkAdmin($user_id);

		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不属于您',
		// 		'code'	=> 0,
		// 	];
		// }

		$payable = $this->where('user_id' , $user_id)->get();
		if($payable->isEmpty()){
			return [
				'data'	=> [],
				'msg'	=> '无已存发票抬头',
				'code'	=> 1,
			];
		}

		return [
			'data'	=> $payable,
			'msg'	=> '发票抬头获取成功',
			'code'	=> 1,
		];
	

	}
	/**
	*删除开票申请
	*/
	public function deleteInvoice($invoice_id)
	{
		$invoice = $this->find($invoice_id);
		if (!$invoice) {
			return [
				'data'	=> [],
				'msg'	=> '发票申请不存在',
				'code'	=> 0,
			];
		}
		$flow_id = json_decode($invoice->flow_id,true);

		DB::beginTransaction();
		$flow_model = new PfmStatistics();
		foreach ($flow_id as $k => $v) {
			$flow = $flow_model->find($v);
			if (!$flow) {
				DB::rollBack();
				return [
					'data'	=> [],
					'msg'	=> '流水不存在,请找技术人员核实',
					'code'	=> 0,
				];
			}
			$flow->invoice_state = 0;
			if (!$flow->save()) {
				DB::rollBack();
				return [
					'data'	=> [],
					'msg'	=> '流水的发票状态更新失败',
					'code'	=> 0,
				];
			}
		}
		if ($invoice->delete()) {
			DB::commit();
			return [
				'data'	=> [],
				'msg'	=> '发票申请删除成功',
				'code'	=> 1,
			];
		}else{
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '发票申请删除失败',
				'code'	=> 0,
			];
		}
	}
	
}