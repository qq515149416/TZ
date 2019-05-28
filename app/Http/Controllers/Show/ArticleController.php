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
    public function content($id)
    {
        $new_connection = DB::connection('mysql_oldoa');
        $new = $new_connection->table('news')->where('newsid',$id)->first();
        return $new;
    }
    public function prev_content($id,$type)
    {
        $prev_id = $id + 1;
        $new_connection = DB::connection('mysql_oldoa');
        $new = $new_connection->table('news')->where('newsid',$prev_id)->first();
        return $new;
    }
    public function next_content($id,$type)
    {
        $next_id = $id - 1;
        $new_connection = DB::connection('mysql_oldoa');
        $new = $new_connection->table('news')->where('newsid',$next_id)->first();
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
        $type_contents_code = [
            "company" => "公司动态",
            "placard" => "公司公告",
            "industry" => "行业动态"
        ];
        $nav = [
            [
                "name" => "company",
                "url" => "/article/company",
                "content" => $type_contents_code["company"]
            ],
            [
                "name" => "placard",
                "url" => "/article/placard",
                "content" => $type_contents_code["placard"]
            ],
            [
                "name" => "industry",
                "url" => "/article/industry",
                "content" => $type_contents_code["industry"]
            ]
        ];
        $tdk = [
            "title" => $type_contents_code[$type]."[腾正科技]",
            "description" => "专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。",
            "keywords" => "云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商"
        ];
        return view($template,[
            "tdk" => $tdk,
            "type" => $type,
            "data" => $newList,
            "list" => [
                "nav"=>$nav,
                "content_list" => [
                    [
                        "name" => $type,
                        "content" => $type_contents_code[$type],
                        "template" => "http.listArticleTemplate.list"
                    ]
                    // [
                    //     "name" => "placard",
                    //     "content" => "公司公告",
                    //     "template" => "http.listArticleTemplate.list"
                    // ],
                    // [
                    //     "name" => "industry",
                    //     "content" => "行业动态",
                    //     "template" => "http.listArticleTemplate.list"
                    // ]
                ]
            ]
        ]);
    }
    public function detail($type,$id)
    {

        $template = "http/article";
        $type_code = [
            "company" => 2,
            "placard" => 1,
            "industry" => 3
        ];
        $reverse_type_code = [
            "2" => "company",
            "1" => "placard",
            "3" => "industry"
        ];
        $newList = [
            $type => $this->content($id)
        ];
        $tdk = [
            "title" => $newList[$type]->titles,
            "description" => $newList[$type]->seoDescription,
            "keywords" => $newList[$type]->seoKeywords
        ];
        return view($template,[
            "tdk" => $tdk,
            "type" => $type,
            "data" => $newList,
            "reverse_type" => $reverse_type_code,
            "prev_data" => $this->prev_content($id,$type_code[$type]),
            "next_data" => $this->next_content($id,$type_code[$type]),
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
                        "name" => $type,
                        "template" => "http.listArticleTemplate.detail"
                    ]
                ]
            ]
        ]);
    }
}
