<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Autoloader;
use PHPSocketIO\SocketIO;

class TestController extends Controller 
{	
	public function user(Request $request) {
		
	}
	public function socket(Request $request){
		return tz_ajax_echo(Admin::user(),"获取成功",1);
		
	}

    public function index()
    {
        return view("show/test");
    }
}
