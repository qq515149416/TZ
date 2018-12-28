
$(document).ready(function () {
	loadDataGrid();
});

//加载数据表格与表格的按钮事件
function loadDataGrid () {
	//表头
	var dataFiles = ["macnum","dxip","quesstatus",["quesdate","askName","macnum","id"]];
	//行内按钮
	var clickbutton = {"aMethod":"dealxq-处理-dealxq"};
	//格式化字段
	var formatFileds = {"quesstatus":"0-未处理,1-处理中,2-完成"};
	//分页配置
	var pageEvent = "";
	var showTableId = "#wapcquestionid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	
}

//处理详情currRowObjJson
function dealxq () {
	if (currRowObjJson) {
		var url = "/wap/cus/answers.jsp";
		var params = {};
		$.post(url,params,function(result){
	    	var rs = $.trim(result);
			$("#wapcusContentsid").html(rs);
			if(currRowObjJson.quesstatus == 2){
				$("#editDiv").hide();
			}
	  	});
	}
}