<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\NavModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class NavController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('导航管理');
            $content->description('导航列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('导航管理');
            $content->description('导航详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('导航管理');
            $content->description('导航添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('导航管理');
            $content->description('导航编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(NavModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->name('名称');
                $show->url('地址');
                $show->type("类型")->using([
                    1 => '内部链接',
                    2 => '外部链接'
                ]);
                $show->description("描述");
                $show->seo_title("SEO标题");
                $show->seo_keywords("SEO关键词");
                $show->seo_description("SEO描述");
                $show->status("状态")->using([
                    1 => '正常',
                    0 => '隐藏'
                ]);
                $show->parent_id("父级信息")->json();
        });
    }
    protected function grid()
    {
        return Admin::grid(NavModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('name','名称');
            $grid->column('url','网址');
            $grid->column('type','类型')->display(function () {
                $types = [
                    1 => '内部链接',
                    2 => '外部链接'
                ];
                return $types[$this->type];
            });
            $grid->column('parent_id','父级信息')->display(function ($parent_id) {
                if($parent_id) {
                    return $parent_id['name'];
                }
                return "一级导航";
            });
            $grid->column('seo_title','SEO标题');
            $grid->column('seo_keywords','SEO关键词');
            $grid->column('seo_description','SEO描述');
            $grid->column('status','状态')->display(function () {
                $types = [
                    1 => '正常',
                    0 => '隐藏'
                ];
                return $types[$this->type];
            });
            $grid->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->like('name', '名称');
                $filter->equal('type')->radio([
                    1 => '内部链接',
                    2 => '外部链接'
                ]);

            });
        });
    }
    protected function form()
    {
        return Admin::form(NavModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '名称');
            $form->text('url', '网址');
            $types = [
                1 => '内部链接',
                2 => '外部链接'
            ];
            $form->select('type', '类型')->options($types);
            $form->textarea('description', '描述');
            $form->switch('status', '状态')->rules('required');
            $form->text('seo_title', 'SEO标题');
            $form->text('seo_keywords', 'SEO关键词');
            $form->text('seo_description', 'SEO描述');
            $form->select('parent_id',"父级")->options('/tz_admin/show/api/nav/select')->default(0);
        });
    }
    public function select()
    {
        $navModel = new NavModel();
        $data = $navModel->select("id","name as text")->get()->toArray();
        array_push($data,[
            "text" => "一级导航",
            "id" => 0
        ]);
        return response()->json($data);
    }
}
