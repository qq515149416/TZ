<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InfoController extends Controller
{
    //

    public function getInfo()
    {
        $info = Auth::user();
        return tz_ajax_echo($info,'获取成功',1);
    }
}
