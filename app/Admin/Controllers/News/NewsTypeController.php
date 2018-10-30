<?php

namespace App\Admin\Controllers\News;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\News\NewsTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 新闻类型
 */
class NewsTypeController extends Controller
{
    use ModelForm;

    /**
     * 查找新闻类型
     * @return [type] [description]
     */
    public function showNewsType(){
    	$showworktype = new NewsTypeModel();
    	$return = $showworktype->showNewsType();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 新增新闻类型信息
     * @param  Request $request [description]
     * @return json           相关的状态和提示信息返回
     */
    public function insertNewsType(Request $request){
		$insertdata = $request->only(['name','note']);
		$insert = new NewsTypeModel();
		$return = $insert->insertNewsType($insertdata);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 修改新闻类型数据
     * @param  Request $request [description]
     * @return json         相关的状态和提示信息
     */
    public function editNewsType(Request $request){
		$editdata = $request->only(['id','name','note']);
		$edit = new NewsTypeModel();
		$return = $edit->editNewsType($editdata);
		return tz_ajax_echo($return,$return['msg'],$return['code']);
    }

    /**
     * 删除对应的新闻类型信息
     * @param  Request $request [description]
     * @return json           相关的信息提示和状态返回
     */
    public function deleteNewsType(Request $request){
		$id = $request->get('delete_id');
		$delete = new NewsTypeModel();
		$result = $delete->deleteNewsType($id);
		return tz_ajax_echo($result,$result['msg'],$result['code']);
    }
}
