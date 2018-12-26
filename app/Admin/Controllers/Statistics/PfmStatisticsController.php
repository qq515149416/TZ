<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 统计业绩用控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-09-06 15:47:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Statistics\PfmStatistics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Admin\Requests\Statistics\PfmStatisticsRequest;
use Encore\Admin\Facades\Admin;




class PfmStatisticsController extends Controller
{
	use ModelForm;

	/**
	* 查找统计表的相关信息
	* @param 	$month  月份,格式date("Ym");
	* @return 	json 返回相关的信息
	*/
	public function index( PfmStatisticsRequest $request){
		
		$par = $request->only(['begin','end','business_type','customer_id']);
		$pfmModel = new PfmStatistics();
		switch ($par['business_type']) {
			//区分查询的业务类型,1-idc;2-高防ip
			case '1':
				if (isset($par['customer_id'])) {
					$return = $pfmModel->getIdcStatisticsBigByUser($par['begin'],$par['end'],$par['customer_id']);
				}else{
					$return = $pfmModel->getIdcStatisticsBig($par['begin'],$par['end']);
				}	
				break;
			case '2':
				if (isset($par['customer_id'])) {
					$return = $pfmModel->getDefenseipStatisticsBigByUser($par['begin'],$par['end'],$par['customer_id']);
				}else{
					$return = $pfmModel->getDefenseipStatisticsBig($par['begin'],$par['end']);
				}
				break;
			default:
				return tz_ajax_echo('','请选择正确业务类型',0);
				break;
		}
	
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	public function pfmSmall(PfmStatisticsRequest $request){
		$par = $request->only(['begin','end','business_type']);
		$user_id = Admin::user()->id;

		$pfmModel = new PfmStatistics();

		switch ($par['business_type']) {
			//区分查询的业务类型,1-idc;2-高防ip
			case '1':
				$return = $pfmModel->getIdcStatisticsSmall($par['begin'],$par['end'],$user_id);
				break;
			case '2':
				$return = $pfmModel->getDefenseipStatisticsSmall($par['begin'],$par['end'],$user_id);
				break;
			default:
				return tz_ajax_echo('','请选择正确业务类型',0);
				break;
		}
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}
}
