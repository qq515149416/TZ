<?php

namespace App\Admin\Controllers\Hr;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Hr\DepartmentModel;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

/**
 * 部门
 */
class DepartmentController extends Controller
{
    use ModelForm;

    /**
     * 获取部门数据
     * @return [type] [description]
     */
    public function showDepart(){
        $show = new DepartmentModel();
        $show_depart = $show->showDepart();
        return tz_ajax_echo($show_depart['data'],$show_depart['msg'],$show_depart['code']);
    }

    /**
     * 进行部门数据的添加
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertDepart(Request $request){
        $param = $request->only(['depart_number','depart_name','sign']);
        $insert = new DepartmentModel();
        $insert_result = $insert->insertDepart($param);
        return tz_ajax_echo($insert_result['data'],$insert_result['msg'],$insert_result['code']);
    }

    /**
     * 部门数据修改
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editDepart(Request $request){
        $data = $request->only(['id','depart_number','depart_name','sign']);
        $edit = new DepartmentModel();
        $edit_result = $edit->editDepart($data);
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }

    /**
     * 删除部门数据
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteDepart(Request $request){
        $delete_id = $request['delete_id'];
        $delete = new DepartmentModel();
        $delete_result = $delete->deleteDepart($delete_id);
        return tz_ajax_echo($delete_result,$delete_result['msg'],$delete_result['code']);
    }
}
