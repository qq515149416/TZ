<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\PromotionModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class PromotionController extends Controller
{
	use ModelForm;
	public function index(Content $content)
	{
		return Admin::content(function (Content $content) {

			$content->header('促销活动管理');
			$content->description('促销活动列表');
			$content->body($this->grid());
		});
	}
	public function show($id, Content $content)
	{
		return Admin::content(function (Content $content) use ($id) {

			$content->header('促销活动管理');
			$content->description('促销活动详细');

			$content->body($this->detail($id));
		});
	}
	public function create(Content $content)
	{
		return Admin::content(function (Content $content) {

			$content->header('促销活动管理');
			$content->description('促销活动添加');

			$content->body($this->form());
		});
	}
	public function edit($id)
	{
		return Admin::content(function (Content $content) use ($id) {

			$content->header('促销活动管理');
			$content->description('促销活动编辑');
			$content->body($this->form()->edit($id));
		});
	}
	protected function detail($id)
	{
		return Admin::show(PromotionModel::findOrFail($id), function (Show $show) {

				$show->id('ID');
				$show->title('标题');
				$show->digest('描述');
				$show->link('地址');
			
				$show->top("置顶")->using([
					0 => '否',
					1 => '是'
				]);
				
				$show->img("图片")->image();
				$show->pro_order("排序");
		});
	}
	protected function grid()
	{
		return Admin::grid(PromotionModel::class, function (Grid $grid) {

			$grid->id('ID')->sortable();
			$grid->column('title','标题');
			$grid->column('digest','描述');
			$grid->column('link','地址');
			// $grid->column('img','图片')->display(function () {
				
			// 	return '<img style="width:300px;" src="'.$this->img.'">';
			// });
			$grid->column('img','图片')->image();
			$grid->column('state','状态')->display(function () {
				$now = time();
				if (strtotime($this->start_at) > $now) {
					return '未开始';
				}else{
					if (strtotime($this->end_at) < $now) {
						return '已结束';
					}else{
						return '正在进行';
					}
				}
			});
			$grid->column('start_at','开始时间');
			$grid->column('end_at','结束时间');
			$grid->column('top','是否置顶')->display(function ($top) {
				return $top ? '是' : '否';
			});
			
			$grid->filter(function($filter){
				// 去掉默认的id过滤器
				$filter->disableIdFilter();
				// 在这里添加字段过滤器
				$filter->like('title', '标题');
				$filter->equal('top')->radio([
					0 => '未置顶',
					1 => '置顶'
				]);

			});
		});
	}
	protected function form()
	{
		return Admin::form(PromotionModel::class, function (Form $form) {

			$form->display('id', 'ID');
			$form->text('title', '标题')->rules('required');
			$form->text('link', '地址')->rules('required');
			$form->textarea('digest', '描述');
			$form->image("img","图片")->move('/images/promotion')->rules('required');
			$form->datetimeRange('start_at','end_at', '开始----结束时间')->rules('required');
			$form->switch('top', '是否置顶')->rules('required');
			//$form->number('pro_order', '排序');
		});
	}
}
