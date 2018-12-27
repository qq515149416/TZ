
$(document).ready(function () {
	loadDataGrid();
});

//加载数据表格与表格的按钮事件
function loadDataGrid () {
	//表头
	var dataFiles = ["macnum","dxip",["fh","customerid","id","unicomip"]];
	//行内按钮
	var clickbutton = {"aMethod":"wapask-提问-wapask"};
	//格式化字段
	var formatFileds = "";
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
			var dataFiles = ["macnum","dxip",["fh","customerid","id"]];
			//行内按钮
			var clickbutton = {"aMethod":"wapask-提问-wapask"};
			//格式化字段
			var formatFileds = "";
			//分页配置
			var url2 = "/members/loadMyMac.action?inputVal=" + inputVal;
			var pageEvent = {"action":url2};
			var showTableId = "#mymaclistid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
		}
	});
}

//弹出提问输入窗口
function wapask () {
	if (currRowObjJson) {
		$.post('/wap/cus/ask.jsp',"",function(result){
			$("#wapmacContentsid").html(result);
	  	});
	}
}
$("#ss").bind ( 'click' , function(){ 
	$(this).val('');
});

