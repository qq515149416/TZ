<?php


namespace App\Admin\Controllers\Idc;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\Ips;
use App\Admin\Requests\Idc\IpsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class IpsController extends Controller
{
    use ModelForm;
    // 测试
    
    /**
     * 查找IP表的相关信息
     * @return json 返回相关的信息
     */
    public function index(){
    	$index = new Ips();
    	$ips = $index->index();
    	return tz_ajax_echo($ips['data'],$ips['msg'],$ips['code']);
    }
    
    /**
     * 新增IP地址的信息
     * @param  IpsRequest $request 进行字段验证Ips
     * @return json             将相关的信息进行返回前台
     */
    public function insert(Request $request){
    	// 符合提交方式的进行数据的提取
		$param = $request->only(['ip_start','ip_end','vlan','ip_company','ip_status','ip_lock','ip_note','ip_comproom']);
        $create = new Ips();
		// 传递数据到对应的model层处理
		$revert = $create->insertIps($param);
		// 返回信息
		return tz_ajax_echo($revert['data'],$revert['msg'],$revert['code']);
    	
    }

    /**
     * 查找要修改的数据
     * @param  Request $request 接收传递的参数
     * @return json           返回相关的数据或提示信息
     */
    public function edit(Request $request){
    	
		$id = $request->get('ip_id');
		if($id+0){
			$edit = new Ips();
			$result = $edit->edit($id+0);
			return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
		} else {
			return tz_ajax_echo([],'请确认操作无误！！',0);
		}
    		
    	
    }

    /**
     * 修改IP地址的相关信息
     * @param  IpsRequest $request 进行字段验证Ips
     * @return json             返回相关的信息
     */
    public function doEdit(Request $request) {
		// 符合判断的进行数据提取
		$data = $request->only(['id','vlan', 'ip','ip_company','ip_status','ip_lock','ip_note','ip_comproom']);
		$doedit = new Ips();
		// 模型层处理
		$result = $doedit->doEdit($data);
		// 返回信息
		return tz_ajax_echo($result,$result['msg'],$result['code']);
    }

    /**
     * 删除操作
     * @param  Request $request 删除的条件
     * @return json           相关的信息和状态的返回
     */
    public function deleted(Request $request) {
		$id = $request->get('delete_id');
		if($id+0) {
			$delete = new Ips();
			$result = $delete->dele($id);
			return tz_ajax_echo($result,$result['msg'],$result['code']);
		} else {
			return tz_ajax_echo([],'删除信息失败',0);
		}
    }

    /**
     * 查找机房的接口
     * @return json 返回相关的信息
     */
    public function machineroom() {
    	$machineroom = new Ips();
    	$result = $machineroom->machineroom();
    	return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }


}
