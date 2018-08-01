<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MachineRoom extends Model
{
    //表名
    protected $table = 'idc_machineroom';

    /**
     * 根据机房编号,机房名称生成机房 记录
     *
     * @param $roomId
     * @param $roomName
     * @return mixed
     */
    public function store($roomId, $roomName)
    {
//        //判断机房编号是否存在
//        if ($this->where('machine_room_id', '=', $roomId)->exists()) {
//            $res['content'] = '';
//            $res['message'] = '机房编号已存在';
//            $res['state']   = 0;
//            return $res;
//        }
//
//        //判断机房名称是否存在
//        if ($this->where('machine_room_name', '=', $roomName)->exists()) {
//            $res['content'] = '';
//            $res['message'] = '机房名字已存在';
//            $res['state']   = 0;
//            return $res;
//        }


        $this->machine_room_id = '';
        $this->machine_room_name = '123';

        $insertInfo=$this->save();
        //添加机房记录
        if (1) {
            $res['content'] = $insertInfo;
            $res['message'] = '添加机房成功';
            $res['state']   = 1;
            return $res;
        }

    }

}