<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

// use Illuminate\Support\Facades\DB;

class GfPromotionController extends Controller
{
    public function index()
    {
        // global $where;
        // $where = '599912913@qq.com';
        // $table = 'tz_users';
        // $dd = DB::table($table)->orWhere('name',$where)->when(DB::raw("IF COL_LENGTH('$where',N'nickname') IS NULL"),function ($query) {
        //      $query->orWhere('email', $GLOBALS['where'])
        //           ->orWhere('nickname', $GLOBALS['where']);
        // })->first();
        // // $dd = DB::table($table)->orWhere('name',$where)->orWhere('nickname', $where)->orWhere('email', $where)->first();
        // dd($dd);
        return view("http/gfPromotion");
    }
}
