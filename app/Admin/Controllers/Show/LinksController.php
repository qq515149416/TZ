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
    // public function store(Request $request,Content $content)
    // {
    //     return Admin::content(function (Content $content) use ($request) {
    //         $content->header('友情链接');
    //         $content->description('友情链接添加保存操作');
    //         $form = new Form(new LinksModel);
    //         $result = LinksModel::create($request->all());
    //         if($result) {
    //             // 抛出成功信息
    //             return redirect(url())->route('tz_admin/show/link/edit').$result->id;
    //         } else {
    //             // 抛出成功信息
    //             $form->saving(function ($form) {
    //                 $error = new MessageBag([
    //                     'title'   => '保存结果',
    //                     'message' => '很遗憾保存失败',
    //                 ]);
    //                 return back()->with(compact('error'));
    //             });
    //             $content->body($form);
    //         }
    //     });
    // }
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
                $show->sort()->using([
                    0 => '友情链接',
                    1 => '轮播图链接'
                ]);
                $show->description();
                $show->image()->image();
                $show->links_order();
        });
    }
    protected function grid()
    {
        return Admin::grid(LinksModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('name','名称');
            $grid->column('url','网址');
            $grid->column('sort','分类')->display(function () {
                return $this->sort===0 ? '友情链接' : '轮播图链接';
            });
            $grid->column('links_order','排序');
        });
    }
    protected function form()
    {
        return Admin::form(LinksModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '名称');
            $form->text('url', '网址');
            $sorts = [
                0 => '友情链接',
                1 => '轮播图链接'
            ];
            $form->select('sort', '类型')->options($sorts);
            $form->image("image","图片")->move('public/images/');
            $form->textarea('description', '描述');
            $form->number('links_order', '排序');
        });
    }
}
