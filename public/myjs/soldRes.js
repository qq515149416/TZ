
$(document).ready(function(){
	loadCompRoom ();
	var liid = "#dk";
	if(createDataGridJsonRows["type"]=='1'){
		liid = "#dk";
		loadSolddkResdk();
	}else if (createDataGridJsonRows["type"]=='2'){
		liid = "#fh";
		loadSolddkResfh();
	}else if (createDataGridJsonRows["type"]=='3'){
		liid = "#dxip";
		loadSolddkResdxip();
	}else if (createDataGridJsonRows["type"]=='4'){
		liid = "#unip";
		loadSolddkResunip();
	}
	$("#tabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
});


var isNearNow = 0;//0：筛选按钮，1：5天内到期或过期未续费按钮
//初始化业务数据表格与表格的按钮事件
function loadSolddkResdk (param) {
	$("#solddkResDividdk").show();
	AddRunningDiv();
	//表头
	var dataFiles= ["macnum","cabinet","custruename","dk","renprice","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate",["id","cusid","maid","renpayid","resourseIPhasNoSubIP"]];
	$("#titleZHdkid").html('带宽资源列表');
//	$("#payspandiddk").show();
//	$("#soldPayValiddk").show();
	var th = $("#zhcxdkid").html();
	if (th.indexOf("初始上架时间") == -1) {
		var addth = th + "<th>初始上架时间</th>";
		$("#zhcxdkid").html(addth);
	}
	//var soldMacNumVal = $("#soldMacNumValiddk").val();
	var soldCabinetVal = $("#soldCabinetValiddk").val();
	var soldCusNameVal = $("#soldCusNameValiddk").val();
	var soldCompRoomVal = $("#solddkCompRoomValid").val();
	var soldPayVal = $("#soldPayValiddk").val();
	var resStatusVal = $("#resstatusiddk").val();
	var renendtime = "";
	var endbydate = "";
	if (param) {
		renendtime = $("#endDateiddk").datebox("getValue");
		//endbydate = $("#xjdateiddk").datebox("getValue");
	}
	//loadUrl翻页功能的action路径
	var loadUrl = "";
	var url = "/customerMan/soldRes.action?type=1&rstatus=0";
	var params = {};
	//param判断是否通过功能按钮过来还是默认初始化通过菜单url请求的，如果是默认请求,就不需要进行再一次请求，因为默认请求过来已经带了数据结果在jsp.
		//加载的机器，返回json
		params = {"jsonStr":"jsonStr","soldCabinetVal":soldCabinetVal,"soldCusNameVal":soldCusNameVal,"soldCompRoomVal":soldCompRoomVal,"soldPayVal":soldPayVal,"renendtime":renendtime,"rstatus":resStatusVal,"endbydate":endbydate};
		loadUrl = "/customerMan/soldRes.action?jsonStr=jsonStr&type=1&rstatus=0";
		if(param=="goOncurrpage"){
			var currPage=$("#solddkResDividdk #currPage").html().substring(3,$("#solddkResDividdk #currPage").html().length-1);
			params = {"jsonStr":"jsonStr","currpage":currPage};
		}else if (param == "reaload") {
			//不带参数搜索
			params = {"jsonStr":"jsonStr"};
			
		} else if (param == "load"){
			//带参数的高级搜索
			loadUrl += ("&urlParams=urlParams&soldCabinetVal=" + soldCabinetVal + "&soldPayVal="  + soldPayVal +"&soldCompRoomVal=" +soldCompRoomVal +"&renendtime=" + renendtime + "&rstatus=" + resStatusVal + "&endbydate=" + endbydate + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal)));
		}
	if (param) {
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				if (result) {
					isNearNow = 0;//0：筛选按钮，1：5天内到期或过期未续费按钮
					createDataGridJsonRows=result;
				}
			}
		});
	}
	if (createDataGridJsonRows["fromOther"]) {
		//从其它页面直接请求到这里
		loadUrl = createDataGridJsonRows["fromOther"];
		loadUrl += ("&fromOther=" + loadUrl);
	}
	
	
	//行内按钮
	if(deptid==0 || deptid==2 || deptid==12 || deptid==16 || deptid==13){
	    var clickbutton = {"aMethod":"soldHostRenews-续费-soldHostRenews,payMent-付款-payMent"};
	    document.getElementById('dkczid').style.display="block";
	}else{
		var clickbutton ='';
	}
	//格式化字段
	var formatFileds = {"resstatus":"0-正常使用,1-已下架","paystatus":"0-<b style='color:red'>未付款</b>,1-已付款,2-<b style='color:red'>过期未续费</b>"};
	//分页配置
	var pageEvent = {"action":loadUrl};
	var showTableId = "#solddkResDividdk";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	MoveRunningDiv();
}


//5天内到期或逾期未续费
//5天内到期或逾期未续费
function loadNearNowOrMore (type) {
	var url = '/customerMan/soldRes.action?jsonStr=jsonStr&rstatus=0&nearNow=5&type='+type;
	var params = '';
	var rs = "";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				rs = result;
				isNearNow = 1;//0：筛选按钮，1：5天内到期或过期未续费按钮
			}
		}
	});
	var dataFiles= '';
	var showTableId ='';
	//表头
	if(type=='1') {
		dataFiles =["macnum","cabinet","custruename","dk","renprice","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate",["id","cusid","renpayid","maid","resourseIPhasNoSubIP"]];
		showTableId =  "#solddkResDividdk";
	}else if (type =='2'){
		dataFiles = ["macnum","cabinet","custruename","fh","renprice","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate",["id","cusid","renpayid","maid","resourseIPhasNoSubIP"]];
		showTableId =  "#solddkResDividfh";
	}else if (type=='3') {
		dataFiles = ["macnum","cabinet","custruename","dxip","renprice","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate",["id","cusid","renpayid","maid","resourseIPhasNoSubIP"]];
		showTableId =  "#solddkResDividdxip";
	}else if (type == '4'){
		dataFiles = ["macnum","cabinet","custruename","unip","renprice","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate",["id","cusid","renpayid","maid","resourseIPhasNoSubIP"]];
		showTableId =  "#solddkResDividunip";
	}
	//行内按钮
	if(deptid==0 || deptid==2 || deptid==12 || deptid==16 || deptid==13){
	    var clickbutton = {"aMethod":"soldHostRenews-续费-soldHostRenews,payMent-付款-payMent"};
	    document.getElementById('dkczid').style.display="block";
	    document.getElementById('fhczid').style.display="block";
	    document.getElementById('dxipczid').style.display="block";
	    document.getElementById('unipczid').style.display="block";
	}else{
		var clickbutton ='';	
	}
	//格式化字段
	var formatFileds = {"resstatus":"0-正常使用,1-已下架","paystatus":"0-<b style='color:red'>未付款</b>,1-已付款,2-<b style='color:red'>过期未续费</b>"};
	//分页配置
	var pageEvent = {"action":url};
	createDataGrid(showTableId,rs,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//--------------------------------防护--------------------------
//初始化业务数据表格与表格的按钮事件
function loadSolddkResfh (param) {
	$("#solddkResDividfh").show();
	AddRunningDiv();
	//表头
	var dataFiles = ["macnum","cabinet","custruename","fh","renprice","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate",["id","cusid","renpayid","maid","resourseIPhasNoSubIP"]];
	//sold标识带宽资源列表，还是已下架带宽资源历史记录.
			$("#titleZHfhid").html('防护资源列表');
			$("#payspandidfh").show();
			$("#soldPayValidfh").show();
			var th = $("#zhcxfhid").html();
			if (th.indexOf("初始上架时间") == -1) {
				var addth = th + "<th>初始上架时间</th>";
				$("#zhcxfhid").html(addth);
			}
	var soldMacNumVal = $("#soldMacNumValidfh").val();
	var soldCusNameVal = $("#soldCusNameValidfh").val();
	var soldCompRoomVal = $("#soldfhCompRoomValid").val();
	var soldPayVal = $("#soldPayValidfh").val();
	var resStatusVal = $("#resstatusidfh").val();
	var renendtime = "";
	var endbydate = "";
	if (param) {
		renendtime = $("#endDateidfh").datebox("getValue");
		//endbydate = $("#xjdateidfh").datebox("getValue");
	}
	//loadUrl翻页功能的action路径
	var loadUrl = "";
	var url = "/customerMan/soldRes.action?type=2&rstatus=0";
	var params = {};
	//param判断是否通过功能按钮过来还是默认初始化通过菜单url请求的，如果是默认请求,就不需要进行再一次请求，因为默认请求过来已经带了数据结果在jsp.

		//加载的机器，返回json
		params = {"jsonStr":"jsonStr","soldMacNumVal":soldMacNumVal,"soldCusNameVal":soldCusNameVal,"soldCompRoomVal":soldCompRoomVal,"soldPayVal":soldPayVal,"renendtime":renendtime,"rstatus":resStatusVal,"endbydate":endbydate};
		loadUrl = "/customerMan/soldRes.action?jsonStr=jsonStr&type=2&rstatus=0";
		if(param=="goOncurrpage"){
			var currPage=$("#solddkResDividfh #currPage").html().substring(3,$("#solddkResDividfh #currPage").html().length-1);
			params = {"jsonStr":"jsonStr","currpage":currPage};
		}else if (param == "reaload") {
			//不带参数搜索
			params = {"jsonStr":"jsonStr"};
			
		} else if (param == "load"){
			//带参数的高级搜索
			loadUrl += ("&urlParams=urlParams&soldMacNumVal=" + soldMacNumVal + "&soldPayVal="  + soldPayVal  +"&soldCompRoomVal=" +soldCompRoomVal + "&renendtime=" + renendtime + "&rstatus=" + resStatusVal + "&endbydate=" + endbydate+ "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal)));
		}
	
	if (param) {
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				if (result) {
					isNearNow = 0;//0：筛选按钮，1：5天内到期或过期未续费按钮
					createDataGridJsonRows=result;
				}
			}
		});
	}
	if (createDataGridJsonRows["fromOther"]) {
		//从其它页面直接请求到这里
		loadUrl = createDataGridJsonRows["fromOther"];
		loadUrl += ("&fromOther=" + loadUrl);
	}
	
	//行内按钮
	if(deptid==0 || deptid==2 || deptid==12 || deptid==16 || deptid==13){
	    var clickbutton = {"aMethod":"soldHostRenews-续费-soldHostRenews,payMent-付款-payMent"};
	    document.getElementById('fhczid').style.display="block";	   
	}else{
		var clickbutton ='';
	}
	//格式化字段
	var formatFileds = {"resstatus":"0-正常使用,1-已下架","paystatus":"0-<b style='color:red'>未付款</b>,1-已付款,2-<b style='color:red'>过期未续费</b>"};
	//分页配置
	var pageEvent = {"action":loadUrl};
	var showTableId = "#solddkResDividfh";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	MoveRunningDiv();
}

//-----------------------------------电信IP---------------------------------------------

//初始化业务数据表格与表格的按钮事件
function loadSolddkResdxip (param) {
	$("#solddkResDividdxip").show();
	AddRunningDiv();
	//表头
	var dataFiles = ["macnum","cabinet","custruename","dxip","renprice","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate",["id","cusid","renpayid","maid","resourseIPhasNoSubIP"]];
	//sold标识带宽资源列表，还是已下架带宽资源历史记录.
			$("#titleZHdxipid").html('电信子IP资源列表');
			$("#payspandiddxip").show();
			$("#soldPayValiddxip").show();
			var th = $("#zhcxdxipid").html();
			if (th.indexOf("初始上架时间") == -1) {
				var addth = th + "<th>初始上架时间</th>";
				$("#zhcxdxipid").html(addth);
			}
	var soldMacdxIpVal = $("#soldMacdxIpValid").val();
	var soldMacNumVal = $("#soldMacNumValiddxip").val();
	var soldCusNameVal = $("#soldCusNameValiddxip").val();
	var soldCompRoomVal = $("#solddxipCompRoomValid").val();
	var soldPayVal = $("#soldPayValiddxip").val();
	var resStatusVal = $("#resstatusiddxip").val();
	var renendtime = "";
	var endbydate = "";
	if (param) {
		renendtime = $("#endDateiddxip").datebox("getValue");
		//endbydate = $("#xjdateiddxip").datebox("getValue");
	}
	//loadUrl翻页功能的action路径
	var loadUrl = "";
	var url = "/customerMan/soldRes.action?type=3&rstatus=0";
	var params = {};
	//param判断是否通过功能按钮过来还是默认初始化通过菜单url请求的，如果是默认请求,就不需要进行再一次请求，因为默认请求过来已经带了数据结果在jsp.
		//加载的机器，返回json
		params = {"jsonStr":"jsonStr","soldMacdxIpVal":soldMacdxIpVal,"soldMacNumVal":soldMacNumVal,"soldCompRoomVal":soldCompRoomVal,"soldCusNameVal":soldCusNameVal,"soldPayVal":soldPayVal,"renendtime":renendtime,"rstatus":resStatusVal,"endbydate":endbydate};
		loadUrl = "/customerMan/soldRes.action?jsonStr=jsonStr&type=3&rstatus=0";
		if(param=="goOncurrpage"){
			var currPage=$("#solddkResDividdxip #currPage").html().substring(3,$("#solddkResDividdxip #currPage").html().length-1);
			params = {"jsonStr":"jsonStr","currpage":currPage};
		}else if (param == "reaload") {
			//不带参数搜索
			params = {"jsonStr":"jsonStr"};
			
		} else if (param == "load"){
			//带参数的高级搜索
			loadUrl += ("&urlParams=urlParams&soldMacdxIpVal=" + soldMacdxIpVal + "&soldMacNumVal=" + soldMacNumVal  +"&soldCompRoomVal=" +soldCompRoomVal + "&soldPayVal="  + soldPayVal + "&renendtime=" + renendtime + "&rstatus=" + resStatusVal + "&endbydate=" + endbydate+  "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal)));
		}
	if (param) {
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				if (result) {
					isNearNow = 0;//0：筛选按钮，1：5天内到期或过期未续费按钮
					createDataGridJsonRows=result;
				}
			}
		});
	}
	
	if (createDataGridJsonRows["fromOther"]) {
		//从其它页面直接请求到这里
		loadUrl = createDataGridJsonRows["fromOther"];
		loadUrl += ("&fromOther=" + loadUrl);
	}
	
	//行内按钮
	if(deptid==0 || deptid==2 || deptid==12 || deptid==16 || deptid==13){
	    var clickbutton = {"aMethod":"soldHostRenews-续费-soldHostRenews,payMent-付款-payMent"};
	    document.getElementById('dxipczid').style.display="block";  
	}else{
		var clickbutton ='';
	}
	//格式化字段
	var formatFileds = {"resstatus":"0-正常使用,1-已下架","paystatus":"0-<b style='color:red'>未付款</b>,1-已付款,2-<b style='color:red'>过期未续费</b>"};
	//分页配置
	var pageEvent = {"action":loadUrl};
	var showTableId = "#solddkResDividdxip";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	MoveRunningDiv();
}


//-----------------------------------联通IP---------------------------------------------

//初始化业务数据表格与表格的按钮事件
function loadSolddkResunip (param) {
	$("#solddkResDividunip").show();
	AddRunningDiv();
	//表头
	var dataFiles = ["macnum","cabinet","custruename","unip","renprice","comproomname","renbegintime","renendtime","rensc","resstatus","paystatus","truename","operator","renote","bydate",["id","cusid","renpayid","maid","resourseIPhasNoSubIP"]];
	//sold标识带宽资源列表，还是已下架带宽资源历史记录.
			$("#titleZHunipid").html('联通子IP资源列表');
			$("#payspandidunip").show();
			$("#soldPayValidunip").show();
			var th = $("#zhcxunipid").html();
			if (th.indexOf("初始上架时间") == -1) {
				var addth = th + "<th>初始上架时间</th>";
				$("#zhcxunipid").html(addth);
			}
	var soldMacunIpVal = $("#soldMacunIpValid").val();
	var soldMacNumVal = $("#soldMacNumValidunip").val();
	var soldCusNameVal = $("#soldCusNameValidunip").val();
	var soldCompRoomVal = $("#soldunipCompRoomValid").val();
	var soldPayVal = $("#soldPayValidunip").val();
	var resStatusVal = $("#resstatusidunip").val();
	var renendtime = "";
	var endbydate = "";
	if (param) {
		renendtime = $("#endDateidunip").datebox("getValue");
		//endbydate = $("#xjdateidunip").datebox("getValue");
	}
	//loadUrl翻页功能的action路径
	var loadUrl = "";
	var url = "/customerMan/soldRes.action?type=4&rstatus=0";
	var params = {};
	//param判断是否通过功能按钮过来还是默认初始化通过菜单url请求的，如果是默认请求,就不需要进行再一次请求，因为默认请求过来已经带了数据结果在jsp.
		//加载的机器，返回json
		params = {"jsonStr":"jsonStr","soldMacunIpVal":soldMacunIpVal,"soldMacNumVal":soldMacNumVal,"soldCompRoomVal":soldCompRoomVal,"soldCusNameVal":soldCusNameVal,"soldPayVal":soldPayVal,"renendtime":renendtime,"rstatus":resStatusVal,"endbydate":endbydate};
		loadUrl = "/customerMan/soldRes.action?jsonStr=jsonStr&type=4&rstatus=0";
		if(param=="goOncurrpage"){
			var currPage=$("#solddkResDividunip #currPage").html().substring(3,$("#solddkResDividunip #currPage").html().length-1);
			params = {"jsonStr":"jsonStr","currpage":currPage};
		}else if (param == "reaload") {
			//不带参数搜索
			params = {"jsonStr":"jsonStr"};
			
		} else if (param == "load"){
			//带参数的高级搜索
			loadUrl += ("&urlParams=urlParams&soldMacunIpVal=" + soldMacunIpVal + "&soldMacNumVal=" + soldMacNumVal  +"&soldCompRoomVal=" +soldCompRoomVal + "&soldPayVal="  + soldPayVal + "&renendtime=" + renendtime + "&rstatus=" + resStatusVal + "&endbydate=" + endbydate + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal)));
		}
	if (param) {
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				if (result) {
					isNearNow = 0;//0：筛选按钮，1：5天内到期或过期未续费按钮
					createDataGridJsonRows=result;
				}
			}
		});
	}
	
	if (createDataGridJsonRows["fromOther"]) {
		//从其它页面直接请求到这里
		loadUrl = createDataGridJsonRows["fromOther"];
		loadUrl += ("&fromOther=" + loadUrl);
	}
	//行内按钮
	if(deptid==0 || deptid==2 || deptid==12 || deptid==16 || deptid==13){
	    var clickbutton = {"aMethod":"soldHostRenews-续费-soldHostRenews,payMent-付款-payMent"};
	    document.getElementById('unipczid').style.display="block";
	}else{
		var clickbutton ='';	
	}
	//格式化字段
	var formatFileds = {"resstatus":"0-正常使用,1-已下架","paystatus":"0-<b style='color:red'>未付款</b>,1-已付款,2-<b style='color:red'>过期未续费</b>"};
	//分页配置
	var pageEvent = {"action":loadUrl};
	var showTableId = "#solddkResDividunip";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	MoveRunningDiv();
}




//-----------------------------tab
function tabChange (type,liidparm) {
	//改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#tabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	
	//改变内容
	if (!type || type == '1') {
		$("#solddkResDividfh").hide();
		$("#solddkResDividdxip").hide();
		$("#solddkResDividunip").hide();
		loadSolddkResdk("reaload");
	} else if(!type || type == '2'){
		$("#solddkResDividdk").hide();
		$("#solddkResDividdxip").hide();
		$("#solddkResDividunip").hide();
		loadSolddkResfh("reaload");
	}else if(!type || type == '3'){
		$("#solddkResDividdk").hide();
		$("#solddkResDividfh").hide();
		$("#solddkResDividunip").hide();
		loadSolddkResdxip("reaload");
	}else if(!type || type == '4'){
		$("#solddkResDividdk").hide();
		$("#solddkResDividfh").hide();
		$("#solddkResDividdxip").hide();
		loadSolddkResunip("reaload");
	}
}


function loadCompRoom (){
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	var rs = "";
	var sldk=$("#solddkCompRoomValid");
	var slfh=$("#soldfhCompRoomValid");
	var sldxip=$("#solddxipCompRoomValid");
	var slunip=$("#soldunipCompRoomValid");
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
					var comproomid = result[i]["comproomid"];
					var comproomname =result[i]["comproomname"];
					sldk.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
					slfh.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
					sldxip.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
					slunip.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
				}
			}
		}
	});
}

//由业务人员付款资源
function payMent () {
	if (currRowObjJson) {
		dk=currRowObjJson.dk;
		fh=currRowObjJson.fh;
		dxip=currRowObjJson.dxip;
		unip=currRowObjJson.unip;
		var bizid =currRowObjJson.id;		
		var cusid= currRowObjJson.cusid;
		var renpayid= currRowObjJson.renpayid;
		var testtype=currRowObjJson.testtype;
		if (currRowObjJson.paystatus == 0) {
			var urls = "/customerMan/queryBalance.action";
			var paramss = {"cusid":cusid};	
			$.post(urls,paramss,function(result){
				var rs = $.trim(result);
				var jsondata = JSON.parse(rs);
				if (rs) {					
					var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
					var canPayTotal = parseInt(jsondata.accbal) + parseInt(jsondata.creded);										
					if (payTotal > canPayTotal) {
						$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
						return;
					}
					var str = "编号:<span style='color:red;font-size:14px;'>" + currRowObjJson.macnum + "</span><br><br>" +
						"缴费总额:<span style='color:red;font-size:14px;'> " + payTotal +"元 </span><br><br>" +
						"<span style='margin-left:40px;'>确定为资源进行付款吗？</span><br><br>";
					$.messager.confirm('Confirm',str,function(r){
						if (r){
							var url = "/customerMan/payMacsMenoy.action";													
							var params = {"cusid":cusid,"payTotal":payTotal,"bizid":bizid,"renpayid":renpayid,"payproject":1,"testtype":testtype};
							$.post(url,params,function(result){
								var rs = $.trim(result);
								if (rs > 0) {
									//刷新当前客户余额
									//queryBalance();
									//刷新当前表的数据
									if(dk){
									loadSolddkResdk('goOncurrpage');
									}else if(fh){										
										loadSolddkResfh('goOncurrpage');
									}else if(dxip){
										loadSolddkResdxip('goOncurrpage');
									}else if(unip){
										loadSolddkResunip('goOncurrpage');
									}
									$.messager.show({
										title: '提 示',
										msg: '支付成功！'
									});
								} else {
									 $.messager.alert("操作提示", "支付失败！","error"); 
								}
						  	});
						}
					});			
				}
		  	});
			
		} else {
			$.messager.alert("提示","此机器已付款！")
		}
	} 
}

//动态显示价格
function formatPrice (value) {
	var rpriceid = $("#mpriceid").val();
	if (rpriceid) {
		return value+"月"+(rpriceid*value)+" 元";
	}
}
var resrprice = undefined;
//currbizPayStatus记录当前业务单的付款状态，当业务单处理未付款状态时，不能再继续续费，只能修改价格。
var currbizPayStatus = undefined;
//资源续费
function soldHostRenews (){
if (currRowObjJson) {
	operator=maid;
	    ddk=currRowObjJson.dk;
	    ffh=currRowObjJson.fh;
	    ddxip=currRowObjJson.dxip;
	    uunip=currRowObjJson.unip;
	    id=currRowObjJson.id;
	    cusid= currRowObjJson.cusid;
	    renpayid=currRowObjJson.renpayid;
		currbizPayStatus = currRowObjJson.paystatus;		 
		$('#goOnSoldMacsid').dialog('open').dialog('setTitle','续 费');
		queryBalance();
		$("#sMTrueNameid").html(currRowObjJson.custruename);
		$("#soldMacsid").val(currRowObjJson.macnum);
		$("#rrenscid").val(currRowObjJson.rensc);
		$("#mpriceid").val(currRowObjJson.renprice);
		rprice = currRowObjJson.renprice;
		$("#rmacsbegintimeid").val(currRowObjJson.renbegintime);
		$("#rmacsendtimeid").val(currRowObjJson.renendtime);
		$("#bizid").val(currRowObjJson.id);
		$("#rcusid").val(currRowObjJson.cusid);
		
	}
	
}

//查询账户信息
function queryBalance () {
	var url = "/customerMan/queryBalance.action";
	var params = {"cusid":currRowObjJson.cusid};	
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = JSON.parse(rs);
		if (rs) {	
			$("#yueid").val(jsondata.accbal);
			$("#eduid").val(jsondata.creded);			
		}
  	});
}

//提交资源续费
function subRenewals () {
	//cusid= currRowObjJson.cusid;
	//renpayid=currRowObjJson.renpayid;
	var addsc = $('#macsaddrenscid').slider('getValue');
	var newPrice = $("#mpriceid").val();
	//如果当前业务单在未付款的情况下，不能继续操作续费功能
	//currbizPayStatus = currRowObjJson.paystatus;
	if (currbizPayStatus == 0 ) {
		$.messager.alert("提示","当前为未付款状态，不能操作续费，请先操作付款当前资源");
		return;
	}
	//如果没有修改价格，也没有选择续费时长，则做出提示，方法停止。
	if ((!oldpriceVal && addsc == 0) || (oldpriceVal==newPrice && addsc == 0)) {
		$.messager.alert("提示","请选择续费时长再进行续费！");
		return;
	}
	var str = '确定要续费编号为【'+$("#soldMacsid").val()+'】的资源吗？';
	if (addsc == 0) {
		str = '确定要修改编号为【'+$("#soldMacsid").val()+'】的价格吗？';
	}
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var renbegintime = $("#rmacsendtimeid").val();			
			var bizid = $("#bizid").val();
			var url = "/customerMan/subRenewalRes.action";
			var renprice = $("#mpriceid").val();
			var rnote = $("#mnoteid").val();
			rnote = $.trim(rnote);
			var rmacnum = $("#soldMacsid").val();
			var params = {"id":id,"addsc":addsc,"operator":operator,"begintime":renbegintime,"paystatus":currbizPayStatus,"bizid":bizid,"renprice":renprice,"cusid":cusid,"note":rnote,"rmacnum":rmacnum,"renpayid":renpayid,"payproject":3};
			//payTot 目前续费总共要支付的费用
			var payTot = undefined;
			//如果点击过修改价格，则要跑审核流程；否则就直接续费
			if (oldpriceVal) {
				if (renprice != oldpriceVal) {
					//确实修改价格,跑流程所需要的参与不同，所有要重新定义params.
					params = {"oldpriceVal":oldpriceVal,"addsc":addsc,"begintime":renbegintime,"bizid":bizid,"renprice":renprice,"cusid":cusid,"note":rnote,"rmacnum":rmacnum,"goflow":"goflow","renpayid":renpayid};
					payTot = renprice * addsc;
					
				} else {
					//点击过修改价格后，又取消了，所以要记录原来的价格去计算
					payTot = oldpriceVal * addsc;
				}
			} else {
				payTot = renprice * addsc;
			}
			//余额加信用度不够支付
			var canPay = parseInt($("#yueid").val()) + parseInt($("#eduid").val());			
			if (payTot > canPay) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				$('#macsaddrenscid').slider('setValue',0);
				return;
			}
			
			//提交
			$.post(url,params,function(result){
				var rs = $.trim(result);
				if (rs > 0) {
					if (rs == 3) {
						$.messager.show({
							title: '提 示',
							//msg: '已经提交到上一级审核!'
							msg: '修改单价成功!'
						});
					} else if(rs==1) {
						$.messager.show({
							title: '提 示',
							msg: '续费支付成功!'
						});
					}else{
						$.messager.show({
							title: '提 示',
							msg: '已经提交到上一级审核!'
						});
					}
					$('#macsaddrenscid').slider('setValue',0);
					//$('#aupdatePriceid2').html('[修改价格]');
					$('#mpriceid').attr("disabled","disabled");
					$('#mnoteid').val('');
					$('#goOnSoldMacsid').dialog('close');					
					if(ddk){
						loadSolddkResdk('goOncurrpage');
						}else if(ffh){
							loadSolddkResfh('goOncurrpage');
						}else if(ddxip){
							loadSolddkResdxip('goOncurrpage');
						}else if(uunip){
							loadSolddkResunip('goOncurrpage');
						}										
				} else {
					$.messager.show({
						title: 'ERROR',
						msg: '续费失败，请联系管理员!'
					});
				}
		  	});
		}
	});
}

//修改价格
var oldpriceVal = undefined;
function changePrice(inputPriceid,textid) {
	textid = "#" + textid;
	inputPriceid = "#" + inputPriceid;
	var ahtml = $(textid).html();
	
	if (ahtml == '[修改价格]') {
		$(textid).html('[取消修改]');
		$(inputPriceid).attr("disabled",false);
		oldpriceVal = $(inputPriceid).val();
	} else if (ahtml == '[取消修改]') {
		$(textid).html('[修改价格]');
		$(inputPriceid).attr("disabled","disabled");
		$(inputPriceid).val(oldpriceVal);
	}
}

/**
 * 带宽资源导出
 */
function exportResWithExcel(type){

	if(isNearNow == 0){
		if(type == '1'){
			var soldCabinetVal = $("#soldCabinetValiddk").val();
			var soldCusNameVal = $("#soldCusNameValiddk").val();
			var soldCompRoomVal = $("#solddkCompRoomValid").val();
			var soldPayVal = $("#soldPayValiddk").val();
			var resStatusVal = $("#resstatusiddk").val();
			var renendtime = $("#endDateiddk").datebox("getValue");
			var endbydate = "";
			
			window.location.href ="/customerMan/exportResWithExcel.action?type=1&rstatus=0"
				+"&soldCabinetVal=" + soldCabinetVal + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))+ "&soldCompRoomVal=" + soldCompRoomVal
				+ "&soldPayVal="  + soldPayVal + "&rstatus=" + resStatusVal + "&renendtime="  + renendtime + "&endbydate=" + endbydate;
		}else if(type == '2'){
			var soldMacNumVal = $("#soldMacNumValidfh").val();
			var soldCusNameVal = $("#soldCusNameValidfh").val();
			var soldCompRoomVal = $("#soldfhCompRoomValid").val();
			var soldPayVal = $("#soldPayValidfh").val();
			var resStatusVal = $("#resstatusidfh").val();
			var renendtime = $("#endDateidfh").datebox("getValue");
			var endbydate = "";
			window.location.href ="/customerMan/exportResWithExcel.action?type=2&rstatus=0"
				+"&soldMacNumVal=" + soldMacNumVal + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))+ "&soldCompRoomVal=" + soldCompRoomVal
				+"&soldPayVal="+soldPayVal+"&renendtime="+renendtime +"&rstatus="+resStatusVal+"&endbydate="+endbydate;
		}else if(type == '3'){
			var soldMacdxIpVal = $("#soldMacdxIpValid").val();
			var soldMacNumVal = $("#soldMacNumValiddxip").val();
			var soldCusNameVal = $("#soldCusNameValiddxip").val();
			var soldCompRoomVal = $("#solddxipCompRoomValid").val();
			var soldPayVal = $("#soldPayValiddxip").val();
			var resStatusVal = $("#resstatusiddxip").val();
			var renendtime = $("#endDateiddxip").datebox("getValue");
			var endbydate = "";
			window.location.href ="/customerMan/exportResWithExcel.action?type=3&rstatus=0"+"&soldMacNumVal=" + soldMacNumVal
				+"&soldMacdxIpVal=" + soldMacdxIpVal + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))+ "&soldCompRoomVal=" + soldCompRoomVal
				+"&soldPayVal="+soldPayVal+"&renendtime="+renendtime +"&rstatus="+resStatusVal+"&endbydate="+endbydate;
			
		}else if(type == '4'){
			var soldMacunIpVal = $("#soldMacunIpValid").val();
			var soldMacNumVal = $("#soldMacNumValidunip").val();
			var soldCusNameVal = $("#soldCusNameValidunip").val();
			var soldCompRoomVal = $("#soldunipCompRoomValid").val();
			var soldPayVal = $("#soldPayValidunip").val();
			var resStatusVal = $("#resstatusidunip").val();
			var renendtime = $("#endDateidunip").datebox("getValue");
			var endbydate = "";
			
			window.location.href ="/customerMan/exportResWithExcel.action?type=4&rstatus=0"+"&soldMacNumVal=" + soldMacNumVal
				+"&soldMacunIpVal=" + soldMacunIpVal + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal))+ "&soldCompRoomVal=" + soldCompRoomVal
				+"&soldPayVal="+soldPayVal+"&renendtime="+renendtime +"&rstatus="+resStatusVal+"&endbydate="+endbydate;
			
		}
	}else{
		window.location.href ="/customerMan/exportResWithExcel.action?rstatus=0&nearNow=5&type="+type;
	}
	
	$.messager.alert("操作提示", "数据正在生成,请稍等,请勿重复点击导出!","info");
}