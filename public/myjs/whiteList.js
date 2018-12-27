
$(function(){
	clickTabToLoad();
})

//展示数据
function showData (data,showTableId,confiditons) {
	if (!data) {
		return;
	}
	// 表头
	var dataFiles = [ "domain","macnum","dxip","recnum","mname", "cname", "addtype", "addtime", "passdate", "submitnote","note",[ "id","bizid","cusid","masid","subpername" ] ];
	if(selectTabFalg == 0 ){
		dataFiles = [ "domain","macnum","dxip","recnum","mname", "cname", "addtype", "addtime", "submitnote",[ "id","bizid","cusid","masid","subpername" ] ];
	}else{
		dataFiles = [ "domain","macnum","dxip","recnum","mname", "cname", "addtype", "addtime", "passdate", "submitnote","note",[ "id","bizid","cusid","masid","subpername" ] ];
	}
	// 行内按钮
	var clickbutton = "";
	if (showTableId == "#waitWhiteListsid") {
		clickbutton = {"aMethod":"checkba-检查备案-checkba,showWhiteWin-审核-showWhiteWin"};
	}
	// 格式化字段
	var formatFileds = {"addtype":"0-内部,1-客户"};
	
	// 分页配置
	var confiditonStr = "";
	if (confiditons) {
		for (var i = 0 ; i < confiditons.length; i++) {
			confiditonStr += confiditons[i];
			if (i != confiditons.length - 1) {
				confiditonStr += "&";
			}
		}
	}
	var url = "/customerserv/loadWhiteData.action?" + confiditonStr;
	var pageEvent = {"action":url};
	createDataGrid(showTableId, data, dataFiles, clickbutton,pageEvent, 10, formatFileds);
}

function showWhiteWin() {
	var id = "#checkWhiteid";
	var tid = "#whwatidealtabid";
	if (currRowObjJson) {
		$(id).dialog('open').dialog('setTitle','白名单审核');
		$('#whiteForm').form('load',currRowObjJson);
		if (currRowObjJson.addtype==0) {
			$("#subperid").val(currRowObjJson.mname);
			
		} else if (currRowObjJson.addtype==1){
			$("#subperid").val(currRowObjJson.cname);
			
		}
		$("#sdomainid").val(currRowObjJson.domain);
		$("#srecnumid").val(currRowObjJson.recnum);
		$("#ssubperidid").val(currRowObjJson.subpername);
		$("#saddtimeid").val(mydecode(currRowObjJson.addtime));
		$("#whid").val(currRowObjJson.id);
	}
}

//数据加载---------------------------------------------------------
//当前选中的tab
var selectTabFalg = 0;
function clickTabToLoad () {
	$('#orderid').tabs({
	    border:false,
	    onSelect:function(title){
	      var checkstatus = "";
		  var showtable = "";
		  var blacklist = 0;
          if (title == "待审核") {
        	  checkstatus = 0;
        	  selectTabFalg = 0;
        	  showtable = "#waitWhiteListsid";
        	  
          } else if (title == "审核通过") {
        	  checkstatus = 1;
        	  selectTabFalg = 1;
        	  showtable = "#passWhiteListsid";
        	  
          } else if (title == "审核不通过") {
        	  checkstatus = 2;
        	  selectTabFalg = 2;
        	  showtable = "#fialWhiteListsid";
        	  
          } else if (title == "黑名单") {
        	  checkstatus = -1;
        	  selectTabFalg = -1;
        	  blacklist = 1;
        	  showtable = "#blackWhiteListsid";
          } 
          
	        var url = "/customerserv/loadWhiteData.action";
	    	var params = {"checkstatus":checkstatus,"blacklist":blacklist};
	    	var rs = queryInfo (url,params);
	    	var confiditons = new Array();
			confiditons.push("checkstatus=" + checkstatus);
			confiditons.push("blacklist=" + blacklist);
    	  	showData(rs,showtable,confiditons);
	    }
	});
}

//高级查询参数
function subWhiteFilters (divid,tabindex) {
	var id = "#" + divid;
	var domain = $(id + " #domain").val();
	var dxip = $(id + " #dxip").val();
	var unip = $(id + " #unip").val();
	var unitname = $(id + " #unitname").val();
	var subper = $(id + " #subper").val();
	var addtime = $(id + " #addtime").datebox('getValue');
	var params = {"checkstatus":tabindex,"domain":domain,"dxip":dxip,"unip":unip,"unitname":unitname,"subper":subper,"addtime":addtime};
	
	var url = "/customerserv/loadWhiteData.action";
    var params = {"checkstatus":tabindex,"blacklist":blacklist};
    var rs = queryInfo (url,params);
    var confiditons = new Array();
	confiditons.push("checkstatus=" + checkstatus);
    showData(rs,divid,confiditons);
}

function adQuery (divid,tabindex) {
	var id = "#" + divid;
	var domain = $(id + " #searchDomain").val();
	var dxip = $(id + " #searchIP").val();
	var url = "/customerserv/loadWhiteData.action";
	var params = {"checkstatus":tabindex,"domain":domain,"dxip":dxip};
	var confiditons = new Array();
	if (tabindex == -1) {
		//黑名单
		confiditons.push("blacklist=1");
		params = {"checkstatus":tabindex,"domain":domain,"blacklist":1,"dxip":dxip};
	}
	var rs = queryInfo (url,params,"过滤数据异常，请联系管理员");
	
	
	confiditons.push("domain=" + domain);
	confiditons.push("dxip=" + dxip);
	confiditons.push("checkstatus=" + tabindex);
	showData(rs,id,confiditons);
}


//白名单审核
function passWhiteList () {
	var note = $("#note").val();
	var id = $("#whid").val();
	var cws = 1;
	var params = {"note":note,"whid":id,"checkstatus":cws};
	var url = "/customerserv/updateCheckWhiteStatus.action";
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			
			$.messager.show({
				title:'提 示',
				msg:'审核通过，已经添加到防火墙'
			});
			$("#checkWhiteid").dialog('close');
			
			//刷新
			var domain = $("waitWhiteListsid #searchDomain").val();
			var dxip = $("waitWhiteListsid #searchIP").val();
			var url = "/customerserv/loadWhiteData.action";
		    var params = {"checkstatus":0,"domain":domain,"dxip":dxip};
		    var rs = queryInfo (url,params);
		    var confiditons = new Array();
			confiditons.push("checkstatus=0");
			confiditons.push("domain=" + domain);
			confiditons.push("dxip=" + dxip);
		    showData(rs,"#waitWhiteListsid",confiditons);
		}
	});
}

//审核不通过
function refuWhiteList () {
	var note = $("#note").val();
	var id = $("#whid").val();
	var cws = 2;
	var params = {"note":note,"whid":id,"checkstatus":cws};
	var url = "/customerserv/updateCheckWhiteStatus.action";
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$.messager.show({
				title:'提 示',
				msg:'审核不通过'
			});
			$("#checkWhiteid").dialog('close');
			
			//刷新
			var domain = $("waitWhiteListsid #searchDomain").val();
			var dxip = $("waitWhiteListsid #searchIP").val();
			var url = "/customerserv/loadWhiteData.action";
		    var params = {"checkstatus":0,"domain":domain,"dxip":dxip};
		    var rs = queryInfo (url,params);
		    var confiditons = new Array();
			confiditons.push("checkstatus=0");
			confiditons.push("domain=" + domain);
			confiditons.push("dxip=" + dxip);
		    showData(rs,"#waitWhiteListsid",confiditons);
		}
	});
}

//拉入黑名单
function changBlackList (tid) {
	if (currRowObjJson) {
		var str = "确定把域名" + currRowObjJson.domain + "列入黑名单，确定？";
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/updateCheckWhiteStatus.action";
				var params = {"whid":currRowObjJson.id,"blacklist":"1","checkstatus":1};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					var mess = "";
					if (rs) {
						mess = (currRowObjJson.domain + " 已经拉入黑名单!");
					} else {
						mess = (currRowObjJson.domain + " 拉入黑名单失败!");
					}
					myMesShow("提示",mess);
					//刷新
					var domain = $("waitWhiteListsid #searchDomain").val();
					var dxip = $("waitWhiteListsid #searchIP").val();
					var url = "/customerserv/loadWhiteData.action";
				    var params = {"checkstatus":0,"domain":domain,"dxip":dxip};
				    var rs = queryInfo (url,params);
				    var confiditons = new Array();
					confiditons.push("checkstatus=0");
					confiditons.push("domain=" + domain);
					confiditons.push("dxip=" + dxip);
				    showData(rs,"#waitWhiteListsid",confiditons);
					$("#checkWhiteid").dialog('close');
			  	});
			}
		});
	}
}


//检查备案
function checkba() {
//	checkbeian();
	var ym = currRowObjJson.domain;
//	var ym = "baidu.com";
	var url = "/customerserv/spiderBeiAnMesg.action";
	var params ={"ym":ym};
	$.post(url,params,function(result){
		result  = $.trim(result);
		if(!(result=="{}")){
			var jsondata = JSON.parse(result);
			getBeiAnSuccess (jsondata)
		}else{
			checkFail (ym);
		}
	});
}
function getBeiAnSuccess (JsonObject) {
	$("#hosts").html(JsonObject.zbdw);
	$("#companytype").html(JsonObject.zbdwxz);
	$("#companyname").html(JsonObject.wzbah);
	$("#licence").html(JsonObject.wzmc);
	$("#sitename").html(JsonObject.wzsy);
	$("#veritytime").html(JsonObject.shsj);
	openwin('#openWindowba','400px','350px','备案查询结果');
}

/*
//记录当前使用的api数量，做开关控制,如果连最后一个也使用完毕，防止发生死循环.
var checkApFlag = false;
//接口
var fa = '2baf51ad3190468dbf5da909ecd75ec2';
var wo = '20e9be5fdc5641f1bf1a24f0484e2fd0';
var ti = '6adeb9ddc5974d9baded7a1f06596834';
function checkbeian (key) {
	AddRunningDiv ('人家在查询,别急...');
	if (!key) {
		//默认
		key = fa;
	}
	var ym = currRowObjJson.domain;
	var checkUrl = "http://api.91cha.com/beian";
	var paramas = {"key":key,"type":0,"wd":ym};
	$.ajax({
		url:checkUrl,
		dataType:'jsonp',
		data:paramas,
		jsonp:'callback',
		async : false,
		cache : false,
		contentType:"application/x-www-form-urlencoded;charset=utf-8",
		success:function(result) {
			if (result.state == 1) {
				//查询成功
				if (result.data) {
					//已经备案
					checkSuccess (result);
				} else {
					//没有备案或注销
					checkFail (ym);
				}
				checkApFlag = true;
			} else if (result.state == 55) {
				//result.state == 55 免费50次已经使用完毕.
				//(2)
				if (checkApFlag && wo != false) {
					checkApFlag = false;
					checkbeian (wo);
				} else if (wo != false) {
					checkApFlag = true;
					wo = false;
				}
				//(3)
				if (checkApFlag && ti != false) {
					checkApFlag = false;
					checkbeian (ti);
				} else if (ti != false){
					checkApFlag = true;
					ti = false;
				}
				
				if (checkApFlag && ti==false && wo == false) {
					$.messager.alert("备案查询提示",'今天的150次查询额度已经使用完毕');
				}
				MoveRunningDiv ();
				return;
			} else if (result.state == 57) {
				$.messager.alert("备案查询结果",'域名填写不完整或者有误,请修正');
			}
			MoveRunningDiv ();
		},
		timeout:3000
	});
	MoveRunningDiv ();
}*/

function checkSuccess (result) {
	var datas = result.data[0];
	$("#hosts").html(datas.hosts);
	$("#companytype").html(datas.companytype);
	$("#companyname").html(datas.companyname);
	$("#licence").html(datas.licence);
	$("#sitename").html(datas.sitename);
	$("#veritytime").html(datas.veritytime);
	openwin('#openWindowba','400px','350px','备案查询结果');
}

function checkFail (ym) {
	var str = "域名：" + ym + " 没有备案或者备案被注销!"
	$.messager.alert("备案查询结果",str);
}

//导出审核通过白名单
function exportExcel () {
	var checkstatus = 1;
	var blacklist = 0;
	window.location.href="/customerserv/exportExcelWhiteList.action?checkstatus="+checkstatus+"&blacklist="+blacklist;
}
