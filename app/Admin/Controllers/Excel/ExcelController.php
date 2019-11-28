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

	/**
	*这个是改的,可以弄多个单元表
	*	$cellArr = [
	*		0 => [
	*			'cellData'	=> [
	*				0 => ['昵称','性别','头像'],
	*				1 => ['AAA','男','aaa'],
	*				2 => ['BBB','女','bbb'],
	*				3 => ['CCC','女','ccc'],
	*				4 => ['DDD','男','ddd'],
	*			],
	*			'cellName'	=> '单元表名',
	*		],
	*		1 => [
	*			'cellData'	=> [],
	*			'cellName'	=> 'xxx',
	*		],
	*	];
	*	$cellName = excel文件名
	* Excel导出
	*/

	public function kiriExcel($cellArr,$cellName)
	{
		ini_set('memory_limit','500M');
		set_time_limit(0);//设置超时限制为0分钟
		

		for($i=0;$i<count($cellArr);$i++){
			for ($j=0; $j < count($cellArr[$i]); $j++) { 
				$cellArr[$i]['cellData'][$j] = array_values($cellArr[$i]['cellData'][$j]);
				$cellArr[$i]['cellData'][$j][0] = str_replace('=',' '.'=',$cellArr[$i]['cellData'][$j][0]);
			}
		}
		//dd($cellData);
		Excel::create($cellName,function($excel) use ($cellArr){

			for ($i=0; $i < count($cellArr); $i++) { 
				$excel->sheet($cellArr[$i]['cellName'] , function($sheet) use ($cellArr,$i){
					$sheet->rows($cellArr[$i]['cellData']);
				});
			}
		})->export('xls');
		die;
	}
}


?>