<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\UserCenter;
use App\Http\Requests\Customer\UserCenterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Customer\Business;
use App\Http\Models\DefenseIp\BusinessModel;

class UserCentorController extends Controller
{

	/**
	* 修改用户的昵称
	* @return 
	*/
	public function resetNickName(UserCenterRequest $request)
	{
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();
		$par = $request->only(['nick_name']);
		$model = new UserCenter();
		$res = $model->resetNickName($user_id,$par['nick_name']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);

	}
	
	/**
	* 修改用户的登录账号
	* @return 
	*/
	public function resetAcc(UserCenterRequest $request)
	{
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();
		$par = $request->only(['user_name']);
		$model = new UserCenter();
		$res = $model->resetAcc($user_id,$par['user_name']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);

	}

	/**
	 * 客户信息相关的概况
	 * @param  Business      $idc_business 服务器业务模型
	 * @param  BusinessModel $dip_business 高防业务模型
	 * @return [type]                      [description]
	 */
	public function userSituation(Business $idc_business,BusinessModel $dip_business){
		//获取客户的相关信息
		$user = Auth::user();
		//获取客户绑定的业务员信息
		$sales = $idc_business->getSales($user->salesman_id);
		//统计在用服务器数量(含租用主机/托管主机/租用机柜)
		$idc['use'] = $idc_business->where(['client_id'=>$user->id])
								->whereBetween('business_status',[0,4])
								->where('remove_status','<',4)
								->count('id');
		//当前时间
		$now = date('Y-m-d H:i:s',time());
		//到期前五天
		$before_five = date('Y-m-d H:i:s',strtotime($now.'+5 days'));
		//5天内即将到期未续费/到期后未续费的服务器数量(含租用主机/托管主机/租用机柜)
		$idc['renew'] = $idc_business->where(['client_id'=>$user->id])
								->whereBetween('business_status',[0,4])
								->where('endding_time','<=',$before_five)
								->where('remove_status','<',4)
								->count('id');
		//在使用高防IP数量
		$dip['use'] = $dip_business->where(['user_id'=>$user->id])
								->whereNotIn('status', [3])
								->count('id');
		//5天内即将到期未续费/到期后未续费的高防数量
		$dip['renew'] = $dip_business->where(['user_id'=>$user->id])
								->whereNotIn('status', [3])
								->where('end_at','<=',$before_five)
								->count('id');

		$data['user'] = $user;
		$data['sales'] = $sales['data'];
		$data['idc'] = json_decode(json_encode($idc));
		$data['dip'] = json_decode(json_encode($dip)) ;
		
		return tz_ajax_echo($data,'获取成功',1);
	
	}
}
