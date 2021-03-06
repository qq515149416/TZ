<?php

namespace App\Admin\Models\Others;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Staff extends Model
{
    protected $table = 'oa_staff';
    public $timestamps = true;

    public function test() {
    	return 123;
    }

    /**
    * 查询员工基本信息表的数据
    * @return 返回数组将相关信息返回
    */
    public function index(){
    	$result = $this->orderBy('entrytime','')->get(['id','admin_users_id','sex','age','department','job','work_number','entrytime','dimission','phone','QQ','wechat','email','note','created_at','updated_at']);
    	if(!$result->isEmpty()) {
            $sex = ['女','男','保密'];
            $dimission = ['在职','离职'];
            foreach($result as $key=>$value) {
                $result[$key]['sex'] = $sex[$value['sex']];
                $result[$key]['dimission'] = $dimission[$value['dimission']];
            }
            $return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '';
    		// return $ret;
    	} else {
            $return['data'] = $result;
    		$return['code'] = 0;
    		$return['msg'] = '暂无数据';
    		
    	}
    	return $return;
    }
}
