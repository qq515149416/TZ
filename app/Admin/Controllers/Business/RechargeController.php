<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\RechargeModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\RechargeRequest;
use Encore\Admin\Facades\Admin;

/**
 * 客户信息
 */
class RechargeController extends Controller
{
	use ModelForm;

	 /**
	 * 后台手动替客户充值余额---创建审核单
	 * @param  Request $request [description]
	 * @return 
	 */
	public function rechargeByAdmin(RechargeRequest $request){
		$data = $request->only(['user_id','recharge_amount','recharge_way','remarks']);
		$model = new RechargeModel();
		$res = $model->rechargeByAdmin($data);
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 后台手动替客户充值余额---显示充值审核订单/财务用接口
	 * @param  Request $request [description]
	 * @return 
	 */
	public function showAuditRechargeBig(RechargeRequest $request){
		$info = $request->only(['audit_status']);
		$need = $info['audit_status'];

		$model = new RechargeModel();
		$res = $model->showAuditRechargeBig($need);
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 后台手动替客户充值余额---显示充值审核订单/业务员用接口
	 * @param  Request $request [description]
	 * @return 
	 */
	public function showAuditRechargeSmall(RechargeRequest $request){
		$info = $request->only(['audit_status']);
		$need = $info['audit_status'];
		
		$model = new RechargeModel();
		$res = $model->showAuditRechargeSmall($need);
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	/**
	 * 后台手动替客户充值余额---进行审核
	 * @param  Request $request [description]
	 * @return 
	 */
	public function auditRecharge(RechargeRequest $request){
		$info = $request->only(['audit_status','trade_id']);
		$audit_status = $info['audit_status'];
		$trade_id = $info['trade_id'];
		if($audit_status == 0){
			return tz_ajax_echo('','审核结果不能为0',0);
		}
		$model = new RechargeModel();
		$res = $model->auditRecharge($audit_status,$trade_id);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	/**
	 * 后台根据客户id获取对应客户充值单接口
	 * @param  Request $request [description]
	 * @return 
	 */
	public function getRecharge(RechargeRequest $request){
	
		$info = $request->only(['customer_id']);
		if(isset($info['customer_id'])){
			$way = 'customer_id';
			$customer_id = $info['customer_id'];
		}else{
			  $way = 'my_all';
			  $customer_id = '';
		}
		
		$model = new RechargeModel();
		$res = $model->getRechargeFlow($way,$customer_id);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 后台获取所有客户充值单接口
	 * @param  Request $request [description]
	 * @return 
	 */
	public function getAllRecharge(RechargeRequest $request){

		$info = $request->only(['month']);
		if(isset($info['month'])){
			$way = 'byMonth';
			$key = $info['month'];
		}else{
			$way = '*';
			$key = '';
		}

		$model = new RechargeModel();
		$res = $model->getRechargeFlow($way,$key);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 后台手动替客户充值余额---修改充值申请的金额与时间/财务用接口
	 * @param  Request $request [description]
	 * @return 
	 */
	public function editAuditRecharge(RechargeRequest $request){
		$info = $request->only(['recharge_amount','recharge_way','trade_id']);
	
		$model = new RechargeModel();
		$res = $model->editAuditRecharge($info['recharge_amount'],$info['recharge_way'],$info['trade_id']);
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
