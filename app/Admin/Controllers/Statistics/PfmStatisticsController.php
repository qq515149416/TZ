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
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Statistics\PfmStatistics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Admin\Requests\Statistics\PfmStatisticsRequest;
use Encore\Admin\Facades\Admin;
use App\Admin\Controllers\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class PfmStatisticsController extends Controller
{
    use ModelForm;

    /**
     * 查找统计表的相关信息
     * @param    
     * @return    json 返回相关的信息
     */
    public function index(PfmStatisticsRequest $request)
    {

        $par      = $request->only(['begin', 'end', 'business_type', 'customer_id']);
        $pfmModel = new PfmStatistics();
        switch ($par['business_type']) {
            //区分查询的业务类型,1-idc;2-高防ip
            case '1':
                if (isset($par['customer_id'])) {
                    $return = $pfmModel->getIdcStatisticsBigByUser($par['begin'], $par['end'], $par['customer_id']);
                } else {
                    $return = $pfmModel->getIdcStatisticsBig($par['begin'], $par['end']);
                }
                break;
            case '2':
                if (isset($par['customer_id'])) {
                    $return = $pfmModel->getDefenseipStatisticsBigByUser($par['begin'], $par['end'], $par['customer_id']);
                } else {
                    $return = $pfmModel->getDefenseipStatisticsBig($par['begin'], $par['end']);
                }
                break;
            default:
                return tz_ajax_echo('', '请选择正确业务类型', 0);
                break;
        }

        return tz_ajax_echo($return['data'], $return['msg'], $return['code']);
    }

    public function pfmSmall(PfmStatisticsRequest $request)
    {
        $par     = $request->only(['begin', 'end', 'business_type']);
        $user_id = Admin::user()->id;

        $pfmModel = new PfmStatistics();

        switch ($par['business_type']) {
            //区分查询的业务类型,1-idc;2-高防ip
            case '1':
                $return = $pfmModel->getIdcStatisticsSmall($par['begin'], $par['end'], $user_id);
                break;
            case '2':
                $return = $pfmModel->getDefenseipStatisticsSmall($par['begin'], $par['end'], $user_id);
                break;
            default:
                return tz_ajax_echo('', '请选择正确业务类型', 0);
                break;
        }
        return tz_ajax_echo($return['data'], $return['msg'], $return['code']);
    }

    public function test(PfmStatisticsRequest $request)
    {
        $par = $request->only(['begin', 'end']);
        
        $begin = '2019-03-01 00:00:00';
        $end   = '2019-03-31 23:59:59';

        $pfmModel = new PfmStatistics();
        $res      = $pfmModel->test($begin, $end);


        $this->excel($res);

//        return tz_ajax_echo($res, '统计完成', 1);
    }





    private function excel($data)
    {
//        $spreadsheet = new Spreadsheet();
        $spreadsheet = new Spreadsheet();
        $worksheet   = $spreadsheet->getActiveSheet();
        $worksheet->setTitle('机器批量导入表格');
        $row_value = ['用户账号', '用户邮箱', '用户昵称', '3月已付款', '3月未付款'];//填写的字段



        $j=2;
        foreach ($data as $k => $v) {
//            dump($v['already']);//已付款
            $worksheet->setCellValueByColumnAndRow(1, $j,  $v['customer_nickname']);
            $worksheet->setCellValueByColumnAndRow(2, $j,  $v['customer_name']);
            $worksheet->setCellValueByColumnAndRow(3, $j,  $v['customer_email']);
            $worksheet->setCellValueByColumnAndRow(4, $j,  $v['already']);
            $worksheet->setCellValueByColumnAndRow(5, $j,  $v['not']);
            $j++;
        }


        $filename = '月统计.xlsx';
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
