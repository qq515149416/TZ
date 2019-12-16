<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\ApiAdmin;
use Illuminate\Http\Request;

class ApiAdminController extends Controller
{
	/**
	* 展示已过白未删除的本库白名单
	* @return 
	*/
	public function showWhiteListInForce()
	{
		
		$model = new ApiAdmin();
		$res = $model->showWhiteList(1);
		
		$res = json_encode($res);

		return $res;
	}

}
