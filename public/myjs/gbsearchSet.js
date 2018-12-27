
$(document).ready(function(){
	loadDeptTab ();
});

//生成部门tab组件
function loadDeptTab () {
	if (deptsJson) {
		var tabStr = "";
		for (var i = 0 ; i < deptsJson.length; i++) {
			var dept = deptsJson[i];
			var deptid = dept['deptid'];
			var deptname = dept['deptname'];
			var divName =  "gbCheckBox";
			tabStr += '<div title="'+deptname+'" id="'+deptid+'" name="'+divName+'" style="padding-top:30px;padding-left:200px;">' +
			'<table style="margin-top:30px;">' +
			'<tr><td colspan="20" style="font-size:15px;font-weight: bold;">【服务器业务基本信息】:</td></tr>'+
			'<tr height="50px;">' +
				'<td><input type="checkbox" alt="产品编号" id="proNum" value="proNum"/></td>' +
				'<td>产品编号</td>' +
				'<td><input type="checkbox" alt="主机编号" id="macnum" value="macnum"/></td>' +
				'<td>主机编号</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="带宽" id="dk" value="dk"/></td>' +
				'<td>带 宽</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="防护" id="fh" value="fh"/></td>' +
				'<td>防 护</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="电信IP" id="dxip" value="dxip"/></td>' +
				'<td>电信IP</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="联通IP" id="unicomip" value="unicomip"/></td>' +
				'<td>联通IP</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="机柜" id="cabinet" value="cabinet"/></td>' +
				'<td>机 柜</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="主机状态" id="checkstatus" value="checkstatus"/></td>' +
				'<td>主机状态</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="类别" id="biztype" value="biztype"/></td>' +
				'<td>类 别</td>' +
			'</tr>' +
			'<tr><td colspan="20" style="font-size:15px;font-weight: bold;padding-top:40px;">【服务器业务详细信息】:</td></tr>'+
			'<tr height="50px;">' +
				'<td><input type="checkbox" alt="开始日期" id="renbegintime" value="renbegintime"/></td>' +
				'<td>开始日期</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="结束日期" id="renendtime" value="renendtime"/></td>' +
				'<td>结束日期</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="时长" id="rensc" value="rensc"/></td>' +
				'<td>时 长</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="价格" id="renprice" value="renprice"/></td>' +
				'<td>价 格</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="付款状态" id="paystatus" value="paystatus"/></td>' +
				'<td>付款状态</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="上架备注" id="cbNote" value="cbNote"/></td>' +
				'<td>上架备注</td>' +
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
			'</tr>' +
			'<tr><td colspan="20" style="font-size:15px;font-weight: bold;padding-top:40px;">【客户信息】:</td></tr>'+
			'<tr height="50px;">' +
				'<td><input type="checkbox" alt="客户登录名" id="cusname" value="cusname"/></td>' +
				'<td>客户登录名</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="客户姓名" id="custruename" value="custruename"/></td>' +
				'<td>客户姓名</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="客户性别" id="cussex" value="cussex"/></td>' +
				'<td>客户性别</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="客户手机" id="cusmobile" value="cusmobile"/></td>' +
				'<td>客户手机</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="客户座机" id="telephone" value="telephone"/></td>' +
				'<td>客户座机</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="客户邮箱" id="cusemail" value="cusemail"/></td>' +
				'<td>客户邮箱</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="客户QQ" id="cusqq" value="cusqq"/></td>' +
				'<td>客户QQ</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="客户传真" id="fax" value="fax"/></td>' +
				'<td>客户传真</td>' +
			'</tr>' +
			'<tr>' +
				'<td><input type="checkbox" alt="客户地址" id="cusaddr" value="cusaddr"/></td>' +
				'<td>客户地址</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="客户公司名" id="companyname" value="companyname"/></td>' +
				'<td>客户公司名</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="客户注册时间" id="createdate" value="createdate"/></td>' +
				'<td>客户注册时间</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="消费总额" id="paytotal" value="paytotal"/></td>' +
				'<td>消费总额</td>' +
				'<td style="padding-left:30px;"><input type="checkbox"  alt="账户余额" id="accbal" value="accbal"/></td>' +
				'<td>账户余额</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="信用额度" id="creded" value="creded"/></td>' +
				'<td>信用额度</td>' +
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
			'</tr>' +
			'<tr><td colspan="20" style="font-size:15px;font-weight: bold;padding-top:40px;">【内部员工信息】:</td></tr>'+
			'<tr height="50px;">' +
				'<td><input type="checkbox" alt="业务员登录名" id="name" value="name"/></td>' +
				'<td>业务员登录名</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="业务员姓名" id="truename" alt="登录名" value="truename"/></td>' +
				'<td>业务员姓名</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="业务员性别" id="sex" value="sex"/></td>' +
				'<td>业务员性别</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="业务员手机" id="mobile" value="mobile"/></td>' +
				'<td>业务员手机</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="业务员邮箱" id="email" value="email"/></td>' +
				'<td>业务员邮箱</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="业务员入职时间" id="mcreatedate" value="mcreatedate"/></td>' +
				'<td>业务员入职时间</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="业务员QQ" id="qq" value="qq"/></td>' +
				'<td>业务员QQ</td>' +
				'<td style="padding-left:30px;"><input type="checkbox" alt="业务员工号" id="worknum" value="worknum"/></td>' +
				'<td>业务员工号</td>' +
			'</tr>' +
			'<tr><td colspan="20" style="font-size:15px;font-weight: bold;padding-top:40px;"><a href="javascript:void(0)" class="button white medium" onclick="updateGbqx(\''+deptid+'\')">提交搜索设置</a></td></tr>'+
		'</table>' +
		'</div>';
		}
		$("#gbSearchTabid").html(tabStr);
		//为每一个tab添加点击事件
	    $('#gbSearchTabid').tabs({    
		    border:true,
		    onSelect:function(title,index){
	    		initCheckBox (index);
		    }
		});
	} else {
		$.messager.show({ // show error message
			title: '提示',
			msg: '部门加载异常'
		});
	}
}

//初始化选中的checkbox
function initCheckBox (deptidParam) {
	var rs = getGbqx (deptidParam);
	if (rs) {
		var gbqxStr = fgStrOfStr(rs["showColumns"]);
		var showColunms = gbqxStr.split(",");
		for (var i = 0 ; i < showColunms.length; i++) {
			$($("div[id='"+deptidParam+"'] input[type='checkbox']")).each(function(a){
				if (this.value == showColunms[i]) {
					this.checked = true;
				}
			});
		}
	}
}

function updateGbqx (deptid) {
	var checkStr = "";
	var count = 0;
	//循环复选框,获取选中值，
    $($("div[id='"+deptid+"'] input[type='checkbox']")).each(function(i){
    	if (this.checked) {
    		var value = this.value;
    		var inputid = "#" + value;
    		var text = $(inputid).attr("alt");
    		count = count + 1;
    		if (count == 1) {
    			checkStr += value + "-" + text;
    		} else {
    			checkStr += "," + value + "-" + text;
    		}
    		
    	}
    });
    
    var showColumns = {"showColumns":checkStr};
    //提交后台处理
    var param = {"gbqx":JSON.stringify(showColumns),"deptid":deptid};
    var url = "/role/updateGbsearchSet.action";
    $.post(url,param,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$.messager.show({ // show error message
				title: '提 示',
				msg: '全局搜索配置已经生效'
			});
		} else {
			$.messager.show({ // show error message
				title: '异 常',
				msg: '配置异常,请联系管理员'
			});
		}
		
	});
}


