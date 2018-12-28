$(document).ready(function() {
	loadMachineDataGrid_coll();
	loadCompRoom2_coll ();           //获取机房
	addOnblur();
});
var url = undefined;            // 提交路径
function loadMachineDataGrid_coll() {
	// 表头
	var dataFiles = ["truename","custruename", "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet",  "comproom", "addtime","note", [ "machid","comproomid"] ];
	// 行内按钮
	var clickbutton = {"aMethod":"editMac_coll-修改-editMac_coll-white,destroyMac_coll-删除-destroyMac_coll"};
	// 格式化字段
	var formatFileds = {"used":"0-未使用,1-使用中"};
	// 分页配置
	var pageEvent = {"action":"/customerserv/loadmachine.action?status=1&biztype=0&used=0&rentOrHosting=hosting"};
	var showTableId = "#prepmachineTid_coll";
	createDataGrid(showTableId, createDataGridJsonRows, dataFiles, clickbutton,
			pageEvent, 10, formatFileds);
}
//查询机器库
function queryAllmachines_coll (currentPage) {
	var url = "/customerserv/loadmachine.action?status=1&biztype=0&used=0&rentOrHosting=hosting&currPage="+$("#prepmachineTid_coll #currPage").html().substring(3,$("#prepmachineTid_coll #currPage").html().length-1);
	var macnum = $("#macnumId").val();
	var comproom = $("#comproomid3").val();
	var params = {"macnum" : macnum,"comproom" : comproom };
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
				var dataFiles = [ "truename","custruename", "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet",  "comproom", "addtime", "note",[ "machid","comproomid"] ];
				// 行内按钮
				var clickbutton = {"aMethod":"editMac_coll-修改-editMac_coll-white,destroyMac_coll-删除-destroyMac_coll"};
				// 格式化字段
				var formatFileds = {"used":"0-未使用,1-使用中"};
				// 分页配置
				var pageEvent = {"action":"/customerserv/loadmachine.action?urlParams=urlParams&used=0&rentOrHosting=hosting&"+"&macnum=" + macnum + "&comproom=" + comproom+"&status=1&biztype=0"};
				var showTableId = "#prepmachineTid_coll";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

// 高级查询
function filtermachineidBiz_coll() {
	var macnum = $("#macnumId").val();
	var comproom = $("#comproomid3").val();
	var url = "/customerserv/loadmachine.action?status=1&biztype=0&used=0&rentOrHosting=hosting";
	var params = {"macnum" : macnum,"comproom" : comproom };
	$.ajax({
			url : url,
			data : params,
			cache : false,
			async : false,
			type : "post",
			dataType : 'json',
			success : function(result) {
			// 表头
			var dataFiles = [ "truename","custruename", "macnum", "cpu", "memory", "harddisk", "mactype", "cabinet",  "comproom", "addtime", "note",[ "machid","comproomid"] ];
			// 行内按钮
			var clickbutton = {"aMethod" : "editMac_coll-修改-editMac_coll-white,destroyMac_coll-删除-destroyMac_coll"};
			// 格式化字段
			var formatFileds = {"used" : "0-未使用,1-使用中"};
			
			if (macnum) {
			macnum = encodeURI(encodeURI(macnum));
			}
			if (comproom) {
				comproom = encodeURI(encodeURI(comproom));
			}
			var urlParams = "/customerserv/loadmachine.action?urlParams=urlParams&used=0&rentOrHosting=hosting&"+"&macnum=" + macnum + "&comproom=" + comproom+"&status=1&biztype=0";
			var pageEvent = {"action" : urlParams};
			var showTableId = "#prepmachineTid_coll";
			createDataGrid(showTableId, result, dataFiles, clickbutton,pageEvent, 10, formatFileds);

		}
	});
}

// 弹出新增机器
function addmachine_coll() {
	remvoAllMes();
	loadCompRoom_coll ();
	$('#dlgPrepMachouse_coll').dialog('open').dialog('setTitle', '新增主机');
	$("#custname").focus();
	$('#macfm').form('clear');
	$("#addmacnum").attr("disabled", false);
	//默认机柜
	$("#addprepcabinetid").val("架下机器");
	$("#custname").val();
	$('#addmacNoteid').val();
	$('#s_custid_info').html('');
	$('#s_custid').combobox('loadData',{});
	$('#s_custid').combobox('clear');
	
}

//添加onblur事件處理
function onblurCheck(name,mes,op){
	
	if(typeof op == "undefined" || op == "val"){
		$('#'+name).blur(function(){
			var labelName = $('#'+name).val();
			if(!labelName){
				checkImgShow('#'+mes,-1,'必填');
				return;
			}
			else{
				checkImgShow('#'+mes,2);
			}
		});
	}else if(op == "combobox"){
		$('#'+name).combobox().next().children(":text").blur(function(){
			var labelName = $('#'+name).combobox('getValue');
			if(!labelName){
				checkImgShow('#'+mes,-1,'必填');
				return;
			}
			else{
				checkImgShow('#'+mes,2);
			}
		});
	}
}
//添加onInput事件處理
function onInputCheck(name,mes,op){
	if(typeof op == "undefined" || op == "val"){
		$('#'+name).bind('input propertychange',function(){
			var labelName = $('#'+name).val();
			if(!labelName){
				checkImgShow('#'+mes,-1,'必填');
				return;
			}
			else{
				checkImgShow('#'+mes,2);
			}
		});
	}else if(op == "combobox"){

		$('#'+name).combobox({
			onChange:function(){
				var labelName = $('#'+name).combobox('getValue');
				if(!labelName){
					checkImgShow('#'+mes,-1,'必填');
					return;
				}
				else{
					checkImgShow('#'+mes,2);
				}
			}});
	}
}
//增加onBlur,onChange事件
function addOnblur(){
	onblurCheck("custname","custnameMes");
	onblurCheck("addmacnum","macnumMes");
	onblurCheck("addcpuid","cpuMes");
	onblurCheck("addmemoryid","memoryMes","combobox");
	onblurCheck("addharddiskid","harddiskMes","combobox");
	onblurCheck("addmactypeid","mactypeMes","combobox");
	onblurCheck("addcomproomid","comproomMes","combobox");
	
	onInputCheck("custname","custnameMes");
	onInputCheck("addmacnum","macnumMes");
	onInputCheck("addcpuid","cpuMes");
	onInputCheck("addmemoryid","memoryMes","combobox");
	onInputCheck("addharddiskid","harddiskMes","combobox");
	onInputCheck("addmactypeid","mactypeMes","combobox");
	onInputCheck("addcomproomid","comproomMes","combobox");
	
	//客户账号
	
	
	$("#custname").bind('input propertychange',function(){
		$('#s_custid_info').html('');
		$('#s_custid').combobox('loadData',{});
		$('#s_custid').combobox('clear');
		
	});
}
//清除标记
function removeMes(mes){
	checkImgShow('#'+mes,2);
}
//清除所有标记
function remvoAllMes(){
	removeMes("custnameMes");
	removeMes("macnumMes");
	removeMes("cpuMes");
	removeMes("memoryMes");
	removeMes("harddiskMes");
	removeMes("mactypeMes");
	removeMes("comproomMes");
}

//通过客户姓名查找客户账号信息，详细定位
function checkCustAccount(){
	var custruename = $("#custname").val();
	var mastername = $("#mastername").val();
	$.ajax({
		url : "/customerserv/queryCustidbyName.action",
		data : {"custruename":custruename,"mastername":mastername,"urltag":"false"},
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		success : function(result) {
			$("#s_custid").combobox({
				valueField:'cusid',
				textField:'cusname',
				data:result.list
			});
			if(result.size == 1){
				  $('#s_custid').combobox('select', result.list[0].cusid);
			}
			$('#s_custid_info').html('下拉'+result.size+'选1')
			}
		});
}

// 保存机器
function saveMac_coll() {
	var custname = $("#custname").val();
	var custid = $("#s_custid").combobox('getValue');
	if(custid ==''){
		alert('请选择客户账号');
	}
/*	//获取后清空值
	$('#s_custid').combobox('loadData',{});
	$('#s_custid').combobox('clear');*/
	var macnum = $("#addmacnum").val();
	var note = $("#addmacNoteid").val();
	var cpu = $("#addcpuid").val();
	var memory = $("#addmemoryid").combobox('getValue');
	var harddisk = $("#addharddiskid").combobox('getValue');
	var mactype = $("#addmactypeid").combobox('getValue');
	var comproom = $("#addcomproomid").combobox('getValue');
	if(!custname ||　!macnum ||　!cpu ||　!memory ||　!harddisk ||　!mactype ||　!comproom){
		return;
	}
	var cabinet =$("#addprepcabinetid").val();
	var url = "/customerserv/addMachine.action";
	var params = {"macnum":macnum,"note":note,"cpu":cpu,"harddisk":harddisk,"memory":memory,"mactype":mactype,"cabinet": cabinet,"macname":"","macpass":"","comproom":comproom,"status":1,biztype:0,collStr:"true","custid":custid};
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		beforeSend: function(){
				var vali3 = checkMacAdd_coll("#addmacnum","#macnumMes");
				return vali3;
        	},
		success : function(result) {
			var rs = $.trim(result);
			if (rs > 0) {
				// 新增后
				
				$("#addmacnum").val("");
				$("#addmacpass").val("");
				queryAllmachines_coll();
				$.messager.show({
					title : '提示',
					msg : '新增主机成功！'
				});
			}else{
				$.messager.show({
					title : '提示',
					msg : '新增主机失败！'
				});
			}
		}
	});
}
//检查输入编号是否重复
function checkMacAdd_coll (id,messpan) {
	var inputVal = $(id).val();
	var ipIsExit = false;
	if (inputVal) {
		var url2 = '/customerMan/checkMacnumRepeat.action';
		var params = undefined;
		if (id == "#addmacnum") {
			params = {"macnum":inputVal,"Machouse":"machouse","status":""};
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
function editMac_coll(){
	if (currRowObjJson.machid) {
		$('#Machinehouse_coll').dialog('open').dialog('setTitle','编辑主机信息');
		 loadCompRoom_coll ();
		 
		$("#updatecabinetid").val(mydecode(currRowObjJson.cabinet));
		$("#updatemacnum").val(mydecode(currRowObjJson.macnum));
		$("#updatecpuid").val(mydecode(currRowObjJson.cpu));
		$("#macNoteid").val(mydecode(mydecode(currRowObjJson.note)));
		$("#updatecomproomid").combobox("setValue",mydecode(currRowObjJson.comproomid));
		$("#updatecomproomid").combobox("setText",mydecode(currRowObjJson.comproom));
		$("#updatememoryid").combobox("setValue",mydecode(currRowObjJson.memory));
		$("#updateharddiskid").combobox("setValue",mydecode(currRowObjJson.harddisk));
		$("#updatemactypeid").combobox("setValue",mydecode(currRowObjJson.mactype));

		$("#updateaddmacnum").attr("disabled",true);

	}
}
//保存修改机器
function editsaveMac_coll(){
	var macnum = $("#updatemacnum").val();
	/*if (!macnum) {
		checkImgShow("#updatemacnumMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatemacnumMes",2);
	}*/
	var cpu = $("#updatecpuid").val();
	var note = $("#macNoteid").val();
//	if (!cpu) {
//		checkImgShow("#updatecpuMes",-1,'必填');
//		return;
//	} else{
//		checkImgShow("#updatecpuMes",2);
//	}
	var memory = $("#updatememoryid").combobox('getValue');
//	if (!memory) {
//		checkImgShow("#updatememoryMes",-1,'必填');
//		return;
//	} else{
//		checkImgShow("#updatememoryMes",2);
//	}
	var harddisk = $("#updateharddiskid").combobox('getValue');
	/*if (!harddisk) {
		checkImgShow("#updateharddiskMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updateharddiskMes",2);
	}*/
	var mactype = $("#updatemactypeid").combobox('getValue');
	/*if (!mactype) {
		checkImgShow("#updatemactypeMes",-1,'必填');
		return;
	}  else{
		checkImgShow("#updatemactypeMes",2);
	}*/
	var comproom = $("#updatecomproomid").combobox('getValue');
//	if (!comproom) {
//		checkImgShow("#updatecomproomMes",-1,'必填');
//		return;
//	} else{
//		checkImgShow("#updatecomproomMes",2);
//	}
	//var cabinet = $("#updatecabinetid").val();
	/*if (!cabinet) {
		checkImgShow("#updatecabinetMes",-1,'必填');
		return;
	} else{
		checkImgShow("#updatecabinetMes",2);
	}*/
	
	var url = "/customerserv/updateMac.action";
	var params = {"note":note,"machid":currRowObjJson.machid,"macnum":macnum,"cpu":cpu,"harddisk":harddisk,"memory":memory,"mactype":mactype,"cabinet": "架下机器","macname":"","macpass":"","comproom":comproom,"status":1};
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
			var vali3 = checkMacAdd_coll("#updatemacnum","#updatemacnumMes");
			return vali3;
        },
		success : function(result) {
			var rs = $.trim(result);
			
			if (rs > 0) {
				$('#Machinehouse_coll').dialog('close');
				queryAllmachines_coll ();
				myMesShow ('提示','预备主机信息修改成功!');
			}else{
				myMesShow ('提示','信息修改失败!');
			}
		}
	});
	$('#Machouse_coll').dialog('close');
}
//删除机器
function destroyMac_coll(){
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
				url = '/customerserv/deleteMac.action?iscoll=true';
				$.post(url,{"machid":currRowObjJson.machid,'dxip':currRowObjJson.dxip,'unip':currRowObjJson.unicomip,'cabinet':currRowObjJson.cabinet,'comproomid':currRowObjJson.comproomid},function(result){
					var rs = $.trim(result);
					if (rs > 0){
						$.messager.show({ // show error message
							title: 'Error',
							msg: '已成功删除主机！'
						});
						queryAllmachines_coll();
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
function loadCompRoom_coll (){
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
function checkFreeCabinet_coll (id) {
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

function checkFreeCabinet2_coll (comproomid) {
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

function loadCompRoom2_coll (){
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
