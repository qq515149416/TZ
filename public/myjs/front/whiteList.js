

$(function(){
	loadTabContent();
})


//初始加载tab内容
function loadTabContent (url,param) {
	if (!param) {
		url = '/cusresult/whiteadd.jsp';
		param = "";
	} 
	$.post(url,param,function(result){
		var rs = $.trim(result);
		afterLoadUI("#whitecontetid",rs);
	});
}

//白名单tab
function tabChange (checkStatu,liidparm) {
	//改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#tabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	
	//改变内容
	var url = '/members/searchWhiteList.action';
	var param = "";
	if (checkStatu == '-1') {
		url = '/cusresult/whiteadd.jsp';
	} else {
		param = {"checkstatus":checkStatu};
	}
	loadTabContent (url,param)
}

