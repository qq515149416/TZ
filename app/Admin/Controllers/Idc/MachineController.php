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

    /**
     * 查找架上机器
     * @return [type] [description]
     */
    public function showRentMachine(){
    	$showrentmachine = new MachineModel();
    	$return = $showrentmachine->showRentMachine();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

}
