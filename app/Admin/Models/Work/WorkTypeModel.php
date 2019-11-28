<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * 工单类型模型
 */
class WorkTypeModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_work_type';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['id','type_name','parent_id','note','created_at','updated_at','deleted_at'];
    /**
     * 展示工单类型信息
     * @return [type] [description]
     */
    public function showWorkType(){
    	$result = $this->all(['id','type_name','parent_id','note','created_at','updated_at']);
    	if(!$result->isEmpty()){
    		foreach($result as $typekey=>$typevalue){
    			$result[$typekey]['parent_name'] = $this->parentType($typevalue['parent_id']);
    		}
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '获取工单类型信息成功';
    	} else {
    		$return['data'] = $result;
    		$return['code'] = 0;
    		$return['msg'] = '获取工单类型信息失败';
    	}
        return $return;
    }

    /**
     * 新增工单类型
     * @param  array $insertdata 要新增的工单类型信息
     * @return 返回新增的状态和提示信息
     */
    public function insertWorkType($insertdata){
    	if($insertdata){
    		$row = $this->create($insertdata);
    		if($row != false){
    			$return['data'] = $row->id;
    			$return['code'] = 1;
    			$return['msg'] = '新增工单类型成功'; 
    		} else {
    			$return['data'] = '';
    			$return['code'] = 0;
    			$return['msg'] = '新增工单类型失败！！';
    		}
    	} else {
    		$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '工单类型信息无法新增！！';
    	}
    	return $return;
    }

    /**
     * 修改工单类型信息
     * @param  array $editdata 要修改的数据
     * @return array           返回提示信息和状态
     */
    public function editWorkType($editdata){
    	if($editdata){
    		$row = $this->where('id',$editdata['id'])->update($editdata);
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '修改工单类型信息成功';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '修改工单类型信息失败';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '无法修改工单类型信息';
    	}
        return $return;
    }

    /**
     * 删除对应的工单类型信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteWorkType($id){
    	if($id){
            $where = ['parent_id'=>$id];
            $child = $this->where($where)->whereNull('deleted_at')->get(['id']);
            if(!$child->isEmpty()){
                $return['code'] = 0;
                $return['msg'] = '请先删除该类型下的分类！！';
                return $return;
            }
    		$row = $this->where('id',$id)->delete();
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '删除工单类型成功！！';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '删除工单类型失败！！';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '工单类型信息无法删除！！';
    	}
        return $return;
    }

    /**
     * 查找父级的工单类型名称
     * @param  [type] $parent_id [description]
     * @return [type]            [description]
     */
    public function parentType($parent_id){
    	$parent = DB::table('tz_work_type')->where('id',$parent_id)->value('type_name');
    	return $parent;
    }
}
