<?php

namespace App\Console\Commands;


use Illuminate\Support\Facades\DB;
use App\Admin\Models\DefenseIp\BusinessModel;
use App\Http\Controllers\DefenseIp\ApiController;
use App\Http\Models\DefenseIp\OverlayBelongModel;

use Illuminate\Console\Command;

/**
 * 将过期业务修改为过期续续费状态
 *
 * Class OverdueDJB
 * @package App\Console\Commands
 */
class OverdueDJB extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'overlay:check-overlay-endtime';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '检测已使用的叠加包的到期时间,将过期的改状态并将附加的防御值去掉';

	/**
	 * Create a new command instance.
	 * 创建
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 * 执行
	 *
	 * @return mixed
	 */
	public function handle()
	{

		$this->info($this->delPastOverlay());  //删除过期订单

	}


	/**
	 * 
	 *
	 *
	 *
	 */
	public function delPastOverlay()
	{

		$model = new OverlayBelongModel();
		//当前date
		$now = date("Y-m-d H:i:s");
		//获取正在生效且已过期叠加包
		$pastOverlay = $model->where('status',1)
				->where('end_time','<',$now)
				->get();
		if ($pastOverlay->isEmpty()) {
			return 0;
		}
		$num = 0;

		//循环每个此类叠加包
		foreach ($pastOverlay as $k => $v) {

			//检测是否存在于高防业务表
			$checkDIP = BusinessModel::where('business_number',$v->target_business)->first();
  			if ($checkDIP) {
  				$res = $this->delPastDIP($v);	//调用高防下架方法
				if($res){		//成功的话,num+1
					$num++;
				}
  			}else{	//查查看idc
  				$checkIDC = DB::table('tz_orders')->where('order_sn' , $v->target_business)->first(['machine_sn' , 'business_sn','resource_type']);
				if ($checkIDC != null) {
					$res = $this->delPastIDC($v);	//调用idc里下架的方法
					if ($res) {
						$num++;
					}
					
				}
  			}

  			//别管这段
			// $type = DB::table('tz_business_relevance')->where('business_id',$v->target_business)->value('type');
			// if ($type == 2) {	//如果是高防业务
			// 	$res = $this->delPastDIP($v);	//调用高防下架方法
			// 	if($res){
			// 		$num++;
			// 	}
			// }	
		}   
		return $num;    
	}

	/**
	 * 
	 *
	 *
	 *
	 */
	protected function delPastDIP($v){
		DB::beginTransaction();
		$v->status = 2;
		//更改状态
		if ( $v->save() ) {     //更改状态成功
			//获取叠加包的防御值
			$protection_value = DB::table('tz_overlay')->where('id',$v->overlay_id)->value('protection_value');
			//获取业务信息tz_defenseip_business
			$business = BusinessModel::where('business_number',$v->target_business)->first();
			//获取业务原本防御值
			$d_ip = DB::table('tz_defenseip_store')->where('id',$business->ip_id)->whereNull('deleted_at')->first();
			
			if($protection_value == null || $business == null || $d_ip == null){    //如果获取失败
				DB::rollBack();
				return false;
			}else{              //获取成功的话就减掉

				//原有防御值
				$ori_protection_value = $d_ip->protection_value;    
				//去除掉过期叠加包防御值后的额外防御值
				$extra_protection = bcsub($business->extra_protection, $protection_value,0);
				if ($extra_protection < 0 ) {
					$extra_protection = 0;
				}

				//更新业务里的额外防御值
				$business->extra_protection = $extra_protection;
				if ( !$business->save() ) {
					DB::rollBack();
					return false;
				}else{
					//更新现在的牵引值
					$after_protection = bcadd($ori_protection_value, $extra_protection,0);
					$api_controller = new ApiController();
					//$res = $api_controller->setProtectionValue($d_ip->ip,$after_protection);
					$res = $api_controller->setProtectionValue('1.1.1.1',0);
					if ($res != 'editok' && $res !='ok') {
						DB::rollBack();
						return false;
					}else{
						DB::commit();   
						return true;	
					}
				}
			}

		}else{
			DB::rollBack();
			return false;
		}
	}


	public function delPastIDC($v)
	{
		DB::beginTransaction();
		
		//获取叠加包的防御值
		$all_protection_value = DB::table('tz_overlay_belong as a')
					->leftjoin('tz_overlay as b','a.overlay_id','=','b.id')
					->where(['a.target_business'=>$v->target_business,'a.status'=>1])
					->sum('b.protection_value');

		$protection_value = DB::table('tz_overlay')->where('id',$v->overlay_id)->value('protection_value');
	
		if($protection_value == null || $all_protection_value == null){    //如果获取失败
			DB::rollBack();
			return false;
		}else{              //获取成功的话就减掉

			//去除掉过期叠加包防御值后的额外防御值
			$after_protection = bcsub($all_protection_value, $protection_value,0);
			if ($after_protection < 0 ) {
				$after_protection = 0;
			}

			$idc = DB::table('tz_orders')->where('order_sn' , $v->target_business)->first(['machine_sn' , 'business_sn','resource_type']);

			if ($idc != null) {
				if($idc->resource_type == 4){		//如果找出来是副ip,直接获取
					$ip = $idc->machine_sn;
				}elseif ($idc->resource_type == 1||$idc->resource_type == 2) {	//如果找出来是主机,去业务表的详情处找
					$business = DB::table('tz_business')->where('business_number',$idc->business_sn)->first(['resource_detail']);
					if ($business == null) {
						$ip = false;
					}else{
						$resource_detail = json_decode($business->resource_detail,true);
						$ip = $resource_detail['ip'];
					}
				}else{
					$ip = false;
				}
			}else{
				$ip = false;
			}
			if ($ip == false) {
				DB::rollBack();
				return false;
			}

			$api_controller = new ApiController();
			$v->status = 2;
			if (!$v->save()) {
				DB::rollBack();
				return false;
			}
			//$res = $api_controller->setProtectionValue($ip,$after_protection);
			$res = $api_controller->setProtectionValue('1.1.1.1',0);
			if ($res != 'editok' && $res !='ok') {
				DB::rollBack();
				return false;
			}else{
				DB::commit();   
				return true;	
			}
		}
	}
}
