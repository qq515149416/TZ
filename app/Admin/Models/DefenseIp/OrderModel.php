<?php 
 
 
namespace App\Admin\Models\DefenseIp; 
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth; 
 
class OrderModel extends Model 
{ 
	use SoftDeletes; 
	 
 
	protected $table = 'tz_orders'; //表 
	protected $primaryKey = 'id'; //主键 
	public $timestamps = true; 
	protected $dates = ['deleted_at']; 
	protected $fillable = ['order_sn', 'business_sn','customer_id','customer_name','business_id','business_name','resource_type','order_type','machine_sn','resource','price','duration','payable_money','achievement','end_time','serial_number','pay_time']; 
 
	/** 
	 *  新购 高防IP 接口  /  选取购买信息后,生成订单信息  
	 */ 
	public function buyNow($package_id,$buy_time,$customer_id){ 
 
		 
	} 
 
	public function renewOrder($data){ 
		$res = $this->create($data); 
		return $res; 
	} 
 
	 
}