
$(function(){
	loadWaitPayMacDataGrid();
	
});

							
//初始化业务数据表格与表格的按钮事件
function loadWaitPayMacDataGrid () {
	//表头
	var dataFiles = ["macnum","custruename","mtruename","mmobile","mqq","renprice","dxip","unicomip","cabinet","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus",["id","customerid","paytotal","accbal","creded"]];
	//行内按钮
	var clickbutton = "";
	//格式化字段
	var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款"};
	//分页配置
	var pageEvent = {"action":"/financ/loadWaitPayMac.action"};
	var showTableId = "#watiPayMacTabid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}