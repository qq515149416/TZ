<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\Customer\Customer;
use \Exception;
use App\Admin\Models\Business\RechargeFlowModel;



/***
*是个后台手动充值的模型
*
*
*/
class RechargeModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_recharge_admin';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'recharge_amount','recharge_way','trade_no','recharge_uid','audit_status','auditor_id','audit_time','remarks','created_at','updated_at','deleted_at','pay_at','tax','recharger'];

	/**
	 * 查找业务员姓名
	 * @param  int $id oa_staff表的admin_users_id字段的值
	 * @return string     返回对应业务员的姓名
	 */
	public function clerk($id){
		$clerk = DB::table('admin_users')->where(['id'=>$id])->value('name');
		if(empty($clerk)){
			$clerk = '未绑定业务员';
		}
		return $clerk;
	}


	/**
	 * 生成未审核充值订单
	 * @param  
	 * @return 
	 */
	public function rechargeByAdmin($data){
		$return = [
			'data'  => [],
			'msg'   => '',
			'code'  => 0,
		];

		$clerk = Admin::user();
		$yewuyuan_id = DB::table('tz_users')->where('id',$data['user_id'])->value('salesman_id');
		if($yewuyuan_id == null){
			$return['msg'] = '获取客户所属id失败';
			return $return;
		}

		if($clerk->id != $yewuyuan_id){
			$return['msg'] = '此客户不属于您';
			return $return;
		}
		//生成订单信息
		$data['trade_no']	= 'tz_'.time().'_'.substr(md5($data['user_id'].'tz'),0,4);
		$data['audit_status']	= 0;
		$data['recharge_uid']	= $clerk->id;
		$data['recharger']	= $clerk->name;
		
		if(isset($data['time'])){
			$data['pay_at'] = $data['time'];
		}
		// dd($data);
		$res = $this->create($data);
		if($res == false){  	
			$return['msg'] = '充值审核单创建失败';
		}else{
			$return['data']	= $res->id;
			$return['msg'] 	= '充值审核单创建成功!';
			$return['code'] 	= 1;
		}
		return $return;
	}

	/**
	 * 后台手动替客户充值余额---显示充值审核订单/财务用接口
	 * @param  Request $request [description]
	 * @return 
	 */
	public function showAuditRechargeBig($need){
		switch ($need) {
			case '*':
				$list = $this
				->leftjoin('admin_users as b','tz_recharge_admin.recharge_uid','=','b.id')
				->leftjoin('tz_users as c','tz_recharge_admin.user_id','=','c.id')
				->select(DB::raw('tz_recharge_admin.id,tz_recharge_admin.tax,tz_recharge_admin.pay_at,tz_recharge_admin.user_id,tz_recharge_admin.recharge_amount,tz_recharge_admin.recharge_way,tz_recharge_admin.trade_no,tz_recharge_admin.recharge_uid,tz_recharge_admin.created_at,tz_recharge_admin.audit_status,tz_recharge_admin.remarks,b.name as recharger,c.nickname as customer_name'))
				->orderBy('tz_recharge_admin.created_at','desc')
				->get();

				break;
			
			default:
				$list = $this
				->leftjoin('admin_users as b','tz_recharge_admin.recharge_uid','=','b.id')
				->leftjoin('tz_users as c','tz_recharge_admin.user_id','=','c.id')
				->select(DB::raw('tz_recharge_admin.id,tz_recharge_admin.tax,tz_recharge_admin.pay_at,tz_recharge_admin.user_id,tz_recharge_admin.recharge_amount,tz_recharge_admin.recharge_way,tz_recharge_admin.trade_no,tz_recharge_admin.recharge_uid,tz_recharge_admin.created_at,tz_recharge_admin.audit_status,tz_recharge_admin.remarks,b.name as recharger,c.nickname as customer_name'))
				->where('tz_recharge_admin.audit_status',$need)
				->orderBy('tz_recharge_admin.created_at','desc')
				->get();

				break;
		}
		
		if($list->isEmpty()){
			$return = [
				'data'	=> [],
				'msg'	=> '无该状态审核订单或获取失败',
				'code'	=> 1,
			];
		}else{
			$list = json_decode($list,true);
			for ($i=0; $i < count($list); $i++) { 
				$list[$i]['recharge_num'] = $list[$i]['recharge_way'];
				switch ($list[$i]['recharge_way']) {
					case '1':
						$list[$i]['recharge_way'] = '腾正公帐(建设银行)';
						break;
					case '2':
						$list[$i]['recharge_way'] = '腾正公帐(工商银行)';
						break;
					case '3':
						$list[$i]['recharge_way'] = '腾正公帐(招商银行)';
						break;
					case '4':
						$list[$i]['recharge_way'] = '腾正公帐(农业银行)';
						break;
					case '5':
						$list[$i]['recharge_way'] = '正易公帐(中国银行)';
						break;
					case '6':
						$list[$i]['recharge_way'] = '支付宝';
						break;
					case '7':
						$list[$i]['recharge_way'] = '公帐支付宝';
						break;
					case '8':
						$list[$i]['recharge_way'] = '财付通';
						break;
					case '9':
						$list[$i]['recharge_way'] = '微信支付';
						break;
					case '10':
						$list[$i]['recharge_way'] = '新支付宝';
						break;
					case '11':
						$list[$i]['recharge_way'] = '腾正公帐(东莞银行)';
						break;
					default:
						$list[$i]['recharge_way'] = '无此状态';
						break;
				}
			}
			$return = [
				'data'	=> $list,
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
		}
		return $return;
	}

	/**
	 * 后台手动替客户充值余额---显示充值审核订单/业务员用接口
	 * @param  Request $request [description]
	 * @return 
	 */
	public function showAuditRechargeSmall($need){
		if(Admin::user()->inRoles(['CMO','administrator','TZ_admin','MD'])){
			/**
			 * 当账号角色是市场总监/管理员/总经理时查询所有
			 * @var [type]
			 */
			$where = [];
		} else {
			/**
			 * 当账号角色不是是市场总监/管理员/总经理时根据充值人员的id作为条件进行查询
			 * @var [type]
			 */
			$user_id = Admin::user()->id;
			$where = ['tz_recharge_admin.recharge_uid'=>$user_id];
		}
		switch ($need) {
			case '*':
				$list = $this
				->leftjoin('admin_users as b','tz_recharge_admin.recharge_uid','=','b.id')
				->leftjoin('tz_users as c','tz_recharge_admin.user_id','=','c.id')
				->select(DB::raw('tz_recharge_admin.id,tz_recharge_admin.tax,tz_recharge_admin.pay_at,tz_recharge_admin.user_id,tz_recharge_admin.recharge_amount,tz_recharge_admin.recharge_way,tz_recharge_admin.trade_no,tz_recharge_admin.recharge_uid,tz_recharge_admin.created_at,tz_recharge_admin.audit_status,tz_recharge_admin.remarks,b.name as recharger,c.nickname as customer_name'))
				->where($where)
				->orderBy('tz_recharge_admin.created_at','desc')
				->get();

				break;
			
			default:
				$list = $this
				->leftjoin('admin_users as b','tz_recharge_admin.recharge_uid','=','b.id')
				->leftjoin('tz_users as c','tz_recharge_admin.user_id','=','c.id')
				->select(DB::raw('tz_recharge_admin.id,tz_recharge_admin.tax,tz_recharge_admin.pay_at,tz_recharge_admin.user_id,tz_recharge_admin.recharge_amount,tz_recharge_admin.recharge_way,tz_recharge_admin.trade_no,tz_recharge_admin.recharge_uid,tz_recharge_admin.created_at,tz_recharge_admin.audit_status,tz_recharge_admin.remarks,b.name as recharger,c.nickname as customer_name'))
				->where('tz_recharge_admin.audit_status',$need)
				->where($where)
				->orderBy('tz_recharge_admin.created_at','desc')
				->get();

				break;
		}
		
		if($list->isEmpty()){
			$return = [
				'data'	=> [],
				'msg'	=> '无该状态审核订单或获取失败',
				'code'	=> 1,
			];
		}else{
			$list = json_decode($list,true);

			for ($i=0; $i < count($list); $i++) { 
				switch ($list[$i]['recharge_way']) {
					case '1':
						$list[$i]['recharge_way'] = '腾正公帐(建设银行)';
						break;
					case '2':
						$list[$i]['recharge_way'] = '腾正公帐(工商银行)';
						break;
					case '3':
						$list[$i]['recharge_way'] = '腾正公帐(招商银行)';
						break;
					case '4':
						$list[$i]['recharge_way'] = '腾正公帐(农业银行)';
						break;
					case '5':
						$list[$i]['recharge_way'] = '正易公帐(中国银行)';
						break;
					case '6':
						$list[$i]['recharge_way'] = '支付宝';
						break;
					case '7':
						$list[$i]['recharge_way'] = '公帐支付宝';
						break;
					case '8':
						$list[$i]['recharge_way'] = '财付通';
						break;
					case '9':
						$list[$i]['recharge_way'] = '微信支付';
						break;
					case '10':
						$list[$i]['recharge_way'] = '新支付宝';
						break;
					case '11':
						$list[$i]['recharge_way'] = '腾正公帐(东莞银行)';
						break;
					default:
						$list[$i]['recharge_way'] = '无此状态';
						break;
				}
			}
			$return = [
				'data'	=> $list,
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
		}
		return $return;
	}

	/**
	 * 后台手动替客户充值余额---进行审核
	 * 如果是已审核的,则改改到账时间和充值方式,未审核的就审核,未审核时可以更改充值金额.
	 * @param  Request $request [description]
	 * $audit_status	- 审核结果 ; 	$trade_id	- 充值单的id ; $recharge_amount		- 充值金额 ; $recharge_way	- 充值方式,	$time 	- 到账时间 , 
	 * $remarks 	- 备注 	;	$tax	-税额;
	 * @return 
	 */
	public function auditRecharge($audit_status,$trade_id,$recharge_amount,$recharge_way,$time,$remarks,$tax){
	
		//获取信息
		$trade = $this->find($trade_id);
		if($trade == null){
			return [
				'data'	=> [],
				'code'	=> 0,
				'msg'	=> '无此充值审核单',
			];
		}

		//判断:如果审核结果是通过的,而订单的支付时间和到账时间都是空的话,就返回错误,必须要有个时间
		if($audit_status == 1 && $trade->pay_at == null && $time == ''){
			return [
				'data'	=> [],
				'code'	=> 0,
				'msg'	=> '请填写到账时间',
			];
		}
		

		if($trade->audit_status != 0){		//如果是已经审核的状态,可以改到账时间和到账的充值方式
			
			if($trade->audit_status != 1){	//如果是驳回的,直接返回错误
				return [
					'data'	=> [],
					'msg'	=> '驳回的审核单无法编辑',
					'code'	=> 0,
				];
			}else{				//已审核并通过的,可以编辑到账时间和充值方式
				$res = $this->doEdit($trade_id,$recharge_way,$time);
				if($res){
					return [
						'data'	=> [],
						'msg'	=> '编辑成功',
						'code'	=> 1,
					];
				}else{
					return [
						'data'	=> [],
						'msg'	=> '编辑失败',
						'code'	=> 0,
					];
				}
			}
		
		}else{					//如果是未审核状态,就去审核
			$res = $this->doAudit($audit_status,$trade_id,$recharge_amount,$recharge_way,$time,$remarks,$tax);
			return [
				'data'	=> [],
				'msg'	=> $res['msg'],
				'code'	=> $res['code'],
			];
			
		}

	
	}

	//未审核的充值申请的审核方法
	//参数跟 auditRecharge 一样
	protected function doAudit($audit_status,$trade_id,$recharge_amount,$recharge_way,$time,$remarks,$tax){
		DB::beginTransaction();
		try {  	//尝试,出错就抛出错误

			//获取信息
			$trade = $this->find($trade_id);
			if($trade == null){
				$error = '获取审核单信息失败';
				throw new Exception($error,0);  	//抛出错误
			}
			//检查流水是否已存在
			$test = DB::table('tz_recharge_flow')->where('trade_no',$trade->trade_no)->whereNull('deleted_at')->value('id');
			if($test != null){
				$error = '该审核单的充值流水已存在,请确认审核单';
				throw new Exception($error,3);  
			}

			//先把通不通过都要更新的信息替换掉
			$trade->audit_status		= $audit_status;
			$trade->audit_time		= date("Y-m-d H:i:s",time());
			$trade->auditor_id		= Admin::user()->id;
			if($remarks != ''){
				$trade->remarks	= $remarks;	
			}

			//如果是不通过,就直接更新审核单
			if($audit_status == -1){
				if($trade->save()){
					DB::commit();
					return [
						'code'	=> 1,
						'msg'	=> '审核成功,已驳回',
					];
				}else{
					$error = '更新审核单失败';  
					throw new Exception($error,2);  
				}
			}
			//以下是审核通过

			//如果是通过的话,把通过需要的信息补齐
			$trade->recharge_way 		= $recharge_way;
			$trade->recharge_amount 	= $recharge_amount;
			if($time != ''){
				$trade->pay_at 		= $time;	
			}
			if($tax != ''){
				$trade->tax 		= $tax;	
			}
			//更新
			$update_trade = $trade->save();
			if(!$update_trade){
				$error = '更新审核单失败';  
				throw new Exception($error,2);  
			}

			//更新过了审核单之后,要更新用户余额

			$user_model = New Customer();
			$update_user = $user_model->find($trade->user_id);

			if($update_user == null){
				$error = '获取客户信息失败';  
				throw new Exception($error,0);
			}

			//计算余额
			$money_before = $update_user->money;//原有余额,客户信息处获取的

			$money_after = bcadd($money_before,$recharge_amount,2);//原有的加上充值金额

			$update_user->money = $money_after;//再更新回客户处

			//更新用户余额
			if(!$update_user->save()){
				$error = '更新用户余额失败';  
				throw new Exception($error,4);
			}

			//成功更新余额后,生成流水单

			switch ($trade->recharge_way) {
				case '1':
					$voucher = '腾正公帐(建设银行)';
					break;
				case '2':
					$voucher = '腾正公帐(工商银行)';
					break;
				case '3':
					$voucher = '腾正公帐(招商银行)';
					break;
				case '4':
					$voucher = '腾正公帐(农业银行)';
					break;
				case '5':
					$voucher = '正易公帐(中国银行)';
					break;
				case '6':
					$voucher = '支付宝';
					break;
				case '7':
					$voucher = '公帐支付宝';
					break;
				case '8':
					$voucher = '财付通';
					break;
				case '9':
					$voucher = '微信支付';
					break;
				case '10':
					$voucher = '新支付宝';
					break;
				case '11':
					$voucher = '腾正公帐(东莞银行)';
					break;
				default:
					$voucher = '无此状态';
					break;
			}
			$data = [
				'user_id'			=> $trade->user_id,
				'recharge_amount'	=> $trade->recharge_amount,
				'recharge_way'		=> 3,
				'trade_no'		=> $trade->trade_no,
				'voucher'		=> $voucher,
				'timestamp'		=> $trade->pay_at,
				'trade_status'		=> 1,
				'money_before'		=> $money_before,
				'money_after'		=> $money_after,
				'month'			=> date("Ym"),
				'tax'			=> $trade->tax,
			];
			
			$create_flow = RechargeFlowModel::create($data);

			if($create_flow != true){
				$error = '创建充值流水失败';  
				throw new Exception($error,5);
			}

			DB::commit();
			return [
					'code'	=> 1,
					'msg'	=> '审核成功,已充值到账',
				];	
		} catch (Exception $e) {  //如果出现错误的话,回退
			DB::rollBack();
			return [
				'code'	=> $e->getCode(),	//接收抛出的错误并返回
				'msg'	=> $e->getMessage(),
			];
		} 
	}
	//审核过了又审核的编辑方法,可以改 到账时间和到账银行
	//就是找出来然后改掉就好了
	protected function doEdit($trade_id,$recharge_way,$time){

		DB::beginTransaction();

		$trade = $this->find($trade_id);
		if($trade == null){
			return false;
		}

		$trade->recharge_way = $recharge_way;
		if($time != ''){
			$trade->pay_at = $time;	
		}

		if(!$trade->save()){
			DB::rollBack();
			return false;
		}
		$flow = RechargeFlowModel::where('trade_no',$trade->trade_no)->first();
		if($flow == null){
			DB::rollBack();
			return false;
		}
		switch ($recharge_way) {
			case '1':
				$voucher = '腾正公帐(建设银行)';
				break;
			case '2':
				$voucher = '腾正公帐(工商银行)';
				break;
			case '3':
				$voucher = '腾正公帐(招商银行)';
				break;
			case '4':
				$voucher = '腾正公帐(农业银行)';
				break;
			case '5':
				$voucher = '正易公帐(中国银行)';
				break;
			case '6':
				$voucher = '支付宝';
				break;
			case '7':
				$voucher = '公帐支付宝';
				break;
			case '8':
				$voucher = '财付通';
				break;
			case '9':
				$voucher = '微信支付';
				break;
			case '10':
				$voucher = '新支付宝';
				break;
			case '11':
				$voucher = '腾正公帐(东莞银行)';
				break;
			default:
				$voucher = '无此状态';
				break;
		}
	
		$flow->timestamp = $trade->pay_at;

		$flow->voucher = $voucher;
	
		if($flow->save()){
			DB::commit();
			return true;
		}else{
			DB::rollBack();
			return false;
		}

	}
	//获取充值流水的方法
	public function getRechargeFlow($way,$key = ''){   
		switch ($way) {
			 case 'my_all':
			 	if(Admin::user()->inRoles(['CMO','administrator','TZ_admin','MD'])){
					/**
					 * 当账号角色是市场总监/管理员/总经理时查询所有
					 * @var [type]
					 */
					$where = [];
				} else {
					/**
					 * 当账号角色不是是市场总监/管理员/总经理时根据业务人员的id作为条件进行查询
					 * @var [type]
					 */
					$clerk_id = Admin::user()->id;
					$where = ['tz_users.salesman_id'=>$clerk_id];
				}
				  
				  $flow = DB::table('tz_users')
						->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
						->select(DB::raw('tz_users.id as customer_id,tz_users.nickname as customer_name,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.id,b.tax'))
						->where('b.trade_status',1)
						->where($where)
						->whereNull('deleted_at')
						->orderBy('b.timestamp','desc')
						->get();    
				 break;

			 case 'customer_id':
				  $flow = DB::table('tz_users')
						->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
						->select(DB::raw('tz_users.id as customer_id,tz_users.nickname as customer_name,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.id,b.tax'))
						->where('b.trade_status',1)
						->where('tz_users.id',$key)
						->whereNull('deleted_at')
						->orderBy('b.timestamp','desc')
						->get();    
				 break;

			case '*':
				  $flow = DB::table('tz_users')
						->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
						->select(DB::raw('tz_users.id as customer_id,tz_users.nickname as customer_name,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.id,b.tax'))
						->where('b.trade_status',1)
						->whereNull('deleted_at')
						->orderBy('b.timestamp','desc')
						->get();   
			
				 break;

			case 'byMonth':
				  $flow = DB::table('tz_users')
						->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
						->select(DB::raw('tz_users.id as customer_id,tz_users.nickname as customer_name,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.id,b.tax'))
						->where('b.trade_status',1)
						->where('b.month',$key)
						->whereNull('deleted_at')
						->orderBy('b.timestamp','desc')
						->get();    
				 break;

			 default:
					$flow = '';
				 break;
		 } 
	   	
		if($flow->isEmpty()){
			$return['data'] = [];
			$return['msg'] = '无数据';
			$return['code'] = 1;
			return $return;
		}
		$flow = json_decode($flow,true);   
		$recharge_way = [ 1 => '支付宝' , 2 => '微信' , 3 => '工作人员手动充值' ];
		for ($i=0; $i < count($flow); $i++) { 
			if($flow[$i]['recharge_way'] != 3){
				$salesman_id = DB::table('tz_users')->where('id',$flow[$i]['customer_id'])->value('salesman_id');		
				$flow[$i]['recharge_way'] = $recharge_way[$flow[$i]['recharge_way']].' / 自助充值';
				$flow[$i]['bank'] = $flow[$i]['recharge_way'];
				$flow[$i]['remarks'] = '';
			}else{
				$salesman_id = DB::table('tz_recharge_admin')->where('trade_no',$flow[$i]['trade_no'])->value('recharge_uid');	
				$auditor_id = DB::table('tz_recharge_admin')->where('trade_no',$flow[$i]['trade_no'])->value('auditor_id');
				$bank_num = DB::table('tz_recharge_admin')->where('trade_no',$flow[$i]['trade_no'])->value('recharge_way');
				$remarks =  DB::table('tz_recharge_admin')->where('trade_no',$flow[$i]['trade_no'])->value('remarks');
				switch ($bank_num) {
					case '1':
						$bank = '腾正公帐(建设银行)';
						break;
					case '2':
						$bank = '腾正公帐(工商银行)';
						break;
					case '3':
						$bank = '腾正公帐(招商银行)';
						break;
					case '4':
						$bank = '腾正公帐(农业银行)';
						break;
					case '5':
						$bank = '正易公帐(中国银行)';
						break;
					case '6':
						$bank = '支付宝';
						break;
					case '7':
						$bank = '公帐支付宝';
						break;
					case '8':
						$bank = '财付通';
						break;
					case '9':
						$bank = '微信支付';
						break;
					case '10':
						$bank = '新支付宝';
						break;
					case '11':
						$bank = '腾正公帐(东莞银行)';
						break;
					default:
						$bank = '无此支付模式';
						break;
				}
				$flow[$i]['recharge_way'] = DB::table('admin_users')->where('id',$auditor_id)->value('name').' / 审核';
				$flow[$i]['bank'] = $bank;
				if ($remarks !== null) {
					$flow[$i]['remarks'] = $remarks;
				}
			}
			$flow[$i]['salesman_name'] = DB::table('admin_users')->where('id',$salesman_id)->value('name');	
		}

		$return['data'] = $flow;
		$return['msg'] = '获取成功';
		$return['code'] = 1;
		return $return;
	}

	
	public function editAuditRecharge($recharge_amount,$recharge_way,$trade_id,$pay_at){
		$trade = $this->find($trade_id);
		$trade->recharge_way = $recharge_way;
		$trade->recharge_amount = $recharge_amount;
		$trade->pay_at = $pay_at;
		$res = $trade->save();
		if($res != true){
			return [
				'data'	=> '',
				'msg'	=> '更改审核单失败',
				'code'	=> 0,
			];
		}else{
			return [
				'data'	=> '',
				'msg'	=> '更改审核单成功',
				'code'	=> 1,
			];
		}
	}
}
