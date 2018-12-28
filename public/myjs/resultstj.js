$(document).ready(function(){
	loadyj();
});
//初始化业务数据表格与表格的按钮事件
function loadyj () {
	//表头
	var dataFiles = ["truename","yj","zxf","newqk","cusqk","yjdate",["id","maid"]];
	//行内按钮
	var clickbutton = "";
	//格式化字段
	var formatFileds = {"yjdate":"01-1月份,02-2月份,03-3月份,04-4月份,05-5月份,06-6月份,07-7月份,08-8月份,09-9月份,10-10月份,11-11月份,12-12月份"};
	//分页配置
	var pageEvent = {"action":"/financ/resultstj.action?returnJson=returnJson"};
	var showTableId = "#resultstjid";
	var pz = createDataGridJsonRows['pageSize'];
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,pz,formatFileds);
}