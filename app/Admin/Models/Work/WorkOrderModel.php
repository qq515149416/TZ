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
    protected $table = 'tz_work_order';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
// 网维人员：net dimension
// 网管人员: net manager
// 衡阳运维：hengyang
// 惠州运维：huizhou
// 西安运维：xian
// 业务员：salesman
// 管理人员：TZ_admin

    /**
     * 显示对应状态的所有工单(管理人员/网维人员/网管人员查看)
     * @param  array $where 工单状态
     * @return array        返回相关的数据信息和状态
     */
    public function showWorkOrder($where){
        // 进行数据查询
    	$result = $this->where($where)
                        ->get(['id','work_order_number','customer_id','customer_name','clerk_id','clerk_name','mac_num',
                               'mac_ip','work_order_type','work_order_content','submitter_id','submitter_name',
                               'submitter','work_order_status','process_department','complete_id','complete_number',
                               'summary','complete_time','created_at','updated_at']);
    	if(!$result->isEmpty()){
            // 查询到数据进行转换
    		$submitter = [1=>'客户',2=>'内部人员'];
    		$work_status = [0=>'待处理',1=>'处理中',2=>'工单完成',3=>'工单取消'];
    		foreach($result as $showkey=>$showvalue){
                // 提交方的转换
    			$result[$showkey]['submit'] = $submitter[$showvalue['submitter']];
                // 工单状态的转换
    			$result[$showkey]['workstatus'] = $work_status[$showvalue['work_order_status']];
                // 工单类型
                $worktype = (array)$this->workType($showvalue['work_order_type']);
                $result[$showkey]['worktype'] = $worktype['type_name'];
                $result[$showkey]['parenttype'] = $worktype['parenttype'];
                // 当前处理部门
                $department = (array)$this->role($showvalue['process_department']);
                $result[$showkey]['department'] = $department['name'];	
    		}
            $return['data'] = $result;
            $return['code'] = 1;
            $return['msg'] = '工单信息获取成功！！';
    	} else {
            $return['data'] = '暂无对应工单数据！！';
            $return['code'] = 0;
            $return['msg'] = '暂无对应工单数据';
        }
        return $return;
    }

    /**
     * 显示对应状态的所属客户的工单列表(业务员查看)
     * @param  array $where 工单状态
     * @return array        返回相关的数据信息和状态
     */
    public function clerkWorkOrder($where){
        // 获取当前登陆用户的id，当前用户可以查看到属于自己客户的信息
        $user_id = Admin::user()->id;
        $where['clerk_id'] = $user_id;
        // 进行数据查询
        $result = $this->where($where)
                        ->get(['id','work_order_number','customer_id','customer_name','clerk_id','clerk_name','mac_num',
                               'mac_ip','work_order_type','work_order_content','submitter_id','submitter_name',
                               'submitter','work_order_status','process_department','complete_id','complete_number',
                               'summary','complete_time','created_at','updated_at']);
        if(!$result->isEmpty()){
            // 查询到数据进行转换
            $submitter = [1=>'客户',2=>'内部人员'];
            $work_status = [0=>'待处理',1=>'处理中',2=>'工单完成',3=>'工单取消'];
            foreach($result as $showkey=>$showvalue){
                // 提交方的转换
                $result[$showkey]['submit'] = $submitter[$showvalue['submitter']];
                // 工单状态的转换
                $result[$showkey]['workstatus'] = $work_status[$showvalue['work_order_status']];
                // 工单类型
                $worktype = (array)$this->workType($showvalue['work_order_type']);
                $result[$showkey]['worktype'] = $worktype['type_name'];
                $result[$showkey]['parenttype'] = $worktype['parenttype'];
                // 当前处理部门
                $department = (array)$this->role($showvalue['process_department']);
                $result[$showkey]['department'] = $department['name'];  
            }
            $return['data'] = $result;
            $return['code'] = 1;
            $return['msg'] = '工单信息获取成功！！';
        } else {
            $return['data'] = '暂无对应工单数据！！';
            $return['code'] = 0;
            $return['msg'] = '暂无对应工单数据';
        }
        return $return;
    }

    /**
     * 显示对应状态的地区机房工单列表(地区机房人员查看)
     * @param  array $where 工单状态
     * @return array        返回相关的数据信息和状态
     */
    public function areaWorkOrder($where){
        //获取当前登陆用户的id，当前用户可以查看到属于自己客户的信息
        $user_id = Admin::user()->id;
        $role = (array)$this->role($user_id);
        //各地运维人员可以看到对应地区的工单
        $where['process_department'] = $role['roleid'];
        //进行数据查询
        $result = $this->where($where)
                        ->get(['id','work_order_number','customer_id','customer_name','clerk_id','clerk_name','mac_num',
                               'mac_ip','work_order_type','work_order_content','submitter_id','submitter_name',
                               'submitter','work_order_status','process_department','complete_id','complete_number',
                               'summary','complete_time','created_at','updated_at']);
        if(!$result->isEmpty()){
            //查询到数据进行转换
            $submitter = [1=>'客户',2=>'内部人员'];
            $work_status = [0=>'待处理',1=>'处理中',2=>'工单完成',3=>'工单取消'];
            foreach($result as $showkey=>$showvalue){
                //提交方的转换
                $result[$showkey]['submit'] = $submitter[$showvalue['submitter']];
                //工单状态的转换
                $result[$showkey]['workstatus'] = $work_status[$showvalue['work_order_status']];
                //工单类型
                $worktype = (array)$this->workType($showvalue['work_order_type']);
                $result[$showkey]['worktype'] = $worktype['type_name'];
                $result[$showkey]['parenttype'] = $worktype['parenttype'];
                //当前处理部门
                $department = (array)$this->role($showvalue['process_department']);
                $result[$showkey]['department'] = $department['name'];  
            }
            $return['data'] = $result;
            $return['code'] = 1;
            $return['msg'] = '工单信息获取成功！！';
        } else {
            $return['data'] = '暂无对应工单数据！！';
            $return['code'] = 0;
            $return['msg'] = '暂无对应工单数据';
        }
        return $return;
    }

    /**
     * 内部人员提交工单
     * @param  array $workdata  提交的工单数据
     * @return array           返回创建工单
     */
    public function insertWorkOrder($workdata){
    	if($workdata){
    		// 工单号的生成
    		$worknumber = mt_rand(71,99).date('Ymd',time()).substr(time(),5,5);
    		$workdata['work_order_number'] = (int)$worknumber;
            // 查找业务员
    		$admin_id = Admin::user()->id;
    		$workdata['submitter_id'] = $admin_id;
            $fullname = (array)$this->staff($admin_id);
    		$workdata['submitter_name'] = $fullname['fullname'];
            // 提交方
    		$workdata['submitter'] = 2;
    		$row = $this->create($workdata);
    		if($row != false){
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
    		if($editdata['work_order_status'] == 2){
    			// 存入完成时间
    			$edit->complete_time = date('Y-m-d H:i:s',time());
    			$id = Admin::user()->id;
    			// 完成人员id
    			$edit->complete_id = $id;
    			// 完成人员工号
                $number = (array)$this->staff($admin_id);
    			$edit->complete_number = $number['work_number'];
    			// 是否有报告总结的数据
    			if(!empty($editdata['summary'])){
    				$edit->summary = $editdata['summary'];
    			}
    			
    		}
    		// 修改状态
    		$edit->work_order_status = $editdata['work_order_status'];
    		// 是否转发下一个处理部门
    		if(!empty($editdata['process_department'])){
    			$edit->process_department = $editdata['process_department'];
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
     * 删除工单信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteWorkOrder($id){
        if($id){
            $row = $this->where('id',$id)->delete();
            if($row != false){
                $return['code'] = 1;
                $return['msg'] = '删除信息成功!!';
            } else {
                $return['code'] = 0;
                $return['msg'] = '删除信息失败!!';
            }
        } else {
            $return['code'] = 0;
            $return['msg'] = '无法删除信息!!';
        }
    }

    /**
     * 内部提交时根据用户账号的id查找出对应的账户的真实姓名
     * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
     * @return string           返回对应账户的真实姓名
     */
    public function staff($admin_id) {
    	$staff = DB::table('oa_staff')->where('admin_users_id',$admin_id)
                    ->select('work_number','fullname')->first();
        return $staff;
    }

    /**
     * 查找对应的工单类型及工单父级类型数据
     * @param  int $id 类型的id
     * @return array     返回对应的工单类型数据
     */
    public function workType($id){
        $worktype = DB::table('tz_worktype')->find($id,['parent_id','type_name']);
        $parent_id = $worktype->parent_id;
        if(!empty($parent_id)){
            $worktype['parenttype'] = DB::table('tz_work_type')->where('id',$parent_id)->value('type_name');
        } else {
            $worktype['parenttype'] = '';
        }
        return $worktype;
    }


    /**
     * 查找当前登陆用户的角色标识和角色名称
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function role($user_id){
        $role = DB::table('admin_role_users')
                    ->join('admin_roles','admin_role_users.role_id = admin_roles.id')
                    ->where('user_id',$user_id)
                    ->select('admin_roles.id as roleid','admin_roles.slug','admin_roles.name')
                    ->first();
        return $role;
    }
}
