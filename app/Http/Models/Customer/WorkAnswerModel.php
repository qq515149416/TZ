<?php

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 工单问答的数据
 */
class WorkAnswerModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_work_answer';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['work_number','answer_content','answer_worknum','answer_id','answer_role','created_at','deleted_at'];

    /**
     * 根据工单号查找对应的详情
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    public function showWorkAnswer($where){
    	if($where){
    		$answer = $this->where($where)->([['work_number','answer_content','answer_worknum','answer_id','answer_role','created_at']]);
    		if($answer->isEmpty()){
    			$return['data'] = $answer;
    			$return['msg'] = '获取详情成功';
    			$return['code'] = 1;
    		} else {
                return['data'] = '';
                $return['msg'] = '暂无详情';
                $return['code'] = 0;
            }
    	} else {
    		$return['data'] = '';
    		$return['msg'] = '无法获取详情';
    		$return['code'] = 0;
    	}

    	return $return;
    }

    /**
     * 工单问答数据插入
     * @param  array $insert_data 工单号，回答的内容
     * @return array              相关的状态提示及信息
     */
    public function insertWorkAnswer($insert_data){
    	if($insert_data){
    		$uid = Auth::user()->id;
    		$insert_data['answer_id'] = $uid;
    		$insert_data['answer_role'] = 1;
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
    	return $return;
    }
}
