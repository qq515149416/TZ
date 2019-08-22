<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    public function index()
    {
        return "这是手机版";
    }
}
