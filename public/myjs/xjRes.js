
$(document).ready(function(){
	loadXjRes();
	loadCompRoom ();//获取机房
});

//初始化业务数据表格与表格的按钮事件
function loadXjRes (param,temp) {
	AddRunningDiv();
	var dataFiles = ["macnum","custruename","resName","res","renprice","cabinet","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate","endbydate",["id","cusid","maid","resourseIPhasNoSubIP"]];
	// 行内按钮
	//var clickbutton = {"aMethod":"queryResShelvesReason-下架原因-queryResShelvesReason-white"};
	var clickbutton = "";
	// 格式化字段
	var formatFileds = {"paystatus":"0-未付款,1-已付款,2-过期未续费","resstatus":"0-正常使用,1-已下架"};
	// 分页配置
	var pageEvent = {"action":"/customerMan/xjRes.action?jsonStr=jsonStr"};
	var showTableId = "#xjResDivid";
	createDataGrid(showTableId, createDataGridJsonRows, dataFiles, clickbutton,pageEvent, 10, formatFileds);
	MoveRunningDiv();
}

function reloadXjRes(temp){
	AddRunningDiv();
	var url = '/customerMan/xjRes.action?jsonStr=jsonStr';
	var params ="";
	if( temp =="search"){
		var macnum = $("#searchMacNumValid").val();
		var cusname = $("#searchCusNameValid").val();
		var ywname = $("#searchYwNameValid").val();
		var comproomid = $("#searchComproomid").val();
		var paystatus = $("#searchPayValid").val();
		var restype = $("#searchRestypeid").val();
		var dxip = $("#searchDxipid").val();
		var unip = $("#searchUnipid").val();
		var endDate = $("#searchEndDateid").datebox("getValue");
		var xjDate = $("#searchXjdateid").datebox("getValue");
		params = {"macnum":macnum,"cusname":encodeURI(encodeURI(cusname)),"ywname":encodeURI(encodeURI(ywname)),"comproomid":comproomid,"paystatus":paystatus,"restype":restype,"dxip":dxip,"unip":unip,"endDate":endDate,"xjDate":xjDate};
		url = url+"&macnum="+macnum+"&cusname="+encodeURI(encodeURI(cusname))+"&ywname="+encodeURI(encodeURI(ywname))+"&comproomid="+comproomid+"&paystatus="+paystatus+"&restype="+restype+"&dxip="+dxip+"&unip="+unip+"&endDate="+endDate+"&xjDate="+xjDate;
	}
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
				var dataFiles = ["macnum","custruename","resName","res","renprice","cabinet","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate","endbydate",["id","cusid","maid","resourseIPhasNoSubIP"]];
				//var clickbutton = {"aMethod":"queryResShelvesReason-下架原因-queryResShelvesReason-white"};
				var clickbutton = "";
				var formatFileds = {"paystatus":"0-未付款,1-已付款,2-过期未续费","resstatus":"0-正常使用,1-已下架"};
				var pageEvent = {"action":url};
				var showTableId = "#xjResDivid";
				createDataGrid(showTableId,rs,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
	});
	MoveRunningDiv();
}

function loadCompRoom (){
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	var rs = "";
	var sl=$("#searchComproomid");
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

$('#searchRestypeid').change(function(){
	var optionVal = $(this).children('option:selected').val();
	$("#searchDxip").hide();
	$("#searchDxipid").hide();
	$("#searchDxipid").val("");
	$("#searchUnip").hide();
	$("#searchUnipid").hide();
	$("#searchUnipid").val("");
	if(optionVal ==3){
		$("#searchDxip").show();
		$("#searchDxipid").show();
	}
	if(optionVal == 4){
		$("#searchUnip").show();
		$("#searchUnipid").show();
	}
});

function exportResourceWithExcel(){
	var macnum = $("#searchMacNumValid").val();
	var cusname = $("#searchCusNameValid").val();
	var ywname = $("#searchYwNameValid").val();
	var comproomid = $("#searchComproomid").val();
	var paystatus = $("#searchPayValid").val();
	var restype = $("#searchRestypeid").val();
	var dxip = $("#searchDxipid").val();
	var unip = $("#searchUnipid").val();
	var endDate = $("#searchEndDateid").datebox("getValue");
	var xjDate = $("#searchXjdateid").datebox("getValue");
	var url = "/customerMan/exportResourceWithExcel.action?macnum="+macnum+"&cusname="+encodeURI(encodeURI(cusname))+"&ywname="+encodeURI(encodeURI(ywname))+"&comproomid="+comproomid+"&paystatus="+paystatus+"&restype="+restype+"&dxip="+dxip+"&unip="+unip+"&endDate="+endDate+"&xjDate="+xjDate;
	window.location.href = url;
}


//查看资源下架原因
function queryResShelvesReason(){
	if(currRowObjJson){
		var params = {"id":currRowObjJson.id};
		url = '/customerserv/queryResShelvesReason.action';
		$.post(url,params,function(result){
			$("#reason").html(mydecode(result));
			openwin('#openShelvesReason','400px','300px','下架原因');
		});
		
	}

}



