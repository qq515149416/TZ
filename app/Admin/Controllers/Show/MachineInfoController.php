<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\MachineRoomModel;
use App\Admin\Models\News\RentServerModel;
use App\Admin\Models\News\NavModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class MachineInfoController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('机器规格管理');
            $content->description('机器规格列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('机器规格管理');
            $content->description('机器规格详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('机器规格管理');
            $content->description('机器规格添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('机器规格管理');
            $content->description('机器规格编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(RentServerModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->machine_room_id("所属机房")->as(function ($machine_room) {
                    return $machine_room['name'];
                });
                $show->nav_id("所属导航")->as(function ($nav) {
                    return $nav['name'];
                });
                $show->ram("内存");
                $show->hardDisk("硬盘");
                $show->bandwidth("带宽");
                $show->defense("防御");
                $show->line("线路");
                $show->format("规格");
                $show->ip("IP");
                $show->annualFee("年付");
                $show->monthlyPay("月付");
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
        return Admin::grid(RentServerModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->machine_room_id('所属机房')->display(function($machine_room) {
                return $machine_room['name'];
            });
            $grid->nav_id('所属导航')->display(function($nav) {
                return $nav['name'];
            });
            $grid->column('line','线路');
            $grid->column('format','规格');
            $grid->column('hardDisk','硬盘');
            $grid->column('bandwidth','带宽');
            $grid->column('defense','防御');
            $grid->column('ip','IP');
            $grid->column('annualFee','年付');
            $grid->column('monthlyPay','月付');
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
                $filter->like('line', '线路');
                $filter->like('format', '规格');
                $filter->like('hardDisk', '硬盘');
                $filter->like('bandwidth', '带宽');
                $filter->like('defense', '防御');
                $filter->like('monthlyPay', '月付');
            });
        });
    }
    protected function form()
    {
        return Admin::form(RentServerModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('line', '线路');
            $form->text('format', '规格');
            $form->text('ram', '内存');
            $form->text('hardDisk', '硬盘');
            $form->text('bandwidth', '带宽');
            $form->text('ip', 'IP');
            $form->text('defense', '防御');
            $form->text('annualFee', '年付');
            $form->text('monthlyPay', '月付');
            $form->switch('status', '状态')->value(1)->rules('required');
            $form->select('machine_room_id',"所属机房")->options('/tz_admin/show/api/machine_info/select/machine_room');
            $form->select("nav_id","所属导航")->options('/tz_admin/show/api/machine_info/select/nav');
        });
    }
    public function select($type)
    {
        switch($type) {
            case "machine_room":
                $machineRoomModel = new MachineRoomModel();
                $data = $machineRoomModel->select("id","name as text")->get()->toArray();
                return response()->json($data);
            break;
            case "nav":
                $navModel = new NavModel();
                $data = $navModel->select("id","name as text")->get()->toArray();
                return response()->json($data);
            break;
        }

    }
}
