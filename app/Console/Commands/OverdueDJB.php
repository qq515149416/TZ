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
		$now = date("Y-m-d H:i:s");

		/**
		 * 获取所有生效的且到期的叠加包根据绑定的业务进行分组
		 * @var [type]
		 */
		$belong = $model->where(['status'=>1])->where('end_time','<',$now)->get(['target_business'])->groupBy('target_business');

		if($belong->isEmpty()){
			return '暂无生效且过期的叠加包';
		}

		$target_business = array_keys($belong->toArray());//获取绑定叠加包的所有业务(剔除了重复的)

		if(empty($target_business)){
			return '暂无绑定的业务';
		}

		$messages = '更新完成';
		foreach ($target_business as $key => $value) {
			$ip = '1.1.1.1';
			$protected = 0;
			$type = 0;
			$gfbusiness = BusinessModel::where(['business_number'=>$value])->value('ip_id');//获取高防业务所绑定的高防IP库的id值
			if(empty($gfbusiness)){//叠加包绑定IDC

				$data = $this->getIDC($value);
				$ip = $data['ip'];
				$protected = $data['protected'];

			} else {//叠加包绑定高防IP

				$ip_store = DB::table('tz_defenseip_store')->where(['id'=>$gfbusiness->ip_id])
								->whereNull('deleted_at')
								->select('ip','protection_value')
								->first();
				if(!empty($ip_store)){
					$ip = $ip_store->ip;
					$protected = $ip_store->protection_value;
					$type = 1;
				}

			}
			//正在生效的某个业务绑定的叠加包的总防护值 
			$all_protected_value = $model->join('tz_overlay','tz_overlay_belong.overlay_id','=','tz_overlay.id')
									->where(['status'=>1,'target_business'=>$value])
									->sum('protection_value');

			//某个业务正在绑定的叠加包过期的总防护值
			$end_protected_value = $model->join('tz_overlay','tz_overlay_belong.overlay_id','=','tz_overlay.id')
									->where(['status'=>1,'target_business'=>$value])
									->where('end_time','<',$now)
									->sum('protection_value');
			//有效的叠加包防护值
			$protection_value = bcsub($all_protected_value,$end_protected_value,0);
			//最后包含原本的总防御值
			$protected = bcadd($protection_value, $protected,0);
			
			DB::beginTransaction();

			//对高防业务的额外防护值字段进行更新
			if($type == 1){
				$row = DB::table('tz_defenseip_business')->where(['business_number'=>$value])->update(['export_extra_protection'=>$protection_value]);
				if($row == 0){
					DB::rollBack();
					$messages = $value.'绑定的叠加包防御值未更新';
					break;
				}
			}

			//叠加包业务状态进行改变
			$update_status = $model->where(['status'=>1,'target_business'=>$value])
									->where('end_time','<',$now)
									->update(['status'=>2]);
			if($update_status ==0){
				DB::rollBack();
				$messages = $value.'绑定的叠加包防御值未更新';
				break;
			}

			/**
			 * 进行防护值的更新
			 * @var ApiController
			 */
			$api = new ApiController();
			$result = $api->setProtectionValue($ip,$protected);
			if ($result != 'editok' && $result !='ok') {
				DB::rollBack();
				break;
			} else {
				DB::commit();
			}
			
		}
		return $messages;
			
	}

	/**
	 * 获取IDC业务的IP和原本防护值
	 * @param  string $order_sn 订单号
	 * @return [type]           [description]
	 */
	public function getIDC($order_sn){

		$idcbusiness = DB::table('tz_orders')->where(['order_sn'=>$order_sn])
								 ->whereNull('deleted_at')
								 ->select('business_sn','resource_type','machine_sn')
								 ->first();
		if(empty($idcbusiness)){
			$return['ip'] = '1.1.1.1';
			$return['protected'] = 0;
			return $return;
		}

		if($idcbusiness->resource_type == 1 || $idcbusiness->resource_type == 2){//主机的查询主IP和防护值
			$resource_detail = json_decode(DB::table('tz_business')->where(['business_number'=>$idcbusiness->business_sn])->value('resource_detail'));
			$return['ip'] = $resource_detail->ip;
			$return['protected'] = $resource_detail->protect;
		} elseif($idcbusiness->resource_type == 4) {//副IP直接绑定IP
			$return['ip'] = $idcbusiness->machine_sn;
			$return['protected'] = 0;
		} else {
			$return['ip'] = '1.1.1.1';
			$return['protected'] = 0;
		}
		
		return $return;
	}

}
	