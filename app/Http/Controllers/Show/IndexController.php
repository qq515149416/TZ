<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Admin\Models\News\CarouselModel;

class IndexController extends Controller
{
    public function new_list($sid)
    {
        // $new_connection = DB::connection('mysql_oldoa');
        $new = DB::table('tz_news')->where('tid', $sid)->orderBy('created_at', 'desc')->select(
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
        )->get();
        return $new;
    }
    public function index()
    {
        return view("http/index",[
            "company_news" => $this->new_list(2),
            "company_announcement" => $this->new_list(1),
            "industry_news" => $this->new_list(3),
            "carousels" => CarouselModel::where('type',1)->orderBy('order', 'desc')->get()
        ]);
    }
}
