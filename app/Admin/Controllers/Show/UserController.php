<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class UserController extends Controller
{
    protected function script()
    {
        return <<<SCRIPT
let myScript = document.querySelector('script[src*="tz_assets/bundle.js"]');
let script = document.createElement("script");
script.type="text/javascript";
script.src="/tz_assets/bundle.js";
console.log('测试');
document.body.replaceChild(script,myScript);
SCRIPT;
    }
    public function index()
    {   
        return Admin::content(function (Content $content) {
            $content->header('用户列表');
            $content->description('用户的信息');
            $content->body(view('show/index'));
            Admin::script($this->script());
        });
    }
}
