<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * 工单的模型
 */
class WorkOrderModel extends Model
{
    use  SoftDeletes;
    protected $table = 'tz_workorder';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function showWorkOrder($where){
    	$result = $this->where($where)->get(['id','work_num','orders_num','business_num','customer_id','customer_name','machine_num','submit_id','submit_name','content','identity','work_status','work_department','complete_time','complete_id','complete_name','summary','work_note','created_at','updated_at']);
    	if(!$result->isEmpty()){
    		$identity = [1=>'内部提交',2=>'客户提交'];
    		$work_status = [0=>'待处理',1=>'处理中',2=>'工单完成',3=>'工单取消'];
    		foreach($result as $showkey=>$showvalue){
    			$result[$showkey]['identi'] = $identity[$showvalue['identity']];
    			$result[$showkey]['workstatus'] = $work_status[$showvalue['work_status']];	
    		}
    	}
    }

    /**
     * 内部人员提交工单
     * @param  array $workdata  提交的工单数据
     * @return array           返回创建工单
     */
    public function insertWorkOrder($workdata){
    	if($workdata){
    		// 工单号的生成
    		$worknumber = mt_rand(7,9).date('ymd',time()).substr(time(),5,5);
    		$workdata['work_num'] = $worknumber;
    		$admin_id = Admin::user()->id;
    		$workdata['submit_id'] = $admin_id;
    		// admin_users_id
    		$workdata['submit_name'] = $this->staff($admin_id);
    		$workdata['identity'] = 1;
    		$row = $this->create($workdata);
    		if($row!=false){
    			$return['data'] = $row->id;
    			$return['code'] = 1;
    			$return['msg'] = '工单提交成功，请耐心等待处理！！';
    		} else {
    			$return['data'] = '';
    			$return['code'] = 0;
    			$return['msg'] = '工单提交失败！！';
    		}

    	} else {
    		$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '工单无法提交！！';
    	}
    	return $return;
    }

    /**
     * 对工单的处理状态进行修改
     * @param  array $editdata 需要修改的数据
     * @return array           返回相关的状态和提示信息
     */
    public function editWorkOrder($editdata){
    	if($editdata){
    		$edit = $this->find($editdata['id']);
    		// 当工单处理状态修改为2完成时
    		if($editdata['work_status'] == 2){
    			// 存入完成时间
    			$edit->complete_time = date('Y-m-d H:i:s',time());
    			$id = Admin::user()->id;
    			// 完成人员id
    			$edit->complete_id = $id;
    			// 完成人员姓名
    			$edit->complete_name = $this->staff($id);
    			// 是否有报告总结的数据
    			if(!empty($editdata['summary'])){
    				$edit->summary = $editdata['summary'];
    			}
    			
    		}
    		// 修改状态
    		$edit->work_status = $editdata['work_status'];
    		// 是否转发下一个处理部门
    		if(!empty($editdata['work_department'])){
    			$edit->work_department = $editdata['work_department'];
    		}
    		$row = $edit->save();
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '工单修改成功!!';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '工单修改失败!!';
    		}

    	} else {
    		$return['code'] = 0;
			$return['msg'] = '工单无法修改!!';
    	}
    	return $return;
    }

    /**
     * 内部提交时根据用户账号的id查找出对应的账户的真实姓名
     * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
     * @return string           返回对应账户的真实姓名
     */
    public function staff($admin_id) {
    	$staff = DB::table('oa_staff')->where('admin_users_id',$admin_id)->value('fullname');
    	return $staff;
    }
}
