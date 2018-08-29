<?php

namespace App\Admin\Controllers\Work;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Work\WhiteListModel;
use App\Admin\Requests\Work\WhiteListRequest;
use Illuminate\Http\Request;

/**
 * 白(黑)名单
 */
class WhiteListController extends Controller
{
    use ModelForm;

    /**
     * 根据对应白名单状态进行信息查询
     * @param  Request $request [description]
     * @return json           返回相关的数据和状态信息
     */
    public function showWhiteList(Request $request){
    	if($request->isMethod('get')){
    		$where = $request->only(['white_status']);
    		$showwhitelist = new WhiteListModel();
    		$return = $showwhitelist->showWhiteList($where);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'获取白名单信息数据失败!!!',0);
    	}
    }

    /**
     * 白名单信息的提交
     * @param  Request $request [description]
     * @return json           返回相关的数据和状态信息
     */
    public function insertWhiteList(Request $request){
    	if($request->isMethod('post')){
    		$insertdata = $request->only(['white_ip','domain_name','record_number','submit_note']);
    		$insert = new WhiteListModel();
    		$return = $insert->insertWhiteList($insertdata);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'白名单信息无法提交',0);
    	}
    }

    /**
     * 对白名单进行审核
     * @param  Request $request [description]
     * @return json           返回相关的数据和状态信息
     */
    public function checkWhiteList(Request $request){
    	if($request->isMethod('post')){
    		$checkdata = $request->only(['white_status','check_note']);
    		$check = new WhiteListModel();
    		$return = $check->checkWhiteList($checkdata);
    		return tz_ajax_echo($return,$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'白名单信息无法进行审核',0);
    	}
    }

    /**
     * 删除对应的白名单信息
     * @param  Request $request [description]
     * @return json           相关的信息提示和状态返回
     */
    public function deleteWhitelist(Request $request){
        if($request->isMethod('post')){
            $id = $request->get('delete_id');
            $delete = new WhiteListModel();
            $result = $delete->deleteWhitelist($id);
            return tz_ajax_echo($result,$result['msg'],$result['code']);
        } else {
            return tz_ajax_echo([],'无法对数据进行删除操作',0);
        }
    }
}
