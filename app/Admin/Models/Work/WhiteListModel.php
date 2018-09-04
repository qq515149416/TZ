<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class WhiteListModel extends Model
{
    use  SoftDeletes;
    protected $table = 'tz_white_list';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * 根据条件查出对应状态的白名单信息
     * @param  array $where 白名单的状态条件
     * @return [type]        [description]
     */
    public function showWhiteList($where){
    	$result = $this->where($where)->get(['id','white_number','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit','submit_note','check_id','check_number','check_time','check_note','white_status','created_at']);
    	if(!$result->isEmpty()){
    		$submit = [1=>'客户提交',2=>'内部提交'];
    		$white_status = [0=>'审核中',1=>'审核通过',2=>'审核不通过',3=>'黑名单'];
    		foreach($result as $key=>$value){
    			$result[$key]['submittran'] = $submit[$value['submit']];
    			$result[$key]['status'] = $white_status[$value['white_status']];
    		}
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '获取白名单信息成功';
    	} else {
    		$return['data'] = $result;
    		$return['code'] = 0;
    		$return['msg'] = '无法获取白名单信息';
    	}
    	return $return;

    }

    /**
     *提交白名单信息
     * @param  array $insertdata  要提交的白名单数据
     * @return [type]             [description]
     */
    public function insertWhiteList($insertdata){
    	if($insertdata){
            // 创建白名单编号
            $whitenumber = mt_rand(71,99).date('Ymd',time()).substr(time(),5,5);
            $insertdata['white_number'] = (int)$whitenumber;
            // 当前登陆用户的信息，作为提交者信息
            $admin_id = Admin::user()->id;
            $insertdata['submit_id'] = $admin_id;
            $fullname = (array)$this->staff($admin_id);
            $insertdata['submit_name'] = $fullname['fullname'];
            // 提交方
            $insertdata['submit'] = 2;
    		$row = $this->create($insertdata);
    		if($row != false){
    			$return['data'] = $row->id;
    			$return['code'] = 1;
    			$return['msg'] = '白名单信息提交成功';
    		} else {
    			$return['data'] = '';
    			$return['code'] = 0;
    			$return['msg'] = '白名单信息提交失败';
    		}
    	} else {
    		$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法提交白名单信息';
    	}
    	return $return;
    }

    /**
     * 白名单审核
     * @param  array $checkdata 审核的信息
     * @return [type]            [description]
     */
    public function checkWhiteList($checkdata){
    	if($checkdata){
            $admin_id = Admin::user()->id;
            $checkdata['check_id'] = $admin_id;
            $fullname = (array)$this->staff($admin_id);
            $checkdata['check_number'] = $fullname['work_number'];
            $checkdata['check_time'] = date('Y-m-d H:i:s',time());
            $row = $this->where('id',$checkdata['id'])->update($checkdata);
            if($row != false) {
                $return['data'] = '';
                $return['code'] = 1;
                $return['msg'] = '白名单审核成功';
            } else {
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '白名单审核失败';
            }

        } else {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '无法对白名单进行审核';
        }
    }

    /**
     * 删除白名单信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteWhitelist($id){
        if($id){
            $row = $this->where('id',$id)->delete();
            if($row != false){
                $return['code'] = 1;
                $return['msg'] = '删除信息成功';
            } else {
                $return['code'] = 0;
                $return['msg'] = '删除信息失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg'] = '无法删除信息';
        }
    }


    /**
     * 内部提交时根据用户账号的id查找出对应的账户的真实姓名
     * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
     * @return string           返回对应账户的真实姓名
     */
    public function staff($admin_id) {
        $staff = DB::table('oa_staff')->where('admin_users_id',$admin_id)
                    ->select('work_number','fullname')->first();
        return $staff;
    }
}
