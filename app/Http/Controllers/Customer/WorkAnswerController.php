<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Customer\WorkAnswerModel;
use Illuminate\Support\Facades\Auth;

/**
 * 前台工单问答
 */
class WorkAnswerController extends Controller
{	
	/**
	 * 前台查找客户对应的工单问答信息
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
    public function showWorkAnswer(Request $request){
    	$where = $request->only(['work_number']);
    	$show = new WorkAnswerModel();
    	$show_work_answer = $show->showWorkAnswer($where);
    	return tz_ajax_echo($show_work_answer['data'],$show_work_answer['msg'],$show_work_answer['code']);
    }


    /**
     * 前台对工单进行问答数据的插入
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertWorkAnswer(Request $request){
    	$insert_data = $request->only(['work_number','answer_content']);
    	$insert = new WorkAnswerModel();
    	$insert_work_answer = $insert->insertWorkAnswer($insert_data);
    	return tz_ajax_echo($insert_work_answer['data'],$insert_work_answer['msg'],$insert_work_answer['code']);
    }
}
