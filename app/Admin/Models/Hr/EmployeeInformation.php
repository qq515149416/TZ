<?php

namespace App\Admin\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;

class EmployeeInformation extends Model
{
	use  SoftDeletes;
	protected $table = 'oa_staff';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	/**
	* 可以被批量赋值的属性.
	*
	* @var array
	*/
	protected $fillable = ['id','admin_users_id','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','education','work','skill','detailed','note','created_at','updated_at','deleted_at'];
	
	/**
	 * 获取个人信息
	 * @param  array $account_id 账户id
	 * @return [type]             [description]
	 */
	public function showEmployee($account_id){
		$path_info = Request()->getPathInfo();
		$arr = explode('/',$path_info);
		$method = $arr[count($arr)-1];
		$name = '';
		if($account_id){//查找对应的账户的个人信息
			$where = ['admin_users_id'=>$account_id['account_id']];
			$data = ['id','admin_users_id','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','education','work','skill','detailed','note','created_at','updated_at'];
		} elseif($method == 'employee_personal'){//个人信息
			$where = ['admin_users_id'=>Admin::user()->id];
			$data = ['id','admin_users_id','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','education','work','skill','detailed','note','created_at','updated_at'];
			$name = Admin::user()->name;
		}
		else {//作为通讯录显示
			$where = [];
			$data = ['id','admin_users_id','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','created_at','updated_at'];
		}
		$show = $this->where($where)->get($data);
		if(!$show->isEmpty()){
			$dimission = [0=>'在职',1=>'离职'];
			$sex = [0=>'女性',1=>'男性',2=>'保密'];
			foreach($show as $showkey){
				$show[$showkey]['department_name'] = $this->department($show[$showkey]['department']);//获取部门
				$show[$showkey]['job_name'] = $this->jobs($show[$showkey]['job']);//获取职位
				$show[$showkey]['dimiss'] = $dimission[$show[$showkey]['dimission']];//转换在职状态
				$show[$showkey]['sex_tran'] = $sex[$show[$showkey]['sex']];//性别转换
				$show[$showkey]['fullname'] = $name?$name:$this->name($show[$showkey]['admin_users_id']);//获取名字
			}
			$return['data'] = $show;
			$return['code'] = 1;
			$return['msg'] = '获取个人信息成功!';
		} else {
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '获取个人信息失败!';
		}
		return $return;
	}

	/**
	 * 添加员工信息
	 * @param  array $insert_data 需要添加的数据
	 * @return [type]              [description]
	 */
	public function insertEmployee($insert_data){
		if($insert_data){
			$row = $this->create($insert_data);
			if($row != false){
				$return['data'] = $row->id;
				$return['code'] = 1;
				$return['msg'] = '新增员工信息成功！！';
			} else {
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '新增员工信息失败！！';
			}
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请输入正确的信息';
		}
		return $return;
	}

	/**
	 * 修改员工个人信息
	 * @param  array $edit_data 要修改的数据
	 * @return [type]            [description]
	 */
	public function editEmployee($edit_data){
		if($edit_data && isset($edit_data['id'])){
			$row = $this->where(['id'=>$edit_data['id']])->update($edit_data);
			if($row != false){
				$return['code'] = 1;
				$return['msg'] = '修改个人信息成功';
			} else {
				$return['code'] = 0;
				$return['msg'] = '修改个人信息失败';
			}
		} else {
			$return['code'] = 0;
			$return['msg'] = '请输入正确的修改信息';
		}
	}

	/**
	 * 删除个人信息
	 * @param  [type] $delete_id [description]
	 * @return [type]            [description]
	 */
	public function deleteEmployee($delete_id){
		if(!$delete_id){
			$return['code'] = 0;
			$return['msg'] = '无法删除';
			return $return;
		}
		$row = $this->where(['id'=>$delete_id['delete_id']])->delete();
		if($row != false){
			$return['code'] = 1;
			$return['msg'] = '删除成功';
		} else {
			$return['code'] = 0;
			$return['msg'] = '删除失败';
		}
		return $return;
	}

	/**
	 * 转换部门
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function department($depart_id){
		$department_name = DB::table('tz_department')->where(['id'=>$depart_id])->value('department_name');
		return $department_name;
	}

	/**
	 * 转换职位
	 * @param  [type] $jon_id [description]
	 * @return [type]         [description]
	 */
	public function jobs($jon_id){
		$job_name = DB::table('tz_jobs')->where(['id'=>$jon_id])->value('job_name');
		return $job_name;
	}

	/**
	 * 获取账户姓名
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function name($user_id){
		$name = DB::table('admin_users')->where(['id'=>$user_id])->value('name');
	}
}
