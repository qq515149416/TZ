$(document).ready(function () {
	loadMyQtDataGrid();
	querybusizdept();
});
var url; //提交路径
function loadMyQtDataGrid() {
	//表头
	var dataFiles = ["truename","qq","mobile","email","sex","deptname","groupnamezn",["maid","groupid","deptid"]];
	//行内按钮
	var clickbutton = {"aMethod":"allocation-分配-allocation"};
	//格式化字段
	var formatFileds = {};
	//分页配置
	var pageEvent = {"action":"/customerMan/allocationSalesman.action?jsonStr=jsonStr"};
	var showTableId = "#salesmanTabid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}


function filterSearchidBiz () {
	var truename = $("#trueNameFilterid").val();
	var deptid = $("#deptid").val();
	if (truename) {
		truename = encodeURI(encodeURI(truename));
	}
	var url ="/customerMan/allocationSalesman.action?jsonStr=jsonStr&urlParams=urlParams&truename=" + truename + "&deptid=" + deptid;
	var params ="";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["truename","qq","mobile","email","sex","deptname","groupnamezn",["maid","groupid","deptid"]];
        	//行内按钮
        	var clickbutton = {"aMethod":"allocation-分配-allocation"};
        	//格式化字段
        	var formatFileds = {};
			var urlParams = "/customerMan/allocationSalesman.action?jsonStr=jsonStr&urlParams=urlParams&truename=" + truename + "&deptid=" + deptid;

			var pageEvent = {"action":urlParams};
			var showTableId = "#salesmanTabid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			
		}
	});
}

function allocation(){
	$("#selectdeptid").empty();
	$('#updateDeptInfo').dialog('open').dialog('setTitle','业务员部门分配');
	$("#selectCusNameid").html(currRowObjJson.truename);
	$("#updateMaid").val(currRowObjJson.maid);
	var deptidval = currRowObjJson.deptid;
	var sl=$("#selectdeptid");
	var url = '/customerMan/querybusizdept.action';
	var params = "";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
        	if (result) {
    			for(var i = 0 ; i < result.length; i++){
    				var deptid = result[i]["deptid"];
    				var deptname =result[i]["deptname"];
    				if(deptidval == deptid){
    					sl.append("<option value='"+deptid+"' selected='true'>"+deptname+"</option>");
    				}else{
    					sl.append("<option value='"+deptid+"'>"+deptname+"</option>");
    				}
    			}
    		}
		}
	});
	
	
}

function subUpdateDeptInfo (){
	var masterid = $("#updateMaid").val();
	var deptid = $("#selectdeptid").val();
	var groupid ;
	if(deptid==2){
		groupid = 24;
	}else if(deptid==12){
		groupid = 44;
	}
	var url = '/customerMan/subUpdateDeptInfo.action';
	var params = {"masterid":masterid,"deptid":deptid,"groupid":groupid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$.messager.show({
				title: '提 示',
				msg: '分配成功!'
			});
			filterSearchidBiz ();
			$('#updateDeptInfo').dialog('close');
		} else {
			$.messager.show({
				title: 'Error',
				msg: '操作失败，请联系管理员!'
			});
		}
	});
}

//查找业务部门
function querybusizdept (){
	var sl=$("#deptid");
	var url = '/customerMan/querybusizdept.action';
	var params = "";//{"masterid":masterid,"deptid":deptid,"groupid":groupid};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
        	if (result) {
    			for(var i = 0 ; i < result.length; i++){
    				var deptid = result[i]["deptid"];
    				var deptname =result[i]["deptname"];
    				sl.append("<option value='"+deptid+"'>"+deptname+"</option>");
    			}
    		}
		}
	});
}