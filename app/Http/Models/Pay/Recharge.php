<?php

/**
 *
 */
namespace App\Http\Models\Pay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Recharge extends Model
{

	protected $table = 'tz_recharge_flow'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $fillable = ['user_id', 'recharge_amount','recharge_way','trade_no','voucher','timestamp','money_before','money_after','created_at'];

	/**
	* 查询cpu表的数据
	* @return 将数据及相关的信息返回到控制器
	*/
	public function insert($data)
	{
		$data['money_before'] 	= floatval($this->getMoney($data['user_id'])->money);
		$data['money_after']	= floatval($data['money_before'] + $data['recharge_amount']);
		
		if($data){
			// 存在数据就用model进行数据写入操作
			DB::beginTransaction();
			$row = $this->create($data);

			if($row != false){
				// 插入订单成功
				$res = DB::table('tz_users')->where('id',$data['user_id'])->update(['money' => $data['money_after']]); 
				if($res == false){
					//失败就回滚
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '订单录入成功!!充值失败!!';
				}else{
					DB::commit();
					$return['data'] = $row->id;
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