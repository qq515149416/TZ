<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\Business\BusinessModel;
use XS;
use XSDocument;

/**
 * 所有客户信息
 */
class CustomerModel extends Model
{

    protected $table = 'tz_users';
    public $timestamps = true;
    protected $fillable = ['name','nickname','password','password_confirmation','msg_qq','msg_phone','remarks','pwd_ver','salesman_id','status'];

	/**
	 * 管理人员查看客户信息
	 * @return array 返回客户信息和状态提示及信息
	 */
    public function adminCustomer($id){
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
        
        if($slug->slug != 3){//非业务员进入此区间
            // dd(Admin::user()->role);
            if(Admin::user()->inRoles(['salesman','operations','finance','HR','product','network_dimension','net_sec'])){//不是主管的按是否自己客户查看
                $where['salesman_id'] = $clerk_id;
            } else  {//主管人员查看客户信息
                $where = [];
            }
            if(Admin::user()->inRoles(['CMO'])){
                $where = [];
            }
            
        } else {//是业务人员按客户所绑定业务员查看
            $where['salesman_id'] = $clerk_id;
            // if(Admin::user()->inRoles(['AE'])){
            //     $where = [];
            // }
            
        }
        if(!empty($id)){
            $where['id'] = $id;
        }
    	$admin_customer = $this
                ->orderBy('created_at','desc')
                ->where($where)
                ->get(['id','status','name','email','money','salesman_id','created_at','updated_at','nickname','msg_qq','msg_phone','remarks']);

                for ($i=0; $i < count($admin_customer); $i++) { 
                    $admin_customer[$i] = $this->checkBusiness($admin_customer[$i]);
                }

    	if(!$admin_customer->isEmpty()){
    		$status = [0=>'拉黑',1=>'未验证',2=>'正常'];
    		foreach($admin_customer as $key=>$value){
    			$admin_customer[$key]['status'] = $status[$value['status']];
                $admin_customer[$key]['email'] = $value['email']?$value['email']:$value['name'];
                if($value['salesman_id'] !=0 || $value['salesman_id'] != Null){
                    $admin_customer[$key]['clerk_name'] = $this->clerk($value['salesman_id']);
                } else {
                    $admin_customer[$key]['clerk_name'] = '未绑定业务员';
                }
    			
                // $admin_customer[$key]['money'] = (float)$value['money'];
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

    public function checkBusiness($customer){
        $b_model = new BusinessModel();
        $count_b = $b_model
            ->where('client_id',$customer->id)
            ->whereIn('business_status',[1,2])
            ->whereBetween('remove_status',[0,3])
            ->count('id');
        if($count_b == 0){
            $count_b = DB::table('tz_defenseip_business')
                                ->where('user_id',$customer->id)
                                ->whereIn('status',[1,2,4])
                                ->count('id');
        }
        $customer->haveBusiness = $count_b;
        return $customer;
    }
    /**
     * 查找业务员姓名
     * @param  int $id oa_staff表的admin_users_id字段的值
     * @return string     返回对应业务员的姓名
     */
    public function clerk($id){
    	$clerk = DB::table('admin_users')->where(['id'=>$id])->value('name');
        if(empty($clerk)){
            $clerk = '业务员不存在';
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
                switch ($data['status']) {
                    case 0:
                        $return['msg'] = '此客户已成功加入黑名单';
                        break;
                    case 1:
                        $return['msg'] = '此客户状态已修改为未验证状态';
                        break;
                    case 2:
                        $return['msg'] = '此客户已恢复正常';
                        break;
                }
                
            } else {
                $return['code'] = 0;
                $return['msg'] = '此客户账户状态修改失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg'] = '此客户账户状态无法修改';
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
                  $flow = $this
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->where('tz_users.salesman_id',$clerk_id)
                        ->whereNull('deleted_at')
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

             case 'customer_id':
                  $flow = $this
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->where('tz_users.id',$key)
                        ->whereNull('deleted_at')
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

            case '*':
                  $flow = $this
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->whereNull('deleted_at')
                        ->orderBy('b.timestamp','desc')
                        ->get();    
                 break;

            case 'byMonth':
                  $flow = $this
                        ->leftjoin('tz_recharge_flow as b','tz_users.id','=','b.user_id')
                        ->select(DB::raw('tz_users.id as customer_id,tz_users.name as customer_name,tz_users.email,b.id as flow_id,b.recharge_amount,b.recharge_way,b.trade_no,b.voucher,b.timestamp,b.money_before,b.money_after,b.salesman_id'))
                        ->where('b.trade_status',1)
                        ->where('b.month',$key)
                        ->whereNull('deleted_at')
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
                    // ->whereIn('tz_jobs.slug',[2,3])
                    ->select('admin_users.id','admin_users.name')
                    ->distinct()
                    ->get();
        if($clerk->isEmpty()){
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
        if(!isset($email['email'])){
            $return['code'] = 0;
            $return['msg'] = '无法绑定客户';
            return $return;
        }
        $customer = $this->where(['email'=>$email['email']])->orWhere(['name'=>$email['email']])->orWhere(['nickname'=>$email['email']])->select('id','name','salesman_id','email','status')->first();
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

        // $userExists = $this->where('name', '=', $email['email'])->exists();//判断是否存在对应的用户名帐号
        if ($this->where('name', '=', $email['email'])->exists()) {//如果存在则根据用户名进行业务员绑定
            $update = $this->where(['name'=>$email['email']])->update(['salesman_id'=>Admin::user()->id]);
        } elseif($this->where('nickname', '=', $email['email'])->exists()) {//如果不存在则根据输入的邮箱进行绑定
           $update = $this->where(['nickname'=>$email['email']])->update(['salesman_id'=>Admin::user()->id]);
        } else {
            $update = $this->where(['email'=>$email['email']])->update(['salesman_id'=>Admin::user()->id]);
        }
        if($update != false){
            $return['code'] = 1;
            $return['msg'] = '客户:'.$customer->name.'(邮箱:'.$customer->email.')'.'已绑定到你名下';
        } else {
            $return['code'] = 0;
            $return['msg'] = '客户绑定失败';
        }
        return $return;
    }

    /**
     * 后台注册客户
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function registerClerk($data){
        unset($data['password_confirmation']);
        $data['pwd_ver'] = 1;
        $data['salesman_id'] = Admin::user()->id;
        $data['status'] = 2;
        $data['password'] = Hash::make($data['password']);
        $row = $this->create($data);
        if($row != false){
            /**
             * 将先注册的账户相关信息放入索引文件
             * @var XS
             */
            $xunsearch    = new XS('customer');
            $index        = $xunsearch->index;
            $doc['id']    = strtolower($row['id']);
            $doc['name'] = strtolower($data['name']);
            $doc['nickname'] = strtolower($data['nickname']);
            $document     = new \XSDocument($doc);
            $index->update($document);
            $index->flushIndex();
            $return['code'] = 1;
            $return['msg'] = '客户信息注册成功';
        } else {
            $return['code'] = 1;
            $return['msg'] = '客户信息注册失败';
        }
        return $return;

    }
}
