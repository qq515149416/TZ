<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function new_list($sid,$page)
    {
        $new_connection = DB::connection('mysql_oldoa');
        $new = $new_connection->table('news')->where('sid', $sid)->orderBy('status', 'desc')->orderBy('createdate', 'desc')->paginate(8);
        $new->withPath($page);
        return $new;
    }
    public function index($type)
    {
        $template = "http/article";
        $newList = [
            "company" => $this->new_list(2,"company"),
            "placard" => $this->new_list(1,"placard"),
            "industry" => $this->new_list(3,"industry")
        ];
        return view($template,[
            "type" => $type,
            "data" => $newList
        ]);
    }
}
