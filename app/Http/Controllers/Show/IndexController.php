<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function new_list($sid)
    {
        $new_connection = DB::connection('mysql_oldoa');
        $new = $new_connection->table('news')->where('sid', $sid)->orderBy('createdate', 'desc')->get();
        return $new;
    }
    public function index()
    {
        return view("http/index",[
            "company_news" => $this->new_list(1),
            "company_announcement" => $this->new_list(2),
            "industry_news" => $this->new_list(3)
        ]);
    }
}
