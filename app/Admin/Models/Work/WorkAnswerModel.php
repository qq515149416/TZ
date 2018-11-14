<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
/**
 * 工单详情即问答详情
 */
class WorkAnswerModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_work_answer';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['work_number','answer_content','answer_id','answer_role','created_at','deleted_at'];

    /**
     * 根据工单号查询工单的详情
     * @param  array $where 工单号
     * @return array        工单的详情和状态提示及信息
     */
    public function showWorkAnswer($where){

    	if($where){
            $business = DB::table('tz_work_order')
                            ->join('tz_business', 'tz_work_order.business_num', '=', 'tz_business.business_number')
                            ->where(['tz_work_order.work_order_number'=>$where['work_number']])
                            ->select('tz_business.business_type','tz_business.business_number','tz_business.machine_number','tz_work_order.work_order_type','tz_work_order.customer_id','tz_work_order.work_order_number','tz_work_order.work_order_content')
                            ->first();

            if(empty($business)){
                $return['data'] = [];
                $return['msg'] = '工单不存在';
                $return['code'] = 0;
                return $return;
            }
            $business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
            $business->business_type = $business_type[$business->business_type];
            $business->work_order_type = $this->workType($business->work_order_type);
    		$answer = $this->where($where)->get(['work_number','answer_content','answer_id','answer_name','answer_role','created_at']);
            $answer = ['content'=>$answer,'business'=>$business];
            if(!empty($answer)){
    			$return['data'] = $answer;
	    		$return['msg'] = '获取工单详情成功';
	    		$return['code'] = 1;
    		} else {
                $return['data'] = '';
                $return['msg'] = '暂无详情';
                $return['code'] = 0;
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
            $work_order = DB::table('tz_work_order')->where(['work_order_number'=>$insert_data['work_number']])->select('work_order_status')->first();
            if($work_order->work_order_status == 2){//工单为完成时，无法再进行操作
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '工单已完成,无法再进行联系';
                return $return;
            }
            if($work_order->work_order_status == 3){//工单为取消时，无法再进行操作
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '工单已取消,无法再进行联系';
                return $return;
            }
    		$uid = Admin::user()->id;
    		$insert_data['answer_id'] = $uid;
            $insert_data['answer_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
    		$insert_data['answer_role'] = 2;
    		$row = $this->create($insert_data);
    		if($row != false){
    			$return['data'] = $row;
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

    /**
     * 工单类型
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function workType($id){
        $worktype = DB::table('tz_work_type')->find($id,['parent_id','type_name']);
        $parent_id = $worktype->parent_id;
        if(!empty($parent_id)){
            $worktype = '【'.DB::table('tz_work_type')->where('id',$parent_id)->value('type_name').'】-- 【'.$worktype->type_name.'】';
        } else {
            $worktype = '【'.$worktype->type_name.'】';
        }
        return $worktype;
    }
}
