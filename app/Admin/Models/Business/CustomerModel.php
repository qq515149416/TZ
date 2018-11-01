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
	 * 管理人员查看客户信息
	 * @return array 返回客户信息和状态提示及信息
	 */
    public function adminCustomer(){
        $clerk_id = Admin::user()->id;
        $slug = DB::table('oa_staff')->join('tz_jobs','oa_staff.job','=','tz_jobs.id')
                ->where(['oa_staff.admin_users_id'=> $clerk_id])
                ->select('tz_jobs.slug')
                ->first();
        if(empty($slug)){
            $return['data'] = [];
            $return['code'] = 0;
            $return['msg'] = '请先完善您的个人信息';
            return $return;
        }
        if($slug->slug == 3){
            $where['salesman_id'] = $clerk_id;
        } else {
            $where = [];
        }
    	$admin_customer = $this->where($where)->get(['id','status','name','email','money','salesman_id','created_at','updated_at']);
    	if(!$admin_customer->isEmpty()){
    		$status = [0=>'拉黑',1=>'未验证',2=>'正常'];
    		foreach($admin_customer as $key=>$value){
    			$admin_customer[$key]['status'] = $status[$value['status']];
    			$admin_customer[$key]['clerk_name'] = $this->clerk($value['salesman_id']);
    		}
    		$return['data'] = $admin_customer;
    		$return['code'] = 1;
    		$return['msg'] = '获取客户信息成功';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '获取客户信息失败';
    	}

    	return $return;
    }

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

    /**
     * 后台手动将客户拉入黑名单
     * @param  array $data 需要加入黑名单的客户的id和黑名单的状态
     * @return array       返回相关的状态信息及提示
     */
    public function pullBlackCustomer($data){
        if($data){
            $row = $this->where('id',$data['id'])->update($data);
            if($row != false){
                $return['code'] = 1;
                $return['msg'] = '此客户已成功加入黑名单';
            } else {
                $return['code'] = 0;
                $return['msg'] = '此客户加入黑名单失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg'] = '无法将此客户加入黑名单';
        }

        return $return;
    }

    /**
     * 后台手动替客户重置密码
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function resetPassword($password){
        if($password){
            $reset['password'] = Hash::make($password['password']);
            $row = $this->where('id',$password['id'])->update($reset);
            if($row != false){
                $return['code'] = 1;
                $return['msg'] = '密码重置成功，密码为用户名'.$password['password'];
            } else {
                $return['code'] = 0;
                $return['msg'] = '密码重置失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg'] = '密码无法重置';
        }
        return $return;
    }

    public function rechargeByAdmin($data){
        $clerk_id = Admin::user()->id;
        $cus = $this->find($data['user_id']);
        $yewuyuan_id = $cus->salesman_id;
        $return = [
        	'data'  => '',
	'msg'   => '',
	'code'  => 0,
        ];

        if($clerk_id != $yewuyuan_id){
        	$return['msg'] = '此客户不属于您';
        	return $return;
        }

        $data['recharge_way']       	= 3;
        $data['trade_no']               	= 'tz_'.time().'_'.$data['user_id'];
        $data['money_before']      	= $cus->money;
        $data['money_after']      	= bcadd($data['money_before'],$data['recharge_amount'],2);
        $data['trade_status']	= 1;
        $data['subject']		= '充值余额';
        $data['month']		= date("Ym");
        $data['timestamp']		= date("Y-m-d H:i:s");
        $data['salesman_id']	= $clerk_id;
        $data['created_at']		= $data['timestamp'];
        //开始事务
        DB::beginTransaction();
        $cus->money = $data['money_after'];
        $update = $cus->save();
        if($update != true){
        	DB::rollBack();
        	$return['msg'] = '更新余额失败';
        	return $return;
        }

        $res = DB::table('tz_recharge_flow')->insert($data);

        if($res != true){
        	DB::rollBack();
        	$return['msg'] = '充值流水记录创建失败';
        	return $return;
        }

        DB::commit();
        $return['msg'] = '充值成功!';
        $return['code'] = 1;
        return $return;
    }

    public function getRechargeFlow($way,$key = ''){   
        switch ($way) {
             case 'my_all':
                  $clerk_id = Admin::user()->id;
                  $flow = $this
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->where('tz_users.salesman_id',$clerk_id)
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

             case 'customer_id':
                  $flow = $this
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->where('tz_users.id',$key)
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

            case '*':
                  $flow = $this
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

            case 'byMonth':
                  $flow = $this
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

    /**
     * 转移业务员时选择业务员
     * @return [type] [description]
     */
    public function selectClerk($depart){
        $clerk = DB::table('oa_staff')
                    ->join('admin_users','oa_staff.admin_users_id','=','admin_users.id')
                    ->join('tz_jobs','oa_staff.job','=','tz_jobs.id')
                    ->where(['oa_staff.department'=>$depart['depart_id']])
                    ->whereIn('tz_jobs.slug',[2,3])
                    ->select('admin_users.id','admin_users.name')
                    ->get();
        if(empty($clerk)){
            $return['data'] = [];
            $return['code'] = 0;
            $return['msg'] = '无法获取业务员相关信息';
        } else {
            $return['data'] = $clerk;
            $return['code'] = 1;
            $return['msg'] = '获取业务员相关信息成功';
        }
        return $return;
    }

    /**
     * 转移客户
     * @param  [type] $edit_param [description]
     * @return [type]             [description]
     */
    public function editClerk($edit_param){
        if(!$edit_param){
            $return['code'] = 0;
            $return['msg'] = '无法转移客户';
            return $return;
        }
        $users = $this->find($edit_param['customer_id']);
        if(empty($users)){
            $return['code'] = 0;
            $return['msg'] = '无对应客户';
            return $return;
        }
        $clerk = DB::table('oa_staff')
                    ->join('admin_users','oa_staff.admin_users_id','=','admin_users.id')
                    ->where(['oa_staff.admin_users_id'=>$edit_param['clerk_id'],'oa_staff.dimission'=>0])
                    ->select('admin_users.name')
                    ->first();
        if(empty($clerk)){
            $return['code'] = 0;
            $return['msg'] = '该业务员不存在或已离职';
            return $return;
        }
        $row = $this->where(['id'=>$edit_param['customer_id']])->update(['salesman_id'=>$edit_param['clerk_id']]);
        if($row != false){
            $return['code'] = 1;
            $return['msg'] = '客户已转到'.$clerk->name.'名下';
        } else {
            $return['code'] = 0;
            $return['msg'] = '该客户转移失败';
        }
        return $return;
    }

    /**
     * 绑定业务员
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    public function insertClerk($email){
        if(!$email){
            $return['code'] = 0;
            $return['msg'] = '无法绑定客户';
            return $return;
        }
        $customer = $this->where(['email'=>$email['email']])->select('id','name','salesman_id','email','status')->first();
        if(empty($customer)){//客户不存在
            $return['code'] = 0;
            $return['msg'] = '此客户不存在,请确认客户注册邮箱正确,或与客户联系核实!';
            return $return;
        }
        if($customer->salesman_id){//客户已绑定过业务员
            $return['code'] = 0;
            $return['msg'] = '此客户已绑定业务员,请与客户确认';
            return $return;
        }
        if($customer->status == 0){//客户已被加入黑名单
            $return['code'] = 0;
            $return['msg'] = '此客户已经被加入黑名单,请与管理员确认';
            return $return;
        }
        $update = $this->where(['email'=>$email['email']])->update(['salesman_id'=>Admin::user()->id]);
        if($update != false){
            $return['code'] = 1;
            $return['msg'] = '客户:'.$customer->name.'(邮箱:'.$customer->email.')'.'已绑定到你名下';
        } else {
            $return['code'] = 0;
            $return['msg'] = '客户绑定失败';
        }
        return $return;
    }
}
