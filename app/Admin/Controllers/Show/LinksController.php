<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\LinksModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class LinksController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('友情链接');
            $content->description('友情链接管理');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('友情链接');
            $content->description('友情链接详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('友情链接');
            $content->description('友情链接添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('友情链接');
            $content->description('友情链接编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(LinksModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->name('名称');
                $show->url('地址');
                $show->type("类型")->using([
                    1 => '友情链接',
                    2 => '热门搜索',
                    3 => '热门产品'
                ]);
                $show->description("描述");
                // $show->image()->image();
                $show->links_order("排序");
        });
    }
    protected function grid()
    {
        return Admin::grid(LinksModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('name','名称');
            $grid->column('url','网址');
            $grid->column('type','类型')->display(function () {
                $types = [
                    1 => '友情链接',
                    2 => '热门搜索',
                    3 => '热门产品'
                ];
                return $types[$this->type];
            });
            $grid->column('links_order','排序');
            $grid->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->like('name', '名称');
                $filter->equal('type')->radio([
                    1 => '友情链接',
                    2 => '热门搜索',
                    3 => '热门产品'
                ]);

            });
        });
    }
    protected function form()
    {
        return Admin::form(LinksModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '名称');
            $form->text('url', '网址');
            $types = [
                1 => '友情链接',
                2 => '热门搜索',
                3 => '热门产品'
            ];
            $form->select('type', '类型')->options($types);
            // $form->image("image","图片")->move('public/images/');
            $form->textarea('description', '描述');
            $form->number('links_order', '排序');
        });
    }
}
