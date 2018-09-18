<?php
/**
 * Created by PhpStorm.
 * User: 568171152@qq.com ZhangJun
 * Date: 2018/7/26
 * Time: 16:00
 */


/**
 * AJAX 格式工具
 *
 * @author 张俊
 * @param array $data
 * @param string $info
 * @param int $code
 * @return mixed
 *
 * 前端对象输出（凡是通过ajax请求的接口都必须调用此函数输出）
 * 方法名: ajaxEcho
 * 参数：$data=[],$info="",$code=0
 * $data为要输出的数据，默认是空数组
 * $info提示信息，默认是空
 * $code错误代码，默认是0
 */
function tz_ajax_echo($data = [], $info = "", $code = 0)
{
    return response()->json(["code" => $code, "data" => $data, "msg" => $info]);
}

/**
 * 计算时间是否过期工具
 *
 * @author 张俊
 * @param $time   string|int 所判断的时间
 * @param $length  int 为时间计算过期的小时数
 * @return bool    true:未过期    false:已过期
 */
function tz_time_expire($time, $length)
{
    $deadline   = time();  //默认到期时间为现在时间
    $lengthTime = $length * 60 * 60; //小时换算成时间戳
    return ((strtotime($time) + $lengthTime) > $deadline) ? true : false; //三元运算符 判断是否过期
}

/**
 * 测试时间参数
 */
function tz_time_test()
{


}