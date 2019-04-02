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

		$businessData['defense_ip'] = $defense_ip->ip; 
		
		//调用api接口,正式的请打开
		//$apiData                    = json_decode($apiModel->createTarget($businessData['defense_ip'], $targetIp), true); //使用api接口更新目标IP地址

		$apiData = [
			'code'	=> 0,
			] ;//调试模式,正式服记得关闭!!!!

		//判断是否更新成功
		if ( $apiData['code'] != 0 ) {
			//成功
			DB::rollBack();
			return tz_ajax_echo([], '失败', 0);
		}
		DB::commit();
		return tz_ajax_echo($apiData, '成功', 1);
	}

	

	
}