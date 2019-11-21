<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;
use Illuminate\Http\Request;

class BusinessController extends script
{
    private function queryUrlParam($arr)
    {
        $str = "";
        foreach($arr as $key=>$val) {
            $str = $str.$key."=".$val."&";
        }
        return "?".substr($str,0,strlen($str)-1);
    }
    public function index(Request $request)
    {
        return Admin::content(function (Content $content) {
            global $request;
            $content->header('业务管理');
            $content->description('业务操作');
            $content->breadcrumb(
                ['text' => '客户管理', 'url' => '/show/crm/clientele'],
                ['text' => '业务管理']
            );
            // $request->session()->flash("url_param",$this->queryUrlParam($request->all()));
            session(["url_param"=>$this->queryUrlParam($request->all())]);
            session(["url_param_json"=>$request->all()]);
            // dump(session("url_param"));
            $content->body(view('show/app'));
            // Admin::script($this->script());
        });
    }
}
