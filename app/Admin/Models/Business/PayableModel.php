<?php


namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\Customer\Customer;

class PayableModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_payable'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'name' , 'num'  ,'address' ,'tel' , 'bank' , 'bank_ACC' ]  ;

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
	public function insertPayable($par )
	{
		// $check_admin = $this->checkAdmin($user_id);
		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不存在或不属于您',
		// 		'code'	=> 0,
		// 	];
		// }
		foreach ($par as $k => $v) {
			$data[$k] = $v;
		}

		$insert = $this->create($data);
		if($insert){
			return [
				'data'	=> [],
				'msg'	=> '添加发票抬头成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '添加发票抬头失败',
				'code'	=> 0,
			];
		}
	}

	/**
	*为客户删除邮寄地址
	*/
	public function delPayable( $payable_id )
	{
		$payable = $this->find($payable_id);
		if (!$payable) {
			return [
				'data'	=> [],
				'msg'	=> '无此发票抬头',
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

		$del = $payable->delete();
		if($del){
			return [
				'data'	=> [],
				'msg'	=> '发票抬头删除成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '发票抬头删除失败',
				'code'	=> 0,
			];
		}
	}

	/**
	*为客户编辑邮寄地址
	*/
	public function editPayable( $par )
	{
		
		$payable = $this->find($par['payable_id']);

		if (!$payable) {
			return [
				'data'	=> [],
				'msg'	=> '无此发票抬头',
				'code'	=> 0,
			];
		}
		$data = [];
		foreach ($par as $k => $v) {
			if ($k != 'payable_id') {
				$payable->$k = $v;
			}	
		}
		// $check_admin = $this->checkAdmin($address->user_id);

		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不属于您',
		// 		'code'	=> 0,
		// 	];
		// }
		$edit = $payable->save();
		if($edit){
			return [
				'data'	=> [],
				'msg'	=> '发票抬头编辑成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '发票抬头编辑失败',
				'code'	=> 0,
			];
		}
	}

	/**
	*为客户编辑邮寄地址
	*/
	public function showPayable( $user_id  )
	{
		// $check_admin = $this->checkAdmin($user_id);

		// if(!$check_admin){
		// 	return [
		// 		'data'	=> [],
		// 		'msg'	=> '客户不属于您',
		// 		'code'	=> 0,
		// 	];
		// }

		$payable = $this->where('user_id' , $user_id)->get();
		if($payable->isEmpty()){
			return [
				'data'	=> [],
				'msg'	=> '无已存发票抬头',
				'code'	=> 1,
			];
		}

		return [
			'data'	=> $payable,
			'msg'	=> '发票抬头获取成功',
			'code'	=> 1,
		];
	
	}
	
}