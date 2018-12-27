$(document).ready(function () {
	loadquestionokGrid();
});
var url; //提交路径
function loadquestionokGrid() {
	//表头
	var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
	//行内按钮
	var clickbutton = {"aMethod":"dealokQuestion-处理详情-dealokQuestion"};
	//格式化字段
	var formatFileds = {};
	//分页配置
	var pageEvent = {"action":"/technology/loadsuccessQuestions.action"};
	var showTableId = "#delSuccessQuestionTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}
//条件查询
function filterdealSuccessQuestionBiz1() {
	//表头
	var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
	//行内按钮
	var clickbutton = {"aMethod":"dealokQuestion-处理详情-dealokQuestion"};
	//格式化字段
	var formatFileds = {};
	//分页配置
	var pageEvent = {"action":"/technology/loadsuccessQuestions.action"};
	var showTableId = "#delSuccessQuestionTid";
	
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		success : function(result) {
			var formatFileds = {};
			var urlParams = "/technology/loadsuccessQuestions.action?urlParams=urlParams&macnum=" + macnum+ "&dxip="+ dxip+ "&unicomip="+ unicomip+"&contents="+contents;
			var pageEvent = {"action" : urlParams};
			createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
		}
		
	});
	
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//点击处理详情
function dealokQuestion (id) {
	if (currRowObjJson) {
		window.open("/result/technology/dealQuesWindow.jsp?"
				+ "id=" + currRowObjJson.qid
				+ "&custid=" + currRowObjJson.custid,"manswer_history");
	}
}

//高级查询
function filterdealSuccessQuestionBiz() {
	var dxip = $("#dxipId").val();
	var unicomip = $("#unicomipId").val();
	var macnum = $("#macnumId").val();
	var contents = $("#contentsId").val();
	
	if (contents) {
		contents = encodeURI(encodeURI(contents));
	}
	
	/*var cabinet = $("#cabinetid").val();
	var used = $("#usedId").val();
	var comproom = $("#comproomid3").val();
	var mactype=$("#mactype").val();*/
	var url = "/technology/loadsuccessQuestions.action?urlParams=urlParams&macnum=" + macnum+ "&dxip="+ dxip+ "&unicomip="+ unicomip+"&contents="+contents;
	var params = {"macnum" : macnum};
	$.ajax({
			url : url,
			data : params,
			cache : false,
			async : false,
			type : "post",
			dataType : 'json',
			success : function(result) {
			// 表头
			var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
			// 行内按钮
			var clickbutton = {"aMethod":"dealokQuestion-处理详情-dealokQuestion"};
				//格式化字段
			var formatFileds = {};
			var urlParams = "/technology/loadsuccessQuestions.action?urlParams=urlParams&macnum="+ macnum+"&dxip="+ dxip+ "&unicomip="+ unicomip+"&contents="+contents;
			var pageEvent = {"action" : urlParams};
			var showTableId = "#delSuccessQuestionTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);

		}
	});
}