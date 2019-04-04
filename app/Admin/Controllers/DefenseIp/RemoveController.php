<?php

namespace App\Admin\Controllers\DefenseIp;

use App\Http\Controllers\Controller;
use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Admin\Requests\DefenseIp\BusinessRequest;
use Encore\Admin\Facades\Admin;
use App\Http\Models\DefenseIp\XADefenseDataModel;

class RemoveController extends Controller
{

	/**
	 * 查询过期业务
	 */
	public function selectExpireList()
	{
//---------------------业务表与资源表联查-----------------------------
//        $nowTime = Carbon::now();  //获取当前时间
//        $endData = BusinessModel::where('end_at', '<', $nowTime)//条件为当前时间大于结束时间时
//        ->join('tz_defenseip_store', 'tz_defenseip_business.ip_id', '=', 'tz_defenseip_store.id')//关联数组
//        ->select('tz_defenseip_business.id', 'tz_defenseip_business.id')
//            ->get(); //获取数据比并转换成数组形式
//----------------------END----------------------------------------------

		$nowTime = Carbon::now();  //获取当前时间
		$endData = BusinessModel::where('end_at', '<', $nowTime)//条件为当前时间大于结束时间时
		->get()
			->toArray(); //获取数据比并转换成数组形式

		//遍历过期列表数组
		foreach ($endData as $key => $value) {
			$storeData           = StoreModel::find($value['ip_id'])->toArray();//获取资源数据
			$endData[$key]['ip'] = $storeData['ip'];  //过期列表添加IP键值
		}

//        dump($endData);
		return $endData;
	}


	/**
	 * 修改业务状态 用户
	 */
	public function updataStatus()
	{

		
	}

	/**
	 * 高防IP资源表 获取资源内容
	 */
	protected function getStoreIP($storeId)
	{
		$storeData = StoreModel::find($storeId); //获取资源数据
		return $storeData;
	}

	 /**
	 * 高防IP业务员提交下架申请
	 */
	public function subExamine(BusinessRequest $request)
	{
		$par = $request->only(['business_id']);
		$business_id = $par['business_id'];
		$admin_user_id = Admin::user()->id;

		$model = new BusinessModel();
		$tijiao = $model->subExamine($business_id,$admin_user_id);
		
		return tz_ajax_echo($tijiao['data'],$tijiao['msg'],$tijiao['code']);
	}

	/**
	 * 高防IP对下架申请进行审核
	 */
	public function goExamine(BusinessRequest $request)
	{
		$par = $request->only(['business_id','status']);
		$business_id = $par['business_id'];
		$admin_user_id = Admin::user()->id;
		$status = $par['status'];
		if($status != 1 && $status != 3){
			return tz_ajax_echo('','审核状态只能选1(不下架)或3(下架)',0);
		}
		$model = new BusinessModel();
		$examineRes = $model->examine($business_id,$status,$admin_user_id);

		return tz_ajax_echo('',$examineRes['msg'],$examineRes['code']);
	}

	public function showExamine()
	{
		$model = new BusinessModel();
		$list = $model->showExamine();

		 return tz_ajax_echo($list['data'],$list['msg'],$list['code']);
	}

	/**
	 * 通过套餐id获取所有该套餐业务
	 */
	public function showBusinessByPackage(BusinessRequest $request)
	{
		$par = $request->only(['package_id']);
		$package_id = $par['package_id'];

		$model = new BusinessModel();
		$list = $model->showBusiness($package_id,'package');
		return tz_ajax_echo($list['data'],$list['msg'],$list['code']);
	}

	/**
	 * 通过客户id获取所有该用户所属业务
	 */
	public function showBusinessByCustomer(BusinessRequest $request)
	{
		$par = $request->only(['customer_id']);
		$customer_id = $par['customer_id'];

		$model = new BusinessModel();
		$list = $model->showBusiness($customer_id,'customer');
		return tz_ajax_echo($list['data'],$list['msg'],$list['code']);
	}

		/**
	 * 统计高防IP数据流量
	 * 用于绘制流量图表
	 *
	 * 接口:/tz_admin/defenseIp/getStatistics
	 *
	 * 参数:
	 *    business_id:业务ID
	 *    date:数据日期  例如:2018-11-19 12:00:00
	 *    ip   :需要查询的ip地址
	 *
	 * 返回:
	 *    time:时间戳
	 *    bandwidth_down:入流量  单位:(M)
	 *    upstream_bandwidth_up:出流量  单位:(M)
	 */
	public function getStatistics(BusinessRequest $request)
	{

		$par = $request->only(['timestamp','business_id','ip']);  //获取所有传参
		// dd(time());
		$endDate = $par['timestamp'];  //结束时间戳
		$startDate = $par['timestamp']-60*60*24; //开始时间戳

		$XADefenseDataModel = new XADefenseDataModel(); //实例化流量数据模型
 
		$data = $XADefenseDataModel->getByIp($par['ip'], $startDate, $endDate); //获取数据


	//        判断有无获取到数据
		if (!$data) {
			return tz_ajax_echo([], '无流量数据', 0);
		}
		return tz_ajax_echo($data, '获取流量数据成功', 1);
	}
}