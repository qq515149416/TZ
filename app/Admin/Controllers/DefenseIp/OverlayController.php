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
}