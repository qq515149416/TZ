<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MachineRoom extends Model
{
    use SoftDeletes;

    //表名
    protected $table = 'idc_machineroom';

    //设置主键
    public $primaryKey = 'id';

    //定义软删除 字段
    protected $dates = ['delete_at'];


    /**
     * 根据机房编号,机房名称生成机房 记录
     *
     * @param $roomId
     * @param $roomName
     * @return mixed
     */
    public function store($roomId, $roomName,$departId)
    {
        //判断机房编号是否存在
        if ($this->where('machine_room_id', '=', $roomId)->exists()) {
            $res['content'] = '';
            $res['message'] = '机房编号已存在';
            $res['state']   = 0;
            return $res;
        }

        //判断机房名称是否存在
        if ($this->where('machine_room_name', '=', $roomName)->exists()) {
            $res['content'] = '';
            $res['message'] = '机房名字已存在';
            $res['state']   = 0;
            return $res;
        }

        //判断管理机房的部门是否已绑定其他机房
        if ($this->where('list_order', '=', $departId)->exists()) {
            $res['content'] = '';
            $res['message'] = '此部门已管理其他机房';
            $res['state']   = 0;
            return $res;
        }

        $this->machine_room_id   = $roomId;
        $this->machine_room_name = $roomName;
        $this->list_order = $departId;

        $insertInfo = $this->save();
        //添加机房记录
        if ($insertInfo) {
            $insertInfo->list_order = $this->machineroom($departId);
            $res['content'] = $insertInfo;
            $res['message'] = '添加机房成功';
            $res['state']   = 1;
            return $res;
        } else {
            $res['content'] = $insertInfo;
            $res['message'] = '添加机房失败';
            $res['state']   = 0;
            return $res;
        }

    }

    /**
     * 查询列表数据
     *
     *
     */
    public function show()
    {
        $res = $this->all();
        if(!$res->isEmpty()){
            foreach ($res as $key => $value) {
                $res[$key]['list_order'] = $this->machineroom($value['list_order']);
            }
        }
        return $res;
    }

    /**
     * 获取机房多选列表
     */
    public function showSelectList()
    {
        $listData = $this->select('id', 'machine_room_name')->get();


        return $listData;
    }


    /**
     * 根据机房id查询机房中文名称
     */
    public function queryMachineRoomName($id = '')
    {

        $data = $this->where('id', $id)->select('machine_room_name')->first();

        return $data;

    }

    /**
     * 获取机房管理部门的部门名称
     * @param  [type] $machineroom_id [description]
     * @return [type]                 [description]
     */
    public function machineroom($machineroom_id){
        $department = DB::table('tz_department')->where(['id'=>$machineroom_id])->value('depart_name');
        return $department;
        
    }

}