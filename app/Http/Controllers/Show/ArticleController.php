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
            "data" => $newList,
            "list" => [
                "nav"=>[
                    [
                        "name" => "company",
                        "url" => "/article/company",
                        "content" => "公司动态"
                    ],
                    [
                        "name" => "placard",
                        "url" => "/article/placard",
                        "content" => "公司公告"
                    ],
                    [
                        "name" => "industry",
                        "url" => "/article/industry",
                        "content" => "行业动态"
                    ]
                ],
                "content_list" => [
                    [
                        "name" => "company",
                        "content" => "公司动态",
                        "template" => "http.listArticleTemplate.list"
                    ],
                    [
                        "name" => "placard",
                        "content" => "公司公告",
                        "template" => "http.listArticleTemplate.list"
                    ],
                    [
                        "name" => "industry",
                        "content" => "行业动态",
                        "template" => "http.listArticleTemplate.list"
                    ]
                ]
            ]
        ]);
    }
    public function detail($type,$id)
    {
        return "类型是：$type,ID是$id";
    }
}
