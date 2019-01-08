<?php

namespace App\Admin\Controllers\Idc;


use App\Admin\Models\Idc\MachineRoom;
use App\Http\Controllers\Controller;
use App\Admin\Models\Idc\Cabinet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Admin\Requests\Idc\CabinetVerify;
use Stevenyangecho\UEditor\UEditorServiceProvider;
use Illuminate\Support\Facades\DB;

class CabinetController extends Controller
{


	/**
	 * Ajax显示机柜列表
	 * 接口:tz_admin/cabinet/showByAjax
	 * 模式: GET
	 *
	 * 返回参数:
	 * code: 1:成功   0:失败
	 * data: {
	 *      id :机柜主键ID
	 *      machineroom_id :机房ID
	 *      machineroom_name:机房ID
	 *      use_state : 有无时使用  0:未使用  1:已使用
	 *      machine_count : 机器数量
	 *      machine_room_name :机房中文名
	 *      use_state_cn :  中文显示使用的状态
	 *      use_type_cn  :  中文显示使用的类型
	 * }
	 *
	 * TODO  分页待完成
	 */
	public function showByAjax()
	{

		//实例化
		$cabinetModel     = new Cabinet();
		$machineRoomModel = new MachineRoom();

		//获取机柜列表数据
		$cabinetData = $cabinetModel->all();
		//dump($cabinetData);
		$stateCN = [
			0 => '未使用',
			1 => '已使用',
		];

		$typeCN = [
			0 => '内部机柜',
			1 => '客户机柜',
		];
		//判断是否为空
		if($cabinetData->isEmpty()){
			return tz_ajax_echo([], '暂无数据', 1);
		}
		//根据机房ID查询机房名称
		foreach ($cabinetData as $key => $value) {
			$machineRoomData                        = $machineRoomModel->queryMachineRoomName($value['machineroom_id']);
			$cabinetData[$key]['machine_room_name'] = $machineRoomData['machine_room_name'];
			$cabinetData[$key]['use_state_cn']      = $stateCN[$value['use_state']];
			$cabinetData[$key]['use_type_cn']       = $typeCN[$value['use_type']];
		}
		
		return tz_ajax_echo($cabinetData, '获取成功', 1);
		
	}


	/**
	 * 添加机柜
	 * 接口: tz_admin/cabinet/storeByAjax
	 * 类型: POST
	 * 参数:
	 * machineroom_id: 所属机房ID
	 * cabinet_id : 机柜编号
	 * use_type :  使用类型   0:内部机柜  1:客户机柜
	 * note : 备注信息
	 *
	 * @param CabinetVerify $request
	 * @return mixed
	 */
	public function storeByAjax(CabinetVerify $request)
	{

		//获取参数
		$par = $request->post();

		//实例化
		$cabinetModel = new Cabinet();

		//存储数据
		$res = $cabinetModel->create($par);
//        dd($res);
		//判断是否添加成功
		if ($res) {
			return tz_ajax_echo([$res['id']], '添加成功', 1);
		} else {
			return tz_ajax_echo([], '添加失败', 0);
		}

		//打印测试数据


	}

	/**
	 * 删除机柜Ajax接口
	 * /tz_admin/cabinet/destroyByAjax
	 * 参数:
	 * id :要删除的机柜的主键id
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroyByAjax(Request $request)
	{
		//软删除
		$par = $request->post();
		//实例化
		$cabineModel = new Cabinet();
		$cabinet = $cabineModel->find($par['id']);
		if(empty($cabinet)){
			return tz_ajax_echo([], '此机柜信息不存在', 0);
		}
		$bindCabinet = DB::table('idc_machine')->where(['cabinet'=>$par['id']])->whereNull('deleted_at')->get();
		if(!$bindCabinet->isEmpty()){
			return tz_ajax_echo([], '请将编号为:'.$cabinet->cabinet_id.'的机柜上的机器转移后再删除', 0);
		};
		//判断是否删除成功
		if ($cabineModel->destroy($par['id'])) {
			//软删除成功
			return tz_ajax_echo([], '删除成功', 1);
		} else {
			//软删除失败
			return tz_ajax_echo([], '删除失败', 0);

		}

	}

	public function updateByAjax(Request $request)
	{
		//获取参数
		$par = $request->post();

		//实例化
		$cabinetModel = new Cabinet();

		// 模型层处理
		$result = $cabinetModel->edit($par);
		// 返回信息
		return tz_ajax_echo('',$result['msg'],$result['code']);
		
	}
}




