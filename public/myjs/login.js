$(function(){
	getOs();
	$(".i-text").focus(function(){
		$(this).addClass('h-light');
	});

	$(".i-text").focusout(function(){
		$(this).removeClass('h-light');
	});

	$("#loginNameId").focus(function(){
		 var username = $(this).val();
		 if(username=='输入账号'){
		 	$(this).val('');
		 }
	});


	$("#loginPassId").focus(function(){
		 var username = $(this).val();
		 if(username=='输入密码'){
		 	$(this).val('');
		 }
	});


	$("#yzm").focus(function(){
		 var username = $(this).val();
		 if(username=='输入验证码'){
		 	$(this).val('');
		 }
	});
});


//标识用户名密码的合法性
var checkloginName = false;
var checkloginPass = false;
//绑定验证事件的动作
$(function(){
	$("#loginNameId").focus();
    //$("#loginNameId").blur(function(){
	  	//checkloginName = valiInput(USERNAME,"loginNameId","nameImgId");
	//}),
	//$("#loginPassId").blur(function(){
		//checkloginPass = valiInput(PASSWORD,"loginPassId","passImgId");
	//});
    $inp = $('input'); //所有的input元素
	$inp.keypress(function (e) { 
	    var key = e.which; //e.which是按键的值
	    if (key == 13) {
	        submitForm();
	    }
	});
});


//重置
function clearForm(){
	$("#loginNameId").val("");
	$("#loginPassId").val("");
	$("#loginNameId").focus();
}

//正确图标 0表示正确, -1标示错误
function checkImgShow (attr,rs,mes) {
	var htmstr = "";
	 if (rs == 0) {
		htmstr = "<img src='/images/onCorrect.gif'/>";
	} else if (rs == -1) {
		htmstr = "<img src='/images/onError.gif'/>";
		if (mes) {
			htmstr += ("<span style='color:red;font-size:12px;'>" + mes + "</span>");
		}
	} else if (rs == 2) {
		htmstr = "";
	}
	 if ($(attr)) {
		 $(attr).html(htmstr);
	 }
	
}

//登录
function submitForm () {
	var ies = getOs();
	if (ies == "MSIE") {
		alert("请使用IE以外有极速模式的浏览器,360下载页面已经打开");
		return;
	}
	//验证格式
	checkloginName = valiInput(USERNAME,"loginNameId","nameImgId");
	checkloginPass = valiInput(PASSWORD,"loginPassId","passImgId");
	//匹配
	if (checkloginName && checkloginPass ) {
		var loginName = $("#loginNameId").val();
		var loginPass = $("#loginPassId").val();
		$.post("/login/login.action",{"loginName":loginName,"loginPass":loginPass},function(result){
	    	var rs = $.trim(result);
	    	var objtip=$(".error-box");
	    	if( rs > 0 ) {
	    		objtip.html("信息验证通过!");
				location.href = "/b2g2016/bgmain.jsp";
			} else {
				objtip.html("用户名或密码错误!");
				//checkImgShow("#nameImgId",-1);
				//checkImgShow("#passImgId",-1);
			}
	  	});
	}
}

function bgLogOut () {
	$.post("/login/bgLogOut.action","",function(result){
		window.location.href="/b2g2016/adminLogin.jsp";
	});
}


