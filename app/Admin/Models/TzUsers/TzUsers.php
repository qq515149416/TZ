<?php

namespace App\Admin\Models\TzUsers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use XS;
use XSDocument;
use Carbon\Carbon;

class TzUsers extends Model
{
	protected $table = 'tz_users';


	/**
	 * 获取用户信息
	 *
	 * @return mixed
	 */
	public function getUserInfo($uId)
	{


//        $userId = 2203; //测试用户的ID

		//根据用户ID获取相关信息
		$userInfo = $this
			->where('id', $uId)
			->select('id', 'msg_phone', 'msg_qq', 'remarks', 'email', 'name', 'money','nickname')
			->get();

		return $userInfo;

	}


	/**
	 * 更新用户信息
	 *
	 * 需要先判断用户是否存在
	 *
	 */
	public function updateUserInfo($updateData)
	{
		$userId = 2203;//用于测试的用户ID

		$res = $this
			->where('id', $updateData['uid'])
			->update([
				'msg_phone' => $updateData['msg_phone'],
				'msg_qq'=>$updateData['msg_qq'],
				'remarks'=>$updateData['remarks'],
				'name'  => $updateData['name'] == '暂未设置用户名' ? '' : $updateData['name'],
				'nickname' => $updateData['nickname'],
			]);
		if($res != 0){
			$xunsearch    = new XS('customer');
			$index        = $xunsearch->index;
			$doc['id']    = strtolower($updateData['uid']);
			$doc['name'] = strtolower($updateData['name']);
			$doc['nickname'] = strtolower($updateData['nickname']);
			$document     = new \XSDocument($doc);
			$index->update($document);
			$index->flushIndex();
		}
		return $res;

	}

	public function noBuyUsers()
	{
		$users = $this->leftJoin('admin_users as b' , 'b.id' , '=' , 'tz_users.salesman_id')
				->get(['tz_users.id' , 'tz_users.status' , 'tz_users.name' , 'tz_users.email' , 'tz_users.money' , 'tz_users.nickname' , 'tz_users.msg_phone' , 'tz_users.msg_qq' ,'b.name as salesman_name'])
				->toArray();
		
		$no_buy_arr = [ 	
					0 =>[
						'ID',
						'状态',
						'用户名',
						'邮箱',
						'余额',
						'昵称',
						'手机号',
						'QQ',
						'业务员',
					]
		];

		$status = [ 0 => '拉黑' , 1 => '未验证' , 2 => '正常'];
		foreach ($users as $k => $v) {
			$check = DB::table('tz_business')->where('client_id' , $v['id'])
							->whereIn('business_status' , [1,2,3,4])
							->whereIn('remove_status' , [0,1])
							->whereNull('deleted_at')
							->exists();

			$check2 = DB::table('tz_defenseip_business')->where('user_id' , $v['id'])
								->whereIn('status' , [1,2,4])
								->whereNull('deleted_at')
								->exists();

			if (!$check && !$check2) {
				$no_buy_arr[] = [
					$v['id'],
					$status[$v['status']],
					$v['name'],
					$v['email'],
					$v['money'],
					$v['nickname'],
					$v['msg_phone'],
					$v['msg_qq'],
					$v['salesman_name'],
				];
			}
		}
		$no_buy_arr[] = [ '统计时间' , date('Y-m-d H:i:s')];
		return $no_buy_arr;
	}

	//获取当日注册的
	public function usersToday()
	{
		$begin = date('Y-m-d 00:00:00');
		$end = date('Y-m-d 23:59:59');

		$num = $this->getUsersNum($begin,$end);
		return $num;
	}

	//获取当月注册的
	public function getUsersThisMonth()
	{
		$begin = date('Y-m-01 00:00:00');
		$end = date('Y-m-t 23:59:59');

		$num = $this->getUsersNum($begin,$end);
		return $num;
	}

	//获取所有
	public function getAllUsers()
	{
		$users_num = $this->where('status' , 2)
				->count();
		return $users_num;
	}
	
	//获取时间区间内的
	public function getUsersNum($begin,$end)
	{
		$users_num = $this->where('created_at','>',$begin)
				->where('created_at','<',$end)
				->where('status' , 2)
				->count();

		return $users_num;
	}

	//获取指定月份,详细情况
	public function getUsersDetailed($month)
	{
		$month_begin = $month.'-1 00:00:00';
		$month_end = date('Y-m-t 23:59:59' , strtotime($month_begin));
		$month_day = date('t',strtotime($month_begin));

		$users = $this->leftJoin('admin_users as b' , 'b.id' , '=' , 'tz_users.salesman_id')
				->where('tz_users.created_at','>',$month_begin)
				->where('tz_users.created_at','<',$month_end)
				->where('tz_users.status' , 2)
				->OrderBy('created_at','desc')
				->get(['tz_users.name' , 'tz_users.email' , 'tz_users.nickname' , 'tz_users.msg_phone' , 'tz_users.msg_qq', 'tz_users.created_at' , 'b.name as salesman_name']);
		$line = [];
		$line2 = [];
		for ($i=1; $i <= $month_day; $i++) { 
			$line[] = [
				'time'	=> $month.'-'.$i,
				'num'	=> 0,
			];
			$line2[$month.'-'.$i] = 0;
		}
		
		if($users->isEmpty()){
			return [
				'data'	=> [
					'line'	=> $line,
					'info'	=> null,
				],
				'msg'	=> '该月无注册用户',
				'code'	=> 1,
			];
		}
		$users = $users->toArray();
		foreach ($users as $k => $v) {
			$time = date('Y-m-j',strtotime($v['created_at']));
			$line2[$time]++;
		}
		foreach ($line as $k => $v) {
			$line[$k]['num'] = $line2[$line[$k]['time']];
		}

		return [
			'data'	=> [
				'line'	=> $line,
				'info'	=> $users,
			],
			'msg'	=> '获取成功',
			'code'	=> 1,
		];

	}
}