<?php


namespace App\Admin\Controllers\DefenseIp;

use App\Admin\Models\DefenseIp\BusinessModel;
use App\Admin\Requests\DefenseIp\BusinessRequest;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\DefenseIp\ApiController;
use Illuminate\Support\Facades\DB;
use App\Admin\Models\DefenseIp\StoreModel;

class SetController extends Controller
{
	
	/**
	 * 设定目标IP
	 * 用于设定高防IP的防护IP
	 *
	 * 接口:/home/defenseIp/setTarget
	 * 接口类型:POST
	 * 参数:
	 *      business_id:高防IP业务ID
	 *      target_ip :高防目标IP
	 *
	 * 返回参数:  ....
	 * 状态码:   ....
	 */
	public function setTarget(Request $request)
	{
		// if(Admin::user()->isAdministrator()){
		// 	dd('1') ;//是管理员
		// }else{
		// 	dd('0') ;//不是管理员
		// }
		$is_admin 	= Admin::user()->isAdministrator();

		if(!isset($request['target_ip'])  || !isset($request['b_id']) ){
			return tz_ajax_echo([], '请提供齐参数', 0); 
		}

		$b_id 		= $request['b_id'];//获取参数,高防IP业务ID
		$targetIp     	= trim($request['target_ip']);  //获取参数,去除左右两边空格

		//        $businessData = BusinessModel::find($busId); //根据业务ID获取相关业务数据
		$businessData = BusinessModel::find($b_id); //根据业务ID获取相关业务数据
		
		//判断有误相关的业务数据
		if ($businessData == null) {
			return tz_ajax_echo([], '没有找到相关的业务', 0);
		}
		// $businessData = $businessData->toArray();  //将业务数据转换成数组

		//判断业务是否为管理员或者业务员名下

		if(!Admin::user()->isAdministrator() ){	//判断是否管理员
			$admin_id = DB::table('tz_users')->where('id',$businessData->user_id)->value('salesman_id');
			if($admin_id != Admin::user()->id){
				return tz_ajax_echo([], '非名下客户', 0); 
			}
		}
		DB::beginTransaction();

		$businessData->target_ip = $targetIp;  //更新高防IP业务目标IP
		if(!$businessData->save()){
			DB::rollBack();
			return tz_ajax_echo([], '储存失败', 0); 
		}

		$defense_ip = StoreModel::find($businessData->ip_id);//根根据高防ID资源获取IP

		if($defense_ip == null){
			DB::rollBack();
			return tz_ajax_echo([], '高防ip获取失败,请查看数据库', 0); 
		}
		$apiModel = new ApiController();
		//调用api接口,先是尝试插入

		$apiData                    = json_decode($apiModel->createTarget($defense_ip->ip, $targetIp), true); //使用api接口更新目标IP地址
		//$apiData                    = json_decode($apiModel->createTarget('1.1.1.1', '2.2.2.3'), true);
	
		//$apiData = json_decode('{"code":0,"msg":"ok","data":{"id":18,"type":0,"state":0,"node_id":1,"ip":"1.1.1.1","vip":"2.2.2.2","utime":1554257150}}',true);
		//判断是否插入成功
		if ( $apiData['code'] != 0 ) {	
			//插入失败的话,尝试更新
			$apiData2                   = json_decode($apiModel->updateTarget($defense_ip->ip, $targetIp), true); //使用api接口更新目标IP地址
			//$apiData2                   = json_decode($apiModel->updateTarget('1.1.1.1', '2.2.2.3'), true); //使用api接口更新目标IP地址
			//判断是否成功更新
			if($apiData2['code'] != 0){
			//如果还是失败,回退,返回失败
				DB::rollBack();
				return tz_ajax_echo([], '失败', 0);
			}	
		}
		//没有失败就是成功了
		DB::commit();
		return tz_ajax_echo($apiData, '成功', 1);
	}


	/**
	 * 高防业务更换服务IP方法
	 * 
	 * 参数:
	 *      business_number	:业务编号
	 *      new_ip		:新ip
	 *
	 * 返回参数:  ....
	 * 状态码:   ....
	 */
	public function changeDIP(Request $request){
		//获取业务和新的ip
		$par = $request->only([ 'business_number' , 'new_ip']);
		if (!isset($par['business_number']) || !isset($par['new_ip'])) {
			return [
				'code'	=> 0,
				'msg'	=> '参数不全',
				];
		}
		$business = BusinessModel::where('business_number' , $par['business_number'])->first();
		$new_ip = StoreModel::where('ip',$par['new_ip'])->first();

		if ($business == null) {
			return [
				'code'	=> 0,
				'msg'	=> '业务不存在',
				];
		}
		if ($new_ip == null) {
			return [
				'code'	=> 0,
				'msg'	=> 'ip不存在',
				];
		}

		//判断业务状态
		if ($business->status != 1 && $business->status != 4) {
			return [
				'code'	=> 0,
				'msg'	=> '业务未使用',
				];
		}
		//开启事务
		DB::beginTransaction();

		//先将业务的旧ip释放
		$old_ip = StoreModel::find($business->ip_id);
		if ($old_ip == null) {
			return [
				'code'	=> 0,
				'msg'	=> '业务旧ip信息获取失败',
				];
		}

		//验证新旧ip配置是否一样
		if ($old_ip->site != $new_ip->site || $old_ip->protection_value != $new_ip->protection_value) {
			DB::rollBack();
			return [
				'code'	=> 0,
				'msg'	=> '新旧ip配置不一致',
				];
		}

		$change_status = DB::table('idc_ips')->where('ip',$old_ip->ip)->update(['ip_status' => 0]);	//idc库里改状态
		$change_status = DB::table('idc_ips')->where('ip',$new_ip->ip)->update(['ip_status' => 4]);	//idc库里改状态
		$new_ip->status = 1;
		if (!$new_ip->save()) {	//高防库里改状态
			DB::rollBack();
			return [
				'code'	=> 0,
				'msg'	=> '新ip改状态失败',
				];
		}

		$old_ip->status = 0;
		if (!$old_ip->save()) {	//高防库里改状态
			DB::rollBack();
			return [
				'code'	=> 0,
				'msg'	=> '旧IP释放失败',
				];
		}

		//再更新业务里的ip_id
		$business->ip_id = $new_ip->id;
		if (!$business->save()) {	//高防库里改状态
			DB::rollBack();
			return [
				'code'	=> 0,
				'msg'	=> '新ip插入失败',
				];
		}

		$apiModel = new ApiController();
		//判断业务是否绑定了有目标ip
		if ($business->target_ip != null) {	//如果有目标的ip,则先解绑旧的ip信息
			$del_res = json_decode( $apiModel->deleteTarget($old_ip->ip) , true);

			if($del_res['code'] != 0){	//解绑失败
				DB::rollBack();
				return [
					'code'	=> 0,
					'msg'	=> '旧ip解绑失败',
					];
			}

			//再绑上新的ip
			$new_ip_res = json_decode($apiModel->createTarget($new_ip->ip, $business->target_ip), true); //使用api接口插入IP地址
			
			//判断是否插入成功
			if ( $new_ip_res['code'] != 0 ) {	
				//插入失败的话,尝试更新
				$new_ip_res2 = json_decode($apiModel->updateTarget($new_ip->ip, $business->target_ip), true); //使用api接口更新目标IP地址
				//判断是否成功更新
				if($new_ip_res2['code'] != 0){
				//如果还是失败,回退,返回失败
					DB::rollBack();
					return [
						'code'	=> 0,
						'msg'	=> '新服务ip绑目标ip失败',
						];
				}	
			}
		}
		//都成功后
		DB::commit();
		return [
			'code'	=> 1,
			'msg'	=> '换绑成功',
			];
	}


}