//currCusOfMaid2根据加载顺序需要，必须要放在loadBusDataGrid之前.
var currCusOfMaid2 = undefined;

$(function(){
	loadBusDataGrid();
	initCheckinghosting(currClickCusid);
	initCheckingRent(currClickCusid);
});

//初始化业务数据表格与表格的按钮事件
function loadBusDataGrid () {
	//表头
	var dataFiles = ["dxip","unicomip","renprice","dk","fh","paystatus","macxjstatus",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","macnum","rensc"]];
	//行内按钮
	var clickbutton = {"aMethod":"askQuestion-提问-askQuestion-white,payBizMac-付款-payBizMac,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
	if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39) {
		//业务管理员在添加机器时，管理员直接添加到客户原来所属的业务员名下
		currCusOfMaid2 = currCusOfMaid;
	} else {
		currCusOfMaid2 = undefined;
	}
	//格式化字段
	var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费"};
	//分页配置
	var pageEvent = {"action":"/customerMan/loadCusMacs.action?cusid="+currClickCusid};
	var showTableId = "#busDataid";
	$("#busDataFootid").show();
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//重载客户主机数据表
function reloadMyCurrCusData () {
	var url = "/customerMan/loadCusMacs.action";
	var params = {"cusid":currClickCusid};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["dxip","unicomip","renprice","dk","fh","paystatus","macxjstatus",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","macnum","rensc"]];
				//行内按钮
				var clickbutton = {"aMethod":"askQuestion-提问-askQuestion-white,payBizMac-付款-payBizMac,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
				if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39) {
					//业务管理员在添加机器时，直接添加到客户原来所属的业务员名下
					currCusOfMaid2 = currCusOfMaid;
				} else {
					currCusOfMaid2 = undefined;
				}
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadCusMacs.action?cusid="+currClickCusid};
				var showTableId = "#busDataid";
				$("#busDataFootid").show();
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//--------工具栏功能---------------


//显示一台租用服务器供选择
function getpassMacidOfCusPage (searchOneMacLike) {
	$("#getOneMacid").show();
	var param = "";
	if (searchOneMacLike) {
		var inputVal = $("#inputSearchOneMacid").val();
		param = {"inputVal":inputVal};
	}
	var url = "/customerMan/queryOneMacOfCuspage.action";
	$.post(url,param,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			var createDataGridJsonRows = JSON.parse(rs);
			//表头
			var dataFiles = ["dxip","unicomip",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","macnum","rensc","cabinet"]];
			//行内按钮
			var clickbutton = {"aMethod":"getPasswordMsc-获 取-getPasswordMsc "};
			//格式化字段
			var formatFileds = {"used":"0-未使用,1-已经使用"};
			//分页配置
			var loadurl = "";
			var pageEvent = "";
			var showTableId = "#getOneMacid";
			createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,1,formatFileds);
		}
  	});
}

//租用工单填写
function getPasswordMsc () {
	if (currRowObjJson) {
		var url = "/wap/mas/rent.jsp";
		$.post(url,"",function(rs){
			$("#wapContentsid").html($.trim(rs));
				$("#currCusOfMaid").val(currCusOfMaid);
				$("#cusid").val(currClickCusid);
				$('#macnumid').attr("readonly","readonly");
				$('#unicomipid').attr("readonly","readonly");
				$('#dxipid').attr("readonly","readonly");
				$('#cabinetid').attr("readonly","readonly");
				$("#cusbiztruenameid").html(custmoerName);
				$("#cusbiznameid").html(cusname);
				$("#macnumid").val(currRowObjJson.macnum);
				$("#cabinetid").val(currRowObjJson.cabinet);
				$("#dxipid").val(currRowObjJson.dxip);
				$("#unicomipid").val(currRowObjJson.unicomip);
				$("#cusid").html(currRowObjJson.customerid);
				$("#bizTypeid").html("租 用");
		});
	}
}
//托管工单填写
function addhostingmac () {
	var url = "/wap/mas/hosting.jsp";
	$.post(url,"",function(rs){
		$("#wapContentsid").html($.trim(rs));
		$("#currCusOfMaid").val(currCusOfMaid);
		$("#cusid").val(currClickCusid);
		$("#macnumid").focus();
		$("#cusbiztruenameid").html(custmoerName);
		$("#cusbiznameid").html(cusname);
		$("#bizTypeid").html("托 管");
	});
}

//恢复客户的登录密码为123456
function restorePass () {
	var str = '确定恢复客户【'+custmoerName+'】的登录密码为初始密码吗？';
	var cusid = currClickCusid;
	if (confirm(str)) {
		url = '/customerMan/updateCustomerPass.action?cusid='+cusid;
		$.post(url,"",function(result){
			var rs = $.trim(result);
			if (rs > 0){
				alert('已经成功为客户恢复登录密码为123456');
			} else {
				alert('恢复初始密码失败，请联系管理员！');
			}
		});
	}
}

//充值
function openToUp () {
	var url = "/wap/mas/toup.jsp";
	$.post(url,"",function(rs){
		$("#wapContentsid").html($.trim(rs));
		$("#toupnameid").html(custmoerName);
		$("#currCusValid").val(currClickCusid);
	});
}



//通过查询IP(包括子IP)去查询当前业务员的客户主机.
function searchMacOfAllIps () {
	var ipval = $.trim($("#searchIpValid").val());
	if (!ipval) {
		return;
	}
	var url = "/customerMan/searchMacOfAllIps.action";
	var params = {"cusid":currClickCusid,"searchIpValid":ipval};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["dxip","unicomip","renprice",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","macnum","rensc"]];
				//行内按钮
				var clickbutton = {"aMethod":"askQuestion-提问-askQuestion-white,payBizMac-付款-payBizMac,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = "";
				var showTableId = "#busDataid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
				$("#busDataFootid").hide();
			}
		}
  	});
}

//弹出提问输入窗口
function askQuestion () {
	if (currRowObjJson) {
		$.post('/wap/mas/ask.jsp',"",function(result){
			$("#wapContentsid").html(result);
	  	});
	}
}

//针对当前主机提交问题
function wapSubcontent (webeditSubUrl,iframName) {
	if (currRowObjJson) {
		var contents = document.getElementById('webeditfrm').contentWindow.getEditor(); 
		if ($.trim(contents)=="") {
			return;
		}
		var macnum = currRowObjJson.macnum;
		var dxip = currRowObjJson.dxip;
		var unicomip = currRowObjJson.unicomip;
		var custid = currRowObjJson.customerid;
		var params = {"contents":contents,"macnum":macnum,"unicomip":unicomip,"dxip":dxip,"custid":custid};
		$.post(webeditSubUrl,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				document.getElementById('webeditfrm').contentWindow.setContent("");
			} else {
				alert('提交问题失败,请联系管理员！');
			}
	  	});
	}
}

//查询账户信息
function queryBalance () {
	var url = "/customerMan/queryBalance.action";
	var params = {"cusid":currClickCusid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs) {
			$("#balanceid").html(rs);
			$("#balanceValid").val(rs)
		}
  	});
}

//由业务人员付款机器
function payBizMac () {
	if (currRowObjJson) {
		if (currRowObjJson.paystatus != 1) {
			var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
			var canPayTotal = parseFloat(currRowObjJson.accbal) + parseFloat(currRowObjJson.creded);
			if (payTotal > canPayTotal) {
				alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				return;
			}
			var str = "编号【" + currRowObjJson.macnum + "】" + currRowObjJson.rensc + "个月缴费总额: " + payTotal +"元,确认支付?";
			if (confirm(str)){
				var url = "/customerMan/payMenoy.action";
				var params = {"cusid":currClickCusid,"payTotal":payTotal,"bizid":currRowObjJson.id,"renpayid":currRowObjJson.renpayid};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					if (rs > 0) {
						//刷新当前客户余额
						queryBalance();
						//刷新当前表的数据
						reloadMyCurrCusData();
					} else {
						alert("网络异常,请重新支付！"); 
					}
			  	});
			}
		} else {
			$.messager.alert("提示","此机器已付款！")
		}
	} 
}

//主机业务下架
function updateMacxjstatus () {
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus == 1) {
			var mes = "编号["+currRowObjJson.macnum+"]的主机已经申请下架!";
			alert(mes);
			return;
		}
		
		var str = '确定要把主机编号为【'+currRowObjJson.macnum+'】的下架吗？';
		if (confirm(str)){
			var url = "/customerMan/updateMacxjstatus.action";
			var parmas  = {"id":currRowObjJson.id,"macxjstatus":"1"};
			$.post(url,parmas,function(result){
	    		var rs = $.trim(result);
	    		if (rs > 0) {
	    			alert('已成功提交客服处理');
	    			reloadMyCurrCusData(currRowObjJson.customerid);
	    		} else {
	    			alert('网络异常,下架失败');
	    		}
	  		});
		}
	}
}


$("#ss").bind ( 'click' , function(){ 
	$(this).val('');
});