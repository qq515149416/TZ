<?php

namespace App\Admin\Controllers\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Excel;

class ExcelController extends Controller
{
	/**
	 *这个是excel需要的数组的格式
	*	$cellData = [
	*		0 => ['昵称','性别','头像'],
	*		1 => ['AAA','男','aaa'],
	*		2 => ['BBB','女','bbb'],
	*		3 => ['CCC','女','ccc'],
	*		4 => ['=DDD','男','ddd'],
	*	];
	*	$cellName = 导出文件名
	* Excel导出
	*/

	public function export($cellData,$cellName)
	{
		ini_set('memory_limit','500M');
		set_time_limit(0);//设置超时限制为0分钟
		

		for($i=0;$i<count($cellData);$i++){
			$cellData[$i] = array_values($cellData[$i]);
			$cellData[$i][0] = str_replace('=',' '.'=',$cellData[$i][0]);
		}
		//dd($cellData);
		Excel::create($cellName,function($excel) use ($cellData){
			$excel->sheet('score', function($sheet) use ($cellData){
				$sheet->rows($cellData);
			});
		})->export('xls');
		die;
	}
}


?>