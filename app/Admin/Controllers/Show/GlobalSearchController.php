<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Box;
use Illuminate\Http\Request;
use App\Admin\Controllers\Search\SearchController;

class GlobalSearchController extends Controller
{
    public function result($search='')
    {
        $searchController = new SearchController();
        $result = $searchController->doSearch($search);
        // client_id=29&client_name=cai&business_number=120181220579&machine_number=JG_0002&machineroom_id=37
        // client_id=29&client_name=cai&business_number=320181221478&machine_number=JG_0002&machineroom_id=37
        // $result = [
        //     [
        //         'id'=>1,
        //         'business_number'=>'320181221478',
        //         'client_name'=>'dsseed',
        //         'sales_name'=>'bbbb',
        //         'machine_number'=>'TZ-dev',
        //         'ip'=>['194.150.23.1','33.44.123.4','120.44.23.1'],
        //         'money'=>100,
        //         'length'=>'6个月',
        //         'start_time'=>'2018-12-21',
        //         'endding_time'=>'2019-01-21',
        //         'type'=>'租用',
        //         'status'=>'未付款',
        //         'protect' => '100',
        //         'bandwidth' => '10',
        //         'client_id' => '29',
        //         'machineroom_id' => '37'
        //     ],
        //     [
        //         'id'=>2,
        //         'business_number'=>'120181220579',
        //         'client_name'=>'dssddeed',
        //         'sales_name'=>'bbbbbb',
        //         'machine_number'=>'TZ-dev1',
        //         'ip'=>['154.120.23.1','22.10.189.4','12.33.24.1'],
        //         'money'=>100,
        //         'length'=>'6个月',
        //         'start_time'=>'2018-12-21',
        //         'endding_time'=>'2019-01-21',
        //         'type'=>'租用',
        //         'status'=>'已付款',
        //         'protect' => '100',
        //         'bandwidth' => '10',
        //         'client_id' => '29',
        //         'machineroom_id' => '37'
        //     ]
        // ];
        $headers = [
            'id',
            '业务号',
            '客户',
            '业务员',
            '机器编号',
            'IP',
            '单价',
            '时长',
            '开始时间',
            '到期时间',
            '业务类型',
            '业务状态',
            '防护',
            '带宽'
        ];
        $rows = [
        ];
        foreach($result as $k=>$v) {
            array_push($rows,[
                "id" => $v["id"],
                "business_number" => $v["business_number"],
                "client_name" => $v["client_name"],
                "sales_name" => $v["sales_name"],
                "machine_number" => $v["machine_number"],
                "ip" => $v["ip"],
                "money" => $v["money"],
                "length" => $v["length"],
                "start_time" => $v["start_time"],
                "endding_time" => $v["endding_time"],
                "type" => $v["type"],
                "status" => $v["status"],
                "protect" => $v["protect"],
                "bandwidth" => $v["bandwidth"]
            ]);
        }

        // $table = new Table($headers, $rows);
        // $box = new Box($search.'的查询结果', $table);

        // $box->style('default');

        // $box->solid();
        return view("show/globalSearch",[
            "title" => $search.'的查询结果',
            "headers" => $headers,
            "data" => $rows,
            "result" => $result
        ]);
    }
    public function index(Request $request)
    {
        $this->search = $request->input('search');
        return Admin::content(function (Content $content) {
            $content->header('搜索数据');
            $content->body($this->result($this->search));
        });
    }
}
