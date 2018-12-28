$(document).ready(function(){
	loadqfcusDataGrid();
});
//初始化业务数据表格与表格的按钮事件
function loadqfcusDataGrid () {
	//表头
	var dataFiles = ["custruename","accbal","paytotal","creded","truename","worknum",["cusid","masterid"]];
	//行内按钮
	var clickbutton = {"aMethod":"arrearsDetail-欠费详情-arrearsDetail"};//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
	//格式化字段
	var formatFileds = "";//{"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
	//分页配置
	var pageEvent = {"action":"/financ/laodQkCus.action"};
	var showTableId = "#qfdivid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	var results = createDataGridJsonRows['sumqk'];
	var footMes = "当前" + createDataGridJsonRows['total'] + "条数据总欠款结算：" + results + "元";
	$("#footMesid").html(footMes);
}

//高级查询
function searchqfcus () {
	var custruename = $("#custruenameid").val();
	var params = {"custruename":custruename};
	var url = "/financ/laodQkCus.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			//表头
			var dataFiles = ["custruename","accbal","paytotal","creded","truename","worknum",["cusid","masterid"]];
			//行内按钮
			var clickbutton = {"aMethod":"arrearsDetail-欠费详情-arrearsDetail"};//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
			//格式化字段
			var formatFileds = "";//{"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
			//分页配置
			url = "/financ/laodQkCus.action?urlParams=urlParams&custruename=" + encodeURI(encodeURI(custruename));
			var pageEvent = {"action":url};
			var showTableId = "#qfdivid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			
			var results = createDataGridJsonRows['sumqk'];
			var footMes = custruename + "当前" + createDataGridJsonRows['total'] + "条数据总欠款结算：" + results + "元";
			$("#footMesid").html(footMes);
		}
	});
}

//欠费详情
function arrearsDetail () {
	$("#custname").html(currRowObjJson.custruename);
	var params = {"cusid":currRowObjJson.cusid};
	var url = "/financ/queryQfDetail.action";
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
				var dataFiles = ["cabinet","macnum","price","overdraft","arrearsdate","projectname",["bizid","cusbizid","cusid","projectid"]];
				//行内按钮
				var clickbutton = "";
				//格式化字段
				var formatFileds = "";
				//分页配置
				var pageEvent =  {"action":"/financ/queryQfDetail.action?cusid="+currRowObjJson.cusid};
				var showTableId = "#qfdetaildivid";
				$("#qfdetaildivid").show();
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
        }
	});
}
function hiddenCabDetail(){
	$("#qfdetaildivid").hide();
}