
$(document).ready(function(){
	//loadManPageRes();
	//loadManPageMac();
	//loadManPageRes();
	//loadManPageJg();
	loadManPageCmr();
});

/*------------机柜/机器/资源 到期情况-----------------*/
function loadManPageCmr(){
	var url = "/customerMan/loadManPageCmr.action";
	var param = {};
	$.post(url,param,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			var cabList = jsondata["cabList"];
			var macList = jsondata["macList"];
			var resList = jsondata["resList"];
			showSmallTableDataCmr (cabList,"cabNearNowid");//机柜--5天内到期或过期未续费
			showSmallTableDataCmr (macList,"macNearNowid");//机器--5天内到期或过期未续费
			showSmallTableDataCmr (resList,"resNearNowid");//资源--5天内到期或过期未续费
			
			var toupsum = jsondata["topupsum"];
			var lasttoupsum = jsondata["lasttoupsum"];
			var todayTopupsum = jsondata["todayTopupsum"];
			var yj = jsondata["yj"];
			var lastYj = jsondata["lastYj"];
			var cusCount = jsondata["cusCount"];
			var sjCount = jsondata["sjCount"];
			var xjCount = jsondata["xjCount"];
			var lssjCount = jsondata["lssjCount"];
			var accbalqk = jsondata["accbalqk"];
			
			$("#toupsumid").html(toupsum);
			$("#lasttoupsumid").html(lasttoupsum);
			$("#todayTopupsumid").html(todayTopupsum);
			$("#manyjid").html(yj);
			$("#lastYjid").html(lastYj);
			$("#cusCountid").html(cusCount);
			$("#xjCountid").html(xjCount);
			$("#sjCountid").html(sjCount);
			$("#lssjCountid").html(lssjCount);
			$("#accbalqkid").html(accbalqk);
		}
	});
}
function showSmallTableDataCmr(jsonList,showElemid) {
	var showHtml = '<ul>';
	var queryType = 0;
	var aurl = '';
	
	var len = jsonList.length - 1;
	var counts = 10;
	for (var i = 0 ; i < jsonList.length; i++) {
		 	if (showElemid == "cabNearNowid") {
		 		aurl = "/customerMan/soldJgs.action?macxjstatus=noeqMacxjstatus&usedtype=1";
		 		var cabinetid = jsonList[i]["cabinetid"];
				var custruename = jsonList[i]["custruename"];
				var cusid = jsonList[i]["cusid"];
				var showJgDate = jsonList[i]["renendtime"];
		 		var comproomname = jsonList[i]["comproomname"];
				queryType = 1;
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinetid + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + comproomname + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showJgDate + '</a></td>'
					+ '</tr></table></li>';
			} else if (showElemid == "macNearNowid") {
				var macnum = jsonList[i]["macnum"];
				var dxip = jsonList[i]["dxip"];
				var custruename = jsonList[i]["custruename"];
				var cusid = jsonList[i]["cusid"];
				var showMacDate = jsonList[i]["renendtime"];
				aurl = "/customerMan/soldMacs.action?macxjstatus=noeqMacxjstatus&notxj=1";
				queryType = 1;
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + dxip + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showMacDate + '</a></td>'
					+ '</tr></table></li>';
			}else if (showElemid == "resNearNowid") {
				var cabinet = jsonList[i]["cabinet"];
				var macnum = jsonList[i]["macnum"];
				var res = jsonList[i]["res"];
				var type = jsonList[i]["type"];
				var custruename = jsonList[i]["custruename"];
				var cusid = jsonList[i]["customerid"];
				var showResDate = jsonList[i]["renendtime"];
				queryType = 1;
				if(type==4){
					aurl="/customerMan/soldRes.action?type=4&rstatus=0";
					showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinet + '</a></td>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>';
					if(res!=null){
						showHtml += '<td width="160px;" align="left"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">联通IP：' + res + '</a></td>';
					}else{
						showHtml += '<td width="160px;" align="left"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">联通IP：' + '<span style="color:red;">已删除</span>' + '</a></td>';
					}
					showHtml +=  '<td width="90px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showResDate + '</a></td>'
						+ '</tr></table></li>';
				}else if(type==3){
					aurl="/customerMan/soldRes.action?type=3&rstatus=0";
					showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinet + '</a></td>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>';
					if(res!=null){
						showHtml +='<td width="160px;" align="left"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">电信IP：' + res + '</a></td>';
					}else{
						showHtml += '<td width="130px;" align="left"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">电信IP：' + '<span style="color:red;">已删除</span>' + '</a></td>';
					}
					showHtml +=  '<td width="90px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showResDate + '</a></td>'
						+ '</tr></table></li>';
				}else if(type==2){
					aurl="/customerMan/soldRes.action?type=2&rstatus=0";
					queryType = 1;
					showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinet + '</a></td>'
						+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>'
						+ '<td width="160px;" align="left"><a left="javascript:clickMore('+ queryType +',\''+aurl+'\');">防护：' + res + '</a></td>'
						+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
						+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showResDate + '</a></td>'
						+ '</tr></table></li>';
				}else if(type==1){
					aurl="/customerMan/soldRes.action?type=1&rstatus=0";
					queryType = 1;
					showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>';
						showHtml += '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinet + '</a></td>';
						showHtml += '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>';
					showHtml += '<td width="160px;" align="left"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">带宽：' + res + '</a></td>'
						+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
						+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showResDate + '</a></td>'
						+ '</tr></table></li>';
				}
			}
		if (i == len) {
			for (var a = 0 ; a < (counts-len-1) ; a++) {
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td></tr></table></li>';
			}
		}
	}
	//如果查询结果为空,打印空行
	if (len == -1) {
		for (var a = 0 ; a < counts ; a++) {
			showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td></tr></table></li>';
		}
	}
	showHtml += "</ul>";
	$("#" + showElemid).html(showHtml);
}
/*------------------------加载未付款机器和最近到期机器和逾期未付款机器-------*/
function loadManPageMac () {
	var url = "/customerMan/loadManPageMac.action";
	var param = {};
	$.post(url,param,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			var noPay = jsondata["noPay"];
			var nearNow = jsondata["nearNow"];
			var shelves = jsondata["shelves"];
			showSmallTableData (noPay,"nopayid");//未付款
			showSmallTableData (nearNow,"nearNowid");//5天内到期或过期未续费
			showSmallTableData (shelves,"shelvesid");//最近已下架
			
			var toupsum = jsondata["topupsum"];
			var lasttoupsum = jsondata["lasttoupsum"];
			var todayTopupsum = jsondata["todayTopupsum"];
			var yj = jsondata["yj"];
			var lastYj = jsondata["lastYj"];
			var cusCount = jsondata["cusCount"];
			var sjCount = jsondata["sjCount"];
			var xjCount = jsondata["xjCount"];
			var lssjCount = jsondata["lssjCount"];
			var accbalqk = jsondata["accbalqk"];
			
			$("#toupsumid").html(toupsum);
			$("#lasttoupsumid").html(lasttoupsum);
			$("#todayTopupsumid").html(todayTopupsum);
			$("#manyjid").html(yj);
			$("#lastYjid").html(lastYj);
			$("#cusCountid").html(cusCount);
			$("#xjCountid").html(xjCount);
			$("#sjCountid").html(sjCount);
			$("#lssjCountid").html(lssjCount);
			$("#accbalqkid").html(accbalqk);
		}
	});
}


//显示小表格的数据
function showSmallTableData (jsonList,showElemid) {
	var showHtml = '<ul>';
	//不同情况显示的不同时间字段
	var showTime = "renendtime";
	var queryType = 0;
	var aurl = "/customerMan/soldMacs.action?macxjstatus=noeqMacxjstatus&notxj=1";
	
	if (showElemid == "nopayid") {
		showTime = "sjdate";
		queryType = 0;
		
	} else if (showElemid == "nearNowid") {
		queryType = 1;
		
	} else if (showElemid == "shelvesid") {
		showTime = "xjdate";
		aurl = "/customerMan/soldMacs.action?macxjstatus=macxjstatus&notxj=0";
		queryType = 2;
	}
	var len = jsonList.length - 1;
	var counts = 10;
	for (var i = 0 ; i < jsonList.length; i++) {
		var macnum = jsonList[i]["macnum"];
		var dxip = jsonList[i]["dxip"];
		var custruename = jsonList[i]["custruename"];
		var cusid = jsonList[i]["cusid"];
		var showMacDate = jsonList[i][showTime];
		showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + dxip + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showMacDate + '</a></td>'
					+ '</tr></table></li>';
		//alert(showHtml);
		if (i == len) {
			for (var a = 0 ; a < (counts-len-1) ; a++) {
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td></tr></table></li>';
			}
		}
	}
	//如果查询结果为空,打印空行
	if (len == -1) {
		for (var a = 0 ; a < counts ; a++) {
			showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td></tr></table></li>';
		}
	}
	showHtml += "</ul>";
	$("#" + showElemid).html(showHtml);
}

//查看客户主机情况
function lookxq (cusidParam) {
	var params = {"cusid":cusidParam};
	url = '/customerMan/queryMacInfoForCus.action';
	$.post(url,params,function(result){
		//var loadImg = "<img src='/zeidc/ui/images/load.gif'>"
		AddRunningDiv();
		afterLoadUI("#bgcenterid",result);
		MoveRunningDiv();
	});
}

//点击获取更多,自动填充帅选参数
function clickMore (queryType,url,param) {
	if (url) {
		//fromOther为了跳转到综合查询后的下一页功能作参数
		var fromOther = url + "&jsonStr=jsonStr";
		var params = {};
		if (queryType == 0) {
			fromOther += "&soldPayVal=0";
			params = {"soldPayVal":0,"fromOther":fromOther};
			
		} else if (queryType == 1) {
			fromOther += "&nearNow=5";
			params = {"nearNow":"5","fromOther":fromOther};
			
		} else {
			params = {"fromOther":fromOther};
		}
		$.post(url,params,function(result){
			if (!checkStr(result)) {
				return;
			}
			AddRunningDiv();
	    	afterLoadUI("#bgcenterid",result);
	    	
	    	//从主页跳转到机器页,根据进入的条件修改相应的地方	   
	    	if(url.indexOf("soldMacs") > -1){
	    		
	    		if(queryType == 0){
	    			//条件为未付款
	    			$("#soldPayValid").val("0");
	    		}else if(queryType == 1){
	    			//条件为5天内到期或过期未续费
	    			$("#maturity").attr("class","button red medium");
	    			maturity = "on";
	    		}
	    		
	    	}
	    	
	    	MoveRunningDiv();
	    	$("#bgrightid").html('');
	  	});
	}
}
//---------------资源使用情况---------------------------
//加载5天内到期或逾期未续费资源
function loadManPageRes () {
	var url = "/customerMan/loadManPageRes.action";
	var param = {};
	$.post(url,param,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			//var noPay = jsondata["noPay"];
			var nearNowdk = jsondata["nearNowdk"];
			var nearNowfh = jsondata["nearNowfh"];
			var nearNowip = jsondata["nearNowip"];
			showSmallTableDataRes (nearNowdk,"nearNowdk");
			showSmallTableDataRes (nearNowfh,"nearNowfh");
			showSmallTableDataRes (nearNowip,"nearNowip");
		}
	});
}
//显示小表格的数据
function showSmallTableDataRes (jsonList,showElemid) {
	var showHtml = '<ul>';
	//不同情况显示的不同时间字段
	var showTime = "renendtime";
	var queryType = 1;
	var aurl = '';
	
	var len = jsonList.length - 1;
	var counts = 10;
	for (var i = 0 ; i < jsonList.length; i++) {
		var macnum = jsonList[i]["macnum"];
		var cabinet = jsonList[i]["cabinet"];
		//var renprice = jsonList[i]["renprice"];
//		var dk = jsonList[i]["dk"];
//		var fh = jsonList[i]["fh"];
//		var dxip = jsonList[i]["dxip"];
//		var unip = jsonList[i]["unip"];
		var res = jsonList[i]["res"];
		var type = jsonList[i]["type"];
		
		var custruename = jsonList[i]["custruename"];
		var cusid =jsonList[i]["cusid"];
		var showMacDate = jsonList[i][showTime];
		 if (showElemid == "nearNowdk") {
			 aurl="/customerMan/soldRes.action?type=1&rstatus=0";
				//queryType = 0;
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>';
				if(macnum!=""){
					showHtml += '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>';
				}else{
					showHtml += '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinet + '</a></td>';
				}
				showHtml += '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + res + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showMacDate + '</a></td>'
					+ '</tr></table></li>';
			} else if (showElemid == "nearNowfh") {
				 aurl="/customerMan/soldRes.action?type=2&rstatus=0";
				//aurl = "/customerMan/soldMacs.action?macxjstatus=macxjstatus";
				//queryType = 1;
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + res + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showMacDate + '</a></td>'
					+ '</tr></table></li>';
			}else if (showElemid == "nearNowip") {
				//queryType = 2;
				if(type==4){
					aurl="/customerMan/soldRes.action?type=4&rstatus=0";
					showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>';
					if(res!=null){
						showHtml += '<td width="130px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">联通IP：' + res + '</a></td>';
					}else{
						showHtml += '<td width="130px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">联通IP：' + '<span style="color:red;">已删除</span>' + '</a></td>';
					}
					showHtml +=  '<td width="90px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showMacDate + '</a></td>'
						+ '</tr></table></li>';
				}else if(type==3){
					aurl="/customerMan/soldRes.action?type=3&rstatus=0";
					showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>';
					if(res!=null){
						showHtml +='<td width="130px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">电信IP：' + res + '</a></td>';
					}else{
						showHtml += '<td width="130px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">电信IP：' + '<span style="color:red;">已删除</span>' + '</a></td>';
					}
					showHtml +=  '<td width="90px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
						+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showMacDate + '</a></td>'
						+ '</tr></table></li>';
				}
			}
		if (i == len) {
			for (var a = 0 ; a < (counts-len-1) ; a++) {
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td></tr></table></li>';
			}
		}
	}
	//如果查询结果为空,打印空行
	if (len == -1) {
		for (var a = 0 ; a < counts ; a++) {
			showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td></tr></table></li>';
		}
	}
	showHtml += "</ul>";
	$("#" + showElemid).html(showHtml);
}

//---------------机柜使用情况---------------------------
//加载5天内到期或逾期未续费资源
function loadManPageJg () {
	var url = "/customerMan/loadManPageJg.action";
	var param = {};
	$.post(url,param,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			var jgnoPay = jsondata["jgnoPay"];
			var jgnearNow = jsondata["jgnearNow"];
			var resshelves = jsondata["resshelves"];
			showSmallTableDataJg (jgnoPay,"jgnoPay");
			showSmallTableDataJg (jgnearNow,"jgnearNow");
			showSmallTableDataJg (resshelves,"resshelves");
		}
	});
}

//显示小表格的数据
function showSmallTableDataJg (jsonList,showElemid) {
	var showHtml = '<ul>';
	//不同情况显示的不同时间字段
	var showTime = "renendtime";
	var queryType = 0;
	var aurl = "/customerMan/soldJgs.action?macxjstatus=noeqMacxjstatus&usedtype=1";
	
	var len = jsonList.length - 1;
	var counts = 10;
	for (var i = 0 ; i < jsonList.length; i++) {
		var macnum = jsonList[i]["macnum"];
		var cabinet = jsonList[i]["cabinet"];
//		var dk = jsonList[i]["dk"];
//		var fh = jsonList[i]["fh"];
//		var dxip = jsonList[i]["dxip"];
//		var unip = jsonList[i]["unip"];
		var res = jsonList[i]["res"];
		var type = jsonList[i]["type"];
		
		var cabinetid = jsonList[i]["cabinetid"];
		var comproomname = jsonList[i]["comproomname"];
		var custruename = jsonList[i]["custruename"];
		var cusid = jsonList[i]["cusid"];
		var showJgDate = jsonList[i][showTime];
		if (showElemid == "jgnoPay") {
			showTime = "sjdate";
			showJgDate = jsonList[i][showTime];
			queryType = 0;
			showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
				+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinetid + '</a></td>'
				+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + comproomname + '</a></td>'
				+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
				+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showJgDate + '</a></td>'
				+ '</tr></table></li>';
		} else if (showElemid == "jgnearNow") {
			queryType = 1;
			showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
				+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinetid + '</a></td>'
				+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + comproomname + '</a></td>'
				+ '<td width="100px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
				+ '<td width="100px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showJgDate + '</a></td>'
				+ '</tr></table></li>';
		} else if (showElemid == "resshelves") {
			showTime = "endbydate";
			showJgDate = jsonList[i][showTime];
			queryType = 2;
			if(type== 1){
				 aurl="/customerMan/soldRes.action?rstatus=1&macxjstatus=macxjstatus&type=1";
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
					+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + cabinet + '</a></td>'
					+ '<td width="130px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">带宽：' + res + ' M</a></td>'
					+  '<td width="90px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showJgDate + '</a></td>'
					+ '</tr></table></li>';
			}else if(type == 2){
				 aurl="/customerMan/soldRes.action?rstatus=1&macxjstatus=macxjstatus&type=2";
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
					+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>'
					+ '<td width="130px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">防护：' + res + ' G</a></td>'
					+  '<td width="90px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showJgDate + '</a></td>'
					+ '</tr></table></li>';
			}else if(type == 3){
				 aurl="/customerMan/soldRes.action?rstatus=1&macxjstatus=macxjstatus&type=3";
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
					+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>'
					+'<td width="130px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">电信IP：' + res + '</a></td>'
					+  '<td width="90px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showJgDate + '</a></td>'
					+ '</tr></table></li>';
			}else if(type == 4){
				 aurl="/customerMan/soldRes.action?rstatus=1&macxjstatus=macxjstatus&type=4";
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr>'
					+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + macnum + '</a></td>'
					+ '<td width="130px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">联通IP：' + res + '</a></td>'
					+  '<td width="90px;" align="center"><a href="javascript:lookxq('+ cusid +');">' + custruename + '</a></td>'
					+ '<td width="90px;" align="center"><a href="javascript:clickMore('+ queryType +',\''+aurl+'\');">' + showJgDate + '</a></td>'
					+ '</tr></table></li>';
			}
		}
		
		if (i == len) {
			for (var a = 0 ; a < (counts-len-1) ; a++) {
				showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td></tr></table></li>';
			}
		}
	}
	//如果查询结果为空,打印空行
	if (len == -1) {
		for (var a = 0 ; a < counts ; a++) {
			showHtml += '<li style="height: 20px;"><table border="0" style="padding-left: 30px;width: 100%"><tr><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td><td width="100px;" align="center"></td></tr></table></li>';
		}
	}
	showHtml += "</ul>";
	$("#" + showElemid).html(showHtml);
}

//加载控件数据
function loadDetailData(id) {
	if(id=="cmrDetailid"){
		if($("#"+id).is(":hidden")){
			$("#cmrBtnid").attr('class','button orange  medium');
			$("#"+id).show(500);
			$("#meunTitleid").text("机柜,机器,资源 到期情况");
			$("#macDetailid").hide(500);
			$("#jgDetailid").hide(500);
			$("#resDetailid").hide(500);
			$("#macBtnid").attr('class','button white medium');
			$("#jgBtnid").attr('class','button white medium');
			$("#resBtnid").attr('class','button white medium');
			loadManPageCmr();
		}else{
			$("#cmrBtnid").attr('class','button white medium');
			$("#"+id).hide(500);
			$("#meunTitleid").text("");
		}
	}else if(id=="macDetailid"){
		if($("#"+id).is(":hidden")){
			$("#macBtnid").attr('class','button orange  medium');
			$("#"+id).show(500);
			$("#meunTitleid").text('机器使用情况');
			$("#resDetailid").hide(500);
			$("#jgDetailid").hide(500);
			$("#cmrDetailid").hide(500);
			$("#resBtnid").attr('class','button white medium');
			$("#jgBtnid").attr('class','button white medium');
			$("#cmrBtnid").attr('class','button white medium');
			loadManPageMac()
		}else{
			$("#macBtnid").attr('class','button white medium');
			$("#"+id).hide(500);
			$("#meunTitleid").text("");
		}
	}else if(id=="resDetailid"){
		if($("#"+id).is(":hidden")){
			$("#resBtnid").attr('class','button orange  medium');
			$("#"+id).show(500);
			$("#meunTitleid").text("资源使用情况	");
			$("#macDetailid").hide(500);
			$("#jgDetailid").hide(500);
			$("#cmrDetailid").hide(500);
			$("#macBtnid").attr('class','button white medium');
			$("#jgBtnid").attr('class','button white medium');
			$("#cmrBtnid").attr('class','button white medium');
			loadManPageRes();
		}else{
			$("#resBtnid").attr('class','button white medium');
			$("#"+id).hide(500);
			$("#meunTitleid").text("");
		}
	}else if(id=="jgDetailid"){
		if($("#"+id).is(":hidden")){
			$("#jgBtnid").attr('class','button orange  medium');
			$("#"+id).show(500);
			$("#meunTitleid").text("机柜使用情况及下架的资源	");
			$("#macDetailid").hide(500);
			$("#resDetailid").hide(500);
			$("#cmrDetailid").hide(500);
			$("#macBtnid").attr('class','button white medium');
			$("#resBtnid").attr('class','button white medium');
			$("#cmrBtnid").attr('class','button white medium');
			loadManPageJg();
		}else{
			$("#jgBtnid").attr('class','button white medium');
			$("#"+id).hide(500);
			$("#meunTitleid").text("");
		}
		
	}
}

