//初始加载广告图片的切换
$(document).ready(function() {
	$("#codeImgBg").click(function(){
		$(this).hide();
	});
});

//返回到客户后台管理系统
function gotosystemMan () {
	location.href = "/hymanager.jsp";
}

//登录
function cusLogin () {
	$("#codeImgBg").hide();
	var loginName = $("#cusnameid").val();
	var loginPass = $("#cuspasswordid").val();
	var loginCode = $("#loginCode").val();
	var checkName = valiInput(USERNAME,"cusnameid");
	var checkPass = valiInput(PASSWORD,"cuspasswordid");
	var params = {"loginName":loginName,"loginPass":loginPass,"loginCode":loginCode};
	var url = "/login/cusLogin.action";
	if (checkName && checkPass ) {
		$.post(url, params,function(result){
			var rs = $.trim(result);
			if (rs > 0 ) {
				location.href = "/hymanager.jsp";
			}  else {
				checkImgShow("#nameImgId",-1);
				checkImgShow("#passImgId",-1);
				checkImgShow("#codeImgId",-1);
			}
		});
	} else {
		checkImgShow("#nameImgId",-1);
		checkImgShow("#passImgId",-1);
		checkImgShow("#codeImgId",-1);
	}
}


//注销登陆
function cusLoginOut () {
	var url = "/login/cusLogOut.action";
	location.href="http://fh.tzidc.com/exitcus.php";
	$.post(url,"",function(result){
    	window.location.href="/index.jsp";
  	});
}

//获取登录验证码
function getLoginCode(){
	var time = new Date().getTime();
	$("#codeImgBg").css("background-image","url('/login/getLoginCode.action?version="+time+"')");
	$("#codeImgBg").show();
}
