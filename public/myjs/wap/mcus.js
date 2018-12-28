
$(document).ready(function () {
	$("#ywssid").hide();
	loadCusDataGrid();
});

//加载数据表格与表格的按钮事件
function loadCusDataGrid () {
	//表头
	var dataFiles = ["custruename","cusmobile",['cusid','maid']];
	if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 25) {
		dataFiles = ["custruename","truename",['cusid','maid']];
		$("#ywssid").show();
		$("#cywthid").html('业 务');
	} 
	//行内按钮
	var clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail"};
	//格式化字段
	var formatFileds = "";
	//分页配置
	var pageEvent = {"action":"/customerMan/loadMycustomer.action"};
	var showTableId = "#mycustomerTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	
}

//高级搜索
function searchMycus () {
	var custruename = $("#custruenameid").val();
	var truename = $("#truenameid").val();
	var url = "/customerMan/loadMycustomer.action";
	var params = {"custruename":custruename,"truename":truename};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			var dataFiles = ["custruename","cusmobile",['cusid','maid']];
			if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 25) {
				dataFiles = ["custruename","truename",['cusid','maid']];
			} 
			//行内按钮
			var clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail"};
			//格式化字段
			var formatFileds = "";
			//分页配置
			if (custruename) {
				custruename = encodeURI(encodeURI(custruename));
			}
			if (truename) {
				truename = encodeURI(encodeURI(truename));
			}
			var urlParams = "/customerMan/loadMycustomer.action?urlParams=urlParams&" + "custruename=" + custruename + "&truename=" + truename;
			var pageEvent = {"action":urlParams};
			var showTableId = "#mycustomerTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
		}
	});
}

//新增客户
function showadd () {
	$.post("/wap/mas/addcus.jsp","",function (rs) {
		$("#wapContentsid").html($.trim(rs));
	});
}

//查看客户信息
function macDetail () {
	look(currRowObjJson.cusid);
}














