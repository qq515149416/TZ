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

class GlobalSearchController extends Controller
{
    public function result()
    {

        $headers = ['Id', 'Email', 'Name', 'Company'];
        $rows = [
            [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 'Goodwin-Watsica'],
            [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 'Murphy, Koepp and Morar'],
            [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 'Kihn LLC'],
            [4, 'xet@yahoo.com', 'William Koss', 'Becker-Raynor'],
            [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.'],
        ];
        $table = new Table($headers, $rows);
        $box = new Box('查询结果', $table);

        $box->style('default');

        $box->solid();
        return $box;
    }
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('搜索数据');
            $content->body($this->result());
        });
    }
}
