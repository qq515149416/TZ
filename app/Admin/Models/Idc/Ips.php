<?php

// +----------------------------------------------------------------------
// | Author: 街"角．回 忆 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 处理IP的模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:21:37
// +----------------------------------------------------------------------
namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ips extends Model
{
    use SoftDeletes;
    protected $table = 'idc_ips';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    /**
    * 可以被批量赋值的属性.
    *
    * @var array
    */
    protected $fillable = ['vlan', 'ip','ip_company','ip_status','ip_lock','ip_note','ip_comproom','ip_comproomname','created_at','updated_at','deleted_at'];
    // 测试
    public function test() {
    	return 'ip 测试';
    }

    /**
     * 查询IP表的数据
     * @return 将数据及相关的信息返回到控制器
     */
    public function index(){
    	// 用模型进行数据查询
    	$index = $this->all(['id','vlan','ip','ip_company','ip_status','ip_lock','ip_note','ip_comproom','ip_comproomname','created_at','updated_at']);
    	if($index->isEmpty()){
    		// 判断存在数据就对部分需要转换的数据进行数据转换的操作
    		$ip_company = ['电信公司','移动公司','联通公司'];
    		$ip_status = ['未使用','使用(子IP)','使用(内部机器主IP)','使用(托管主机的主IP)'];
    		$ip_lock = ['未锁定','锁定'];
    		foreach($index as $ipkey=>$ipvalue) {
    			// 对应的字段的数据转换
    			$index[$ipkey]['ip_company'] = $ip_company[$value['ip_company']];
    			$index[$ipkey]['ip_status'] = $ip_status[$value['ip_status']];
    			$index[$ipkey]['ip_lock'] = $ip_lock[$value['ip_lock']];
    		}
    		$return['data'] = $index;
    		$return['code'] = 1;
    		$return['msg'] = '获取信息成功！！';
    	} else {
    		$return['data'] = $index;
    		$return['code'] = 0;
    		$return['msg'] = '暂无数据';
    	}
    	// 返回
    	return $return;
    }

    /**
     * 对IP地址进行添加处理
     * @param  array $data 要添加的数据
     * @return array      返回的信息和状态
     */
    public function insert($data){
    	if($data){
    		// 存在数据就用model进行数据写入操作
    		// $fill = $this->fill($data);
    		$row = $this->create($data);
    		if($row != false){
    			// 插入数据成功
    			$return['code'] = 1;
    			$return['msg'] = '新增IP地址信息成功!!';

    		} else {
    			// 插入数据失败
    			$return['code'] = 0;
    			$return['msg'] = '新增IP地址信息失败!!';
    		}
    	} else {
    		// 未有数据传递
    		$return['code'] = 0;
    		$return['msg'] = '请检查您要新增的信息是否正确!!';
    	}
    	return $return;
    }
    
    /**
     * 查找对应的IP数据
     * @param  int $id 查找IP的id条件
     * @return array     返回相关的数据和信息提示
     */
    public function edit($id){
    	if($id){
    		$result = $this->where('id',$ids)->get(['vlan', 'ip','ip_company','ip_status','ip_lock','ip_note','ip_comproom','ip_comproomname']);
    		if($result){
    			$return['data'] = $result;
               $return['code'] = 1;
               $return['msg'] = '获取信息成功！！';
            } else {
           		$return['data'] = $result;
                $return['code'] = 0;
                $return['msg'] = '无法获取到信息！！';
           }
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无法获取到对应的信息！！';
    	}

    	return $return;
    }

    /**
     * 对要修改的信息进行处理
     * @param  array $data 要修改的数据
     * @return array       返回信息和状态
     */
    public function doEdit($data){
    	if($data && $data['id']+0) {
    		$row = $this->where('id',$data['id'])->save($data);
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '修改IP信息成功！！';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '修改IP信息失败！！！';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '确保信息正确';
    	}
    }

    /**
     * 删除IP信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleted($id) {
    	if($id) {
    		$row = $this->where('id',$id)->delete();
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '删除IP信息成功';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '删除IP信息失败';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '无法删除IP信息';
    	}

    	return $return;
    }

    /**
     * 获取机房的信息
     * @return array 返回相关的信息和数据
     */
    public function machineroom() {
    	$result = DB::table('idc_machineroom')->select('machine_room_id','machine_room_name')->get();
    	if($result) {
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '机房信息获取成功!!';
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '机房信息获取失败!!';
    	}

    	return $return;
    }
}
