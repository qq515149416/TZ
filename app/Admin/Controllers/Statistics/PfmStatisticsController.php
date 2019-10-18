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
use App\Admin\Controllers\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Carbon\Carbon;

class PfmStatisticsController extends Controller
{
	use ModelForm;

	/**
	 * 查找统计表的相关信息
	 * @param    
	 * @return    json 返回相关的信息
	 */
	public function index(PfmStatisticsRequest $request)
	{

		$par      = $request->only(['begin', 'end', 'business_type', 'customer_id']);
		$pfmModel = new PfmStatistics();
		switch ($par['business_type']) {
			//区分查询的业务类型,1-idc;2-高防ip
			case '1':
				if (isset($par['customer_id'])) {
					$return = $pfmModel->getIdcStatisticsBigByUser($par['begin'], $par['end'], $par['customer_id']);
				} else {
					$return = $pfmModel->getIdcStatisticsBig($par['begin'], $par['end']);
				}
				break;
			case '2':
				if (isset($par['customer_id'])) {
					$return = $pfmModel->getDefenseipStatisticsBigByUser($par['begin'], $par['end'], $par['customer_id']);
				} else {
					$return = $pfmModel->getDefenseipStatisticsBig($par['begin'], $par['end']);
				}
				break;
			default:
				return tz_ajax_echo('', '请选择正确业务类型', 0);
				break;
		}

		return tz_ajax_echo($return['data'], $return['msg'], $return['code']);
	}

	public function pfmSmall(PfmStatisticsRequest $request)
	{
		$par     = $request->only(['begin', 'end', 'business_type']);
		$user_id = Admin::user()->id;

		$pfmModel = new PfmStatistics();

		switch ($par['business_type']) {
			//区分查询的业务类型,1-idc;2-高防ip
			case '1':
				$return = $pfmModel->getIdcStatisticsSmall($par['begin'], $par['end'], $user_id);
				break;
			case '2':
				$return = $pfmModel->getDefenseipStatisticsSmall($par['begin'], $par['end'], $user_id);
				break;
			default:
				return tz_ajax_echo('', '请选择正确业务类型', 0);
				break;
		}
		return tz_ajax_echo($return['data'], $return['msg'], $return['code']);
	}

	public function test(PfmStatisticsRequest $request)
	{
		$par = $request->only(['begin', 'end']);
		
		$begin = '2019-05-01 00:00:00';
		$end   = '2019-05-31 23:59:59';

		$pfmModel = new PfmStatistics();
		$res      = $pfmModel->test2($begin, $end);

		$this->excelTest($res);

//        return tz_ajax_echo($res, '统计完成', 1);
	}

	private function excelTest($data)
	{
//        $spreadsheet = new Spreadsheet();
		$spreadsheet = new Spreadsheet();
		$worksheet   = $spreadsheet->getActiveSheet();
		$worksheet->setTitle('机器批量导入表格');
		$row_value = ['业务编号', '消费金额', '消费类型', '所属机房', '客户名称' ,'支付时间'];//填写的字段

		$worksheet->setCellValueByColumnAndRow(1, 1 ,'业务编号');
		$worksheet->setCellValueByColumnAndRow(2, 1 ,'消费金额');
		$worksheet->setCellValueByColumnAndRow(3, 1, '消费类型');
		$worksheet->setCellValueByColumnAndRow(4, 1, '所属机房');
		$worksheet->setCellValueByColumnAndRow(5, 1, '客户名称');
		$worksheet->setCellValueByColumnAndRow(6, 1, '支付时间');


		$j=2;
		foreach ($data as $k => $v) {
//            dump($v['already']);//已付款
			$worksheet->setCellValueByColumnAndRow(1, $j,  $v['business_number']);
			$worksheet->setCellValueByColumnAndRow(2, $j,  $v['payable_money']);
			$worksheet->setCellValueByColumnAndRow(3, $j,  $v['type']);
			$worksheet->setCellValueByColumnAndRow(4, $j,  $v['machine_room']);
			$worksheet->setCellValueByColumnAndRow(5, $j,  $v['customer_name']);
			$worksheet->setCellValueByColumnAndRow(6, $j,  $v['pay_time']);
			$j++;
		}


		$filename = '5月统计.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);
		exit;

	}



	private function excel($data)
	{
//        $spreadsheet = new Spreadsheet();
		$spreadsheet = new Spreadsheet();
		$worksheet   = $spreadsheet->getActiveSheet();
		$worksheet->setTitle('机器批量导入表格');
		$row_value = ['用户账号', '用户邮箱', '用户昵称', '3月已付款', '3月未付款'];//填写的字段



		$j=2;
		foreach ($data as $k => $v) {
//            dump($v['already']);//已付款
			$worksheet->setCellValueByColumnAndRow(1, $j,  $v['customer_nickname']);
			$worksheet->setCellValueByColumnAndRow(2, $j,  $v['customer_name']);
			$worksheet->setCellValueByColumnAndRow(3, $j,  $v['customer_email']);
			$worksheet->setCellValueByColumnAndRow(4, $j,  $v['already']);
			$worksheet->setCellValueByColumnAndRow(5, $j,  $v['not']);
			$j++;
		}


		$filename = '月统计.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);
		exit;

	}

	/**
	 * 含分类业绩统计
	 * @param  Requests $request --begin统计开始时间,--end统计结束时间
	 * @return [type]            [description]
	 */
	public function performance(Request $request){
		$time = $request->only(['begin','end','business_type']);
		$performance = new PfmStatistics();
		$result = $performance->performance($time);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}

	/**
	 * 总统计模块
	 * @return [type] [description]
	 */
	public function statistics(){
		$statistics = new PfmStatistics();
		$result = $statistics->statistics();
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}

	/**
	 * 获取消费总额折线图所需数据接口
	 * @return [type] [description]
	 */
	public function consumptionTwelve(){
		$statistics = new PfmStatistics();
		$result = $statistics->consumptionTwelve();
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}

	/**
	 * 获取消费
	 * @param  $need 	1 - 获取当日 ; 2 - 获取当月 ; 3 - 获取上月
	 * @return
	 */
	public function getConsumption(PfmStatisticsRequest $request){
		$par = $request->only(['need']);
		$this_month = date('Y-m');
		$statistics = new PfmStatistics();

		if ($par['need'] == 1) { // 取当日
			$result = $statistics->consumptionToday();
		}elseif ($par['need'] == 2) {// 取当月
			$result = $statistics->getConsumptionByMonth($this_month);
		}elseif ($par['need'] == 3) {// 取上月
			$last_month =date('Y-m',Carbon::parse($this_month.'-01 00:00:00')->subMonths(1)->timestamp);
			$result = $statistics->getConsumptionByMonth($last_month);
		}
		

		return tz_ajax_echo($result,'获取成功',1);
	}

}
