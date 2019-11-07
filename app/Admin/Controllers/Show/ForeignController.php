<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\News\MachineRoomModel;
use App\Admin\Models\News\ForeignModel;
use App\Admin\Models\News\NavModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;

class ForeignController extends Controller
{
    use ModelForm;
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('海外机器管理');
            $content->description('海外机器列表');
            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('海外机器管理');
            $content->description('海外机器详细');

            $content->body($this->detail($id));
        });
    }
    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {

            $content->header('海外机器管理');
            $content->description('海外机器添加');

            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('海外机器管理');
            $content->description('海外机器编辑');
            $content->body($this->form()->edit($id));
        });
    }
    protected function detail($id)
    {
        return Admin::show(ForeignModel::findOrFail($id), function (Show $show) {

                $show->id('ID');
                $show->machine_room_id("所属机房")->as(function ($machine_room) {
                    return $machine_room['name'];
                });
                $show->nav_id("所属导航")->as(function ($nav) {
                    return $nav['name'];
                });
                // $show->ram("内存");
                // $show->hardDisk("硬盘");
                // $show->bandwidth("带宽");
                // $show->defense("防御");
                // $show->line("线路");
                // $show->format("规格");
                // $show->ip("IP");
                // $show->annualFee("年付");
                // $show->monthlyPay("月付");
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
        return Admin::grid(ForeignModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->machine_room_id('所属机房')->display(function($machine_room) {
                return $machine_room['name'];
            });
            $grid->nav_id('所属导航')->display(function($nav) {
                return $nav['name'];
            });
            $grid->column('cpu','CPU');
            $grid->column('type','型号');
            $grid->column('thread','线程');
            $grid->column('ram','内存');
            $grid->column('hard_disk_type','硬盘类型');
            $grid->column('hard_disk_size','硬盘大小');
            $grid->column('upgrade','支持升级?')->display(function ($released) {
                return $released ? '是' : '否';
            });
            $grid->column('raid_card','RAID卡');
            $grid->column('ips','IP数量');
            $grid->column('ddos','DDOS');
            $grid->column('price','价格');
            $grid->column('unit','单位');
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
                $filter->like('cpu', 'CPU');
                $filter->like('type', '型号');
                $filter->like('thread', '线程');
                $filter->like('ram', '内存');
                $filter->like('hard_disk_type', '硬盘类型');
                $filter->like('hard_disk_size', '硬盘大小');
                $filter->like('price', '价格');
            });
        });
    }
    protected function form()
    {
        return Admin::form(ForeignModel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('cpu', 'CPU')->help('如果需要在页面中换行显示请使用/进行换行');
            $form->text('type', '型号')->help('如果需要在页面中换行显示请使用/进行换行');
            $form->text('thread', '线程')->help('如果需要在页面中换行显示请使用/进行换行');
            $form->text('ram', '内存')->help('如果需要在页面中换行显示请使用/进行换行');
            $form->text('hard_disk_type', '硬盘类型')->help('如果需要在页面中换行显示请使用/进行换行');
            $form->text('hard_disk_size', '硬盘大小')->help('如果需要在页面中换行显示请使用/进行换行');
            $form->switch('upgrade', '是否支持硬件升级')->states([
                'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ]);
            $form->text('raid_card', 'RAID卡')->help('如果需要在页面中换行显示请使用/进行换行');
            $form->number('ips', 'IP数量')->help('如果需要在页面中换行显示请使用/进行换行');
            $form->text('ddos', 'DDOS')->help('如果需要在页面中换行显示请使用/进行换行');

            $form->currency('price', '价格')->symbol('￥');
            $form->text('unit', '单位');
            $form->switch('status', '状态')->value(1)->rules('required');
            $form->select('machine_room_id',"所属机房")->options('/tz_admin/show/api/machine_info/select/machine_room');
            $form->select("nav_id","所属导航")->options('/tz_admin/show/api/machine_info/select/nav');
            // $form->embeds('bandwidth','带宽',function ($table) {
            //     $table->text('key');
            //     $table->text('value');
            //     $table->text('desc');
            // });
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
