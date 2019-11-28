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
	protected $fillable = ['img', 'link','title','top','digest','end_at','pro_order','start_at'];  


	/**
	 * 获取指定状态的促销活动
	 *	*	-所有的
	 *	top 	-置顶的正在进行的
	 *	0 	-已结束的
	 *	1 	-正在进行的
	 *	2 	-未开始的
	 */
	public function getPro($need){
		//获取当前date
		$now = date("Y-m-d H:i:s");

		//根据所需选择对应sql  ,  用start_at 和 end_at 与 当前date进行比较获取
		switch ($need) {
			case '*':		//所有的促销活动
				$pro = $this->orderBy('pro_order','desc')->get();
				break;
			case 'top':	//置顶的正在进行的促销活动
				$pro = $this->where('top',1)->where('start_at','<',$now)->where('end_at','>',$now)->orderBy('pro_order','desc')->get();
				break;
			case '0':		//已结束的促销活动
				$pro = $this->where('end_at','<',$now)->orderBy('pro_order','desc')->get();
				break;
			case '1':		//正在生效的促销活动
				$pro = $this->where('start_at','<',$now)->where('end_at','>',$now)->orderBy('pro_order','desc')->get();
				break;
			case '2':		//还没开始的促销活动
				$pro = $this->where('start_at','>',$now)->orderBy('pro_order','desc')->get();
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
		//渲染数据
		foreach ($pro as $k => $v) {
			$v = $this->trans($v);
		}
		return [
			'data'	=> $pro,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}


	/**
	 * 渲染数据
	 */
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

		return $pro;
	}
}
