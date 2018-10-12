<?php

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class WorkOrderModel extends Model
{
    use  SoftDeletes;
    protected $table = 'tz_work_order';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * 展示工单
     * @param  array $status 工单的状态
     * @return array         返回对应的状态和提示信息
     */
    public function showWorkOrder($status){
    	$where = [
    		'customer_id' => Auth::user()->id;
    		'submitter'  => 1;
    		$status;
    	]
    	$list = $this->where($where)->get(['id','work_order_number','business_num','work_order_type','work_order_content','submitter_name','work_order_status','process_department','complete_time','created_at','updated_at']);
    	if(!$list->isEmpty()){
    		// 查询到数据进行转换
    		$work_status = [0=>'待处理',1=>'处理中',2=>'完成',3=>'取消'];
    		foreach($list as $showkey=>$showvalue){
                // 工单状态的转换
    		    $list[$showkey]['workstatus'] = $work_status[$showvalue['work_order_status']];
                // 工单类型
                $worktype = $this->workType($showvalue['work_order_type']);
                $list[$showkey]['worktype'] = $worktype->parenttype?$worktype->parenttype.'->'.$worktype->type_name:$worktype->type_name;
                // $list[$showkey]['parenttype'] = $worktype->parenttype;
                // 当前处理部门
                $list[$showkey]['department'] = $showvalue['process_department']?$this->role($showvalue['process_department'])->name:'网维部门';
                $business = $this->businessDetail($showvalue['business_num']);
                $list[$showkey]['client_name'] = $business->client_name;
                $list[$showkey]['business_type'] = $business->business_type;	
                $list[$showkey]['machine_number'] = $business->machine_number;
                $list[$showkey]['resource_detail'] = $business->resource_detail;	
    		}
            $return['data'] = $list;
            $return['code'] = 1;
            $return['msg'] = '工单信息获取成功！！';

    	} else {
    		$return['data'] = '暂无您提交的对应工单数据!';
    		$return['code'] = 0;
    		$return['msg'] = '暂无您提交的对应工单数据!';
    	}
    	return $return;
    }

    /**
     * 提交工单
     * @param  array $insert_data 工单的数据
     * @return array              返回相关的状态及提示信息
     */
    public function insertWorkOrder($insert_data){
    	if(!$insert_data){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '工单无法提交';
    		return $return;
    	}
    	
    	$where = ['client_id'=>Auth::user()->id,'business_number'=>$insert_data['business_num'],'business_status'=>'in (2,3,4)'];
    	// $where_in = ['business_status'=>[2,3,4]];
    	$business = DB::table('tz_business')->where($where)->select('client_id','business_number','sales_id')->first();
    	if(!$business){
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '工单所属业务不存在或者已过期或者已取消,请确认后提交';
    		return $return;
    	}
		// 工单号的生成
		$worknumber = mt_rand(71,99).date("Ymd",time()).substr(time(),8,2);
		$insert_data['work_order_number'] = $worknumber;//工单号
		$insert_data['customer_id'] = Auth::user()->id;//客户id,方便对应客户查看对应业务的工单
		$insert_data['clerk_id'] = $business->sales_id;//业务员id,方便业务员查看自己客户的工单
		$insert_data['submitter_id'] = Auth::user()->id;//提交者id
		$insert_data['submitter_name'] = Auth::user()->name;//提交者姓名
		$insert_data['submitter'] = 1;//提交方客户
		$insert_data['work_order_status'] = 0;//工单状态
		$insert_data['process_department'] = 0;//转发部门
		$row = $this->create($insert_data);
		if($row != false){
			$return['data'] = $row->id;
			$return['code'] = 1;
			$return['msg'] = '工单提交成功,等待工作人员处理,您的工单号:'.$row->work_order_number;
		} else {
			$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '工单提交失败';
		}
    
    		
    	return $return;
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

    /**
     * 根据工单绑定的业务编号进行业务数据的查询
     * @param  string $business_number 业务编号
     * @return                   对应的业务数据
     */
    public function businessDetail($business_number){
    	$business = DB::table('tz_business')->where('business_number',$business_number)->select('client_name','business_type','machine_number','resource_detail')->first();
    	$business_type = ['-1'=>'取消','-2'=>'审核不通过',0=>'审核中',1=>'审核通过',2=>'付款使用中',3=>'未付款使用',4=>'锁定中',5=>'到期',6=>'退款'];
    	$business->business_type = $business_type[$business->business_type];
    	return $business;
    }
}