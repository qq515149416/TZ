<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\NavModel;
use App\Admin\Models\News\ForeignModel;
use App\Admin\Models\News\MachineRoomModel;

use Illuminate\Http\Request;

class OverseasController extends Controller
{
    public function index($page="",$room="",Request $request)
    {
        if(!$page || $page=="index") {
            $nav_id = NavModel::where('alias','like','%turtle%')->first()->id;
            $nav_data = NavModel::find($nav_id);
            return view("http/overseas",[
                "son_nav" => NavModel::where('parent_id',$nav_data->id)->get(),
                "data" => ForeignModel::all()
            ]);
        } else {
            $nav_id = NavModel::where('alias','like','%'.$page.'%')->first()->id;
            $nav_data = NavModel::find($nav_id);
            if(!$room) {
                $room = $nav_data->machineRooms()->first()->alias;
            }
            $current_room = $nav_data->machineRooms()->where("alias",$room)->first();
            return view("http/overseas_product",[
                "page" => $page,
                "son_nav" => NavModel::where('parent_id',$nav_data->parent_id->id)->get(),
                "machine_rooms" => $nav_data->machineRooms()->get(),
                "room" => $room,
                "current_room" => $current_room,
                "data" => ForeignModel::where("machine_room_id",$current_room->id)->where("nav_id",$nav_data->id)->get()
            ]);
        }
    }
}
