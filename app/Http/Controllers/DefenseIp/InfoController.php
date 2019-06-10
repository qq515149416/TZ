<?php
/**
 *
 */

namespace App\Http\Controllers\DefenseIp;

use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use App\Http\Models\DefenseIp\XADefenseDataModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{

	protected $userId; //用户ID

	/**
	 * 自动加载
	 */
	public function __construct()
	{
		$this->userId = Auth::id();  //获取登录的用户ID
	}

	/**
	 * 获取高防IP地址 列表
	 */
	public function showList()
	{
		$this->userId = Auth::id();  //获取用户ID
		$businessM    = new BusinessModel();  //实例化

		//根据用户ID获取本用户所有高防IP业务表
		$listData = $businessM
			->where([
				'user_id' => $this->userId//用户ID
			])
			->whereIn('status', [1, 4])
			->get()
			->toArray();   //将对象转为数组

		//遍历添加查询IP资源数组
		foreach ($listData as $key => $value) {
			$storeData = StoreModel::find($value['ip_id']);
			if ($storeData != null) {
				$storeData                          = $storeData->toArray();
				$listData[$key]['defense_ip']       = $storeData['ip']; //列表数组中添加高防IP
				if($listData[$key]['status'] == 4){
					$listData[$key]['status_cn'] = '试用中';
				}else{
					$listData[$key]['status_cn']        = $this->checkStatus($value['end_at']);  //追加业务状态
				}
				$listData[$key]['protection_value'] = $storeData['protection_value'];  //防御值
			} else {
				$listData[$key]['defense_ip']       = 'ip不存在,请联系客服'; //列表数组中添加高防IP
				$listData[$key]['status_cn']        = 'ip不存在,请联系客服';  //追加业务状态
				$listData[$key]['protection_value'] = 'ip不存在,请联系客服';  //防御值
			}
			
			$listData[$key]['machine_room_id'] = $storeData['site'];
			$listData[$key]['machine_room_name'] = DB::table('idc_machineroom')->where('id',$storeData['site'])->value('machine_room_name');
			if ($listData[$key]['machine_room_name'] == null) {
				$listData[$key]['machine_room_name'] = '机房信息错误';
			}

			$listData[$key]['protection_value'] = bcadd($listData[$key]['protection_value'], $listData[$key]['extra_protection'] , 0);
		}
		return tz_ajax_echo($listData, '获取高防IP列表成功', 1);
	}


	/**
	 *  判断业务时间状态
	 *
	 * @param $endTime '业务到期时间'
	 * @return string    '返回业务中文状态'
	 */
	protected function checkStatus($endTime)
	{
//        $endTime  = ;   //获取业务过期时间
		$nowDate  = Carbon::now();  //获取现在时间
		$willDate = Carbon::now()->addDay(config('tz_time.deadline.long')); //获取将要过期的时间限期

		//判断是否过期
		if ($endTime > $nowDate) {
			//未过期
			//判断是否准备过期
			if ($endTime < $willDate) {
				return '即将到期';
			}
			return '未过期';
		} else {
			//已过期
			return '已过期';
		}
	}


	/**
	 * 统计高防IP数据流量
	 * 用于绘制流量图表
	 *
	 * 接口:/home/defenseIp/getStatistics
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
	public function getStatistics(Request $request)
	{

		$res       = $request->all();  //获取所有传参

		$endDate = Carbon::parse($res['date'])->timestamp;  //结束时间戳
		$startDate = Carbon::parse($res['date'])->subDay(1)->timestamp; //开始时间戳


		$XADefenseDataModel = new XADefenseDataModel(); //实例化流量数据模型

		$data = $XADefenseDataModel->getByIp($res['ip'], $startDate, $endDate); //获取数据


//        判断有无获取到数据
		if (!$data) {
			return tz_ajax_echo([], '无流量数据', 0);
		}
		return tz_ajax_echo($data, '获取流量数据成功', 1);
	}


//    /**
//     * 统计高防IP数据流量
//     * 用于绘制流量图表
//     *
//     * 接口:/home/defenseIp/getStatistics
//     *
//     * 参数:
//     *    business_id:业务ID
//     *    date:数据日期  例如:2018-11-19
//     *    ip   :需要查询的ip地址
//     *
//     * 返回:
//     *    ctime:时间戳
//     *    in_byte: 入流量  单位:(byte)
//     *    out_byte:出流量  单位:(byte)
//     *    bandwidth_down:入流量  单位:(M)
//     *    upstream_bandwidth_up:出流量  单位:(M)
//     */
//    public function getStatistics(Request $request)
//    {
//
//        $res      = $request->all();  //获取所有传参
//        $apiData  = $this->test($res['ip'], $res['date']);
//
//        $flowData = $apiData['data'];
//
//        foreach ($flowData as $key => $value) {
////
//            $flowData[$key]['bandwidth_down']        = number_format(($value['in_byte'] /= pow(128, 1)), 3);
//            $flowData[$key]['upstream_bandwidth_up'] = number_format(($value['out_byte'] /= pow(128, 1)), 3);
//        }
//
////        dump($flowData);
////        dd(1);
//
////        判断有无获取到数据
//        if (!$flowData) {
//            return tz_ajax_echo([], '无流量数据', 0);
//        }
//        return tz_ajax_echo($flowData, '获取流量数据成功', 1);
//    }

	/**
	 * 测试模型关联
	 *
	 *
	 */
	public function test($ip, $date)
	{

		$gfApi = new ApiController();
		$test  = $gfApi->getState($ip, $date);
		$test  = json_decode($test, true);

		return $test;
//        dump($test['data']);
	}


	/**
	 * @param $num
	 */
	public function getFilesize($num)
	{

		$p      = 0;
		$format = 'bytes';
		if ($num > 0 && $num < 1024) {
			$p = 0;
			return number_format($num) . ' ' . $format;
		}
		if ($num >= 1024 && $num < pow(1024, 2)) {
			$p      = 1;
			$format = 'KB';
		}
		if ($num >= pow(1024, 2) && $num < pow(1024, 3)) {
			$p      = 2;
			$format = 'MB';
		}
		if ($num >= pow(1024, 3) && $num < pow(1024, 4)) {
			$p      = 3;
			$format = 'GB';
		}
		if ($num >= pow(1024, 4) && $num < pow(1024, 5)) {
			$p      = 3;
			$format = 'TB';
		}
		$num /= pow(1024, $p);
		return number_format($num, 3) . ' ' . $format;
	}

//
//    public function getFilesize($num)
//    {
//
//        $p      = 0;
//        $format = 'bytes';
//        if ($num > 0 && $num < 1024) {
//            $p = 0;
//            return number_format($num) . ' ' . $format;
//        }
//        if ($num >= 1024 && $num < pow(1024, 2)) {
//            $p      = 1;
//            $format = 'KB';
//        }
//        if ($num >= pow(1024, 2) && $num < pow(1024, 3)) {
//            $p      = 2;
//            $format = 'MB';
//        }
//        if ($num >= pow(1024, 3) && $num < pow(1024, 4)) {
//            $p      = 3;
//            $format = 'GB';
//        }
//        if ($num >= pow(1024, 4) && $num < pow(1024, 5)) {
//            $p      = 3;
//            $format = 'TB';
//        }
//        $num /= pow(1024, $p);
//        return number_format($num, 3) . ' ' . $format;
//    }

}

