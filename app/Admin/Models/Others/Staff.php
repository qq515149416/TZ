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
    	$data = [];
    	$result = $this->all();
    	// $result = (object)[['1'],[2],[4]];
    	if(!$result->isEmpty()) {
    		$data['data'] = $result;
    		$data['code'] = 1;
    		$data['msg'] = '';
    		// return $result;
    	} else {
    		$data['data'] = $result;
    		$data['code'] = 0;
    		$data['msg'] = '暂无数据';
    		
    	}
    	return $data;
    }
}
