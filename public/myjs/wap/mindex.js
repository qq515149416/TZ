$(document).ready(function(){
	$.post('/wap/mas/buttons.jsp',"",function(result){
		$("#wapContentsid").html(result);
  	});
});

function getQX(action) {
	//获取当前的权限限制
	if (!action) {
		alert("你没有权限");
		return;
	}
	var url = '/role/queryAction.action';
	var params = {"action":action};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'text',
        success : function (rs){
			if (rs == 0) {
				alert("你没有权限");
				return;
			}
		}
	});
}

function go (urlParam) {
	if (!urlParam) {
		urlParam = '/wap/mas/buttons.jsp';
	}
	$.post(urlParam,"",function(result){
		$("#wapContentsid").html(result);
  	});
}

//控制定时刷新用的
var timeToDo = undefined;
function timeTo (methodsName,time) {
	if (timeToDo) {
		removeTime();
	} 
	timeToDo = setInterval(methodsName,time);
}
function removeTime () {
	if (timeToDo) {
		clearInterval(timeToDo);
	}
}

function lookCusMacInfo () {
	if (currClickCusid) {
		look (currClickCusid);
	}
}

//查看客户主机情况
function look (cusidParam) {
	var params = {"cusid":cusidParam,"go":"wap"};
	url = '/customerMan/queryMacInfoForCus.action';
	$.post(url,params,function(result){
		//var loadImg = "<img src='/zeidc/ui/images/load.gif'>"
		$("#wapContentsid").html(result);
	});
}

//加载当前客户租用机器审核中的数据表格与表格的按钮事件
function initCheckingRent (currClickCusid) {
	if (currClickCusid) {
		var url = "/customerMan/queryCheckingMac.action";
		var params = {"biztype":"rent","cusid":currClickCusid,"pageSize":3};
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				if (result) {
					var showTableId = "#rentCheckingid";
					if (result.total == 0) {
						$(showTableId).hide();
						return;
					} else {
						$(showTableId).show();
					}
					//表头
					var dataFiles = ["dxip","unicomip","macname","macpass",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","macnum","rensc"]];
					//行内按钮
					var clickbutton = '';//{"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-修改-editCus-white"};//,
					//格式化字段
					var formatFileds = {"checkstatus":"3-租用审核中"};
					//分页配置
					var loadurl = "/customerMan/queryCheckingMac.action?pageSize=3&biztype=rent&cusid="+currClickCusid;
					var pageEvent = {"action":loadurl}; //加载数据,必须返回json数据.
					createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,3,formatFileds);
				}
			}
			
		});
	}
}

//加载当前客户托管机器审核中的数据表格与表格的按钮事件
function initCheckinghosting (currClickCusid) {
	if (currClickCusid) {
		var url = "/customerMan/queryCheckingMac.action";
		var params = {"biztype":"hosting","cusid":currClickCusid,"pageSize":3};
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				if (result) {
					var showTableId = "#hostingCheckingid";
					if (result.total == 0) {
						$(showTableId).hide();
						return;
					} else {
						$(showTableId).show();
					}
					//表头
					var dataFiles = ["dxip","unicomip",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","macnum","rensc"]];
					//行内按钮
					var clickbutton = '';//{"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-修改-editCus-white"};//,
					//格式化字段
					var formatFileds = {"checkstatus":"3-托管审核中"};
					//分页配置
					var loadurl = "/customerMan/queryCheckingMac.action?pageSize=3&biztype=hosting&cusid="+currClickCusid;
					var pageEvent = {"action":loadurl}; //加载数据,必须返回json数据.
					createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,3,formatFileds);
				}
			}
		});
	}
}

function wapcustomers () {
	getQX("/customerMan/queryMycustomer.action");
	var url = "/customerMan/queryMycustomer.action";
	var params = {"wap":"wap"};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
		$("#wapContentsid").html(rs);
  	});
}

function wapquestions () {
	alert('期待开发中......');
	return;
	getQX("/customerMan/queryMycustomer.action");
}

function wapwhitelist () {
	alert('期待开发中......');
	return;
	getQX("/customerMan/queryMycustomer.action");
}