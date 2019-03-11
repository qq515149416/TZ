<?php

namespace App\Admin\Controllers\Idc;

use App\Admin\Models\Idc\MachineRoom;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Admin\Requests\Idc\MachineRoom as MachineRoomValidate;
use Psy\Util\Json;

class MachineRoomController extends Controller
{
	use ModelForm;

	/**
	 * 测试方法
	 */
	public function test()
	{
		dump('邮箱测试');
//        Mail
		$name = 'hello';
		// Mail::send()的返回值为空，所以可以其他方法进行判断
		for ($x = 0; $x <= 2000; $x++) {
			Mail::send('emails.test', ['name' => $name], function ($message) use ($x){
				$to = 'idckx_jun@yeah.net';
				$message->to($to)->subject('邮件测试1'.$x);
			});
		}

		// 返回的一个错误数组，利用此可以判断是否发送成功
		dd(Mail::failures());


	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
//        dump(Auth::user());
		dump(Session::all());
		dump(Admin::user());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

//        dump('create');
	}

	/**
	 * 添加机房接口
	 * 传参方式:POST
	 * 参数:
	 * room_id:机房编号
	 * room_namee:机房中文名
	 *
	 * 表:idc_machineroom
	 *
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(MachineRoomValidate $request)
	{
		//获取参数
		$par = $request->post();

		//实例化
		$machineRoomModel = new MachineRoom();

		//模型添加机房数据
		$res = $machineRoomModel->store($par['room_id'], $par['room_name'],$par['depart_id'],$par['white_list_add'],$par['white_list_key']);
		//dump($res);
		return tz_ajax_echo([], '新增机房成功', 1);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//修改机房编号或名字


	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{


	}

	/**
	 * Ajax 获取机房列表
	 * 接口地址 :/machine_room/showByAjax
	 *
	 *
	 * TODO 没有做分页
	 */
	public function showByAjax()
	{
		//实例化
		$machineRoomModel = new MachineRoom();

		//使用模型方法获取列表数据
		$listData = $machineRoomModel->show();


		//判断是否获取到数据
		if ($listData) {
			//成功
			return tz_ajax_echo($listData, '机房列表获取成功', 1);
		} else {
			//失败
			return tz_ajax_echo($listData, '暂无数据', 1);
		}

	}

	/**
	 * 添加机房接口
	 * 接口地址: /machine_room/storeByAjax
	 * 传参方式:POST
	 * 参数:
	 * room_id:机房编号
	 * room_name:机房中文名
	 *
	 *
	 * 表:idc_machineroom
	 * @param MachineRoomValidate $request
	 * @return mixed
	 */
	public function storeByAjax(MachineRoomValidate $request)
	{
		//获取参数
		$par = $request->post();

		//实例化
		$machineRoomModel = new MachineRoom();

		//模型添加机房数据
		$res = $machineRoomModel->store($par['room_id'], $par['room_name'],$par['depart_id'],isset($par['white_list_add'])?$par['white_list_add']:'',isset($par['white_list_key'])?$par['white_list_key']:'');
//        dump($res);
		return tz_ajax_echo($res['content'], $res['message'], $res['state']);

	}


	/**
	 * 删除机房Ajax接口
	 * 参数:
	 *
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroyByAjax(Request $request)
	{
		//软删除
		$par = $request->post();
		//实例化
		$machineRoomModel = new MachineRoom();

		//判断是否删除成功
		if ($machineRoomModel->destroy($par['id'])) {
			//软删除成功
			return tz_ajax_echo([], '删除成功', 1);

		} else {
			//软删除失败
			return tz_ajax_echo([], '删除失败', 0);

		}

	}

	/**
	 *  修改机房编号或名字
	 * 参数:
	 * id: 需要修改过机房ID
	 * room_id: 修改后的机房编号名
	 * room_name: 修改后的机房名字
	 *
	 * @param Request $request
	 * @param $id
	 * @return Json
	 */
	public function updateByAjax(Request $request)
	{
		//获取参数
		$par = $request->post();
        
        $update = new MachineRoom();
        $result = $update->updateStore($par['id'],$par['machine_room_id'], $par['machine_room_name'],$par['depart_id'],isset($par['white_list_add'])?$par['white_list_add']:'',isset($par['white_list_key'])?$par['white_list_key']:'');

		//返回正确信息
        return tz_ajax_echo($result['content'], $result['message'], $result['state']);


	}


	/**
	 * 显示机房选择列表
	 * GET
	 * 接口: tz_admin/machine_room/show_select_list_by_ajax
	 *
	 * 返回参数:
	 *  id:机房ID
	 *  machine_room_name:机房中文名
	 *
	 */
	public function showSelectListByAjax()
	{
		//实例化
		$machineRoomModel = new MachineRoom();

		//获取选择列表信息
		$listData = $machineRoomModel->showSelectList();

		return $listData ? tz_ajax_echo($listData, '成功获取选择列表', 1) : tz_ajax_echo([], '获取选择列表失败', 0);
	}




//    public function retrieveById($identifier)
//    {
//    }
//
//    public function retrieveByToken($identifier, $token)
//    {
//    }
//
//    public function updateRememberToken(Authenticatable $user, $token)
//    {
//    }
//
//    public function retrieveByCredentials(array $credentials)
//    {
//        // 用$credentials里面的用户名密码去获取用户信息，然后返回Illuminate\Contracts\Auth\Authenticatable对象
//    }
//
//    public function validateCredentials(Authenticatable $user, array $credentials)
//    {
//        // 用$credentials里面的用户名密码校验用户，返回true或false
//    }

}
