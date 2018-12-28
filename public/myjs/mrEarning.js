var comproomlist;
var restypelist = [{k:"1",v:"带  宽"},{k:"2",v:"防  护"},{k:"3",v:"电信IP"},{k:"4",v:"联通IP"}];
$(document).ready(function(){
	initComproomList();
	loadComproom('comproom_mac');
	loadPayDataGrid();
});
//初始化业务数据表格与表格的按钮事件
function loadPayDataGrid () {
	//表头
	var dataFiles = ["comproom","macnum","custruename","note","periodPay","usedDays","residuePay","residueDays","dayprice","renPrice","totalPrice","renbegintime","renendtime","truename"];
	//行内按钮
	var clickbutton = "";//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
	//格式化字段
	var formatFileds = {"comproom":"1-湖南衡阳,5-广东惠州,7-腾正机房,2-东莞美佳,6-东莞科技园,4-沈阳,3-广东佛山"};//{"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
	
	//分页配置
	var pageEvent = {"action":"/financ/loadMacEarning.action"};
	var showTableId = "#payDataId";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	var results = createDataGridJsonRows['sumrs'];
	var startDTime = createDataGridJsonRows['startDTime'];
	var stopDTime = createDataGridJsonRows['stopDTime'];
	var footMes = "当前" + createDataGridJsonRows['total'] + "条数据，" + startDTime + "到" + stopDTime + "期间机器租金收入结算：" + results + "元";
	$("#footMesid").html(footMes);
}

//高级查询
function searchmacFinanc(accbalParam) {
	var custruename = $("#custruenameid").val();
	var startDTime = $("#paydateid").datebox("getValue");
	var stopDTime = $("#payenddateid").datebox("getValue");
	var checkdate = compareDate(startDTime,stopDTime);
	if (checkdate) {
		$.messager.alert("提 示",checkdate);
		return;
	}
	var macnum = $("#macnumid").val();
	var truename = $("#truenameid").val();
	var comproom = $("#comproom_mac").combobox('getValue');
	var params = {"comproom":comproom,"custruename":custruename,"startDTime":startDTime,"stopDTime":stopDTime,"macnum":macnum,"truename":truename};
	var url = "/financ/loadMacEarning.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			//表头"macnum","dk","fh","renprice","dxip","unicomip","cabinet","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus"
        	var dataFiles = ["comproom","macnum","custruename","note","periodPay","usedDays","residuePay","residueDays","dayprice","renPrice","totalPrice","renbegintime","renendtime","truename"];
			//行内按钮
			var clickbutton = "";//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
			//格式化字段
			var formatFileds = {"comproom":"1-湖南衡阳,5-广东惠州,7-腾正机房,2-东莞美佳,6-东莞科技园,4-沈阳,3-广东佛山"};// {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
			//分页配置
			var urlParams = "/financ/loadMacEarning.action?urlParams=urlParams" + "&truename=" + encodeURI(encodeURI(truename)) +"&custruename=" + encodeURI(encodeURI(custruename)) + "&startDTime=" + startDTime + "&stopDTime=" + stopDTime + "&macnum=" + macnum + "&comproom=" + comproom;
			var pageEvent = {"action":urlParams};
			var showTableId = "#payDataId";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			var results = result['sumrs'];
			var footMes = "当前" + result['total'] + "条数据，" + result["startDTime"] + "到" + result["stopDTime"] + "期间机器租金收入结算：" + results + "元";
			$("#footMesid").html(footMes);
		}
	});
}



function tabChange2 (checkStatu,liidparm) {
	//改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#tabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	
	//改变内容
	if (!checkStatu || checkStatu == '-1') {
		//初始化输入文本框
		$("#macnumid").val("");
		$("#custruenameid").val("");
		$("#truenameid").val("");
		$("#paydateid").datebox("setValue",'');
		$("#payenddateid").datebox("setValue",'');
		loadComproom('comproom_mac');
		//$("#comproom_mac").combobox("setValue",'');
		searchmacFinanc();
		$("#payDataId").show();
		$("#payDataIdCab").hide();
		$("#payDataIdRes").hide();
	} else if(!checkStatu || checkStatu == '0'){
		//初始化输入文本框
		$("#cabid").val("");
		$("#custruenameidcab").val("");
		$("#truenameidcab").val("");
		$("#paydateidcab").datebox("setValue",'');
		$("#payenddateidcab").datebox("setValue",'');
		loadComproom('comproom_cab');
		//$("#comproom_cab").combobox('setValue','');
		loadPayDataGridCab(); 
		$("#payDataId").hide();
		$("#payDataIdCab").show();
		$("#payDataIdRes").hide();
	} else if(!checkStatu || checkStatu == '1'){
		//初始化输入文本框
		$("#cabidres").val("");
		$("#macnumidres").val("");
		//$("#restypeid").val("");
		$("#custruenameidres").val("");
		$("#truenameidres").val("");
		$("#paydateidres").datebox("setValue",'');
		$("#payenddateidres").datebox("setValue",'');
		loadComproom('comproom_res');
		loadresType();
		loadPayDataGridRes () 
		$("#payDataId").hide();
		$("#payDataIdCab").hide();
		$("#payDataIdRes").show();
	}
}


//-----------------------------------------机柜费用----------------------------------------------------------------------
function loadPayDataGridCab( ) {
	var custruename = $("#custruenameidcab").val();
	var startDTime = $("#paydateidcab").datebox("getValue");
	var stopDTime = $("#payenddateidcab").datebox("getValue");
	var checkdate = compareDate(startDTime,stopDTime);
	if (checkdate) {
		$.messager.alert("提 示",checkdate);
		return;
	}
	var comproom = $("#comproom_cab").combobox('getValue');
	var cabinet = $("#cabid").val();
	var truename = $("#truenameidcab").val();
	var params = {"custruename":custruename,"startDTime":startDTime,"stopDTime":stopDTime,"cabinet":cabinet,"truename":truename,"comproom":comproom};
	var url = "/financ/loadCabinetEarning.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["comproom","cabinetid","custruename","note","usedpay","usedDays","residuepay","residueDays","dayprice","renprice","totalPay","renbegintime","renendtime","truename"];
        	//行内按钮
        	var clickbutton = "";//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
        	//格式化字段
        	var formatFileds = {"comproom":"1-湖南衡阳,5-广东惠州,7-腾正机房,2-东莞美佳,6-东莞科技园,4-沈阳,3-广东佛山"};;
        	//分页配置
        	var pageEvent = {"action":"/financ/loadCabinetEarning.action?urlParams=urlParams" + "&truename=" + encodeURI(encodeURI(truename)) +"&custruename=" + encodeURI(encodeURI(custruename)) + "&startDTime=" + startDTime + "&stopDTime=" + stopDTime + "&comproom=" + comproom};
        	var showTableId = "#payDataIdCab";
        	createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
        	var results = result['sumrs'];
        	var footMes = "当前" + result['total'] + "条数据，" + result["startDTime"] + "到" + result["stopDTime"] + "期间机器租金收入结算：" + results + "元";
        	$("#footMesidcab").html(footMes);
		}
	});
}



//------------------------------------------------------资源费用----------------------------------------------------------------------------------------

function loadPayDataGridRes( ) {
	var custruename = $("#custruenameidres").val();
	var startDTime = $("#paydateidres").datebox("getValue");
	var stopDTime = $("#payenddateidres").datebox("getValue");
	var checkdate = compareDate(startDTime,stopDTime);
	if (checkdate) {
		$.messager.alert("提 示",checkdate);
		return;
	}
	var comproom = $("#comproom_res").combobox('getValue');
	var cabinet = $("#cabidres").val();
	var macnum = $("#macnumidres").val();
	var restypeid = $("#restypeid").combobox('getValue');
	var truename = $("#truenameidres").val();
	var params = {"custruename":custruename,"startDTime":startDTime,"stopDTime":stopDTime,"cabinet":cabinet,"truename":truename,"macnum":macnum,"restypeid":restypeid,"comproom":comproom};
	var url = "/financ/loadResEarning.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["comproom", "macnum", "custruename", "note", "usedpay", "usedDays", "residuepay", "residueDays", "dayprice", "renprice", "totalpay", "renbegintime", "renendtime"/*, "cabinet"*/, "type", "res", "paydate", "truename"];
        	//行内按钮
        	var clickbutton = "";//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
        	//格式化字段
        	var formatFileds ={"type":"1-带宽,2-防护,3-电信IP,4-联通IP","comproom":"1-湖南衡阳,5-广东惠州,7-腾正机房,2-东莞美佳,6-东莞科技园,4-沈阳,3-广东佛山"};
        	//分页配置
        	var pageEvent = {"action":"/financ/loadResEarning.action?urlParams=urlParams" + "&truename=" + encodeURI(encodeURI(truename)) +"&custruename=" + encodeURI(encodeURI(custruename)) + "&startDTime=" + startDTime + "&stopDTime=" + stopDTime + "&comproom=" + comproom + "&restypeid=" + restypeid + "&macnum=" + macnum};
        	var showTableId = "#payDataIdRes";
        	createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
        	var results = result['sumrs'];
        	var footMes = "当前" + result['total'] + "条数据，" + result["startDTime"] + "到" + result["stopDTime"] + "期间机器租金收入结算：" + results + "元";
        	$("#footMesidres").html(footMes);
		}
	});
}

//装载机房列表
function loadComproom(intag){
	$("#" + intag).combobox({
		data:comproomlist,
		valueField:'comproomid',
		textField:'comproomname'
	});


}

function loadresType(){
	$("#restypeid").combobox({
		data:restypelist,
		valueField:'k',
		textField:'v'
	});
}


function initComproomList(){
	$.ajax({
        url : '/financ/loadCompRoom.action',
        data: null,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
    		comproomlist = result;
        }
    });
}
