<?php


namespace App\Admin\Controllers\DefenseIp;

use App\Admin\Models\DefenseIp\OverlayModel;
use App\Admin\Requests\DefenseIp\OverlayRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OverlayController extends Controller
{
	
	/**
	 *  创建叠加包
	 */
	public function insert(OverlayRequest $request){
		$par = $request->only(['name', 'description','site','protection_value','price','validity_period']);

		$model = new OverlayModel();

		$res = $model->insert($par);

		if($res){
			return tz_ajax_echo([],'创建成功',1);	
		}else{
			return tz_ajax_echo([],'创建失败',0);
		}
	}
	
	/**
	 *  删除叠加包
	 */
	public function del(OverlayRequest $request){
		$par = $request->only(['del_id']);

		$model = new OverlayModel();

		$res = $model->del($par['del_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  编辑叠加包
	 */
	public function edit(OverlayRequest $request){
		$par = $request->only(['name', 'description','sell_status','edit_id']);

		$model = new OverlayModel();

		$res = $model->edit($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  展示叠加包
	 */
	public function show(OverlayRequest $request){
		$par = $request->only(['site']);

		$model = new OverlayModel();

		$res = $model->show($par['site']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  后台工作人员为客户购买叠加包
	 */
	public function buyNowByAdmin(OverlayRequest $request){
		$par = $request->only(['overlay_id','buy_num','price','user_id']);

		$model = new OverlayModel();

		$res = $model->buyNowByAdmin($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  展示客户所属叠加包
	 */
	public function showBelong(OverlayRequest $request){
		$par = $request->only(['user_id','status']);

		$model = new OverlayModel();

		$res = $model->showBelong($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  将叠加包使用在高防业务上
	 */
	public function useOverlayToDIP(OverlayRequest $request){
		$par = $request->only(['belong_id','business_number']);

		$model = new OverlayModel();

		$res = $model->useOverlayToDIP($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	// public function test(){
	// 	$model = new OverlayBelongModel();
	// 	//当前date
	// 	$now = date("Y-m-d H:i:s");
	// 	//获取正在生效且已过期叠加包
	// 	$pastOverlay = $model->where('status',1)
	// 			->where('end_time','<',$now)
	// 			->get();
	// 	if ($pastOverlay->isEmpty()) {
	// 		return 0;
	// 	}
	// 	$num = 0;

	// 	//循环每个此类叠加包
	// 	foreach ($pastOverlay as $k => $v) {
	// 	   	DB::beginTransaction();
	// 	   	$v->status = 2;
	// 	   	//更改状态
	// 	   	if ( $v->save() ) {		//更改状态成功
	// 	   		//获取叠加包的防御值
	// 	   		$protection_value = DB::table('tz_overlay')->where('id',$v->overlay_id)->value('protection_value');
	// 	   		//获取业务信息tz_defenseip_business
	// 	   		$business = BusinessModel::where('business_number',$v->target_business)->first();
	// 	   		//获取业务原本防御值
	// 	   		$d_ip = DB::table('tz_defenseip_store')->where('id',$business->ip_id)->whereNull('deleted_at')->first();
		   		
	// 	   		if($protection_value == null || $business == null || $d_ip == null){	//如果获取失败
	// 	   			DB::rollBack();
	// 	   		}else{				//获取成功的话就减掉

	// 	   			//原有防御值
	// 	   			$ori_protection_value = $d_ip->protection_value;	
	// 	   			//去除掉过期叠加包防御值后的额外防御值
	// 	   			$extra_protection = bcsub($business->extra_protection, $protection_value,0);
	// 	   			if ($extra_protection < 0 ) {
	// 	   				$extra_protection = 0;
	// 	   			}

	// 	   			//更新业务里的额外防御值
	// 	   			$business->extra_protection = $extra_protection;
	// 	   			if ( !$business->save() ) {
	// 	   				DB::rollBack();
	// 	   			}else{
	// 	   				//更新现在的牵引值
	// 	   				$after_protection = bcadd($ori_protection_value, $extra_protection,0);
	// 	   				$api_controller = new ApiController();
	// 	   				$res = $api_controller->setProtectionValue($d_ip->ip,$after_protection);
	// 	   				//$res = $api_controller->setProtectionValue('1.1.1.1',0);
	// 	   				if ($res != 'editok' && $res !='ok') {
	// 	   					DB::rollBack();
	// 	   				}else{
	// 	   					$num++;
	// 	   					DB::commit();	
	// 	   				}
	// 	   			}
	// 	   		}
	// 	   	}else{
	// 	   		DB::rollBack();
	// 	   	}
	// 	}	
	// 	return $num;						   
	// }
}