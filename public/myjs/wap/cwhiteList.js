
$(function(){
	loadTabContent();
	
});


//初始加载tab内容
function loadTabContent (url,param) {
	if (!param) {
		url = '/wap/cus/whiteadd.jsp';
		param = "";
	} 
	$.post(url,param,function(result){
		var rs = $.trim(result);
		$("#whitecontetid").html(rs);
	});
}

//白名单tab
function tabChange2 (checkStatu,liidparm) {
	//改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#tabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	
	//改变内容
	var url = '/members/searchWhiteList.action';
	var param = "";
	if (!checkStatu || checkStatu == '-1') {
		url = '/cusresult/whiteadd.jsp';
	} else {
		param = {"checkstatus":checkStatu,"goto":"wap"};
	}
	loadTabContent (url,param)
}




