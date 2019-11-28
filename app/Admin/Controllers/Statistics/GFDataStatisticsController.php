<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 统计业绩用控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-09-06 15:47:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Models\DefenseIp\XADefenseDataModel;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Statistics\PfmStatistics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Admin\Requests\Statistics\PfmStatisticsRequest;
use Encore\Admin\Facades\Admin;
use App\Admin\Controllers\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

//TODO 测试高防数据导出
class GFDataStatisticsController extends Controller
{


    public function index()
    {

//        dump(date("Y-m-d H:i",'1554866993') );
        $test = new XADefenseDataModel();

        $testData = $test->select('id','time','bandwidth_down','upstream_bandwidth_up')
            ->where('ipaddress','=','113.141.163.129')
            ->where('bandwidth_down','!=','0')
            ->whereBetween('time',['1556640000','1557072000' ])
            ->orderBy('time','desc')
            ->get(['time','bandwidth_down','upstream_bandwidth_up'])
            ->toArray();


        $this->excel($testData);
//        $this->excel($testData);
//        $this->excel($testData);

//        dump($testData);




    }


    private function excel($data)
    {
//        $spreadsheet = new Spreadsheet();
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->setTitle('表1');
        $row_value = ['序号', '北京时间', '入口流量', '出口流量'];//填写的字段


        $j = 2;
        foreach ($data as $k => $v) {
//            dump($v['already']);//已付款
            $worksheet->setCellValueByColumnAndRow(1, $j, $v['id']);
            $worksheet->setCellValueByColumnAndRow(2, $j, date("Y-m-d H:i",$v['time']));
            $worksheet->setCellValueByColumnAndRow(3, $j, $v['bandwidth_down']);
            $worksheet->setCellValueByColumnAndRow(4, $j, $v['upstream_bandwidth_up']);
//            $worksheet->setCellValueByColumnAndRow(5, $j, $v['not']);
            $j++;
        }


        $filename = '4月1-4月10.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        exit;

    }

}
