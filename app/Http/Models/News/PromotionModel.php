<?php

namespace App\Http\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class PromotionModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_promotion';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['img', 'link','title','top','digest','end_at','pro_order','sale_status'];  

	public function getPro($need){
		switch ($need) {
			case '*':
				$pro = $this->orderBy('pro_order','asc')->get();
				break;
			case 'top':
				$pro = $this->where('top',1)->orderBy('pro_order','asc')->get();
				break;
			case '0':
				$pro = $this->where('sale_status',0)->orderBy('pro_order','asc')->get();
				break;
			case '1':
				$pro = $this->where('sale_status',1)->orderBy('pro_order','asc')->get();
				break;
			case '2':
				$pro = $this->where('sale_status',2)->orderBy('pro_order','asc')->get();
				break;
			default:
				return [
					'data'	=> [],
					'msg'	=> '请填写正确需求',
					'code'	=> 0,
				];
				break;
		}

		if ($pro->isEmpty()) {
			return [
				'data'	=> [],
				'msg'	=> '无数据',
				'code'	=> 1,
			];
		}
		foreach ($pro as $k => $v) {
			$v = $this->trans($v);
		}
		return [
			'data'	=> $pro,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}


	protected function trans($pro){

		$pro->img = json_decode($pro->img);
		$pro->link = json_decode($pro->link);
		switch ($pro->top) {
			case '0':
				$pro->top = "不置顶";
				break;
			case '1':
				$pro->top = "置顶";
				break;
			default:
				$pro->top = "未知状态";
				break;
		}
		switch ($pro->sale_status) {
			case '0':
				$pro->sale_status = "活动结束";
				break;
			case '1':
				$pro->sale_status = "在售";
				break;
			case '2':
				$pro->sale_status = "预备中";
				break;
			default:
				$pro->sale_status = "未知状态";
				break;
		}
		return $pro;
	}
}
