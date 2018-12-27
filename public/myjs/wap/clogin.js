var cusUserInfo = undefined;

$(document).ready(function(){
	var u = window.location + "";
	if (u.indexOf("login") == -1 && !$.trim(cusUserInfo)) {
		location.href = '/wap/login.jsp';
	}
});

//登录
function wapcusLogin () {
	var loginName = $("#cusnameid").val();
	var loginPass = $("#cuspasswordid").val();
	var checkName = valiInput(USERNAME,"cusnameid","cusnameErr",true,"用户名为空或格式有误");
	var checkPass = valiInput(PASSWORD,"cuspasswordid","cuspasswordErr",true,"密码为空或格式有误");
	var params = {"loginName":loginName,"loginPass":loginPass};
	var url = "/login/cusLogin.action";
	if (checkName && checkPass ) {
		$.post(url,params,function(result){
	    	var rs = $.trim(result);
			if (rs > 0 ) {
				location.href = "/wap/cus/index.jsp";
			}  else {
				$("#cusnameErr").html('账号与密码不匹配');
			}
	  	});
	}
}


//注销登陆
function wapcusLoginOut () {
	var url = "/login/cusLogOut.action";
	$.post(url,"",function(result){
    	window.location.href="/wap/login.jsp";
  	});
}









