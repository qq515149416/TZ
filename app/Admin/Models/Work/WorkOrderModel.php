<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\Work\WorkAnswerModel;


/**
 * 工单的模型
 */
class WorkOrderModel extends Model
{
    use  SoftDeletes;
    protected $table = 'tz_work_order';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ["work_order_number","business_num","customer_id","clerk_id","work_order_type","work_order_content","submitter_id","submitter_name","submitter","work_order_status","process_department","complete_id","complete_number","summary","complete_time","created_at","updated_at","deleted_at"];

    /**
     * 用于检验后台用户信息是否完整
     */
    // public function __construct(){
    //     $user_id = Admin::user()->id;
    //     $staff = DB::table('oa_staff')->where(['admin_users_id'=>$user_id])->select('id','department','job','work_number')->first();
    //     if(empty($staff)){

    //     }
    // }

    /**
     * 显示对应状态的所有工单(管理人员/网维人员/网管人员查看)
     * @param  array $where 工单状态
     * @return array        返回相关的数据信息和状态
     */
    public function showWorkOrder($where){
        /**
         * 根据不同角色进行查看不同的内容
         * @var [type]
         */
        $user_id = Admin::user()->id;
        $staff = $this->staff($user_id);

        if( !Admin::user()->inRoles(['administrator','network_dimension'])   ){
            if($staff->slug == 3){//业务查看
                $where['clerk_id'] = $user_id;
            } elseif($staff->slug == 4){//机房查看
                $where['process_department'] = $staff->department;
            }
        }
 
        // 进行数据查询
        $result = $this->where($where)
                        ->get(['id','work_order_number','business_num','customer_id','clerk_id','work_order_type',
                              'work_order_content','submitter_id','submitter_name','submitter','work_order_status',
                              'process_department','complete_id','complete_number','summary','complete_time','created_at','updated_at']);
        if(!$result->isEmpty()){
            // 查询到数据进行转换
            $submitter = [1=>'客户',2=>'内部人员'];
            $work_status = [0=>'待处理',1=>'处理中',2=>'完成',3=>'取消'];
            foreach($result as $showkey=>$showvalue){
                // 提交方的转换
                $result[$showkey]['submit'] = $submitter[$showvalue['submitter']];
                // 工单状态的转换
                $result[$showkey]['workstatus'] = $work_status[$showvalue['work_order_status']];
                // 工单类型
                $worktype = $this->workType($showvalue['work_order_type']);


                $result[$showkey]['worktype'] = $worktype->parenttype?'【'.$worktype->parenttype.'】 -- 【'.$worktype->type_name.'】':'【'.$worktype->type_name.'】';
                // 当前处理部门
                $result[$showkey]['department'] = $this->department($showvalue['process_department'])->depart_name;
                // 对应的业务数据
                $business = $this->businessDetail($showvalue['business_num']);

                $result[$showkey]['client_name'] = $business->client_name;
                $result[$showkey]['business_type'] = $business->business_type;
                $result[$showkey]['machine_number'] = $business->machine_number;
                $result[$showkey]['resource_detail'] = $business->resource_detail;
                $result[$showkey]['sales_name'] = $business->sales_name;
                // dump($result);
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
    public function insertWorkOrder($work_data){
    	if(!$work_data){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '无法提交工单';
            return $return;

        }
        if( !Admin::user()->inRoles(['network_dimension'])   ){
           $where = ['sales_id'=>Admin::user()->id,'business_number'=>$work_data['business_num']];
        }else{
            $where = ['business_number'=>$work_data['business_num']];
        }
        
        $business = DB::table('tz_business')->where($where)->whereIn('business_status',[0,1,2,3,4])->select('client_id','business_number','sales_id')->first();
    	if(!$business){
            $business = DB::table('tz_defenseip_business')
                            ->join('tz_users','tz_defenseip_business.user_id','=','tz_users.id')
                            ->join('admin_users','tz_users.salesman_id','=','admin_users.id')
                            ->where(['tz_defenseip_business.business_number'=>$work_data['business_num'],'tz_defenseip_business.status'=>1])
                            ->select('tz_defenseip_business.id','admin_users.id as sales_id','admin_users.name as sales_name','tz_defenseip_business.user_id as client_id')
                            ->first();
            if(!$business){
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '工单所属业务不存在或者已过期或者已取消,请确认后提交';
                return $return;
            }
            
        }
        $work_order = $this->where(['business_num'=>$work_data['business_num']])->whereBetween('work_order_status',array(0,1))->get(['id','work_order_number']);
        if(!$work_order->isEmpty()){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '该业务有工单正在处理中,无法提交新的工单,如有需要,请在处理中的工单下联系';
            return $return;
        }
        // 工单号的生成
        $worknumber = mt_rand(71,99).date("Ymd",time()).substr(time(),8,2);
        $work_data['work_order_number'] = $worknumber;//工单号
        $work_data['customer_id'] = $business->client_id;//客户id,方便对应客户查看对应业务的工单
        $work_data['clerk_id'] = Admin::user()->id;//业务员id,方便业务员查看自己客户的工单
        $work_data['submitter_id'] = Admin::user()->id;//提交者id
        $work_data['submitter_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;//提交者姓名
        $work_data['submitter'] = 2;//提交方客户
        $work_data['work_order_status'] = 0;//工单状态
        $work_data['process_department'] = $this->department()->id;//转发部门
        $row = $this->create($work_data);
        $answer = new WorkAnswerModel();
        $answer->insertWorkAnswer(['work_number'=>$row['work_order_number'],'answer_content'=>$row['work_order_content'],'work_order_status'=>0]);
        if($row != false){

            /**
             * 当提交工单成功的时候使用curl进行模拟传值，发送数据到实时推送接口
             * @var [type]
             */
            $submitter = [1=>'客户',2=>'内部人员'];
            $work_status = [0=>'待处理',1=>'处理中',2=>'完成',3=>'取消'];
            // 提交方的转换
            $row->submit = $submitter[$row->submitter];
            // 工单状态的转换
            $row->workstatus = $work_status[$row->work_order_status];
            // 工单类型
            $worktype = $this->workType($row->work_order_type);
            $row->worktype = $worktype->parenttype?'【'.$worktype->parenttype.'】 -- 【'.$worktype->type_name.'】':'【'.$worktype->type_name.'】';
            // 当前处理部门
            $row->department = $this->department($row->process_department)->depart_name;
            // 对应的业务数据
            $business = $this->businessDetail($row->business_num);
            $row->client_name = $business->client_name;
            $row->business_type = $business->business_type;
            $row->machine_number = $business->machine_number;
            $row->resource_detail = $business->resource_detail;
            $row->sales_name = $business->sales_name;
            $row = $row->toArray();
            $array = ['work_order'=>$row];
            curl('http://sk.tzidc.com:8121',$array);
            $return['data'] = $row['id'];
            $return['code'] = 1;
            $return['msg'] = '工单提交成功,工单号:'.$row['work_order_number'];        
            
        } else {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '工单提交失败';
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
            $user_id = Admin::user()->id;
            $staff = $this->staff($user_id);
            if($staff->slug != 2){
                if($edit->work_order_status == 2){
                    $return['code'] = 0;
                    $return['msg'] = '工单是已完成的,您无权对其进行再次操作!!';
                    return $return;
                }
                if($edit->work_order_status == 3){
                    $return['code'] = 0;
                    $return['msg'] = '工单是已取消的,您无权对其进行再次操作!!';
                    return $return;
                }
                if($edit->work_order_status == 1 && $editdata['work_order_status']==0){
                    $return['code'] = 0;
                    $return['msg'] = '您无权对处理中的工单的状态修改为待处理!!';
                    return $return;
                }
                if($edit->work_order_status == 1 && $editdata['work_order_status']==3){
                    $return['code'] = 0;
                    $return['msg'] = '您无权对处理中的工单的状态修改为取消!!';
                    return $return;
                }
            }
    		// 当工单处理状态修改为2完成时
    		if($editdata['work_order_status'] == 2){
    			// 存入完成时间
    			$edit->complete_time = date('Y-m-d H:i:s',time());
    			$id = Admin::user()->id;
    			// 完成人员id
    			$edit->complete_id = $id;
    			// 完成人员工号
                $number = (array)$this->staff($id);
    			$edit->complete_number = isset($number['work_number'])?$number['work_number']:123345;
    			// 是否有报告总结的数据
    			if(!empty($editdata['summary'])){
    				$edit->summary = $editdata['summary'];
    			}

    		}
    		// 修改状态
    		$edit->work_order_status = $editdata['work_order_status'];
    		// 是否转发下一个处理部门
    		if(isset($editdata['process_department'])){
    			$edit->process_department = $editdata['process_department'];
    		}
    		$row = $edit->save();//true
    		if($row != false){
                if($editdata['work_order_status'] == 1){
                    /**
                     * 当工单状态修改为处理中时将值传递到实时推送接口
                     * @var [type]
                     */
                    $edit_after = $this->find($editdata['id']);
                    $submitter = [1=>'客户',2=>'内部人员'];
                    $work_status = [0=>'待处理',1=>'处理中',2=>'完成',3=>'取消'];
                    // 提交方的转换
                    $edit_after->submit = $submitter[$edit_after->submitter];
                    // 工单状态的转换
                    $edit_after->workstatus = $work_status[$edit_after->work_order_status];
                    // 工单类型
                    $worktype = $this->workType($edit_after->work_order_type);
                    $edit_after->worktype = $worktype->parenttype?'【'.$worktype->parenttype.'】 -- 【'.$worktype->type_name.'】':'【'.$worktype->type_name.'】';
                    // 当前处理部门
                   $edit_after->department = $this->department($edit_after->process_department)->depart_name;
                    // 对应的业务数据
                    $business = $this->businessDetail($edit_after->business_num);
                    $edit_after->client_name = $business->client_name;
                    $edit_after->business_type = $business->business_type;
                    $edit_after->machine_number = $business->machine_number;
                    $edit_after->resource_detail = $business->resource_detail;
                    $edit_after->sales_name = $business->sales_name;
                    $edit_after = $edit_after->toArray();
                    $array = ['work_order'=>$edit_after];
                    curl('http://sk.tzidc.com:8121',$array);
                }
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
        return $return;
    }

    /**
     * 内部提交时根据用户账号的id查找出对应的账户的真实姓名
     * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
     * @return string           返回对应账户的真实姓名
     */
    public function staff($admin_id) {
    	$staff = DB::table('oa_staff')
                    ->join('tz_department','oa_staff.department','=','tz_department.id')
                    ->join('tz_jobs','oa_staff.job','=','tz_jobs.id')
                    ->where(['admin_users_id'=>$admin_id])
                    ->select('oa_staff.work_number','oa_staff.department','tz_department.sign','tz_jobs.slug')
                    ->first();
        return $staff;
    }

    /**
     * 查找对应的工单类型及工单父级类型数据
     * @param  int $id 类型的id
     * @return array     返回对应的工单类型数据
     */
    public function workType($id){
        $worktype = DB::table('tz_work_type')->find($id,['parent_id','type_name']);
        $parent_id = $worktype->parent_id;
        if(!empty($parent_id)){
            $worktype->parenttype = DB::table('tz_work_type')->where('id',$parent_id)->value('type_name');
        } else {
            $worktype->parenttype = '';
        }
        return $worktype;
    }

    /**
     * 部门转换
     * @param  [type] $depart_id [description]
     * @return [type]            [description]
     */
    public function department($depart_id = 0){
        if($depart_id != 0){
            $where['id'] =  $depart_id;
        } else {
            $where['sign'] = 2;
        }
        $depart = DB::table('tz_department')->where($where)->select('id','depart_number','depart_name')->first();
        return $depart;
    }

    /**
     * 根据工单绑定的业务编号进行业务数据的查询
     * @param  string $business_number 业务编号
     * @return                   对应的业务数据
     */
    public function businessDetail($business_number){
        $business = DB::table('tz_business')->where('business_number',$business_number)->select('client_name','business_type','machine_number','resource_detail','sales_name')->first();
        if(!$business){
            $business = DB::table('tz_defenseip_business')
                            ->join('tz_defenseip_store','tz_defenseip_business.ip_id','=','tz_defenseip_store.id')
                            ->join('tz_users','tz_defenseip_business.user_id','=','tz_users.id')
                            ->join('admin_users','tz_users.salesman_id','=','admin_users.id')
                            ->where('tz_defenseip_business.business_number',$business_number)
                            ->select('tz_defenseip_business.target_ip','tz_defenseip_store.ip','tz_defenseip_store.protection_value','tz_users.name','tz_users.email','admin_users.name as sales_name')
                            ->first();
            $business->business_type = 4;
            $business->client_name = $business->name?$business->name:$business->email;
            $business->machine_number = $business->ip;
            $business->resource_detail = json_encode((array)$business);
        }
        $business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'高防IP'];
        $business->business_type = $business_type[$business->business_type];
        return $business;
    }

    /**
     * 获取工单类型
     * @param  [type] $parent_id [description]
     * @return [type]            [description]
     */
    public function workTypes($parent_id){
        if(!$parent_id){
            $parent_id['parent_id'] = 0;
        }
        $work_type = DB::table('tz_work_type')->where($parent_id)->whereNull('deleted_at')->select('id','type_name')->get();
        $return['data'] = $work_type;
        $return['code'] = 1;
        $return['msg'] = '获取分类成功';
        return $return;
    }
}
