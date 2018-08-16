<?php

namespace App\Admin\Controllers\Idc;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\MachineModel;
use App\Admin\Requests\Idc\MachineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 机器的相关操作接口
 */
class MachineController extends Controller
{
    use ModelForm;
// Rent 租用
    /**
     * 查找业务类型为租用的机器
     * @return [type] [description]
     */
    public function showRentMachine(){
    	$showrentmachine = new MachineModel();
    	$return = $showrentmachine->showRentMachine();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }
// Deposit 托管
    /**
     * 查找业务类型为托管的机器
     * @return [type] [description]
     */
    public function showDepositMachine(){
    	$showdepositmachine = new MachineModel();
    	$return = $showdepositmachine->showDepositMachine();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }
//reserve储备，备用
	/**
     * 查找业务类型为托管的机器
     * @return [type] [description]
     */
    public function showReserveMachine(){
    	$showdepositmachine = new MachineModel();
    	$return = $showdepositmachine->showReserveMachine();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 根据传递的条件查找对应的机器
     * @return [type] [description]
     */
    public function showMachine(Request $request){
    	$where = $request->all();
    	$showmachine = new MachineModel();
    	$return = $showmachine->showMachine($where);
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

}
