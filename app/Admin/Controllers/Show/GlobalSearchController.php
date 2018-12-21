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
        $headers = [
            'id',
            '业务号',
            '客户',
            '业务员',
            '机器编号',
            '单价',
            '时长',
            '开始时间',
            '到期时间',
            '业务类型',
            '业务状态'
        ];
        $rows = [
        ];
        foreach($result as $k=>$v) {
            array_push($rows,[
                $v["business_number"],
                $v["client_name"],
                $v["sales_name"]
            ]);
        }

        $table = new Table($headers, $rows);
        $box = new Box($search.'的查询结果', $table);

        $box->style('default');

        $box->solid();
        return $box;
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
