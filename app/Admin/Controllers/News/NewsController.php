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
use App\Admin\Models\News\NewsTypeModel;
use App\Admin\Requests\News\NewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;


class NewsController extends Controller
{
	use ModelForm;

	/**
	* 查找文章表的相关信息
	* @return json 返回相关的信息
	*/
	// public function index(){
	// 	$index = new News();
	// 	$news = $index->index();
	// 	// dd($ips['data']);
	// 	return tz_ajax_echo($news['data'],$news['msg'],$news['code']);
	// }

	// /**
	//  * 新增文章消息
	//  * @param  NewsRequest $request 进行字段验证
	//  * @return json             将相关的信息进行返回前台
	//  */

	// public function insert( NewsRequest $request){
	// 	//验证提交方式
	// 	if($request->isMethod('post')) {
	// 	// 符合提交方式的进行数据的提取
	// 	$article = $request->only(['tid', 'title','content','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest','list_order']);       

	// 	$create = new News();
	// 	// 传递数据到对应的model层处理
	// 	$revert = $create->insert($article);
	// 	// 返回信息
		
	// 		return tz_ajax_echo($revert['data'],$revert['msg'],$revert['code']);

	// 	} else {
	// 		// 不符合方式的
	// 		return tz_ajax_echo([],'添加文章失败!!',0);
	// 	}
	// }

	// /**
	//  * 修改文章消息的相关信息
	//  * @param  NewsRequest $request 进行字段验证
	//  * @return json             返回相关的信息
	//  */
	// public function edit(NewsRequest $request) {
	// 	//判断提交的方式
	// 	if($request->isMethod('post')){
	// 		// 符合判断的进行数据提取
	// 		$data = $request->only(['id','tid', 'title','content','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest','list_order']);
	// 		$edit = new News();
	// 		// 模型层处理
	// 		$result = $edit->edit($data);
	// 		// 返回信息
	// 		return tz_ajax_echo($result,$result['msg'],$result['code']);
	// 	} else {
	// 		// 不符合条件的返回错误信息
	// 		return tz_ajax_echo([],'修改文章信息失败！！！',0);
	// 	}
		
	// }


	// /**
	// * 删除操作
	// * @param  Request $request 删除的条件
	// * @return json           相关的信息和状态的返回
	// */
	// public function deleted(Request $request) {
	// 	if($request->isMethod('post')) {
	// 		$id = $request->get('delete_id');
	// 		if($id+0) {
	// 			$delete = new News();
	// 			$result = $delete->dele($id);
	// 			return tz_ajax_echo($result,$result['msg'],$result['code']);
	// 		} else {
	// 			return tz_ajax_echo([],'删除文章失败',0);
	// 		}
	// 	} else {
	// 		return tz_ajax_echo([],'删除文章失败',0);
	// 	}
	// }


	//  /**
	// * 查找文章类型的接口
	// * @return json 返回相关的信息
	// */
	// public function get_news_type() {
	// 	$newsModel = new News();
	// 	$result = $newsModel->get_news_type();
	// 	return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	// }

	// public function form()
	// {
		
	// 	return view('form2');
	// }

	// public function putImages(NewsRequest $request){
	// 	$par = $request->only(['images']);

	// 	if( !is_array($par['images']) ){
	// 		return json_encode(['errno' => 1]);
	// 	}

	// 	$model = new News();
	// 	$res = $model->putImages($par['images']);
	
	// 	return json_encode(['errno' => 0 , 'data' => $res['data']]);
	// }


	public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('文章管理');
            $content->description('文章列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('文章管理');
            $content->description('文章内容');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('文章管理');
            $content->description('文章添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('文章管理');
            $content->description('文章编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(News::findOrFail($id), function (Show $show) {

                $show->title('标题');
                $show->seoDescription('描述');
                $show->content("内容");
               
        });
    }
    protected function grid()
    {
        return Admin::grid(News::class, function (Grid $grid) {
			$grid->model()->orderBy('id','desc');
            $grid->id('序号')->sortable();
            $grid->column('tid','文章分类')->display(function ($tid) {
                return NewsTypeModel::where(['id'=>$tid])->value('name');
            });
            $grid->column('title','标题');
            $grid->column('top_status','置顶显示')->display(function ($top_status) {
                return $top_status ? '置顶' : '不置顶';
			});
			$grid->column('home_status','首页显示')->display(function ($home_status) {
                return $home_status ? '显示' : '不显示';
            });
            
            $grid->column('seoKeywords','SEO关键词');
            $grid->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->like('name', '名称');

            });
        });
    }
    protected function form()
    {
        return Admin::form(News::class, function (Form $form) {

			$form->display('id', '序号');
			$type = NewsTypeModel::get(['id','name']);
			foreach($type as $value){
				$type_array[$value['id']] = $value['name'];
			}
            $form->select('tid',"文章分类")->options($type_array);
			$form->text('title', '标题');
			$form->switch('top_status', '置顶显示')->value(0);
			$form->switch('home_status', '首页显示')->value(0);
			$form->text('seoKeywords', 'seo关键词');
			$form->text('seoTitle', 'seo标题');
			$form->text('seoDescription', 'seo简介');
            $form->text('digest', '消息摘要');
            $form->editor('content','内容');
        });
    }
    
}
