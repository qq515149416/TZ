$(document).ready(function() {
	loadMachineDataGrid();
	loadCompRoom2 ();//获取机房
});
var url = undefined; // 提交路径
function loadMachineDataGrid() {
	// 表头
	var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "macpass", "comproom","used", "addtime", [ "machid","comproomid" ] ];
	if (deptid == 0 || deptid==4){
		dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "macpass", "comproom","used", "addtime", [ "machid","comproomid" ] ];
	}else{
		dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "comproom","used", "addtime", [ "machid","comproomid" ] ];
	}
	// 行内按钮
	var clickbutton = {"aMethod":"editMac-修改-editMac-white,unShelve-下架-unShelve"};
	// 格式化字段
	var formatFileds = {"used":"0-未使用,1-使用中"};
	// 分页配置
	var pageEvent = {"action":"/customerserv/loadmachine.action?status=0&biztype=1"};
	var showTableId = "#machineTid";
	createDataGrid(showTableId, createDataGridJsonRows, dataFiles, clickbutton,
			pageEvent, 10, formatFileds);
}
//查询机器库
function queryAllmachines (currentPage) {
	var dxip = $("#dxipId").val();
	var unicomip = $("#unicomipId").val();
	var macnum = $("#macnumId").val();
	var cabinet = $("#cabinetid").val();
	var used = $("#usedId").val();
	var comproom = $("#comproomid3").val();
	var mactype=$("#mactype").val();
	var params = {"dxip" : dxip,"unicomip" : unicomip,"macnum" : macnum,"cabinet" : cabinet,"used" : used ,"comproom" : comproom ,"mactype":mactype};
	var url = "/customerserv/loadmachine.action?status=0&biztype=1&currPage="+$("#machineTid #currPage").html().substring(3,$("#machineTid #currPage").html().length-1)+"&dxip";
	$.ajax({
        url : url,
        data : params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				// 表头
				var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "macpass", "comproom","used", "addtime", [ "machid","comproomid" ] ];
				if (deptid == 0 || deptid==4){
					dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "macpass", "comproom","used", "addtime", [ "machid","comproomid" ] ];
				}else{
					dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "comproom","used", "addtime", [ "machid","comproomid" ] ];
				}
				// 行内按钮
				var clickbutton = {"aMethod":"editMac-修改-editMac-white,unShelve-下架-unShelve"};
				// 格式化字段
				var formatFileds = {"used":"0-未使用,1-使用中"};
				// 分页配置
				var pageEvent = {"action":"/customerserv/loadmachine.action?status=0&biztype=1"};
				var showTableId = "#machineTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

// 高级查询
function filtermachineidBiz() {
	var dxip = $("#dxipId").val();
	var unicomip = $("#unicomipId").val();
	var macnum = $("#macnumId").val();
	var cabinet = $("#cabinetid").val();
	var used = $("#usedId").val();
	var comproom = $("#comproomid3").val();
	var mactype=$("#mactype").val();
	var url = "/customerserv/loadmachine.action?urlParams=urlParams&status=0&biztype=1"+ "&dxip="+ dxip+ "&unicomip="+ unicomip+ "&macnum=" + macnum + "&cabinet=" + cabinet + "&used=" + used + "&comproom=" + comproom;
	var params = {"dxip" : dxip,"unicomip" : unicomip,"macnum" : macnum,"cabinet" : cabinet,"used" : used ,"comproom" : comproom ,"mactype":mactype};
	$.ajax({
			url : url,
			data : params,
			cache : false,
			async : false,
			type : "post",
			dataType : 'json',
			success : function(result) {
			// 表头
			var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "macpass", "comproom","used", "addtime", [ "machid","comproomid" ] ];
			if (deptid == 0 || deptid==4){
				dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "macpass", "comproom","used", "addtime", [ "machid","comproomid" ] ];
			}else{
				dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype","cabinet", "dxip", "unicomip", "macname", "comproom","used", "addtime", [ "machid","comproomid" ] ];
			}
			// 行内按钮
			var clickbutton = {"aMethod" : "editMac-修改-editMac-white,unShelve-下架-unShelve"};
			// 格式化字段
			var formatFileds = {"used" : "0-未使用,1-使用中"};
			// 分页配置
			/*if (dxip) {
			dxip = encodeURI(encodeURI(dxip));
			}
			if (unicomip) {
			unicomip = encodeURI(encodeURI(unicomip));
			}
			if (macnum) {
			macnum = encodeURI(encodeURI(macnum));
			}
			if (cabinet) {
				cabinet = encodeURI(encodeURI(cabinet));
			}
			if (used) {
				used = encodeURI(encodeURI(used));
			}
			if (comproom) {
				comproom = encodeURI(encodeURI(comproom));
			}*/
			if (mactype) {
				mactype = encodeURI(encodeURI(mactype));
			}
			var urlParams = "/customerserv/loadmachine.action?urlParams=urlParams&biztype=1"+ "&dxip="+ dxip+ "&unicomip="+ unicomip+ "&macnum=" + macnum + "&cabinet=" + cabinet + "&used=" + used + "&comproom=" + comproom+"&status=0"+"&mactype=" +mactype;
			var pageEvent = {"action" : urlParams};
			var showTableId = "#machineTid";
			createDataGrid(showTableId, result, dataFiles, clickbutton,pageEvent, 10, formatFileds);

		}
	});
}

// 弹出新增机器
function addmachine() {
	loadCompRoom ();
	//给机房下拉添加onChange事件
	$("#comproomid1").combobox({
		onChange : function(n, o) {
			checkFreeCabinet("#comproomid1")
		}
	});
	$('#dlgMachouse').dialog('open').dialog('setTitle', '新增主机');
	$("#addmacnum").focus();
	$('#macfm').form('clear');
	url = '/customerserv/addMachine.action';

	// 可以修改IP
	//$("#addDxipid").attr("disabled", false);
	//$("#addUnipid").attr("disabled", false);
	$("#addmacnum").attr("disabled", false);
	$("#dxerrorsip").html("* 请输入IP库中的电信IP");
	$("#unerrorsip").html("* 请输入IP库中的联通IP");
}
// 保存机器
function saveMac() {
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
	} else{
		checkImgShow("#mactypeMes",2);
	}
	var macnum = $("#addmacnum").val();
	var cpu = $("#cpuid").val();
	if (!cpu) {
		checkImgShow("#cpuMes",-1,'必填');
		return;
	} else{
		checkImgShow("#cpuMes",2);
	}
	var cabinet =$("#cabinetid1").combobox('getValue');
	//var cabinet = $("#cabinetid").val();
	if (!cabinet) {
		checkImgShow("#cabinetMes",-1,'必填');
		return;
	} else{
		checkImgShow("#cabinetMes",2);
	}
	var dxip = $("#addDxipid").val();
	var unicomip = $("#addUnipid").val();
	var macname = $("#macnameid").val();
	if (!macname) {
		checkImgShow("#macnameMes",-1,'必填');
		return;
	} else{
		checkImgShow("#macnameMes ",2);
	}
	var macpass = $("#macpassid").val();
	if (!macpass) {
		checkImgShow("#macpassMes",-1,'必填');
		return;
	} else{
		checkImgShow("#macpassMes",2);
	}
	var comproom = $("#comproomid1").combobox('getValue');
	if (!comproom) {
		checkImgShow("#comproomMes",-1,'必填');
		return;
	} else{
		checkImgShow("#comproomMes",2);
	}
	var url = "/customerserv/addMachine.action";
	var params = {"macnum":macnum,"cpu":cpu,"harddisk":harddisk,"memory":memory,"mactype":mactype,"cabinet": cabinet,"dxip":dxip,"unicomip":unicomip,"macname":macname,"macpass":macpass,"comproom":comproom};
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		beforeSend: function(){
        	var rsvali = false;
				var vali1 = checIPExit("unip","#addUnipid");
				var vali2 = checIPExit("dxip","#addDxipid");
				var vali3 = checkMacAdd("#addmacnum","#macnumMes");
				var ipvali1 = false;
				var ipvali2 = false;
				if(vali1 ==false){//存在这个IP，再判断这个IP与机房是否匹配
					ipvali1 = checkIpComproom("unip","#addUnipid",comproom);
				}
				if(vali2 ==false){//存在这个IP，再判断这个IP与机房是否匹配
					ipvali2 = checkIpComproom("dxip","#addDxipid",comproom);
				}
				if (vali1 == false && vali2 == false && vali3 == true  && ipvali1 == true && ipvali2 == true) {
					rsvali = true;
				} 
					return rsvali;
        	},
		success : function(result) {
			var rs = $.trim(result);
			if (rs > 0) {
				// 新增后
				$("#addmacnum").val("");
				$("#addDxipid").val("");
				$("#addUnipid").val("");
				$("#addmacpass").val("");
				queryAllmachines();
				$.messager.show({
					title : '提示',
					msg : '新增主机成功！'
				});
			}
		}
	});
}
//检查输入编号是否重复
function checkMacAdd (id,messpan) {
		var inputVal = $(id).val();
		var ipIsExit = false;
		if (inputVal) {
			var url2 = '/customerMan/checkMacnumRepeat.action';
			var params = undefined;
			if (id == "#addDxipid") {
				params = {"dxip":inputVal};
				
			} else if (id == "#addUnipid") {
				params = {"unip":inputVal};
				
			} else if (id == "#addmacnum") {
				params = {"macnum":inputVal,"machouse":"machouse"};
			} 
			
			//同步请求.
			$.ajax({
		        url : url2,
		        data: params,
		        cache : false, 
		        async : false,
		        type : "POST",
		        dataType : 'json',
		        success : function (result){
					var rs = $.trim(result);
					if (rs > 0){
						$(messpan).html("<font color='red'>已存在!</font>");
					} else {
						$(messpan).html("");
						ipIsExit = true;
					}
		        }
			});
			
		} else {
			$(id).focus();
			$(messpan).html("<font color='red'>*必填</font>");
		}
	return ipIsExit;
}

//修改机器
function editMac(){
	if (currRowObjJson.dxip) {
		$('#Machouse').dialog('open').dialog('setTitle','编辑主机信息');
		 loadCompRoom ();
		// 给机房下拉添加onChange事件
		$("#comproomid2").combobox({
			onChange : function(n, o) {
				checkFreeCabinet("#comproomid2")
			}
		});
		//$('#mac').form('load',currRowObjJson);
		$("#Machouse #addDxipid").val(mydecode(currRowObjJson.dxip));
		$("#Machouse #addUnipid").val(mydecode(currRowObjJson.unicomip));
		$("#Machouse #ydxipid").val(mydecode(currRowObjJson.dxip));
		$("#Machouse #yunipid").val(mydecode(currRowObjJson.unicomip));
		$("#Machouse #addmacnum").val(mydecode(currRowObjJson.macnum));
		$("#Machouse #cpuid").val(mydecode(currRowObjJson.cpu));
		$("#Machouse #cabinetid2").val(mydecode(currRowObjJson.cabinet));
		$("#Machouse #macnameid").val(mydecode(currRowObjJson.macname));
		$("#Machouse #macpassid").val(mydecode(currRowObjJson.macpass));
		//$("#Machouse #cabinetid2").val(mydecode(currRowObjJson.cabinet));
		$("#Machouse #cabinetid2").combobox("setValue",mydecode(currRowObjJson.cabinet));
		$("#Machouse #comproomid2").combobox("setValue",mydecode(currRowObjJson.comproomid));
		$("#Machouse #comproomid2").combobox("setText",mydecode(currRowObjJson.comproom));
		$("#Machouse #memoryid").combobox("setValue",mydecode(currRowObjJson.memory));
		$("#Machouse #harddiskid").combobox("setValue",mydecode(currRowObjJson.harddisk));
		$("#Machouse #mactypeid").combobox("setValue",mydecode(currRowObjJson.mactype));
		
		$("#Machouse #addmacnum").focus();

		//不可以修改IP
		//$("#Machouse #addDxipid").attr("disabled",true);
		//$("#Machouse #addUnipid").attr("disabled",true);
		$("#Machouse #addmacnum").attr("disabled",true);
		$("#Machouse #dxerrorsip").html("");
		$("#Machouse #unerrorsip").html("");
	}
}
//保存修改机器
function editsaveMac(){
	var memory = $("#Machouse #memoryid").combobox('getValue');
	if (!memory) {
		checkImgShow("#Machouse #memoryMes",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #memoryMes",2);
	}
	var harddisk = $("#Machouse #harddiskid").combobox('getValue');
	if (!harddisk) {
		checkImgShow("#Machouse #harddiskMes",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #harddiskMes",2);
	}
	var mactype = $("#Machouse #mactypeid").combobox('getValue');
	if (!mactype) {
		checkImgShow("#Machouse #mactypeMes",-1,'必填');
		return;
	}  else{
		checkImgShow("#Machouse #mactypeMes",2);
	}
	var cpu = $("#Machouse #cpuid").val();
	if (!cpu) {
		checkImgShow("#Machouse #cpuMes",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #cpuMes",2);
	}
	var cabinet = $("#Machouse #cabinetid2").combobox('getValue');
	if (!cabinet) {
		checkImgShow("#Machouse #cabinetMes",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #cabinetMes",2);
	}
	var macname = $("#Machouse #macnameid").val();
	if (!macname) {
		checkImgShow("#Machouse #macnameMes",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #macnameMes",2);
	}
	var macpass = $("#Machouse #macpassid").val();
	if (!macpass) {
		checkImgShow("#Machouse #macpassMes",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #macpassMes",2);
	}
	var comproom = $("#Machouse #comproomid2").combobox('getValue');
	if (!comproom) {
		checkImgShow("#Machouse #comproomMes",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #comproomMes",2);
	}
	var dxip = $("#Machouse #addDxipid").val();
	if (!dxip) {
		checkImgShow("#Machouse #dxerrorsip",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #dxerrorsip",2);
	}
	var unip = $("#Machouse #addUnipid").val();
/*	if (!unip) {
		checkImgShow("#Machouse #unerrorsip",-1,'必填');
		return;
	} else{
		checkImgShow("#Machouse #unerrorsip",2);
	}*/
	
	
	var yunip = $("#Machouse #yunipid").val();
	var vali1 = false;
	var ipvali1 =false;
	if($.trim(yunip)!=$.trim(unip)  && $.trim(unip)!=""){
		vali1 = searchIPCounts("unip","#Machouse #addUnipid","#Machouse #unerrorsip",0);//判断新IP是否存在可用
		if(vali1 ==true){//存在这个IP，再判断这个IP与机房是否匹配
			ipvali1 = checkIpComproom("unip","#Machouse #addUnipid",comproom);
		}
	}else{
		vali1 = true;
		ipvali1 =true;
	}
	var ydxip = $("#Machouse #ydxipid").val();
	var vali2 = false;
	var ipvali2 =false;
	if($.trim(ydxip)!=$.trim(dxip)){
		vali2 = searchIPCounts("dxip","#Machouse #addDxipid","#Machouse #dxerrorsip",0);//判断新IP是否存在可用
		if(vali2 ==true){//存在这个IP，再判断这个IP与机房是否匹配
			ipvali2 = checkIpComproom("dxip","#Machouse #addDxipid",comproom);
		}
	}else{
		vali2 = true;
		ipvali2 =true;
	}
	
	if (!vali1 || !vali2 ||!ipvali1  ||!ipvali2) {
		return;
	}
	var params = {"ydxip":ydxip,"yunip":yunip,"dxip":dxip,"unip":unip,"machid":currRowObjJson.machid,"macnum":currRowObjJson.macnum,"cpu":cpu,"harddisk":harddisk,"memory":memory,"mactype":mactype,"cabinet": cabinet,"macname":macname,"macpass":macpass,"comproom":comproom};
	$.post('/customerserv/updateMac.action',params,function(result){
		if (result > 0 ) {
			myMesShow ('提示','服务器信息修改成功!');
		}
		queryAllmachines();
  	});
	$('#Machouse').dialog('close');
}
//删除机器
function destroyMac(){
	var str = '确定要删除编号为【'+currRowObjJson.macnum+'】的主机吗？';
	if (currRowObjJson){
		if (currRowObjJson.used == 1) {
			$.messager.show({ // show error message
				title: '提 示',
				msg: '使用中的机器不能删除,请走回收流程！'
			});
			return;
		}
		$.messager.confirm('Confirm',str,function(r){    
			if (r){
				url = '/customerserv/deleteMac.action';
				$.post(url,{"machid":currRowObjJson.machid,'dxip':currRowObjJson.dxip,'unip':currRowObjJson.unicomip,'cabinet':currRowObjJson.cabinet,'comproomid':currRowObjJson.comproomid},function(result){
					var rs = $.trim(result);
					if (rs > 0){
						$.messager.show({ // show error message
							title: 'Error',
							msg: '已成功删除主机！'
						});
						queryAllmachines();
					} else {
						$.messager.show({ // show error message
							title: 'Error',
							msg: '删除主机失败，请联系管理员！'
						});
					}
				});
			}
		});
	}
}

/**
 * 动态获取机房
 * */
function loadCompRoom (){
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = eval(rs);
		if (rs) {
			$("#comproomid1").combobox('loadData',jsondata);
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
					$("#cabinetid1").combobox('loadData',jsondata);
					$("#cabinetid2").combobox('loadData',jsondata);
				} 
			});
		} 
}


function loadCompRoom2 (){
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

function unShelve(){
	var str = '确定要将编号为【'+currRowObjJson.macnum+'】的主机下架吗？';
	if (currRowObjJson){
		if (currRowObjJson.used == 1) {
			$.messager.show({ // show error message
				title: '提 示',
				msg: '使用中的机器不能下架,请走回收流程！'
			});
			return;
		}
		$.messager.confirm('Confirm',str,function(r){    
			if (r){
				url = '/customerserv/downMac.action';
				var params = {"cabinet":"架下机器",'macnum':currRowObjJson.macnum,'machid':currRowObjJson.machid,'dxip':currRowObjJson.dxip,'unip':currRowObjJson.unicomip,'comproomid':currRowObjJson.comproomid,"status":1};
				$.ajax({
					url : url,
					data : params,
					cache : false,
					async : false,
					type : "post",
					dataType : 'json',
					success : function(result) {
						var rs = $.trim(result);
						if (rs > 0) {
							queryAllmachines();
							$.messager.show({
								title : '提示',
								msg : '主机下架成功！'
							});
						}
					}
				});
				
			}
		});
	}
}

