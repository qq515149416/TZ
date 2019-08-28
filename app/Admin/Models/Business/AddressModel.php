<?php


namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\Customer\Customer;

class AddressModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_address'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'address'];

	/**
	* 查询权限,是不是自己的客户或者是不是管理员
	*/
	public function checkAdmin($user_id)
	{
		if(Admin::user()->isAdministrator()){
			return true;
		}else{
			$admin_user = Admin::user();
			$customer_model = new Customer();
			$customer = $customer_model->find($user_id);
			if ($customer == null || $customer->salesman_id != $admin_user->id) {
				return false;
			}else{
				return true;
			}
		}
		

	}
	

	/**
	*为客户添加邮寄地址
	*
	*
	*/
	public function insert($user_id , $address )
	{
		// $check_admin = $this->checkAdmin($user_id);
		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不存在或不属于您',
		// 		'code'	=> 0,
		// 	];
		// }

		$insert = $this->create([
				'user_id'		=> $user_id,
				'address'	=> $address,
			]);
		if($insert){
			return [
				'data'	=> [],
				'msg'	=> '添加地址成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '添加地址失败',
				'code'	=> 0,
			];
		}
	}

	/**
	*为客户删除邮寄地址
	*/
	public function del( $address_id )
	{
		$address = $this->find($address_id);
		if (!$address) {
			return [
				'data'	=> [],
				'msg'	=> '无此地址',
				'code'	=> 0,
			];
		}

		// $check_admin = $this->checkAdmin($address->user_id);

		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不属于您',
		// 		'code'	=> 0,
		// 	];
		// }

		$del = $address->delete();
		if($del){
			return [
				'data'	=> [],
				'msg'	=> '地址删除成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '地址删除失败',
				'code'	=> 0,
			];
		}
	}

	/**
	*为客户编辑邮寄地址
	*/
	public function edit( $address_id , $address_after )
	{
		
		$address = $this->find($address_id);
		if (!$address) {
			return [
				'data'	=> [],
				'msg'	=> '无此地址',
				'code'	=> 0,
			];
		}

		// $check_admin = $this->checkAdmin($address->user_id);

		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不属于您',
		// 		'code'	=> 0,
		// 	];
		// }
		$address->address = $address_after;
		$edit = $address->save();
		if($edit){
			return [
				'data'	=> [],
				'msg'	=> '地址编辑成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '地址编辑失败',
				'code'	=> 0,
			];
		}
	}

	/**
	*为客户编辑邮寄地址
	*/
	public function show( $user_id  )
	{
		// $check_admin = $this->checkAdmin($user_id);

		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不属于您',
		// 		'code'	=> 0,
		// 	];
		// }

		$address = $this->where('user_id' , $user_id)->get(['address']);
		if($address->isEmpty()){
			return [
				'data'	=> [],
				'msg'	=> '无已存地址',
				'code'	=> 1,
			];
		}

		return [
			'data'	=> $address,
			'msg'	=> '地址获取成功',
			'code'	=> 1,
		];
	
	}
	
}