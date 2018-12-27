
//初始tab的样式
$('#psersonaltabid').tabs({tabPosition:'top'})
//在$.post回返方法中去改变属性的值是无效的，要用全局变量
var uloginPassid = false;

//绑定验证事件的动作
$(function(){
	$("#uloginPassid").blur(function(){
		//验证初始密码格式与是否正确
		var pass = $("#uloginPassid").val();
		uloginPassid = valiInput(PASSWORD,"uloginPassid","uloginPassImgMesid");
		if (pass && uloginPassid) {
			$.post("/members/checkCusOldPass.action",{"loginPass":pass},function(result){
		    	var rs = $.trim(result);
		    	if( rs > 0 ) {
		    		uloginPassid = true;
					checkImgShow("#uloginPassImgMesid",0);
				} else {
					$("#uloginPassid").focus();
					uloginPassid = false;
					checkImgShow("#uloginPassImgMesid",-1);
				}
	  		});
		}
	}),
	$("#submitUpdatePassid").click(function() {
		var pass1 = $("#newPassid").val();
		var pass2 = $("#comfigPassid").val();
		
		//验证新密码
		var newPassid = valiInput(PASSWORD,"newPassid","unewPassImgMesid");
		
		//验证两次新密码输入
		var comfigPassid = valiInput(PASSWORD,"comfigPassid","comfigPassImgMesid");
		//判断两次输入是否一致
		if (comfigPassid && newPassid) {
			if (pass1 && pass2 && pass1 == pass2) {
				comfigPassid = true;
				checkImgShow("#comfigPassImgMesid",0);
			} else {
				comfigPassid = false;
				checkImgShow("#comfigPassImgMesid",-1);
			}
		}
		if (uloginPassid && newPassid && comfigPassid) {
			//提交
			$.post("/members/updateLoginPass.action",{"newPass":pass2},function(result){
		    	var rs = $.trim(result);
		    	if( rs > 0 ) {
					showSuccessMes("submitPassMesid","密码更新成功!");
					$("#uloginPassid").val('');
					$("#newPassid").val('');
					$("#comfigPassid").val('');
				} else {
					showSuccessMes("submitPassMesid","更新失败，请联系管理员!");
				}
	    	});
		}
	});
});