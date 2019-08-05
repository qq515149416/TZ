<?php

namespace App\Admin\Controllers\Others;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Others\Staff;

class StaffController extends Controller
{
    use ModelForm;

    /**
     * 用于查询员工基本信息表的数据作为通讯录
     * @return json 返回相关信息
     */
    public function index() {
    	$index = new Staff();
    	$staff = $index->index();
    	return tz_ajax_echo($staff['data'],$staff['msg'],$staff['code']);
    }
}
