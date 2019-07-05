<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\DefenseIp\OverlayModel;
use App\Admin\Models\DefenseIp\OverlayBelongModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
// use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;


class OverlayBelongController extends Controller
{
	// use ModelForm;
	public function index(Content $content)
	{

		// dd('666');
		return Admin::content(function (Content $content) {

			$content->header('已购叠加包管理');
			$content->description('叠加包列表');

			$content->body($this->grid());
		});
	}
	// public function show($id, Content $content)
	// {
	// 	return Admin::content(function (Content $content) use ($id) {

	// 		$content->header('轮播图管理');
	// 		$content->description('轮播图详细');

	// 		$content->body($this->detail($id));
	// 	});
	// }
	// public function create(Content $content)
	// {
	// 	return Admin::content(function (Content $content) {

	// 		$content->header('轮播图管理');
	// 		$content->description('轮播图添加');

	// 		$content->body($this->form());
	// 	});
	// }
	// public function edit($id)
	// {
	// 	return Admin::content(function (Content $content) use ($id) {

	// 		$content->header('轮播图管理');
	// 		$content->description('轮播图编辑');
	// 		$content->body($this->form()->edit($id));
	// 	});
	// }
	// protected function detail($id)
	// {
	// 	return Admin::show(CarouselModel::findOrFail($id), function (Show $show) {

	// 			$show->id('ID');
	// 			$show->customer_name('客户名称');
	// 			$show->overlay_name('套餐名称');
	// 			$show->buy_time('购买时间');
	// 			$show->status("使用状态")->using([
	// 				0 => '未使用',
	// 				1 => '生效中',
	// 				2 => '已使用完毕',
	// 			]);
	// 			$show->use_time('启用时间');
	// 			$show->end_time('结束时间');
	// 			$show->protection_value('防御值');
	// 			$show->validity_period('生效时长/天');
	// 			$show->machine_room_name('机房');
	// 			$show->clerk_name('所属业务员');

	// 			// $show->image_url("图片")->image();

	// 	});
	// }
	protected function grid()
	{

		return Admin::grid(OverlayBelongModel::class, function (Grid $grid) {
			$par = [
				'status'	=> '*',
				'site'	=> '*',
			];
			
			$grid->model()->leftJoin('tz_overlay as b','b.id', '=' , 'tz_overlay_belong.overlay_id')
				->leftJoin('idc_machineroom as c' , 'c.id' , '=' , 'b.site')
				->leftJoin('tz_users as d' , 'd.id' , '=' , 'tz_overlay_belong.user_id')
				->leftJoin('admin_users as e' , 'e.id' , '=' , 'd.salesman_id')
				->when($par['status'] ,function ($query, $role) {
						if ($role != '*') {
							return $query->where('tz_overlay_belong.status',$role);
						}
					},function ($query, $role) {
						if($role==="0") {
							return $query->where('tz_overlay_belong.status',$role);
						}
						return $query;
					})
				->when($par['site'], function ($query, $role) {
							if ($role != '*') {
								return $query->where('c.id',$role);
							}
						})
				->select(['tz_overlay_belong.*','b.name as overlay_name','b.protection_value','b.validity_period','c.machine_room_name','c.id as machine_room_id' , 'd.nickname' , 'd.email' , 'd.name' , 'e.name as clerk_name']);

			$grid->disableCreateButton();	//禁用创建按钮
			$grid->disableExport();		//禁用导出数据按钮
			$grid->disableRowSelector();	//禁用行选择checkbox
			$grid->disableActions();		//禁用行操作列

			$grid->id('ID')->sortable();
			$grid->column('nickname','客户昵称')->display(function () {
				$this->customer_name = $this->nickname?:$this->email;
				$this->customer_name = $this->customer_name?:$this->name;
				return $this->customer_name;
			})->sortable();
			// $grid->column('email','客户邮箱');
			$grid->column('overlay_name','套餐名称');
			$grid->column('buy_time','购买时间');
			$grid->column('status','使用状态')->display(function () {
				$status = [
					0 => '未使用',
					1 => '生效中',
					2 => '已使用完毕',
				];
				return $status[$this->status];
			});
			$grid->column('use_time','启用时间');
			$grid->column('end_time','结束时间');
			$grid->column('protection_value','防御值');
			$grid->column('validity_period','生效时长/天');
			$grid->column('machine_room_name','机房');
			$grid->column('clerk_name','所属业务员');
			
			
			$grid->filter(function($filter){
				// 去掉默认的id过滤器
				$filter->disableIdFilter();
				// 在这里添加字段过滤器
				$filter->like('nickname', '客户名');
				$filter->like('email', '客户邮箱');
				$filter->like('name', '客户账号');
				// $filter->equal('status')->radio([
				// 	0 => '未使用',
				// 	1 => '生效中',
				// 	2 => '已使用完毕',
				// ]);

			});
			$grid->column('ip','使用IP')->display(function () {
				if ($this->status == 0) {
					$this->ip = '';
				}else{
					//查查看在不在高防业务里
					$ip = DB::table('tz_defenseip_business')->leftJoin('tz_defenseip_store as b' , 'b.id' , '=' , 'tz_defenseip_business.ip_id')
								->where('tz_defenseip_business.business_number' , $this->target_business)
								->first(['b.ip']);

					if ($ip != null) {	//在高防的话直接获取
						$this->ip = $ip->ip;
					}else{		//不在高防就去找找idc
						//idc的从订单表处找,因为存的是订单号
						$idc = DB::table('tz_orders')->where('order_sn' , $this->target_business)->first(['machine_sn' , 'business_sn','resource_type']);
						if ($idc != null) {
							if($idc->resource_type == 4){		//如果找出来是副ip,直接获取
								$this->ip = $idc->machine_sn;
							}elseif ($idc->resource_type == 1||$idc->resource_type == 2) {	//如果找出来是主机,去业务表的详情处找
								$business = DB::table('tz_business')->where('business_number',$idc->business_sn)->first(['resource_detail']);
								if ($business == null) {
									$this->ip = '信息有误';
								}else{
									$resource_detail = json_decode($business->resource_detail);
									$this->ip = $resource_detail['ip'];
								}
							}else{
								$this->ip = '信息有误';
							}
						}else{
							$this->ip = '信息有误';
						}
					}
				}
				return $this->ip;
			});

			

		});
	}
	// protected function form()
	// {
	// 	return Admin::form(CarouselModel::class, function (Form $form) {

	// 		$form->display('id', 'ID');
	// 		$form->text('name', '名称');
	// 		$form->text('url', '网址');
	// 		$types = [
	// 			1 => '首页'
	// 		];
	// 		$form->select('type', '类型')->options($types);
	// 		$form->image("image_url","图片")->move('public/images/');
	// 		$form->textarea('description', '描述');
	// 		$form->switch('top', '是否默认显示')->rules('required');
	// 		$form->number('order', '排序');
	// 	});
	// }
}
