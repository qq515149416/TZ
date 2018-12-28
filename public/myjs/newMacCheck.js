$(document).ready(function () {
	loadMacCheckDataGrid();
	loadCabCheckDataGrid();
	$("#test").text("默认上架审核列表");
	$("#testcab").text("默认机柜上架审核列表");
	$("#moren").css({color: "black",background: "White" });
	$("#morencab").css({color: "black",background: "White" });
	setInterval(timingNewMacCheck, 18000);
	hiddens();
	
});

function loadMacCheckDataGrid() {
	//表头
	var dataFiles = ["proNum","macnum","dxip","unicomip","custruename","truename","cabinet","dk","fh","biztype","renprice","renbegintime","renendtime","cbNote","checkstatus",["id"]];
	//行内按钮
	var clickbutton = {"aMethod":"checkedForNewMac-审核-checkedForNewMac-white,returnCheck-驳回-returnCheck"};
	//格式化字段
	var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中"};
	//分页配置
	var pageEvent = {"action":"/customerMan/loadnewMacCheck.action"};
	var showTableId = "#MacCheckTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	
}
//隐藏按钮
function hiddens(){
	$(":input[id='checkstatus']").each(function(){
		if($(this).val()==1){
		$(this).parent().next().next().children().hide();
		}
	});
}

//分页添加隐藏按钮事件
$("#upPage").bind("click",function(){
	hiddens()
});
$("#nextPage").bind("click",function(){
	hiddens()
});
$("#lastPage").bind("click",function(){
	hiddens()
});
$("#firstPage").bind("click",function(){
	hiddens()
});


//默认信息查询
function typeone (currentPage) {
	var truename = $("#truenameId").val();
	var dxip = $("#dxipId").val();
	var unicomip = $("#unicomipId").val();
	var macnum = $("#macnumId").val();
	var params = {"truename":truename,"dxip":dxip,"unicomip":unicomip,"macnum":macnum};
	var url = "/customerMan/loadnewMacCheck.action?currPage="+$("#MacCheckTid #currPage").html().substring(3,$("#MacCheckTid #currPage").html().length-1);
	$.ajax({
        url : url,
        data : params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["proNum","macnum","dxip","unicomip","custruename","truename","cabinet","dk","fh","biztype","renprice","renbegintime","renendtime","cbNote","checkstatus",["id"]];
				//行内按钮
				var clickbutton = {"aMethod":"checkedForNewMac-审核-checkedForNewMac-white,returnCheck-驳回-returnCheck"};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中"};
				//分页配置
				if (truename) {
					truename = encodeURI(encodeURI(truename));
				}
				var pageEvent = {"action":"/customerMan/loadnewMacCheck.action?urlParams=urlParams&" + "truename=" + truename + "&dxip=" + dxip + "&unicomip=" + unicomip + "&macnum=" + macnum};
				var showTableId = "#MacCheckTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
				hiddens();
				
			}
		}
  	});
	$("#test").text("默认上架审核列表");
	$("#moren").css({color: "black",background: "White" });
	$("#guoqi").css({color: "White",background: "Orange" });
	$("#biang").css({color: "White",background: "Orange" });
	$("#jbian").css({color: "White",background: "Orange" });
	$("#upPage").bind("click",function(){
		hiddens()
	});
	$("#nextPage").bind("click",function(){
		hiddens()
	});
	$("#lastPage").bind("click",function(){
		hiddens()
	});
	$("#firstPage").bind("click",function(){
		hiddens()
	});
}
	

//过期信息查询
function typetwo (currentPage) {
	var url = "/customerMan/loadnewMacCheck.action";
	var params = {"bizstatus":1};
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
				var dataFiles = ["proNum","macnum","dxip","unicomip","custruename","truename","cabinet","dk","fh","biztype","renprice","renbegintime","renendtime","cbNote","checkstatus",["id"]];
				//行内按钮
				var clickbutton = {"aMethod":""};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadnewMacCheck.action?bizstatus=1"};
				var showTableId = "#MacCheckTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
	$("#test").text("过期上架审核列表");
	$("#guoqi").css({color: "black",background: "White" });
	$("#moren").css({color: "White",background: "Orange" });
	$("#biang").css({color: "White",background: "Orange" });
	$("#jbian").css({color: "White",background: "Orange" });
}
//变更过信息查询
function typethr (currentPage) {

	var url = "/customerMan/loadnewMacCheck.action";
	var params = {"bizstatus":2};
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
				var dataFiles = ["proNum","macnum","dxip","unicomip","custruename","truename","cabinet","dk","fh","biztype","renprice","renbegintime","renendtime","cbNote","checkstatus",["id"]];
				//行内按钮
				var clickbutton = {"aMethod":""};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadnewMacCheck.action?bizstatus=2"};
				var showTableId = "#MacCheckTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
	$("#test").text("变更过上架审核列表");
	$("#biang").css({color: "black",background: "White" });
	$("#moren").css({color: "White",background: "Orange" });
	$("#guoqi").css({color: "White",background: "Orange" });
	$("#jbian").css({color: "White",background: "Orange" });
}
//即将过期又变更过
function typefour (currentPage) {
	var url = "/customerMan/loadnewMacCheck.action";
	var params = {"bizstatus":3};
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
				var dataFiles = ["proNum","macnum","dxip","unicomip","custruename","truename","cabinet","dk","fh","biztype","renprice","renbegintime","renendtime","cbNote","checkstatus",["id"]];
				//行内按钮
				var clickbutton = {"aMethod":""};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadnewMacCheck.action?bizstatus=3"};
				var showTableId = "#MacCheckTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
	$("#test").text("即将过期又变更过列表");
	$("#jbian").css({color: "black",background: "White" });
	$("#moren").css({color: "White",background: "Orange" });
	$("#guoqi").css({color: "White",background: "Orange" });
	$("#biang").css({color: "White",background: "Orange" });
}

//定时执行
$(document).ready(function(){
	//setInterval(timingNewMacCheck, 16000);
});

function showTxContent() {
	//action_attr = "/customerMan/newMacCheck.action";
	$.post("/customerMan/newMacCheck.action",{},function(result){
    	afterLoadUI("#bgcenterid",result);
		$("#bgrightid").html('');
  	});
}

//提醒新提交的租用或托管的业务<a href="javascript:void(0)">你有'+rs+'条上架待审核信息</a>
function timingNewMacCheck () {
	var param = {};
	var url = "/customerMan/timingNewMacCheck.action";
	$.post(url,param,function(result){
    	var rs = $.trim(result);
    	if (rs > 0) {
	    	$.messager.show({
				title:'新信息提示',
				msg:'<a href="javascript:showTxContent()">你有'+rs+'条上架待审核信息</a>',
				timeout:5000,
				showType:'slide'
			});
	    }
  	});
}

//客服审核新提交的业务
function checkedForNewMac() {
	var param = {"checkId":currRowObjJson.id,"macnum":currRowObjJson.macnum,"biztype":currRowObjJson.biztype};
	var url = "/customerserv/checkedForNewMac.action";
	$.post(url,param,function(result){
    	var rs = $.trim(result);
    	if (currRowObjJson.biztype == 1) {
    		if (rs > 0) {
	    		$.messager.show({
					title:'审核提示',
					msg:'租用机器审核通过！',
					timeout:6000,
					showType:'slide'
						
				});
	    	} else {
	    		$.messager.show({
					title:'审核提示',
					msg:'租用机器审核出错，请联系管理员！',
					timeout:6000,
					showType:'slide'
				});
	    	}
    	} else {
    		$.messager.show({
				title:'审核提示',
				msg:'托管机器审核通过，请联系管理员！',
				timeout:6000,
				showType:'slide'
			});
    	}
    	typeone();
  	});
}


//审核驳回，即拒绝审核，删除业务单
//checkId业务单的ID
function returnCheck () {
	if (currRowObjJson.id) {
		var str = '确定要拒绝编号为【'+currRowObjJson.macnum+'】的主机上架吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/deleteBusiness.action";
				var param = {"id":currRowObjJson.id,"macnum":currRowObjJson.macnum,"dxip":currRowObjJson.dxip,"unip":currRowObjJson.unicomip,"biztype":currRowObjJson.biztype,"cabinet":currRowObjJson.cabinet};
				$.post(url,param,function(result){
			    	var rs = $.trim(result);
			    	if (rs > 0) {
			    		$.messager.show({
							title:'提 示',
							msg:'拒绝上架成功，业务单已经删除!',
							timeout:6000,
							showType:'slide'
						});
			    		typeone();
    				} else {
    					$.messager.show({
							title:'错 误',
							msg:'拒绝上架失败，请联系管理员！!',
							timeout:6000,
							showType:'slide'
						});
    					
    				}
  				});
			}
		});
	}
	
}

//高级查询----------四种状态共用一个高级查询请求函数
//tableId高级查询的table的id，datagr的id
function filterSearchidBiz () {
	var truename = $("#truenameId").val();
	var dxip = $("#dxipId").val();
	var unicomip = $("#unicomipId").val();
	var macnum = $("#macnumId").val();
	var url = "/customerMan/loadnewMacCheck.action";
	var params = {"truename":truename,"dxip":dxip,"unicomip":unicomip,"macnum":macnum};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["proNum","macnum","dxip","unicomip","custruename","truename","cabinet","dk","fh","biztype","renprice","renbegintime","renendtime","cbNote","checkstatus",["id"]];
        	//行内按钮
        	var clickbutton = {"aMethod":"checkedForNewMac-审核-checkedForNewMac-white,returnCheck-驳回-returnCheck"};//{"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-提问-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,updateCusMacInfo-修改-updateCusMacInfo-rosy,updateMacxjstatus-下架-updateMacxjstatus-rosy"};

        	//格式化字段
        	var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中"};

			//分页配置
			if (truename) {
				truename = encodeURI(encodeURI(truename));
			}
			if (dxip) {
				dxip = encodeURI(encodeURI(dxip));
			}
			if (unicomip) {
				unicomip = encodeURI(encodeURI(unicomip));
			}
			if (macnum) {
				macnum = encodeURI(encodeURI(macnum));
			}
			var urlParams = "/customerMan/loadnewMacCheck.action?urlParams=urlParams&" + "truename=" + truename + "&dxip=" + dxip + "&unicomip=" + unicomip + "&macnum=" + macnum;

			var pageEvent = {"action":urlParams};
			var showTableId = "#MacCheckTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			
		}
	});
	hiddens();
	//分页添加隐藏按钮事件
	$("#upPage").bind("click",function(){
		hiddens()
	});
	$("#nextPage").bind("click",function(){
		hiddens()
	});
	$("#lastPage").bind("click",function(){
		hiddens()
	});
	$("#firstPage").bind("click",function(){
		hiddens()
	});
}
function loadCabCheckDataGrid() {
	//表头
	var dataFiles = ["proNum","cabinetid","comproomid","custruename","truename","dk","fh","biztype","renprice","renbegintime","renendtime","note","checkstatus",["id"]];
	//行内按钮
	var clickbutton = {"aMethod":"checkedForNewCab-审核-checkedForNewCab-white,returnCheckCab-驳回-returnCheckCab"};
	//格式化字段
	var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州"};
	//分页配置
	var pageEvent = {"action":"/customerMan/loadnewCabCheck.action"};
	var showTableId = "#CabCheckTid";
	createDataGrid(showTableId,createDataGridJson,dataFiles,clickbutton,pageEvent,10,formatFileds);
	
}
//客服审核新提交的业务（机柜）
function checkedForNewCab() {
	var param = {"checkId":currRowObjJson.id,"cabinet":currRowObjJson.cabinet,"biztype":currRowObjJson.biztype};
	var url = "/customerserv/checkedForNewCab.action";
	$.post(url,param,function(result){
    	var rs = $.trim(result);
    	if (currRowObjJson.biztype == 1) {
    		if (rs > 0) {
	    		$.messager.show({
					title:'审核提示',
					msg:'租用机柜审核通过！',
					timeout:6000,
					showType:'slide'
						
				});
	    	} else {
	    		$.messager.show({
					title:'审核提示',
					msg:'租用机柜审核出错，请联系管理员！',
					timeout:6000,
					showType:'slide'
				});
	    	}
    	} else {
    		$.messager.show({
				title:'审核提示',
				msg:'托管机柜审核通过，请联系管理员！',
				timeout:6000,
				showType:'slide'
			});
    	}
    	typeonecab();
  	});
}
//审核驳回，即拒绝审核，删除业务单
//checkId业务单的ID
function returnCheckCab () {
	if (currRowObjJson.id) {
		var str = '确定要拒绝编号为【'+currRowObjJson.cabinet+'】的机柜上架吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/deleteBusinessCab.action";
				var param = {"id":currRowObjJson.id,"cabinet":currRowObjJson.cabinetid};
				$.post(url,param,function(result){
			    	var rs = $.trim(result);
			    	if (rs > 0) {
			    		$.messager.show({
							title:'提 示',
							msg:'拒绝上架成功，业务单已经删除!',
							timeout:6000,
							showType:'slide'
						});
			    		typeonecab();
  				} else {
  					$.messager.show({
							title:'错 误',
							msg:'拒绝上架失败，请联系管理员！!',
							timeout:6000,
							showType:'slide'
						});
  					
  				}
				});
			}
		});
	}
	
}
//默认机柜信息查询(机柜列表)
function typeonecab (currentPage) {
	var url = "/customerMan/loadnewCabCheck.action";
	$.ajax({
        url : url,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["proNum","cabinetid","comproomid","custruename","truename","dk","fh","biztype","renprice","renbegintime","renendtime","note","checkstatus",["id"]];
				//行内按钮
				var clickbutton = {"aMethod":"checkedForNewCab-审核-checkedForNewCab-white,returnCheckCab-驳回-returnCheckCab"};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadnewCabCheck.action"};
				var showTableId = "#CabCheckTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
				hiddens();
				
			}
		}
  	});
	$("#testcab").text("默认机柜上架审核列表");
	$("#morencab").css({color: "black",background: "White" });
	$("#guoqicab").css({color: "White",background: "Orange" });
	$("#biangcab").css({color: "White",background: "Orange" });
	$("#jbiancab").css({color: "White",background: "Orange" });
	$("#upPage").bind("click",function(){
		hiddens();
	});
	$("#nextPage").bind("click",function(){
		hiddens();
	});
	$("#lastPage").bind("click",function(){
		hiddens();
	});
	$("#firstPage").bind("click",function(){
		hiddens();
	});
}

//过期信息查询(机柜列表)
function typetwocab (currentPage) {
	var url = "/customerMan/loadnewCabCheck.action";
	var params = {"bizstatus":1};
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
				var dataFiles = ["proNum","cabinetid","comproomid","custruename","truename","dk","fh","biztype","renprice","renbegintime","renendtime","note","checkstatus",["id"]];
				//行内按钮
				var clickbutton = {"aMethod":""};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadnewCabCheck.action?bizstatus=1"};
				var showTableId = "#CabCheckTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
	$("#testcab").text("过期上架审核列表");
	$("#guoqicab").css({color: "black",background: "White" });
	$("#morencab").css({color: "White",background: "Orange" });
	$("#biangcab").css({color: "White",background: "Orange" });
	$("#jbiancab").css({color: "White",background: "Orange" });
}
//变更过信息查询(机柜列表)
function typethrcab (currentPage) {

	var url = "/customerMan/loadnewCabCheck.action";
	var params = {"bizstatus":2};
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
				var dataFiles = ["proNum","cabinetid","comproomid","custruename","truename","dk","fh","biztype","renprice","renbegintime","renendtime","note","checkstatus",["id"]];
				//行内按钮
				var clickbutton = {"aMethod":""};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadnewCabCheck.action?bizstatus=2"};
				var showTableId = "#CabCheckTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
	$("#testcab").text("变更过上架审核列表");
	$("#biangcab").css({color: "black",background: "White" });
	$("#morencab").css({color: "White",background: "Orange" });
	$("#guoqicab").css({color: "White",background: "Orange" });
	$("#jbiancab").css({color: "White",background: "Orange" });
}
//即将过期又变更过(机柜列表)
function typefourcab (currentPage) {
	var url = "/customerMan/loadnewCabCheck.action";
	var params = {"bizstatus":3};
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
				var dataFiles = ["proNum","cabinetid","comproomid","custruename","truename","dk","fh","biztype","renprice","renbegintime","renendtime","note","checkstatus",["id"]];
				//行内按钮
				var clickbutton = {"aMethod":""};
				//格式化字段
				var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadnewMacCheck.action?bizstatus=3"};
				var showTableId = "#CabCheckTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
	$("#testcab").text("即将过期又变更过列表");
	$("#jbiancab").css({color: "black",background: "White" });
	$("#morencab").css({color: "White",background: "Orange" });
	$("#guoqicab").css({color: "White",background: "Orange" });
	$("#biangcab").css({color: "White",background: "Orange" });
}

//高级查询----------四种状态共用一个高级查询请求函数
//tableId高级查询的table的id，datagr的id
function filterSearchidBizCab () {
	var truename = $("#cabtruenameId").val();
	var cabinet = $("#cabumId").val();
	var url = "/customerMan/loadnewCabCheck.action";
	var params = {"truename":truename,"cabinet":cabinet};
	$.ajax({
      url : url,
      data: params,
      cache : false, 
      async : false,
      type : "post",
      dataType : 'json',
      success : function (result){
      	//表头
    	  var dataFiles = ["proNum","cabinetid","comproomid","custruename","truename","dk","fh","biztype","renprice","renbegintime","renendtime","note","checkstatus",["id"]];
      	//行内按钮
      	var clickbutton = {"aMethod":"checkedForNewCab-审核-checkedForNewCab-white,returnCheckCab-驳回-returnCheckCab"};
      	//格式化字段
      	var formatFileds = {"biztype":"0-托管,1-租用","checkstatus":"0-未审核,1-已审核,2-审核不通过,3-审核中","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州"};

			//分页配置
			if (truename) {
				truename = encodeURI(encodeURI(truename));
			}
			if (dxip) {
				dxip = encodeURI(encodeURI(dxip));
			}
			if (unicomip) {
				unicomip = encodeURI(encodeURI(unicomip));
			}
			if (macnum) {
				macnum = encodeURI(encodeURI(macnum));
			}
			var urlParams = "/customerMan/loadnewCabCheck.action?urlParams=urlParams&" + "truename=" + truename;

			var pageEvent = {"action":urlParams};
			var showTableId = "#CabCheckTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			
		}
	});
	hiddens();
	//分页添加隐藏按钮事件
	$("#upPage").bind("click",function(){
		hiddens()
	});
	$("#nextPage").bind("click",function(){
		hiddens()
	});
	$("#lastPage").bind("click",function(){
		hiddens()
	});
	$("#firstPage").bind("click",function(){
		hiddens()
	});
}