<?php

namespace App\Admin\Models\TzUsers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use XS;
use XSDocument;

class TzUsers extends Model
{
    protected $table = 'tz_users';


    /**
     * 获取用户信息
     *
     * @return mixed
     */
    public function getUserInfo($uId)
    {


//        $userId = 2203; //测试用户的ID

        //根据用户ID获取相关信息
        $userInfo = $this
            ->where('id', $uId)
            ->select('id', 'msg_phone', 'msg_qq', 'remarks', 'email', 'name', 'money','nickname')
            ->get();

        return $userInfo;

    }


    /**
     * 更新用户信息
     *
     * 需要先判断用户是否存在
     *
     */
    public function updateUserInfo($updateData)
    {
        $userId = 2203;//用于测试的用户ID

        $res = $this
            ->where('id', $updateData['uid'])
            ->update([
                'msg_phone' => $updateData['msg_phone'],
                'msg_qq'=>$updateData['msg_qq'],
                'remarks'=>$updateData['remarks'],
                'name'  => $updateData['name'],
                'nickname' => $updateData['nickname'],
            ]);
        if($res != 0){
            $xunsearch    = new XS('customer');
            $index        = $xunsearch->index;
            $doc['id']    = strtolower($updateData['uid']);
            $doc['name'] = strtolower($updateData['name']);
            $doc['nickname'] = strtolower($updateData['nickname']);
            $document     = new \XSDocument($doc);
            $index->update($document);
            $index->flushIndex();
        }
        return $res;

    }

}