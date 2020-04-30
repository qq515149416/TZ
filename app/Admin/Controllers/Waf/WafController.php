<?php


namespace App\Admin\Controllers\Waf;

use App\Admin\Models\Waf\WafModel;
use App\Admin\Requests\Waf\WafRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class WafController extends Controller
{
	
	/**
	 *  创建
	 */
	public function insert(WafRequest $request){
		$par = $request->only(['name', 'description','https_switch','web_switch','cc_switch','domain_num','price']);

		$model = new WafModel();

		$res = $model->insert($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}
	
	/**
	 *  删除
	 */
	public function del(WafRequest $request){
		$par = $request->only(['del_id']);

		$model = new WafModel();

		$res = $model->del($par['del_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  编辑
	 */
	public function edit(WafRequest $request){
		$par = $request->only(['name', 'description','sell_status','edit_id']);

		$model = new WafModel();

		$res = $model->edit($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  展示叠加包
	 */
	public function show(WafRequest $request){
		$par = $request->only(['sell_status']);

		$model = new WafModel();

		$res = $model->show($par);

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
		$par = $request->only(['belong_id','business_number','is_ignore']);

		$model = new OverlayModel();

		$res = $model->useOverlayToDIP($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  按机房展示客户所属叠加包
	 */
	public function showBelongBySite(OverlayRequest $request){
		//获取机房id, 需要查的状态
		$par = $request->only(['site','status']);
		$par['site'] = isset($par['site'])?$par['site']:'*';
		$par['status'] = isset($par['status'])?$par['status']:'*';
		$model = new OverlayModel();

		$res = $model->showBelongBySite($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 * 将叠加包绑定到IDC业务的机器IP上
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function useOverlayToIDC(Request $request){
		$param = $request->only(['belong_id','order_id','is_ignore']);
		$model = new OverlayModel();
		$result = $model->useOverlayToIDC($param);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}
}