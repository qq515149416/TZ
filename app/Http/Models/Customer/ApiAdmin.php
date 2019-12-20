<?php 
 
 
namespace App\Http\Models\Customer; 
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Facades\DB; 

use App\Http\Models\Customer\WhiteListModel;
class ApiAdmin extends Model 
{ 
	use SoftDeletes; 
	 
 
	protected $table = 'tz_api'; //表 
	protected $primaryKey = 'id'; //主键 
	public $timestamps = true; 
	protected $dates = ['deleted_at']; 
	protected $fillable = ['user_id', 'state','api_key','api_secret']; 


	/** 
	 *  按状态查看白名单
	 * @param 
	 * @return 
	 */ 
	public function showWhiteList($white_status){ 

		$model = new WhiteListModel();
		$list = $model->where('white_status',$white_status)->get(['id','domain_name','record_number','white_ip','binding_machine','customer_name']);

		if(!$list->isEmpty()){
			$list = $list->toArray();
			
			return [
				'data'	=> $list,
				'code'	=> 1,
			];

		} else {
			return [
				'data'	=> [],
				'code'	=> 0,
			];
		}

	
	}



}