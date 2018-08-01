<?php

namespace App\Admin\Models\Others;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Contacts extends Model
{
    use SoftDeletes;
    protected $table = 'oa_contacts';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    /**
    * 可以被批量赋值的属性.
    *
    * @var array
    */
    protected $fillable = ['contactname', 'qq','mobile','email','rank','site','created_at','updated_at','deleted_at'];

    public function test() {
    	return 456;
    }

    /**
    * 查询系统联系人（业务员）信息表的数据
    * @return 返回数组将相关信息返回
    */
    public function index(){
        // 查询数据并进行权重排序（权重数值越小，越靠前）
    	$result = $this->all(['id','contactname', 'qq','mobile','email','rank','site']);
        $this->orderBy('rank');

    	if(!$result->isEmpty()) {
            $site = [1=>'左侧',2=>'联系人页面',3=>'两侧均显示'];
            foreach($result as $key => $value){
                $result[$key]['site'] = $site[$value['site']];
            }
            $return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '获取信息成功！';
    	} else {
            // 不存在数据
            $return['data'] = $result;
    		$return['code'] = 0;
    		$return['msg'] = '暂无数据';	
    	}
    	return $return;
    	
    }

    /**
     * 对信息进行添加处理
     * @param  array $data 要添加的数据
     * @return array       返回信息和状态
     */
    public function create($data){
        // 定义一个空数组接收返回的信息
        // $result = [];
        if($data) {
            // 存在传递的数据进行对应字段的插入
            $row = $this->fill()->save($data);
            // $this->create_at;
            if($row){
                // 插入数据成功
                $return['code'] = $row;
                $return['msg'] = '新增信息成功！！';
            } else {
                // 插入数据失败
                $return['code'] = 0;
                $return['msg'] = '新增信息失败！！';
            }

        } else {
            // 不存在传递的数据
            $return['code'] = 0;
            $return['msg'] = '请输入正确的信息';
        }

        return $return;
    }

    /**
     * 根据控制器传递过来的参数进行数据的查找并返回数据及信息提示
     * @param  int $id 查询条件的相关参数
     * @return array     返回相关的数据或者提示信息
     */
    public function edit($id){
        $ids = $id + 0;
        if($ids){
            // 存在条件进行查询
            $result = $this->where('id',$ids)->get(['id','contactname', 'qq','mobile','email','rank','site']);
            if($result){
                // 根据条件查询到数据
                $site = [1=>'左侧',2=>'联系人页面',3=>'两侧均显示'];
                foreach($result as $key => $value){
                    $result[$key]['sitename'] = $site[$value['site']];
                }
                $return['data'] = $result;
               $return['code'] = 1;
               $return['msg'] = '获取信息成功！！'; 
            } else {
                // 根据条件没有查询到数据
                $return['data'] = $result;
                $return['code'] = 0;
                $return['msg'] = '无法获取到信息！！';
            }
        }else {
            // 没传递条件
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '无法获取信息！！';
        }

        return $return;
    }

    /**
     * 对信息进行修改处理
     * @param  array $data 要修改的数据
     * @return array       返回信息和状态
     */
    public function doEdit($data) {
        // 定义一个空的数组接收返回的信息
        // $result = [];
        if($data && $data['id']+0) {
            //存在修改的数据进行修改操作
            $row = $this->where('id',$data['id'])->fill($data)->save();
            if($row){
                // 修改数据成功
                $return['code'] = $row;
                $return['msg'] = '修改信息成功！！';
            } else {
                // 修改数据失败
                $return['code'] = 0;
                $return['msg'] = '修改信息失败！！';
            }

        } else {
            // 没有数据
            $return['code'] = 0;
            $return['msg'] = '请确保信息正确';
        }

        return $return;
    }

    /**
     * 删除联系人信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function dele($id) {
        // $result = [];
        $ids = $id + 0;
        if($ids){
            // 存在条件进行删除
            $row = $this->where('id',$ids)->delete();
            if($result){
                // 根据条件查询到数据
               $return['code'] = $row;
               $return['msg'] = '删除信息成功！！'; 
            } else {
                // 根据条件没有删除到数据
                $return['code'] = 0;
                $return['msg'] = '无法删除相关的信息！！';
            }
        }else {
            // 没传递条件
            $return['code'] = 0;
            $return['msg'] = '无法删除相关信息！！';
        }

        return $return;
    }
}
