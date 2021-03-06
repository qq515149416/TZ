<?php

namespace App\Admin\Controllers\Work;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Work\WhiteListModel;
use App\Admin\Requests\Work\WhiteListRequest;
use Illuminate\Http\Request;

use Encore\Admin\Facades\Admin;

/**
 * 白(黑)名单
 */
class WhiteListController extends Controller
{
	use ModelForm;

	/**
	 * 根据对应的IP使用状态进行信息查询
	 * @param  $ip 		-需要检测的IP
	 * @return  json           	返回
	 */
	public function checkIP(WhiteListRequest $request)
	{
		$info = $request->only(['ip']);
		$ip = $info['ip'];

		$model = new WhiteListModel();
		$res = $model->checkIP($ip);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	/**
	 * 根据对应白名单状态进行信息查询
	 * @param  	Request 	$white_status
	 * @return  	json          	 返回相关的数据和状态信息
	 */

	public function showWhiteList(WhiteListRequest $request){

			$where = $request->only(['white_status']);
			$showwhitelist = new WhiteListModel();
			$return = $showwhitelist->showWhiteList($where);
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);

	}

	/**
	 * 白名单信息的提交
	 * @param  Request  	white_ip		-IP地址;domain_name	-域名;record_number	-备案编号;;submit_note	-备注;
	 * @return json           返回录入状态
	 */
	public function insertWhiteList(WhiteListRequest $request){

			$insertdata = $request->only(['white_ip','domain_name','record_number','submit_note']);

			$insert = new WhiteListModel();

			$return = $insert->insertWhiteList($insertdata);
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);

	}

	/**
	 * 对白名单进行审核
	 * @param  Request 	white_status	-审核结果;check_note	-备注;id 	-被审核的申请单ID
	 * @return json           	返回审核结果录入状态
	 */
	public function checkWhiteList(WhiteListRequest $request){

			$checkdata = $request->only(['white_status','check_note','id','record_number']);
			$check = new WhiteListModel();
			$return = $check->checkWhiteList($checkdata);
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);

	}

	/**
	 * 对白名单进行批量审核
	 * @param  Request 	white_status	-审核结果;check_note	-备注;id 	-被审核的申请单ID
	 * @return json           	返回审核结果录入状态
	 */
	public function checkWhiteListBatch(WhiteListRequest $request){

			$checkdata = $request->only(['white_status','check_note','id_list']);
			$check = new WhiteListModel();
			$return = $check->checkWhiteListBatch($checkdata);
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);

	}
	/**
	 * 删除对应的白名单信息
	 * @param  Request 	delete_id	-需要删除的申请单ID
	 * @return   json           	返回删除结果
	 */
	public function deleteWhiteList(WhiteListRequest $request){

			$id = $request->only('delete_id');
			$delete = new WhiteListModel();
			$result = $delete->deleteWhiteList($id);
			return tz_ajax_echo([],$result['msg'],$result['code']);

	}



	/**
	 * 域名跳转
	 * domain
	 * http://gd.beian.miit.gov.cn/icp/publish/query/icpMemoInfo_searchExecute.action?siteDomain=
	 */
	public function skipBeian(Request $request)
	{
		$req = $request->all();
		$url = "http://gd.beian.miit.gov.cn/icp/publish/query/icpMemoInfo_searchExecute.action?siteDomain=" . $req['domain'];
		return redirect($url);
	}

	/**
	 * 下载批量添加白名单申请的模板
	 * 
	 */
	public function excelTemplate(Request $request)
	{
		$model = new WhiteListModel();
		$model->excelTemplate();
	}
	

	/**
	* 处理excel批量添加白名单excel
	* @param  
	* @return 
	*/
	public function handleExcel(WhiteListRequest $request){
		$file = $request->file('handle_excel');
		
		
		if($file->getClientOriginalExtension() != 'xlsx'){//判断上传文件的后缀
			return tz_ajax_echo([],'仅支持类型为xlsx的文件',0);
		}
		
		$model = new WhiteListModel();
		$res = $model->handleExcel($file);
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 批量删除白名单接口(不经系统直接调用api,针对没经过系统直接上墙过白的)
	* @param  
	* @return 
	*/
	public function delWhiteBatch(Request $request){
		$par = $request->only( ['site'] );
		$file = $request->file('del_excel');
		
		if($file->getClientOriginalExtension() != 'xlsx'){//判断上传文件的后缀
			return tz_ajax_echo([],'仅支持类型为xlsx的文件',0);
		}

		$model = new WhiteListModel();

		$res = $model->delWhiteBatch($par['site'],$file);
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	public function delForm(){
		return view('defenseipForm');
	}
}
