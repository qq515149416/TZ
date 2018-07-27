<?php

namespace App\Admin\Models\Others;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Contacts extends Model
{
    protected $table = 'oa_contacts';
    public $timestamps = true;

    public function test() {
    	return 456;
    }

     /**
     * 查询系统联系人（业务员）信息表的数据
     * @return 返回数组将相关信息返回
     */
    public function index(){
    	$data = [];
    	$result = $this->all();
    	// $result = [['1'],[2],[4]];
    	if($result) {
    		$data['data'] = $result;
    		$data['code'] = 1;
    		$data['msg'] = '';
    	} else {
    		$data['data'] = $result;
    		$data['code'] = 0;
    		$data['msg'] = '暂无数据';	
    	}
    	return $data;
    	
    }
}
