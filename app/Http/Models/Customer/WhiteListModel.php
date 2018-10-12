<?php

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * 前台客户有关的白名单的模型
 */
class WhiteListModel extends Model
{
	use  SoftDeletes;
	protected $table = 'tz_white_list';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['white_number', 'white_ip','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit','submit_note','check_time','check_note','white_status'];
   	
   	/**
   	 * 找出对应客户的工单
   	 * @param  [type] $white_status [description]
   	 * @return [type]               [description]
   	 */
   	public function showWhiteList($white_status){
   		// 当前登陆用户的id
   		$user_id = Auth::id();
   		$white_status['customer_id'] = $user_id;
    	$list = $this->where($white_status)->get(['id','white_number','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit_note','check_time','white_status','created_at']);
    	if(!$list->isEmpty()){
    		$status = [0=>'审核中',1=>'审核通过',2=>'审核不通过',3=>'审核不通过'];
    		foreach($list as $list_key => $list_value){
    			$list[$list_key]['status'] = $status[$list_value['white_status']];
    		}
    		$return['data'] = $list;
    		$return['code'] = 1;
    		$return['msg'] = '获取白名单信息成功';
    	} else {
    		$return['data'] = $list;
    		$return['code'] = 0;
    		$return['msg'] = '获取白名单信息失败';
    	}

    	return $return;
    }

    /**
     * 白名单信息的提交
     * @param  array $insert_data 需要提交的白名单相关数据
     * @return   array            返回相关的状态提示及信息
     */
    public function insertWhiteList($insert_data){
    	if($insert_data){
    		$white_number = mt_rand(41,70).date("Ymd",time()).substr(time(),8,2);
    		$insert_data['white_number'] = (int)$white_number;
    		$insert_data['customer_id'] = Auth::id();
    		$insert_data['customer_name'] = Auth::user()->name;
    		$insert_data['submit_id'] = Auth::id();
    		$insert_data['submit_name'] = Auth::user()->name;
    		$insert_data['submit'] = 1;
    		$insert_data['white_status'] = 0;
    		$row = $this->create($insert_data);
    		if($row != false){
    			$return['data'] = $row->id;
    			$return['code'] = 1;
    			$return['msg'] = '白名单信息提交成功，请耐心等待审核';
    		} else {
    			$return['data'] = '';
    			$return['code'] = 0;
    			$return['msg'] = '白名单信息提交失败，请确认后重新提交';
    		}
    	} else {
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = '无法提交白名单信息';
    	}
    	return $return;
    }

    /**
     * 提交白名单前对该域名进行查询是否提交过
     * @param  array $domain_name 提交的域名
     * @return array              返回相关的状态提示及信息
     */
    public function checkDomainName($domain_name){
    	$domain_name['customer_id'] = Auth::user()->id;
    	$status = $this->where($domain_name)->select('white_status')->first();
    	if(!$status->isEmpty()){
			$return['code'] = 1;
			$return['msg'] = '该域名您已提交过,请勿重复提交';
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '';
    	}
    	return $return;
    }

    /**
     * 提交白名单前对客户的IP进行核验
     * @param  array $white_ip IP地址
     * @return array           返回核验结果的机器编号和状态提示及信息
     */
    public function checkIp($white_ip){
    	// 根据IP地址查找IP库中对应IP绑定机器编号，业务编号等信息
    	$where['ip'] = $white_ip['white_ip'];
    	$ip = DB::table('idc_ips')->where($where)->select('ip_status','own_business','mac_num')->first();
    	if(!$ip->isEmpty()){// 查找到对应的IP相关数据后，根据业务状态和客户id进行查找对应的业务信息
    		$business['business_status'] = ' > 1';
    		$business['business_status'] = ' < 5';
    		$business['client_id'] = Auth::user()->id;
    		if($ip->ip_status == 1){//IP使用状态为1即子IP时根据业务编号进行查找
    			$business['business_number'] = $ip->own_business;
    		} elseif($ip->ip_status == 2 || $ip->ip_status == 3) {//IP使用状态为主IP时即2或者3时，根据机器编号进行查找
    			$business['machine_number'] = $ip->mac_num;
    		} else {//IP使用状态为未使用即0时直接返回
    			$return['data'] = '';
	    		$return['code'] = 0;
	    		$return['msg'] = '您暂未购买此IP使用';
	    		return $return;
    		}
    		//根据前面的条件进行查找IP绑定的机器编号
    		$machine_number = DB::table('tz_business')->where($business)->value('machine_number');
    		if($machine_number){//存在机器编号返回机器编号
    			$return['data'] = $machine_number;
    			$return['code'] = 1;
    			$return['msg'] = 'IP绑定的机器获取成功';
    		} else {//不存在机器编号时直接返回
    			$return['data'] = '';
	    		$return['code'] = 0;
	    		$return['msg'] = '该IP赞未绑定机器无法';
    		}
    	} else {//IP库中未找到对应数据时直接返回
    		$return['data'] = '';
    		$return['code'] = 0;
    		$return['msg'] = 'IP地址不存在';
    	}
    	return $return;
    }

    /**
     * 取消白名单操作
     * @param  array $id 对应的id
     * @return array     返回相关的状态及提示信息
     */
    public function cancelWhiteList($id){
    	if($id){
    		$where['id'] = $id['cancel_id'];
    		$row = $this->where($where)->update(['white_status'=>4]);
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '白名单申请取消成功';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '白名单申请取消失败';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '白名单申请无法取消';
    	}
    	return $return;
    }
}
