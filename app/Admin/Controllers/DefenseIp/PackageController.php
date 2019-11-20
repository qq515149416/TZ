<?php

namespace App\Admin\Controllers\DefenseIp;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\DefenseIp\PackageModel;
use Illuminate\Http\Request;
use App\Admin\Requests\DefenseIp\PackageRequest;

class PackageController extends Controller
{
	use ModelForm;
	
	public function insert(PackageRequest $request){

		$model = new PackageModel();
		$par = $request->only(['name','description','site','protection_value','price','channel_price','sell_status']);
		$insert = $model->insert($par);
		
		return tz_ajax_echo($insert['data'],$insert['msg'],$insert['code']);
	}

	public function del(PackageRequest $request){
		$model = new PackageModel();

		$par = $request->only(['del_id']);
		$del_id = $par['del_id'];

		$del_res = $model->del($del_id);
		return tz_ajax_echo($del_res['data'],$del_res['msg'],$del_res['code']);
	}

	public function edit(PackageRequest $request){
		$model = new PackageModel();
		$par = $request->only(['edit_id','name','description','site','protection_value','price','channel_price','sell_status']);
		$edit_res = $model->edit($par);

		return tz_ajax_echo($edit_res['data'],$edit_res['msg'],$edit_res['code']);
	}

	public function show(PackageRequest $request){
		$model = new PackageModel();
		$par = $request->only(['site']);
		$site = $par['site'];
		$ip_list = $model->show($site);

		return tz_ajax_echo($ip_list['data'],$ip_list['msg'],$ip_list['code']);
	}

	public function showById(PackageRequest $request){
		$model = new PackageModel();
		$par = $request->only(['id']);
		$id = $par['id'];
		$ip_list = $model->showById($id);

		return tz_ajax_echo($ip_list['data'],$ip_list['msg'],$ip_list['code']);
	}

}
