var userInfo = undefined;

$(document).ready(function(){
	var u = window.location + "";
	if (u.indexOf("mlogin") == -1 && !$.trim(userInfo)) {
		location.href = '/wap/mlogin.jsp';
	}
});

//登录
function mLogin () {
	var loginName = $("#loginNameId").val();
	var loginPass = $("#loginPassId").val();
	var checkName = valiInput(USERNAME,"loginNameId","cusnameErr",true,"用户名为空或格式有误");
	var checkPass = valiInput(PASSWORD,"loginPassId","cuspasswordErr",true,"密码为空或格式有误");
	var params = {"loginName":loginName,"loginPass":loginPass};
	var url = "/login/login.action";
	if (checkName && checkPass ) {
		$.post(url,params,function(result){
	    	var rs = $.trim(result);
			if (rs > 0 ) {
				location.href = "/wap/mas/index.jsp";
			}  else {
				$("#cusnameErr").html('账号与密码不匹配');
			}
	  	});
	}
}


//注销登陆
function wapbgLogOut () {
	var url = "/login/bgLogOut.action";
	$.post(url,"",function(result){
    	window.location.href="/wap/mlogin.jsp";
  	});
}









