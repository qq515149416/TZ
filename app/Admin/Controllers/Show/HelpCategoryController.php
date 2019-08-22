<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\HelpCategoryModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class HelpCategoryController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('帮助分类管理');
            $content->description('帮助分类列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('帮助分类管理');
            $content->description('帮助分类详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('帮助分类管理');
            $content->description('帮助分类添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('帮助分类管理');
            $content->description('帮助分类编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(HelpCategoryModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->name('名称');
                $show->seo_title('seo标题');
                $show->seo_keywords("seo关键词");
                $show->seo_description("seo描述");
                $show->status("状态")->using([
                    0 => '隐藏',
                    1 => '显示'
                ]);
                $show->parent_id("父级信息")->json();
        });
    }
    protected function grid()
    {
        return Admin::grid(HelpCategoryModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('parent_id','父级信息')->display(function ($parent_id) {
                if($parent_id) {
                    return $parent_id['name'];
                }
                return "一级分类";
            });
            $grid->column('name','名称');
            $grid->column('status','状态')->display(function ($status) {
                return $status ? '是' : '否';
            });
            $grid->column('seo_title','seo标题');
            $grid->column('seo_keywords','seo关键词');
            $grid->column('seo_description','seo描述');
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
        return Admin::form(HelpCategoryModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('parent_id',"父级")->options('/tz_admin/show/api/help_category/select')->default(0);
            $form->text('name', '名称');
            $form->text('seo_title', 'seo标题');
            $form->text('seo_keywords', 'seo关键词');
            $form->text('seo_description', 'seo描述');
            $form->switch('status', '状态')->value(1);
        });
    }
    public function select()
    {
        $helpCategoryModel = new HelpCategoryModel();
        $data = $helpCategoryModel->where('parent_id', 0)->select("id","name as text")->get()->toArray();
        array_push($data,[
            "text" => "一级导航",
            "id" => 0
        ]);
        return response()->json($data);
    }
}
