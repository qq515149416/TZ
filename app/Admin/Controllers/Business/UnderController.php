<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\UnderModel;
use App\Admin\Models\Hr\DepartmentModel;
use Illuminate\Http\Request;

/**
 * 下架控制器
 */
class UnderController extends Controller
{
    use ModelForm;

    /**
     *申请下架接口
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function applyUnder(Request $request){
        $apply = $request->only(['type','business_number','remove_reason','order_sn']);
        $apply_for = new UnderModel();
        $apply_result = $apply_for->applyUnder();
        return tz_ajax_echo($apply_result,$apply_result['msg'],$apply_result['code']);
    }

    /**
     * 获取下架的历史记录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function underHistory(Request $request){
        $history = $request->only(['type']);
        $history_for = new UnderModel();
        $history_result = $apply_for->underHistory();
        return tz_ajax_echo($history_result['data'],$history_result['msg'],$history_result['code']);
    }

    /**
     * 对下架进行操作
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doUnder(Request $request){
        $do_parm = $request->only(['remove_reason','business_number','remove_status','machineroom','order_sn','type']);
        $do_for = new UnderModel();
        $do_result = $do_for->doUnder();
        return tz_ajax_echo($do_result,$do_result['msg'],$do_result['code']);
    }

    /**
     * 获取申请的下架记录
     * @return [type] [description]
     */
    public function showApplyUnder(){
        $show = new UnderModel();
        $show_result = $show->showApplyUnder();
        return tz_ajax_echo($show_result['data'],$show_result['msg'],$show_result['code']);
    }

}
