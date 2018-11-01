<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * 新闻类型模型
 */
class NewsTypeModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_news_type';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['id','name','note','created_at','updated_at','deleted_at'];

    /**
     * 展示新闻类型信息
     * @return [type] [description]
     */
    public function showNewsType(){
    	$result = $this->all(['id','name','note','created_at','updated_at']);
    	if(!$result->isEmpty()){
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '获取新闻类型信息成功';
    	} else {
    		$return['data'] = $result;
    		$return['code'] = 0;
    		$return['msg'] = '获取新闻类型信息失败';
    	}
        return $return;
    }

    /**
     * 新增新闻类型
     * @param  array $insertdata 要新增的新闻类型信息
     * @return 返回新增的状态和提示信息
     */
    public function insertNewsType($insertdata){
    	if($insertdata){
    		$row = $this->create($insertdata);
    		if($row != false){
    			$return['data'] = $row->id;
    			$return['code'] = 1;
    			$return['msg'] = '新增新闻类型成功'; 
    		} else {
    			$return['data'] = '';
    			$return['code'] = 0;
    			$return['msg'] = '新增新闻类型失败！！';
    		}
    	} else {
    		$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '新闻类型信息无法新增！！';
    	}
    	return $return;
    }

    /**
     * 修改新闻类型信息
     * @param  array $editdata 要修改的数据
     * @return array           返回提示信息和状态
     */
    public function editNewsType($editdata){
    	if($editdata){
    		$row = $this->where(['id'=>$editdata['id']])->update($editdata);
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '修改新闻类型信息成功';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '修改新闻类型信息失败';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '无法修改新闻类型信息';
    	}
        return $return;
    }

    /**
     * 删除对应的新闻类型信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteNewsType($id){
    	if($id){
    		$row = $this->where(['id'=>$id])->delete();
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '删除新闻类型成功！！';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '删除新闻类型失败！！';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '新闻类型信息无法删除！！';
    	}
        return $return;
    }

}
