<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\RechargeModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\RechargeRequest;

/**
 * 客户信息
 */
class RechargeController extends Controller
{
    use ModelForm;

     /**
     * 后台手动替客户充值余额---创建审核单
     * @param  Request $request [description]
     * @return 
     */
    public function rechargeByAdmin(BusinessRequest $request){
        $data = $request->only(['user_id','recharge_amount','recharge_way','remarks']);
        $model = new RechargeModel();
        $res = $model->rechargeByAdmin($data);
        return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
    }

    /**
     * 后台手动替客户充值余额---显示未审核订单
     * @param  Request $request [description]
     * @return 
     */
    public function showNoAuditRecharge(BusinessRequest $request){
        $model = new RechargeModel();
        $res = $model->rechargeByAdmin($data);
        return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
    }

    // /**
    //  * 后台手动替客户充值余额---进行审核
    //  * @param  Request $request [description]
    //  * @return 
    //  */
    // public function auditRecharge(){
    //     $data = $request->only(['user_id','recharge_amount','recharge_way','remarks']);
    //     $model = new RechargeModel();
    //     $res = $model->rechargeByAdmin($data);
    //     return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
    // }


    /**
     * 后台根据客户id获取对应客户充值单接口
     * @param  Request $request [description]
     * @return 
     */
    public function getRecharge(BusinessRequest $request){
    
        $info = $request->only(['customer_id']);
        if(isset($info['customer_id'])){
            $way = 'customer_id';
            $customer_id = $info['customer_id'];
        }else{
              $way = 'my_all';
              $customer_id = '';
        }
        
        $model = new RechargeModel();
        $res = $model->getRechargeFlow($way,$customer_id);

        return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
    }

    /**
     * 后台获取所有客户充值单接口
     * @param  Request $request [description]
     * @return 
     */
    public function getAllRecharge(BusinessRequest $request){

        $info = $request->only(['month']);
        if(isset($info['month'])){
            $way = 'byMonth';
            $key = $info['month'];
        }else{
            $way = '*';
            $key = '';
        }

        $model = new RechargeModel();
        $res = $model->getRechargeFlow($way,$key);

        return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
    }


}
