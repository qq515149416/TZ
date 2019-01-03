<?php

namespace App\Admin\Controllers\DataTransfer;

use App\Admin\Models\DataTransfer\DataTransfer;
use App\Http\Controllers\Controller;

use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class DataTransferController extends Controller
{
	public function transMachineroom(){
		$model = new DataTransfer();
		$res = $model->transMachineroom();
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	public function transAdminUser(){

		$model = new DataTransfer();

		$res = $model->transAdminUser();
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	public function transIp(){

		$model = new DataTransfer();
		
		$res = $model->transIp();
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	public function transCabinet(){
		$model = new DataTransfer();
		
		$res = $model->transCabinet();
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	public function transMachine(){
		$model = new DataTransfer();
		
		$res = $model->transMachine();
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	public function transCustomer(){
		$model = new DataTransfer();
		
		$res = $model->transCustomer();
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
