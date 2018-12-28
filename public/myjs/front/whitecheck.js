
$(function(){
	loadWhiteDataGri();
});

$("#domain").bind ( 'click' , function(){ 
	$(this).val('');
});

function loadWhiteDataGri () {
	//表头
	if(checkstatusbg == 0){
		var dataFiles = ["domain","dxip","unip","recnum","addtime","submitnote",["id","cusid","masid","cname","mname"]];
	}else{
		var dataFiles = ["domain","dxip","unip","recnum","addtime","submitnote","note",["id","cusid","masid","cname","mname"]];
	}
	//行内按钮
	var clickbutton = "";
	//格式化字段addtype
	var formatFileds = {"addtype":"0-业务,1-个人"};
	//分页配置
	var pageEvent = {"action":'/members/searchWhiteList.action?goto=json&checkstatus='+checkstatusbg};
	var showTableId = "#whitecontetid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//高级查询
function gj () {
	var domain = $("#domain").val();
	var params = {"domain":domain,"goto":"json","checkstatus":checkstatusbg};
	var url = '/members/searchWhiteList.action';
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			//表头
        	if(checkstatusbg == 0){
        		var dataFiles = ["domain","dxip","unip","recnum","addtime","submitnote",["id","cusid","masid","cname","mname"]];
        	}else{
        		var dataFiles = ["domain","dxip","unip","recnum","addtime","submitnote","note",["id","cusid","masid","cname","mname"]];
        	}
			//行内按钮
			var clickbutton = "";
			//格式化字段
			var formatFileds = "";
			//分页配置
			url += "?&goto=json&domain=" + domain+"&checkstatus="+checkstatusbg;
			var pageEvent = {"action":url};
			var showTableId = "#whitecontetid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
		}
	});
}