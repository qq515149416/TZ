<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\RecommendServerModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class RecommendController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('服务器推荐管理');
            $content->description('服务器推荐列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('服务器推荐管理');
            $content->description('服务器推荐详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('服务器推荐管理');
            $content->description('服务器推荐添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('服务器推荐管理');
            $content->description('服务器推荐编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(RecommendServerModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->name('名称');
                $show->cpu('CPU');
                $show->ram("内存");
                $show->hardDisk("硬盘");
                $show->bandwidth("带宽");
                $show->defense("防御");
                $show->price("价格");
                $show->status("状态")->using([
                    1 => '正常',
                    0 => '隐藏'
                ]);
                // $show->nav_id("所属导航")->json();
                // $show->navs("所属导航")->as(function ($navs) {
                //     return $navs->pluck('name');
                // })->label();
                // $show->navs('所属导航', function ($navs) {
                //     // $navs->resource('/admin/comments');
                //     // $navs->id();
                //     $navs->name();
                // });
        });
    }
    protected function grid()
    {
        return Admin::grid(RecommendServerModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('name','名称');
            $grid->column('cpu','CPU');
            $grid->column('ram','内存');
            $grid->column('hardDisk','硬盘');
            $grid->column('bandwidth','带宽');
            $grid->column('defense','防御');
            $grid->column('price','价格');
            $grid->column('status','状态')->display(function () {
                $types = [
                    1 => '正常',
                    0 => '隐藏'
                ];
                return $types[$this->status];
            });
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
        return Admin::form(RecommendServerModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '名称');
            $form->text('cpu', 'CPU');
            $form->text('ram', '内存');
            $form->text('hardDisk', '硬盘');
            $form->text('bandwidth', '带宽');
            $form->text('defense', '防御');
            $form->text('price', '价格');
            $form->switch('status', '状态')->value(1)->rules('required');
        });
    }
}
