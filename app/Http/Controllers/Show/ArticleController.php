<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{

    public function new_list($sid,$page)
    {
        // $new_connection = DB::connection('mysql_oldoa');
        // $new = $new_connection->table('news')->where('sid', $sid)->orderBy('status', 'desc')->orderBy('createdate', 'desc')->paginate(8);
        $new = DB::table('tz_news')
                ->where('tid', $sid)
                ->whereNull("deleted_at")
                ->orderBy('top_status', 'desc')
                ->orderBy('created_at', 'desc')
                ->select(
                    'id as newsid',
                    'tid as sid',
                    'title as titles',
                    'content',
                    'top_status as status',
                    'home_status as newsstatus',
                    'created_at as createdate',
                    'seoKeywords',
                    'seoTitle',
                    'seoDescription',
                    'digest',
                    'updated_at',
                    'list_order',
                    'deleted_at'
                )
                ->paginate(8);
        $new->withPath($page);
        return $new;
    }
    public function content($id)
    {
        // $new_connection = DB::connection('mysql_oldoa');
        // $new = $new_connection->table('news')->where('newsid',$id)->first();
        $new = DB::table('tz_news')->where('id',$id)->select(
            'id as newsid',
            'tid as sid',
            'title as titles',
            'content',
            'top_status as status',
            'home_status as newsstatus',
            'created_at as createdate',
            'seoKeywords',
            'seoTitle',
            'seoDescription',
            'digest',
            'updated_at',
            'list_order',
            'deleted_at'
        )->first();
        return $new;
    }
    public function prev_content($id,$type)
    {
        $prev_id = $id + 1;
        // $new_connection = DB::connection('mysql_oldoa');
        // $new = $new_connection->table('news')->where('newsid',$prev_id)->first();
        $new = DB::table('tz_news')->where('id',$prev_id)->select(
            'id as newsid',
            'tid as sid',
            'title as titles',
            'content',
            'top_status as status',
            'home_status as newsstatus',
            'created_at as createdate',
            'seoKeywords',
            'seoTitle',
            'seoDescription',
            'digest',
            'updated_at',
            'list_order',
            'deleted_at'
        )->first();
        return $new;
    }
    public function next_content($id,$type)
    {
        $next_id = $id - 1;
        // $new_connection = DB::connection('mysql_oldoa');
        // $new = $new_connection->table('news')->where('newsid',$next_id)->first();
        $new = DB::table('tz_news')->where('id',$next_id)->select(
            'id as newsid',
            'tid as sid',
            'title as titles',
            'content',
            'top_status as status',
            'home_status as newsstatus',
            'created_at as createdate',
            'seoKeywords',
            'seoTitle',
            'seoDescription',
            'digest',
            'updated_at',
            'list_order',
            'deleted_at'
        )->first();
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
            "company" => "????????????",
            "placard" => "????????????",
            "industry" => "????????????"
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
            "title" => $type_contents_code[$type]."-IDC????????????-????????????[????????????]",
            "description" => $type_contents_code[$type]."??????????????????????????????????????????????????????????????????????????????????????????,??????IP???CDN,???????????????,??????????????????????????????????????????????????????????????????IDC?????????",
            "keywords" => $type_contents_code[$type].",????????????,????????????,????????????,????????????"
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
                    //     "content" => "????????????",
                    //     "template" => "http.listArticleTemplate.list"
                    // ],
                    // [
                    //     "name" => "industry",
                    //     "content" => "????????????",
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
            "title" => $newList[$type]->seoTitle,
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
                        "content" => "????????????"
                    ],
                    [
                        "name" => "placard",
                        "url" => "/article/placard",
                        "content" => "????????????"
                    ],
                    [
                        "name" => "industry",
                        "url" => "/article/industry",
                        "content" => "????????????"
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
    public function shine_upon($item)
    {
        $result = [];
        $result["newsid"] = $item->id;
        $result["sid"] = $item->tid;
        $result["titles"] = $item->title;
        $result["content"] = $item->content;
        $result["status"] = $item->top_status;
        $result["newsstatus"] = $item->home_status;
        $result["seoKeywords"] = $item->seoKeywords;
        $result["seoTitle"] = $item->seoTitle;
        $result["seoDescription"] = $item->seoDescription;
        $result["digest"] = $item->digest;
        $result["createdate"] = $item->created_at;
        $result["updated_at"] = $item->updated_at;
        $result["list_order"] = $item->list_order;
        $result["deleted_at"] = $item->deleted_at;
        return $result;
    }
}
