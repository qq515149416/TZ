<?php


namespace App\Admin\Controllers\TzUsers;

use App\Admin\Models\TzUsers\TzUsers;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\Ips;
use App\Admin\Requests\Business\TzUserRequest;
use Illuminate\Http\Request;
use App\Admin\Controllers\Excel\ExcelController;

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

    public function noBuyUsers()
    {
        $TzUsersM = new TzUsers();//实例化客户用户模型
        $users_arr = $TzUsersM->noBuyUsers();    
        
        $excel_model = new ExcelController();
        $excel_model->export($users_arr,'无业务客户信息');
 
    }

    /**
     * 获取客户数量
     * @param  $need    1 - 获取当日 ; 2 - 获取当月 ; 3 - 获取所有
     * @return
     */
    public function getUsers(Request $request){
        $par = $request->only(['need']);
        $this_month = date('Y-m');
        $statistics = new TzUsers();

        if (!isset($par['need'])) {
            return tz_ajax_echo(null,'请明确需求 : 1 - 当日 ; 2 - 当月 ; 3 - 所有',0);
        }
        if ($par['need'] == 1) { // 取当日
            $result = $statistics->usersToday();
        }elseif ($par['need'] == 2) {// 取当月
            $result = $statistics->getUsersThisMonth();
        }elseif ($par['need'] == 3) {// 取所有
      
            $result = $statistics->getAllUsers();
        }
        

        return tz_ajax_echo($result,'获取成功',1);
    }

    /**
     * 获取客户数量
     * @param  $month - 月份
     * @return
     */
    public function getUsersDetailed(Request $request){
        $par = $request->only(['month']);

        if (!isset($par['month'])) {
            return tz_ajax_echo(null,'请提供查询月份',0);
        }
        $statistics = new TzUsers();

        $result = $statistics->getUsersDetailed($par['month']);

        return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

     /**
     * 获取客户数量excel
     * @param  $month - 月份
     * @return
     */
    public function getUsersExcel(Request $request){
        $par = $request->only(['month']);

        if (!isset($par['month'])) {
            return tz_ajax_echo(null,'请提供查询月份',0);
        }
        $statistics = new TzUsers();

        $res = $statistics->getUsersDetailed($par['month']);
        $res = $res['data'];
        
        $data1 = [ 
            [
                '日期',
                '新增客户数量'
            ], 
        ];
        foreach ($res['line'] as $k => $v) {
            $data1[] = [ $res['line'][$k]['time'] , $res['line'][$k]['num'] ];
        }

        $data2 = [ 
            [
                '用户名',
                '邮箱',
                '昵称',
                '联系电话',
                'qq',
                '注册时间',
                '所属业务员',
            ], 
        ];
        foreach ($res['info'] as $k => $v) {
            $data2[] = [ 
                $res['info'][$k]['name'] , 
                $res['info'][$k]['email'] ,
                $res['info'][$k]['nickname'] ,
                $res['info'][$k]['msg_phone'] ,
                $res['info'][$k]['msg_qq'] ,
                $res['info'][$k]['created_at'] ,
                $res['info'][$k]['salesman_name'] ,
            ];
        }

        $arr = [
            0   => [
                'cellData' => $data1,
                'cellName' => '每日新增',
            ],
            1   => [
                'cellData' => $data2,
                'cellName' => '新增客户列表',
            ],
        ];
        $excel = new ExcelController();

        $excel->kiriExcel($arr,$par['month'].'新增客户详情');
    }
}


