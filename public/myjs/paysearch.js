
$(document).ready(function(){
	loadPayDataGrid();
});
//初始化业务数据表格与表格的按钮事件
function loadPayDataGrid () {
	//表头
	var dataFiles = ["custruename","macnum","paymoney","cpnote","truename","paydate","dk","fh","renprice","dxip","unicomip","cabinet","renbegintime","renendtime","rensc","biztype",["id","customerid"]];
	//行内按钮
	var clickbutton = "";//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
	//格式化字段
	var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
	//分页配置
	var pageEvent = {"action":"/financ/loadPaySearch.action"};
	var showTableId = "#payDataId";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	var results = createDataGridJsonRows['sumrs'];
	var footMes = "当前" + createDataGridJsonRows['total'] + "条数据业绩结算：" + results + "元";
	$("#footMesid").html(footMes);
}

//高级查询
function searchxfjl(accbalParam) {
	var custruename = $("#custruenameid").val();
	var paydate = $("#paydateid").datebox("getValue");
	var payenddate = $("#payenddateid").datebox("getValue");
	var checkdate = compareDate(paydate,payenddate);
	if (checkdate) {
		$.messager.alert("提 示",checkdate);
		return;
	}
	var macnum = $("#macnumid").val();
	var truename = $("#truenameid").val();
	var params = {"custruename":custruename,"paydate":paydate,"payenddate":payenddate,"macnum":macnum,"truename":truename};
	var url = "/financ/loadPaySearch.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			//表头"macnum","dk","fh","renprice","dxip","unicomip","cabinet","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus"
			var dataFiles = ["custruename","macnum","paymoney","cpnote","truename","paydate","dk","fh","renprice","dxip","unicomip","cabinet","renbegintime","renendtime","rensc","biztype",["id","customerid"]];
			//行内按钮
			var clickbutton = "";//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
			//格式化字段
			var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
			//分页配置
			var urlParams = "/financ/loadPaySearch.action?urlParams=urlParams" + "&truename=" + encodeURI(encodeURI(truename)) +"&custruename=" + encodeURI(encodeURI(custruename)) + "&paydate=" + paydate + "&payenddate=" + payenddate + "&macnum=" + macnum;
			var pageEvent = {"action":urlParams};
			var showTableId = "#payDataId";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			var results = result['sumrs'];
			var footMes = truename + "当前" + result['total'] + "条交易数据业绩结算：" + results + "元";
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
		
		loadPayDataGrid();
		$("#payDataId").show();
		$("#payDataIdCab").hide();
		$("#payDataIdRes").hide();
		$("#payDataIdOther").hide();
	} else if(!checkStatu || checkStatu == '0'){
		//初始化输入文本框
		$("#cabid").val("");
		$("#custruenameidcab").val("");
		$("#truenameidcab").val("");
		$("#paydateidcab").datebox("setValue",'');
		$("#payenddateidcab").datebox("setValue",'');
		
		loadPayDataGridCab ( ); 
		$("#payDataId").hide();
		$("#payDataIdCab").show();
		$("#payDataIdRes").hide();
		$("#payDataIdOther").hide();
	} else if(!checkStatu || checkStatu == '1'){
		//初始化输入文本框
		$("#cabidres").val("");
		$("#macnumidres").val("");
		$("#restypeid").val("");
		$("#custruenameidres").val("");
		$("#truenameidres").val("");
		$("#paydateidres").datebox("setValue",'');
		$("#payenddateidres").datebox("setValue",'');
		
		loadPayDataGridRes () 
		$("#payDataId").hide();
		$("#payDataIdCab").hide();
		$("#payDataIdRes").show();
		$("#payDataIdOther").hide();
	}else if(!checkStatu || checkStatu == '2'){
		
		
		loadPayDataGridOther ();
		$("#payDataId").hide();
		$("#payDataIdCab").hide();
		$("#payDataIdRes").hide();
		$("#payDataIdOther").show();
		
	}
}


//-----------------------------------------机柜费用----------------------------------------------------------------------
function loadPayDataGridCab( ) {
	var custruename = $("#custruenameidcab").val();
	var paydate = $("#paydateidcab").datebox("getValue");
	var payenddate = $("#payenddateidcab").datebox("getValue");
	var checkdate = compareDate(paydate,payenddate);
	if (checkdate) {
		$.messager.alert("提 示",checkdate);
		return;
	}
	var cabinet = $("#cabid").val();
	var truename = $("#truenameidcab").val();
	var params = {"custruename":custruename,"paydate":paydate,"payenddate":payenddate,"cabinet":cabinet,"truename":truename};
	var url = "/financ/paySearchCabMethod.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["custruename","cabinetid","paymoney","cpnote","truename","paydate","dk","fh","renprice","comproomname","renbegintime","renendtime","rensc",["id","customerid","comproom"]];
        	//行内按钮
        	var clickbutton = "";//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
        	//格式化字段
        	var formatFileds = '';
        	//分页配置
        	var urlParams = "/financ/paySearchCabMethod.action?urlParams=urlParams" + "&truename=" + encodeURI(encodeURI(truename)) +"&custruename=" + encodeURI(encodeURI(custruename)) + "&paydate=" + paydate + "&payenddate=" + payenddate + "&macnum=" + macnum;
			var pageEvent = {"action":urlParams};
        	//var pageEvent = {"action":"/financ/paySearchCabMethod.action?urlParams=urlParams" + "&truename=" + encodeURI(encodeURI(truename)) +"&custruename=" + encodeURI(encodeURI(custruename)) + "&paydate=" + paydate + "&payenddate=" + payenddate + "&macnum=" + macnum"};
        	var showTableId = "#payDataIdCab";
        	createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
        	var results = result['sumrs'];
        	var footMes = "当前" + result['total'] + "条数据业绩结算：" + results + "元";
        	$("#footMesidcab").html(footMes);
		}
	});
}



//------------------------------------------------------资源费用----------------------------------------------------------------------------------------

function loadPayDataGridRes( ) {
	var custruename = $("#custruenameidres").val();
	var paydate = $("#paydateidres").datebox("getValue");
	var payenddate = $("#payenddateidres").datebox("getValue");
	var checkdate = compareDate(paydate,payenddate);
	if (checkdate) {
		$.messager.alert("提 示",checkdate);
		return;
	}
	var cabinet = $("#cabidres").val();
	var macnum = $("#macnumidres").val();
	var restypeid = $("#restypeid").val();
	var truename = $("#truenameidres").val();
	var params = {"custruename":custruename,"paydate":paydate,"payenddate":payenddate,"cabinet":cabinet,"truename":truename,"macnum":macnum,"restypeid":restypeid};
	var url = "/financ/paySearchResMethod.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["custruename","cabinet","macnum","type","res","paymoney","cpnote","truename","paydate","renprice","comproomname","renbegintime","renendtime","rensc",["id","customerid","comproom"]];
        	//行内按钮
        	var clickbutton = "";//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
        	//格式化字段
        	var formatFileds ={"type":"1-带宽,2-防护,3-电信IP,4-联通IP"};
        	//分页配置
        	var urlParams = "/financ/paySearchResMethod.action?urlParams=urlParams" + "&truename=" + encodeURI(encodeURI(truename)) +"&custruename=" + encodeURI(encodeURI(custruename)) + "&paydate=" + paydate + "&payenddate=" + payenddate + "&macnum=" + macnum+"&restypeid="+restypeid;
			var pageEvent = {"action":urlParams};
        	//var pageEvent = {"action":"/financ/paySearchResMethod.action"};
        	var showTableId = "#payDataIdRes";
        	createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
        	var results = result['sumrs'];
        	var footMes = "当前" + result['total'] + "条数据业绩结算：" + results + "元";
        	$("#footMesidres").html(footMes);
		}
	});
}

//------------------------------------------------------其他费用----------------------------------------------------------------------------------------
function loadPayDataGridOther( ) {
	AddRunningDiv();
	getconsumeTypes();
	var macnum = $("#macnumidother").val();
	var othertypeid = $("#othertypeid").val();
	var custruename = $("#custruenameidother").val();
	var truename = $("#truenameidother").val();
	var params = {"custruename":custruename,"truename":truename,"macnum":macnum,"othertype":othertypeid};
	var url = "/financv2/paySearchOtherMethod.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["custruename","truename","macnum","comproomname","value","expense","createdate","operator","note",["bizid","oeid","consumetype"]];
        	//行内按钮
        	var clickbutton = "";
        	//格式化字段
        	var formatFileds ="";
        	//分页配置
        	var urlParams = "/financv2/paySearchOtherMethod.action?urlParams=urlParams" + "&truename=" + encodeURI(encodeURI(truename)) +"&custruename=" + encodeURI(encodeURI(custruename)) + "&macnum=" + macnum+"&othertype="+othertypeid;
        	var pageEvent = {"action":urlParams};
        	var showTableId = "#payDataIdOther";
        	createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
        	var results = result['sumrs'];
        	var footMes = "当前" + result['total'] + "条数据业绩结算：" + results + "元";
        	$("#footMesidother").html(footMes);
		}
	});
        	MoveRunningDiv();
}


/**
 * 获取KV表中消费类型数据（关联值：other_expense）
 */
function getconsumeTypes (){
	var url = '/customerMan/getconsumeTypes.action';
	var params = {};
	var rs = "";
	var sladdcab=$("#othertypeid");
	sladdcab.empty();
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				sladdcab.append("<option value=''>---请选择---</option>");
				for(var i = 0 ; i < result.length; i++){
					var key = result[i]["key"];
					var value =result[i]["value"];
					if(key ==4 || key ==3 ){
						continue;
					}
					sladdcab.append("<option value='"+key+"'>"+value+"</option>");
				}
			}
		}
	});
}