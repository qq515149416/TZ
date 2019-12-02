<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 统计用控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-20 15:47:56
// +----------------------------------------------------------------------
//test
namespace App\Admin\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Statistics\MachineStatistics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Admin\Requests\Statistics\StatisticsRequest;
use App\Admin\Models\Business\BusinessModel;
use App\Admin\Models\DefenseIp\BusinessModel as DipModel;
use App\Admin\Models\DefenseIp\OverlayBelongModel;
use App\Admin\Controllers\Excel\ExcelController;

class StatisticsController extends Controller
{
	use ModelForm;

	/**
	* 查找统计表的相关信息
	* @return json 返回相关的信息
	*/
	public function index( StatisticsRequest $request){
		$res = $this->machineStatistics();
		if($res == 1){
			$msg = '数据更新成功 , ';
		}else{
			$msg = '数据更新失败 , ';
		}

		$machineModel = new MachineStatistics();

		$month = $request->only(['month']);
		if(isset($month['month'])){
			$month = $month['month'];
		}else{
			$month = date("y-m");
		}

		$info = $machineModel->getStatistics($month);

		return tz_ajax_echo($info['data'],$msg.$info['msg'],$info['code']);
	}

	/**
	 * 按机房统计machine各地区使用状况并存入或更新数据库,按月份区分
	 * @param
	 * @return code,1为更新成功,0为失败
	 */

	public function machineStatistics()
	{

		$machineModel = new MachineStatistics();

		$result = $machineModel->statistics();

		return $result['code'];

	}

	/**
	* 按条件获取机器数量
	* @param
	* @return [type]           [description]
	*/
	public function getMachineNum(){
		$model = new BusinessModel();

		$this_month_begin   = date('Y-m-01 00:00:00');
		$this_month_end     = date('Y-m-t 23:59:59');
		// $this_month_begin = '2019-05-01 00:00:00';
		// $this_month_end = '2019-05-31 23:59:59';
		$today_begin = date('Y-m-d 00:00:00');
		$today_end = date('Y-m-d 23:59:59');

		$this_month_on = $model->where(function($query) use ($this_month_begin,$this_month_end){
						$query->whereIn('business_type',[1,2])
						->where('start_time','>',$this_month_begin)
						->where('start_time','<',$this_month_end)
						->whereIn('business_status',[0,1,3,4])
						->where('remove_status',0);
					})
					->orWhere(function($query) use ($this_month_begin,$this_month_end){
						$query->whereIn('business_type',[1,2])
						->where('start_time','>',$this_month_begin)
						->where('start_time','<',$this_month_end)
						->where('business_status' , 2);
					})
					->count();

		$this_month_down = $model->whereIn('business_type',[1,2])
					->where('updated_at','>',$this_month_begin)
					->where('updated_at','<',$this_month_end)
					->where('remove_status','=',4)
					->whereIn('business_status',[2,5,6])
					->count();

		$today_on_idc = $model->where(function($query) use ($today_begin,$today_end){
						$query->whereIn('business_type',[1,2])
						->where('start_time','>',$today_begin)
						->where('start_time','<',$today_end)
						->whereIn('business_status',[0,1,3,4])
						->where('remove_status',0);
					})
					->orWhere(function($query) use ($today_begin,$today_end){
						$query->whereIn('business_type',[1,2])
						->where('start_time','>',$today_begin)
						->where('start_time','<',$today_end)
						->where('business_status' , 2);
					})
					->count();

		$dip_model = new DipModel();
		$today_on_dip = $dip_model->where(function($query) use ($today_begin,$today_end){
						$query->where('created_at' , '>' , $today_begin)
						->where('created_at' , '<' , $today_end)
						->where('status',4);
					})
					->orWhere(function($query) use ($today_begin,$today_end){
						$query->whereIn('status',[1,2,3])
						->where('start_time' , '>' , $today_begin)
						->where('start_time' , '<' , $today_end);
					})
					->count();

		$overlay_model = new OverlayBelongModel();
		$today_on_overlay = $overlay_model->where('buy_time' , '>' , $today_begin)
						->where('buy_time' , '<' , $today_end)
						->count();


		// $using = $model->whereIn('business_type',[1,2])
		// 		->where('remove_status',0)
		// 		->whereIn('business_status',[1,2])
		// 		->count();
		$arr = [
			'this_month_on'		=> $this_month_on,
			'this_month_down'	=> $this_month_down,
			'today_on'		=> $today_on_idc+$today_on_dip+$today_on_overlay,
		];

		return tz_ajax_echo($arr,'统计成功',1);
	}

	public function getBusinessDetailed(Request $request)
	{
		$par = $request->only(['month']);
		if (!isset($par['month'])) {
			return tz_ajax_echo([],'请提供查询月份',0);
		}

		$res = $this->getBusinessSta($par['month']);

		return [
			'data'	=> $res,
			'msg'	=> '统计成功',
			'code'	=> 1,
		];
	}
	/**
	* 按月份获取业务上下架统计数据
	*
	* @param $month 	-月份( 格式: Y-m ; 例子: 2019-10 )
	* @return 
	*
	**/
	public function getBusinessSta($month)
	{
		//拼接出月份开始的date (头一天的0点)
		$month_begin = $month.'-01 00:00:00';
		//获取月份的结束date (最后一天的最后一秒)
		$month_end = date('Y-m-t 23:59:59',strtotime($month_begin));
		//月份的最后一天的 日
		$month_day = date('t',strtotime($month_begin));
		//获取月份
		$month_small = date('m',strtotime($month_begin));

		//业务类型的数组
		$type_arr = [
			0	=> [
				'type'			=> 'idc',		//类型
				'num'			=> 0,		//上架数量
			],
			1	=> [
				'type'			=> 'cdn',
				'num'			=> 0,
			],
			2	=> [
				'type'			=> '高防',
				'num'			=> 0,
			],
			3	=> [
				'type'			=> '流量叠加包',
				'num'			=> 0,
			],

		];

		//生成该月份的数组
		$arr 	= [];
		for ($j=1; $j <= $month_day; $j++) {
			$arr[] = [
				'time'		=> $month_small .'-'.$j,		//日期
				'num'		=> 0,				//上架数量
			];
		}
		//获取该月份idc的上架业务
		$model = new BusinessModel();
		$idc_on = $model->leftJoin('tz_users as b' , 'b.id' , '=' , 'tz_business.client_id')
					->where(function($query) use ($month_begin,$month_end){
						$query->where('tz_business.start_time','>',$month_begin) 	//开始时间大于月开始的
						->where('tz_business.start_time','<',$month_end) 		//开始时间小于月结束的
						->whereIn('tz_business.business_status',[0,1,3,4])			//业务状态为
						->where('tz_business.remove_status',0);
					})
					->orWhere(function($query) use ($month_begin,$month_end){
						$query->where('tz_business.start_time','>',$month_begin)
						->where('tz_business.start_time','<',$month_end)
						->where('tz_business.business_status' , 2);
					})
					->orderBy('tz_business.start_time','desc')
					->get(['tz_business.sales_name' , 'tz_business.business_number' , 'tz_business.business_type' , 'tz_business.machine_number', 'tz_business.money as price' , 'tz_business.start_time' , 'tz_business.endding_time' , 'b.name as cusname' , 'b.nickname' , 'b.email']);
		//idc业务主机类型
		$business_type = [ 1 => '租用主机' , 2 => '托管主机' , 3 => '租用机柜' ];
		//如果不是空就塞进统计数组里
		if (!$idc_on->isEmpty()) {
			$idc_on = $idc_on->toArray();
			foreach ($idc_on as $k => $v) {
				//主机类型转成中文
				$idc_on[$k]['business_type'] = $business_type[$idc_on[$k]['business_type']];
				//idc类型统计数量加一个
				$type_arr[0]['num']++;
				//获取业务上架 date 里的 日
				$day = date('j' , strtotime($idc_on[$k]['start_time']));
				//在该日的统计数量加一
				$arr[$day-1]['num']++;
				//获取客户名称,昵称>邮箱>登录名
				$idc_on[$k]['customer_name'] = $idc_on[$k]['nickname']?:$idc_on[$k]['email']?:$idc_on[$k]['name'];
			}

		}
		//获取该月份上架的高防业务
		$dip_model = new DipModel();
		$dip_on = $dip_model->leftJoin('tz_users as b' , 'b.id' , '=' , 'tz_defenseip_business.user_id')
					->leftJoin('admin_users as c' , 'c.id' , '=' , 'b.salesman_id')
					->leftJoin('tz_defenseip_package as d' , 'd.id' , '=' , 'tz_defenseip_business.package_id')
					->leftJoin('tz_defenseip_store as e' , 'e.id' , '=' , 'tz_defenseip_business.ip_id')
					->where(function($query) use ($month_begin,$month_end){
						$query->where('tz_defenseip_business.created_at' , '>' , $month_begin)
						->where('tz_defenseip_business.created_at' , '<' , $month_end)
						->where('tz_defenseip_business.status',4);
					})
					->orWhere(function($query) use ($month_begin,$month_end){
						$query->whereIn('tz_defenseip_business.status',[1,2,3])
						->where('tz_defenseip_business.start_time' , '>' , $month_begin)
						->where('tz_defenseip_business.start_time' , '<' , $month_end);
					})
					->orderBy('tz_defenseip_business.start_time', 'desc')
					->get(['c.name as sales_name' ,'tz_defenseip_business.business_number','tz_defenseip_business.status' , 'd.name as package_name' , 'd.price' ,'tz_defenseip_business.start_time' , 'tz_defenseip_business.end_at as endding_time' , 'tz_defenseip_business.created_at' , 'b.name' , 'b.nickname' , 'b.email','e.ip as machine_number']);

		if (!$dip_on->isEmpty()) {
			$dip_on = $dip_on->toArray();
			for ($i=0; $i < count($dip_on); $i++) {
				//如果业务状态是试用,业务的开始时间是生成的时间
				if ($dip_on[$i]['status'] == 4) {
					$dip_on[$i]['start_time'] = $dip_on[$i]['created_at'];
				}
				$dip_on[$i]['business_type'] = '高防ip';	
				$type_arr[2]['num']++;
				$day = date('j' , strtotime($dip_on[$i]['start_time']));
				$arr[$day-1]['num']++;
				$dip_on[$i]['customer_name'] = $dip_on[$i]['nickname']?:$dip_on[$i]['email']?:$dip_on[$i]['name'];
			}
		}
		//获取月份内购买的叠加包
		$overlay_model = new OverlayBelongModel();
		$overlay_on = $overlay_model->leftJoin('tz_users as b' , 'b.id' , '=' , 'tz_overlay_belong.user_id')
						->leftJoin('admin_users as c' , 'c.id' , '=' , 'b.salesman_id')
						->leftJoin('tz_overlay as d' , 'd.id' , '=' , 'tz_overlay_belong.overlay_id')
						->where('tz_overlay_belong.buy_time' , '>' , $month_begin)
						->where('tz_overlay_belong.buy_time' , '<' , $month_end)
						->orderBy('tz_overlay_belong.buy_time','desc')
						->get(['c.name as sales_name' , 'd.name as machine_number' , 'd.price' , 'tz_overlay_belong.buy_time','b.name' , 'b.nickname' , 'b.email','tz_overlay_belong.order_sn as business_number']);
		if (!$overlay_on->isEmpty()) {
			$overlay_on = $overlay_on->toArray();
			for ($i=0; $i < count($overlay_on); $i++) {
				$overlay_on[$i]['business_type'] = '叠加包';
				$type_arr[3]['num']++;
				$day = date('j' , strtotime($overlay_on[$i]['buy_time']));
				$arr[$day-1]['num']++;
				$overlay_on[$i]['customer_name'] = $overlay_on[$i]['nickname']?:$overlay_on[$i]['email']?:$overlay_on[$i]['name'];
           			}
		}
		//所有上架业务的数组
		//把几种业务类型的业务都按照一定规律塞到所有上架数组中
		$all_on = [];
		foreach ($idc_on as $k => $v) {
			$all_on[] = [
				'business_number'	=> $idc_on[$k]['business_number'],
				'customer_name'	=> $idc_on[$k]['customer_name'],
				'sales_name'		=> $idc_on[$k]['sales_name'],
				'business_type'		=> $idc_on[$k]['business_type'],
				'machine_number'	=> $idc_on[$k]['machine_number'],
				'price'			=> $idc_on[$k]['price'],
				'start_time'		=> $idc_on[$k]['start_time'],
			];
		}
		foreach ($dip_on as $k => $v) {
			$all_on[] = [
				'business_number'	=> $dip_on[$k]['business_number'],
				'customer_name'	=> $dip_on[$k]['customer_name'],
				'sales_name'		=> $dip_on[$k]['sales_name'],
				'business_type'		=> $dip_on[$k]['business_type'],
				'machine_number'	=> $dip_on[$k]['machine_number'],
				'price'			=> $dip_on[$k]['price'],
				'start_time'		=> $dip_on[$k]['start_time'],
			];
		}
		foreach ($overlay_on as $k => $v) {
			$all_on[] = [
				'business_number'	=> '叠加包',
				'customer_name'	=> $overlay_on[$k]['customer_name'],
				'sales_name'		=> $overlay_on[$k]['sales_name'],
				'business_type'		=> $overlay_on[$k]['business_type'],
				'machine_number'	=> $overlay_on[$k]['machine_number'],
				'price'			=> $overlay_on[$k]['price'],
				'start_time'		=> $overlay_on[$k]['buy_time'],
			];
		}
		return [
			'line'		=> $arr,
			'type_arr'	=> $type_arr,
			'idc_on'		=> $idc_on,
			'dip_on'		=> $dip_on,
			'overlay_on'	=> $overlay_on,
			'all_on'		=> $all_on,
		];
	}

	public function getBusinessExcel(Request $request)
	{
		$par = $request->only(['month']);
		if (!isset($par['month'])) {
			return tz_ajax_echo([],'请提供查询月份',0);
		}

		$res = $this->getBusinessSta($par['month']);

		$data1 = [
			[
				'日期',
				'新增业务数量'
			],
		];
		foreach ($res['line'] as $k => $v) {
			$data1[] = [ $res['line'][$k]['time'] , $res['line'][$k]['num'] ];
		}

		$data2 = [
			[
				'业务类型',
				'新增业务数量'
			],
		];
		foreach ($res['type_arr'] as $k => $v) {
			$data2[] = [ $res['type_arr'][$k]['type'] , $res['type_arr'][$k]['num'] ];
		}

		$data3 = [
			[
				'业务号',
				'客户',
				'业务类型',
				'机器编号',
				'单价',
				'开始时间',
				'结束时间',
				'所属业务员',
			],
		];
		foreach ($res['idc_on'] as $k => $v) {
			$data3[] = [
				$res['idc_on'][$k]['business_number'] ,
				$res['idc_on'][$k]['customer_name'] ,
				$res['idc_on'][$k]['business_type'] ,
				$res['idc_on'][$k]['machine_number'] ,
				$res['idc_on'][$k]['price'] ,
				$res['idc_on'][$k]['start_time'] ,
				$res['idc_on'][$k]['endding_time'] ,
				$res['idc_on'][$k]['sales_name'] ,
			];
		}

		$data4 = [
			[
				'业务号',
				'客户',
				'业务类型',
				'套餐',
				'ip',
				'单价',
				'开始时间',
				'结束时间',
				'所属业务员',
			],
		];
		foreach ($res['dip_on'] as $k => $v) {
			$data4[] = [
				$res['dip_on'][$k]['business_number'] ,
				$res['dip_on'][$k]['customer_name'] ,
				$res['dip_on'][$k]['business_type'] ,
				$res['dip_on'][$k]['package_name'] ,
				$res['dip_on'][$k]['machine_number'] ,
				$res['dip_on'][$k]['price'] ,
				$res['dip_on'][$k]['start_time'] ,
				$res['dip_on'][$k]['endding_time'] ,
				$res['dip_on'][$k]['sales_name'] ,
			];
		}

		$data5 = [
			[
				'客户',
				'业务类型',
				'套餐',
				'单价',
				'购买时间',
				'所属业务员',
			],
		];
		foreach ($res['overlay_on'] as $k => $v) {
			$data5[] = [
				$res['overlay_on'][$k]['customer_name'] ,
				$res['overlay_on'][$k]['business_type'] ,
				$res['overlay_on'][$k]['machine_number'] ,
				$res['overlay_on'][$k]['price'] ,
				$res['overlay_on'][$k]['buy_time'] ,
				$res['overlay_on'][$k]['sales_name'] ,
			];
		}
		$arr = [
			0 => [
				'cellData'	=> $data1,
				'cellName'	=> '每日新增业务数量',
			],
			1 => [
				'cellData'	=> $data2,
				'cellName'	=> '业务类型统计',
			],
			2 => [
				'cellData'	=> $data3,
				'cellName'	=> 'idc业务新增业务列表',
			],
			3 => [
				'cellData'	=> $data4,
				'cellName'	=> '高防业务新增业务列表',
			],
			4 => [
				'cellData'	=> $data5,
				'cellName'	=> '叠加包业务新增业务列表',
			],
		];
		$excel = new ExcelController();
		$excel->kiriExcel($arr,$par['month'].'新增业务详情');
	}


	public function getMachineExcelByMonth(Request $request)
	{
		$par = $request->only(['month']);
		if (!isset($par['month'])) {
			return tz_ajax_echo([],'请提供查询月份',0);
		}
		$month = $par['month'];

		$month_begin = $month.'-01 00:00:00';
		$month_begin_timestamp = strtotime($month_begin);
		$month_end = date('Y-m-t 23:59:59',$month_begin_timestamp);
		$month_end_timestamp = strtotime($month_end);

		$model = new BusinessModel();

		$time = [
			'begin'	=> $month_begin_timestamp,
			'end'	=> $month_end_timestamp,
		];
		$new_res = $model->newBusiness($time);
		$under_res = $model->underBusiness($time);

		$new = $new_res['data'];
		$under = $under_res['data'];

		$new_arr = [
			0 => [
				'业务号',
				'累计时长',
				'单价',
				'预计营收',
				'客户名称',
				'业务员',
				'机器编号',
				'IP',
				'所在机柜',
				'所属机房',
				'业务类型',
				'开始时间',
				'结束时间',
				'业务状态',
			],
		];
		$under_arr = [
			0 => [
				'业务号',
				'月营收',
				'下架原因',
				'客户名称',
				'业务员',
				'机器编号',
				'IP',
				'所在机柜',
				'所属机房',
				'业务类型',
				'开始时间',
				'结束时间',
				'业务状态',
				'下架状态'
			],
		];
		foreach ($new['business'] as $k => $v) {
			$new_arr[] = [
				$v->business_number,
				$v->length,
				$v->money,
				$v->single_total,
				$v->client_name,
				$v->sales_name,
				$v->machine_number,
				$v->ip,
				$v->cabinet,
				$v->machineroom,
				$v->type,
				$v->start_time,
				$v->endding_time,
				$v->status,
			];
		}
		foreach ($under['business'] as $k => $v) {
			$under_arr[] = [
				$v->business_number,
				$v->money,
				$v->remove_reason,
				$v->client_name,
				$v->sales_name,
				$v->machine_number,
				$v->ip,
				$v->cabinet,
				$v->machineroom,
				$v->type,
				$v->start_time,
				$v->endding_time,
				$v->status,
				$v->remove,
			];
		}


		$arr = [
			0 => [
				'cellData'	=> $new_arr,
				'cellName'	=> '本月上架',
			],
			1 => [
				'cellData'	=> $under_arr,
				'cellName'	=> '本月下架',
			],

		];
		$excel = new ExcelController();
		$excel->kiriExcel($arr,$month.'上下架机器详情');
	}
}
