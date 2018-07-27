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
        //判断机房编号是否存在
        if ($this->where('machine_room_id', '=', $roomId)->exists()) {
            return '机房编号已存在';
        }

        //判断机房名称是否存在
        if ($this->where('machine_room_name', '=', $roomName)->exists()) {
            return '机房名称已经存在';
        }


        $data = $this->where('machine_room_id', '=', $roomId)->exists();
        if ($data) {
            dd($data);
        }
//        return $data;
//        return 'su';
    }

}