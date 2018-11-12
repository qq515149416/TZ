<?php

namespace App\Admin\Controllers\Defenseip;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Defenseip\StoreModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Defenseip\StoreRequest;
use Encore\Admin\Facades\Admin;


class StoreController extends Controller
{
	use ModelForm;
	
	public function insert(StoreRequest $request){
		$par = $request->only(['ip','site','protection_value']);
		$ip = $par['ip'];
		$protection_value = $par['protection_value'];
		$site = $par['site'];
		$model = new StoreModel();

		$insert = $model->insert($ip,$protection_value,$site);
	}
}
