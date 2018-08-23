<?php

namespace App\Admin\Controllers\Work;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Work\WorkTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 工单类型
 */
class WorkTypeController extends Controller
{
    use ModelForm;

    /**
     * 查找工单类型
     * @return [type] [description]
     */
    public function showWorkType(){
    	$showworktype = new WorkTypeModel();
    	$return = $showworktype->showWorkType();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 新增工单类型信息
     * @param  Request $request [description]
     * @return json           相关的状态和提示信息返回
     */
    public function insertWorkType(Request $request){
    	if($request->isMethod('post')){
    		$insertdata = $request->only(['type_name','parent_id','note']);
    		$insert = new WorkTypeModel();
    		$return = $insert->insertWorkType($insertdata);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'无法新增工单类型信息',0);
    	}
    }

    /**
     * 修改工单类型数据
     * @param  Request $request [description]
     * @return json         相关的状态和提示信息
     */
    public function editWorkType(Request $request){
    	if($request->isMethod('post')){
    		$editdata = $request->only(['id','type_name','parent_id','note']);
    		$edit = new WorkTypeModel();
    		$return = $edit->editWorkType($editdata);
    		return tz_ajax_echo($return,$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'工单类型无法修改',0);
    	}
    }

    /**
     * 删除对应的工单类型信息
     * @param  Request $request [description]
     * @return json           相关的信息提示和状态返回
     */
    public function deleteWorkType(Request $request){
    	if($request->isMethod('post')){
    		$id = $request->get('delete_id');
    		$delete = new WorkTypeModel();
    		$result = $delete->deleteWorkType($id);
    		return tz_ajax_echo($result,$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'无法删除工单类型信息',0);
    	}
    }
}
