<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Models\Business\InvoiceModel;
use App\Admin\Models\Business\PayableModel;
use App\Admin\Models\Business\OrdersModel;
use Encore\Admin\Form;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Widgets\Table;
use App\Admin\Models\Statistics\PfmStatistics as FlowModel;
use App\Admin\Models\Customer\Customer;
//行操作
use App\Admin\Controllers\Business\DelInvoice;

/***
*	这个是业务员用的,只能看到自己的
*
*/
class InvoiceViewSmallController extends Controller
{
	protected $detailID;
	protected $mail_state;
	use ModelForm;
	public function index(Request $request,Content $content)
	{
		return Admin::content(function (Content $content) use($request) {

			$content->header('发票审核');
			$content->description('');

			$content->body($this->grid($request->input('invoice_id')));
		});
	}
	//行操作,show按钮
	public function show($id, Content $content)
	{
		$this->detailID = $id;
		return Admin::content(function (Content $content) use ($id) {


			$content->header('发票所包含订单详情');
			$content->description('ID : '.$this->detailID.' 号发票包含的订单详情');

			$content->body($this->detail($id));
		});
	}



	// public function create(Content $content)
	// {
	// 	return Admin::content(function (Content $content) {

	// 		$content->header('发票申请');
	// 		$content->description('提交申请');

	// 		$content->body($this->form());
	// 	});
	// }

	//编辑方法,由于是业务员用,只能编辑回答
	// public function edit($id)
	// {
	// 	$status = DB::table('tz_invoice')->where('id' ,$id)->value('mail_state');
	// 	$this->mail_state = $status;
	// 	return Admin::content(function (Content $content) use ($id) {

	// 		$content->header('发票管理');
	// 		$content->description('');
	// 		$content->body($this->form()->edit($id));
	// 	});
	// }

	//显示具体包含的订单
	protected function detail($id)
	{

		return Admin::grid(OrdersModel::class, function (Grid $show) {

			$invoice = InvoiceModel::find($this->detailID)->toArray();

			$flow_id = json_decode($invoice['flow_id'],true);

			$order_id = DB::table('tz_orders_flow')
					->whereIn('id',$flow_id)
					->whereNull('deleted_at')
					->select('order_id')
					->get();
			if (count($flow_id) != count($order_id)) {
				echo "<script language=javascript>alert('订单信息有误,请找技术人员查看！');location.href='javascript:history.go(-1)';</script>";
				exit;
			}
			$order_arr = [];
			foreach ($order_id as $k => $v) {
				$a = json_decode($v->order_id,true);
				if (!is_array($a)) {
					$order_arr[]=$a;
				}else{
					$order_arr = array_merge($order_arr,$a);
				}
			}
			
			//添加数据查询条件
			// $grid->model()->leftJoin('tz_orders as b','b.id', '=' , 'tz_orders_review.flow_id')
			// 	->leftJoin('tz_users as c' , 'c.id' , '=' , 'b.customer_id')
			// 	->where('b.business_id',$admin_user['id'])
			// 	->select(['tz_orders_review.*', 'b.serial_number','c.nickname','c.email','c.name']);
			$show->model()->whereIn('id',$order_arr)
				->select(['tz_orders.*']);


			/*	自定义按钮start		*/
			$show->disableCreateButton();		//禁用创建按钮
			$show->disableExport();			//禁用导出数据按钮
			$show->disableRowSelector();		//禁用行选择checkbox
			// $show->disableActions();		//禁用行操作列
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

			//$show->id('ID')->sortable();
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
	protected function grid($invoice_id = NULL)
	{
		return Admin::grid(InvoiceModel::class, function (Grid $grid) use($invoice_id) {
		            if($invoice_id) {
		                $grid->model()->where('id', $invoice_id);
		            }
		            
			// $grid->model()->leftJoin('tz_orders_flow as b','b.id', '=' , 'tz_orders_review.flow_id')
			// 	->leftJoin('tz_users as c' , 'c.id' , '=' , 'b.customer_id')
			// 	->orderBy('tz_orders_review.status' , 'asc')
			// 	->select(['tz_orders_review.*', 'b.serial_number','b.actual_payment','b.pay_time','b.before_money','b.after_money','c.nickname','c.email','c.name']);
	            		$grid->model()
	            		->where('salesman_id',Admin::user()->id)
	            		->orderBy('mail_state','asc');
			/*	自定义按钮start		*/
			$grid->disableCreateButton();	//禁用创建按钮
			$grid->disableExport();		//禁用导出数据按钮
			//$grid->disableFilter();			//禁用查询过滤器

			$grid->disableRowSelector();	//禁用行选择checkbox
			// $grid->disableActions();		//禁用行操作列
			// $grid->actions(function ($actions) {
			// 	$actions->disableDelete();	//行操作里屏蔽删除按钮
			// 	$actions->disableEdit();
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
				$actions->disableEdit();
				if($actions->row->mail_state != 1){
					$actions->append(new DelInvoice($actions->getKey()));
					//$actions->append('<a href="delete?invoice_id='.$actions->getKey().'"><i class="fa fa-trash"></i></a>');
				}	
			});

			//$grid->disableCreateButton();		//添加按钮重构
			// $grid->tools(function ($tools) {
			// 	$tools->append("<a href='添加跳转地址' class='btn btn-sm btn-success' style='float: right;'>
			// 	<i class='fa fa-save'></i>&nbsp;&nbsp;新增
			// 	</a>");
			// });

			/*	自定义按钮end		*/


			$grid->id('ID')->sortable();
			$grid->column('flow_id','包含流水及复核情况')->display(function () {
				$flow_id = json_decode($this->flow_id,true);
				$string = '';
				foreach ($flow_id as $k => $v) {
					$review_state = DB::table('tz_orders_review')
							->whereNull('deleted_at')
							->where(['flow_id' => $v])
							->get(['status']);
					$serial_number =  DB::table('tz_orders_flow')
								->whereNull('deleted_at')
								->where(['id' => $v])
								->value('serial_number');
					if ($review_state->isEmpty()) {//如果没有发现复核单
						$string.="流水号 : {$serial_number}  ,流水复核状态 : <span style='color:#f94949'>尚未完成复核</span><br>";
					}else{

						$switch = 1;//开关
						foreach ($review_state->toArray() as $ke => $va) {//循环每个查找到的复核单
							if ($va->status == 0) {//如果有其中一个复核单没解决
								$switch = 0;//关掉开关
							}
						}
						if ($switch == 0) {//如果开关是关的
							$string.="流水号 : {$serial_number}  ,流水复核状态 : <span style='color:#f94949'>尚未完成复核</span><br>";
						}else{
							$string.="流水号 : {$serial_number}  ,流水复核状态 : <span style='color:#40dc5d'>已完成复核</span><br>";
						}
					}
					
				}
				
				return $string;
			});
			$grid->column('salesman_id','业务员')->display(function () {
				$salesman = DB::table('admin_users')->where('id',$this->salesman_id)->value('name');
				return $salesman;
			});
			$grid->column('payable','客户')->display(function () {
				$payable = json_decode($this->payable,true); 
				$user_id = $payable['user_id'];
				$customer = DB::table('tz_users')->where('id',$user_id)->first(['name','email','nickname']);
				if (!$customer) {
					$name = '客户信息有误';
				}else{
					$name = $customer->nickname ?? $customer->email ?? $customer->name ?? '客户信息有误';
				}
				return $name;
			});
			$grid->column('total_amount','总金额 / 元');
			$grid->column('tax', '税额');
			$grid->column('type','发票种类')->display(function () {
				$type = [
					1 => '增值税普通发票',
					2 => '增值税专用发票',
				];

				return $type[$this->type];
			});
			$grid->column('invoice_num','发票号');
			$grid->column('date','开票日期');
			
			$grid->column('mail_state','寄出状态')->using([0 => '未寄出', 1 => '已寄出']);

			$grid->filter(function($filter){
				// 去掉默认的id过滤器
				$filter->disableIdFilter();
				// 在这里添加字段过滤器
				$filter->equal('type')->radio([
					1 => '增值税普通发票',
					2 => '增值税专用发票',
				]);
				$filter->equal('mail_state')->radio([
					0 => '未寄出',
					1 => '已寄出',
				]);
			});

		});
	}


	// protected function form()
	// {
	// 	return Admin::form(InvoiceModel::class, function (Form $form) {
	// 		//$form->select($column[, $label])->options('/api/users');
	// 		$form->select('customer','选择客户')->options('/tz_admin/invoice/getUsers')->load('flow_id', '/tz_admin/invoice/getFlow');

	// 		$form->listbox('flow_id','流水选择');

	// 		$form->display('id', 'ID');

	// 		$form->display('total_amount', '总金额');

	// 		$form->display('tax', '税额');
		
	// 		$form->tools(function (Form\Tools $tools) {

	// 			$tools->disableDelete();
	// 			$tools->disableView();
	// 			$tools->disableList();
	// 		});
			

			

			
	// 		$form->footer(function ($footer) {
	// 			// // 去掉`重置`按钮
	// 			// $footer->disableReset();
	// 			// 去掉`提交`按钮

	// 			if ($this->mail_state == 1) {
	// 				$footer->disableSubmit();
	// 				$footer->disableReset();
	// 			}
	// 			// // 去掉`查看`checkbox
	// 			//$footer->disableViewCheck();
	// 			// // 去掉`继续编辑`checkbox
	// 			//$footer->disableEditingCheck();
	// 			// // 去掉`继续创建`checkbox
	// 			// $footer->disableCreatingCheck();
	// 		});

	// 		$form->display('payable' , '发票抬头')->with(function ($value) {
	// 			$payable = json_decode($value,true);
	// 			//dd($payable);

	// 			return '名称 : '.$payable['name'].' </br> 纳税人识别号 : '.$payable['num'].' </br> 地址 : '.$payable['address'].' </br> 电话 : '.$payable['tel'].' </br> 开户行 : '.$payable['bank'].' </br> 开户行账号 : '.$payable['bank_acc'];
	// 		});
	// 		$form->display('address', '邮寄地址');
			
	// 		if ($this->mail_state == 1) {
	// 			$form->display('invoice_num','发票号');
	// 			$form->display('date', '选择开票日期');
	// 			$form->display('mail_state' , '开票状态')->with(function ($value) {
	// 				$state = [ 1 => '已寄出' , 0 => '未寄出'];
	// 				return $state[$value];
	// 			});
	// 		}else{
	// 			$form->text('invoice_num','发票号')->placeholder('请输入...')->rules('required');
	// 			$form->time('date', '选择开票日期')->format('YYYY-MM-DD HH:mm:ss')->rules('required');
	// 			$form->radio('mail_state' , '开票状态')->options([0 => '未寄出', 1=> '已寄出'])->default(0);
	// 		}
	// 		$form->saving(function (Form $form) {
	// 			if($form->mail_state == 1)
	// 			{
	// 				DB::beginTransaction();
	// 				$flow_id = json_decode($form->flow_id,true);
	// 				$model = new FlowModel();
	// 				foreach ($flow_id as $k => $v) {	
	// 					$flow = $model->find($v);
	// 					if(!$flow){
	// 						DB::rollBack();
	// 						throw new \Exception('流水信息错误,请找技术人员查看！');
	// 					}
	// 					$flow->invoice_state = 1;
	// 					if (!$flow->save()) {
	// 						DB::rollBack();
	// 						throw new \Exception('更新流水的发票状态失败');
	// 					}
	// 				}
	// 			}
	// 		});
	// 		$form->saved(function (Form $form) {
	// 			 if($form->model()->mail_state == 1){
	// 			 	DB::commit();
	// 			 }
	// 		});
	// 		// $types = [
	// 		// 	1 => '首页'
	// 		// ];
	// 		// $form->select('type', '类型')->options($types);
	// 		// $form->image("image_url","图片")->move('public/images/');
	// 		// $form->textarea('description', '描述');
	// 		// $form->switch('top', '是否默认显示')->rules('required');
	// 		// $form->number('order', '排序');
	// 	});
	// }

		
}
