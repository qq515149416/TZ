<?php

namespace App\Admin\Controllers\Hr;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Hr\JobsModel;
use Illuminate\Http\Request;

/**
 * 职位
 */
class AccountController extends Controller
{
    use ModelForm;

    /**
     * 获取职位数据
     * @return [type] [description]
     */
    public function showJobs(Request $request){
        $depart_id = $request->only(['depart_id']);//用于选择时使用
        $show = new JobsModel();
        $show_jobs = $show->showJobs($depart_id);
        return tz_ajax_echo($show_jobs['data'],$show_jobs['msg'],$show_jobs['code']);
    }

    /**
     * 进行职位数据的添加
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertJobs(Request $request){
        $param = $request->only(['job_number','job_name','depart_id','slug']);
        $insert = new JobsModel();
        $insert_result = $insert->insertJobs($param);
        return tz_ajax_echo($insert_result['data'],$insert_result['msg'],$insert_result['code']);
    }

    /**
     * 职位数据的修改
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editJobs(Request $request){
        $data = $request->only(['id','job_number','job_name','depart_id','slug']);
        $edit = new JobsModel();
        $edit_result = $edit->editJobs($data);
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }

    /**
     * 删除部门数据
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteJobs(Request $request){
        $delete_id = $request->only(['delete_id']);
        $delete = new JobsModel();
        $delete_result = $delete->deleteJobs($delete_id);
        return tz_ajax_echo($delete_result,$delete_result['msg'],$delete_result['code']);
    }
}
