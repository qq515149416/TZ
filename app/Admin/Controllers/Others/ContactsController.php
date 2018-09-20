<?php

namespace App\Admin\Controllers\Others;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Others\Contacts;
use App\Admin\Requests\Test;
use App\Admin\Requests\Idc\OaContacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    use ModelForm;
    /**
     * 测试
     */
    public function test() {
    	$model = new contactsmodel();
    	$result = $model->test();
    	echo $result;
    }

    /**
     * 测试
     */
    public function rulestest(Test $request){
  			// return $request->all();
  			print_r($request->get('title'));
  		if($request->isMethod('post')){

	        // $test = $request->get('title');

	        // echo('<pre>');var_dump($test);die('</pre>');
	        echo 123;

	    }else{

	        echo 'this request method is GET';

	    }
	   // echo 123;
  			// dump($request);
    }

    /**
     * 测试
     */
    public function vi() {
    	return view('show/test');
    }

     /**
     * 用于查询系统联系人（业务员）的信息
     * @return json 返回相关的信息
     */
    public function index() {
      $index = new Contacts();
      $contacts = $index->index();
      return tz_ajax_echo($contacts['data'],$contacts['msg'],$contacts['code']);
    }
// $request->ajax() && 
    /**
     * 新增联系人表的信息
     * @param  OaContracts $request 进行字段验证
     * @param  array $data 前台传输过来的信息
     * @return json               将相关的信息进行json返回
     */
    public function insert(OaContacts $request){
      
      // 符合判断的方式正确继续进行，获取提交信息
        $data = $request->only(['contactname', 'qq','mobile','email','rank','site']);
        // 实例化model
        $create = new Contacts();
        // 数据进行model层处理
        $result = $create->insert($data);
        // 返回信息
        return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
       
    }

    /**
     * 查找要修改的数据
     * @param  Request $request 接收传递的参数
     * @return json            返回相关的数据或信息提示
     */
    public function edit(Request $request) {
      // 判断传输方式
     
      // 获取传递的参数
      $id = $request->get('contacts_id');
      $edit = new Contacts();
      // 将参数传递到对应的model的方法并进行接收结果
      $result = $edit->edit($id);
      // 返回相关数据和信息提示
      return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
      
    }

    /**
     * 修改联系人表的信息
     * @param  OaContracts $request 进行字段验证
     * @param  array $data 前台传输过来的信息
     * @return json               将相关的信息进行json返回
     */
    public function doEdit(OaContacts $request){
     
        // 符合判断的方式正确继续进行，获取提交信息
          $data = $request->only(['id','contactname', 'qq','mobile','email','rank','site']);
          // 实例化model
          $create = new Contacts();
          // 数据进行model层处理
          $result = $create->doEdit($data);
          // 返回信息
          return tz_ajax_echo($result,$result['msg'],$result['code']);
     
    }


    /**
     * 删除操作
     * @param  Request $request 操作删除的条件
     * @return json           相关的信息返回
     */
    public function deleted(Request $request){
      
        // 获取传递的参数
        $id = $request->get('delete_id');
        // echo $id;
        $edit = new Contacts();
        // 将参数传递到对应的model的方法并进行接收结果
        $result = $edit->dele($id);
        // 返回相关数据和信息提示
        return tz_ajax_echo($result,$result['msg'],$result['code']);
     
    }
}
