<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;

/**
 * 所有客户信息
 */
class CustomerModel extends Model
{

    protected $table = 'tz_users';
    public $timestamps = true;


    /**
     * 查找业务员姓名
     * @param  int $id oa_staff表的admin_users_id字段的值
     * @return string     返回对应业务员的姓名
     */
    public function clerk($id){
    	$clerk = DB::table('admin_users')->where(['id'=>$id])->value('name');
        if(empty($clerk)){
            $clerk = '未绑定业务员';
        }
    	return $clerk;
    }

    public function rechargeByAdmin($data){
        $clerk_id = Admin::user()->id;
        $yewuyuan_id = $this->where('id',$data['user_id'])->value('salesman_id');

        $return = [
        	'data'  => '',
	'msg'   => '',
	'code'  => 0,
        ];

        if($clerk_id != $yewuyuan_id){
        	$return['msg'] = '此客户不属于您';
        	return $return;
        }

        $data['trade_no']               	= 'tz_'.time().'_'.$data['user_id'];
        //$data['money_before']      	= $cus->money;
        //$data['money_after']      	= bcadd($data['money_before'],$data['recharge_amount'],2);
        $data['audit_status']	= 0;
        $data['recharge_uid']	= $clerk_id;
        $data['created_at']		= date("Y-m-d H:i:s",time());
        //开始事务

        // DB::beginTransaction();
        // $cus->money = $data['money_after'];
        // $update = $cus->save();
        // if($update != true){
        // 	DB::rollBack();
        // 	$return['msg'] = '更新余额失败';
        // 	return $return;
        // }

        $res = DB::table('tz_recharge_admin')->insert($data);

        if($res != true){  	
        	$return['msg'] = '充值审核单创建失败';
        }else{
            $return['msg'] = '充值审核单创建成功!';
            $return['code'] = 1;
        }
        return $return;
    }




    public function getRechargeFlow($way,$key = ''){   
        switch ($way) {
             case 'my_all':
                  $clerk_id = Admin::user()->id;
                  $flow = DB::table('tz_users')
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->where('tz_users.salesman_id',$clerk_id)
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

             case 'customer_id':
                  $flow = DB::table('tz_users')
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->where('tz_users.id',$key)
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

            case '*':
                  $flow = DB::table('tz_users')
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

            case 'byMonth':
                  $flow = DB::table('tz_users')
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->where('b.month',$key)
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

             default:
                    $flow = '';
                 break;
         } 
       
        if($flow->isEmpty()){
            $return['data'] = '';
            $return['msg'] = '无数据';
            $return['code'] = 0;
            return $return;
        }
        $flow = json_decode($flow,true);   
        $recharge_way = [ 1 => '支付宝' , 2 => '微信' , 3 => '工作人员手动充值' ];
        for ($i=0; $i < count($flow); $i++) { 
            if($flow[$i]['salesman_id'] == 0){
                $flow[$i]['salesman_name'] = '自助充值';
            }else{
                $flow[$i]['salesman_name'] = DB::table('admin_users')->where('id',$flow[$i]['salesman_id'])->value('name');
            }
            $flow[$i]['recharge_way'] = $recharge_way[$flow[$i]['recharge_way']];
            $flow[$i]['customer_name'] = $flow[$i]['customer_name'] ? $flow[$i]['customer_name'] : $flow[$i]['email'];
        }
        $return['data'] = $flow;
        $return['msg'] = '获取成功';
        $return['code'] = 1;
        return $return;
    }

}
