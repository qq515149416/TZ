<?php

namespace App\Admin\Controllers\DefenseIp;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\DefenseIp\StoreModel;
use Illuminate\Http\Request;
use App\Admin\Requests\DefenseIp\StoreRequest;
use App\Admin\Models\Idc\Ips;

class StoreController extends Controller
{
	use ModelForm;
	
	// public function insert(StoreRequest $request){
	// 	$model = new StoreModel();

	// 	$par = $request->only(['ip','site','protection_value']);
	// 	$ip = $par['ip'];

	// 	//0.0.0.0--- 255.255.255.255
	// 	$pat = "/^(((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))$/";
	// 	for ($i=0; $i < count($ip); $i++) { 
	// 		if(!preg_match($pat,$ip[$i])){
	// 			return tz_ajax_echo('','ip地址有误',0);
	// 		}
	// 		$check = $model->checkExist($ip[$i]);
	// 		if($check['code'] == 0){
	// 			return tz_ajax_echo($ip[$i],$ip[$i].'该ip地址已存在',0);
	// 		}
	// 	}

	// 	$protection_value = $par['protection_value'];
	// 	$site = $par['site'];
	// 	$insert = $model->insert($ip,$protection_value,$site);
	// 	return tz_ajax_echo($insert['data'],$insert['msg'],$insert['code']);
	// }

	public function del(StoreRequest $request){
		$model = new StoreModel();

		$par = $request->only(['del_id']);
		$del_id = $par['del_id'];

		$del_res = $model->del($del_id);
		return tz_ajax_echo($del_res['data'],$del_res['msg'],$del_res['code']);
	}

	public function edit(StoreRequest $request){
		$model = new StoreModel();
		$par = $request->only(['edit_id','protection_value']);
		$edit_res = $model->edit($par);

		return tz_ajax_echo($edit_res['data'],$edit_res['msg'],$edit_res['code']);
	}

	public function show(StoreRequest $request){
		$model = new StoreModel();
		$par = $request->only(['status','site']);
		$status = $par['status'];
		$site = $par['site'];
		
		if($status == '1'){
			$ip_list = $model->showUse();
		}else{
			$ip_list = $model->show($status,$site);
		}
		

		return tz_ajax_echo($ip_list['data'],$ip_list['msg'],$ip_list['code']);
	}

	public function showIdcIps(StoreRequest $request){
		$model = new Ips();
		$par = $request->only('site');
		$ip_list = $model->where('ip_comproom',$par['site'])->get();
		if(!$ip_list->isEmpty()){
			return tz_ajax_echo($ip_list,'获取成功',1);	
		}else{
			return tz_ajax_echo([],'暂无数据',1);
		}
	}

	public function insert(StoreRequest $request){
		$model = new StoreModel();

		$par = $request->only(['ip_id','protection_value']);

		$insert = $model->insert($par['ip_id'],$par['protection_value'] );
		return tz_ajax_echo($insert['data'],$insert['msg'],$insert['code']);
	}

	public function form(){
		 return view('defenseipForm');
	}
}
