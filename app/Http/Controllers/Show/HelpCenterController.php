<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;


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
        return view("http/helpCenter",[
            "nav_main" => HelpCategoryModel::where([
                "parent_id" => 0,
                "status" => 1
            ])->get(),
            "template" => "http.help.collection",
            "nav" => HelpCategoryModel::where($where)->get(),
            "list_data" => $helpContentsModel
        ]);
    }
    public function category($id)
    {
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
            ])->get(),
            "template" => "http.help.list"
        ]);
    }
    public function detail($id)
    {

    }
}
