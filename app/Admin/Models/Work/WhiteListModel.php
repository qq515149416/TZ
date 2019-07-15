<?php

namespace App\Admin\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Facades\Admin;
use App\Admin\Controllers\Work\ApiController;
use App\Admin\Models\DefenseIp\BusinessModel;
use App\Admin\Models\Idc\Ips;

use App\Admin\Models\Business\BusinessModel as IdcBusinessModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WhiteListModel extends Model
{
	use  SoftDeletes;
	protected $table = 'tz_white_list';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['white_number', 'white_ip','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit','submit_note','check_id','check_number','check_time','check_note','white_status'];

	/**
	 * 查询ip地址是否使用中
	 * @param  $ip
	 * @return [type]        [description]
	 */
	public function checkIP($ip){
		// *****	这段暂时弃用,数据有bug不能这么查
			
		// 前往IP库查找对应传入IP的状态
		// $idc_ip = Ips::where('ip',$ip)->select('id','ip_status','ip_lock','own_business')->first();
		// $idc_ip = $idc_ip->toArray();
		// $return['data']	= '';
		// $return['code']	= 0;
		// //判断IP的获取情况,返回失败信息
		// if($idc_ip == NULL){	
		// 	$return['msg']	= 'IP地址不存在';		
		// 	return $return;
		// }
	
		// if($idc_ip['ip_status'] == 0){
		// 	$return['msg']	= '该IP尚未启用';		
		// 	return $return;
		// }
		
		// //用获取的业务编号,前往业务表查找对应的机器编号及客户ID
		// $business = DB::table('tz_business')->where('business_number',$idc_ip['own_business'])->select('client_id','machine_number','business_status')->first();

		// *****

		/****	这段临时补上	****/
		//idc业务里查
		//查查主IP有没有
		$business = IdcBusinessModel::leftJoin('idc_machine as b' , 'b.machine_num' , '=' , 'tz_business..machine_number')
						->leftJoin('idc_ips as c' , 'c.id' , '=' , 'b.ip_id')
						->where(['c.ip' => $ip])
						->whereNull('c.deleted_at')
						->whereNull('b.deleted_at')
						->WhereIn('tz_business.business_status' , [1,2])
						->first(['tz_business.client_id','tz_business.machine_number']);

		//如果主IP没有,去订单表查副ip
		if($business == null){
			$business = IdcBusinessModel::leftJoin('tz_orders as c' , 'c.business_sn' , '=' , 'tz_business.business_number')
						->where(['c.machine_sn' => $ip , 'c.remove_status' => 0])
						->whereNull('c.deleted_at')
						->WhereIn('tz_business.business_status' , [1,2])
						->first(['tz_business.client_id','tz_business.machine_number']);
		}


		/****	end	****/
		if($business != NULL){	//如果idc里有
			

			$info['machine_number']	= $business->machine_number;
			$info['customer_id']		= $business->client_id;
			//根据获得的客户ID查找客户可用信息
			$customer = DB::table('tz_users')->where('id',$info['customer_id'])->select('name','email','nickname')->first();
			if($customer == NULL){
				$return['msg']	= '客户id错误';		
				return $return;
			}
			$info['customer_name'] 	= $customer->nickname;
			$info['email']		= $customer->email;
		}else{			//查查高防有没有

		
			$business = BusinessModel::leftJoin('tz_defenseip_store as b' , 'b.id' , '=' , 'tz_defenseip_business.ip_id' )
							->where(['b.ip' => $ip ])
							->whereIn('tz_defenseip_business.status' , [1,4])
							->whereNull('b.deleted_at')
							->first(['tz_defenseip_business.business_number' , 'tz_defenseip_business.user_id']);

			if($business == null){
				return [
					'data'	=> [],
					'msg'	=> '业务编号不存在',
					'code'	=> 0,
				];
			}
			$info['machine_number']	= $business->business_number;
			$info['customer_id']		= $business->user_id;

			$customer = DB::table('tz_users')->where('id',$info['customer_id'])->select('name','email','nickname')->first();
			if($customer == NULL){
				$return['msg']	= '客户id错误';		
				return $return;
			}
			$info['customer_name'] 	= $customer->nickname?$customer->nickname:$customer->name;
			$info['email']		= $customer->email;
		}
		
		$return['data'] 	= $info;
		$return['msg']	= '获取成功';
		$return['code']	= 1;
		
		return $return;
	}
	
	/**
	 * 根据条件查出对应状态的白名单信息
	 * @param  array $where 白名单的状态条件
	 * @return [type]        [description]
	 */
	public function showWhiteList($where){
		//获取模型
		$result = $this->where($where)
			->orderBy('created_at','desc')
			->get(['id','white_ip','white_number','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit','submit_note','check_id','check_number','check_time','check_note','white_status','created_at']);
		//返回
		if(!$result->isEmpty()){
			//转换信息
			$submit = [1=>'客户提交',2=>'内部提交'];
			$white_status = [0=>'审核中',1=>'审核通过',2=>'审核不通过',3=>'黑名单',4=>'取消'];
			foreach($result as $key=>$value){
				$result[$key]['submittran'] = $submit[$value['submit']];
				$result[$key]['status'] = $white_status[$value['white_status']];
			}
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '获取白名单信息成功';
		} else {
			$return['data'] = $result;
			$return['code'] = 0;
			$return['msg'] = '无信息';
		}
		return $return;

	}

	/**
	 *提交白名单信息
	 * @param  array $insertdata  要提交的白名单数据
	 * @return [type]             [description]
	 */
	public function insertWhiteList($insertdata){
		
		$pattern = '/^((http){1}|w{3}|\W)/i';//意思是以  http  | www  |  非单词字符即 a-z A-Z 0-9的字符/

		$res = preg_match($pattern,$insertdata['domain_name'],$match);

		if( $res){
			return [
				'data'	=> [],
				'msg'	=> '域名格式错误,勿填 : http:// ; https ; www ; / ;',
				'code'	=> 0,
			];
		}

		// 创建白名单编号
		$whitenumber = create_number();
		$insertdata['white_number'] 	= $whitenumber;
		// 当前登陆用户的信息，作为提交者信息
		$check = $this->checkIP($insertdata['white_ip']);
		if($check['code'] != 1){
			return $check;
		}
		if($check['data']['customer_name'] == null){
			$insertdata['customer_name']	= $check['data']['email'];
		}else{
			$insertdata['customer_name']	= $check['data']['customer_name'];
		}		

		$insertdata['customer_id'] 	= $check['data']['customer_id'];
		$insertdata['binding_machine']	= $check['data']['machine_number'];
		$admin_id 			= Admin::user()->id;
		$fullname 			= Admin::user()->name?Admin::user()->name:Admin::user()->username;
		$insertdata['submit_id'] 	= $admin_id;			
		$insertdata['submit_name'] 	= $fullname;	
		$insertdata['submit'] 		= 2;			// 提交方
		$insertdata['white_status'] 	= 0;			//待审核
		//查找是否存在已提交过的申请单

		$check = $this->where('domain_name',$insertdata['domain_name'])->select(['white_status','white_ip'])->get();
		//根据审核状态返回信息
		foreach ($check as $k => $v) {
			$return = [
				'data'	=> '',
				'code'	=> 0,
			];
			//曾经被拉黑过就不能再提交
			if($v->white_status == 3){
				$return['msg']	= '该域名已被拉黑';
				return $return;
			}

			if($v->white_status == 1 ){
				if($v->white_ip == $insertdata['white_ip']){
					$return['msg']	= '该域名审核申请单已通过,请勿重复提交';
					return $return;	
				}
			}
			if($v->white_status == 0 ){
				if($v->white_ip == $insertdata['white_ip']){
					$return['msg']	= '该域名审核申请单正在审核中,请勿重复提交';
					return $return;	
				}
			}			
		}

		$row = $this->create($insertdata);
		
		if($row != false){
			$return['data'] = $row->id;
			$return['code'] = 1;
			$return['msg'] = '白名单审核申请提交成功';
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '白名单审核申请提交失败';
		}
		
		return $return;
	}

	/**
	 * 白名单审核
	 * @param  array $checkdata 审核的信息
	 * @return [type]            [description]
	 */
	public function checkWhiteList($checkdata){

		//获取审核单信息
		$row = $this->find($checkdata['id']);
		if($row == null){
			return [
				'data'	=> $row,
				'msg'	=> '审核单不存在',
				'code'	=> 2,
			];
		}
		//如果审核单已经审核过
		if($row->white_status != 0){
			return [
				'data'	=> $row,
				'msg'	=> '该单已审核',
				'code'	=> 0,
			];
		}

		//获取审核者信息
		$admin_id = Admin::user()->id;
		$fullname = (array)$this->staff($admin_id);
		if(count($fullname) == 0){
			return [
				'data'	=> $row,
				'msg'	=> '审核人员信息不完整,请填写完整再进行审核',
				'code'	=> 0,
			];
		}
		//如果要通过审核,就要有备案编号
		if($row->record_number == null && $checkdata['white_status'] == 1 && !isset($checkdata['record_number'])){
			return [
				'data'	=> $row,
				'msg'	=> '若需通过,请填写备案编号',
				'code'	=> 0,
			];
		}
		
		//更新审核单信息
		$row->check_id 	= $admin_id;
		$row->check_number	= $fullname['work_number'];

		$row->check_time 	= date('Y-m-d H:i:s',time());
		$row->white_status 	= $checkdata['white_status'];
		if(isset($checkdata['record_number'])){
			$row->record_number 	= $checkdata['record_number'];
		}
		if(isset($checkdata['check_note'])){
			$row->check_note 	= $checkdata['check_note'];
		}

		DB::beginTransaction();//开启事务处理

		$save_res = $row->save($checkdata);
		if(!$save_res){
			DB::rollBack();
			return [
				'data'	=> $row,
				'msg'	=> '白名单审核失败',
				'code'	=> 0,
			];
			return $return;	
		}
		//判断审核状态,如果是不通过,就直接返回审核结果
		if($checkdata['white_status'] == 2){
			DB::commit();
			return [
				'data'	=> $row,
				'msg'	=> '审核成功',
				'code'	=> 1,
			];		
		}

		if ($checkdata['white_status'] == 1) {
			//没添加过就开始添加通行证
			$api_controller = new ApiController();
			$room_id = DB::table('idc_ips')->where('ip',$row->white_ip)->whereNull('deleted_at')->value('ip_comproom');
			//$room_id = 78;
			if($room_id == null){
				DB::rollBack();
				return[
					'data'	=> $row,
					'msg'	=> 'ip无绑定机房',
					'code'	=> 0,	
				];
			}

			//更改状态成功,开始调用API塞到白名单的数据库
			$domain = $row->domain_name;
			$insert_res = $api_controller->createWhiteList($domain,$room_id);
			// $insert_res = [ 'code' => 1];
			if($insert_res['code'] != 1){
				DB::rollBack();
				return $insert_res;
			}
			DB::commit();
			$return = [
				'data'	=> $row,
				'msg'	=> '审核成功,已为域名添加通行证',
				'code'	=> 1,
			];
			return $return;
		}elseif ($checkdata['white_status'] == 3) {
			//如果审核结果是拉黑的话
			
			
			// $api_controller = new ApiController();
			// $room_id = DB::table('idc_ips')->where('ip',$already[$i]['white_ip'])->whereNull('deleted_at')->value('ip_comproom');
		
			// if($room_id == null){
			// 	DB::rollBack();
			// 	return[
			// 		'data'	=> '',
			// 		'msg'	=> 'ip无绑定机房',
			// 		'code'	=> 0,	
			// 	];
			// }
			// // 预留黑名单的接口
			// // $del_res = $api_controller->delWhiteList($domain,$room_id);
			// //这个正式上线需要替换
			// $del_res = [
			// 	'code'	=> 1,
			// ];
			// if($del_res['code'] != 1){
			// 	DB::rollBack();
			// 	return[
			// 		'data'	=> '',
			// 		'msg'	=> '拉黑失败',
			// 		'code'	=> 0,	
			// 	];
			// }	
			DB::commit();
			return[
				'data'	=> $row,
				'msg'	=> '拉黑成功',
				'code'	=> 1,	
			];	
		}					
	}

	/**
	 * 批量审核白名单接口
	 * @param
	 */
	public function checkWhiteListBatch($checkdata){
	
		$data = [
			'white_status'	=> $checkdata['white_status'],
			'check_note'	=> isset($checkdata['check_note'])?$checkdata['check_note']:null,
		];
		$fail_list = [];
		foreach ($checkdata['id_list'] as $k => $v) {
			$data['id'] = $v;
			$res = $this->checkWhiteList($data);
			if ($res['code'] == 0) {
				$fail_list[] = [
					'domain_name'	=> $res['data']->domain_name,
					'reason'		=> $res['msg'],
				];
			}elseif ($res['code'] == 2) {
				$fail_list[] = [
					'domain_name'	=> 'id 为' . $v,
					'reason'		=> $res['msg'],
				];
			}
		}

		if (count($fail_list) == 0) {
			return [
				'data'	=> [],
				'msg'	=> '所有申请审核成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> $fail_list,
				'msg'	=> '以下申请审核失败',
				'code'	=> 0,
			];
		}
	}
	
	

	/**
	 * 删除白名单信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteWhitelist($id){
		$white = $this->find($id);
		if($white == null){
			return [
				'data'	=> [],
				'msg'	=> '白名单不存在',
				'code'	=> 0,
			];
		}
		
		//如果是已通过的白名单,那么从白名单库里去掉
		$swi = 0;
		$api_controller = new ApiController();
		if ($white[0]->white_status == 1) {
			$room_id = DB::table('idc_ips')->where('ip',$white[0]->white_ip)->whereNull('deleted_at')->value('ip_comproom');
			$api_res = $api_controller->delWhiteList($white[0]->domain_name , $room_id);
			if ($api_res['code'] != 1) {
				return $api_res;
			}
			$swi = 1;
		}

		$row = $white[0]->delete();
		if($row != false){
			if ($swi == 1) {
				return [
					'data'	=> [],
					'msg'	=> '删除信息成功,已删除库内该白名单',
					'code'	=> 1,
				];
			}else{
				return [
					'data'	=> [],
					'msg'	=> '删除信息成功',
					'code'	=> 1,
				];
			}
			
		} else {
			return [
				'data'	=> [],
				'msg'	=> '删除信息失败',
				'code'	=> 0,
			];
		}
	}


	/**
	 * 内部提交时根据用户账号的id查找出对应的账户的真实姓名
	 * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
	 * @return string           返回对应账户的真实姓名
	 */
	public function staff($admin_id) {
		$staff = DB::table('oa_staff')->where('admin_users_id',$admin_id)
					->select('work_number')
					->whereNull('deleted_at')
					->first();
		return $staff;
	}


	/**
	 * 下载excel模板
	 * @return [type] [description]
	 */
	public function excelTemplate(){
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->setTitle('白名单申请批量导入表格');
		$worksheet->setCellValueByColumnAndRow(1, 1, '白名单申请批量导入表格');
		$worksheet->getRowDimension('1')->setRowHeight(26);//头行高
		// $row_value = ['IP(必填)','域名(必填)','备案编号(必填)','机器编号(必填)','客户姓名(必填)','备注(选填)'];//填写的字段
		// $row = $worksheet->fromArray($row_value,NULL,'A4');//分配字段从A4开始填写（横向）
		$worksheet->setCellValue('A4', 'IP(必填)')
		            ->setCellValue('B4', '域名(必填)')
		            ->setCellValue('C4', '备案编号(必填)')
		            ->setCellValue('D4', '备注(选填)');

		$highest_row = $worksheet->getHighestRow();//总行数
		$highest_colum = $worksheet->getHighestColumn();//总列数

		//标题样式
		$title_font = [
			'font' => [
				'bold' => true,//加粗
				'size' => '20px',//字体大小
			],
			'alignment' => [//内容居中
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
		];
		$worksheet->mergeCells('A1:'.$highest_colum.'1')->getStyle('A1:'.$highest_colum.'1')->applyFromArray($title_font);//设置标题样式
		//说明内容
		$worksheet->getCell('A2')->setValue("填写说明:按要求填上就好,高防的填个业务编号上去也行,你们自己看得懂就好,备注选填,别的都得填");
		$worksheet->getStyle('A2')->getFont()->applyFromArray(['bold'=>TRUE,'size'=>'12px']);//说明内容样式
		$worksheet->getRowDimension('2')->setRowHeight(26);//说明内容行高
		$worksheet->mergeCells('A2:'.$highest_colum.'3')->getStyle('A2:'.$highest_colum.'3')->getAlignment()->setWrapText(true);//说明内容自动换行
		//设置字段宽度
		for($i='A';$i<=$highest_colum;$i++){
			$worksheet->getColumnDimension($i)->setWidth(16);
		}

		/**
		 * 下载模板
		 * @var [type]
		 */

		$filename = '白名单申请批量导入表格模板.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);
		exit;
	}

	/**
	 * 处理上传excel批量添加白名单申请
	 * @return 
	 */
	public function handleExcel($file){
		//获取操作人员信息
		$admin_user 	= Admin::user();

		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');//读取excel文件
		$spreadsheet = $reader->load($file->getRealPath());//加载文件
		$worksheet = $spreadsheet->getActiveSheet();//获取表格的活动区域
		// $highest_colum = $worksheet->getHighestColumn();//获取总的列数
		$sheet = $spreadsheet->getSheet(0);   //excel中的第一张sheet
		$highest_row = $sheet->getHighestRow();       // 取得总行数
		// $highest_column = $sheet->getHighestColumn();   // 取得总列数

		//如果没填东西就返回错误
		if($highest_row < 5){
			return [
				'data'	=> [],
				'msg'	=> '请填写内容',
				'code'	=> 0,
			];
		}
		//对比下列标题对不对得上
		$arr = [
			'A'	=> 'IP(必填)',
			'B'	=> '域名(必填)',
			'C'	=> '备案编号(必填)',
			'D'	=> '备注(选填)',
		];
		//比对列标题
		for ($i = 'A'; $i  <= 'D' ; $i ++) { 
			$title = $worksheet->getCell($i . '4')->getValue();

			if($title != $arr[$i]){
				return [
					'data'	=> [],
					'msg'	=> '请下载最新excel表格并按格式填写',
					'code'	=> 0,
				];
			}
		}		

		//失败数组
		$fail_list = [];
		//开关
		$swi = 0;
		for($k = 5 ; $k <= $highest_row ; $k++){//转换列名
			//获取信息
			$insertdata = [
				'white_ip'		=> $worksheet->getCell('A' . $k)->getValue(),
				'domain_name'		=> $worksheet->getCell('B' . $k)->getValue(),
				'record_number'	=> $worksheet->getCell('C' . $k)->getValue(),
				'submit_note'		=> $worksheet->getCell('D' . $k)->getValue(),
			];
			//一条条怼进去
			$insert_res = $this->insertWhiteList($insertdata);

			//如果怼失败了就返回失败信息
			if($insert_res['code'] == 0){
				//如果 有失败的,开关变1
				$swi = 1;
				$fail_list[] = [
					'ip'		=> $insertdata['white_ip'],
					'domain_name'	=> $insertdata['domain_name'],
					'reason'		=> $insert_res['msg'],
				];
			}
			
		}

		if ($swi == 0) {	//没有失败的
			return [
				'data'	=> [],
				'msg'	=> '所有申请提交成功',
				'code'	=> 1,
			];
		}else{		//有失败的
			return [
				'data'	=> $fail_list,
				'msg'	=> '以下申请提交失败',
				'code'	=> 0,
			];
		}
		
	}	

	
}
