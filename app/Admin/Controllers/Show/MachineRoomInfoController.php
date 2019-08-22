<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\MachineRoomModel;
use App\Admin\Models\News\NavModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class MachineRoomInfoController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('机房管理');
            $content->description('机房列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('机房管理');
            $content->description('机房详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('机房管理');
            $content->description('机房添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('机房管理');
            $content->description('机房编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(MachineRoomModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->name('名称');
                $show->alias('别名');
                $show->overview('概况');
                $show->grade("等级");
                $show->detail_url("查看详细");
                $show->customer_representative("典型客户");
                $show->status("状态")->using([
                    1 => '正常',
                    0 => '隐藏'
                ]);
                $show->thumbnails("缩略图")->unescape()->as(function($thumbnails) {
                    $thumbnail = "";
                    foreach($thumbnails as $key=>$val) {
                        $thumbnail .= '<div class="col-xs-6 col-md-3">
                        <a href="#" style="margin-bottom: 0;" class="thumbnail">
                          <img style="width: 171px;height: 180px;" src="/upload/'.$val.'" />
                        </a>
                      </div>';
                    }
                    return '<div class="row">'.$thumbnail.'</div>';
                });
                $show->more("详细信息")->unescape()->as(function ($content) use ($show) {
                    $content = json_decode($content, true);
                    $show->wrapped = false;
                    return '<pre><code>'.preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
                    function($matches) {
                        return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");
                    },
                    json_encode($content, JSON_PRETTY_PRINT)).'</code></pre>';
                });
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
        return Admin::grid(MachineRoomModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('name','名称');
            $grid->column('overview','概况');
            // $grid->column('navs','所属导航')->display(function ($nav) {
            //     dd($nav);
            //     return $nav->name;
            // });
            // $grid->navs("所属导航")->display(function ($navs) {

            //     $navs = array_map(function ($nav) {
            //         return "<span class='label label-success'>{$nav['name']}</span>";
            //     }, $navs);

            //     return join('&nbsp;', $navs);
            // });
            $grid->column('grade','等级');
            $grid->column('detail_url','查看详细');
            $grid->column('customer_representative','典型客户');
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
        return Admin::form(MachineRoomModel::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', '名称');
            $form->text('alias', '别名');
            $form->textarea('overview', '概况');
            $form->text('grade', '等级');
            $form->switch('status', '状态')->default(1)->rules('required');
            $form->text('detail_url', '查看详细');
            $form->text('customer_representative', '典型客户');
            $form->multipleImage("thumbnails","展示图片");
            $form->embeds('more', '附加信息', function ($form) {
                $form->text("area","面积");
                $form->text("total","机柜总数");
                $form->text("bandwidth","带宽");
                $form->text("firewall","防火墙");
                $form->text("power","电力设备");
                $form->text("address","地址");
            });
            // $form->multipleSelect('navs',"所属导航")->options(NavModel::all()->pluck('name', 'id'));
        });
    }
    // public function select()
    // {
    //     $navModel = new NavModel();
    //     $data = $navModel->select("id","name as text")->get()->toArray();
    //     return response()->json($data);
    // }
}
