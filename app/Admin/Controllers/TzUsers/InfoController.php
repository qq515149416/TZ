<?php


namespace App\Admin\Controllers\TzUsers;

use App\Admin\Models\TzUsers\TzUsers;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\Ips;
use App\Admin\Requests\Business\TzUserRequest;
use Illuminate\Http\Request;

class InfoController extends Controller
{


    /**
     * 后台管理获取用户信息
     * 用于显示用户 手机号码 QQ号码 备注信息
     *
     * 接口 ：/tz_admin/users/getUserInfo
     * 类型 ：POST
     *
     * 参数：
     *   uid   用户ID
     *
     * 返回参数：
     *      id         用户ID
     *      msg_phone  用户联系信息
     *      msg_qq     用户QQ
     *      remarks    此用户的备注信息
     *      email      邮箱
     *      name       登陆名
     *      money      余额
     *      nickname   用户昵称
     */
    public function getUserInfo(Request $request)
    {

        $uId = $request->all()['uid'];//获取用户ID

//        $uId =2203;

        $TzUsersM = new TzUsers();//实例化用户模型

        return tz_ajax_echo($TzUsersM->getUserInfo($uId), '获取用户信息成功', 1);


    }


    /**
     * 更新用户信息
     *
     * 接口： /tz_admin/users/updateUserInfo
     * 类型：POST
     *
     * 参数：
     *   uid        用户id
     *   msg_phone  用户手机号码 （仅用于后台显示）
     *   msg_qq     用户QQ号码   （仅用于后台显示）
     *   remarks    用户备注信息
     *   name       用户名
     *   nickname   用户昵称
     */
    public function updateUserInfo(TzUserRequest $request)
    {
        $TzUsersM = new TzUsers();//实例化客户用户模型
        $updateData = $request->all();//获取参数
        $TzUsersM->updateUserInfo($updateData);

        return tz_ajax_echo(null, '修改成功', 1);


    }

}


