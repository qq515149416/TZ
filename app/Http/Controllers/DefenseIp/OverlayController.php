<?php


namespace App\Http\Controllers\DefenseIp;

use App\Http\Models\DefenseIp\OverlayModel;
use App\Http\Requests\DefenseIp\OverlayRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OverlayController extends Controller
{
	
	public function showOverlay(OverlayRequest $request){
		$model = new OverlayModel();

		$res = $model->showOverlay();

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  后台工作人员为客户购买叠加包
	 */
	public function buyNowByCustomer(OverlayRequest $request){
		$par = $request->only(['overlay_id','buy_num']);
		
		$model = new OverlayModel();

		$res = $model->buyNowByCustomer($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  展示客户所属叠加包
	 */
	public function showBelong(OverlayRequest $request){
		$par = $request->only(['status']);

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

	/**
	 * 将叠加包绑定到IDC业务的机器IP上
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function useOverlayToIDC(Request $request){
		$param = $request->only(['belong_id','order_id']);
		$model = new OverlayModel();
		$result = $model->useOverlayToIDC($param);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}

	
}