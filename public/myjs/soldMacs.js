
$(document).ready(function(){
	loadSoldMacs();
	loadCompRoom ();//获取机房
});
var th='';
//初始化业务数据表格与表格的按钮事件
function loadSoldMacs (param,temp) {

	AddRunningDiv();

	//表头
	var dataFiles = ["proNum","macnum","custruename","businesstypeid","dk","fh","renprice","dxip","unicomip","comproom","cabinet","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus","truename","testtype","cbNote","sjdate",["id","customerid","renpayid","maid","comproomid"]];
	//sold标识出售中服务器列表，还是已下架服务器历史记录.
	var sold = true;
	if(action_attr || createDataGridJsonRows["fromOther"]) {
		if (action_attr.indexOf("noeqMacxjstatus") > -1 || (createDataGridJsonRows["fromOther"] && createDataGridJsonRows["fromOther"].indexOf("noeqMacxjstatus") > -1 )) {
			$("#titleZHid").html('出售中服务器列表');
			$("#payspandid").show();
			$("#soldPayValid").show();
			var th = $("#zhcxid").html();
			if (th.indexOf("初始上") == -1) {
				
				var addth = th + "<th width='5%'>初始上<br>架时间</th></th><th width='9%'>操作</th>";
				$("#zhcxid").html(addth);
			}
			sold = true;
			
		} else if (action_attr.indexOf("macxjstatus") > -1 || (createDataGridJsonRows["fromOther"] && createDataGridJsonRows["fromOther"].indexOf("macxjstatus") > -1 )) {
			$("#titleZHid").html('已下架服务器历史记录');
			$("#payspandid").hide();
			$("#soldPayValid").hide();
			//表头
			dataFiles = ["proNum","macnum","custruename","businesstypeid","dk","fh","renprice","dxip","unicomip","comproom","cabinet","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus","truename","testtype","cbNote","xjdate",["id","customerid","renpayid","maid","comproomid"]];
			var th = $("#zhcxid").html();
			if (th.indexOf("下架时间") == -1) {
				var addth = th + "<th>下架时间</th><th width='9%'>操作</th>";
				$("#zhcxid").html(addth);
			}
			sold = false;
		}
		
	} 
	var soldMacdxIpValid = $("#soldMacdxIpValid").val();
	var soldMacNumVal = $("#soldMacNumValid").val();
	var soldCabinetVal = $("#soldCabinetValid").val();
	var soldCusNameVal = $("#soldCusNameValid").val();
	var soldYwNameVal = $("#soldYwNameValid").val();
	var soldPayVal = $("#soldPayValid").val();
	var soldMacType = $("#tesMacOrNotid").val();
	var comproomVal = $("#comproomid").val();
	var biztypeVal = $("#biztypeid").val();
	var renendtime = "";
	var xjdate = "";
	if (param) {
		renendtime = $("#endDateid").datebox("getValue");
		if(notxj=='0'){
			xjdate = $("#xjdateid").datebox("getValue");
		}
	}
	//loadUrl翻页功能的action路径
	var loadUrl = "";
	var url = "/customerMan/soldMacs.action";
	var params = {};
	//param判断是否通过功能按钮过来还是默认初始化通过菜单url请求的，如果是默认请求,就不需要进行再一次请求，因为默认请求过来已经带了数据结果在jsp.
	if (sold) {
		//加载售出中的机器，返回json
		params = {"macxjstatus":"noeqMacxjstatus","jsonStr":"jsonStr","soldMacdxIpValid":soldMacdxIpValid,"soldMacNumVal":soldMacNumVal,"soldCabinetVal":soldCabinetVal,"soldCusNameVal":soldCusNameVal,"soldYwNameVal":soldYwNameVal,"soldPayVal":soldPayVal,"comproomVal":comproomVal,"biztypeVal":biztypeVal,"renendtime":renendtime,"testtype":soldMacType};
		loadUrl = "/customerMan/soldMacs.action?macxjstatus=noeqMacxjstatus&jsonStr=jsonStr&allmac="+temp;
		if (param=="goOncurrpage"){
			currPage=$("#soldMacsDivid #currPage").html().substring(3,$("#soldMacsDivid #currPage").html().length-1);
			params = {"macxjstatus":"noeqMacxjstatus","currpage":currPage,"jsonStr":"jsonStr","soldMacdxIpValid":soldMacdxIpValid,"soldMacNumVal":soldMacNumVal,"soldCabinetVal":soldCabinetVal,"soldCusNameVal":soldCusNameVal,"soldYwNameVal":soldYwNameVal,"soldPayVal":soldPayVal,"comproomVal":comproomVal,"biztypeVal":biztypeVal,"renendtime":renendtime,"testtype":soldMacType};
		}else if(param == "reaload") {
			//不带参数搜索
			params = {"macxjstatus":"noeqMacxjstatus","jsonStr":"jsonStr","allmac":temp};
			//清空查询输入框
			clearInput();
		
		} else if (param == "load"){
			//带参数的高级搜索
			loadUrl += ("&urlParams=urlParams&soldMacdxIpValid=" + soldMacdxIpValid + "&soldMacNumVal=" + soldMacNumVal+ "&soldCabinetVal=" + soldCabinetVal + "&comproomVal="  + comproomVal + "&biztypeVal="  + biztypeVal + "&soldPayVal="  + soldPayVal + "&renendtime=" + renendtime + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))+ "&soldYwNameVal=" + encodeURI(encodeURI(soldYwNameVal))+ "&testtype=" + soldMacType);
		}
	} else {
		//加载历史下架机器，返回json
		params = {"macxjstatus":"macxjstatus","jsonStr":"jsonStr","soldMacdxIpValid":soldMacdxIpValid,"soldMacNumVal":soldMacNumVal,"soldCabinetVal":soldCabinetVal,"soldCusNameVal":soldCusNameVal,"soldYwNameVal":soldYwNameVal,"comproomVal":comproomVal,"biztypeVal":biztypeVal,"renendtime":renendtime,"xjdate":xjdate,"testtype":soldMacType};
		loadUrl = "/customerMan/soldMacs.action?macxjstatus=macxjstatus&jsonStr=jsonStr&allmac="+temp;
		if (param=="goOncurrpage"){
			laodUrl="/customerMan/soldMacs.action?macxjstatus=noeqMacxjstatus&currpage="+currPage+"&jsonStr=jsonStr&allmac="+temp;
		}else if (param == "reaload") {
			params = {"macxjstatus":"macxjstatus","jsonStr":"jsonStr","allmac":temp};
			//清空查询输入框
			clearInput();
		} else if (param == "load") {
			loadUrl += ("&urlParams=urlParams&soldMacdxIpValid=" + soldMacdxIpValid + "&soldMacNumVal=" + soldMacNumVal+ "&soldCabinetVal=" + soldCabinetVal + "&comproomVal="  + comproomVal + "&biztypeVal="  + biztypeVal + "&renendtime=" + renendtime + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))+ "&soldYwNameVal=" + encodeURI(encodeURI(soldYwNameVal))+ "&testtype=" + soldMacType+"&xjdate="+xjdate);
		}
		
	}
	if (param) {
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				if (result) {
					createDataGridJsonRows=result;
				}
			}
		});
	}
	
	if (createDataGridJsonRows["fromOther"]) {
		//从其它页面直接请求到这里
		loadUrl = createDataGridJsonRows["fromOther"];
		loadUrl += ("&fromOther=" + loadUrl);
	}
	
	//行内按钮
	if(notxj==1 && (deptid==0 || deptid==2 || deptid==12 || deptid==16 || deptid==13)){
		var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white,updateCusMacNote-备注修改-updateCusMacNote-white,updateMacxjstatus-下架-openXJMacWindow-white,soldHostRenew-续费-soldHostRenew,payMent-付款-payMent,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
	}else if(notxj==1 && deptid==4){
		var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,updateMacxjstatus-下架-openXJMacWindow-white,updateInfo-直接修改-updateInfo-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
	}else{
		if(notxj==1){
			var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white"};
		}else{
			var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white"};
		}
	}
	
	//格式化字段
	var formatFileds = {"testtype":"0-测试机,1-正式机","businesstypeid":"0-其他,1-IDC普通业务,2-IDC高防,3-大带宽,4-15cdn,5-云计算","biztype":"1-租用,0-托管","macxjstatus":"0-正常上架,1-客服下架审核中,2-客服已通知机房,3-已下架,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费"};
	//分页配置
	var pageEvent = {"action":loadUrl};
	var showTableId = "#soldMacsDivid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	
	//清除5天内到期或过期未续费标志
	if(maturity == "on"){
		$("#maturity").attr("class","button white medium");
		maturity = "off";
	}
	
	MoveRunningDiv();
}


//5天内到期或逾期未续费
//5天内到期或逾期未续费
function loadNearNowOrMore () {

	var macxjstatus = "noeqMacxjstatus";
	var soldMacdxIpValid = $("#soldMacdxIpValid").val();
	var soldMacNumVal = $("#soldMacNumValid").val();
	var soldCabinetVal = $("#soldCabinetValid").val();
	var soldCusNameVal = $("#soldCusNameValid").val();
	var soldYwNameVal = $("#soldYwNameValid").val();
	var soldMacType = $("#tesMacOrNotid").val();
	var comproomVal = $("#comproomid").val();
	var biztypeVal = $("#biztypeid").val();
	var renendtime = "";
	var xjdate = "";	
	renendtime = $("#endDateid").datebox("getValue");
	if(notxj=='0'){
		xjdate = $("#xjdateid").datebox("getValue");
		macxjstatus = "macxjstatus";
	}
		
	
	var url = "/customerMan/loadNearnowOrMore.action?macxjstatus="+macxjstatus+"&urlParams=urlParams&soldMacdxIpValid=" + soldMacdxIpValid + "&soldMacNumVal=" + soldMacNumVal+ "&soldCabinetVal=" + soldCabinetVal + "&comproomVal="  + comproomVal + "&biztypeVal="  + biztypeVal + "&renendtime=" + renendtime + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))+ "&soldYwNameVal=" + encodeURI(encodeURI(soldYwNameVal))+ "&testtype=" + soldMacType+"&xjdate="+xjdate;
	var params = {};
	var rs = "";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				rs = result;
			}
		}
	});
	//表头
	var dataFiles = ["proNum","macnum","custruename","businesstypeid","dk","fh","renprice","dxip","unicomip","comproom","cabinet","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus","truename","testtype","cbNote","sjdate",["id","customerid","maid","comproomid"]];
	//行内按钮
	if(notxj==1 && (deptid==0 || deptid==2 || deptid==12 || deptid==16 || deptid==13)){
		var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white,updateCusMacNote-备注修改-updateCusMacNote-white,updateMacxjstatus-下架-openXJMacWindow-white,soldHostRenew-续费-soldHostRenew,payMent-付款-payMent,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
	}else if(notxj==1 && deptid==4){
		var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,updateMacxjstatus-下架-openXJMacWindow-white,updateInfo-直接修改-updateInfo-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
	}else{
		if(notxj==1){
			var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white"};
		}else{
			var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white"};
		}
	}
	//格式化字段
	var formatFileds = {"testtype":"0-测试机,1-正式机","businesstypeid":"0-其他,1-IDC普通业务,2-IDC高防,3-大带宽,4-15cdn,5-云计算","biztype":"1-租用,0-托管","macxjstatus":"0-正常上架,1-客服下架审核中,2-客服已通知机房,3-已下架,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费"};
	//分页配置
	var pageEvent = {"action":url};
	var showTableId = "#soldMacsDivid";
	createDataGrid(showTableId,rs,dataFiles,clickbutton,pageEvent,10,formatFileds);
	
	//标志点击了5天内到期或过期未续费
	$("#maturity").attr("class","button red medium");
	maturity = "on";
}

//查看主机信息
function queryMacInfo () {
	if (currRowObjJson) {
		var params = {"macnum":currRowObjJson.macnum,"biztype":currRowObjJson.biztype,"id":currRowObjJson.id};
		url = '/customerserv/querySoldMacInfo.action';
		$.post(url,params,function(result){			
			$("#macInfoDivId").html(result);   		
    		openwin('#openWindowInfo','300px','550px','主机信息');
  		});
	}
}

//查询账户信息
function queryBalance () {
	var url = "/customerMan/queryBalance.action";
	var params = {"cusid":currRowObjJson.customerid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = JSON.parse(rs);
		if (rs) {		
			$("#yueid").val(jsondata.accbal);
			$("#eduid").val(jsondata.creded);
		}
  	});
}

operator=maids;
var resrprice = undefined;
//currbizPayStatus记录当前业务单的付款状态，当业务单处理未付款状态时，不能再继续续费，只能修改价格。
var currbizPayStatus = undefined;
//主机续费
function soldHostRenew (){
if (currRowObjJson) {
	    cusid=currRowObjJson.customerid;
		currbizPayStatus = currRowObjJson.paystatus;
		$('#goOnSoldMacsid').dialog('open').dialog('setTitle','续 费');
		queryBalance();
		$("#sMTrueNameid").html(currRowObjJson.custruename);
		$("#soldMacsid").val(currRowObjJson.macnum);
		$("#rrenscid").val(currRowObjJson.rensc);
		$("#mpriceid").val(currRowObjJson.renprice);
		rprice = currRowObjJson.renprice;
		$("#rmacsbegintimeid").val(currRowObjJson.renbegintime);
		$("#rmacsendtimeid").val(currRowObjJson.renendtime);
		$("#bizid").val(currRowObjJson.id);
		$("#rcusid").val(currRowObjJson.customerid);
		
	}
	
}

//动态显示价格
function formatPrice (value) {
	var rpriceid = $("#mpriceid").val();
	if (rpriceid) {
		return value+"月"+(rpriceid*value)+" 元";
	}
}

//修改价格
var oldpriceVal = undefined;
function changePrice(inputPriceid,textid) {
	textid = "#" + textid;
	inputPriceid = "#" + inputPriceid;
	var ahtml = $(textid).html();
	
	if (ahtml == '[修改价格]') {
		$(textid).html('[取消修改]');
		$(inputPriceid).attr("disabled",false);
		oldpriceVal = $(inputPriceid).val();
	} else if (ahtml == '[取消修改]') {
		$(textid).html('[修改价格]');
		$(inputPriceid).attr("disabled","disabled");
		$(inputPriceid).val(oldpriceVal);
	}
}

//提交续费
function subRenewal () {
	var addsc = $('#macsaddrenscid').slider('getValue');
	var newPrice = $("#mpriceid").val();
	//如果当前业务单在未付款的情况下，不能继续操作续费功能
	if (currbizPayStatus == 0 ) {
		$.messager.alert("提示","当前为未付款状态，不能操作续费，请先操作付款当前机器");
		return;
	}
	//如果没有修改价格，也没有选择续费时长，则做出提示，方法停止。
	if ((!oldpriceVal && addsc == 0) || (oldpriceVal==newPrice && addsc == 0)) {
		$.messager.alert("提示","请修改价格或者续费！");
		return;
	}
	var str = '确定要续费编号为【'+$("#soldMacsid").val()+'】的主机吗？';
	if (addsc == 0) {
		str = '确定要修改编号为【'+$("#soldMacsid").val()+'】的价格吗？';
	}
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var renbegintime = $("#rmacsendtimeid").val();			
			var bizid = $("#bizid").val();
			var url = "/customerMan/subRenewal.action";
			var renprice = $("#mpriceid").val();
			var rnote = $("#mnoteid").val();
			rnote = $.trim(rnote);
			var rmacnum = $("#soldMacsid").val();
			var params = {"addsc":addsc,"begintime":renbegintime,"bizid":bizid,"renprice":renprice,"cusid":cusid,"note":rnote,"rmacnum":rmacnum,"renpayid":currRowObjJson.renpayid,"payproject":3};
			//payTot 目前续费总共要支付的费用
			var payTot = undefined;
			//如果点击过修改价格，则要跑审核流程；否则就直接续费
			if (oldpriceVal) {
				if (renprice != oldpriceVal) {
					//确实修改价格,跑流程所需要的参与不同，所有要重新定义params.
					params = {"oldpriceVal":oldpriceVal,"addsc":addsc,"begintime":renbegintime,"bizid":bizid,"renprice":renprice,"cusid":cusid,"note":rnote,"rmacnum":rmacnum,"goflow":"goflow","renpayid":currRowObjJson.renpayid};
					payTot = renprice * addsc;
					
				} else {
					//点击过修改价格后，又取消了，所以要记录原来的价格去计算
					payTot = oldpriceVal * addsc;
				}
			} else {
				payTot = renprice * addsc;
			}
			//余额加信用度不够支付
			var canPay = parseInt($("#yueid").val()) + parseInt($("#eduid").val());			
			if (payTot > canPay) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				$('#macsaddrenscid').slider('setValue',0);
				return;
			}
			
			//提交
			$.post(url,params,function(result){
				var rs = $.trim(result);				
				if (rs > 0) {
					if (rs == 3) {
						$.messager.show({
							title: '提 示',
							//msg: '已经提交到上一级审核!'
							msg: '修改单价成功!'
						});
					} else if(rs==1) {
						$.messager.show({
							title: '提 示',
							msg: '续费支付成功!'
						});
					}else{
						$.messager.show({
							title: '提 示',
							msg: '已经提交到上一级审核!'
						});
					}
					$('#macsaddrenscid').slider('setValue',0);
					//$('#aupdatePriceid2').html('[修改价格]');
					$('#mpriceid').attr("disabled","disabled");
					$('#goOnSoldMacsid').dialog('close');					
					loadSoldMacs('goOncurrpage','notcabmac');										
				} else {
					$.messager.show({
						title: 'ERROR',
						msg: '续费失败，请联系管理员!'
					});
				}
		  	});
		}
	});
}

//由业务人员付款机器
function payMent () {
	if (currRowObjJson) {		
		if (currRowObjJson.paystatus == 0) {
			var urls = "/customerMan/queryBalance.action";
			var paramss = {"cusid":currRowObjJson.customerid};
			$.post(urls,paramss,function(result){
				var rs = $.trim(result);
				var jsondata = JSON.parse(rs);
				if (rs) {
					var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
					var canPayTotal =  parseInt(jsondata.accbal) +  parseInt(jsondata.creded);					
					if (payTotal > canPayTotal) {
						$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
						return;
					}
					var str = "编号:<span style='color:red;font-size:14px;'>" + currRowObjJson.macnum + "</span><br><br>" +
						"缴费总额:<span style='color:red;font-size:14px;'> " + payTotal +"元 </span><br><br>" +
						"<span style='margin-left:40px;'>确定为主机进行付款吗？</span><br><br>";
					$.messager.confirm('Confirm',str,function(r){
						if (r){
							var url = "/customerMan/payMenoy.action";
							var bizid = $("#bizid").val();					
							var params = {"cusid":currRowObjJson.customerid,"payTotal":payTotal,"bizid":bizid,"renpayid":currRowObjJson.renpayid,"payproject":1,"testtype":currRowObjJson.testtype};
							$.post(url,params,function(result){
								var rs = $.trim(result);
								if (rs > 0) {									
									//刷新当前表的数据
									loadSoldMacs('goOncurrpage','notcabmac');
									$.messager.show({
										title: '提 示',
										msg: '支付成功！'
									});
								} else {
									 $.messager.alert("操作提示", "支付失败！","error"); 
								}
						  	});
						}
					});
				}
		  	});	
		} else {
			$.messager.alert("提示","此机器已付款！")
		}
	} 
}

function loadCompRoom (){
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	var rs = "";
	var sl=$("#comproomid");
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				for(var i = 0 ; i < result.length; i++){
					var comproomid = result[i]["comproomid"];
					var comproomname =result[i]["comproomname"];
					sl.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
				}
			}
		}
	});
}

//清空查询框
function　clearInput(){	
	$("#soldMacdxIpValid").val("");
	$("#soldMacNumValid").val("");
	$("#soldCabinetValid").val("");
	$("#soldCusNameValid").val("");
	$("#soldYwNameValid").val("");
	$("#soldPayValid").val("");
	$("#tesMacOrNotid").val("");
	$("#comproomid").val("");
	$("#biztypeid").val("");
	$("#endDateid").datebox("setValue","");
	if(notxj=='0'){
		$("#xjdateid").datebox("setValue","");
	}
}


function exportMacWithExcel(){

	var macxjstatus = "noeqMacxjstatus";
	var nearnow = "5";
	var soldMacdxIpValid = $("#soldMacdxIpValid").val();
	var soldMacNumVal = $("#soldMacNumValid").val();
	var soldCabinetVal = $("#soldCabinetValid").val();
	var soldCusNameVal = $("#soldCusNameValid").val();
	var soldYwNameVal = $("#soldYwNameValid").val();
	var soldPayVal = $("#soldPayValid").val();
	var soldMacType = $("#tesMacOrNotid").val();
	var comproomVal = $("#comproomid").val();
	var biztypeVal = $("#biztypeid").val();
	var renendtime = "";
	var xjdate = "";	
	renendtime = $("#endDateid").datebox("getValue");
	if(notxj=='0'){
		xjdate = $("#xjdateid").datebox("getValue");
		macxjstatus = "macxjstatus";
	}
	
	
	if(maturity == "on"){
		//导出5天内或过期未续费的机器
		window.location.href ="/customerMan/exportMacWithExcel.action?macxjstatus="+macxjstatus
		+"&soldMacdxIpValid=" + soldMacdxIpValid + "&soldMacNumVal=" + soldMacNumVal+ "&soldCabinetVal=" + soldCabinetVal
		+ "&comproomVal="  + comproomVal + "&biztypeVal="  + biztypeVal
		+ "&renendtime=" + renendtime + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))
		+ "&soldYwNameVal=" + encodeURI(encodeURI(soldYwNameVal))+ "&testtype=" + soldMacType+"&xjdate="+xjdate+"&nearnow="+nearnow+"&notxj="+notxj;
	}else{
		//导出正常筛选的机器
		window.location.href ="/customerMan/exportMacWithExcel.action?macxjstatus="+macxjstatus
		+"&soldMacdxIpValid=" + soldMacdxIpValid + "&soldMacNumVal=" + soldMacNumVal+ "&soldCabinetVal=" + soldCabinetVal
		+ "&comproomVal="  + comproomVal + "&biztypeVal="  + biztypeVal
		+ "&renendtime=" + renendtime + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))
		+ "&soldYwNameVal=" + encodeURI(encodeURI(soldYwNameVal))+ "&testtype=" + soldMacType+"&xjdate="+xjdate+"&soldPayVal="+soldPayVal+"&notxj="+notxj;
	}
	
	$.messager.alert("操作提示", "数据正在生成,请稍等,请勿重复点击导出!","info");
}

//用来标记是否按下了5天内到期或过期未续费
var maturity = "off";

//查看机器下架原因
function queryShelvesReason(){
	if(currRowObjJson){
		var params = {"id":currRowObjJson.id};
		url = '/customerserv/queryShelvesReason.action';
		$.post(url,params,function(result){
			$("#reason").html(mydecode(result));
			openwin('#openShelvesReason','400px','300px','下架原因');
		});
		
	}
		
}

//弹出工单窗口
function askQuestion(){
	if(currRowObjJson){
		dropDownList();
		$("#webEditMacnumId").html("当前主机编号["+currRowObjJson.macnum+"]");
		$('#qestionWindow').dialog('open').dialog('setTitle','编辑客户主机业务信息');
	}
}

function dropDownList(){
	//查询问题第一层分类信息
	$('#question-first-type option').remove();
	$('#question-second-type option').remove();
	$('#question-second-type').hide();
	$.post('/members/queryQTypeInfoList.action?parentId=0', null, function(text, status) {
		var questionTypeInfo = $.parseJSON(text);
		$.each(questionTypeInfo, function(n, value) {
			$('#question-first-type').append(
					"<option value='"+value.id+"'>" + value.name + "</option>");
		});
	});
	
}

//查询问题分类信息
$("#question-first-type").change(function(){
	$('#question-second-type option').remove();
	$('#question-second-type').hide();
	$.post('/members/queryQTypeInfoList.action?parentId=' + $('#question-first-type').val(), null, function(text, status) {
		var questionTypeInfo = $.parseJSON(text);
		
		var length = 0;
		
		$.each(questionTypeInfo, function(n, value) {
			$('#question-second-type').append(
					"<option value='"+value.id+"'>" + value.name + "</option>");
					length+=1;
		});
		//alert(text);
		if(length > 0){
			$('#question-second-type').show();
		}
	});
});

//备注修改
var updateMacNote_bizid='';
function updateCusMacNote(){
	updateMacNote_bizid = currRowObjJson.id;
	$("#addmacnum").val(currRowObjJson.macnum);
	$("#addProNumid").val(currRowObjJson.proNum);
	$("#cabinetId").val(currRowObjJson.cabinet);
	$("#comproomnameforNoteid").val(currRowObjJson.comproom);
	$("#ubizNoteid").val(mydecode(mydecode(currRowObjJson.cbNote)));
	$('#editCusMac').dialog('open').dialog('setTitle','服务器备注修改');
}

//提交修改备注
function saveMacNote(){
	var id = updateMacNote_bizid;
	var bizNote = $("#ubizNoteid").val();
	var proNum = $("#addProNumid").val();
	var str = "修改机器信息操作，确定？";
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var url = "/customerMan/updateBizInfo.action";
			var params = {"id":id,"note":bizNote,"proNum":proNum};
			queryInfo (url,params,"修改失败，请联系管理员");
			$('#editCusMac').dialog('close');	    	
			loadSoldMacs('goOncurrpage','notcabmac');	    		
		}
	});
}

//打开下架机器弹框
function openXJMacWindow(){
	$("#xjMacaddmacnum").val(currRowObjJson.macnum);
	$("#xjMacaddProNumid").val(currRowObjJson.proNum);
	$("#xjMaccabinetId").val(currRowObjJson.cabinet);
	$("#xjMaccomproomnameforNoteid").val(currRowObjJson.comproom);
	$("#xjMacreasonsid").val("");
	$('#xjMacWindow').dialog('open').dialog('setTitle','机器下架');
}

//主机业务下架
function updateMacxjstatus () {
		
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus == 1) {
			var mes = "编号["+currRowObjJson.macnum+"]的主机已经申请下架!";
			$.messager.alert("提示",mes);
			return;
		}
		var reason = dotran($("#xjMacreasonsid").val());
		if(!reason){
			checkImgShow("#reasonMes",-1,'必填');
			return;
		}else{
			checkImgShow("#reasonMes",2);
		}
	
		var str = '确定要把主机编号为【'+currRowObjJson.macnum+'】的下架吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				
				var shelvesOperatorId = currMasterid;
				var url = "/customerMan/updateMacxjstatus.action";
				var parmas  = {"id":currRowObjJson.id,"macxjstatus":"1","reason":reason,"shelvesOperatorId":shelvesOperatorId};
				$.post(url,parmas,function(result){
		    		var rs = $.trim(result);
		    		$("#xjMacWindow").dialog('close');
		    		$("#reasons").val('');
		    		if (rs > 0) {
		    			$.messager.show({
							title: '提示',
							msg: '已经把下架信息提交到客服处理......'
						});
		    			loadSoldMacs('goOncurrpage','notcabmac');		    			
		    		} else {
		    			$.messager.show({
							title: 'Error',
							msg: '下架失败，请联系管理员！'
						});
		    		}		    		
		  		});
			}
		});
	}
}

//单机资源管理
var bizid ="";
var resTypeIp = "";
var cusMacid='';
var addMacRes ='';
var payMark ='';
function macResoucesMan (){
	currClickCusid=currRowObjJson.customerid;
	custruename=currRowObjJson.custruename;
	/*if($("div[name='layout']").length!=2){
		var layout = $("div[name='layout']");
		layout[0].remove();
		layout[1].remove();
	}*/
	res_cabinetid='';
	payMark='danjiRes';
	//赋值给全局变量初始化数据
	cusMacid=currRowObjJson.id;
	addMacRes=currRowObjJson.macnum;
	dxipFormat = currRowObjJson.dxip;
	unipFormat = currRowObjJson.unicomip;
	$("#resMacComproomid").val(currRowObjJson.comproomid)
	queryMacResDetail();
	tabChangeMacRes ('1','dktabm');
	resType='1';
	$('#macResourcesManageid').dialog('open').dialog('setTitle','单机资源管理');
}

function  queryMacResDetail( ){
	var url = '/customerMan/queryMacResDetail.action';
	var params = {"id":cusMacid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			$("#maczongdk").html(jsondata.zongdk);
			$("#maczongfh").html(jsondata.zongfh);
			$("#macdxziip").html(jsondata.dxipsCounts);
			$("#macunziip").html(jsondata.unipsCounts);
			}
  		});
}

function tabChangeMacRes (checkStatu,liidparm){
	
	  //改变当前选中的tab头部
		var liid = "#" + liidparm;
		$("#macResourcesTabulid li").each (function(){
			$(this).removeClass("active");
		});
		$(liid).addClass("active");
		
		$('#addMacResourcesDkid').hide();
		$('#addMacResourcesFhid').hide();
		$('#addMacResourcesDxIPid').hide();
		$('#addMacResourcesUnIPid').hide();
		if (!checkStatu || checkStatu == '1') {
			resType = 1;
			queryDangJiRes (resType);
			$("#dkMacResources").show();
			$("#fhMacResources").hide();
			$("#macResourcesIPid").hide();
		} else if(!checkStatu || checkStatu == '2'){
			resType = 2;
			queryDangJiRes (resType);
			$("#dkMacResources").hide();
			$("#fhMacResources").show();
			$("#macResourcesIPid").hide();
		} else if(!checkStatu || checkStatu == '3'){
			resType=3;
			queryDangJiRes (3);
			queryDangJiRes (4);
			$("#dkMacResources").hide();
			$("#fhMacResources").hide();
			$("#macResourcesIPid").show();
		}
	}

function  queryDangJiRes (resType){
	var currPageShowTableId ="";
	if(resType=="1"){
		currPageShowTableId = "#dkMacResources";
	}else if(resType=="2"){
		currPageShowTableId = "#fhMacResources";
	}else if(resType=="3"){
		currPageShowTableId = "#dxipMacResources";
	}else if(resType=="4"){
		currPageShowTableId = "#unipMacResources";
	}
	var currPage = $(currPageShowTableId+" #currPage").html().substring(3,$(currPageShowTableId+" #currPage").html().length-1);
	//var url = "/customerMan/queryResources.action?type="+resType+"&cusbizid="+cusMacid+"&macbiz="+"macbiz";
	var url = "/customerMan/queryResInfoByMacNum.action";
	//var params = {"cusid":currClickCusid};
	var params = {'type':resType,'macnum':currRowObjJson.macnum,"currPage": currPage};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				var dataFiles = "";
				var showTableId = "";
				//1:带宽 	2：防护 3：子IP
				if(resType=='1'){
					//表头
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "customerid","id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP"] ];
					showTableId = "#dkMacResources";
					$("#dkcabinetMacBizResListsidFootid").show();
				}else if(resType=='2'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "customerid","id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP"] ];
					showTableId = "#fhMacResources";
					$("#fhcabinetMacBizResListsidFootid").show();
				}else if(resType=='3'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "customerid","id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP"] ];
					showTableId = "#dxipMacResources";
					$("#dxipcabinetMacBizResListsidFootid").show();
				}else if(resType=='4'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "customerid","id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP"] ];
					showTableId = "#unipMacResources";
					$("#unipcabinetMacBizResListsidFootid").show();
				}
				//var clickbutton ={"aMethod":"goOnRenewalRes-续费-goOnRenewalRes,payBizRes-付款-payBizRes,openXjResWindow2-下架-openXjResWindow2,openXjResWindow-IP下架-openXjResWindow,xgResources-直接修改-xgResources"};
				var clickbutton="";	
				if(deptid==2 || deptid ==12|| deptid ==16){
						//deptid=2，业务部
						clickbutton = {"aMethod":"goOnRenewalRes-续费-goOnRenewalRes,payBizRes-付款-payBizRes"};
					}else if((resType=='3' || resType=='4') && (deptid=='4' || deptid ==0|| deptid ==13)){
						//deptid=4， 综合部
						clickbutton = {"aMethod":"openXjResWindow-下架-openXjResWindow,xgResources-直接修改-xgResources"};
					} else if ((resType=='1' || resType=='2') && (deptid=='4' || deptid ==0|| deptid ==13)){
						clickbutton = {"aMethod":"openXjResWindow2-下架-openXjResWindow2,xgResources-直接修改-xgResources"};
					} else{
						clickbutton={};
					}
				//格式化字段
				var formatFileds = {"paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":url+'?type='+resType+'&macnum='+currRowObjJson.macnum};
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//资源管理提交修改
function updateMacResourcesAdd () {
	var form='';
	var ziIPid= '';
	var ziIp = '';
	var str ='';
	if(resType=='1'){
		form = "macResourcesDkfm";
		str = '确定要为编号为【'+addMacRes+'】的机器增加带宽吗？';
	}else if(resType=='2'){
		form = "macResourcesFhfm";
		str = '确定要为编号为【'+addMacRes+'】的机器增加防护吗？';
	}else if(resType=='3'){
		//子IP
		ziIp = $('#macResadddxipid').combobox('getText'); 
		ziIPid = $('#macResadddxipid').combobox('getValue');
		form = "macResourcesDxIpfm";
		str = '确定要为编号为【'+addMacRes+'】的机器添加电信IP吗？';
	}else if(resType=='4'){
		ziIp = $('#macResddunicomipid').combobox('getText'); 
		ziIPid = $('#macResddunicomipid').combobox('getValue');
		form = "macResourcesUnIpfm";
		str = '确定要为编号为【'+addMacRes+'】的机器添加联通IP吗？';
	}
	
	//var id = "";//机柜业务ID
	//机器业务ID
	if (!cusMacid) {
		$.messager.alert('Errors','错误代码：subUpdateBizInfo,获取业务单信息失败，请联系管理员');
		return;
	}
	var url = "/customerMan/addMacResourcesManage.action?cusbizid="+cusMacid+"&resType="+resType+"&resTypeIp="+resTypeIp+"&ziIPid="+ziIPid/*+"&ziIp="+ziIp*/+"&zhuip="+dxipFormat+"&maid="+currMasterid+"&cusid="+currClickCusid;
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			if(resType=='3'||resType=='4'){
				var reg = /\d+\.\d+\.\d+\.\d+/g; 
				if(ziIPid=='' || !reg.test(ziIPid)){
					$.messager.alert("提示","子IP值有误！");
					return;
				}else{
					var ipvali = false;
					var comproom = $("#resMacComproomid").val();
					if(resType=='3'){
						ipvali = resCheckIpComproom("dxip",ziIPid,comproom);
					}else if(resType=='4'){
						ipvali = resCheckIpComproom("unip",ziIPid,comproom);
					}
					if(!ipvali){
						return;
					}
				}
			}
			$('#'+form).form('submit',{
				url: url,
				onSubmit: function(){
					//所有验证通过
					var rsvali = false;
					var vali1 = $(this).form('validate');
					if (vali1 == true ) {
						rsvali = true;
					}
					return rsvali;
				},
				success: function(result){
					var rs = $.trim(result);
					if (rs > 0){
							$('#macResourcesDkfm').form('clear');
							$('#macResourcesFhfm').form('clear');
							$('#macResourcesDxIpfm').form('clear');
							$('#macResourcesUnIpfm').form('clear');
							$('#addMacResourcesDkid').hide();
							$('#addMacResourcesFhid').hide();
							$('#addMacResourcesDxIPid').hide();
							$('#addMacResourcesUnIPid').hide();
							$.messager.show({
								title: '提 示',
								msg: '已成功增加资源！'
							});
							//reloadMyCurrCusData ();
							queryDangJiRes (resType);
							queryMacResDetail();
					} else if(rs=='-1'){
						$.messager.alert("提示","输入IP值有误！");
						return;
					}else {
						$.messager.show({
							title: 'Error',
							msg: '资源信息错误，请联系管理员！'
						});
					}
				}
			});
		}
	});
}

//资源增加按钮
function showAddMacResources (addResType){
	if(addResType=='dk'){
		$("#macResourcesbeginTimeiddk").datebox("setValue",myDateformatter(new Date()));
		$('#addMacResiddk').val( addMacRes);
		$("#addMacResourcesDkid").toggle(500);
		//$('#addMacResourcesDkid').show();
	}else if(addResType=='fh'){
		$("#macResourcesbeginTimeidfh").datebox("setValue",myDateformatter(new Date()));
		$('#addMacResidfh').val( addMacRes);
		$("#addMacResourcesFhid").toggle(500);
		//$('#addMacResourcesFhid').show();
	}else if(addResType=='dxip'){
		resTypeIp = addResType;
		resType='3';
		$("#macResourcesbeginTimeiddxip").datebox("setValue",myDateformatter(new Date()));
		$('#addMacResiddxip').val( addMacRes);
		loadIps("dxip");
		$("#addMacResourcesDxIPid").toggle(500);
		//$('#addMacResourcesDxIPid').show();
		$('#addMacResourcesUnIPid').hide(500);
		
	}else if(addResType=='unicomip'){
		resTypeIp = addResType;
		resType='4';
		$("#macResourcesbeginTimeidunip").datebox("setValue",myDateformatter(new Date()));
		$('#addMacResidunip').val( addMacRes);
		loadIps("unicomip");
		$("#addMacResourcesUnIPid").toggle(500);
		$('#addMacResourcesDxIPid').hide(500);
		//$('#addMacResourcesUnIPid').show();
	}
}

function resCheckIpComproom (iptype,ipVal,comproom) {
	var url = '/customerMan/checkIpComproom.action';
	var params = {"iptype":iptype,"ipVal":ipVal,"comproom":comproom};
	var ipvali = false;
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "POST",
		dataType : 'json',
		success : function (result){
			var rs = $.trim(result);
			if(rs== 0 ){
				if(iptype=='unip') {
					$.messager.alert("提示","子IP所属机房与选择的机房不相符");
					ipvali= false;
				}else if (iptype == 'dxip') {
					$.messager.alert("提示","子IP所属机房与选择的机房不相符");
					 ipvali= false;
				}
			}else{
				ipvali =true;
			}
		}
	});
	return ipvali;
}

var dxipsCom = undefined;
var unipsCom = undefined;
//加载IP库的IP，供业务员选择
function loadIps (iptype) {
	var url = "";
	var params = "";
	if (iptype == "dxip") {
		url = "/customerMan/loadDxIps.action";
		params = {"dxipFormat":dxipFormat,"cusid":currClickCusid};
		
	} else if (iptype == "unicomip") {
		url = "/customerMan/loadUnIps.action"
		params = {"unipFormat":unipFormat};
	}
	
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = eval(rs);
		if (rs) {
			if (iptype == "dxip") {
				dxipsCom = jsondata;
				$("#adddxipid").combobox('loadData',jsondata);
				//机柜资源管理
				$("#resadddxipid").combobox('loadData',jsondata);
				//单机资源管理
				$("#macResadddxipid").combobox('loadData',jsondata);
			} else if (iptype == "unicomip"){
				unipsCom = jsondata;
				$("#addunicomipid").combobox('loadData',jsondata);
				//机柜资源管理
				$("#resddunicomipid").combobox('loadData',jsondata);
				//单机资源管理
				$("#macResddunicomipid").combobox('loadData',jsondata);
			}
		}
  	});
}

function checkall(tab){
	   var hobbys = $(tab+" #payment");
	   var ids = [];
	     for(var i=0;i<hobbys.length;i++){
	       hobbys[i].checked="true";
	   }
	}

	function notcheckall(tab){
	   var hobbys = $(tab+" #payment");
	    for(var i=0;i<hobbys.length;i++){
	       hobbys[i].checked="";
	   }
	}
	function batchpayment(tab){
	   var hobbys = $(tab+" #payment");
	   var sum = parseInt(0);
	   var resourcesids = "{";
	   var renpayids = "{";
	   var expenses = "{";
	   var object1 = "";
	   var object2 = "";
	   var object3 = "";
	   if($("input[type='checkbox']").is(':checked')){
	       for(var i=0;i<hobbys.length;i++){
	    	   if(hobbys[i].checked){
	    		  myDataRow(hobbys[i].value,tab);
		 		  if(currRowObjJson.paystatus != 0){
		 			 $.messager.alert("提示","编号："+currRowObjJson.macnum+"机器已付款！")
		 			 return;
		 		  }
		 		 object1 = object1+"'"+i+"':'"+currRowObjJson.id+"'";
		 		 object2 = object2+"'"+i+"':'"+currRowObjJson.renpayid+"'";

		 		  var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
		 		  object3 = object3+"'"+i+"'"+":'"+payTotal+"'";
		 		  sum = parseInt(sum) + parseInt(payTotal);
		 		 
		 		 if(i < hobbys.length-1){
		 			object1 += ",";
		 			object2 += ",";
		 			object3 += ",";
		 		 }
		 		 
	    	   }
	 		  
	 	   }
	       resourcesids += object1 + "}";
	       renpayids　+=　object2 + "}";
	       expenses += object3 + "}";     
	       var canPayTotal = parseFloat(currRowObjJson.accbal) + parseFloat(currRowObjJson.creded);
	       if (sum > canPayTotal) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				return;
		   }
	       var str = "批量缴费总额:<span style='color:red;font-size:14px;'> " + sum +"元 </span><br><br>" +
			"<span style='margin-left:40px;'>确定为服务器进行付款吗？</span><br><br>";
	       $.messager.confirm('Confirm',str,function(r){
				if (r){
					var url = "/customerMan/batchPayMoneyRes.action";
					var params = {"cusid":currClickCusid,"payTotal":sum,"expenses":expenses,"resourcesids":resourcesids,"renpayids":renpayids,"resType":resType,"maid":currMasterid,"paytype":"payres"};
					$.post(url,params,function(result){
						var rs = $.trim(result);
						if (rs > 0) {
							//刷新当前客户余额
							queryBalance();
							//刷新当前表的数据 
							if(payMark=='danjiRes'){
								//当前刷新的是单机资源表
								queryDangJiRes (resType);
							}else{
								//当前刷新的是机柜资源
								queryRes (resType);
							}
							$.messager.show({
								title: '提 示',
								msg: '支付成功！'
							});
						} else {
							 $.messager.alert("操作提示", "支付失败！","error"); 
						}
				  	});
				}
			});
	   }else{
		   $.messager.alert("提示","无选中项")
	   }
	   
	}

	//打开批量续费窗口
	function openBatchRenewalWindow(tab){
		var hobbys = $(tab+" #payment");
		   var sum = parseInt(0);
		   var sumprice = 0;
		   resourcesids = "{";
		   begintime = "{";
		   renprice = "{";
		   if($("input[type='checkbox']").is(':checked')){
		       for(var i=0;i<hobbys.length;i++){
		    	   if(hobbys[i].checked){
		    		  myDataRow(hobbys[i].value,tab);
			 		  if(currRowObjJson.paystatus == 0){
			 			 $.messager.alert("提示","当前为未付款状态，不能操作续费，请先操作付款当前资源")
			 			 return;
			 		  }
			 		resourcesids = resourcesids+"'"+i+"':'"+currRowObjJson.id+"'";
			 		begintime = begintime+"'"+i+"':'"+currRowObjJson.renendtime+"'";	
			 		renprice = renprice+"'"+i+"':'"+currRowObjJson.renprice+"'";
			 		sumprice += parseInt(currRowObjJson.renprice);
			 		
			 		 if(i < hobbys.length-1){
			 			resourcesids += ",";
			 			begintime += ",";
			 			renprice += ",";
			 		 }
			 		 
		    	   }
		 		  
		 	   }
		       resType = currRowObjJson.type;
		       resourcesids += "}";
		       begintime += "}";
		       renprice += "}";

		       
		   }else{
			   $.messager.alert("提示","无选中项")
			   return;
		   }
		
		   //查询账户余额、信用额度和真实名字
		   $.ajax({
				url : '/customerMan/queryBalanceAndCredit.action',
				dataType : 'json',
				type : 'post',
				async: false,//使用同步的方式,true为异步方式
				data : {'custid':currClickCusid},//这里使用json对象
				success : function(data){
					cusTruename = custruename;
					accbal = data.accbal;
					creded = data.creded;
				},
				fail:function(){
					$.messager.alert("错误","与服务器数据交换出错！");
				}
				});
		   
		   
		$('#BatchResgoOnRenewalid').dialog('open').dialog('setTitle','续 费');
		$("#BatchResrCusTrueNameid").html(cusTruename);
		$("#BatchResMacnumid").val(currRowObjJson.macnum);
		$("#BatchAccbal").val(accbal);
		$("#BatchCreded").val(creded);
		$("#BatchResrpriceid").val(sumprice);
		
		
	}
	
	//动态显示价格
	function BatchFormatPriceRes (value) {
		var rpriceid = $("#BatchResrpriceid").val();
		if (rpriceid) {
			return value+"月"+(rpriceid*value)+" 元";
		}
	}
	
	//提交批量续费
	function BatchRessubRenewal(){

		var addsc = $('#BatchResaddrenscid').slider('getValue');
		var newPrice = $("#BatchResrpriceid").val();
		
		if (addsc==0) {
			$.messager.alert("提示","请选择续费时长！");
			return;
		}
		
		var str;
		if(!res_cabinetid){
			str = '确定要续费主机编号为【'+currRowObjJson.macnum+'】的资源吗？';
		}else{
			str = '确定要续费机柜编号为【'+res_cabinetid+'】的资源吗？';
		}
		
		$.messager.confirm("Confirm",str,function(r){
			if(r){
				var payCount = parseFloat(newPrice)*parseInt(addsc);
				var canPayCount = parseFloat(accbal)+parseFloat(creded);
				if(payCount>canPayCount){
					$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
					return;
				}
				
				
				//var params = {"addsc":addsc,"begintime":renbegintime,"resourcesid":resourcesid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"resType":resType,"renpayid":currRowObjJson.renpayid,"maid":currMasterid,"paytype":"renewres"};
				var url ="/customerMan/batchSubRenewalRes.action";
				var params = {"addsc":addsc,"begintime":begintime,"resourcesid":resourcesids,"renprice":renprice,"cusid":currClickCusid,"resType":resType,"maid":currMasterid,"paytype":"renewres"};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					if(rs==1){
						$.messager.show({
							title: '提 示',
							msg: '续费支付成功!'
						});
						
						$('#BatchResaddrenscid').slider('setValue',0);
						$('#BatchResgoOnRenewalid').dialog('close');													
						//刷新当前客户余额
						queryBalance();
						//刷新当前表的数据
						queryDangJiRes (resType);
						queryMacResDetail();
					}else {
						$.messager.show({
							title: 'ERROR',
							msg: '续费失败，请联系管理员!'
						});
					}
				});
			}
		});		
	}
	
	//currbizPayStatus记录当前业务单的付款状态，当业务单处理未付款状态时，不能再继续续费，只能修改价格。
	var rescurrbizPayStatus = undefined;
	function goOnRenewalRes() {
		var cusTruename;
		if (currRowObjJson) {
				$.ajax({
					url : '/customerMan/queryBalanceAndCredit.action',
					dataType : 'json',
					type : 'post',
					async: false,//使用同步的方式,true为异步方式
					data : {'custid':currRowObjJson.customerid},//这里使用json对象
					success : function(data){
						cusTruename = data.custruename;
					},
					fail:function(){
						$.messager.alert("错误","与服务器数据交换出错！");
					}
					});
			rescurrbizPayStatus = currRowObjJson.paystatus;
			$('#resgoOnRenewalid').dialog('open').dialog('setTitle','续 费');
			$("#resrCusTrueNameid").html(cusTruename);
			//$("#rescabinetid").val(currRowObjJson.cabinetid);
			//$("#cabrrenscid").val(currRowObjJson.rensc);
			$("#resrpriceid").val(currRowObjJson.renprice);
			resrprice = currRowObjJson.renprice;
			$("#resrrenbegintimeid").val(currRowObjJson.renbegintime);
			$("#resMacnumid").val(currRowObjJson.macnum);
			$("#resrrenendtimeid").val(currRowObjJson.renendtime);
			$("#resid").val(currRowObjJson.id);
			$("#res_mrcusid").val(currRowObjJson.customerid);
		}
	}

	//修改资源价格
	var oldpriceValRes= undefined;
	function changePriceRes(inputPriceid,textid) {
		textid = "#" + textid;
		inputPriceid = "#" + inputPriceid;
		var ahtml = $(textid).html();
		
		if (ahtml == '[修改价格]') {
			$(textid).html('[取消修改]');
			$(inputPriceid).attr("disabled",false);
			oldpriceValRes = $(inputPriceid).val();
		} else if (ahtml == '[取消修改]') {
			$(textid).html('[修改价格]');
			$(inputPriceid).attr("disabled","disabled");
			$(inputPriceid).val(oldpriceValRes);
		}
	}

	//动态显示价格
	function formatPriceRes (value) {
		var rpriceid = $("#resrpriceid").val();
		if (rpriceid) {
			return value+"月"+(rpriceid*value)+" 元";
		}
	}

	//资源提交续费
	function ressubRenewal () {
		var addsc = $('#resaddrenscid').slider('getValue');
		var newPrice = $("#resrpriceid").val();
		//如果当前业务单在未付款的情况下，不能继续操作续费功能
		if (rescurrbizPayStatus == 0 ) {
			$.messager.alert("提示","当前为未付款状态，不能操作续费，请先操作付款当前资源");
			return;
		}

	/*	//判断子IP类型
		 if(currRowObjJson.dxip !=undefined){
				resType=3;
			}else if(currRowObjJson.unip !=undefined){
				resType=4;
			}*/
		if( isNaN(parseInt(currRowObjJson.type))){
			$.messager.alert("提示","数据异常！");
			return;
		}
		resType=currRowObjJson.type;
		//如果没有修改价格，也没有选择续费时长，则做出提示，方法停止。
		if ((!oldpriceValRes && addsc == 0) || (oldpriceValRes==newPrice && addsc == 0)) {
			$.messager.alert("提示","请修改价格或者续费时长！");
			return;
		}
		var str;
		if(!currRowObjJson.macnum){
			str = '确定要续费机柜编号为【'+currRowObjJson.cabinet+'】的资源吗？';
			if (addsc == 0) {
				str = '确定要修改机柜编号为【'+currRowObjJson.cabinet+'】资源的价格吗？';
			}
		}else{
			str = '确定要续费主机编号为【'+currRowObjJson.macnum+'】的资源吗？';
			if (addsc == 0) {
				str = '确定要修改主机编号为【'+currRowObjJson.macnum+'】资源的价格吗？';
			}
		}
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var renbegintime = $("#resrrenendtimeid").val();
				var resourcesid = $("#resid").val();//资源记录的id
				var renprice = $("#resrpriceid").val();
				var rnote = $("#resrnoteid").val();
				var currClickCusid=$("#res_mrcusid").val();
				rnote = $.trim(rnote);
				var url = "/customerMan/subRenewalRes.action";
				var params = {"addsc":addsc,"begintime":renbegintime,"paystatus":rescurrbizPayStatus,"operator":operator,"id":resourcesid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"resType":resType,"renpayid":currRowObjJson.renpayid,"maid":currMasterid,"paytype":"renewres"};
				//payTot 目前续费总共要支付的费用
				var payTot = undefined;
				//如果点击过修改价格，则要跑审核流程；否则就直接续费
				if (oldpriceValRes) {
					if (renprice != oldpriceValRes) {
						//确实修改价格,跑流程所需要的参与不同，所有要重新定义params.     "cabinetid":cabinetid,
						params = {"oldpriceVal":oldpriceValRes,"addsc":addsc,"begintime":renbegintime,"resourcesid":resourcesid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"goflow":"goflow","resType":resType,"renpayid":currRowObjJson.renpayid};
						payTot = renprice * addsc;
						
					} else {
						//点击过修改价格后，又取消了，所以要记录原来的价格去计算
						payTot = oldpriceValRes * addsc;
					}
				} else {
					payTot = renprice * addsc;
				}
				//余额加信用度不够支付
				var canPay = parseInt($("#balanceValid").val()) + parseInt($("#credeValid").val());
				if (payTot > canPay) {
					$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
					$('#resaddrenscid').slider('setValue',0);
					return;
				}
				
				//提交
				$.post(url,params,function(result){
					var rs = $.trim(result);
					if (rs > 0) {
						if (rs == 3) {
							$.messager.show({
								title: '提 示',
								msg: '修改单价成功!'
							});
						} else if(rs==1) {
							$.messager.show({
								title: '提 示',
								msg: '续费支付成功!'
							});
						}else{
							$.messager.show({
								title: '提 示',
								msg: '已经提交到上一级审核!'
							});
						}
						$('#resaddrenscid').slider('setValue',0);
						$('#resaupdatePriceid2').html('[修改价格]');
						$('#resrpriceid').attr("disabled","disabled");
						$('#resgoOnRenewalid').dialog('close');
						//清空oldpriceValRes值
						oldpriceValRes=undefined;
						//刷新当前客户余额
						queryBalance();
						//刷新当前表的数据
						queryDangJiRes (resType);
						queryMacResDetail();
					} else {
						$.messager.show({
							title: 'ERROR',
							msg: '续费失败，请联系管理员!'
						});
					}
			  	});
			}
		});
	}
	
	//为资源付款
	function payBizRes () {
		if (currRowObjJson) {
			if (currRowObjJson.paystatus == 0) {
				var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
				var canPayTotal;
				var num;
					$.ajax({
						url : '/customerMan/queryBalanceAndCredit.action',
						dataType : 'json',
						type : 'post',
						async: false,//使用同步的方式,true为异步方式
						data : {'custid':currRowObjJson.customerid},//这里使用json对象
						success : function(data){
							canPayTotal = parseFloat(data.accbal) + parseFloat(data.creded);
						},
						fail:function(){
							$.messager.alert("错误","与服务器数据交换出错！");
						}
						});
				var str = '';
				
					str += "机器编号:"
					num = currRowObjJson.macnum;
				
				if (payTotal > canPayTotal || isNaN(canPayTotal)) {
					$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
					return;
				}
					resType=currRowObjJson.type;
					var resString;
				switch(parseInt(resType)){
				case 1:
					resString = "带宽";
					break;
				case 2:
					resString = "防护";
					break;
				case 3:
					resString = "电信IP";
					break;
				case 4:
					resString = "联通IP";
					break;
				}
				str += "<span style='color:red;font-size:14px;'>" + num + "</span><br><br>" +
					"<span style='margin-left:40px;color:red;font-size:14px;'>缴费总额: " + payTotal +"元 </span><br><br>" +
					"<span style='margin-left:40px;'>确定为"+"<span style='color:red;font-size:14px;'>"+resString+"资源</span>"+"进行付款吗？</span><br><br>";
				$.messager.confirm('资源付款',str,function(r){
					if (r){
						var url = "/customerMan/payMenoyRes.action";
						//var url="";
						var params = {"cusid":currClickCusid,"payTotal":payTotal,"resourcesid":currRowObjJson.id,"renpayid":currRowObjJson.renpayid,"resType":resType,"maid":currMasterid,"paytype":"payres"};
						$.post(url,params,function(result){
							var rs = $.trim(result);
							if (rs > 0) {
								//刷新当前客户余额
								queryBalance();
								//刷新当前表的数据 
								queryDangJiRes (resType);
								queryMacResDetail();
								$.messager.show({
									title: '提 示',
									msg: '支付成功！'
								});
							} else {
								 $.messager.alert("操作提示", "支付失败！","error"); 
							}
					  	});
					}
				});
			} else {
				$.messager.alert("提示","此资源已付款！")
			}
		} 
	}
	
	//打开下架资源弹框
	function openXjResWindow2(){
		$('#xjResWindow2').dialog('open').dialog('setTitle','资源下架');
	}

	//打开下架资源弹框
	function openXjResWindow(){
		$('#xjResWindow').dialog('open').dialog('setTitle','资源下架');
	}
	
	/**
	 * 资源下架
	 * */
	function xjResources ( ) {
		
		var reason = dotran($("#resReason2").val());
		if(!reason){
			checkImgShow("#resReasonMes2",-1,'必填');
			return;
		}else{
			checkImgShow("#resReasonMes2",2);
		}
		

		var str='';
			if (currRowObjJson.type=='1'){
				str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
				"带宽资源:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span>M  下架吗？";
			}else if(currRowObjJson.type=='2'){
				str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
				"防护资源:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span> G 下架吗？";
			}
				
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var shelvesOperatorId = currMasterid;
				var url = "/customerMan/xjResources.action";
				var params = {"id":currRowObjJson.id,"danjiZhenggui":"-1","bizid":currRowObjJson.bizid,"cusbizid":currRowObjJson.cusbizid,"dk":currRowObjJson.res,"fh":currRowObjJson.res,"type":currRowObjJson.type,"reason":reason,"shelvesOperatorId":shelvesOperatorId};
				
				$.post(url,params,function(result){
					$('#xjResWindow2').dialog('close');
					$('#resReason2').val('')
					var rs = $.trim(result);
					alert(rs)
					if (rs > 0) {
						queryDangJiRes (resType);
						queryMacResDetail();
						$.messager.show({
							title: '提 示',
							msg: '资源下架成功！'
						});
					} else {
						 $.messager.alert("操作提示", "资源下架失败！","error"); 
					}
				 	});
			}
		});
		
	}
	
	//资源修改按钮
	function xgResources(){
		$('#updateResourcesInfo').dialog('open').dialog('setTitle','修改单机资源信息');	
		/*$("#updaterensc").val(currRowObjJson.rensc);
		alert(currRowObjJson.rensc);*/
		$("#updatejg").val(currRowObjJson.renprice);
	}
	
	//修改资源价格
	function updateResourcesInfo(){
		var renprice=$("#updatejg").val();
		var id=currRowObjJson.renpayid;
		var url="/customerMan/updateResourcesInfo.action";
		var params={'id':id,'renprice':renprice};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			if (rs) {
				queryDangJiRes (currRowObjJson.type);
				$.messager.show({
					title: '提 示',
					msg: '已成功修改资源价格！'
				});
				$('#updateResourcesInfo').dialog('close');
				}
	  		});
	}
	
	function deleteIP (){
		
		var reason = dotran($("#resReason").val());
		if(!reason){
			checkImgShow("#resReasonMes",-1,'必填');
			return;
		}else{
			checkImgShow("#resReasonMes",2);
		}
		
		
		var str='';
			if (currRowObjJson.type=='3'){
				str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
				"电信副IP:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span>  删除吗？";
			}else if(currRowObjJson.type=='4'){
				str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
				"联通副IP:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span>  删除吗？";
			}
		
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var shelvesOperatorId = currMasterid;
				var url = "/customerMan/deleteIP.action";
				var params;
					params = {"resourcesid":currRowObjJson.id,"dxip":currRowObjJson.res,"unip":currRowObjJson.res,"type":currRowObjJson.type,"cusbizid":currRowObjJson.cusbizid,"renpayid":currRowObjJson.renpayid,"maid":currMasterid,"shelvesOperatorId":shelvesOperatorId,"reason":reason};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					$("#xjResWindow").dialog('close');
					$("#resReason").val('');				
					if (rs > 0) {
						tabChangeMacRes('3','iptabm');
						queryDangJiRes (resType);
						queryMacResDetail();
						$.messager.show({
							title: '提 示',
							msg: '删除成功！'
						});
					} else {
						 $.messager.alert("操作提示", "删除失败！","error"); 
					}
				 	});
			}
		});
	}
	
	//综合部直接修改业务单信息
	function updateInfo () {
		$('#updateBizInfo').dialog('open').dialog('setTitle','修改业务单信息');
		$("#updatebtid").html("");
		$("#uptadecpnum").val(currRowObjJson.proNum);
		//$("#updatebtid").val(currRowObjJson.businesstypeid);
		$("#updatedk").val(currRowObjJson.dk);
		$("#updatefh").val(currRowObjJson.fh);
		$("#updatedj").val(currRowObjJson.renprice);
		getbusinessIdTypes();
	}
	
	function getbusinessIdTypes (){
		var url = '/customerMan/getbusinessTypes.action';
		var params = {};
		var rs = "";
		var hdaddcab=$("#updatebtid");
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				if (result) {			
					for(var i = 1 ; i < result.length; i++){
						var key = result[i]["key"];
						var value =result[i]["value"];
						hdaddcab.append("<option id='id" + key + "' value='"+key+"'>"+value+"</option>");
					}
					hdaddcab.append("<option id='id" + result[0]["key"] + "' value='"+result[0]["key"]+"'>"+result[0]["value"]+"</option>");
					$("#id"+currRowObjJson.businesstypeid).attr("selected","true");
				}
			}
		});
	}
	
	//提交修改
	function subUpdateBizInfo () {
		var proNum=$("#uptadecpnum").val();
		var businesstypeid=$("#updatebtid").val();
		var dk = $("#updatedk").val();
		var fh = $("#updatefh").val();
		var renprice = $("#updatedj").val();
		var id = currRowObjJson.id;
		var url = "/customerMan/updateBizInfoByzh.action";
		if (!id) {
			$.messager.alert('Errors','错误代码：subUpdateBizInfo,获取业务单信息失败，请联系管理员');
			return;
		}
		if (!dk || !fh || !renprice) {
			$("#uErrorid").html('提示：输入框内容不能为空值.');
			return;
		} else {
			$("#uErrorid").html('');
		}
		var params = {"id":id,"dk":dk,"fh":fh,"renprice":renprice,"proNum":proNum,"businesstypeid":businesstypeid};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				$('#updateBizInfo').dialog('close');
				//刷新当前表的数据
				loadSoldMacs('goOncurrpage','notcabmac');
				myMesShow ("提示","业务单信息修改成功");
			} else {
				$.messager.alert('Errors','错误代码：subUpdateBizInfo,业务单信息更新失败，请联系管理员');
				return;
			}
		});
	}