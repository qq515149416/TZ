<?php

namespace App\Http\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BusinessModel extends Model
{
    use SoftDeletes;

    protected $table = 'tz_defenseip_business'; //表
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at']; //删除时间

//    /**
//     *
//     */
//    public function test()
//    {
//       return $this->hasOne('App\Http\Models\DefenseIp\StoreModel','id','ip_id');
//    }

    public function subExamine($business_id,$admin_user_id)
    {
    	$business = $this->find($business_id);
    	if($business == null){
    		return [
    			'data'	=> '',
    			'msg'	=> '无此业务',
    			'code'	=> 0,
    		];
    	}
    	$business_admin_user_id = DB::table('tz_users')->where('id',$business->user_id)->value('salesman_id');
    	if($business_admin_user_id != $admin_user_id){
    		return [
    			'data'	=> '',
    			'msg'	=> '该业务所属客户不属于您',
    			'code'	=> 0,
    		];
    	}
    	$business->status = 2;
    	$res = $business->save();
    	if($res != true)
    	{
    		return [
    			'data'	=> '',
    			'msg'	=> '更改业务使用状态失败',
    			'code'	=> 0,
    		];
    	}
    	return [
    		'data'	=> '',
		'msg'	=> '提交下架审核成功',
		'code'	=> 1,
    	];
    }


}
