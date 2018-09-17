<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 工单详情即问答详情
 */
class WorkAnswerModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_work_answer';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['work_number','answer_content','answer_worknum','answer_id','answer_role','created_at','deleted_at'];

    /**
     * 根据工单号查询工单的详情
     * @param  array $where 工单号
     * @return array        工单的详情和状态提示及信息
     */
    public function showWorkAnswer($where){
    	if($where){
    		$answer = $this->where($where)->get(['work_number','answer_content','answer_worknum','answer_id','answer_role','created_at']);
    		if($answer->isEmpty()){
    			$return['data'] = $answer;
	    		$return['msg'] = '获取工单详情成功';
	    		$return['code'] = 1;
    		} 
    	} else {
    		$return['data'] = '';
    		$return['msg'] = '无法获取该工单详情';
    		$return['code'] = 0;
    	}
    	return $return;
    }

    /**
     * 对工单的问答数据进行插入数据库
     * @param  array $insert_data 工单号，回答的内容
     * @return array              相关的状态提示及信息
     */
    public function insertWorkAnswer($insert_data){
    	if($insert_data){
    		$uid = Admin::user()->id;
    		$insert_data['answer_id'] = $uid;
    		$insert_data['answer_worknum'] = $this->worknum($uid);
    		$insert_data['answer_role'] = 2;
    		$row = $this->create($insert_data);
    		if($row != false){
    			$return['data'] = $insert_data['answer_content'];
	    		$return['code'] = 1;
	    		$return['msg'] = '';
    		} else {
    			$return['data'] = '';
	    		$return['code'] = 0;
	    		$return['msg'] = '';
    		}
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '';
    	}
    }
}
