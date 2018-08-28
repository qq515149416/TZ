<?php

/**
 *
 */
namespace App\Http\Models\Pay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Recharge extends Model
{

	use SoftDeletes;

	protected $table = 'tz_recharge_flow'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'recharge_amount','recharge_way','trade_no','voucher','timestamp','money_before','money_after','created_at','trade_status','deleted_at'];


	public function makeOrder($data)
	{
		if ($data) {
			$test = $this->select('created_at','id')->where("user_id",$data['user_id'])->where('trade_status',0)->get();
			$test = json_decode(json_encode($test),true);
			if(count($test)>0){
				$created_at = strtotime($test[0]['created_at']);
				$time = time();	
				if($time - $created_at <= 300){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '5分钟内只能创建一张订单!!';
					return $return;
				}else{
					$row = $this->where('id',$test[0]['id'])->delete();
					if($row == false){
						$return['code'] 	= 0;
						$return['msg'] 	= '删除旧订单失败失败';
						return $return;
					}
				}
			}
			
			$row = $this->create($data);

			if($row != false){
				// 插入订单成功
				$return['data'] = $row->id;
				$return['code'] = 1;
				$return['msg'] = '订单录入成功!!';
			} else {
			// 插入数据失败
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '订单录入失败!!';
			}
		}else{
			// 未有数据传递
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请检查您要新增的信息是否正确!!';
		}
		return $return;
	}

	/**
	* 支付宝跳回页面处理方法
	* @return 将数据及相关的信息返回到控制器
	*/
	public function returnInsert($data)
	{
		$order = $this->select('user_id','trade_status')->where('trade_no',$data['trade_no'])->get();
		if(count($order) == 0){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无此单号!!请联系客服!!';
			return $return;
		}

		$trade_status = $order[0]['trade_status'];
		if($trade_status == 1){
			$return['data'] = '';
			$return['code'] = 1;
			$return['msg'] = '该订单已完成!!';
			return $return;
		}

		$user_id = $order[0]['user_id'];

		$data['money_before'] 	= floatval($this->getMoney($user_id)->money);
		$data['money_after']	= floatval($data['money_before'] + $data['recharge_amount']);
		$data['trade_status']	= 1;

		if($data){
			// 存在数据就用model进行数据写入操作
			DB::beginTransaction();
			$row = $this->where('trade_no',$data['trade_no'])->update($data);

			if($row != false){
				// 插入订单成功
				$res = DB::table('tz_users')->where('id',$user_id)->update(['money' => $data['money_after']]); 
				if($res == false){
					//失败就回滚
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '订单录入成功!!充值失败!!';
				}else{
					DB::commit();
					$return['data'] = $row;
					$return['code'] = 1;
					$return['msg'] = '订单录入成功!!充值成功';
				}
				
			} else {
			// 插入数据失败
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '订单录入失败!!';
			}
		} else {
			// 未有数据传递
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请检查您要新增的信息是否正确!!';
		}
		return $return;
	}

	/**
	* 查询user表的余额数据
	*@param $user_id	
	* @return 余额
	*/
	public function getMoney($user_id)
	{
		$money = DB::table('tz_users')->find($user_id,['money']);
		return $money;
	}
}