<?php

// +----------------------------------------------------------------------
// | Author: 街"角．回 忆 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 处理IP的控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:20:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\Idc;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\Ips;
use App\Admin\Requests\IpsRequest;
use App\Admin\Requests\IpsBatchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IpsController extends Controller
{
    use ModelForm;
    // 测试
    public function test(){
    	$test = new Ips();
    	$rtest = $test->test();
    	return $rtest;
    }

    /**
     * 查找IP表的相关信息
     * @return json 返回相关的信息
     */
    public function index(){
    	$index = new Ips();
    	$ips = $index->index();
    	// dd($ips['data']);
    	return tz_ajax_echo($ips['data'],$ips['msg'],$ips['code']);
    }
    /**
     * 新增IP地址的信息
     * @param  IpsRequest $request 进行字段验证
     * @return json             将相关的信息进行返回前台
     */
    public function insert(IpsRequest $request){
    	// 判断传递的方式和提交方式
    	if($request->isMethod('post')) {
    		// 符合提交方式的进行数据的提取
    		$param = $request->only(['ip_start','ip_end','vlan','ip_company','ip_status','ip_lock','ip_note','ip_comproom']);
    		$create = new Ips();
    		// 传递数据到对应的model层处理
    		$revert = $create->insert($param);
    		// 返回信息
    		return tz_ajax_echo($revert['data'],$revert['msg'],$revert['code']);
    	} else {
    		// 不符合方式的
    		return tz_ajax_echo([],'新增IP地址失败!!',0);
    	}
    }

    /**
     * 查找要修改的数据
     * @param  Request $request 接收传递的参数
     * @return json           返回相关的数据或提示信息
     */
    public function edit(Request $request){
    	if($request->isMethod('get')){
    		$id = $request->get('ip_id');
    		if($id+0){
    			$edit = new Ips();
    			$result = $edit->edit($id+0);
    			return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    		} else {
    			return tz_ajax_echo([],'请确认操作无误！！',0);
    		}
    		
    	} else {
    		return tz_ajax_echo([],'获取IP信息失败！！',0);
    	}
    }

    /**
     * 修改IP地址的相关信息
     * @param  IpsRequest $request 进行字段验证
     * @return json             返回相关的信息
     */
    public function doEdit(IpsRequest $request) {
    	//判断提交的方式
    	if($request->isMethod('post')){
    		// 符合判断的进行数据提取
    		$data = $request->only(['id','vlan', 'ip','ip_company','ip_status','ip_lock','ip_note','ip_comproom']);
    		$doedit = new Ips();
    		// 模型层处理
    		$result = $doedit->doEdit($data);
    		// 返回信息
    		return tz_ajax_echo($result,$result['msg'],$result['code']);
    	} else {
    		// 不符合条件的返回错误信息
    		return tz_ajax_echo([],'修改IP地址信息失败！！！',0);
    	}
    }

    /**
     * 删除操作
     * @param  Request $request 删除的条件
     * @return json           相关的信息和状态的返回
     */
    public function deleted(Request $request) {
    	if($request->isMethod('post')) {
    		$id = $request->get('delete_id');
    		if($id+0) {
    			$delete = new Ips();
    			$result = $delete->dele($id);
    			return tz_ajax_echo($result,$result['msg'],$result['code']);
    		} else {
    			return tz_ajax_echo([],'删除信息失败',0);
    		}
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
