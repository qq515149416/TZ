<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function new_list($sid)
    {
        $new_connection = DB::connection('mysql_oldoa');
        $new = $new_connection->table('news')->where('sid', $sid)->orderBy('createdate', 'desc')->paginate(8);
        return $new;
    }
    public function index($type)
    {
        $template = "http/article";
        $newList = [
            "company" => $this->new_list(2),
            "placard" => $this->new_list(1),
            "industry" => $this->new_list(3)
        ];
        return view($template,[
            "type" => $type,
            "data" => $newList
        ]);
    }
}
