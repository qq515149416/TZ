<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\BusinessModel;
// use App\Admin\Requests\Business\BusinessRequest;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    use ModelForm;

    /**
     * 业务员和管理人员点击查看按钮可以查看到对应订单的对应业务数据
     * @param  Request $request [description]
     * @return json           返回相关的数据和状态及提示信息
     */
    public function showBusiness(Request $request){
    	if($request->isMethod('post')){
    		$where = $request->only(['business_number']);
    		$show = new BusinessModel($where);
    		$return = $show->showBusiness($where);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'暂时没有对应业务数据',0);
    	}
    }
}
