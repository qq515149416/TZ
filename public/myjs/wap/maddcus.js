//检查登录名
function checkCusname() {
	var cusnameval = $("#cusnameid").val();
	var cusname = valiInput(USERNAME,"cusnameid","cusnameMes","","数字和英文及下划线和.的组合，开头为字母，5-20个字符");
	if (cusname) {
		var param = {"cusname":cusnameval};
		var url = "/customerMan/checkCusname.action";
		$.post(url,param,function(result){
	    	var rs = $.trim(result);
	    	if (rs > 0) {
	    		$("#cusnameMes").html("<font color='red'>登录名已存在!</font>");
	    		$("#cusnameid").val("");
	    		$("#cusnameid").focus();
	    		return false;
	    	} else {
	    		$("#cusnameMes").html("");
	    	}
	  	});
	} else {
		checkImgShow("#cusnameMes",2);
		checkImgShow("#cusnameMes2",0);
	}
	
}

//新增机器
function saveNewMac(){
	//密码框
	var checkPass = valiInput(PASSWORD,"passInputid","passMes1","","数字和英文及下划线的组合，6-20个字符");
	if (!checkPass) {
		return;
	} else {
		checkImgShow("#passwordMes2",0);
		checkImgShow("#passMes1",2);
	}
	//密码确认框
	var pass1 = $("#passInputid").val();
	var pass2 = $("#comfigpassInputid").val();
	if (pass1 != pass2) {
		checkImgShow("#passMes2",-1,'两次密码输入不一致');
		return;
	} else {
		checkImgShow("#passMes2",2);
		checkImgShow("#comfigpassInputidMes2",0);
	}
	var url = '/customerMan/addCustomer.action';
	$('#addcusfm').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var rs = $.trim(result);
			if (rs > 0){
				$('#addcusfm').form('clear');
				wapcustomers();
				
			} else {
				$.messager.show({
					title: 'Error',
					msg: '客户资料填写错误，请联系管理员！'
				});
			}
		}
	});
}
