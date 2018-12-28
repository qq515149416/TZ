
$(document).ready(function(){
	loadPayDataGrid();
	$("#bankid").empty().append('<option></option><option value="腾正公帐（建设银行）">腾正公帐（建设银行）</option><option value="腾正公帐（工商银行）">腾正公帐（工商银行）</option><option value="腾正公帐（招商银行）">腾正公帐（招商银行）</option><option value="腾正公帐（农业银行）">腾正公帐（农业银行）</option><option value="正易公帐（中国银行）">正易公帐（中国银行）</option><option value="支付宝">支付宝</option><option value="公帐支付宝">公帐支付宝</option><option value="财付通">财付通</option><option value="微信支付">微信支付</option>');
});
//初始化业务数据表格与表格的按钮事件
function loadPayDataGrid () {
	//表头
	var dataFiles = ["custruename","getdate","payamount","tax","taxmoney","bank","bankaccount","mastruename","note","cwname","cwnote",["id","taxrate"]];
	//行内按钮
	var clickbutton = "";
	//格式化字段
	var formatFileds ="";
	//分页配置
	var pageEvent = {"action":"/financ/loadSalesRegister.action?paystatus=1"};
	var showTableId = "#sqlesDataId";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	var results = createDataGridJsonRows['sumrs'];
	var sumrsTax = createDataGridJsonRows['sumrsTax'];
	var sumrsSum = createDataGridJsonRows['sumrsSum'];
	var footMes = "当前<span style='font-size:15px;color:red;'>" + createDataGridJsonRows['total'] + "</span>条数据金额结算：<span style='font-size:15px;color:red;'>" + results + "</span>元；";
	var footMesTax = "            金额结算：<span style='font-size:15px;color:red;'>" + sumrsTax + "</span>元；";
	var footMesSum = "            金额结算：<span style='font-size:15px;color:red;'>" + sumrsSum + "</span>元；";
	$("#footMesid").html(footMes);
	$("#footMesTaxid").html(footMesTax);
	$("#footMesSumid").html(footMesSum);
}

//高级查询
function searchxfjl(accbalParam) {
	var stdate = $("#stdateid").datebox("getValue");
	var enddate = $("#enddateid").datebox("getValue");
	var custruename = $("#cusnameid").val();
	var mastruename = $("#mnameid").val();
	var bank = $("#bankid").val();
	var bankaccount = $("#bankaccountid").val();
	var checkdate = compareDate(stdate,enddate);
	if (checkdate) {
		$.messager.alert("提 示",checkdate);
		return;
	}
	var params = {"paystatus":1,"stdate":stdate,"enddate":enddate,"custruename":custruename,"mastruename":mastruename,"bank":bank,"bankaccount":bankaccount};
	var url = "/financ/loadSalesRegister.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	var dataFiles = ["custruename","getdate","payamount","tax","taxmoney","bank","bankaccount","mastruename","note","cwname","cwnote",["id","taxrate"]];
			//行内按钮
			var clickbutton = "";
			//格式化字段
			var formatFileds = "";
			//分页配置
			var urlParams = "/financ/loadSalesRegister.action?paystatus=1&urlParams=urlParams&stdate=" + stdate+"&enddate="+enddate+"&custruename="+encodeURI(encodeURI(custruename))+"&mastruename="+encodeURI(encodeURI(mastruename))+"&bank="+encodeURI(encodeURI(bank))+"&bankaccount="+encodeURI(encodeURI(bankaccount));
			var pageEvent = {"action":urlParams};
			var showTableId = "#sqlesDataId";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			var results = result['sumrs'];
			var sumrsTax = result['sumrsTax'];
			var sumrsSum = result['sumrsSum'];
			var footMes = "当前<span style='font-size:15px;color:red;'>" + result['total'] + "</span>条数据金额结算：<span style='font-size:15px;color:red;'>" + results + "</span>元；";
			var footMesTax = "            金额结算：<span style='font-size:15px;color:red;'>" + sumrsTax + "</span>元；";
			var footMesSum = "            金额结算：<span style='font-size:15px;color:red;'>" + sumrsSum + "</span>元；";
			$("#footMesid").html(footMes);
			$("#footMesTaxid").html(footMesTax);
			$("#footMesSumid").html(footMesSum);
		}
	});
}

function exportExcel () {
	var stdate = $("#stdateid").datebox("getValue");
	var enddate = $("#enddateid").datebox("getValue");
	var custruename = $("#cusnameid").val();
	var mastruename = $("#mnameid").val();
	var bank = $("#bankid").val();
	var bankaccount = $("#bankaccountid").val();
	var checkdate = compareDate(stdate,enddate);
	if (checkdate) {
		$.messager.alert("提 示",checkdate);
		return;
	}
	window.location.href="/financ/exportExcel.action?stdate="+stdate+"&enddate="+enddate+"&custruename="+encodeURI(encodeURI(custruename))+"&mastruename="+encodeURI(encodeURI(mastruename))+"&bank="+encodeURI(encodeURI(bank))+"&bankaccount="+encodeURI(encodeURI(bankaccount));
}


