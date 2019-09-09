<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Admin\Models\Business\InvoiceModel;
use App\Admin\Models\Business\PayableModel;
use App\Admin\Models\Customer\Customer;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\InvoiceRequest;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\Statistics\PfmStatistics as FlowModel;
use Illuminate\Support\Facades\DB;

/**
 * 后台订单控制器
 */
class InvoiceController extends Controller
{

	/**
	 * 为客户添加发票抬头
	 * @param 
	 * @return json 返回添加结果
	 */
	public function insertPayable(InvoiceRequest $request)
	{
		$par = $request->only(['user_id' ,'name' ,'num'  , 'address','tel' ,'bank' , 'bank_acc']);
		
		$model = new PayableModel();

		$res = $model->insertPayable($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 为客户删除邮寄地址
	 * @param 
	 * @return json 返回删除结果
	 */
	public function delPayable(InvoiceRequest $request)
	{
		$par = $request->only(['payable_id']);
		
		$model = new PayableModel();

		$res = $model->delPayable($par['payable_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 为客户编辑邮寄地址
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function editPayable(InvoiceRequest $request)
	{
		$par = $request->only(['payable_id' ,'name' ,'num'  , 'address','tel' ,'bank' , 'bank_acc']);
		
		$model = new PayableModel();

		$res = $model->editPayable($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 展示指定客户的邮寄地址
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function showPayable(InvoiceRequest $request)
	{
		$par = $request->only(['user_id']);
		
		$model = new PayableModel();

		$res = $model->showPayable($par['user_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 生成发票单
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function makeInvoice(InvoiceRequest $request)
	{
		$par = $request->only(['flow_id','type' , 'address_id' , 'payable_id']);
		
		$model = new InvoiceModel();

		$res = $model->makeInvoice($par['flow_id'] , $par['type'] , $par['address_id'] , $par['payable_id']  );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	/**
	 * 删除开票申请
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function deleteInvoice(InvoiceRequest $request)
	{
		$par = $request->only(['invoice_id']);
		
		$model = new InvoiceModel();

		$res = $model->deleteInvoice($par['invoice_id'] );
		
		echo ("<script>alert('".$res['msg']." ');location='/tz_admin/invoice/view'</script>");
		
	}

	/**
	 * 获取所属客户
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function getUsers(Request $request)
	{
		//$q = $request->get('q');

		$model = new Customer();

		$admin_id = Admin::user()->id;

		$users = $model->where('salesman_id' , $admin_id)
				->get( ['id', 'nickname as name']);
				// ->paginate(null, ['id', 'nickname as text']);

		return tz_ajax_echo($users,'获取成功',1);
		// return Customer::where(['salesman_id' => $admin_id])
		// 	->paginate(null, ['id', 'admin_id as text']);
		
	}

	/**
	 * 获取所属客户的流水
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function getFlow(InvoiceRequest $request)
	{
		$provinceId = $request->get('customer_id');
		
		$model = new FlowModel();

		$res = $model->where(['customer_id' => $provinceId , 'invoice_state' => 0])
				->get( ['id', 'serial_number' , 'actual_payment' ,'order_id']);
				// ->paginate(null, ['id', 'nickname as text']);

		foreach ($res as $k => $v) {
			$order_id = json_decode($v['order_id'],true);
			if (is_array($order_id)) {
				$order = DB::table('tz_orders')->whereIn('id',$order_id)->get(['id','resource_type','business_sn','resource','order_type']);
			}else{
				$order = DB::table('tz_orders')->where('id',$order_id)->get(['id','resource_type','business_sn','resource','order_type']);
			}
			//资源的类型(1.租用主机，2.托管主机，3.租用机柜，4.IP，5.CPU，6.硬盘，7.内存，8.带宽，9.防护，10.cdn , 11.高防IP ; 12.流量叠加包 )
			if(!$order->isEmpty()){
				$order = json_decode(json_encode($order) ,true);
			}
			$order_type = [ 1 => '新购' , 2 => '续费'];
			foreach ($order as $ke => $va) {
				switch ($va['resource_type']) {
					case '1':
						$order[$ke]['resource_type'] = '租用主机';
						break;
					case '2':
						$order[$ke]['resource_type'] = '托管主机';
						break;
					case '3':
						$order[$ke]['resource_type'] = '租用机柜';
						break;
					case '4':
						$order[$ke]['resource_type'] = 'IP';
						break;
					case '5':
						$order[$ke]['resource_type'] = 'CPU';
						break;
					case '6':
						$order[$ke]['resource_type'] = '硬盘';
						break;
					case '7':
						$order[$ke]['resource_type'] = '内存';
						break;
					case '8':
						$order[$ke]['resource_type'] = '带宽';
						break;
					case '9':
						$order[$ke]['resource_type'] = '防护';
						break;
					case '10':
						$order[$ke]['resource_type'] = 'cdn';
						break;
					case '11':
						$order[$ke]['resource_type'] = '高防IP';
						break;
					case '12':
						$order[$ke]['resource_type'] = '流量叠加包';
						break;		
					default:
						$order[$ke]['resource_type'] = '未知';
						break;
				}
				$order[$ke]['order_type'] = $order_type[$order[$ke]['order_type']];
				//$v['text'] = '流水号 : '. $v['serial_number'].' : 业务号 : ' .$order['business_sn']."({$type}) / " . '￥'.$v['actual_payment'];
				
				//unset($v['serial_number']);
				//unset($v['actual_payment']);
				//unset($v['order_id']);
			}
			$v['order'] = $order;
		}
		return $res;
		// return Customer::where(['salesman_id' => $admin_id])
		// 	->paginate(null, ['id', 'admin_id as text']);
		
	}

}
