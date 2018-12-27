$(document).ready(function () {
	loadMyCusQuesGrid();
	$("#th").hide();
	$("#text").text("待处理问题列表");
	$("#daicl").css({color: "black",background: "White" });
	$("#chulz").css({color: "White",background: "Orange" });
	$("#yicl").css({color: "White",background: "Orange" });
});
function loadMyCusQuesGrid() {
	//表头
	var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
	//行内按钮
	var clickbutton = {"aMethod":"MycusDealQuestion-处理详情-MycusDealQuestion"};
	//格式化字段
	var formatFileds = {};
	//分页配置
	var pageEvent = {"action":"/customerMan/loadMyCusQues.action"};
	var showTableId = "#MyCusQuesTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//点击处理详情
function MycusDealQuestion (id) {
	if (currRowObjJson) {
		//新打开一个窗口后需要用到的数据
/*		$("#inputContentsid").val(currRowObjJson.contents);
		$("#inputQuesdateid").val(currRowObjJson.quesdate);
		$("#inputAskNameid").val(currRowObjJson.askName);
		$("#inputMacnumid").val(currRowObjJson.macnum);
		$("#inputQuestionid").val(currRowObjJson.qid);
		$("#inputquesstatusid").val(currRowObjJson.quesstatus);*/
		window.open("/result/technology/dealQuesWindow.jsp?"
				+ "id=" + currRowObjJson.qid
				+ "&custid=" + currRowObjJson.custid,"manswer");
	}
}
//待处理问题
function typeone (currentPage) {
	var url = "/customerMan/loadMyCusQues.action";
	var params = {"quesstatus":0};
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
				var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
				//行内按钮
				var clickbutton = {"aMethod":"MycusDealQuestion-处理详情-MycusDealQuestion"};
				//格式化字段
				var formatFileds = {};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadMyCusQues.action"};
				var showTableId = "#MyCusQuesTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//处理中问题
function typetwo (currentPage) {
	var url = "/customerMan/loadMyCusQues.action";
	var params = {"quesstatus":1};
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
				var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
				//行内按钮
				var clickbutton = {"aMethod":"MycusDealQuestion-处理详情-MycusDealQuestion"};
				//格式化字段
				var formatFileds = {};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadMyCusQues.action?quesstatus=1"};
				var showTableId = "#MyCusQuesTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
	});
	$("#th").hide();
	$("#text").text("处理中问题列表");
	$("#chulz").css({color: "black",background: "White" });
	$("#daicl").css({color: "White",background: "Orange" });
	$("#yicl").css({color: "White",background: "Orange" });
}

//已处理问题
function typethr (currentPage) {
	var url = "/customerMan/loadMyCusQues.action";
	var params = {"quesstatus":2};
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
				var dataFiles = ["quesdate","dealdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
				//行内按钮
				var clickbutton = {"aMethod":"MycusDealQuestion-处理详情-MycusDealQuestion"};
				//格式化字段
				var formatFileds = {};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadMyCusQues.action?quesstatus=2"};
				var showTableId = "#MyCusQuesTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
	});
	$("#th").show();
	$("#text").text("已处理问题列表");
	$("#yicl").css({color: "black",background: "White" });
	$("#daicl").css({color: "White",background: "Orange" });
	$("#chulz").css({color: "White",background: "Orange" });
}
