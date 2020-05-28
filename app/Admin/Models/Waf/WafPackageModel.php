<?php


namespace App\Admin\Models\Waf;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\DefenseIp\OrderModel; //后台高防ip的订单模型
use App\Admin\Models\Business\OrdersModel; //后台的订单支付模型
// use App\Admin\Models\DefenseIp\BusinessModel;

use Carbon\Carbon;
//use App\Http\Controllers\DefenseIp\ApiController;


class WafPackageModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_waf_package'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'description','https_switch','web_switch','cc_switch','domain_num','sell_status','price'];
	protected $time_limit = 60;//两次购买的时间限制

	/**
	 *
	 */
	public function insert($par){
		$check = $this->where('name',$par['name'])->exists();
		
		if($check){
			return [
				'data'	=> [],
				'msg'	=> '已存在同名套餐',
				'code'	=> 0,
			];
		}

		if($this->create($par)){
			return [
				'data'	=> [],
				'msg'	=> '创建成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '创建失败',
				'code'	=> 0,
			];
		}
	}
	
	public function del($del_id){
		$pac = $this->find($del_id);
		if($pac == null){
			return [
				'data'	=> [],
				'msg'	=> '不存在',
				'code'	=> 0,
			];
		}
		$del_res = $pac->delete();
		if($del_res){
			return [
				'data'	=> [],
				'msg'	=> '删除成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '删除失败',
				'code'	=> 0,
			];
		}
	}

	public function edit($par){
		if (isset($par['name'])) {
			$check = $this->where('name',$par['name'])->value('id');
			if($check){
				if ($check != $par['edit_id']) {
					return [
						'data'	=> [],
						'msg'	=> '已存在同名套餐',
						'code'	=> 0,
					];
				}	
			}
		}

		$pac = $this->find($par['edit_id']);
		if($pac == null){
			return [
				'data'	=> [],
				'msg'	=> '不存在',
				'code'	=> 0,
			];
		}
		$edit_res = $pac->update($par);

		if($edit_res){
			return [
				'data'	=> [],
				'msg'	=> '编辑成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '编辑失败',
				'code'	=> 0,
			];
		}
	}

	public function show($par){

		if ($par['sell_status'] == '*') {
			$pac = $this->get();
		}else{
			$pac = $this->where('sell_status',$par['sell_status'])->get();
		}
				
		if($pac->isEmpty()){
			return [
				'data'	=> [],
				'msg'	=> '无此状态套餐',
				'code'	=> 1,
			];
		}else{
			foreach ($pac as $k => $v) {
				$v = $this->trans($v);
			}
			return [
				'data'	=> $pac,
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
		}
	}

	public function trans($pac){
		switch ($pac->sell_status) {
			case '0':
				$pac->sell_status = '下架中';
				break;
			case '1':
				$pac->sell_status = '上架中';
				break;
			default:
				$pac->sell_status = '未知状态';
				break;
		}
		switch ($pac->web_switch) {
			case '0':
				$pac->web_switch = '不允许';
				break;
			case '1':
				$pac->web_switch = '允许';
				break;
			default:
				$pac->web_switch = '未知状态';
				break;
		}
		switch ($pac->https_switch) {
			case '0':
				$pac->https_switch = '不允许';
				break;
			case '1':
				$pac->https_switch = '允许';
				break;
			default:
				$pac->https_switch = '未知状态';
				break;
		}
		switch ($pac->cc_switch) {
			case '0':
				$pac->cc_switch = '不允许';
				break;
			case '1':
				$pac->cc_switch = '允许';
				break;
			default:
				$pac->cc_switch = '未知状态';
				break;
		}
		switch ($pac->ip_switch) {
			case '0':
				$pac->ip_switch = '不允许';
				break;
			case '1':
				$pac->ip_switch = '允许';
				break;
			default:
				$pac->ip_switch = '未知状态';
				break;
		}
		return $pac;
	}

	
}