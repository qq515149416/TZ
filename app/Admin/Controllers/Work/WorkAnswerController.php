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

        $where = $request->only(['work_number']);
        $show = new WorkAnswerModel();
        $return = $show->showWorkAnswer($where);
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);

    }

    /**
     * 对工单进行问答数据的插入数据库
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertWorkAnswer(Request $request){

        $insert_data = $request->only(['work_number','answer_content']);
        $insert = new WorkAnswerModel();
        $insert_result = $insert->insertWorkAnswer($insert_data);
        return tz_ajax_echo($insert_result['data'],$insert_result['msg'],$insert_result['code']);

    }
}
