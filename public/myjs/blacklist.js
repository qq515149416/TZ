

$(document).ready(function() {
	loadBlacklistDataGrid();
});

function loadBlacklistDataGrid(data) {
	if (!data) {
		data = createDataGridJsonRows;
	}
	// 表头
	var dataFiles = [ "domain", "mname", "cname", "addtype", "tel","recnum", "zjnum", "addtime", "passdate", [ "id","bizid","cusid","masid" ] ];
	// 行内按钮
	var clickbutton = {"aMethod":"changWhite-恢复-changWhite"};
	// 格式化字段
	var formatFileds = {"addtype":"0-业务员,1-客户"};
	// 分页配置
	var url = "/customerserv/blacklist.action?rs=json";
	var pageEvent = {"action":url};
	var showTableId = "#blacklisid";
	createDataGrid(showTableId, data, dataFiles, clickbutton,pageEvent, 10, formatFileds);
}

//加载数据
function loadBlacklistData () {
	var url = "/customerserv/blacklist.action?rs=json&currPage="+$("#blacklisid #currPage").html().substring(3,$("#blacklisid #currPage").html().length-1)
;
	var mes = "获取黑名单列表失败";
	var blacklist = queryInfo(url,"",mes);
	loadBlacklistDataGrid(blacklist);
	
}

//恢复白名单
function changWhite () {
	if (currRowObjJson) {
		var str = "将要恢复域名" + currRowObjJson.domain + "白名单，确定？";
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/updateCheckWhiteStatus.action";
				var params = {"whid":currRowObjJson.id,"blacklist":"0"};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					if (rs) {
						var mess = (currRowObjJson.domain + " 恢复白名单成功!");
						myMesShow("提示",mess);
						loadBlacklistData();
					} else {
						var mess = (currRowObjJson.domain + " 恢复白名单失败!");
						myMesShow("异常",mess);
					}
			  	});
			}
		});
	}
}

//新增黑名单
function popupBacklist (status) {
	$("#bdomainid").val('');
	$("#backNoteid").val('');
	if (status == 0) {
		$("#addBid").show(1000);
	} else {
		$("#addBid").hide(1000);
	}
	
}

//提交黑名单
function subBacklist () {
	var domain = $("#bdomainid").val();
	if (!checkStr(domain)) {
		myMesShow("提示","请输入黑名单域名");
		return;
	}
	var note = $("#backNoteid").val();
	var url = "/members/addWhiteList.action";
	var params = {"domain":domain,"note":note,"blacklist":"1"};
	var rs = queryInfo(url,params,"新增黑名单失败，请联系管理员");
	if (rs > 0) {
		myMesShow ("提示","黑名单新增成功");
		$("#addBid").hide(1000);
		$("#bdomainid").val('');
		$("#backNoteid").val('');
		
		var url = "/customerserv/blacklist.action";
		var params = {"rs":"json"};
		var rs = queryInfo(url,params,"获取黑名单列表失败");
		loadBlacklistDataGrid(rs);
	}
}






