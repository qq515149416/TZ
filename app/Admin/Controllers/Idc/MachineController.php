<?php

namespace App\Admin\Controllers\Idc;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\MachineModel;
use App\Admin\Requests\Idc\MachineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * 机器的相关操作接口
 */
class MachineController extends Controller
{
    use ModelForm;

    /**
     * 根据传递的条件查找对应的机器
     * @return [type] [description]
     */
    public function showMachine(Request $request){
		$where = $request->only(['business_type']);
    	$showmachine = new MachineModel();
    	$return = $showmachine->showMachine($where);
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	
    	
    }

    /**
     * 新增机器信息
     * @param  MachineRequest $request 字段验证
     * @return json                  将相关的状态和提示信息返回
     */
    public function insertMachine(MachineRequest $request){
    	
		$data = $request->only(['machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','business_type','machine_note']);
		$insertmachine = new MachineModel();
		$return = $insertmachine->insertMachine($data);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 修改机器的信息
     * @param  MachineRequest $request 字段验证
     * @return json                  相关的提示信息和状态返回
     */
    public function editMachine(MachineRequest $request){
		$editdata = $request->only(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','business_type','machine_note']);
		$editmachine = new MachineModel();
		$return = $editmachine->editMachine($editdata);
		return tz_ajax_echo($return,$return['msg'],$return['code']);
    }

    /**
     * 删除对应的机器信息
     * @param  Request $request [description]
     * @return json           相关的信息提示和状态返回
     */
    public function deleteMachine(Request $request){
    		$id = $request->get('delete_id');
    		$deletemachine = new MachineModel();
    		$result = $deletemachine->deleteMachine($id);
    		return tz_ajax_echo($result,$result['msg'],$result['code']);
    }

    /**
     * 查找机房的接口
     * @return json 返回机房的相关的数据
     */
    public function machineroom(){
    	$machineroom = new MachineModel();
    	$result = $machineroom->machineroom();
    	return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 查找对应机房的机柜
     * @param  Request $request 机房的id
     * @return json           对应机房的机柜的数据
     */
    public function cabinets(Request $request){
    	
		$roomid = $request->only(['roomid','business_type']);
		$cabinet = new MachineModel();
		$result = $cabinet->cabinets($roomid);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	
    }

    /**
     * 查找对应机房的IP地址数据
     * @param  Request $request 机房的id和IP所属的运营商
     * @return json           对应机房的IP信息
     */
    public function ips(Request $request){
        
		$data = $request->only(['roomid','ip_company','id']);
		$ips = new MachineModel();
		$result = $ips->ips($data);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	
    }

    /**
     * 下载excel模板
     * @return [type] [description]
     */
    public function excelTemplate(){
        $excel = new MachineModel();
        $excel->excelTemplate();
    }

    /**
     * 处理excel批量添加机器
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function handleExcel(Request $request){
        $file = $request->file('handle_excel');
        if(!$file){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '请上传文件!';
        }
        if($file->getClientOriginalExtension() != 'xlsx'){//判断上传文件的后缀
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '仅支持类型为xlsx的文件!';
        }
        $excel = new MachineModel();
        $return = $excel->handleExcel($file);
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

}
