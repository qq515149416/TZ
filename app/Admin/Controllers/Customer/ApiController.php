<?php


namespace App\Admin\Controllers\Customer;

use App\Admin\Models\Customer\Api;
use App\Admin\Requests\Customer\ApiRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
	/**
	 * 展示
	 * @param  $state	-要查询的状态
	 * @return 
	 */
	public function show(ApiRequest $request){
		$par = $request->only(['state']);

		$model = new Api();
		$result = $model->show($par['state']);
		
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}

	/**
	 * 审核
	 * @param  $examine_res	-审核结果 , $apply_id	-需审核的id
	 * @return 
	 */
	public function examine(ApiRequest $request){
		$par = $request->only(['examine_res','apply_id']);

		$model = new Api();
		$result = $model->examine($par['examine_res'],$par['apply_id']);
		
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}
}