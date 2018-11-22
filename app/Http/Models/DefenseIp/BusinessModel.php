<?php

namespace App\Http\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DefenseIp\ApiController;


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

    public function examine($business_id,$status,$admin_user_id)
    {
    	$business = $this->where('status',2)->find($business_id);
    	if($business == null){
    		return [
    			'data'	=> '',
    			'msg'	=> '无此待审核下架业务',
    			'code'	=> 0,
    		];
    	}

    	 DB::beginTransaction();//开启事务处理

    	$business->status = $status;
    	$res = $business->save();
    	if($res != true)
    	{
    		return [
    			'data'	=> '',
    			'msg'	=> '审核失败',
    			'code'	=> 0,
    		];
    	}
    	if($status == 1){
    		DB::commit();
    		return [
    			'data'	=> '',
    			'msg'	=> '审核成功',
    			'code'	=> 1,
    		];
    	}else{
    		$apiController = new ApiController();
	    	$ip = DB::table('tz_defenseip_store')->where('id',$business->ip_id)->value('ip');
	    	$delRes = $apiController->deleteTarget($ip);
	    	if($delRes == 0){
	    		DB::commit();
	    		return [
		    		'data'	=> '',
				'msg'	=> '审核成功,解绑成功,业务已下架',
				'code'	=> 1,
		    	];
	    	}else{
	    		DB::rollBack();
	    		return [
		    		'data'	=> '',
				'msg'	=> '解绑失败,业务审核失败',
				'code'	=> 0,
		    	];
	    	}	
    	}	
    }

    public function showExamine()
    {
    	$list = $this->where('status',2)->get()->toArray();
    	if(count($list) == 0){
    		return [
	    		'data'	=> '',
			'msg'	=> '无下架申请',
			'code'	=> 0,
	    	];
    	}
   
    	for ($i=0; $i < count($list); $i++) { 
    		switch ($list[$i]['status']) {
    			case '0':
    				$list[$i]['status'] = '预留状态';
    				break;
    			case '1':
    				$list[$i]['status'] = '正在使用';
    				break;
    			case '2':
    				$list[$i]['status'] = '申请下架';
    				break;
    			case '3':
    				$list[$i]['status'] = '已下架';
    				break;	
    			default:
    				# code...
    				break;
    		}
    		$list[$i]['ip'] = DB::table('tz_defenseip_store')->where('id',$list[$i]['ip_id'])->value('ip');
    		$list[$i]['user_name'] = DB::table('tz_users')->where('id',$list[$i]['user_id'])->value('name');
    		if($list[$i]['user_name'] == null){
    			$list[$i]['user_name'] = DB::table('tz_users')->where('id',$list[$i]['user_id'])->value('email');	
    		}
    	}
    	return [
    		'data'	=> $list,
		'msg'	=> '获取成功',
		'code'	=> 1,
    	];
    }
}
