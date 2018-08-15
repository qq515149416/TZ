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

namespace App\Admin\Controllers\News;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\News\News;
use App\Admin\Requests\News\NewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NewsController extends Controller
{
	use ModelForm;

	/**
	* 查找文章表的相关信息
	* @return json 返回相关的信息
	*/
	public function index(){
		$index = new News();
		$news = $index->index();
		// dd($ips['data']);
		return tz_ajax_echo($news['data'],$news['msg'],$news['code']);
	}

	/**
	 * 新增文章消息
	 * @param  NewsRequest $request 进行字段验证
	 * @return json             将相关的信息进行返回前台
	 */

	public function insert( NewsRequest $request){
		//验证提交方式
		if($request->isMethod('post')) {
		// 符合提交方式的进行数据的提取
		$article = $request->only(['tid', 'title','content','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest']);       

		$create = new News();
		// 传递数据到对应的model层处理
		$revert = $create->insert($article);
		// 返回信息
		
			return tz_ajax_echo($revert['data'],$revert['msg'],$revert['code']);

		} else {
			// 不符合方式的
			return tz_ajax_echo([],'添加文章失败!!',0);
		}
	}

	/**
	 * 修改文章消息的相关信息
	 * @param  NewsRequest $request 进行字段验证
	 * @return json             返回相关的信息
	 */
	public function edit(NewsRequest $request) {
		//判断提交的方式
		if($request->isMethod('post')){
			// 符合判断的进行数据提取
			$data = $request->only(['id','tid', 'title','content','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest']);
			$edit = new News();
			// 模型层处理
			$result = $edit->edit($data);
			// 返回信息
			return tz_ajax_echo($result,$result['msg'],$result['code']);
		} else {
			// 不符合条件的返回错误信息
			return tz_ajax_echo([],'修改文章信息失败！！！',0);
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
				$delete = new News();
				$result = $delete->dele($id);
				return tz_ajax_echo($result,$result['msg'],$result['code']);
			} else {
				return tz_ajax_echo([],'删除文章失败',0);
			}
		} else {
			return tz_ajax_echo([],'删除文章失败',0);
		}
	}


	 /**
	* 查找文章类型的接口
	* @return json 返回相关的信息
	*/
	public function get_news_type() {
		$newsModel = new News();
		$result = $newsModel->get_news_type();
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}

	public function form()
	{
		echo "<pre>";
		print_r($_COOKIE);
		return view('form');
	}
}
