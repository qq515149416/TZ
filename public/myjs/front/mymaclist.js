
$(document).ready(function () {
	dblClickRows("#mymacListTab");
	loadDataGrid();
});

//加载数据表格与表格的按钮事件
function loadDataGrid () {
	//表头
	var dataFiles = ["macnum","dxip","unicomip","dk","renprice","cabinet","renbegintime","renendtime","rensc","biztype",["fh","customerid","id"]];
	//行内按钮
	var clickbutton = {"aMethod":"aMacInfo-配置-queryMacInfo,aAskQus-工单-askQuestion-white"};
	//格式化字段
	var formatFileds = {"biztype":"1-租用,0-托管"};
	//分页配置
	var pageEvent = {"action":"/members/loadMyMac.action"};
	var showTableId = "#mymaclistid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	
}

//高级查询
function searchMacListgj() {
	var inputVal = $("#ss").val();
	var params = {"inputVal":inputVal};
	var url = "/members/loadMyMac.action";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			//表头
			var dataFiles = ["macnum","dxip","unicomip","dk","renprice","cabinet","renbegintime","renendtime","rensc","biztype",["fh","customerid","id"]];
			//行内按钮
			var clickbutton = {"aMethod":"aMacInfo-配置-queryMacInfo,aAskQus-工单-askQuestion-white"};
			//格式化字段
			var formatFileds = {"biztype":"1-租用,0-托管"};
			//分页配置
			var url2 = "/members/loadMyMac.action?inputVal=" + inputVal;
			var pageEvent = {"action":url2};
			var showTableId = "#mymaclistid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
		}
	});
}

$("#ss").bind ( 'click' , function(){ 
	$(this).val('');
});


//弹出提问输入窗口
function askQuestion () {
	var temp = checkAskQuestion();
	if( temp == "true"){
		$.messager.show({
			title: '提示',
			msg: '此机器已有工单正在处理...'
		});
		return;
	}
	if (currRowObjJson) {
		$('#qestionWindow').dialog('open').dialog('setTitle','提问问题窗口');
		var str = "主机编号："+currRowObjJson.macnum+"&nbsp;&nbsp;电信IP："+currRowObjJson.dxip+"&nbsp;&nbsp;联通IP："+currRowObjJson.unicomip;
		$("#askMacInfoid").html(str);	
	}
	
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
$("#question-first-type").click(function(){
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

//双击弹出提问输入窗口
function dblClickRows (tableid) {
	$(tableid).datagrid({  
		onDblClickRow:function(data){  
		   askQuestion(tableid);
	    }  
    });
}

//针对当前主机提交问题
function cusSubcontent (webeditSubUrl,iframName) {
	if (currRowObjJson) {
		var contents = document.getElementById('webeditfrm').contentWindow.getEditor(); 
		var qfsttype = $("#question-first-type").val();
		var qscdtype = $("#question-second-type").val();
		
		if ($.trim(contents)=="") {
			$.messager.show({
				title: '提示',
				msg: '请输入内容'
			});
			return;
		}
		//$(iframName).contents().find("#wysiwyg").val();
		var bizid = currRowObjJson.id;
		var macnum = currRowObjJson.macnum;
		var dxip = currRowObjJson.dxip;
		var unicomip = currRowObjJson.unicomip;
		var params = {"contents":contents,"macnum":macnum,"unicomip":unicomip,"dxip":dxip,"bizid":bizid,"question-first-type":qfsttype,"question-second-type":qscdtype};
		$.post(webeditSubUrl,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				$.messager.show({
					title: '提示',
					msg: '已经成功提交问题！'
				});
				document.getElementById('webeditfrm').contentWindow.setContent("");
				myquestion();
				$('#qestionWindow').dialog('close');
			} else {
				$.messager.show({
					title: '错误提示',
					msg: '提交问题失败,请联系管理员！'
				});
			}
	  	});
	}
}

//我的问题
function myquestion () {
	var url = "/technology/queryCusQuestions.action";
	var params = {};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
	    $("#frontMainid").css({"visibility":"hidden"});
		$("#frontMainid").html(rs);
		$("#frontMainid").css({"visibility":"visible"});
    	//afterLoadUI("#frontMainid",rs);
		$("#meunTitleid").html("我的问题");
  	});
}

//已经下架机器
function myshelved () {
	//$('#pzid').attr("disabled","disabled");
	
	var str = "<a href='javascript:void(0)' onclick='myshelved()'>已下架机器</a>";
	$("#toolbar2").html(str);
	var url ="/members/cusShelvedMac.action";
	var params = {"macxjstatus":"3"};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = JSON.parse(rs);
		$("#mymacListTab").datagrid("loadData",jsondata);
  	});
}

//查询客户主机信息
function queryMacInfo () {
	if (currRowObjJson) {
		var params = {"macnum":currRowObjJson.macnum,"biztype":currRowObjJson.biztype,"id":currRowObjJson.id};
		url = '/customerserv/queryMacInfo.action';
		$.post(url,params,function(result){
    		var rs = $.trim(result);
    		$("#macInfoDivId").html(rs);
    		$('#openWindowInfo').dialog('open').dialog('setTitle','主机信息');
    		//$.parent.$('#bgmainuiid')().layout('expand','east');
  		});
	}
}

function checkAskQuestion(){
	var macnum = currRowObjJson.macnum;
	var url = "/members/checkAskQuestion.action";
	var params = {"macnum":macnum};
	var result = "false";
	$.ajax({
        type : "post",  
         url : url,  
         data : params,  
         async : false,  
         success : function(data){
        	 if(data == "1"){
        		 result = "true";
        	 }else{
        		 result = "false";
        	 }
         }  
    });
	return result;
}

