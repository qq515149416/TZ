<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\CustomerModel;
use App\Admin\Models\Hr\DepartmentModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\CustomerRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * 客户信息
 */
class CustomerController extends Controller
{
    use ModelForm;

    /**
     * 管理员查看客户信息接口
     * @return json 返回相关的数据信息及状态提示及信息
     */
    public function adminCustomer(Request $request) {
        $id = $request->only('id'); 
        $admin = new CustomerModel();
        $admin_customer = $admin->adminCustomer($id);
        return tz_ajax_echo($admin_customer['data'],$admin_customer['msg'],$admin_customer['code']);
    }


    /**
     * 后台手动将客户拉入黑名单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function pullBlackCustomer(Request $request){
        $status = $request->only(['status','id']);
        $black = new CustomerModel();
        $pull = $black->pullBlackCustomer($status);
       return tz_ajax_echo($pull,$pull['msg'],$pull['code']);     
    }

    /**
     * 后台手动替客户重置密码
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resetPassword(Request $request){
        $password = $request->only(['password','id']);
        $reset = new CustomerModel();
        $reset_password = $reset->resetPassword($password);
        return tz_ajax_echo($reset_password,$reset_password['msg'],$reset_password['code']);
    }

    /**
     * 转移业务员时选择部门
     * @return [type] [description]
     */
    public function depart(Request $request){
        $param = $request->only(['transfer']);
        $clerk = new DepartmentModel();
        $clerk_result = $clerk->showDepart($param);
        return tz_ajax_echo($clerk_result['data'],$clerk_result['msg'],$clerk_result['code']);
    }

     /**
     * 转移业务员时选择业务员
     * @return [type] [description]
     */
    public function selectClerk(Request $request){
        $depart_id = $request->only(['depart_id']);
        $clerk = new CustomerModel();
        $clerk_result = $clerk->selectClerk($depart_id);
        return tz_ajax_echo($clerk_result['data'],$clerk_result['msg'],$clerk_result['code']);
    }

    /**
     * 修改客户所绑定的业务员
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editClerk(Request $request){
        $clerk_id = $request->only(['clerk_id','customer_id']);
        $edit = new CustomerModel();
        $edit_result = $edit->editClerk($clerk_id);
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }

    /**
     * 绑定业务员(业务员直接输入客户提供的Email)
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertClerk(CustomerRequest $request){
        $customer = $request->only(['email']);
        $insert = new CustomerModel();
        $insert_result = $insert->insertClerk($customer);
        return tz_ajax_echo($insert_result,$insert_result['msg'],$insert_result['code']); 
    }

    /**
     * 后台注册客户
     * @param  CustomerRequest $request 'name'--用户名,'nickname'--昵称,'password'--密码,'password_confirmation'--确认密码,'msg_qq'--客户QQ,'msg_phone'--客户手机,'remarks'--备注
     * @return [type]                   [description]
     */
    public function registerClerk(CustomerRequest $request){
        $register_info = $request->only(['name','nickname','password','password_confirmation','msg_qq','msg_phone','remarks']);
        $register = new CustomerModel();
        $result = $register->registerClerk($register_info);
        return tz_ajax_echo($result,$result['msg'],$result['code']);
    }

    /**
     * 手动消费
     * @param  Request $request 'business_number'--手动消费的业务,'flow_type'--手动消费的类型,'note'--类型备注,'money'--金额,'pay_time'--支付时间
     * @return [type]           [description]
     */
    public function manualPay(Request $request){
        $manual = $request->only('business_number','note','money','pay_time');

        /**
         * 检验手动消费的相关字段是否填写
         * @var [type]
         */
        $rules = ['business_number'=>'required','note'=>'required','money'=>'required'];
        $messages = ['business_number.required'=>'手动消费的业务必须选择','note.required'=>'手动消费备注必须填写','money.required'=>'手动消费金额必须填写'];
        $validator = Validator::make($manual,$rules,$messages);
        if($validator->messages()->first()){
            return tz_ajax_echo('',$validator->messages()->first(),0);
        }

        if(isset($manual['pay_time'])){
            $pay_time = $manual['pay_time'];
        } else {
            $pay_time = date('Y-m-d H:i:s',time());
        }

        $serial_number = 'tz_'.time().'_admin_'.Admin::user()->id;

        $order = DB::table('tz_orders')->where(['business_sn'=>$manual['business_number']])
                      ->whereBetween('resource_type',[1,3]);
                      ->whereNull('deleted_at')
                      ->select('id','customer_id')
                      ->first();

        $order_id = $order->id;
        $customer_id = $order->customer_id;

        $before_money = DB::table('tz_users')->where(['id'=>$customer_id])->value('money');

        if($before_money < $manual['money']){
            return tz_ajax_echo('','余额不足,无法支付',0);
        }

        $after_money = bcsub($before_money,$manual['money'],2);

        $detail = DB::table('tz_business')->where(['business_number'=>$manual['business_number']])->select('resource_detail')->first();
        $room_id = json_encode($detail)->machineroom_id;

        DB::beginTransaction();
        $user = DB::table('tz_users')->where(['id'=>$customer_id])->update(['money'=>$after_money,'updated_at'=>$pay_time]);

        if($user == 0){
            DB::rollBack();
            return tz_ajax_echo('','手动消费失败',0);
        }
        
        $flow = [
                    'business_number'=>$manual['business_number'],
                    'serial_number'=>$serial_number,
                    'order_id' => $order_id,
                    'customer_id' => $customer_id,
                    'business_id' => Admin::user()->id;
                    'payable_money' => $manual['money'];
                    'actual_payment' => $manual['money'];
                    'preferential_amount' => 0;
                    'pay_time' => $pay_time;
                    'before_money' =>$before_money;
                    'after_money' => $after_money;
                    'flow_type' => 3,
                    'room_id' => $room_id,
                    'note' => $manual['note'];
                    'created_at' => date('Y-m-d H:i:s',time());
                    'updated_at' => date('Y-m-d H:i:s',time());
                ];

        $row = DB::table('tz_orders_flow')->insertGetId($flow);

        if($row != 0){
            DB::commit();
            return tz_ajax_echo('','业务:'.$manual['business_number'].'的增值消费成功',1);
        } else {
            DB::rollBack();
            return tz_ajax_echo('','业务:'.$manual['business_number'].'的增值消费失败',0);
        }

    }



}
