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
    	$result = $this->all(['id','admin_users_id','fullname','sex','age','department','position','work_number','phone','QQ','wechat','email','note','created_at','updated_at']);
    	if(!$result->isEmpty()) {
            $sex = ['女','男','保密'];
            foreach($result as $key=>$value) {
                $result[$key]['sex'] = $sex[$value['sex']];
            }
    		$result['code'] = 1;
    		$result['msg'] = '';
    		// return $result;
    	} else {
    		$result['code'] = 0;
    		$result['msg'] = '暂无数据';
    		
    	}
    	return $result;
    }
}
