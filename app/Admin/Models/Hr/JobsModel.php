<?php

namespace App\Admin\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Facades\Admin;

class JobsModel extends Model
{
    //
	use SoftDeletes;
    protected $table = 'tz_jobs';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['job_number','job_name','depart_id','slug'];

    /**
     * 获取职位数据
     * @param  [type] $depart_id [description]
     * @return [type]            [description]
     */
    public function showJobs($depart_id = 0 ){
    	if($depart_id != 0){
    		$where = $depart_id;
    	} else {
            $where = [];
        }
    	$show_jobs = $this->where($where)->get(['id','job_number','job_name','depart_id','slug','created_at','updated_at']);
    	if(!$show_jobs->isEmpty()){
    		$slug = [1=>'普通',2=>'部门管理人员',3=>'业务员',4=>'机房人员',5=>'财务人员',6=>'信安人员'];
    		foreach($show_jobs as $jobs_key=>$jobs_value){
    			$show_jobs[$jobs_key]['slug_name'] = $slug[$show_jobs[$jobs_key]['slug']];
    			$show_jobs[$jobs_key]['depart'] = $this->depart($show_jobs[$jobs_key]['depart_id']);
    		}
    		$return['data'] = $show_jobs;
    		$return['code'] = 1;
    		$return['msg'] = '获取职位数据成功';
    	} else {
    		$return['data'] = [];
    		$return['code'] = 0;
    		$return['msg'] = '暂无职位数据';
    	}
    	return $return;
    }

    /**
     * 职位数据的添加
     * @param  [type] $insert_data [description]
     * @return [type]              [description]
     */
    public function insertJobs($insert_data){
    	if(!$insert_data){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无法添加职位数据!';
    		return $return;	
    	}
    	$row = $this->create($insert_data);
    	if($row != false){
    		$return['data'] = $row->id;
    		$return['code'] = 1;
    		$return['msg'] = '添加职位数据成功!';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '添加职位数据失败!';
    	}
    	return $return;
    }

    /**
     * 修改职位数据
     * @param  [type] $edit_data [description]
     * @return [type]            [description]
     */
    public function editJobs($edit_data){
    	if(!$edit_data){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无法修改职位数据!';
    		return $return;
    	}
    	$job = $this->find($edit_data['id']);
    	if(empty($job)){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无对应职位数据，无法修改!';
    		return $return;
    	}
		$edit_row = $this->where(['id'=>$edit_data['id']])->update($edit_data);
		if($edit_row != false){
    		$return['data'] = '';
    		$return['code'] = 1;
    		$return['msg'] = '修改对应职位数据成功!';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '修改对应职位数据失败!';
    	}
    	return $return; 
    }

    /**
     * 删除部门数据
     * @param  [type] $delete_id [description]
     * @return [type]            [description]
     */
    public function deleteJobs($delete_id){
    	if(!$delete_id){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无法删除职位数据!';
    		return $return;
    	}
    	$job = $this->find($delete_id['delete_id']);
    	if(empty($job)){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无对应职位数据，无法删除!';
    		return $return;
    	}
    	$delete_row = $this->where(['id'=>$delete_id['delete_id']])->delete();
    	if($delete_row != false){
    		$return['data'] = '';
    		$return['code'] = 1;
    		$return['msg'] = '删除对应职位数据成功!';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '删除对应职位数据失败!';
    	}
    	return $return;
    }

    /**
     * 转换部门
     * @param  [type] $depart_id [description]
     * @return [type]            [description]
     */
    public function depart($depart_id){
    	$depart = DB::table('tz_department')->where(['id'=>$depart_id])->value('depart_name');
    	return $depart;
    }
}
