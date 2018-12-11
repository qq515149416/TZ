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
    public $timestamps = true;
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


    /*
    *下架审核的方法
    */
    public function examine($business_id,$status,$admin_user_id)
    {
    	//获取审核对象
    	$business = $this->where('status',2)->find($business_id);
    	if($business == null){
    		return [
    			'data'	=> '',
    			'msg'	=> '无此待审核下架业务',
    			'code'	=> 0,
    		];
    	}

    	 DB::beginTransaction();//开启事务处理

    	 //更新审核结果
    	$business->status = $status;
    	$res = $business->save();
    	//如果没成功就返回0
    	if($res != true)
    	{
    		return [
    			'data'	=> '',
    			'msg'	=> '审核失败',
    			'code'	=> 0,
    		];
    	}
    	//成功的话,就看他审核结果,如果是1(正在使用),就什么都不改变,直接提交事务,返回成功
    	if($status == 1){
    		DB::commit();
    		return [
    			'data'	=> '',
    			'msg'	=> '审核成功,业务将继续使用',
    			'code'	=> 1,
    		];
    	}
    	//如果不是1,就是3(确定下架),就调用解绑接口,把客户ip和高防ip解绑
	$apiController = new ApiController();
    	$ip = DB::table('tz_defenseip_store')->where('id',$business->ip_id)->value('ip');

    	$delRes = $apiController->deleteTarget($ip);
    	//解绑失败的话,事务回滚,回到待审核状态
    	if($delRes != 0){
    		DB::rollBack();
    		return [
	    		'data'	=> '',
			'msg'	=> '解绑失败,业务审核失败',
			'code'	=> 0,
	    	];
    	}
    	//解绑成功后,需要把ip释放出来回到未使用状态
    	$release_ip = DB::table('tz_defenseip_store')->where('id',$business->ip_id)->update(['status' => 0]);
    	if($release_ip != 1){
    		DB::rollBack();
    		return [
	    		'data'	=> '',
			'msg'	=> '释放高防IP失败,请检查数据库',
			'code'	=> 0,
	    	];
    	}	
    	//释放完IP之后提交事务并返回成功信息
    	DB::commit();
	return [
		'data'	=> '',
		'msg'	=> '审核成功,业务已下架',
		'code'	=> 1,
	];
    }

    public function showExamine()
    {
    	$list = $this->where('status',2)->orderBy('updated_at','desc')->get()->toArray();
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
                                            case '4':
                                                        $list[$i]['status'] = '试用中';
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

    public function showBusiness($id,$way)
    {
        switch ($way) {
            case 'package':
                $list = $this->where('package_id',$id)->get()->toArray();
                break;
            case 'customer':
                $list = $this->where('user_id',$id)->get()->toArray();
                break;
            default:
                return [
                    'data'  => '',
                    'msg'   => '获取失败',
                    'code'  => 0,
                ];
                break;
        }
        
        if(count($list) == 0){
            return [
                'data'  =>  '',
                'msg'   => '获取失败或无数据',
                'code'  => 0,
            ];
        }
        for ($i=0; $i < count($list); $i++) { 
            $list[$i]['user_name'] = DB::table('tz_users')->where('id',$list[$i]['user_id'])->value('name');
            if($list[$i]['user_name'] == null){
                $list[$i]['user_name'] = DB::table('tz_users')->where('id',$list[$i]['user_id'])->value('email');
            }
            $list[$i]['ip'] = DB::table('tz_defenseip_store')->where('id',$list[$i]['ip_id'])->value('ip');
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
                case '4':
                    $list[$i]['status'] = '试用中';
                    break;
                default:
                    $list[$i]['status'] = '无此状态,请核对数据库';
                    break;
            }
        }
        return [
            'data'  =>  $list,
            'msg'   => '获取成功',
            'code'  => 1,
        ];
    }
}
