
$(document).ready(function(){
	if(createDataGridJsonRows["usedtype"]=='0'){
		liid = "#neibu";
		loadSoldNeiJgs();
	}else if (createDataGridJsonRows["usedtype"]=='1'){
		liid = "#kehu";
		loadSoldJgs();
	}
	$("#tabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	//动态后去机房下拉
	loadCompRoom();
	if(currGroupid=='1' || currGroupid =='26'){
		$("#addbtnid").show();
	}
});

//初始化业务数据表格与表格的按钮事件
function loadSoldJgs (param) {
	$("#soldJgsDivid").show();
	AddRunningDiv();
	//表头
	var dataFiles = ["cabinetid","custruename","macnum","dxipcount","unipcount","dk","fh","renprice","comproomname","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus","truename","note","sjdate","xjdate",["id","customerid","maid","comproomid"]];
	//sold标识出售中机柜列表，还是已下架机柜历史记录.
	$("#titleZHid").html('客户机柜列表');
	var soldJgNumVal = $("#soldJgNumValid").val();
	var soldCusNameVal = $("#soldCusNameValid").val();
	var soldMacCompRoomVal = $("#soldMacCompRoomValid").val();
	var soldPayVal = $("#soldPayValid").val();
	var jgstatusValid = $("#jgstatusValid").val();
	var renendtime = "";
	var xjdate = "";
	if (param) {
		renendtime = $("#endDateid").datebox("getValue");
		xjdate = $("#xjdateid").datebox("getValue");
	}
	//loadUrl翻页功能的action路径
	var loadUrl = "";
	var url = "/customerMan/soldJgs.action";
	var params = {};
	//param判断是否通过功能按钮过来还是默认初始化通过菜单url请求的，如果是默认请求,就不需要进行再一次请求，因为默认请求过来已经带了数据结果在jsp.
		//加载售出中的机器，返回json
		params = {"macxjstatus":"noeqMacxjstatus","jsonStr":"jsonStr","soldMacCompRoomVal":soldMacCompRoomVal,"soldJgNumVal":soldJgNumVal,"soldCusNameVal":soldCusNameVal,"soldPayVal":soldPayVal,"renendtime":renendtime,"xjdate":xjdate,"macxjstatus":jgstatusValid,"usedtype":1};
		loadUrl = "/customerMan/soldJgs.action?macxjstatus=noeqMacxjstatus&jsonStr=jsonStr&usedtype=1";
		//loadUrl = '/customerMan/soldJgs.action?jsonStr=jsonStr&nearNow=5&soldPayVal=1&macxjstatus=noeqMacxjstatus&usedtype=1';
		if (param == "reaload") {
			//不带参数搜索
			params = {"macxjstatus":"noeqMacxjstatus","jsonStr":"jsonStr","usedtype":1};
			
		} else if (param == "load"){
			//带参数的高级搜索
			loadUrl += ("&usedtype=1&urlParams=urlParams&soldMacCompRoomVal=" + soldMacCompRoomVal + "&soldJgNumVal=" + soldJgNumVal + "&soldPayVal="  + soldPayVal + "&renendtime=" + renendtime + "&xjdate" + xjdate + "&macxjstatus" + jgstatusValid + "&soldCusNameVal=" + encodeURI(encodeURI(soldCusNameVal)));
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
	var clickbutton = "";
	//格式化字段
	var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-正常上架,1-客服下架审核中,2-客服已通知机房,3-已经下架,4-机房下架清空处理中","paystatus":"0-<b style='color:red'>未付款</b>,1-已付款,2-<b style='color:red;'>过期未续费</b>"};
	//分页配置
	var pageEvent = {"action":loadUrl};
	var showTableId = "#soldJgsDivid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	MoveRunningDiv();
}


//5天内到期或逾期未续费
function loadNearNowOrMore () {
	var url = '/customerMan/soldJgs.action?jsonStr=jsonStr&nearNow=5&macxjstatus=noeqMacxjstatus&usedtype=1';
	var params = {};
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
			}
		}
	});
	//表头
	var dataFiles = ["cabinetid","custruename","macnum","dxipcount","unipcount","dk","fh","renprice","comproomname","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus","truename","note","sjdate","xjdate",["id","customerid","maid","comproomid"]];
	//行内按钮
	var clickbutton = "";
	//格式化字段
	var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-正常上架,1-客服下架审核中,2-客服已通知机房,3-已经下架,4-机房下架清空处理中","paystatus":"0-<b style='color:red'>未付款</b>,1-已付款,2-<b style='color:red'>过期未续费</b>"};
	//分页配置
	var pageEvent = {"action":url};
	var showTableId = "#soldJgsDivid";
	createDataGrid(showTableId,rs,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

function loadCompRoom (){
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	var rs = "";
	var sl=$("#soldMacCompRoomValid");
	var slnei=$("#soldNeiMacCompRoomValid");
	var sladdcab=$("#addcomproomid");
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
					sl.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
					slnei.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
					sladdcab.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
				}
			}
		}
	});
}



//--------------------------------------内部机柜-----------------------------------
//初始化业务数据表格与表格的按钮事件
function loadSoldNeiJgs (param) {
	$("#soldNeiJgsDivid").show();
	AddRunningDiv();
	//表头
	//var dataFiles = ["cabinet","macnum","comproomname","used","addtime","note",["jgid","comproomid"]];
	var dataFiles = ["cabinet","macnum","comproomname","addtime","note",["comproomid"]];
	//sold标识出售中机柜列表，还是已下架机柜历史记录.
	$("#titleNeiZHid").html('内部机柜列表');
	var soldJgNumVal = $("#soldNeiJgNumValid").val();
	var kongMacnumVal = $("#kongMacnumid").val();
	var soldMacCompRoomVal = $("#soldNeiMacCompRoomValid").val();
	var jgstatusValid = $("#NeijgstatusValid").val();
	//loadUrl翻页功能的action路径
	var loadUrl = "";
	var url = "/customerMan/soldJgs.action";
	var params = {};
	//param判断是否通过功能按钮过来还是默认初始化通过菜单url请求的，如果是默认请求,就不需要进行再一次请求，因为默认请求过来已经带了数据结果在jsp.
		//加载售出中的机器，返回json
		params = {"macxjstatus":"noeqMacxjstatus","jsonStr":"jsonStr","soldMacCompRoomVal":soldMacCompRoomVal,"soldJgNumVal":soldJgNumVal,"kongMacnumVal":kongMacnumVal,"used":jgstatusValid,"usedtype":0};
		loadUrl = "/customerMan/soldJgs.action?macxjstatus=noeqMacxjstatus&jsonStr=jsonStr&usedtype=0";
		
		if (param == "reaload") {
			//不带参数搜索
			params = {"macxjstatus":"noeqMacxjstatus","jsonStr":"jsonStr","usedtype":0};
			
		} else if (param == "load"){
			//带参数的高级搜索
			loadUrl += ("&urlParams=urlParams&usedtype=0&soldMacCompRoomVal=" + soldMacCompRoomVal + "&soldJgNumVal=" + encodeURI(encodeURI(soldJgNumVal))+ "&kongMacnumVal=" + kongMacnumVal + "&used=" + jgstatusValid  );
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
	var clickbutton = "";
	//格式化字段
	var formatFileds = {"used":"1-使用中,0-未使用"};
	//分页配置
	var pageEvent = {"action":loadUrl};
	var showTableId = "#soldNeiJgsDivid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
	MoveRunningDiv();
}

//-----------------------------tab--------------------
function tabChange (type,liidparm) {
	//改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#tabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	
	//改变内容
	if (!type || type == '1') {
		$("#soldJgsDivid").hide();
		loadSoldNeiJgs("reaload");
	} else if(!type || type == '2'){
		$("#soldNeiJgsDivid").hide();
		loadSoldJgs("reaload");
	}
}


/***
 * 新增机柜按钮点击事件
 * */
function showAddNewCabinet () {
	$('#addCabinetid').dialog('open').dialog('setTitle','新增机柜');
}

/***
 * 新增机柜提交事件
 * */
function addCabinet() {
	var str = '确定新增机柜吗？';
	var comproomVal = $("#addcomproomid").val();
	var cabinetVal = $("#CabCabinetid").val();
	var noteVal = $("#cabNoteid").val();
	var usedtypeVal = $("input[name='usedtype']:checked").val();
	var url = '/customerMan/addCabinet.action';
	var params = {"comproom":comproomVal,"cabinet":cabinetVal,"usedtype":usedtypeVal,"note":noteVal};
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			//非空验证
			if ( comproomVal == ''  || cabinetVal == '') {
				$.messager.alert("提示","输入不允许为空！");
				return false;
			}
			$.post(url,params,function(result){
				var rs = $.trim(result);
				if (rs ==-1){
					$.messager.show({
						title: 'Error',
						msg: '机柜库信息错误，请联系管理员！'
					});
					return;
				} else if(rs ==0 ){
					$.messager.alert("提示","机房中有同名机柜存在！");
				}else if(rs >0 ){
					$("#CabCabinetid").val('');
					$("#cabNoteid").val('');
					$.messager.show({
						title: '提 示',
						msg: '已成功添加新机柜！'
					});
					$('#addCabinetid').dialog('close');	
				}
			});
		}
	});
}

