<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\Business\OrdersReviewModel;
use App\Admin\Models\Business\OrdersModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Widgets\Table;

/***
*	这个是业务员用的,只能看到自己的
*
*/
class OrdersReviewBigController extends Controller
{
	protected $detailID;
	protected $edit_status = 1;
	use ModelForm;
	public function index(Content $content)
	{
		return Admin::content(function (Content $content) {

			$content->header('消费流水复核');
			$content->description('需复核列表');

			$content->body($this->grid());
		});
	}
	//行操作,show按钮
	public function show($id, Content $content)
	{	
		$this->detailID = $id;
		return Admin::content(function (Content $content) use ($id) {


			$content->header('消费流水复核');
			$content->description('ID : '.$this->detailID.' 号复核流水包含的订单详情');

			$content->body($this->detail($id));
		});
	}



	// public function create(Content $content)
	// {
	// 	return Admin::content(function (Content $content) {

	// 		$content->header('轮播图管理');
	// 		$content->description('轮播图添加');

	// 		$content->body($this->form());
	// 	});
	// }

	//编辑方法,由于是业务员用,只能编辑回答
	public function edit($id)
	{
		$status = DB::table('tz_orders_review')->where('id' ,$id)->value('status');
		$this->edit_status = $status;
		return Admin::content(function (Content $content) use ($id) {

			$content->header('流水复核处理结果更改');
			$content->description('');
			$content->body($this->form()->edit($id));
		});
	}

	//显示具体包含的订单
	protected function detail($id)
	{
		
		return Admin::grid(OrdersModel::class, function (Grid $show) {

			$review = OrdersReviewModel::find($this->detailID)->toArray();
			
			$order_id = json_decode($review['order_id'],true);
			
			//添加数据查询条件
			// $grid->model()->leftJoin('tz_orders as b','b.id', '=' , 'tz_orders_review.flow_id')
			// 	->leftJoin('tz_users as c' , 'c.id' , '=' , 'b.customer_id')
			// 	->where('b.business_id',$admin_user['id'])
			// 	->select(['tz_orders_review.*', 'b.serial_number','c.nickname','c.email','c.name']);
			$show->model()->whereIn('id',$order_id)
				->select(['tz_orders.*']);
				

			/*	自定义按钮start		*/
			$show->disableCreateButton();		//禁用创建按钮
			$show->disableExport();			//禁用导出数据按钮
			$show->disableRowSelector();		//禁用行选择checkbox
			$show->disableActions();		//禁用行操作列
			$show->disableFilter();			//禁用查询过滤器
			$show->disablePagination();		//禁用分页条


			//$grid->perPages([10, 20, 30, 40, 50]);	//设置分页选择器选项
			// $grid->actions(function ($actions) {
			// 	$actions->disableDelete();	//行操作里屏蔽删除按钮
			// 	//按钮重构
			// 	// $actions->append("<a href='编辑跳转链接' style='float: left'><i class='fa fa-edit'></i></a>");
			// });
			// $grid->disableCreateButton();		//添加按钮重构
			// $grid->tools(function ($tools) {
			// 	$tools->append("<a href='添加跳转地址' class='btn btn-sm btn-success' style='float: right;'>
			// 	<i class='fa fa-save'></i>&nbsp;&nbsp;新增
			// 	</a>");
			// });

			/*	自定义按钮end		*/
			
			$show->id('ID')->sortable();
			$show->column('order_sn','订单编号');
			$show->column('business_sn','业务编号');
			$show->column('business_name','业务员');
			$show->column('resource_type','资源类型')->display(function () {
				$resource_type = [
					1 	=> '租用主机',
					2 	=> '托管主机',
					3 	=> '租用机柜',
					4 	=> 'IP',
					5 	=> 'CPU',
					6 	=> '硬盘',
					7 	=> '内存',
					8 	=> '带宽',
					9 	=> '防护',
					10 	=> 'cdn',
					11 	=> '高防IP',
					12 	=> '流量叠加包',
				];
				return $resource_type[$this->resource_type];
			});
			$show->column('order_type','资源类型')->display(function () {
				$order_type = [
					1 	=> '新购',
					2 	=> '续费',
				];
				return $order_type[$this->order_type];
			});
			$show->column('machine_sn','资源编号(高防和叠加包为套餐名)')->display(function () {
				if($this->resource_type == 11){		//如果是高防订单,去获取高防套餐
					$pack = DB::table('tz_defenseip_package')->where('id',$this->machine_sn)->value('name');
					return $pack;
				}elseif ($this->resource_type == 12) {	//如果是叠加包订单,去获取叠加包套餐
					$pack = DB::table('tz_overlay')->where('id',$this->machine_sn)->value('name');
					return $pack;
				}else{					//不是上述两个就是idc的了,直接返回资源编号
					return $this->machine_sn;
				}
			});
			$show->column('price','单价');
			$show->column('duration','数量/月or个');
			$show->column('payable_money','应付');
			$show->column('order_note','备注');
			// $show->column('machine_sn','资源编号(高防和叠加包为套餐id)');
			

		});
	}
	protected function grid()
	{
		return Admin::grid(OrdersReviewModel::class, function (Grid $grid) {


			$grid->model()->leftJoin('tz_orders_flow as b','b.id', '=' , 'tz_orders_review.flow_id')
				->leftJoin('tz_users as c' , 'c.id' , '=' , 'b.customer_id')
				->orderBy('tz_orders_review.status' , 'asc')
				->select(['tz_orders_review.*', 'b.serial_number','b.actual_payment','b.pay_time','b.before_money','b.after_money','c.nickname','c.email','c.name']);

			/*	自定义按钮start		*/
			$grid->disableCreateButton();	//禁用创建按钮
			$grid->disableExport();		//禁用导出数据按钮
			$grid->disableFilter();			//禁用查询过滤器

			$grid->disableRowSelector();	//禁用行选择checkbox
			// $grid->disableActions();		//禁用行操作列
			// $grid->actions(function ($actions) {
			// 	$actions->disableDelete();	//行操作里屏蔽删除按钮
			// 	// $actions->disableEdit();	
			// 	//按钮重构
			// 	// $actions->append("<a href='编辑跳转链接' style='float: left'><i class='fa fa-edit'></i></a>");
			// });
			// $grid->tools(function (Grid\Tools $tools) {
			// 	$tools->batch(function (Grid\Tools\BatchActions $actions) {
			// 		$actions->disableDelete();
			// 	});
			// });
			$grid->actions(function (Grid\Displayers\Actions $actions) {
				$actions->disableDelete();
				if($actions->row->status == 1){
					$actions->disableEdit();
				}
			});
			// $grid->disableCreateButton();		//添加按钮重构
			// $grid->tools(function ($tools) {
			// 	$tools->append("<a href='添加跳转地址' class='btn btn-sm btn-success' style='float: right;'>
			// 	<i class='fa fa-save'></i>&nbsp;&nbsp;新增
			// 	</a>");
			// });

			/*	自定义按钮end		*/


			$grid->id('ID')->sortable();
			$grid->column('nickname','客户昵称')->display(function () {
				$this->customer_name = $this->nickname?:$this->email;
				$this->customer_name = $this->customer_name?:$this->name;
				return $this->customer_name;
			})->sortable();
			$grid->column('business_name','业务员')->display(function () {
				$order_id = json_decode($this->order_id,true);
				$business_name = DB::table('tz_orders')->where('id',$order_id[0])->value('business_name');
				return $business_name;
			});
			$grid->column('serial_number','流水号');
			// $grid->column('order_id', '包含订单');
			$grid->column('actual_payment','实际扣费');
			$grid->column('before_money','扣前余额');
			$grid->column('after_money','扣后余额');
			$grid->column('pay_time','支付时间');
			$grid->column('status','处理进度')->display(function () {
				$status = [
					0 => '等待处理',
					1 => '处理完毕',
				];
				return $status[$this->status];
			});

			$grid->column('reason','问题');
			$grid->column('answer','回答');

		
		// 	$grid->column('status','使用状态')->display(function () {
		// 		$status = [
		// 			0 => '未使用',
		// 			1 => '生效中',
		// 			2 => '已使用完毕',
		// 		];
		// 		return $status[$this->status];
		// 	});
		// 	$grid->column('use_time','启用时间');
		// 	$grid->column('end_time','结束时间');
		// 	$grid->column('protection_value','防御值');
		// 	$grid->column('validity_period','生效时长/天');
		// 	$grid->column('machine_room_name','机房');
		// 	$grid->column('clerk_name','所属业务员');
			
			
		// 	$grid->filter(function($filter){
		// 		// 去掉默认的id过滤器
		// 		$filter->disableIdFilter();
		// 		// 在这里添加字段过滤器
		// 		$filter->like('nickname', '客户名');
		// 		$filter->like('email', '客户邮箱');
		// 		$filter->like('name', '客户账号');
		// 		// $filter->equal('status')->radio([
		// 		// 	0 => '未使用',
		// 		// 	1 => '生效中',
		// 		// 	2 => '已使用完毕',
		// 		// ]);

		// 	});
		// 	$grid->column('ip','使用IP')->display(function () {
		// 		$business_num = $this->target_business;
		// 		if ($this->status == 0) {
		// 			$this->ip = '';
		// 		}else{
		// 			//查查看在不在高防业务里
		// 			$ip = DB::table('tz_defenseip_business')->leftJoin('tz_defenseip_store as b' , 'b.id' , '=' , 'tz_defenseip_business.ip_id')
		// 						->where('tz_defenseip_business.business_number' , $business_num)
		// 						->first(['b.ip']);
								
		// 			if ($ip != null) {	//在高防的话直接获取
		// 				$this->ip = $ip->ip;
		// 			}else{		//不在高防就去找找idc
		// 				//idc的从订单表处找,因为存的是订单号
		// 				$idc = DB::table('tz_orders')->where('order_sn' , $business_num)->first(['machine_sn' , 'business_sn','resource_type']);
		// 				if ($idc != null) {
		// 					if($idc->resource_type == 4){		//如果找出来是副ip,直接获取
		// 						$this->ip = $idc->machine_sn;
		// 					}elseif ($idc->resource_type == 1||$idc->resource_type == 2) {	//如果找出来是主机,去业务表的详情处找
		// 						$business = DB::table('tz_business')->where('business_number',$idc->business_sn)->first(['resource_detail']);
		// 						if ($business == null) {
		// 							$this->ip = '信息有误';
		// 						}else{
		// 							$resource_detail = json_decode($business->resource_detail,true);

		// 							$this->ip = $resource_detail['ip'];
		// 						}
		// 					}else{
		// 						$this->ip = '信息有误';
		// 					}
		// 				}else{
		// 					$this->ip = '信息有误';
		// 				}
		// 			}
		// 		}
		// 		return $this->ip;
		// 	});

			

		});
	}
	protected function form()
	{
		return Admin::form(OrdersReviewModel::class, function (Form $form) {

			$form->display('id', 'ID');
	
			$form->display('reason', '问题');

			$form->display('answer', '回答');

			$form->tools(function (Form\Tools $tools) {
				$tools->disableDelete();
				$tools->disableView();
				$tools->disableList();
			});

			$form->radio('status')->options([0 => '等待处理', 1=> '处理完毕'])->default(0);
			// $types = [
			// 	1 => '首页'
			// ];
			// $form->select('type', '类型')->options($types);
			// $form->image("image_url","图片")->move('public/images/');
			// $form->textarea('description', '描述');
			// $form->switch('top', '是否默认显示')->rules('required');
			// $form->number('order', '排序');
		});
	}
}
