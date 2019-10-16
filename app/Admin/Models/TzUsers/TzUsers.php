<?php

namespace App\Admin\Models\TzUsers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use XS;
use XSDocument;

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
				->get(['tz_users.id' , 'tz_users.status' , 'tz_users.name' , 'tz_users.email' , 'tz_users.money' , 'tz_users.nickname' , 'tz_users.msg_phone' ,'b.name as salesman_name'])
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
					$v['salesman_name'],
				];
			}
		}
		return $no_buy_arr;
	}

}