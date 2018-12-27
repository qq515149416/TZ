
$(document).ready(function() {
	loadMachineDataGrid();
	loadCompRoom ();//获取机房
});

function loadMachineDataGrid() {
	// 表头
	var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip","comproom","macxjstatus", "sjdate", [ "id","customerid","masterid","comproomid" ] ];
	// 行内按钮
	var clickbutton = {"aMethod":"popuUpdate-修改-popuUpdate"};
	// 格式化字段
	var formatFileds = {"macxjstatus":"0-使用中,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
	// 分页配置
	var pageEvent = {"action":"/customerserv/hotingMacs.action?returnJson=json"};
	var showTableId = "#hotingMacsid";
	createDataGrid(showTableId, createDataGridJsonRows, dataFiles, clickbutton,
			pageEvent, 10, formatFileds);
}


// 高级查询
function filterhostingmac() {
	var macnum = $("#searchmacnumId").val();
	var dxip = $("#dxipId").val();
	var unicomip = $("#unicomipId").val();
	var comproom = $("#comproomid3").val();
	var url = "/customerserv/hotingMacs.action";
	var params = {"dxip" : dxip,"unip" : unicomip,"macnum" : macnum,"returnJson":"json","comproom":comproom };
	$.ajax({
			url : url,
			data : params,
			cache : false,
			async : false,
			type : "post",
			dataType : 'json',
			success : function(result) {
			// 表头
				var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip","comproom","macxjstatus", "sjdate", [ "id","customerid","masterid","comproomid" ] ];
			// 行内按钮
			var clickbutton = {"aMethod":"popuUpdate-修改-popuUpdate"};
			// 格式化字段
			var formatFileds = {"macxjstatus":"0-使用中,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
			if (dxip) {
				dxip = encodeURI(encodeURI(dxip));
			}
			if (unicomip) {
				unicomip = encodeURI(encodeURI(unicomip));
			}
			if (macnum) {
				macnum = encodeURI(encodeURI(macnum));
			}
			if (comproom) {
				comproom = encodeURI(encodeURI(comproom));
			}
			// 分页配置
			var urlParams = "/customerserv/hotingMacs.action?returnJson=json&"+ "&dxip="+ dxip+ "&unicomip="+ unicomip+ "&macnum=" + macnum + "&comproom=" + comproom ;
			var pageEvent = {"action" : urlParams};
			var showTableId = "#hotingMacsid";
			createDataGrid(showTableId, result, dataFiles, clickbutton,pageEvent, 10, formatFileds);

		}
	});
}

//查询机器库
function loadhostingmacs () {
	var macnum = $("#searchmacnumId").val();
	var dxip = $("#dxipId").val();
	var unicomip = $("#unicomipId").val();
	var comproom = $("#comproomid3").val();
	var url = "/customerserv/hotingMacs.action?returnJson=json&currPage="+$("#hotingMacsid #currPage").html().substring(3,$("#hotingMacsid #currPage").html().length-1)+ "&dxip="+ dxip+ "&unicomip="+ unicomip+ "&macnum=" + macnum + "&comproom=" + comproom;
	$.ajax({
        url : url,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				// 表头
				var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip","comproom","macxjstatus", "sjdate", [ "id","customerid","masterid","comproomid" ] ];
				// 行内按钮
				var clickbutton = {"aMethod":"popuUpdate-修改-popuUpdate"};
				// 格式化字段
				var formatFileds = {"macxjstatus":"0-使用中,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
				// 分页配置
				var pageEvent = {"action":url};
				var showTableId = "#hotingMacsid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//打开编辑窗口
function popuUpdate () {
	$('#updateInfo').dialog('open').dialog('setTitle', '修改信息');
	 loadCompRoom2 ();
		// 给机房下拉添加onChange事件
		$("#comproomid2").combobox({
			onChange : function(n, o) {
				checkFreeCabinet("#comproomid2")
			}
		});
	$("#dxipid").val(mydecode(currRowObjJson.dxip));
	$("#unipid").val(mydecode(currRowObjJson.unicomip));
	$("#ydxipid").val(mydecode(currRowObjJson.dxip));
	$("#yunipid").val(mydecode(currRowObjJson.unicomip));
	$("#macnumid").val(mydecode(currRowObjJson.macnum));
	$("#cpuid").val(mydecode(currRowObjJson.cpu));
	//$("#cabinetid").val(mydecode(currRowObjJson.cabinet));
	//$("#comproomid").combobox("setValue",mydecode(currRowObjJson.comproom));
	$("#cabinetid").combobox("setValue",mydecode(currRowObjJson.cabinet));
	$("#comproomid2").combobox("setValue",mydecode(currRowObjJson.comproomid));
	$("#comproomid2").combobox("setText",mydecode(currRowObjJson.comproom));
	
	$("#memoryid").combobox("setValue",mydecode(currRowObjJson.memory));
	$("#harddiskid").combobox("setValue",mydecode(currRowObjJson.harddisk));
//	$("#comproomsid").val(mydecode(currRowObjJson.comproomid));
	//$("#mactypeid").combobox("setValue",mydecode(currRowObjJson.mactype));
}

//编辑托管机器信息
function edithostingMac () {
	var memory = $("#memoryid").combobox('getValue');
	if (!memory) {
		checkImgShow("#memoryMes",-1,'必填');
		return;
	} else{
		checkImgShow("#memoryMes",2);
	}
	var harddisk = $("#harddiskid").combobox('getValue');
	if (!harddisk) {
		checkImgShow("#harddiskMes",-1,'必填');
		return;
	} else{
		checkImgShow("#harddiskMes",2);
	}
	var mactype = $("#mactypeid").combobox('getValue');
	if (!mactype) {
		checkImgShow("#mactypeMes",-1,'必填');
		return;
	}  else{
		checkImgShow("#mactypeMes",2);
	}
	var cpu = $("#cpuid").val();
	if (!cpu) {
		checkImgShow("#cpuMes",-1,'必填');
		return;
	} else{
		checkImgShow("#cpuMes",2);
	}
	var cabinet = $("#cabinetid").combobox('getValue');
	if (!cabinet) {
		checkImgShow("#cabinetMes",-1,'必填');
		return;
	} else{
		checkImgShow("#cabinetMes",2);
	}
	var comproom = $("#comproomid2").combobox('getValue');
	if (!comproom) {
		checkImgShow("#comproomMes",-1,'必填');
		return;
	} else{
		checkImgShow("#comproomMes",2);
	}
	/**var comproom = $("#comproomid").combobox('getValue');
	if (!comproom) {
		checkImgShow("#comproomMes",-1,'必填');
		return;
	} else{
		checkImgShow("#comproomMes",2);
	}*/
	var dxip = $("#dxipid").val();
	if (!dxip) {
		checkImgShow("#dxerrorsip",-1,'必填');
		return;
	} else{
		checkImgShow("#dxerrorsip",2);
	}
	var unip = $("#unipid").val();
	/*if (!unip) {
		checkImgShow("#unerrorsip",-1,'必填');
		return;
	} else{
		checkImgShow("#unerrorsip",2);
	}*/
//	var comproom =  $("#comproomsid").val()
	
	var yunip = $("#yunipid").val();
	var vali1 = false;
	var ipvali1 = false;
	if($.trim(yunip)!=$.trim(unip)  && $.trim(unip)!=""){
		vali1 = searchIPCounts("unip","#unipid","#unerrorsip",0);//判断新IP是否存在可用
		if(vali1 == true){//存在这个IP，再判断这个IP与机房是否匹配
			ipvali1 = checkIpComproom("unip","#unipid",comproom);
		}
	}else{
		vali1 = true;
		ipvali1 =true;
	}
	
	var ydxip = $("#ydxipid").val();
	var vali2  = false;
	var ipvali2 = false;
	if($.trim(ydxip)!=$.trim(dxip)){
		vali2= searchIPCounts("dxip","#dxipid","#dxerrorsip",0);//判断新IP是否存在可用
		if(vali2 == true){//存在这个IP，再判断这个IP与机房是否匹配
			ipvali2 = checkIpComproom("dxip","#dxipid",comproom);
		}
	}else{
		vali2 = true;
		ipvali2 =true;
	}
	
	if (!vali1 || !vali2 || !ipvali1  ||!ipvali2) {
		return;
	}
	
	$('#updateInfo').dialog('close');
	var params = {"ydxip":ydxip,"yunip":yunip,"dxip":dxip,"unip":unip,"id":currRowObjJson.id,"macnum":currRowObjJson.macnum,"cpu":cpu,"harddisk":harddisk,"memory":memory,"mactype":mactype,"cabinet": cabinet,"comproom":comproom};
	$.post('/customerserv/updatehosting.action',params,function(result){
		if (result > 0 ) {
			myMesShow ('提示','托管服务器信息修改成功!');
			loadhostingmacs ();
		} else {
			$.messager.alert('Error','托管服务器信息修改失败，请联系管理员!');
		}
		
  	});
	
}

/**
 * 动态获取机房
 * */
function loadCompRoom2 (){
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = eval(rs);
		if (rs) {
			$("#comproomid2").combobox('loadData',jsondata);
		}
  	});
}
/**
 * 机房下拉选择后触发事件
 * 获取选中机房中有空余机位的机柜
 * */
function checkFreeCabinet (id) {
	var comproomid = $(id).combobox('getValue');
		if (comproomid) {
			var url = '/customerMan/checkFreeCabinet.action';
			var params = {"comproomid":comproomid};
			$.post(url,params,function(result){
				var rs = $.trim(result);
				var jsondata = eval(rs);
				if (jsondata){
					$("#cabinetid").combobox('loadData',jsondata);
				} 
			});
		} 
}


function loadCompRoom (){
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	var rs = "";
	var sl=$("#comproomid3");
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
				}
			}
		}
	});
}
