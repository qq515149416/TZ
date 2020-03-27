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

/**
 * curl模拟请求
 * @param  [type]  $url   请求的url地址
 * @param  string  $params 需要传递的参数
 * @param  integer $return 是否返回
 * @param  array   $header 头部信息
 * @param  array   $cookie cookie
 * @param  array   $option 其他参数
 * @return [type]          [description]
 */
function curl($url, $params ='', $return = 1, $header = array(), $cookie = array(), $option = array())
{
	$ch = curl_init($url); // 初始化curl并设置链接
	// curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
	// 设置是否为post传递
	curl_setopt($ch, CURLOPT_POST, (bool)$params);
	// 对于https 设定为不验证证书和host
	// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, $return);//设置是否返回信息

	if($cookie)
	{
		$key = array_keys($cookie);
		curl_setopt($ch, $key[0]=='jar' ? CURLOPT_COOKIEJAR : CURLOPT_COOKIEFILE, $cookie['file']);
	}

	if($params)
	{
		if(is_array($params))
		{
			$params = http_build_query($params);
        }
		// POST 数据
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	}

	if($header)
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置头信息的地方
	}
	else
	{
		PHP_SAPI != 'cli' && isset($_SERVER['HTTP_USER_AGENT']) && curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	}

	foreach($option as $key => $val)
	{
		curl_setopt($ch, $key, $val);
	}
	$response = curl_exec($ch); // 执行并接收返回信息
	
	if(curl_errno($ch))
	{
		// 出错则显示错误信息
		exit(curl_error($ch));
	}

	if(! empty($option[CURLOPT_HEADER]))
	{
		// 获得响应结果里的：头大小
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		// 根据头大小去获取头信息内容
		$_EVN['CURL_HEADER'] = substr($response, 0, $header_size);
		$response = substr($response, $header_size);
	}

	curl_close($ch); // 关闭curl链接
	return $response;
}

/**
 * 计算时间（计算到期时间）
 * @param  string  $date      起始时间(2019-04-02 13:16:30)
 * @param  integer $duration  时长
 * @param  string  $time_unit 计算的时间单位(按月计算-'month',按天计算-'day',按年计算-'year')
 * @param  int  $monthly 月结日(0~31)
 * @return string             返回计算好的结束时间
 * @note   当起始时间的天数为自然月的最后一天时，到期时间的天数会是到期当月的最后一天
 * (如:起始时间为02-28,一个月后就是03-31;起始时间为03-31,一个月后就是04-30,诸如此)
 */
function time_calculation($date,$duration = 1,$time_unit = 'month',$monthly = 0){
	if($time_unit == 'month'){//按自然月计算
		//起始时间所属的自然月
	 	$current_month = date('m',strtotime($date));

	    //到期时间所属的自然月
	    $next_month = date('m',strtotime($date.'+'.$duration.' '.$time_unit));

	    //起始时间的天（号数）
	    $current_days = date('d',strtotime($date));

	    //起始时间所属自然月的总天数
	    $current_month_days = date('t',strtotime(date('Y-m',strtotime($date))));

	    //到期时间所属自然月的总天数
	    $next_month_days = date('t',strtotime(date('Y-m',strtotime($date)).'+'.$duration.' '.$time_unit));

	    if($monthly != 0){//月结客户
	    	if($monthly > $current_days){//当月结日大于传递的开始日期天数时，代表该周期内还未到月结日，到期时间则以该月月结日为基准。
	    		return $end_date = date('Y-m-'.$monthly.' H:i:s',strtotime($date));
	    	}
	    	if($monthly > 27 && $monthly > $next_month_days){//月结日是28-31号的且月结日超过到期月最大天数的，以最大天数为到期时间
	    		return $end_date = date('Y-m-'.$next_month_days.' H:i:s',strtotime(date('Y-m H:i:s',strtotime($date)).'+'.$duration.' '.$time_unit));
	    	}
    		return $end_date = date('Y-m-'.$monthly.' H:i:s',strtotime(date('Y-m H:i:s',strtotime($date)).'+'.$duration.' '.$time_unit));
	    }

	    //起始时间所属自然月的总天数与到期时间所属自然月的总天数的差值
	    $days = $current_month_days - $next_month_days;

		if($current_month == '02' && $current_days == $current_month_days){
			//当起始时间所属的自然月是02月时且起始时间的天（号数）与起始时间所属自然月的总天数相等时
			
			//正常计算后需减去起始时间所属自然月的总天数与到期时间所属自然月的总天数的差值,最后得到正确的时间
	        $end_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date($date).'+'.$duration.' '.$time_unit)).'-'.$days.' day'));

	    } elseif($days < 0 && $current_days == $current_month_days){
	        //当起始时间所属自然月的总天数与到期时间所属自然月的总天数的差值为负数时（即起始时间所属自然月的总天数小于到期时间所属自然月的总天数）
	        //且起始时间的天（号数）与起始时间所属自然月的总天数相等时
	       	
	       	//正常计算后需减去起始时间所属自然月的总天数与到期时间所属自然月的总天数的差值,最后得到正确的时间
	        $end_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date($date).'+'.$duration.' '.$time_unit)).'-'.$days.' day'));

	    } elseif($days > 0 && $next_month == '02' && $current_days > $next_month_days){
	    	//当起始时间所属自然月的总天数与到期时间所属自然月的总天数的差值为正数时（即起始时间所属自然月的总天数大于到期时间所属自然月的总天数）
	    	//且当到期时间所属的自然月是02月时，且起始时间的天（号数）大于到期时间所属自然月的总天数时
	    	
	        $difference_days =  $current_days - $next_month_days;//起始时间的天（号数）与到期时间所属自然月的总天数的差值
	        //正常计算后需减去起始时间的天（号数）与到期时间所属自然月的总天数的差值,最后得到正确的时间
	        $end_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date($date).'+'.$duration.' '.$time_unit)).'-'.$difference_days.' day'));

	    } elseif($days > 0 && $current_days > $next_month_days){
	    	//当起始时间所属自然月的总天数与到期时间所属自然月的总天数的差值为正数时（即起始时间所属自然月的总天数大于到期时间所属自然月的总天数）
	    	//且起始时间的天（号数）大于到期时间所属自然月的总天数时
	    	
	    	//正常计算后需减去起始时间所属自然月的总天数与到期时间所属自然月的总天数的差值,最后得到正确的时间
	        $end_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date($date).'+'.$duration.' '.$time_unit)).'-'.$days.' day'));

	    } else {
	    	//其他情况
	        $end_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date($date).'+'.$duration.' '.$time_unit))));

	    }
	} elseif($time_unit == 'day' || $time_unit == 'year'){//按天/年计算
		$end_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date($date).'+'.$duration.' '.$time_unit))));
	}
 	
    return $end_date;
}

/**
 * 创建单号
 * @param  string $first 单号前缀
 * @return string 返回生成的单号
 * @note:重复率:百万低于1%(数据可能存在一定误差),位数:16位,
 * 返回后检验是否存在此号,如有重新调用此方法重新生成单号
 * 格式:日期(年月日)+微秒数第3位开始截6个+10-99的随机数
 */
function create_number($first=''){
	$number = $first.date('Ymd',time()).substr(microtime(),2,6).mt_rand(10, 99);
	return trim($number);//剔除特殊字符后返回
}

/**
 * 资源类型的统一转换 
 * @param int 资源类型的代码 
 * @return 返回转换后对应的类型 
 */
function resource_type($type){
	$resource_type = [
		1=>'租用主机',
		2=>'托管主机',
		3=>'租用机柜',
		4=>'IP',
		5=>'CPU',
		6=>'硬盘',
		7=>'内存',
		8=>'带宽',
		9=>'防护',
		10=>'cdn',
		11=>'高防IP',
		12=>'流量叠加包'
	];
	$result = $resource_type[$type];
	return $result;
}

/**
 * 业务状态的统一转换 
 * @param int 业务状态的代码 
 * @return 返回转换后对应的状态 
 */
function business_status($status){
	$business_status = [0=>'审核中',1=>'未付款使用',2=>'正常使用',3=>'正常使用',4=>'锁定中'];
	$result = $business_status[$status];
	return $result;
}

/**
 * 订单状态的统一转换
 * @param  int $status 订状态的代码
 * @return          返回转换后的对应的状态
 */
function order_status($status){
	$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'取消',4=>'申请退款',5=>'退款中',6=>'退款完成'];
	$result = $order_status[$status];
	return $result;
}

/**
 * IP的线路提供商
 * @param  int $line 线路提供商的代码
 * @return 返回转换后的对应的线路提供商
 */
function line($line){
	$lines = [0=>'电信公司',1=>'移动公司',2=>'联通公司',3=>'BGP'];
	$result = $lines[$line];
	return $result;
}
