
$(function(){
	checkwlInput();
})


//提交白名单
var macnumOfIP = "";
function subWhiteList2 () {
	if (urlF && recnumF && bip && checkStr(macnumOfIP)) {
		var domain = $("#domainid").val();
		var recnum = $("#recnumid").val();
		var ip = $("#ipid").val();
		var url = "/members/addWhiteList.action";
		var params = {"domain":domain,"ip":ip,"macnum":macnumOfIP,"recnum":recnum};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				$.messager.show({
					title: '提 示',
					msg: '提交成功，请待审核....'
				});
				//清空
				$("#domainid").val('');
				$("#recnumid").val('');
				checkImgShow("#domainmesid",2);
				checkImgShow("#recnummesid",2);
				urlF = false;
				recnumF = false;
				bip = false;
			}
		});
		
	} else {
		$.messager.show({
			title: 'Error',
			msg: '必填项不能为空或者输入信息有误'
		});
	}
}


//检查白名单输入的字段
var urlF = false;
var recnumF = false;
var bip = false;
function checkwlInput () {
	$("#domainid").focus();
	//检查域名输入
	$("#domainid").blur (function(){
		var domain = $("#domainid").val();
		var rex = "http://";
		var rex1 = "/";
		var rex2 = "\\";
		var rex3 = "www";
		var str = domain.split(".");
		var temp = valiInput(DOMAIN,"domainid","");
		if (!temp || !domain || str[0] == rex3 || domain.indexOf(rex2) >= 0 || domain.indexOf(rex1) >= 0 || domain.indexOf(rex) >= 0) {
			$("#domainid").val('');
			checkImgShow("#domainmesid",-1,"*必填");
		} else {
			//检查是否黑名单
			var url = "/customerserv/blacklist.action";
			var params = {"domain":domain,"rs":"json"};
			var rs = queryInfo (url,params,"域名检查异常");
			if (rs.total > 0) {
				checkImgShow("#domainmesid",-1,"黑名单域名");
				
			} else {
				urlF = true;
				checkImgShow("#domainmesid",0);
			}
			
		}
	});
	
	
	//备案编号
	$("#recnumid").blur(function(){
		var recnum = $("#recnumid").val();
		if (recnum) {
			recnumF = true;
			checkImgShow("#recnummesid",0);
		} else {
			checkImgShow("#recnummesid",-1,"*必填");
		}
	});
	
	
	//IP验证
	$("#ipid").blur(function(){
		var ip = $("#ipid").val();
		if (ip) {
			var url = "/members/queryMacInfoOfIP.action";
			var params = {"ip":ip};
			var errorsMessages = "机器信息匹配异常，请联系管理员";
			var rs = queryInfo(url,params,errorsMessages);
			if (rs.length > 0) {
				bip = true;
				macnumOfIP = rs[0].macnum;
				checkImgShow("#ipMesid",0);
			} else {
				checkImgShow("#ipMesid",-1,"IP有误");
			}
			
		} else {
			checkImgShow("#ipMesid",-1,"*必填");
		}
	});
	
}

