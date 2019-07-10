<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class HelpContentsController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('帮助管理');
            $content->description('帮助列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('帮助管理');
            $content->description('帮助详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('帮助管理');
            $content->description('帮助添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('帮助管理');
            $content->description('帮助编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(HelpContentsModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->title('标题');
                $show->description('描述');
                $show->content("内容");
                $show->keywords("关键词");
                $show->click("点击次数");
                $show->state("状态")->using([
                    0 => '隐藏',
                    1 => '显示'
                ]);
                $show->category_id("所属分类")->json();
        });
    }
    protected function grid()
    {
        return Admin::grid(HelpContentsModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('category_id','所属分类')->display(function ($category_id) {
                if($category_id) {
                    return $category_id['name'];
                }
                return "无分类";
            });
            $grid->column('title','标题');
            $grid->column('state','状态')->display(function ($state) {
                return $state ? '是' : '否';
            });
            $grid->column('description','描述');
            // $grid->column('content','内容');
            $grid->column('keywords','关键词');
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
        return Admin::form(HelpContentsModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('category_id',"所属分类")->options('/tz_admin/show/api/help_content/select')->default(0);
            $form->text('title', '标题');
            $form->text('description', '描述');
            $form->editor('content','内容');
            $form->tags('keywords', '关键词');
            $form->number('click', '点击次数');
            $form->switch('state', '状态')->value(1);
            $form->saved(function (Form $form) {
                $keywords_arr = explode(",",$form->model()->keywords);
                // dd($keywords_arr);
                foreach($keywords_arr as $key => $val) {
                    if(!HelpTagModel::where([
                        ['name','=',$val],
                        ['content_id','=',$form->model()->id]
                    ])->first()) {
                        HelpTagModel::create([
                            "name" => $val,
                            "content_id" => $form->model()->id
                        ]);
                        // array_push($setAllData,[
                        //     "name" => $val,
                        //     "content_id" => $form->model()->id
                        // ]);
                    }
                }
                // $helpTagModel->push_all_data($setAllData);

            });
        });
    }
    public function select()
    {
        $helpCategoryModel = new HelpCategoryModel();
        $data = $helpCategoryModel->where('parent_id', '<>', 0)->select("id","name as text")->get()->toArray();
        // array_push($data,[
        //     "text" => "一级导航",
        //     "id" => 0
        // ]);
        return response()->json($data);
    }
}
