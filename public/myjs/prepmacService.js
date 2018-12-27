$(document).ready(function() {
	loadMachineDataGrid();
	loadCompRoom2 ();           //获取机房
});
var url = undefined;            // 提交路径
function loadMachineDataGrid() {
	// 表头
	var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "macpass", "comproom", "addtime", [ "machid","comproomid"] ];
	if (deptid == 0 || deptid==4){
		dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "macpass", "comproom", "addtime", [ "machid","comproomid"] ];
	}else{
		dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "macpass", "comproom", "addtime", [ "machid","comproomid"] ];
	}
	// 行内按钮
	var clickbutton = {"aMethod":"editMac-修改-editMac-white,grounding-上架-grounding,destroyMac-删除-destroyMac"};
	// 格式化字段
	var formatFileds = {"used":"0-未使用,1-使用中"};
	// 分页配置
	var pageEvent = {"action":"/customerserv/loadmachine.action?status=1&biztype=1"};
	var showTableId = "#prepmachineTid";
	createDataGrid(showTableId, createDataGridJsonRows, dataFiles, clickbutton,
			pageEvent, 10, formatFileds);
}
//查询机器库
function queryAllmachines (currentPage) {
	var macnum = $("#macnumId").val();
	var comproom = $("#comproomid3").val();
	var mactype=$("#mactypeId").val();
	var params = {"macnum" : macnum,"comproom" : comproom ,"mactype":mactype};
	var url = "/customerserv/loadmachine.action?status=1&biztype=1&currPage="+currentPage;
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
				var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "macpass", "comproom", "addtime", [ "machid","comproomid"] ];
				if (deptid == 0 || deptid==4){
					dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "macpass", "comproom", "addtime", [ "machid","comproomid"] ];
				}else{
					dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "comproom", "addtime", [ "machid","comproomid"] ];
				}
				// 行内按钮
				var clickbutton = {"aMethod":"editMac-修改-editMac-white,grounding-上架-grounding,destroyMac-删除-destroyMac"};
				// 格式化字段
				var formatFileds = {"used":"0-未使用,1-使用中"};
				// 分页配置
				var pageEvent = {"action":"/customerserv/loadmachine.action?urlParams=urlParams&"+"&macnum=" + macnum + "&comproom=" + comproom+"&status=1&biztype=1"+"&mactype=" +mactype};
				var showTableId = "#prepmachineTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

// 高级查询
function filtermachineidBiz() {
	var macnum = $("#macnumId").val();
	var comproom = $("#comproomid3").val();
	var mactype=$("#mactypeId").val();
	var url = "/customerserv/loadmachine.action?status=1&biztype=1";
	var params = {"macnum" : macnum,"comproom" : comproom ,"mactype":mactype};
	$.ajax({
			url : url,
			data : params,
			cache : false,
			async : false,
			type : "post",
			dataType : 'json',
			success : function(result) {
			// 表头
			var dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "macpass", "comproom", "addtime", [ "machid","comproomid"] ];
			if (deptid == 0 || deptid==4){
				dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "macpass", "comproom", "addtime", [ "machid","comproomid"] ];
			}else{
				dataFiles = [ "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet", "macname", "comproom", "addtime", [ "machid","comproomid"] ];
			}
			// 行内按钮
			var clickbutton = {"aMethod" : "editMac-修改-editMac-white,grounding-上架-grounding,destroyMac-删除-destroyMac"};
			// 格式化字段
			var formatFileds = {"used" : "0-未使用,1-使用中"};
			
			if (macnum) {
			macnum = encodeURI(encodeURI(macnum));
			}
			if (comproom) {
				comproom = encodeURI(encodeURI(comproom));
			}
			if (mactype) {
				mactype = encodeURI(encodeURI(mactype));
			}
			var urlParams = "/customerserv/loadmachine.action?urlParams=urlParams&"+"&macnum=" + macnum + "&comproom=" + comproom+"&status=1&biztype=1"+"&mactype=" +mactype;
			var pageEvent = {"action" : urlParams};
			var showTableId = "#prepmachineTid";
			createDataGrid(showTableId, result, dataFiles, clickbutton,pageEvent, 10, formatFileds);

		}
	});
}

// 弹出新增机器
function addmachine() {
	loadCompRoom ();
	$('#dlgPrepMachouse').dialog('open').dialog('setTitle', '新增主机');
	$("#addmacnum").focus();
	$('#macfm').form('clear');
	$("#addmacnum").attr("disabled", false);
	//默认机柜
	$("#addprepcabinetid").val("架下机器");
	
}
// 保存机器
function saveMac() {
	var macnum = $("#addmacnum").val();
	if (!macnum) {
		checkImgShow("#macnumMes",-1,'必填');
		return;
	} else{
		checkImgShow("#macnumMes",2);
	}
	var cpu = $("#addcpuid").val();
	if (!cpu) {
		checkImgShow("#cpuMes",-1,'必填');
		return;
	} else{
		checkImgShow("#cpuMes",2);
	}
	var memory = $("#addmemoryid").combobox('getValue');
	if (!memory) {
		checkImgShow("#memoryMes",-1,'必填');
		return;
	} else{
		checkImgShow("#memoryMes",2);
	}
	var harddisk = $("#addharddiskid").combobox('getValue');
	if (!harddisk) {
		checkImgShow("#harddiskMes",-1,'必填');
		return;
	} else{
		checkImgShow("#harddiskMes",2);
	}
	var mactype = $("#addmactypeid").combobox('getValue');
	if (!mactype) {
		checkImgShow("#mactypeMes",-1,'必填');
		return;
	} else{
		checkImgShow("#mactypeMes",2);
	}
	var comproom = $("#addcomproomid").combobox('getValue');
	if (!comproom) {
		checkImgShow("#comproomMes",-1,'必填');
		return;
	} else{
		checkImgShow("#comproomMes ",2);
	}
	var cabinet =$("#addprepcabinetid").val();
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
	var url = "/customerserv/addMachine.action";
	var params = {"macnum":macnum,"cpu":cpu,"harddisk":harddisk,"memory":memory,"mactype":mactype,"cabinet": cabinet,"macname":macname,"macpass":macpass,"comproom":comproom,"status":1};
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		beforeSend: function(){
				var vali3 = checkMacAdd("#addmacnum","#macnumMes");
				return vali3;
        	},
		success : function(result) {
			var rs = $.trim(result);
			if (rs > 0) {
				// 新增后
				$("#addmacnum").val("");
				$("#addmacpass").val("");
				queryAllmachines($("#prepmachineTid #currPage").html().substring(3,$("#prepmachineTid #currPage").html().length-1));
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
		if (id == "#addmacnum") {
			params = {"macnum":inputVal,"machouse":"machouse","status":""};
		} else if (id == "#upMacNum") {
			params = {"macnum":inputVal,"machouse":"machouse","status":0};
		} else if (id == "#updatemacnum"){
			params = {"macnum":inputVal,"machouse":"machouse","status":1};
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
	if (currRowObjJson.machid) {
		$('#Machinehouse').dialog('open').dialog('setTitle','编辑主机信息');
		 loadCompRoom ();
		 
		$("#updatecabinetid").val(mydecode(currRowObjJson.cabinet));
		$("#updatemacnum").val(mydecode(currRowObjJson.macnum));
		$("#updatecpuid").val(mydecode(currRowObjJson.cpu));
		$("#updatemacnameid").val(mydecode(currRowObjJson.macname));
		$("#updatemacpassid").val(mydecode(currRowObjJson.macpass));
		$("#updatecomproomid").combobox("setValue",mydecode(currRowObjJson.comproomid));
		$("#updatecomproomid").combobox("setText",mydecode(currRowObjJson.comproom));
		$("#updatememoryid").combobox("setValue",mydecode(currRowObjJson.memory));
		$("#updateharddiskid").combobox("setValue",mydecode(currRowObjJson.harddisk));
		$("#updatemactypeid").combobox("setValue",mydecode(currRowObjJson.mactype));
		
		$("#updateaddmacnum").focus();

		$("#updateaddmacnum").attr("disabled",true);

	}
}
//保存修改机器
function editsaveMac(){
	var macnum = $("#updatemacnum").val();
	if (!macnum) {
		checkImgShow("#updatemacnumMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatemacnumMes",2);
	}
	var cpu = $("#updatecpuid").val();
	if (!cpu) {
		checkImgShow("#updatecpuMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatecpuMes",2);
	}
	var memory = $("#updatememoryid").combobox('getValue');
	if (!memory) {
		checkImgShow("#updatememoryMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatememoryMes",2);
	}
	var harddisk = $("#updateharddiskid").combobox('getValue');
	if (!harddisk) {
		checkImgShow("#updateharddiskMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updateharddiskMes",2);
	}
	var mactype = $("#updatemactypeid").combobox('getValue');
	if (!mactype) {
		checkImgShow("#updatemactypeMes",-1,'必填');
		return;
	}  else{
		checkImgShow("#updatemactypeMes",2);
	}
	var comproom = $("#updatecomproomid").combobox('getValue');
	if (!comproom) {
		checkImgShow("#updatecomproomMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatecomproomMes",2);
	}
	var cabinet = $("#updatecabinetid").val();
	if (!cabinet) {
		checkImgShow("#updatecabinetMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatecabinetMes",2);
	}
	var macname = $("#updatemacnameid").val();
	if (!macname) {
		checkImgShow("#updatemacnameMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatemacnameMes",2);
	}
	var macpass = $("#updatemacpassid").val();
	if (!macpass) {
		checkImgShow("#updatemacpassMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatemacpassMes",2);
	}
	var url = "/customerserv/updateMac.action";
	var params = {"machid":currRowObjJson.machid,"macnum":macnum,"cpu":cpu,"harddisk":harddisk,"memory":memory,"mactype":mactype,"cabinet": cabinet,"macname":macname,"macpass":macpass,"comproom":comproom,"status":1};
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		beforeSend: function(){
			if(currRowObjJson.macnum == macnum){
				return true;
			}
			var vali3 = checkMacAdd("#updatemacnum","#updatemacnumMes");
			return vali3;
        },
		success : function(result) {
			var rs = $.trim(result);
			if (rs > 0) {
				$('#Machinehouse').dialog('close');
				queryAllmachines ($("#prepmachineTid #currPage").html().substring(3,$("#prepmachineTid #currPage").html().length-1));
				myMesShow ('提示','预备主机信息修改成功!');
			}else{
				myMesShow ('提示','信息修改失败!');
			}
		}
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
						queryAllmachines($("#prepmachineTid #currPage").html().substring(3,$("#prepmachineTid #currPage").html().length-1));
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
	$.ajax({
		type:'post',
		cache:false,
		url:url,
		data:null,
		dataType:"json",
		async:false,
		success:function(jsondata){
			if (jsondata) {
				$("#addcomproomid").combobox('loadData',jsondata);
				$("#updatecomproomid").combobox('loadData',jsondata);
			}
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
				$("#upPrepCabinetid").combobox('loadData',jsondata);
			});
		} 
}

function checkFreeCabinet2 (comproomid) {
		if (comproomid) {
			var url = '/customerMan/checkFreeCabinet.action';
			var params = {"comproomid":comproomid};
			$.post(url,params,function(result){
				var rs = $.trim(result);
				var jsondata = eval(rs);
				$("#upPrepCabinetid").combobox('loadData',jsondata);
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

/*
 * 主机上架
 * */
function grounding(){
	if(currRowObjJson.machid){
		$('#dlgGrounding').dialog('open').dialog('setTitle', '上架主机');
		loadCompRoom ();
		checkFreeCabinet2(mydecode(currRowObjJson.comproomid));
		$("#upMacNum").val(mydecode(currRowObjJson.macnum));
		$("#upCpuId").val(mydecode(currRowObjJson.cpu));
		$("#upMemoryId").val(mydecode(currRowObjJson.memory));
		$("#upHardDiskId").val(mydecode(currRowObjJson.harddisk));
		$("#upMacTypeId").val(mydecode(currRowObjJson.mactype));
		$("#upComproomId").val(mydecode(currRowObjJson.comproom));
		$("#upPrepCabinetid").combobox("setText",mydecode(""));
		$("#upPrepCabinetid").combobox("setValue",mydecode(""));
		$("#upDxipId").val(mydecode(""));
		$("#upUnipId").val(mydecode(""));
		$("#upMacNameId").val(mydecode(currRowObjJson.macname));
		$("#upMacPassId").val(mydecode(currRowObjJson.macpass));
	}
}

function toGrounding(){
	var macnum = $("#upMacNum").val();
	if (!macnum) {
		checkImgShow("#upMacNumMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upMacNumMes",2);
	}
	var cpu = $("#upCpuId").val();
	if (!cpu) {
		checkImgShow("#upCpuMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upCpuMes",2);
	}
	var memory = $("#upMemoryId").val();
	if (!memory) {
		checkImgShow("#upMemoryMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upMemoryMes",2);
	}
	var harddisk = $("#upHardDiskId").val();
	if (!harddisk) {
		checkImgShow("#upHardDiskMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upHardDiskMes",2);
	}
	var mactype = $("#upMacTypeId").val();
	if (!mactype) {
		checkImgShow("#upMacTypeMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upMacTypeMes",2);
	}
	var comproom = $("#upComproomId").val();
	if (!comproom) {
		checkImgShow("#upComproomMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upComproomMes",2);
	}
	var cabinet =$("#upPrepCabinetid").combobox('getValue');
	if (!cabinet) {
		checkImgShow("#upCabinetMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upCabinetMes",2);
	}
	var dxip = $("#upDxipId").val();
	if (!dxip) {
		checkImgShow("#dxerrorsip",-1,'必填');
		return;
	} else{
		checkImgShow("#dxerrorsip ",2);
	}
	var unicomip = $("#upUnipId").val();
	/*if (!unicomip) {
		checkImgShow("#unerrorsip",-1,'必填');
		return;
	} else{
		checkImgShow("#unerrorsip ",2);
	}*/
	var macname = $("#upMacNameId").val();
	if (!macname) {
		checkImgShow("#upMacNameMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upMacNameMes ",2);
	}
	var macpass = $("#upMacPassId").val();
	if (!macpass) {
		checkImgShow("#upMacPassMes",-1,'必填');
		return;
	} else{
		checkImgShow("#upMacPassMes",2);
	}
	var url = "/customerserv/upMac.action";
	var params = {"machid":currRowObjJson.machid,"macnum":macnum,"cpu":cpu,"harddisk":harddisk,"memory":memory,"mactype":mactype,"cabinet": cabinet,"dxip":dxip,"unicomip":unicomip,"macname":macname,"macpass":macpass,"comproom":currRowObjJson.comproomid,"status":0};
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		beforeSend: function(){
        	    var rsvali = false;
        	    var vali1 = true;
        	    var ipvali1 = false;
        	    if( $.trim(unicomip)!=""){
        	    	vali1  = checIPExit("unip","#upUnipId");
        	    	if(vali1 ==false){//存在这个IP，再判断这个IP与机房是否匹配
    					ipvali1 = checkIpComproom("unip","#upUnipId",currRowObjJson.comproomid);
    				}
        	    }else{
        	    	 vali1 = false;
        	    	ipvali1 = true;
        	    }
				var vali2 = checIPExit("dxip","#upDxipId");
				var vali3 = checkMacAdd("#upMacNum","#upMacNumMes");
				var ipvali2 = false;
				if(vali2 ==false){//存在这个IP，再判断这个IP与机房是否匹配
					ipvali2 = checkIpComproom("dxip","#upDxipId",currRowObjJson.comproomid);
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
				$('#dlgGrounding').dialog('close');
				queryAllmachines($("#prepmachineTid #currPage").html().substring(3,$("#prepmachineTid #currPage").html().length-1));
				$.messager.show({
					title : '提示',
					msg : '主机上架成功！'
				});
			}
		}
	});
}
