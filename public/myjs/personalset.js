
//初始tab的样式
$('#psersonaltabid').tabs({tabPosition:'left'})
//在$.post回返方法中去改变属性的值是无效的，要用全局变量
var uloginPassid = false;

//绑定验证事件的动作
$(function(){
	$("#uloginPassid").blur(function(){
		//验证初始密码格式与是否正确
		var pass = $("#uloginPassid").val();
		uloginPassid = valiInput(PASSWORD,"uloginPassid","uloginPassImgMesid");
		if (pass && uloginPassid) {
			$.post("/login/checkLoginPass.action",{"loginPass":pass},function(result){
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
	$("#newPassid").blur(function(){
		
	}),
	$("#comfigPassid").blur(function(){
		
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
			$.post("/login/updateLoginPass.action",{"newPass":pass2},function(result){
		    	var rs = $.trim(result);
		    	if( rs > 0 ) {
					showSuccessMes("submitPassMesid","更新成功!");
					$("#uloginPassid").val('');
					$("#newPassid").val('');
					$("#comfigPassid").val('');
				} else {
					showSuccessMes("submitPassMesid","更新失败，请联系管理员!");
				}
	    	});
		}
		
	}),
	$("#submitUpdateMesid").click(function() {
		
		var loginName = $("#loginNameid").val();
		var mobile = $("#mobileid").val();
		var email = $("#emailid").val();
		var sex = $("#sexid").val();
		var qq = $("#qqid").val();
		//验证
		var loginNameid = valiInput(USERNAME,"loginNameid","loginNameImgMesid");
		var mobileid = valiInput(MOBILE,"mobileid","mobileImgMesid");
		var qqid = valiInput(QQ,"qqid","qqImgMesid",false);
		if (qq){
			//非必填时，如果有值输入，则验证
			checkImgShow("#qqImgMesid",0);
		} else {
			checkImgShow("#qqImgMesid",2);
		}
		var emailid = valiInput(MAIL,"emailid","emailImgMesid",false);
		if (email){
			//非必填时，如果有值输入，则验证
			checkImgShow("#emailImgMesid",0);
		} else {
			checkImgShow("#emailImgMesid",2);
		}
		var prarms = {"loginName":loginName,"mobile":mobile,"email":email,"sex":sex,"qq":qq};
		if (loginNameid && mobileid && emailid && qqid) {
			$.post("/login/updatePersional.action",prarms,function(result){
		    	var rs = $.trim(result);
		    	if( rs > 0 ) {
					showSuccessMes("updateMesid","更新成功!");
				} else {
					showSuccessMes("updateMesid","更新失败，请联系管理员!");
				}
    		});
		} else {
			showSuccessMes("updateMesid","输入不正确!");
		}
	})
});
function myinfo(value){
	var maid = value;
	window.showModalDialog("/role/myinfo.action?maid="+maid);
}