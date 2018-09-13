<?php

namespace App\Admin\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

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
	protected $fillable = ['id','admin_users_id', 'fullname','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','education','train','work','skill','detailed','family','note','created_at','updated_at','deleted_at'];
	
	/**
	 * 查找员工的个人信息
	 * @return 返回相关的数据和提示信息
	 */
	public function showEmployee(){
		$result = $this->get(['id','admin_users_id', 'fullname','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','note','created_at','updated_at']);
		if(!$result->isEmpty()){
			$sex = [0=>'女',1=>'男',2=>'保密'];
			$dimission = [0=>'在职',1=>'离职'];
			foreach($result as $infor => $mation){
				$result[$infor]['sex'] = $sex[$mation['sex']];
				$result[$infor]['dimission'] = $dimission[$mation['dimission']];
			}
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！';
		} else {
			$return['data'] = $result;
			$return['code'] = 0;
			$return['msg'] = '暂无数据';
		}

		return $return;
	}


	/**
	 * 对员工信息进行添加处理
	 * @param  array $data 要新建的信息
	 * @return 返回新建的提示和信息
	 */
	public function insertEmployee($data) {
		if($data){
			$row = $this->create($data);
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
	 * 对员工信息进行修改
	 * @param  array $data 要修改的数据
	 * @return array       返回提示信息和状态
	 */
	public function editEmployee($data){
		if($data && $data['id']+0){
			
			$row = self::where('id', $data['id'])
				->update($data);
			if($row != false){
				// 修改数据成功
				$return['code'] = 1;
				$return['msg'] = '修改信息成功！！';
			} else {
				// 修改数据失败
				$return['code'] = 0;
				$return['msg'] = '修改信息失败！！';
			}
		} else {
			$return['code'] = 0;
			$return['msg'] = '请确保要修改的员工信息正确';
		}
		return $return;
	}

	/**
	 * 删除员工信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteEmployee($id) {
		if($id+0){
			$row = $this->where('id',$id)->delete();
			if($row != false){
				// 根据条件查询到数据
			   $return['code'] = 1;
			   $return['msg'] = '删除员工信息成功！！'; 
			} else {
				// 根据条件没有删除到数据
				$return['code'] = 0;
				$return['msg'] = '无法删除相关的信息！！';
			}
		} else {
			$return['code'] = 0;
			$return['msg'] = '无法删除相关信息！！';
		}
		return $return;
	}

	/**
	 * 查找登录用户的个人的信息
	 * @param int $user_id 对应的admin_users_id
	 */
	public function employeePersonal($user_id){
		$result = $this->where('admin_users_id',$user_id)->get(['id','admin_users_id', 'fullname','sex','age','department','job','entrytime','work_number','phone','QQ','wechat','email','dimission','note','created_at','updated_at']);
		if(!$result->isEmpty()){
			$sex = [0=>'女',1=>'男',2=>'保密'];
			$dimission = [0=>'在职',1=>'离职'];
			foreach($result as $infor => $mation){
				$result[$infor]['sex'] = $sex[$mation['sex']];
				$result[$infor]['dimission'] = $sex[$mation['dimission']];
			}
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！';
		} else {
			$return['data'] = $result;
			$return['code'] = 0;
			$return['msg'] = '暂无数据';
		}

		return $return;
	}


	public function employeeDetailed($param){
		if($param['detailed_id']+0){
			$result = $this->where('admin_users_id',$param)->get(['education','train','work','skill','detailed','family']);

			if(!$result->isEmpty()){
				$return['data'] = $result;
				$return['code'] = 1;
				$return['msg'] = '获取信息成功！';
			} else {
				$return['data'] = $result;
				$return['code'] = 0;
				$return['msg'] = '暂无数据';
			}
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法获取详情信息！！';
		}
	
		return $return;
	}
}
