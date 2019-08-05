<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\UnderModel;
use App\Admin\Models\Hr\DepartmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 下架控制器
 */
class UnderController extends Controller
{
    use ModelForm;

    /**
     *申请下架接口
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function applyUnder(Request $request){
        $apply = $request->only(['type','business_number','remove_reason','order_sn','parent_business']);
        
        /**
         * 检验下架理由是否填写
         * @var [type]
         */
        $rules = ['remove_reason'=>'required'];
        $messages = ['remove_reason.required'=>'下架理由必须填写'];
        $validator = Validator::make($apply,$rules,$messages);
        if($validator->messages()->first()){
            return tz_ajax_echo('',$validator->messages()->first(),0);
        }

        $apply_for = new UnderModel();
        $apply_result = $apply_for->applyUnder($apply);
        return tz_ajax_echo($apply_result,$apply_result['msg'],$apply_result['code']);
    }

    /**
     * 获取下架的历史记录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function underHistory(Request $request){
        $history = $request->only(['type']);
        $history_for = new UnderModel();
        $history_result = $history_for->underHistory($history);
        return tz_ajax_echo($history_result['data'],$history_result['msg'],$history_result['code']);
    }

    /**
     * 对下架进行操作
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doUnder(Request $request){
        $do_parm = $request->only(['remove_reason','business_number','remove_status','machineroom','order_sn','type','loginname','loginpass','parent_business']);
        $do_for = new UnderModel();
        $do_result = $do_for->doUnder($do_parm);
        return tz_ajax_echo($do_result,$do_result['msg'],$do_result['code']);
    }

    /**
     * 获取申请的下架记录
     * @return [type] [description]
     */
    public function showApplyUnder(){
        $show = new UnderModel();
        $show_result = $show->showApplyUnder();
        return tz_ajax_echo($show_result['data'],$show_result['msg'],$show_result['code']);
    }

    /**
     * 获取转发部门数据
     * @return [type] [description]
     */
    public function department(){
        $where['sign'] = 3;
        $depart = DepartmentModel::where($where)->get(['id','depart_number','depart_name']);
        if($depart->isEmpty()){
            $return['data'] = [];
            $return['code'] = 0;
            $return['msg'] = '暂无部门数据';
        } else {
            $return['data'] = $depart;
            $return['code'] = 1;
            $return['msg'] = '获取部门数据成功';
        }
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 给机器生成随机密码
     * @return [type] [description]
     */
    public function randomCode(){
        // 密码字符集，可任意添加你需要的字符
        $code = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 
        'i', 'j', 'k','m', 'n', 'o', 'p', 'q', 'r', 's', 
        't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D', 
        'E', 'F', 'G', 'H', 'J', 'K', 'L','M', 'N', 'O', 
        'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z', 
        '0', '2', '3', '4', '5', '6', '7', '8', '9', '!', 
        '@','#','%', '^', '&', '*', '(', ')', '<', '>', '+', '=','.');
        //在$code中随机取 $length 个数组元素键名
        $length = mt_rand(4,6);
        $keys = array_rand($code,$length); 
        $random_code = '';
        for($i = 0; $i < $length; $i++)
        {
            //将$length个数组元素连接成字符串
            $password .= $code[$keys[$i]];
        }
        $return['data'] = $password.substr(time(), 8, 2);
        $return['msg'] = '随机密码生成成功';
        return tz_ajax_echo($return['data'],$return['msg'],1);
    }

    public function tranUnder(){
        $tran = new UnderModel();
        $result = $tran->tranUnder();
        return tz_ajax_echo($result['data'],'',1);
    }

}
