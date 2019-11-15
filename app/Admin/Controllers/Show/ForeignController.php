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
                $show->cpu("CPU");
                $show->type("型号");
                $show->thread("线程");
                $show->ram("内存");
                $show->hard_disk_type("硬盘类型");
                $show->hard_disk_size("硬盘大小");
                $show->upgrade("是否支持硬件升级")->using(['0' => '不支持', '1' => '支持']);
                $show->is_enhance("增强服务器")->using(['0' => '不是', '1' => '是']);
                $show->raid_card("RAID卡");
                $show->ips("IP数量");
                $show->ddos("DDOS");
                $show->bandwidth("月付")->label();
                $show->price("价格");
                $show->unit("单位");
                $show->status("状态")->using([
                    1 => '正常',
                    0 => '隐藏'
                ]);
                // $show->more("增强配置")->json();
                $show->more("详细信息")->unescape()->as(function ($content) use ($show) {
                    // $content = json_decode($content, true);
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
            $grid->column('upgrade','硬件升级')->display(function ($released) {
                return $released ? '支持' : '不支持';
            });
            $grid->column('is_enhance','增强服务器')->display(function ($released) {
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
            $form->text('cpu', 'CPU')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->text('type', '型号')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->text('thread', '线程')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->text('ram', '内存')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->text('hard_disk_type', '硬盘类型')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->text('hard_disk_size', '硬盘大小')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->switch('upgrade', '硬件升级')->states([
                'on'  => ['value' => 1, 'text' => '支持', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '不支持', 'color' => 'danger'],
            ]);
            $form->switch('is_enhance', '增强服务器')->states([
                'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
            ]);
            $form->text('raid_card', 'RAID卡')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->number('ips', 'IP数量')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->text('ddos', 'DDOS')->help('如果需要在页面中换行显示请使用\进行换行');
            $form->tags('bandwidth','带宽');
            $form->currency('price', '价格')->symbol('￥');
            $form->text('unit', '单位');
            $form->embeds("more","增强配置",function ($form) {
                $form->text('platform',"平台");
                $form->text('network_card',"网卡");
                $form->currency('original_price',"原价");
                $form->number('discount',"几折");
            });
            $form->switch('status', '状态')->value(1)->rules('required');
            $form->select("nav_id","所属导航")->options('/tz_admin/show/api/machine_info/select/nav');
            $form->select('machine_room_id',"所属机房")->options('/tz_admin/show/api/machine_info/select/machine_room');

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
