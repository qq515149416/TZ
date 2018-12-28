$(function(){
	if(addedService==1){
		$("#addedServiceid").show();
	}
	loadManager();
});
//-------------菜单栏功能--------------------

//菜单颜色
function changeClass (currid) {
	var cuid = "#" + currid;
	$("#main-nav li").each(function() {
    	$(this).removeClass("active");
	});
	$(cuid).addClass("active");
	
}

//管理页面
function loadManager () {
	var url = "/members/loadManager.action";
	var params = {};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
    	changeClass("mfirstid");
		$("#frontMainid").html(rs);
  	});
}

//故障列表
function myquestionForCus () {
	var url = "/technology/queryCusQuestions.action";
	var params = {"wap":"wap"};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
    	changeClass("mquesliid");
    	$("#frontMainid").css({"visibility":"hidden"});
		$("#frontMainid").html(rs)
		$.parser.parse();
		$("#frontMainid").css({"visibility":"visible"});
  	});
}

//我的主机列表
function queryMyMac () {
	var url = "/members/queryMyMac.action";
	var params = {};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
    	changeClass("mmaclistid");
    	$("#frontMainid").css({"visibility":"hidden"});
		$("#frontMainid").html(rs)
		$.parser.parse();
		$("#frontMainid").css({"visibility":"visible"});
  	});
}

//白名单
function gowhitelistPage (meuns) {
	changeClass("mwhitelistid");
	$.post('/cusresult/whiteList.jsp','',function(result){
		var rs = $.trim(result);
		$("#frontMainid").html(rs)
		if (meuns == '1') {
			tabChange2(meuns,'liwlpassid')
		}
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
	if (checkStatu == '-1') {
		url = '/cusresult/whiteadd.jsp';
	} else {
		param = {"checkstatus":checkStatu};
	}
	loadTabContent (url,param)
}

//修改密码
function updateCusPass () {
	var url = "/members/personalset.action";
	$.post('/cusresult/personalset.jsp','',function(result){
    	var rs = $.trim(result);
    	changeClass("mupdatePassid");
    	$("#frontMainid").html(rs);
  	});
}


//注销登陆
function cusLoginOut () {
	var url = "/login/cusLogOut.action";
	location.href="http://fh.tzidc.com/exitcus.php";
	$.post(url,"",function(result){
    	window.location.href="/index.jsp";
  	});
}

//增值业务
function goAddedServicePage (username,cusid) {
	var url ="/login/changefhSession.action";
	if(!iflogin_fh){
		location.href="http://fh.tzidc.com/tzcuslogin.php?username="+username+"&cusid="+cusid;
		$.post(url,"",function(result){
			iflogin_fh ="true";
	  	});
	}else{
		location.href="http://fh.tzidc.com/vipcus.php";
	}
}
