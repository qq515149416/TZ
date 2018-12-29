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
            $idc_business = DB::table('tz_work_order')
                            ->join('tz_business', 'tz_work_order.business_num', '=', 'tz_business.business_number')
                            ->where(['work_order_number'=>$where['work_number']])
                            ->select('tz_business.business_type','tz_business.resource_detail','tz_business.business_number','tz_business.machine_number','tz_work_order.work_order_type','tz_work_order.customer_id','tz_work_order.work_order_number','tz_work_order.work_order_content')
                           ->first();
            if(!empty($idc_business)){
                $resource_detail = json_decode($idc_business->resource_detail);
                $idc_business->cpu = isset($resource_detail->cpu)?$resource_detail->cpu:'';
                $idc_business->memory = isset($resource_detail->memory)?$resource_detail->memory:'';
                $idc_business->harddisk = isset($resource_detail->harddisk)?$resource_detail->harddisk:'';
                $idc_business->bandwidth = isset($resource_detail->bandwidth)?$resource_detail->bandwidth:'';
                $idc_business->protect = isset($resource_detail->protect)?$resource_detail->protect:'';
                $idc_business->machine_type = isset($resource_detail->machine_type)?$resource_detail->machine_type:'';
                $idc_business->cabinets = isset($resource_detail->cabinets)?$resource_detail->cabinets:isset($resource_detail->cabinet_id)?$resource_detail->cabinet_id:'';
                $idc_business->ip = isset($resource_detail->ip_detail)?$resource_detail->ip_detail:'';
                $idc_business->machineroom_name = $resource_detail->machineroom_name;
                unset($idc_business->resource_detail);
                $business = $idc_business;
            } else {
                $define_business = DB::table('tz_work_order')
                            ->join('tz_defenseip_business', 'tz_work_order.business_num', '=', 'tz_defenseip_business.business_number')
                            ->join('tz_defenseip_store','tz_defenseip_business.ip_id','=','tz_defenseip_store.id')
                            ->join('tz_users','tz_defenseip_business.user_id','=','tz_users.id')
                            ->where(['tz_work_order.work_order_number'=>$where['work_number']])
                            ->select('tz_defenseip_business.target_ip','tz_defenseip_store.ip','tz_defenseip_store.protection_value','tz_users.name','tz_users.email','tz_work_order.work_order_type','tz_work_order.customer_id','tz_work_order.work_order_number','tz_work_order.work_order_content')
                            ->first();
                if(!empty($define_business)){
                    $define_business->business_type = 4;
                    $define_business->client_name = $define_business->name?$define_business->name:$define_business->email;
                    $define_business->machine_number = $define_business->ip;
                    $define_business->protect = $define_business->protection_value;
                    $business = $define_business;
                }
            }
            if(empty($business)){
                $return['data'] = [];
                $return['msg'] = '工单不存在';
                $return['code'] = 0;
                return $return;
            }
            $business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'高防IP'];
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
                    $row = DB::table('tz_work_order')->where(['work_order_number'=>$insert_data['work_number']])->update(['work_order_status'=>isset($insert_data['work_order_status'])?$insert_data['work_order_status']:1]);
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
            $insert_data['created_at'] = date('Y-m-d H:i:s',time());
    		$row = DB::table('tz_work_answer')->insertGetId($insert_data);
    		if($row != 0){
                DB::commit();
                $insert_data['id'] = $row;
                $work_order_detail = DB::table('tz_work_order')->where(['work_order_number'=>$insert_data['work_number']])->select('id','work_order_number','business_num','customer_id','clerk_id','work_order_type',
                              'work_order_content','submitter_id','submitter_name','submitter','work_order_status',
                              'process_department','complete_id','complete_number','summary','complete_time','created_at','updated_at')->first();
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
                $insert_data['customer_id'] = $work_order_detail->customer_id;
                $insert_data['role'] = $work_order_detail->submitter;
                $work_order_detail = (array)$work_order_detail;
                $array = ['work_order'=>$work_order_detail,'work_chat'=>$insert_data];
                curl('http://sk.jungor.cn:8121',$array);
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
            $business->resource_detail = json_decode(json_encode($business));
        }
        $business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'高防IP'];
        $business->business_type = $business_type[$business->business_type];
        return $business;
    }
}
