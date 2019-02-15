<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;


class RechargeModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_recharge_admin';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'recharge_amount','recharge_way','trade_no','recharge_uid','audit_status','auditor_id','audit_time','remarks','created_at','updated_at','deleted_at'];

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

		$clerk_id = Admin::user()->id;
		$yewuyuan_id = DB::table('tz_users')->where('id',$data['user_id'])->value('salesman_id');
		if($yewuyuan_id == null){
			$return['msg'] = '获取客户所属id失败';
			return $return;
		}

		if($clerk_id != $yewuyuan_id){
			$return['msg'] = '此客户不属于您';
			return $return;
		}

		$data['trade_no']	= 'tz_'.time().'_'.$data['user_id'];
		$data['audit_status']	= 0;
		$data['recharge_uid']	= $clerk_id;
	
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
				->select(DB::raw('tz_recharge_admin.id,tz_recharge_admin.user_id,tz_recharge_admin.recharge_amount,tz_recharge_admin.recharge_way,tz_recharge_admin.trade_no,tz_recharge_admin.recharge_uid,tz_recharge_admin.created_at,tz_recharge_admin.audit_status,tz_recharge_admin.remarks,b.name as recharger,c.name as customer_name,c.email as customer_email'))
				->orderBy('tz_recharge_admin.created_at','desc')
				->get();

				break;
			
			default:
				$list = $this
				->leftjoin('admin_users as b','tz_recharge_admin.recharge_uid','=','b.id')
				->leftjoin('tz_users as c','tz_recharge_admin.user_id','=','c.id')
				->select(DB::raw('tz_recharge_admin.id,tz_recharge_admin.user_id,tz_recharge_admin.recharge_amount,tz_recharge_admin.recharge_way,tz_recharge_admin.trade_no,tz_recharge_admin.recharge_uid,tz_recharge_admin.created_at,tz_recharge_admin.audit_status,tz_recharge_admin.remarks,b.name as recharger,c.name as customer_name,c.email as customer_email'))
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
		$user_id = Admin::user()->id;
		switch ($need) {
			case '*':
				$list = $this
				->leftjoin('admin_users as b','tz_recharge_admin.recharge_uid','=','b.id')
				->leftjoin('tz_users as c','tz_recharge_admin.user_id','=','c.id')
				->select(DB::raw('tz_recharge_admin.id,tz_recharge_admin.user_id,tz_recharge_admin.recharge_amount,tz_recharge_admin.recharge_way,tz_recharge_admin.trade_no,tz_recharge_admin.recharge_uid,tz_recharge_admin.created_at,tz_recharge_admin.audit_status,tz_recharge_admin.remarks,b.name as recharger,c.name as customer_name,c.email as customer_email'))
				->where('tz_recharge_admin.recharge_uid',$user_id)
				->orderBy('tz_recharge_admin.created_at','desc')
				->get();

				break;
			
			default:
				$list = $this
				->leftjoin('admin_users as b','tz_recharge_admin.recharge_uid','=','b.id')
				->leftjoin('tz_users as c','tz_recharge_admin.user_id','=','c.id')
				->select(DB::raw('tz_recharge_admin.id,tz_recharge_admin.user_id,tz_recharge_admin.recharge_amount,tz_recharge_admin.recharge_way,tz_recharge_admin.trade_no,tz_recharge_admin.recharge_uid,tz_recharge_admin.created_at,tz_recharge_admin.audit_status,tz_recharge_admin.remarks,b.name as recharger,c.name as customer_name,c.email as customer_email'))
				->where('tz_recharge_admin.audit_status',$need)
				->where('tz_recharge_admin.recharge_uid',$user_id)
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
	 * @param  Request $request [description]
	 * @return 
	 */
	public function auditRecharge($audit_status,$trade_id){
		$return['data'] 	= [];
		$return['code']	= 0;
		$auditor_id = Admin::user()->id;
		
		$trade = $this->find($trade_id);

		if($trade == null){
			$return['data'] 	= [];
			$return['code']	= 1;
			$return['msg'] = '无此充值审核单';
			return $return;
		}
		if($trade->audit_status != 0){
			$return['msg'] = '该审核单已审核完毕';
			return $return;
		}
		$test = DB::table('tz_recharge_flow')->where('trade_no',$trade->trade_no)->value('id');
		if($test != null){
			DB::rollBack();
			$return['msg'] = '该审核单的充值流水已存在,请确认审核单';
			return $return;
		}

		DB::beginTransaction();
		$trade->auditor_id	= $auditor_id;
		$trade->audit_status	= $audit_status;
		$trade->audit_time	= date("Y-m-d H:i:s",time());

		$audit_res = $trade->save();

		if($audit_res != true){
			DB::rollBack();
			$return['msg'] = '更新审核状态失败';
			return $return;
		}

		if($audit_status == -1){
			DB::commit();
			$return['msg'] 	= '审核成功,已驳回此充值单';
			$return['code'] 	= 1;
			return $return;
			exit;
		}

		$money_before = DB::table('tz_users')->where('id',$trade->user_id)->value('money');
		if($money_before == null){
			DB::rollBack();
			$return['msg'] = '获取客户余额失败';
			return $return;
		}
		$money_after = bcadd($money_before,$trade->recharge_amount,2);

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
			
			default:
				$voucher = '无此状态';
				break;
		}
		$data = [
			'user_id'		=> $trade->user_id,
			'recharge_amount'	=> $trade->recharge_amount,
			'recharge_way'		=> 3,
			'trade_no'		=> $trade->trade_no,
			'voucher'		=> $voucher,
			'timestamp'		=> $trade->audit_time,
			'trade_status'		=> 1,
			'money_before'		=> $money_before,
			'money_after'		=> $money_after,
			'month'			=> date("Ym"),
			'created_at'		=> date("Y-m-d H:i:s"),
		];
		

		$create_flow = DB::table('tz_recharge_flow')->insert($data);
		if($create_flow != true){
			DB::rollBack();
			$return['msg'] = '创建充值流水失败';
			return $return;
		}

		$update_money = DB::table('tz_users')->where('id',$trade->user_id)->update(['money' => $money_after]);
		if($update_money != true){
			DB::rollBack();
			$return['msg'] = '更新用户余额失败';
			return $return;
		}
		DB::commit();
		$return['code'] 	= 1;
		$return['msg'] 	= '审核成功,充值到账';
		return $return;
	}


	public function getRechargeFlow($way,$key = ''){   
		switch ($way) {
			 case 'my_all':
				  $clerk_id = Admin::user()->id;
				  $flow = DB::table('tz_users')
						->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
						->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.id'))
						->where('b.trade_status',1)
						->where('tz_users.salesman_id',$clerk_id)
						->orderBy('b.timestamp','desc')
						->get();    
				 break;

			 case 'customer_id':
				  $flow = DB::table('tz_users')
						->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
						->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.id'))
						->where('b.trade_status',1)
						->where('tz_users.id',$key)
						->orderBy('b.timestamp','desc')
						->get();    
				 break;

			case '*':
				  $flow = DB::table('tz_users')
						->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
						->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.id'))
						->where('b.trade_status',1)
						->orderBy('b.timestamp','desc')
						->get();    
				 break;

			case 'byMonth':
				  $flow = DB::table('tz_users')
						->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
						->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.id'))
						->where('b.trade_status',1)
						->where('b.month',$key)
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
				$flow[$i]['salesman_name'] = '自助充值';
			}else{
				$salesman_id = DB::table('tz_recharge_admin')->where('trade_no',$flow[$i]['trade_no'])->value('recharge_uid');
				$flow[$i]['salesman_name'] = DB::table('admin_users')->where('id',$salesman_id)->value('name');
			}
			$flow[$i]['recharge_way'] = $recharge_way[$flow[$i]['recharge_way']];
			$flow[$i]['customer_name'] = $flow[$i]['customer_name'] ? $flow[$i]['customer_name'] : $flow[$i]['email'];
		}
		$return['data'] = $flow;
		$return['msg'] = '获取成功';
		$return['code'] = 1;
		return $return;
	}

}
