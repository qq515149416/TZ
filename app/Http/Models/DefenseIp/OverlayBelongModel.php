<?php


namespace App\Http\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class OverlayBelongModel extends Model
{

	use SoftDeletes;


	protected $table = 'tz_overlay_belong'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['overlay_id', 'user_id','buy_time','status','use_time','end_time','order_sn','target_business','price'];

    /**
     * 修改状态名称.
     *
     * @return string
     */
    public function getStatusTextAttribute($value)
    {
        $status_text = [
            "0" => "未使用",
            "1" => "生效中",
            "2" => "已使用完毕"
        ];
        if(array_key_exists($this->status,$status_text)) {
            return $status_text[$this->status];
        } else {
            return "未知状态";
        }
    }

}
