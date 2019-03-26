<?php

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Models\Customer\WorkAnswerModel;

class WorkOrderModel extends Model
{
    use  SoftDeletes;
    protected $table = 'tz_work_order';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ["work_order_number","business_num","customer_id","clerk_id","work_order_type","work_order_content","submitter_id","submitter_name","submitter","work_order_status","process_department","complete_id","complete_number","summary","complete_time","created_at","updated_at","deleted_at"];

    /**
     * 展示工单
     * @param  array $status 工单的状态
     * @return array         返回对应的状态和提示信息
     */
    public function showWorkOrder($status){
    	$where = [
    		'customer_id' => Auth::user()->id,
    		'submitter'  => 1,
        ];
    	if(isset($status['work_order_status'])){
    		$where['work_order_status']= $status['work_order_status'];
    	}

    	$list = $this->where($where)->get(['id','work_order_number','business_num','work_order_type','work_order_content','submitter_name','work_order_status','process_department','complete_time','created_at','updated_at']);
    	if(!$list->isEmpty()){
    		// 查询到数据进行转换
    		$work_status = [0=>'待处理',1=>'处理中',2=>'完成',3=>'取消'];
    		foreach($list as $showkey=>$showvalue){
                // 工单状态的转换
    		    $list[$showkey]['workstatus'] = $work_status[$showvalue['work_order_status']];
                // 工单类型
                $worktype = $this->workType($showvalue['work_order_type']);
                $list[$showkey]['worktype'] = $worktype->parenttype?'【'.$worktype->parenttype.'】 -- 【'.$worktype->type_name.'】':'【'.$worktype->type_name.'】';
                // 当前处理部门
                $list[$showkey]['department'] = $this->department($showvalue['process_department'])->depart_name;
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
    	$where = ['client_id'=>Auth::user()->id,'business_number'=>$insert_data['business_num']];
        $business = DB::table('tz_business')->where($where)->whereIn('business_status',[0,1,2,3,4])->select('client_id','business_number','sales_id','sales_name')->first();
    	if(!$business){
            $business = DB::table('tz_defenseip_business')
                            ->join('tz_users','tz_defenseip_business.user_id','=','tz_users.id')
                            ->join('admin_users','tz_users.salesman_id','=','admin_users.id')
                            ->where(['tz_defenseip_business.user_id'=>Auth::user()->id,'tz_defenseip_business.business_number'=>$insert_data['business_num'],'tz_defenseip_business.status'=>1])
                            ->select('tz_defenseip_business.id','admin_users.id as sales_id','admin_users.name as sales_name')
                            ->first();
            if(!$business){
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '工单所属业务不存在或者已过期或者已取消,请确认后提交';
                return $return;
            }
    		
    	}
        $work_order = $this->where(['business_num'=>$insert_data['business_num']])->whereBetween('work_order_status',array(0,1))->get(['id','work_order_number']);
        if(!$work_order->isEmpty()){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '该业务有工单正在处理中,无法提交新的工单,如有需要,请在处理中的工单下联系';
            return $return;
        }
		// 工单号的生成
		$worknumber = mt_rand(71,99).date("Ymd",time()).substr(time(),8,2);
		$insert_data['work_order_number'] = $worknumber;//工单号
		$insert_data['customer_id'] = Auth::user()->id;//客户id,方便对应客户查看对应业务的工单
		$insert_data['clerk_id'] = $business->sales_id;//业务员id,方便业务员查看自己客户的工单
		$insert_data['submitter_id'] = Auth::user()->id;//提交者id
		$insert_data['submitter_name'] = Auth::user()->name?Auth::user()->name:Auth::user()->email;//提交者姓名
		$insert_data['submitter'] = 1;//提交方客户
		$insert_data['work_order_status'] = 0;//工单状态
		$insert_data['process_department'] = $this->department()->id;//转发部门
		$row = $this->create($insert_data);
        $answer = new WorkAnswerModel();
        $answer->insertWorkAnswer(['work_number'=>$row['work_order_number'],'answer_content'=>$row['work_order_content']]);
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
            // dd($business);
            $row->sales_name = $business->sales_name;
            $row = $row->toArray();
            $array = ['work_order'=>$row];
            $socket_url = env('SOCKET_URL');//获取.env里面的有关socket_url的地址
            $end = strrpos($socket_url,':');//端口号前的:位置
            $start = strpos($socket_url,'/')+2;//‘/’第一次出现的第一次位置加2就是url地址的开始部分
            $url = substr($socket_url,$start,$end - $start);//截取url地址
            curl('http://'.$url.':8121',$array);
			$return['data'] = $row['id'];
			$return['code'] = 1;
			$return['msg'] = '工单提交成功,等待工作人员处理,您的工单号:'.$row['work_order_number'];
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
