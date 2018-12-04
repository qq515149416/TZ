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
            DB::beginTransaction();
            switch ($work_order->work_order_status) {
                case 0:
                    $row = DB::table('tz_business')->where(['work_order_number'=>$insert_data['work_number']])->update(['work_order_status'=>1]);
                    if($row == 0){
                        DB::rollBack();
                        $return['data'] = '';
                        $return['code'] = 0;
                        $return['msg'] = '联系失败';
                        return $return;
                    }
                    break;
                case 2:
                    $return['data'] = '';
                    $return['code'] = 0;
                    $return['msg'] = '工单已完成,无法再进行联系';
                    return $return;
                    break;
                case 3:
                    $return['data'] = '';
                    $return['code'] = 0;
                    $return['msg'] = '工单已取消,无法再进行联系';
                    return $return;
                    break;
                default:
                    break;
            }
    		$uid = Admin::user()->id;
    		$insert_data['answer_id'] = $uid;
            $insert_data['answer_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
    		$insert_data['answer_role'] = 2;
    		$row = DB::table('tz_work_answer')->insertGetId($insert_data);
    		if($row != 0){
                DB::commit();
                $insert_data['id'] = $row;
                $work_order_detail = DB::table('tz_work_order')->where(['work_order_number'=>$insert_data['work_number']])->select('id','work_order_number','business_num','customer_id','work_order_type','work_order_content','submitter_name','work_order_status','process_department','complete_time','created_at','updated_at')->first();
                /**
                 * 转换工单
                 * @var [type]
                 */
                $submitter = [1=>'客户',2=>'内部人员'];
                $work_status = [0=>'待处理',1=>'处理中',2=>'完成',3=>'取消'];
                // 提交方的转换
                $work_order_detail->submit = $submitter[$work_order_detail->submitter];
                // 工单状态的转换
                $work_order_detail->workstatus = $work_status[$work_order_detail->work_order_status];
                // 工单类型
                $worktype = $this->workType($work_order_detail->work_order_type);
                $work_order_detail->worktype = $worktype;
                // 当前处理部门
                $work_order_detail->department = $this->department($work_order_detail->process_department)->depart_name;
                // 对应的业务数据
                $business = $this->businessDetail($work_order_detail->business_num);
                $work_order_detail->client_name = $business->client_name;
                $work_order_detail->business_type = $business->business_type;
                $work_order_detail->machine_number = $business->machine_number;
                $work_order_detail->resource_detail = $business->resource_detail;
                $work_order_detail->sales_name = $business->sales_name;
                $work_order_detail = $work_order_detail->toArray();
                curl('http://127.0.0.1:8121',$work_order_detail);
    			$return['data'] = $insert_data;
	    		$return['code'] = 1;
	    		$return['msg'] = '';
    		} else {
                DB::rollBack();
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
