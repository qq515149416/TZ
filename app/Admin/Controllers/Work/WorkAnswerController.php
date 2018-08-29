<?php

namespace App\Admin\Controllers\Work;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Work\WorkAnswerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 工单问答
 */
class WorkAnswerController extends Controller
{
    use ModelForm;

    /**
     * 查找工单问答信息
     * @return json 返回相关的数据状态和提示信息
     */
    public function showWorkAnswer(Request $request){
        if($request->isMethod('get')){
            $where = $request->only('work_number');
            $show = new WorkAnswerModel();
            $return = $show->showWorkAnswer($where);
            return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
        } else {
            return tz_ajax_echo([],'无法获取该工单问答信息!!',0);
        } 	
    }
}
