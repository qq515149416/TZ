<?php

namespace App\Admin\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Facades\Admin;

class DepartmentModel extends Model
{
    //
    use SoftDeletes;
    protected $table = 'tz_department';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['depart_number','depart_name','sign'];

    /**
     * 获取部门数据
     * @return [type] [description]
     */
    public function showDepart($param = []){
        if(count($param)>0){
            $where['sign'] = 4;
        } else {
            $where = [];
        }
    	$show_depart = $this->where($where)->get(['id','depart_number','depart_name','sign','created_at','updated_at']);
		if(!$show_depart->isEmpty()){
    		$sign = [1=>'普通',2=>'工单初始部门',3=>'工单处理部门',4=>'业务部门'];
    		foreach($show_depart as $depart_key=>$depart_value){
    			$show_depart[$depart_key]['sign_name'] = $sign[$show_depart[$depart_key]['sign']];
			}
    		$return['data'] = $show_depart;
    		$return['code'] = 1;
    		$return['msg'] = '获取部门数据成功';
    	} else {
    		$return['data'] = [];
    		$return['code'] = 0;
    		$return['msg'] = '暂无部门数据';
    	}
    	return  $return;
    }

    /**
     * 部门数据的添加
     * @param  [type] $insert_param [description]
     * @return [type]               [description]
     */
    public function insertDepart($insert_param){
    	if(!$insert_param){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无法添加部门数据!';
    		return $return;
    	}
    	$row = $this->create($insert_param);
    	if($row != false){
    		$return['data'] = $row->id;
    		$return['code'] = 1;
    		$return['msg'] = '添加部门数据成功!';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '添加部门数据失败!';
    	}
    	return $return;
    }

    /**
     * 修改部门数据
     * @param  [type] $edit_param [description]
     * @return [type]             [description]
     */
    public function editDepart($edit_param){
    	if(!$edit_param){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无法修改部门数据!';
    		return $return;
    	}
    	$data = $this->find($edit_param['id']);
    	if(empty($data)){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无对应部门数据，无法修改!';
    		return $return;
    	}
		$edit_row = $this->where(['id'=>$edit_param['id']])->update($edit_param);
    	if($edit_row != false){
    		$return['data'] = '';
    		$return['code'] = 1;
    		$return['msg'] = '修改对应部门数据成功!';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '修改对应部门数据失败!';
    	}
    	return $return;
    }

    /**
     * 删除部门数据
     * @param  [type] $delete_param [description]
     * @return [type]               [description]
     */
    public function deleteDepart($delete_param){
    	if(!$delete_param){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无法删除部门数据!';
    		return $return;
    	}
    	$data = $this->find($delete_param['delete_id']);
    	if(empty($data)){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无对应部门数据，无法删除!';
    		return $return;
    	}
    	$delete_row = $this->where(['id'=>$delete_param['delete_id']])->delete();
    	if($delete_row != false){
    		$return['data'] = '';
    		$return['code'] = 1;
    		$return['msg'] = '删除对应部门数据成功!';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '删除对应部门数据失败!';
    	}
    	return $return;
    }
}
