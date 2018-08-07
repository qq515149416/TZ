<?php
/**
 * Created by PhpStorm.
 * User: Administrator
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
