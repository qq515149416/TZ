<?php
/**
 * 发送业务到期日期
 *
 * Created by PhpStorm.
 * User: ZhangJun
 * Date: 2018/10/11
 * Time: 15:31
 */

namespace App\Admin\Controllers\Message;

use App\Admin\Models\Business\BusinessModel;
use App\Http\Controllers\Controller;
use App\Http\Models\TzUser;
use App\Jobs\Demo;
use Encore\Admin\Controllers\ModelForm;
use Faker\Provider\zh_CN\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class DeadlineController extends Controller
{

    /**
     *  对指定用户 检测过期业务 并发送相关的提醒电子邮件
     *
     * 参数:
     *  business_id:  业务ID
     *  send_type  :  发送类型 默认为电子邮件
     *
     */
    public function sendUser(Request $request)
    {
//        $podcast = 'test';
//        Demo::dispatch($podcast);
//        dd('123');

        $data['email'] = '568171152@qq.com';
        Mail::send('emails.test', [
            //发送内容
//            'token' => $token,
//            'userName'    => $data['userName'],     //用户名
//            'exampleType' => $data['exampleType'],  //实例类型
//            'exampleId'   => $data['exampleId'],    //实例ID
//            'deadLine'    => $data['deadLine '],    //到期时间
        ], function ($message) use ($data) {
            $message->to($data['email'])->subject('tz');
        });
        die();
//        dump($info);
//        $this->selectOverdueBusiness();

        $par           = $request->all();//获取参数
        $businessModel = new BusinessModel(); //实例化
        $tzUserModel   = new TzUser();
//        $data          = $businessModel->find($par['business_id']);   //获取数据
        $data = $businessModel->selectOverdueBusiness();   //获取数据

        dump($data);

        foreach ($data as $key => $value) {

            dump('用户ID:' . $value['client_id']);
            dump($value['endding_time']);
            $testD = $tzUserModel->find($value['client_id']);
            dump($testD);
            die();
            dump($testD['email']);

            $data['email']   = '568171152@qq.com';
            $data['subject'] = '腾正科技';


            Mail::send('emails.test', [
                //发送内容
//            'token' => $token,
//            'userName'    => $data['userName'],     //用户名
//            'exampleType' => $data['exampleType'],  //实例类型
//            'exampleId'   => $data['exampleId'],    //实例ID
//            'deadLine'    => $data['deadLine '],    //到期时间
            ], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['subject']);
            });
        }

        die();

        //业务不存在
        if (!$data) {
            return tz_ajax_echo([], '业务不存在', 0);
        }

        dump($data);  //获取打印数据;

    }

    /**
     * 查找用户已经过期的业务
     *  参数:
     *  userId: 用户ID
     *
     */
    public function selectOverdueBusiness($userId = null)
    {

        dump(date('Y-m-d H:i:s'));
//        $datetime = new \DateTime();


        dump('查找用户已过期的业务');
        //重点查询 过期时间

        $businessModel = new BusinessModel();

//        dump($businessModel->selectOverdueBusiness());

        if ($userId) {
            //$userId 不为空的时候

            dump('1');
        } else {
            //$userId 为空时候

            dump('2');

        }

    }


    /**
     * 检测所有将要过期的业务 并发送提醒邮件
     *
     */
    public function sendAllUser()
    {
        dump('sendAll');
        dump('现在时间:' . date('Y-m-d H:i:s'));  //打印现在时间

        $businessModel = new BusinessModel();  //实例化

        //


    }


}