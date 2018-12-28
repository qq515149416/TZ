//查看客户信息
function macDetail () {
	var cusid = $("#currCusValid").val();
	look(cusid);
}

//查看客户主机情况
function look (cusidParam) {
	var params = {"cusid":cusidParam,"go":"wap"};
	url = '/customerMan/queryMacInfoForCus.action';
	$.post(url,params,function(result){
		$("#wapContentsid").html(result);
	});
}


//提交充值
function subToUp () {
	alert(1);
	var moneyval = $("#moneyid").val();
	var bankval = $("input[name='bankrname']:checked").val();
	var noteval = $("#toupnoteid").val();
	if (!moneyval) {
		$("#moneyMesid").html(" * 请输入充值金额");
	} else if (!bankval) {
		$("#bankMesid").html(" * 请选择银行");
	} else {
		var url = "/customerMan/payrecord.action";
		var custruename = $("#toupnameid").html();
		var params = {"menorys":moneyval,"bank":bankval,"custruename":custmoerName,"cusid":currClickCusid,"note":noteval};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				alert('操作成功,财务审核中');
				macDetail();
			} else {
				alert('充值失败，请联系管理员!');
			}
  		});
	}
	
}