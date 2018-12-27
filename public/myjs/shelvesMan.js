$(document).ready(function () {
	loadMyshelvesManDataGrid();
	loadMyshelvesManCabDataGrid();
});
var url; //提交路径
function loadMyshelvesManDataGrid() {
	//表头
	var dataFiles = ["proNum","macnum","custruename","truename","dxip","unicomip","dk","fh","domain","cabinet","renprice","paystatus","renbegintime","renendtime","rensc","biztype","cbNote","macxjstatus",["id","fh","customerid","bizid"]];
	//行内按钮
	var clickbutton = {"aMethod":"callComputerRoom-通知机房-callComputerRoom-white,refusedShelves-拒绝下架-refusedShelves,queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white"};//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
	//格式化字段
	var formatFileds = {"biztype":"0-托管,1-租用","macxjstatus":"1-业务申请下架,2-机房处理中...,4-机房下架清空处理中...","paystatus":"0-未付款,1-已付款,2-过期未续费"};
	//分页配置
	var pageEvent = {"action":"/customerserv/loadMyshelvesMan.action"};
	var showTableId = "#xiajiaTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

function loadMyshelvesManCabDataGrid(){
	// 表头
	var dataFiles = ["proNum","cabinetid","custruename","truename","macnum","dxipcount","unipcount","comproomid","dk","fh","renprice","rensc","renbegintime", "renendtime","sjdate","lssc","macxjstatus","paystatus", [ "id","comproomname","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproom"] ];
	//行内按钮
	var clickbutton = {"aMethod":"cabinetXj-通知机房-cabinetXj-white,refuseCabinetXj-拒绝下架-refuseCabinetXj,getAllMacOfCab-详情-getAllMacOfCab,queryCabShelvesReason-下架原因-queryCabShelvesReason-white"};
	// 格式化字段
	var formatFileds = {"addtype":"0-未使用,1-已使用","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州","paystatus":"0-未付款,1-已付款,2-过期未续费","macxjstatus":"1-业务申请下架,2-机房处理中...,4-机房下架清空处理中..."};
	//分页配置
	var pageEvent = {"action":"/customerserv/loadMyshelvesManCab.action"};
	var showTableId = "#xiajiaCabinetid";
	createDataGrid(showTableId,shelvesManCabListStr,dataFiles,clickbutton,pageEvent,10,formatFileds);
}




//下架处理数据表数据获取
function shelvesMan (currentPage) {
	var url = "/customerserv/loadMyshelvesMan.action?currPage="+$("#xiajiaTid #currPage").html().substring(3,$("#xiajiaTid #currPage").html().length-1)
;
	$.ajax({
        url : url,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["proNum","macnum","custruename","truename","dxip","unicomip","dk","fh","domain","cabinet","renprice","paystatus","renbegintime","renendtime","rensc","biztype","cbNote","macxjstatus",["id","fh","customerid","bizid"]];
				//行内按钮
				var clickbutton = {"aMethod":"callComputerRoom-通知机房-callComputerRoom-white,refusedShelves-拒绝下架-refusedShelves,queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white"};//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","macxjstatus":"1-业务申请下架,2-机房处理中...,3-已下架,4-机房下架清空处理中...","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":"/customerserv/loadMyshelvesMan.action"};
				var showTableId = "#xiajiaTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//重新请求数据加载机柜信息
function shelvesManCab (currentPage) {
	var url = "/customerserv/loadMyshelvesManCab.action";
	$.ajax({
        url : url,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				// 表头
				var dataFiles = ["proNum","cabinetid","custruename","truename","macnum","dxipcount","unipcount","comproomid","dk","fh","renprice","rensc","renbegintime", "renendtime","sjdate","lssc","macxjstatus","paystatus", [ "id","comproomname","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproom"] ];
				//行内按钮
				var clickbutton = {"aMethod":"cabinetXj-通知机房-cabinetXj-white,refuseCabinetXj-拒绝下架-refuseCabinetXj,getAllMacOfCab-详情-getAllMacOfCab,queryCabShelvesReason-下架原因-queryCabShelvesReason-white"};
				// 格式化字段
				var formatFileds = {"addtype":"0-未使用,1-已使用","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州","paystatus":"0-未付款,1-已付款,2-过期未续费","macxjstatus":"1-业务申请下架,2-机房处理中...,4-机房下架清空处理中..."};
				//分页配置
				var pageEvent = {"action":"/customerserv/loadMyshelvesManCab.action"};
				var showTableId = "#xiajiaCabinetid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}








//客服通知机房下架
function callComputerRoom () {
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus == 2 || currRowObjJson.macxjstatus == 4) {
			var str = "主机编号为["+currRowObjJson.macnum+"]已经通知机房下架处理!";
			$.messager.alert("提示",str);
			return;
		}
		var str = '确定要通知机房下架编号为【'+currRowObjJson.macnum+'】的主机吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/callComputerRoom.action";
				var param = {"id":currRowObjJson.id};
				$.post(url,param,function(result){
	    			var rs = $.trim(result);
	    			if (rs > 0) {
	    				shelvesMan ();
	    				$.messager.show({
							title: '提 示',
							msg: '已提交下架请求，机房处理中......！'
						});
	    			} else {
	    				$.messager.show({
							title: '错 误',
							msg: '通知机房下架失败，请联系管理员！'
						});
	    			}
	    		});
	    	}
	  	});
	}
}


//拒绝下架
function refusedShelves () {
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus == 2 || currRowObjJson.macxjstatus == 4) {
			$.messager.show({
				title: '提 示',
				msg: '拒绝下架失败，主机已在下架中，不能进行拒绝操作！'
			});
			return;
		}
		var str = '确定要拒绝编号为【'+currRowObjJson.macnum+'】的主机的下架请求吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/callComputerRoom.action";
				var param = {"id":currRowObjJson.id,"refusedShelves":"refusedShelves"};
				$.post(url,param,function(result){
	    			var rs = $.trim(result);
	    			if (rs > 0) {
	    				shelvesMan ();
	    				$.messager.show({
							title: '提 示',
							msg: '已把下架请求驳回业务员......！'
						});
	    			} else {
	    				$.messager.show({
							title: '错 误',
							msg: '拒绝下架业务失败，请联系管理员！'
						});
	    			}
	    		});
	    	}
	  	});
	}
}

//机柜下架
function cabinetXj(){
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus == 2 || currRowObjJson.macxjstatus == 4) {
			var str = "机柜编号为["+currRowObjJson.cabinetid+"]已经通知机房下架处理!";
			$.messager.alert("提示",str);
			return;
		}
		var str = '确定要通知机房下架编号为【'+currRowObjJson.cabinetid+'】的机柜吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/cabinetXj.action";
				var param = {"id":currRowObjJson.id,"cabinet":currRowObjJson.cabinetid,"comproom":currRowObjJson.comproomid,"cusid":currRowObjJson.customerid};
				$.post(url,param,function(result){
	    			var rs = $.trim(result);
	    			if (rs > 0) {
	    				shelvesManCab();
	    				reloadMacOfCabData();
	    				$.messager.show({
							title: '提 示',
							msg: '已提交下架请求，机房处理中......！'
						});
	    			} else {
	    				$.messager.show({
							title: '错 误',
							msg: '通知机房下架失败，请联系管理员！'
						});
	    			}
	    		});
	    	}
	  	});
	}
}


//拒绝机柜下架
function refuseCabinetXj(){
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus == 2 || currRowObjJson.macxjstatus == 4) {
			$.messager.show({
				title: '提 示',
				msg: '拒绝下架失败，机柜已在下架中，不能进行拒绝操作！'
			});
			return;
		}
		var str = '确定要拒绝编号为【'+currRowObjJson.cabinetid+'】的机柜的下架请求吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/cabinetXj.action";
				var param = {"id":currRowObjJson.id,"cabinet":currRowObjJson.cabinetid,"comproom":currRowObjJson.comproomid,"cusid":currRowObjJson.customerid,"refusedShelves":"refusedShelves"};
				$.post(url,param,function(result){
	    			var rs = $.trim(result);
	    			if (rs > 0) {
	    				shelvesManCab();
	    				hiddenCabDetail();
	    				$.messager.show({
							title: '提 示',
							msg: '已把下架请求驳回业务员......！'
						});
	    			} else {
	    				$.messager.show({
							title: '错 误',
							msg: '拒绝下架业务失败，请联系管理员！'
						});
	    			}
	    		});
	    	}
	  	});
	}
}






//单击详情按钮查看机柜详情
function getAllMacOfCab () {
	$("#zdk").val(currRowObjJson.dk);
	$("#zfh").val(currRowObjJson.fh);
	$("#cabProNumid").val(currRowObjJson.proNum);
	/*alert("当前机柜机器数量："+currRowObjJson.macnum)
	$("#macnumincab").val(currRowObjJson.macnum);*/
	$("#cabinetdetailid").html(currRowObjJson.cabinetid);
	$("#cabid").val(currRowObjJson.cabinetid);
	$("#cdComproomid").val(currRowObjJson.comproomid);
	$("#bizcabid").val(currRowObjJson.id);
	$("#comproomname").val(currRowObjJson.comproomname);
	$("#cusid").val(currRowObjJson.customerid);
	$("#allMacInCab").show();
	var cusidParam=currRowObjJson.customerid;
	var params = {"cusid":cusidParam};
	var url = "/customerMan/queryMacInfoForCusCab.action?cabinet="+currRowObjJson.cabinetid+"&comproom="+currRowObjJson.comproomid;
	$.ajax({
        	url : url,
        	data: params,
        	cache : false, 
        	async : false,
        	type : "POST",
        	dataType : 'json',
        	success : function (result){
			if (result) {
				$("#uzdk").val(result.uzdk);
				$("#uzfh").val(result.uzfh);
				//表头
				//var dataFiles = ["macnum","dk","fh","renprice","dxip","unicomip","cabinet","renbegintime","renendtime","rensc","sjdate","lssc","biztype","macxjstatus",/*"paystatus",*/"cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename"]];
				var dataFiles = ["proNum","macnum","custruename","truename","dxip","unicomip","dk","fh","domain","cabinet","renprice","paystatus","renbegintime","renendtime","rensc","biztype","macxjstatus",["id","fh","customerid","bizid"]];
				//行内按钮
				//goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,changRes-更换-changRes-rosy
				var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white"};
				
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"1-业务申请下架,2-机房处理中...,4-机房下架清空处理中...","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":"/customerMan/queryMacInfoForCusCab.action?cabinet="+currRowObjJson.cabinetid+"&cusid="+currRowObjJson.customerid+"&comproom="+currRowObjJson.comproomid};
				var showTableId = "#busDataidCabMac";
			$("#busDataFootidCabMac").show();
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
        }
	});
}


//重新加载机柜中机器的数据
function reloadMacOfCabData(){
	var cusidParam=$("#cusid").val();
	var cabinet=$("#cabid").val();
	var comproom = $("#cdComproomid").val();
	var params = {"cusid":cusidParam};
	var url = "/customerMan/queryMacInfoForCusCab.action?cabinet="+cabinet+"&comproom="+comproom;
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
				var dataFiles = ["proNum","macnum","custruename","truename","dxip","unicomip","dk","fh","domain","cabinet","renprice","paystatus","renbegintime","renendtime","rensc","biztype","macxjstatus",["id","fh","customerid","bizid"]];
				//行内按钮
				//goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,changRes-更换-changRes-rosy
				var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white"};
				
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"1-业务申请下架,2-机房处理中...,4-机房下架清空处理中...","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":"/customerMan/queryMacInfoForCusCab.action?cabinet="+cabinet+"&cusid="+cusidParam+"&comproom="+comproom};
				var showTableId = "#busDataidCabMac";
			$("#busDataFootidCabMac").show();
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
        }
	});
}


//通过查询IP(包括子IP)去查询当前业务员的客户机柜中的主机.
function searchMacOfAllIpsOfCab () {
	var cabinet=$("#cabid").val();
	var ipval = $.trim($("#cabMacSearchIpValid").val());
	var macnumval = $.trim($("#cabMacSearchMacnumValid").val());
	var cusid = $("#cusid").val();
	if (!ipval && !macnumval) {
		$.messager.show({ // show error message
			title: '提示',
			msg: '请输入要查询的IP或主机编号'
		});
		return;
	}
	var url = "/customerMan/searchMacOfAllIpsOfCab.action";
	var params = {"cusid":cusid,"searchIpValid":ipval,"cabinet":cabinet,"macnumval":macnumval};
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
				var dataFiles = ["proNum","macnum","custruename","truename","dxip","unicomip","dk","fh","domain","cabinet","renprice","paystatus","renbegintime","renendtime","rensc","biztype","macxjstatus",["id","fh","customerid","bizid"]];
				//行内按钮
				//goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,changRes-更换-changRes-rosy
				var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,queryShelvesReason-下架原因-queryShelvesReason-white"};
				
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"1-业务申请下架,2-机房处理中...,4-机房下架清空处理中...","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = "";
				var showTableId = "#busDataidCabMac";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
				$("#busDataFootidCabMac").hide();
			}
		}
  	});
}

//查看主机信息
function queryMacInfo () {
	if (currRowObjJson) {
		var params = {"macnum":currRowObjJson.macnum,"biztype":currRowObjJson.biztype,"id":currRowObjJson.id};
		url = '/customerserv/querySoldMacInfo.action';
		$.post(url,params,function(result){
			//afterLoadUI("#macInfoDivId",result);
			$("#macInfoDivId").html(result);
    		//$('#openWindowInfo').dialog('open').dialog('setTitle','主机信息');
    		openwin('#openWindowInfo','300px','550px','主机信息');
  		});
	}
}

//----------机柜详情--------
function hiddenCabDetail(){
	$("#allMacInCab").hide();
}


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

//查看机柜下架原因
function queryCabShelvesReason(){
	if(currRowObjJson){
		var params = {"id":currRowObjJson.id};
		url = '/customerserv/queryCabShelvesReason.action';
		$.post(url,params,function(result){
			$("#reason").html(mydecode(result));
			openwin('#openShelvesReason','400px','300px','下架原因');
		});
		
	}
	
	
}



