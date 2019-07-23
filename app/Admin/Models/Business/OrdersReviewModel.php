<?php


namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;


class OrdersReviewModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_orders_review'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['flow_id', 'order_id','reason','answer','status'];

	/**
	*流水复核提交的接口
	*
	*
	*/
	public function ordersReview($par)
	{
		$flow = DB::table('tz_orders_flow')
			->where( [ 'id' => $par['flow_id'] ] )
			->whereNull( 'deleted_at' )
			->first();
		if($flow == null){
			return [ 
				'data'	=> [],
				'msg'	=> '流水不存在',
				'code'	=> 0,
			];
		}
		//因为之前代码有问题,所以有的存的不是json数组而是字符串,不统一,所以这个入库把它统一为json数组
		$order_id = json_decode($flow->order_id,true);
		if ( !is_array($order_id) ) {
			$order_id = [ $order_id ];
		}
		$order_id = json_encode($order_id);

		$data = [
			'flow_id'		=> $par['flow_id'],	
			'reason'		=> $par['reason'],
			'order_id'	=> $order_id,
			'status'		=> $par['status'],
		];
		$res = $this->create($data);
		if ($res) {
			return [ 
				'data'	=> [],
				'msg'	=> '添加复核成功',
				'code'	=> 1,
			];
		}else{
			return [ 
				'data'	=> [],
				'msg'	=> '添加复核失败',
				'code'	=> 0,
			];
		}
	}
	

	/**
	*根据流水id查询该流水的所有复核情况
	*
	*
	*/
	public function showReview( $flow_id )
	{
		$review = $this->where('flow_id',$flow_id)->get()->toArray();
		if (count($review) == 0) {
			return [
				'data'	=> [],
				'msg'	=> '无复核单',
				'code'	=> 1,
			];
		}

		$status_arr = [
			0	=> '尚未处理',
			1	=> '处理完毕',
		];
		foreach ($review as $k => $v) {
			if (isset($status_arr[$v['status']])) {
				$review[$k]['review_status'] = $status_arr[$v['status']];
			}else{
				$review[$k]['review_status'] = ['状态异常'];
			}	
		}
		return [
			'data'	=> $review,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}
	
}