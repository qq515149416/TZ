$(document).ready(function () {
	loadMyQtDataGrid();
});
var url; //提交路径
function loadMyQtDataGrid() {
	//表头
	var dataFiles = ["truename","qq","worknum","mobile","sex","deptname","groupnamezn","email",["maid"]];
	//行内按钮
	var clickbutton = {"aMethod":""};
	//格式化字段
	var formatFileds = {};
	//分页配置
	var pageEvent = {"action":"/book/loadbook.action"};
	var showTableId = "#bookTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

function filterSearchidBiz () {
	var truename = $("#trueNameFilterid").val();
	var qq = $("#qqFilterid").val();
	var worknum = $("#worknumFilterid").val();
	var mobile = $("#mobileFilterid").val();
	var sex = $("#sexid").val();
	var groupnamezn = $("#groupFilterid").val();
	var email = $("#emailFilterid").val();
	
	var url = "/book/loadbook.action";
	var params = {"truename":truename,"qq":qq,"worknum":worknum,"mobile":mobile,"sex":sex,"groupnamezn":groupnamezn,"email":email};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["truename","qq","worknum","mobile","sex","deptname","groupnamezn","email",["maid"]];
        	//行内按钮
        	var clickbutton = {"aMethod":""};
        	//格式化字段
        	var formatFileds = {};
			//分页配置
			if (truename) {
				truename = encodeURI(encodeURI(truename));
			}
			if (name) {
				name = encodeURI(encodeURI(name));
			}
			if (qq) {
				qq = encodeURI(encodeURI(qq));
			}
			if (worknum) {
				worknum = encodeURI(encodeURI(worknum));
			}
			if (mobile) {
				mobile = encodeURI(encodeURI(mobile));
			}
			if (sex) {
				sex = encodeURI(encodeURI(sex));
			}
			if (groupnamezn) {
				groupnamezn = encodeURI(encodeURI(groupnamezn));
			}
			if (email) {
				email = encodeURI(encodeURI(email));
			}
			var urlParams = "/book/loadbook.action?urlParams=urlParams&" + "truename=" + truename + "&name=" + name + "&qq=" + qq + "&worknum=" + worknum+ "&mobile=" + mobile + "&sex=" + sex + "&groupnamezn=" + groupnamezn + "&email=" + email;

			var pageEvent = {"action":urlParams};
			var showTableId = "#bookTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			
		}
	});
}