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
			'status'		=> 0,
			
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
	
}