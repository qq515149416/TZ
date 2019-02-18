<?php


namespace App\Admin\Controllers\TzUsers;

use App\Admin\Models\TzUsers\TzUsers;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\Ips;
use App\Admin\Requests\Idc\IpsRequest;
use Illuminate\Http\Request;

class InfoController extends Controller
{


    /**
     * 后台管理获取用户信息
     *
     */
    public function getUserInfo()
    {
        $TzUsersM = new TzUsers();//实例化用户模型
        dump($TzUsersM->getUser());
        dump('UsersInfo');


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
     *
     */
    public function updateUserInfo(Request $request)
    {
        $TzUsersM = new TzUsers();//实例化客户用户模型



        dump('更新用户数据控制器');
        dump($request->all());
    }

}


