<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\CarouselModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class CarouselController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('轮播图管理');
            $content->description('轮播图列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('轮播图管理');
            $content->description('轮播图详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('轮播图管理');
            $content->description('轮播图添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('轮播图管理');
            $content->description('轮播图编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(CarouselModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->name('名称');
                $show->url('地址');
                $show->type("类型")->using([
                    1 => '首页'
                ]);
                $show->top("默认显示")->using([
                    0 => '否',
                    1 => '是'
                ]);
                $show->description("描述");
                $show->image_url("图片")->image();
                $show->order("排序");
        });
    }
    protected function grid()
    {
        return Admin::grid(CarouselModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('name','名称');
            $grid->column('url','网址');
            $grid->column('type','类型')->display(function () {
                $types = [
                    1 => '首页'
                ];
                return $types[$this->type];
            });
            $grid->column('top','默认显示')->display(function ($top) {
                return $top ? '是' : '否';
            });
            $grid->column('order','排序');
            $grid->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->like('name', '名称');
                $filter->equal('type')->radio([
                    1 => '首页'
                ]);

            });
        });
    }
    protected function form()
    {
        return Admin::form(CarouselModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '名称');
            $form->text('url', '网址');
            $types = [
                1 => '首页'
            ];
            $form->select('type', '类型')->options($types);
            $form->image("image_url","图片")->move('public/images/');
            $form->textarea('description', '描述');
            $form->switch('top', '是否默认显示')->rules('required');
            $form->number('order', '排序');
        });
    }
}
