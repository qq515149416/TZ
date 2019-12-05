<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;
use Illuminate\Http\Request;


class HelpCenterController extends Controller
{
    public function index($page=NULL)
    {
        $helpContentsModel = new HelpContentsModel();
        $where = [
            ["parent_id", "<>" , 0],
            ["status", "=", 1]
        ];
        if($page) {
            $where = [
                ["parent_id", "=" , $page],
                ["status", "=", 1]
            ];
        }
        $helpTagModel = new HelpTagModel();
        return view("http/helpCenter",[
            "nav_main" => HelpCategoryModel::where([
                "parent_id" => 0,
                "status" => 1
            ])->get(),
            "template" => "http.help.collection",
            "nav" => HelpCategoryModel::where($where)->paginate(10),
            "list_data" => $helpContentsModel,
            "tags" => $helpTagModel->orderBy("search_count","desc")->limit(5)->get()
        ]);
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $result = HelpTagModel::where("name","like","%$keyword%")->get();
        HelpTagModel::where("name","like","%$keyword%")->increment("search_count");
        $data = [];
        foreach($result as $key=>$val)
        {
            array_push($data,$val->content);
        }
        $helpTagModel = new HelpTagModel();
        return view("http/helpCenter",[
            "nav_main" => HelpCategoryModel::where([
                "parent_id" => 0,
                "status" => 1
            ])->get(),
            "keyword" => $keyword,
            "data" => $data,
            "template" => "http.help.list",
            "tags" => $helpTagModel->orderBy("search_count","desc")->limit(5)->get()
        ]);
    }
    public function category($id)
    {
        $helpTagModel = new HelpTagModel();
        return view("http/helpCenter",[
            "nav_main" => HelpCategoryModel::where([
                "parent_id" => 0,
                "status" => 1
            ])->get(),
            "nav" => HelpCategoryModel::where([
                "id" => $id
            ])->first(),
            "data" => HelpContentsModel::where([
                "category_id" => $id
            ])->paginate(10),
            "template" => "http.help.list",
            "tags" => $helpTagModel->orderBy("search_count","desc")->limit(5)->get()
        ]);
    }
    public function detail($id)
    {
        $data = HelpContentsModel::where([
            "id" => $id
        ])->first();
        $helpTagModel = new HelpTagModel();
        return view("http/helpCenter",[
            "nav_main" => HelpCategoryModel::where([
                "parent_id" => 0,
                "status" => 1
            ])->get(),
            "data" => $data,
            "recommend" => HelpContentsModel::where("category_id",$data->category_id['id'])->get(),
            "next_data" => HelpContentsModel::where("id",">",$id)->first(),
            "prev_data" => HelpContentsModel::where("id","<",$id)->orderBy('id', 'desc')->first(),
            "template" => "http.help.content",
            "tags" => $helpTagModel->orderBy("search_count","desc")->limit(5)->get()
        ]);
    }
}
