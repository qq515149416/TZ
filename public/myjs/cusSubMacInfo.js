//currCusOfMaid2根据加载顺序需要，必须要放在loadBusDataGrid之前.
var currCusOfMaid2 = undefined;
$(document).ready(function() {
	//clickTabToLoad();
	loadBusDataGrid();
	initCheckinghosting();
	initCheckingRent();
	loadCompRoomByOneMac();//获取机房
	//定时50分钟刷新当前客户主机数据列表
	setInterval(reloadMyCurrCusData,3000000);
});


//初始化业务数据表格与表格的按钮事件
function loadBusDataGrid () {
	//表头
	var dataFiles = ["proNum","macnum","businesstypeid","dk","fh","renprice","dxip","unicomip","comproomname","cabinet","renbegintime","renendtime","rensc","sjdate","lssc","biztype","macxjstatus","paystatus","testtype","cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproomid"]];
	//行内按钮
	var clickbutton = {"bizType":"mac","aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white,goOnRenewal-续费-goOnRenewal-white,payBizMac-付款-payBizMac-white,updateCusMacNote-备注修改-updateCusMacNote-white,updateMacxjstatus-下架-openXJMacWindow-white,changRes-更换-changRes-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
	//var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,ipMan-IP管理-ipMan-rosy,openXJMacWindow-下架-openXJMacWindow-rosy,changRes-更换-changRes-rosy,macResoucesMan-资源管理-macResoucesMan"};
	if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 26) {
		//业务管理员在添加机器时，管理员直接添加到客户原来所属的业务员名下
		currCusOfMaid2 = currCusOfMaid;
		if (currGroupid == 26) {
			clickbutton = {"bizType":"mac","aMethod":"queryMacInfo-查看-queryMacInfo-white,updateInfo-直接修改-updateInfo-white,updateMacxjstatus-下架-openXJMacWindow-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
		}
	} else if (deptid == 3) {
		//财务只能查看机器信息
		clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
	} else {
		currCusOfMaid2 = undefined;
	}
	//格式化字段
	var formatFileds = {"testtype":"0-测试机,1-正式机","biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费","businesstypeid":"0-其他,1-IDC普通业务,2-IDC高防,3-大带宽,4-15cdn,5-云计算"};
	//分页配置
	var pageEvent = {"action":"/customerMan/loadCusMacs.action?cusid="+currClickCusid};
	var showTableId = "#busDataid";
	$("#busDataFootid").show();
	$("#cabinetMacListsid").hide();
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//重载客户主机数据表
function reloadMyCurrCusData () {
	var ipval = $.trim($("#searchIpValid").val());
	var macnumval = $.trim($("#searchMacnumValid").val());
	var url = "/customerMan/loadCusMacs.action";
	var currPage = $("#busDataid #currPage").html().substring(3,$("#busDataid #currPage").html().length-1);
	var params = {"cusid":currClickCusid,"currPage":currPage,"ipval":ipval,"macnumval":macnumval};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["proNum","macnum","businesstypeid","dk","fh","renprice","dxip","unicomip","comproomname","cabinet","renbegintime","renendtime","rensc","sjdate","lssc","biztype","macxjstatus","paystatus","testtype","cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproomid"]];
				//行内按钮
				/*var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white,goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac-rosy,updateCusMacNote-备注修改-updateCusMacNote-rosy,openXJMacWindow-下架-openXJMacWindow-rosy,changRes-更换-changRes-rosy,macResoucesMan-资源管理-macResoucesMan"};*/
				var clickbutton = {"bizType":"mac","aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white,goOnRenewal-续费-goOnRenewal-white,payBizMac-付款-payBizMac-white,updateCusMacNote-备注修改-updateCusMacNote-white,updateMacxjstatus-下架-openXJMacWindow-white,changRes-更换-changRes-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
				if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 26) {
					//业务管理员在添加机器时，直接添加到客户原来所属的业务员名下
					currCusOfMaid2 = currCusOfMaid;
					if (currGroupid == 26) {
						clickbutton = {"bizType":"mac","aMethod":"queryMacInfo-查看-queryMacInfo-white,updateInfo-直接修改-updateInfo-white,updateMacxjstatus-下架-openXJMacWindow-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
					}
				} else {
					currCusOfMaid2 = undefined;
				}
				//格式化字段
				var formatFileds = {"testtype":"0-测试机,1-正式机","biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费","businesstypeid":"0-其他,1-IDC普通业务,2-IDC高防,3-大带宽,4-15cdn,5-云计算"};
				//分页配置
				var pageEvent = {"action":"/customerMan/loadCusMacs.action?cusid="+currClickCusid+"&ipval="+ipval+"&macnumval="+macnumval};
				var showTableId = "#busDataid";
				$("#busDataFootid").show();
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//加载当前客户租用机器审核中的数据表格与表格的按钮事件
function initCheckingRent () {
	var url = "/customerMan/queryCheckingMac.action";
	var params = {"biztype":"rent","cusid":currClickCusid,"pageSize":3};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				var showTableId = "#rentCheckingid";
				if (result.total == 0) {
					$(showTableId).hide();
					return;
				} else {
					$(showTableId).show();
				}
				//表头
				var dataFiles = ["macnum","cpu","memory","harddisk","mactype","cabinet","dxip","unicomip","macname","macpass","checkstatus",['machid']];
				//行内按钮
				var clickbutton = '';//{"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-升级-editCus-white"};//,
				//格式化字段
				var formatFileds = {"checkstatus":"3-租用审核中"};
				//分页配置
				var loadurl = "/customerMan/queryCheckingMac.action?pageSize=3&biztype=rent&cusid="+currClickCusid;
				var pageEvent = {"action":loadurl}; //加载数据,必须返回json数据.
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,3,formatFileds);
			}
		}
		
	});
}

//加载当前客户托管机器审核中的数据表格与表格的按钮事件
function initCheckinghosting () {
	var url = "/customerMan/queryCheckingMac.action";
	var params = {"biztype":"hosting","cusid":currClickCusid,"pageSize":3};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				var showTableId = "#hostingCheckingid";
				if (result.total == 0) {
					$(showTableId).hide();
					return;
				} else {
					$(showTableId).show();
				}
				//表头
				var dataFiles = ["macnum","cpu","memory","harddisk","mactype","cabinet","dxip","unicomip","checkstatus",['machid']];
				//行内按钮
				var clickbutton = '';//{"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-升级-editCus-white"};//,
				//格式化字段
				var formatFileds = {"checkstatus":"3-托管审核中"};
				//分页配置
				var loadurl = "/customerMan/queryCheckingMac.action?pageSize=3&biztype=hosting&cusid="+currClickCusid;
				var pageEvent = {"action":loadurl}; //加载数据,必须返回json数据.
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,3,formatFileds);
			}
		}
	});
}


//随机获取一条主机供业务员选择
//busIpType,标识当前添加业务主机的类型.
//var busIpType = undefined;
function getpassMacidOfCusPage (searchOneMacLike) {
	$("#oneMacToGetPassDivid").show();
	$("#searchDivid").show();
	$("#collMacList").hide();
	
	var param = "";
	if (searchOneMacLike) {
		var inputVal = $("#inputSearchOneMacid").val();
		var inputRoomVal = $("#inputSearchOneMacRoomid").val();
		param = {"inputVal":inputVal,"comproomid":inputRoomVal};
	}
	var url = "/customerMan/queryOneMacOfCuspage.action";
	$.post(url,param,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			var createDataGridJsonRows = JSON.parse(rs);
			//表头
			var dataFiles = ["macnum","cpu","memory","harddisk","mactype","comproomname","cabinet","dxip","unicomip","used",['machid',"comproom"]];
			//行内按钮
			var clickbutton = {"aMethod":"getPasswordMsc-获取密码-getPasswordMscOfCusPage"};
			//格式化字段
			var formatFileds = {"used":"0-未使用,1-已经使用"};
			//分页配置
			var loadurl = "";//"/customerMan/queryCheckingMac.action?pageSize=3&biztype=rent&cusid="+currClickCusid;
			var pageEvent = "";//{"action":loadurl}; //加载数据,必须返回json数据.
			var showTableId = "#getOneMacid";
			createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,1,formatFileds);
		}
  	});
}

//封装函数作为事件参数传递
function handerDX () {
	checIPExit("dxip","#dxipid");
}
function handerUN () {
	checIPExit("unip","#unicomipid");
}
function handerMacnum () {
	checkMacnum("#macnumid");
}


//删除客户到回收站
function destroyCus(){
	var str = '确定要把客户【'+custmoerName+'】移至回收站吗？';
	//cusid,在jquery的回调方法中，一定要声明一个变量去赋值全局变量，否则无法获取值。
	var cusid = currClickCusid;
	var url2 = '/customerMan/checkCusInBus.action';
	var params = {"cusid":cusid,"macxjstatus":3};
	$.post(url2,params,function(result){
		var rs = $.trim(result);
		if (rs > 0){
			$.messager.show({ // show error message
				title: '提示',
				msg: '该用户仍有主机使用中，不能删除！'
			});
			return false;
		} else {
			$.messager.confirm('Confirm',str,function(r){
				if (r){
					var url = '/customerMan/deleteCustomer.action?cusid='+currClickCusid;
					$.post(url,"",function(result){
						var rs = $.trim(result);
						if (rs > 0){
							queryMycustomer();
						} else {
							$.messager.show({ // show error message
								title: 'Error',
								msg: '删除用户失败，请联系管理员！'
							});
						}
					});
				}
			});
		}
	});
}

//恢复客户的登录密码为123456
function restorePass () {
	var str = '确定恢复客户【'+custmoerName+'】的登录密码为初始密码吗？';
	var cusid = currClickCusid;
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			url = '/customerMan/updateCustomerPass.action?cusid='+cusid;
			$.post(url,"",function(result){
				var rs = $.trim(result);
				if (rs > 0){
					//queryMycustomer();
					$.messager.show({ // show error message
						title: 'success',
						msg: '已经成功为客户恢复登录密码为123456'
					});
				} else {
					$.messager.show({ // show error message
						title: 'Error',
						msg: '恢复初始密码失败，请联系管理员！'
					});
				}
			});
		}
	});
}

//--------工具栏功能---------------

//通过查询IP(包括子IP)去查询当前业务员的客户主机.
function searchMacOfAllIps () {
	var ipval = $.trim($("#searchIpValid").val());
	var macnumval = $.trim($("#searchMacnumValid").val());
	if (!ipval && !macnumval ) {
		$.messager.show({ // show error message
			title: '提示',
			msg: '请输入要查询的IP或机器编号'
		});
		return;
	}
	var url = "/customerMan/searchMacOfAllIps.action";
	var params = {"cusid":currClickCusid,"searchIpValid":ipval,"macnumval":macnumval};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头              
				var dataFiles = ["proNum","macnum","businesstypeid","dk","fh","renprice","dxip","unicomip","comproomname","cabinet","renbegintime","renendtime","rensc","sjdate","lssc","biztype","macxjstatus","paystatus","testtype","cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproomid"]];
				//var dataFiles = ["macnum","dk","fh","renprice","dxip","unicomip","cabinet","renbegintime","renendtime","rensc","biztype","macxjstatus","paystatus","cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename"]];
				//行内按钮
				var clickbutton = {"bizType":"mac","aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white,goOnRenewal-续费-goOnRenewal-white,payBizMac-付款-payBizMac-white,updateCusMacNote-备注修改-updateCusMacNote-white,updateMacxjstatus-下架-openXJMacWindow-white,changRes-更换-changRes-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
				if (currGroupid == 26) {
					clickbutton = {"bizType":"mac","aMethod":"queryMacInfo-查看-queryMacInfo-white,updateInfo-直接修改-updateInfo-white,updateMacxjstatus-下架-openXJMacWindow-white,macResoucesMan-资源管理-macResoucesMan-white-haveres"};
				}
				//格式化字段
				var formatFileds = {"testtype":"0-测试机,1-正式机","biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费","businesstypeid":"0-其他,1-IDC普通业务,2-IDC高防,3-大带宽,4-15cdn,5-云计算"};
				//分页配置
				var pageEvent = "";
				var showTableId = "#busDataid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
				$("#busDataFootid").hide();
			}
		}
  	});
}

//查看主机信息
function queryMacInfo () {
	if (currRowObjJson) {
		var params = {"macnum":currRowObjJson.macnum,"biztype":currRowObjJson.biztype,"id":currRowObjJson.id};
		url = '/customerserv/queryMacInfo.action';
		$.post(url,params,function(result){
			//afterLoadUI("#macInfoDivId",result);
			$("#macInfoDivId").html(result);
    		//$('#openWindowInfo').dialog('open').dialog('setTitle','主机信息');
    		openwin('#openWindowInfo','300px','550px','主机信息');
  		});
	}
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

//弹出修改客户主机业务信息窗口,可修改并且要跑流程审核的四个元素，记录原值做对比。
var yfh = "";
var ydk = "";
var yrenbegintime = "";
var yrenendtime = "";
var ycpu = "";
var ymemory = "";
var yharddisk = "";
var yrenprice = "";
function updateCusMacInfo () {
	if (currRowObjJson) {
		var sl=$("#ufhid");
		var ops=sl.find("option");
		ops.eq(0).val(currRowObjJson.fh).text(currRowObjJson.fh).prop("selected",true);
		//if (currRowObjJson.paystatus == 0) {
			//$.messager.alert("提示","请先付款机器才能做升级操作");
			//return;
		//}
		var attrs = undefined;
		//赋值服务器服务项目数据
		$('#editfm').form('load',currRowObjJson);
		$("#addpriceid").val("0");
		//判断如果为托管服务器的，则不能修改硬盘内存cpu
		if (currRowObjJson.biztype == 0) {
			$("#cpudivid").hide();
			$("#memorydivid").hide();
			$("#ucpuIdMes2").hide();
			$("#umemoryIdMes2").hide();
			$("#harddiskdivid").hide();
			//组织清空提示的参数
			attrs = new Array("ufhid","udkId","urenbegintimeid","urenendtimeid","addpriceid","unewrpriceid");
		} else {
			$("#cpudivid").show();
			$("#memorydivid").show();
			$("#ucpuIdMes2").show();
			$("#umemoryIdMes2").show();
			$("#harddiskdivid").show();
			//获取并且赋值服务器硬件配置
			var params = {"macnum":currRowObjJson.macnum,"biztype":currRowObjJson.biztype,"id":currRowObjJson.id,"json":"json"};
			url = '/customerserv/queryMacInfo.action';
			var rs = queryInfo(url,params,"硬件配置获取失败，请联系管理员");
			ycpu = rs.cpu;
			ymemory = rs.memory;
			yharddisk = rs.harddisk;
			$("#uharddiskId").val(yharddisk);
			$("#ucpuId").val(ycpu);
			$("#umemoryId").val(ymemory);
			//组织清空提示的参数
			attrs = new Array("ufhid","udkId","urenbegintimeid","urenendtimeid","addpriceid","unewrpriceid","ucpuId","umemoryId","uharddiskId");
		}
		yfh = $("#ufhid").val();
		ydk = $("#udkId").val();
		yrenprice = $("#urpriceid").val();
		yrenbegintime = $("#urenbegintimeid").val();
		yrenendtime = $("#urenendtimeid").val();
		$('#ubizNoteid').val(mydecode(mydecode(currRowObjJson.cbNote)));
		
		//清空提示
		checkAttrs (attrs,true);
		$('#editCusMac').dialog('open').dialog('setTitle','服务器备注修改');
	}
}


//提交修改信息
function saveMacBiz () {
	var fh = $("#ufhid").val();
	var dk = $("#udkId").val();
	var renbegintime = $("#urenbegintimeid").val();
	var renendtime = $("#urenendtimeid").val();
	var addprice = $("#addpriceid").val();
	var renprice = $("#unewrpriceid").val();
	var bizNote = $("#ubizNoteid").val();
	var unewrprice = $("#unewrpriceid").val();
	var cpu = $("#ucpuId").val();
	var memory = $("#umemoryId").val();
	var harddisk = $("#uharddiskId").val();
	var id = $("#sid").val();
	var attrs = undefined;
	
	//非空验证
	if (currRowObjJson.biztype == 1) {
		attrs = new Array("ufhid","udkId","urenbegintimeid","urenendtimeid","addpriceid","unewrpriceid","ucpuId","umemoryId","uharddiskId");
	} else {
		attrs = new Array("ufhid","udkId","urenbegintimeid","urenendtimeid","addpriceid","unewrpriceid");
	}
	var checkrs = checkAttrs (attrs);
	if (!checkrs) {
		return;
	}
	
	//控制提交
	if (addprice == 0 && yrenprice == renprice && yfh == fh && ydk == dk && yrenbegintime == renbegintime && yrenendtime == renendtime && ycpu == cpu && ymemory == memory && harddisk == yharddisk) {
			//如果点击提交检测到数据全部没有做过修改，并且如果补扣费用也为0，那么就是做修改备注操作.
			//当id为0的时候，也会返回false，所以要加上此条件.
			if (id || id == 0) {
				var str = "修改备注信息操作，确定？";
				$.messager.confirm('Confirm',str,function(r){
					if (r){
						var url = "/customerMan/updateBizInfo.action";
						var params = {"id":id,"note":bizNote};
						queryInfo (url,params,"编写备注失败，请联系管理员");
						$('#editCusMac').dialog('close');
				    	if(danjiZhenggui=='-1'){
				    		//单机中的机器列表
				    		reloadMyCurrCusData(currRowObjJson.customerid);
				    	}else {
				    		//整柜中的机器列表
				    		reloadMacOfCabData();
				    	}
					}
				})
			} else {
				myMesShow("提 示","业务单信息获取异常，请联系管理员");
			}
			return;
	}
	//修改价格
	if (addprice == 0 && yrenprice != renprice && yfh == fh && ydk == dk && yrenbegintime == renbegintime && yrenendtime == renendtime && ycpu == cpu && ymemory == memory && harddisk == yharddisk) {
		 myMesShow("提 示","你是在修改单价，请到续费功能处进行修改");
		return;
	}
	if (addprice && !bizNote) {
		myMesShow("提 示","你在进行其他项目扣款，请必须备注");
		return;
	}
	
	//付费前计算额度
	var payTotal = parseFloat(addprice);
	var canPayTotal = parseFloat(currRowObjJson.accbal) + parseFloat(currRowObjJson.creded);
	if (payTotal > canPayTotal) {
		$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
		return;
	}
	
	
	//组织标题
	var flowName = "服务器资源变更";
	if (ydk != dk) {
		flowName += "（含带宽）";
	}
	//组织提示文字
	if (currRowObjJson){
		var str = '编号[' + currRowObjJson.macnum + ']的主机申请变更如下：</br>';
		if (fh != yfh) {
			str += "</br>【防护" + yfh + " 改为：" + fh + "】";
		}
		if (dk != ydk) {
			str += "</br>【带宽" + ydk + " 改为：" + dk + "】";
		}
		if (renbegintime != yrenbegintime) {
			str += "</br>【上架时间 " + yrenbegintime + " 改为：" + renbegintime + "】";
		}
		if (renendtime != yrenendtime) {
			str += "</br>【下架时间 " + yrenendtime + " 改为：" + renendtime + "】";
		}
		if (unewrprice != currRowObjJson.renprice) {
			str += "</br>【月租单价 " + currRowObjJson.renprice + " 改为：" + unewrprice + "】";
		}
		if (currRowObjJson.biztype == 1) {
			if (memory != ymemory ) {
				str += "</br>【内存 " + ymemory + " 改为：" + memory + "】";
			}
			if (cpu != ycpu) {
				str += "</br>【CPU " + ycpu + " 改为：" + cpu + "】";
			}
			if (harddisk != yharddisk) {
				str += "</br>【硬盘 " + yharddisk + " 改为：" + harddisk + "】";
			}
		}
		
		str += "</br><span style='color:red'>付款差额：(" + addprice + "元) <span>" + ", 确定？</br>";
		var cusid = currRowObjJson.customerid;
		var unip = currRowObjJson.unicomip;
		var dxip = currRowObjJson.dxip;
		var renpayid = currRowObjJson.renpayid;
		var macnum = currRowObjJson.macnum;
		var maid = currRowObjJson.maid;
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var parmas = {"id":id,"cusid":cusid,"unip":unip,"dxip":dxip,"fh":fh,"dk":dk,"renbegintime":renbegintime,
							  "renendtime":renendtime,"addprice":addprice,"renprice":renprice,"note":bizNote,"flowName":flowName,
							  "yfh":yfh,"ydk":ydk,"yrenbegintime":yrenbegintime,"yrenendtime":yrenendtime,"macnum":macnum,"unewrprice":unewrprice,
							  "renpayid":renpayid,"memory":memory,"ymemory":ymemory,"cpu":cpu,"ycpu":ycpu,"harddisk":harddisk,"yharddisk":yharddisk,
							  "maid":maid
							 } 
				var url = "/customerMan/updateCusBiz.action";
				$.post(url,parmas,function(result){
		    		var rs = $.trim(result);
		    		$('#editCusMac').dialog('close');
		    		reloadMyCurrCusData(currRowObjJson.customerid);
		    		if (rs > 0 ) {
		    			myMesShow("提示","申请成功，等待上一级审核");
		    		}
		    		//look(cusid);
		  		});
			}
		});
	} else {
		myMesShow("异 常","数据获取异常，请联系管理员");
	}
}


//主机业务下架
function updateMacxjstatus () {
		
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus == 1) {
			var mes = "编号["+currRowObjJson.macnum+"]的主机已经申请下架!";
			$.messager.alert("提示",mes);
			return;
		}
		
		var reason = dotran($("#xjMacreasonsid").val());
		if(!reason){
			checkImgShow("#reasonMes",-1,'必填');
			return;
		}else{
			checkImgShow("#reasonMes",2);
		}
	
		var str = '确定要把主机编号为【'+currRowObjJson.macnum+'】的下架吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				
				var shelvesOperatorId = currMasterid;
				var url = "/customerMan/updateMacxjstatus.action";
				var parmas  = {"id":currRowObjJson.id,"macxjstatus":"1","reason":reason,"shelvesOperatorId":shelvesOperatorId};
				$.post(url,parmas,function(result){
		    		var rs = $.trim(result);
		    		$("#xjMacWindow").dialog('close');
		    		$("#reason").val('');
		    		if (rs > 0) {
		    			$.messager.show({
							title: '提示',
							msg: '已经把下架信息提交到客服处理......'
						});
		    			reloadMyCurrCusData(currRowObjJson.customerid);
		    			var cabinet=$("#cabid").val();
		    			var comproom = $("#cdComproomid").val();
		    			if(!cabinet=='' && !comproom==''){
		    				reloadMacOfCabData();
		    			}
		    		} else {
		    			$.messager.show({
							title: 'Error',
							msg: '下架失败，请联系管理员！'
						});
		    		}
		    		//$.parent.$('#bgmainuiid')().layout('expand','east');
		  		});
			}
		});
	}
}

//弹出提问输入窗口
function askQuestion () {
	var temp = checkAskQuestion();
	if( temp == "true"){
		$.messager.show({
			title: '提示',
			msg: '此机器已有工单正在处理...'
		});
		return;
	}
	if (currRowObjJson) {
		dropDownList();
		$("#webEditMacnumId").html("当前主机编号["+currRowObjJson.macnum+"]");
		$('#qestionWindow').dialog('open').dialog('setTitle','编辑客户主机业务信息');
	}
}


//把json数组转换为js数组
function getArrayFromJson (arrjson) {
	var arr = [];
	for (var i = 0 ; i < arrjson.length ; i++) {
		arr[i] = arrjson[i].ip;
	}
	return arr;
}


//弹出IP管理窗口
//var businessid = undefined;
var dxipFormat = undefined;
var unipFormat = undefined;

function ipMan () {
	if (currRowObjJson) {
		dxipFormat = currRowObjJson.dxip;
		unipFormat = currRowObjJson.unicomip;
		$('#ipmanDivid').dialog('open').dialog('setTitle','IP管理');
		$("#ipmacnumspid").html(currRowObjJson.macnum);
		$("#unipShowSpanid").html(unipFormat);
		$("#dxipShowSpanid").html(dxipFormat);
		$("#ipcustruenameid").html(currRowObjJson.custruename);
		$("#ipcusnameid").html(currRowObjJson.cusname);
		//businessid = currRowObjJson.id;
		searchIp("unicomip",currRowObjJson.id);
		searchIp("dxip",currRowObjJson.id);
		loadIps("unicomip");
		loadIps("dxip");
	}
}


//删除客户子IP
function delSubIp (iptype) {
	var ip = undefined;
	if (iptype) {
		if (iptype == "dxip") {
			ip = $('#deldxipid').combobox('getValue');
			
		} else if (iptype == "unicomip")  {
			ip = $('#delunipid').combobox('getValue');
		}
		if (!ip) {
			return;
		}
		var str = '确定要删除客户的IP【'+ip+'】吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerMan/delSubIp.action";
				var params = {"busid":currRowObjJson.id,"iptype":iptype,"ip":ip};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					if (rs > 0) {
						if (iptype == "dxip") {
							$('#deldxipid').combobox('setValue','');
							searchIp("dxip",currRowObjJson.id);
							loadIps("dxip");
							
						} else if (iptype == "unicomip")  {
							$('#delunipid').combobox('setValue','');
							searchIp("unicomip",currRowObjJson.id);
							loadIps("unicomip");
						}
					}
		  		});
				reloadMyCurrCusData();
				reloadMacOfCabData();
			}
		});
	}
}

//展示现有IP，以及加载现有IP到可删除IP的下拉框中，以便直接选择删除IP
function searchIp (iptype,busid) {
	var url = "/customerMan/searchunIp.action";	
	if (iptype == "dxip") {
		url = "/customerMan/searchdxIp.action";
	} else {
		iptype = "unicomip";
	}
	var params = {"busid":busid,"iptype":iptype};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs) {
			if (iptype == "dxip") {
				$("#dxippid").html(rs);
				$("#deldxipid").combobox('loadData',dxipjsondata);
				
			} else if (iptype == "unicomip"){
				$("#unippid").html(rs);
				$("#delunipid").combobox('loadData',unipjsondata);
			}
		}
  	});
}

//dxipsCom,unipsCom存放ip管理中下拉框的所有值。
var dxipsCom = undefined;
var unipsCom = undefined;
//加载IP库的IP，供业务员选择
function loadIps (iptype) {
	var url = "";
	var params = "";
	if (iptype == "dxip") {
		url = "/customerMan/loadDxIps.action";
		params = {"dxipFormat":dxipFormat,"cusid":currClickCusid};
		
	} else if (iptype == "unicomip") {
		url = "/customerMan/loadUnIps.action"
		params = {"unipFormat":unipFormat};
	}
	
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = eval(rs);
		if (rs) {
			if (iptype == "dxip") {
				dxipsCom = jsondata;
				$("#adddxipid").combobox('loadData',jsondata);
				//机柜资源管理
				$("#resadddxipid").combobox('loadData',jsondata);
				//单机资源管理
				$("#macResadddxipid").combobox('loadData',jsondata);
			} else if (iptype == "unicomip"){
				unipsCom = jsondata;
				$("#addunicomipid").combobox('loadData',jsondata);
				//机柜资源管理
				$("#resddunicomipid").combobox('loadData',jsondata);
				//单机资源管理
				$("#macResddunicomipid").combobox('loadData',jsondata);
			}
		}
  	});
}

//添加电信子IP
function addDxSubIp() {
	
	if (currRowObjJson) {
		var ip = $('#adddxipid').combobox('getValue');
		var falgInput = undefined;
		for (var i = 0 ; i < dxipsCom.length ; i++) {
			if (ip == dxipsCom[i]["ip"]) {
				falgInput = true;
				break;
			}
		}
		if (!falgInput) {
			$.messager.alert("提示","无效电信IP!");
			return;
		}
		if (currRowObjJson && ip) {
			var busid = currRowObjJson.id;
			var url = "/customerMan/addIp.action";
			var params = {"ip":ip,"iptype":"dxip","busid":busid};
			$.post(url,params,function(result){
				var rs = $.trim(result);
					if (rs > 0) {
					$('#adddxipid').combobox('setValue','');
					searchIp("dxip",currRowObjJson.id);
					loadIps("dxip");
				}
	  		});
		}
	}
	reloadMyCurrCusData();
	reloadMacOfCabData();
}


//添加联通子IP
function addUnSubIp() {
	if (currRowObjJson) {
		var ip = $('#addunicomipid').combobox('getValue');
		var falgInput = undefined;
		for (var i = 0 ; i < unipsCom.length ; i++) {
			if (ip == unipsCom[i]["ip"]) {
				falgInput = true;
				break;
			}
		}
		if (!falgInput) {
			$.messager.alert("提示","无效联通IP!");
			return;
		}
		if (currRowObjJson && ip) {
			var busid = currRowObjJson.id;
			var url = "/customerMan/addIp.action";
			var params = {"ip":ip,"iptype":"unicomip","busid":busid};
			$.post(url,params,function(result){
				rs = $.trim(result);
				if (rs > 0) {
					$('#addunicomipid').combobox('setValue','');
					searchIp("unicomip",currRowObjJson.id);
					loadIps ("unicomip");
				}
	  		});
			
		}
	}
	reloadMyCurrCusData();
	reloadMacOfCabData();
}

//已经下架机器
function shelvedMac () {
	//var arr = JSON.parse(macInfoForCusJson);
	var str = "<a href='javascript:void(0)' onclick='shelvedMac()'>已下架机器</a>";
	$("#toolbar").html(str);
	var arr=eval(macInfoForCusJson);
	//业务员姓名,id,登录名
	//var truename = arr.truename;
	//var masterid = arr.masterid
	//var name = arr.name;
	//客户姓名,id,登录名
	//var custruename = arr.custruename;
	//var cusname = arr.cusname;
	var customerid = arr.customerid;
	var url ="/customerMan/shelvedMac.action";
	var params = {"customerid":customerid,"macxjstatus":"3"};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			$("#subInfoForCusdgTId").datagrid("loadData",jsondata);
		}
		
  	});
}


//获取密码，选择租用主机
function getPasswordMscOfCusPage () {
	if (currRowObjJson) {
		loadCompRoom ();//获取机房
		//给机房下拉添加onChange事件
		$("#comproomids").combobox({
			 onChange: function (n,o) {
				 checkFreeCabinet ("#comproomids")
			 }
			 });
		$("#cpuid").hide();
		$("#memoryid").hide();
		$("#harddiskid").hide();
		$("#comproomids").combobox("setValue",mydecode(currRowObjJson.comproom));
		$("#comproomids").combobox("setText",mydecode(currRowObjJson.comproomname));
		$("#addcabinetid").combobox("setValue",mydecode(currRowObjJson.cabinet));
		$("#addcabinetid").combobox("setText",mydecode(currRowObjJson.cabinet));
		getPasswordMsc(currRowObjJson.macnum,currRowObjJson.cabinet,currRowObjJson.dxip,currRowObjJson.unicomip);
		$("#dxerrorsip").html("");
	    $("#unerrorsip").html("");
	    $("#macnumMes").html("");
	    
	    //去除IP输入的焦点事件
	    removeEvnent("unicomipid",handerUN);
		removeEvnent("dxipid",handerDX);
		removeEvnent("macnumid",handerMacnum);
		
	}
}

//添加托管主机
/*function addHostingOfcusPage () {
	//清空上柜日期
	$("#beginTimeid").datebox("setValue",'');
	$("#formTypeid").val('hosting');
	$("#cpuid").show();
	$("#memoryid").show();
	$("#harddiskid").show();
	$('#macnumid').val("");
	$('#comproomids').val("");
	$('#addcabinetid').val("");
	$('#unicomipid').val("")
	$('#dxipid').val("")
	
	//去掉租用部门的内容.
	$("#oneMacToGetPassDivid").hide();
	$("#searchDivid").hide();
	
	//添加IP输入的焦点事件
	addEvent("dxipid",handerDX);
	addEvent("unicomipid",handerUN);
	addEvent("macnumid",handerMacnum);
	loadCompRoom ();//获取机房
	addhostingmac();
}*/

function addHostingOfcusPage(){
	//去掉租用部门的内容.
	$("#oneMacToGetPassDivid").hide();
	$("#searchDivid").hide();
	if($("#collMacList").is(":hidden")){
		$("#collMacList").show();
	}else{
		$("#collMacList").hide();
	}
	var cusname = $("#nameid").html();
	var param = {"cusname":cusname};
	var url = "/customerMan/queryCollMacWithoutActive.action";
	$.ajax({
		url:url,
		async:false,
		cache:false,
		data:param,
		dataType:'json',
		success:function(result){
			var createDataGridJsonRows = result;
			var dataFiles = ["macnum","cpu","memory","harddisk","mactype","comproom","cabinet",['machid','comproomid']];
			var clickbutton = {"aMethod":"collMacActive-上架-collMacActive"};
			var formatFileds = "";//{"status":"0-未使用,1-已经使用"};
			//分页配置
			var loadurl = "/customerMan/queryCollMacWithoutActive.action?cusname="+cusname;
			var pageEvent = {"action":loadurl}; //加载数据,必须返回json数据.
			var showTableId = "#collMacList";
			createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,1,formatFileds);
		}
	});
}

//托管机器上架
function collMacActive(){
	//清空上柜日期
	$("#beginTimeid").datebox("setValue",'');
	$("#formTypeid").val('hosting');
	$("#cpuid").show();
	$("#memoryid").show();
	$("#harddiskid").show();
	$('#macnumid').val("");
	$('#comproomids').val("");
	$('#addcabinetid').val("");
	$('#unicomipid').val("")
	$('#dxipid').val("")
	$("#bt").html("");
	getbusinessTypes ();
	//去掉租用部门的内容.
	$("#oneMacToGetPassDivid").hide();
	$("#searchDivid").hide();
	
	//去掉正式测试
	$("#test-types").hide();
	//添加IP输入的焦点事件
	addEvent("dxipid",handerDX);
	addEvent("unicomipid",handerUN);
	//addEvent("macnumid",handerMacnum);
	loadCompRoom ();//获取机房
	addhostingmac(currRowObjJson);
}

//续费
var rprice = undefined;
//currbizPayStatus记录当前业务单的付款状态，当业务单处理未付款状态时，不能再继续续费，只能修改价格。
var currbizPayStatus = undefined;
function goOnRenewal() {
	if (currRowObjJson) {
		
		currbizPayStatus = currRowObjJson.paystatus;
		$('#goOnRenewalid').dialog('open').dialog('setTitle','续 费');
		$("#rCusTrueNameid").html(currRowObjJson.custruename);
		$("#rmacnumid").val(currRowObjJson.macnum);
		$("#rrenscid").val(currRowObjJson.rensc);
		$("#rpriceid").val(currRowObjJson.renprice);
		rprice = currRowObjJson.renprice;
		$("#rrenbegintimeid").val(currRowObjJson.renbegintime);
		$("#rrenendtimeid").val(currRowObjJson.renendtime);
		$("#bizid").val(currRowObjJson.id);
		$("#rcusid").val(currRowObjJson.customerid);
		
	}
}

//动态显示价格
function formatPrice (value) {
	var rpriceid = $("#rpriceid").val();
	if (rpriceid) {
		return value+"月"+(rpriceid*value)+" 元";
	}
}

//提交续费
function subRenewal () {
	var addsc = $('#addrenscid').slider('getValue');
	var newPrice = $("#rpriceid").val();
	//如果当前业务单在未付款的情况下，不能继续操作续费功能
	if (currbizPayStatus == 0 ) {
		$.messager.alert("提示","当前为未付款状态，不能操作续费，请先操作付款当前机器");
		return;
	}
	//如果没有修改价格，也没有选择续费时长，则做出提示，方法停止。
	if ((!oldpriceVal && addsc == 0) || (oldpriceVal==newPrice && addsc == 0)) {
		$.messager.alert("提示","请修改价格或者续费！");
		return;
	}
	var str = '确定要续费编号为【'+$("#rmacnumid").val()+'】的主机吗？';
	if (addsc == 0) {
		str = '确定要修改编号为【'+$("#rmacnumid").val()+'】的价格吗？';
	}
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var renbegintime = $("#rrenendtimeid").val();
			var bizid = $("#bizid").val();
			var url = "/customerMan/subRenewal.action";
			var renprice = $("#rpriceid").val();
			var rnote = $("#rnoteid").val();
			rnote = $.trim(rnote);
			var rmacnum = $("#rmacnumid").val();
			var params = {"addsc":addsc,"begintime":renbegintime,"bizid":bizid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"rmacnum":rmacnum,"renpayid":currRowObjJson.renpayid,"payproject":3};
			//payTot 目前续费总共要支付的费用
			var payTot = undefined;
			//如果点击过修改价格，则要跑审核流程；否则就直接续费
			if (oldpriceVal) {
				if (renprice != oldpriceVal) {
					//确实修改价格,跑流程所需要的参与不同，所有要重新定义params.
					params = {"oldpriceVal":oldpriceVal,"addsc":addsc,"begintime":renbegintime,"bizid":bizid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"rmacnum":rmacnum,"goflow":"goflow","renpayid":currRowObjJson.renpayid};
					payTot = renprice * addsc;
					
				} else {
					//点击过修改价格后，又取消了，所以要记录原来的价格去计算
					payTot = oldpriceVal * addsc;
				}
			} else {
				payTot = renprice * addsc;
			}
			//余额加信用度不够支付
			var canPay = parseInt($("#balanceValid").val()) + parseInt($("#credeValid").val());
			if (payTot > canPay) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				$('#addrenscid').slider('setValue',0);
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
					$('#addrenscid').slider('setValue',0);
					$('#aupdatePriceid2').html('[修改价格]');
					$('#rpriceid').attr("disabled","disabled");
					$('#goOnRenewalid').dialog('close');
					//清空oldpriceVal值
					oldpriceVal=undefined;
					//刷新当前客户余额
					queryBalance();
					//刷新当前表的数据
					reloadMyCurrCusData();
					//reloadMyCurrCusData($("#rcusid").val());
					
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


//弹出充值窗口
function openToUp () {
	$('#toupdivid').dialog('open').dialog('setTitle','充值');
	$("#toupnameid").html(custmoerName);
	$("#moneyid").val("");
	$("#taxid").val(0);
	$("#taxMoneyid").html("0");
	$("#bankid").html("<option></option>"+
	"<option value='腾正公帐（建设银行）'>腾正公帐（建设银行）</option>"+
	"<option value='腾正公帐（工商银行）'>腾正公帐（工商银行）</option>"+
	"<option value='腾正公帐（招商银行）'>腾正公帐（招商银行）</option>"+
	"<option value='腾正公帐（农业银行）'>腾正公帐（农业银行）</option>"+
	"<option value='正易公帐（中国银行）'>正易公帐（中国银行）</option>"+
	"<option value='支付宝'>支付宝</option>"+
	"<option value='公帐支付宝'>公帐支付宝</option>"+
	"<option value='财付通'>财付通</option>"+
	"<option value='微信支付'>微信支付</option>");
	addEvent("moneyid",moneyMes);
	addEvent("taxid",moneyMes);
	$("#moneyMesid").html("");
}

//充值焦点事件
function moneyMes () {
	var moneyval = $("#moneyid").val();//充值金额
	var taxval = $("#taxid").val();//税额
	if(moneyval =='' ){
		moneyval = 0;
	}
	if( taxval == ''){
		taxval = 0;
		$("#taxid").val(0);
	}
	$("#moneyid").val(parseFloat(moneyval).toFixed(2)) ;
	$("#taxid").val(parseFloat(taxval).toFixed(2)) ;
	var taxmoney =  parseFloat(moneyval) + parseFloat(taxval);//到账金额
	$("#taxMoneyid").html(taxmoney.toFixed(2));
}

//查询账户信息
function queryBalance () {
	var url = "/customerMan/queryBalance.action";
	var params = {"cusid":currClickCusid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = JSON.parse(rs);
		if (rs) {
			cuaccount = jsondata.accbal;
			$("#balanceid").html(jsondata.accbal);
			$("#balanceValid").val(jsondata.accbal)
			$("#paytotalid").html(jsondata.paytotal);
			$("#paytotalValid").val(jsondata.paytotal)
		}
  	});
}

//提交充值
function subToUp () {
	var moneyval = $("#moneyid").val();
//	var bankval = $("input[name='bankrname']:checked").val();
	var bankval = $("#bankid").val();
	var noteval = $("#toupnoteid").val();
	var  tax = $("#taxid").val();//税额
	var  taxmoney = $("#taxMoneyid").html();//到账金额
	if (!moneyval) {
		$("#moneyMesid").html(" * 请输入充值金额");
	} else if (!bankval) {
		$("#bankMesid").html(" * 请选择银行");
	} else {
		var url = "/customerMan/payrecord.action";
		var custruename = $("#toupnameid").html();
		var params = {"menorys":moneyval,"bank":bankval,"custruename":custmoerName,"cusid":currClickCusid,"note":noteval,"tax":tax,"taxmoney":taxmoney,"deptid":currClickDeptid};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				$.messager.show({
					title: '提 示',
					msg: '操作成功,财务审核中'
				});
			} else {
				$.messager.show({
					title: 'Error',
					msg: '充值失败，请联系管理员!'
				});
			}
  		});
		$('#toupdivid').dialog('close');
	}
	
}


//打开添加租用机器编辑窗口
function getPasswordMsc (mannum,cabinet,dxip,unicomip) {
	var testMacOrNotid =$("#testMacOrNotid").val('');
	$("#test-types").show();
	$("#testMacOrNotMes").html("");
	$("#priceValid").val('');
	$('#macnumid').attr("readonly","readonly");
	$('#unicomipid').attr("readonly","readonly");
	$('#dxipid').attr("readonly","readonly");
	$('#cabinetid').attr("readonly","readonly");
	//$("#beginTimeid").datebox("setValue","");
	$("#beginTimeid").datebox("setValue",myDateformatter(new Date()));
	$("#cusbiztruenameid").html(custmoerName);
	$("#cusbiznameid").html($("#nameid").html());
	$("#macnumid").val(mannum);
	$("#cabinetid").val(cabinet);
	$("#dxipid").val(dxip);
	$("#unicomipid").val(unicomip);
	$("#popTitleid").html("主机租用");
	$("#bizTypeid").html("租 用");
	
	$('#cusmacbizid').dialog('open').dialog('setTitle','客户租用主机提交单');
	$("#bt").html("");
	getbusinessTypes ();
	url = '/customerMan/addCusMacBiz.action?pageSize=3&bizType=rent&cusid='+currClickCusid+"&currCusOfMaid="+currCusOfMaid2;
}

//打开添加托管机器编辑窗口
function addhostingmac (currRowObjJson) {
	//var testMacOrNotid =$("#testMacOrNotid").val('');
	$("#testMacOrNotid").val(1);
	$("#testMacOrNotMes").html("");
	//给编窗口添加当前时间
	$("#beginTimeid").datebox("setValue",myDateformatter(new Date()));
	//$('#macnumid').removeAttr("readonly");
	//获取已知的值
	$('#macnumid').val(mydecode(mydecode(currRowObjJson.macnum)));
	$('#macnumid').attr("readonly","readonly");
	
	$('#cpuidinput').val(mydecode(mydecode(currRowObjJson.cpu)));
	$('#memoryidinput').val(mydecode(mydecode(currRowObjJson.memory)));
	$('#harddiskidinput').val(mydecode(mydecode(currRowObjJson.harddisk)));
	
	
	
	
	$('#unicomipid').removeAttr("readonly")
	$('#dxipid').removeAttr("readonly")
	$('#cabinetid').removeAttr("readonly");
	//$("#macnumid").focus();
	$("#cusbiztruenameid").html(custmoerName);
	$("#cusbiznameid").html($("#nameid").html());
	$("#popTitleid").html("主机托管");
	$("#bizTypeid").html("托 管");
	//给机房下拉添加onChange事件
	
	
	$("#comproomids").combobox('select',currRowObjJson.comproomid);
	$("#comproomids").combobox('disable');
	 checkFreeCabinet ("#comproomids");
/*	$("#comproomids").combobox({
		 onChange: function (n,o) {
			 checkFreeCabinet ("#comproomids")
		 }
		 });*/
	$('#cusmacbizid').dialog('open').dialog('setTitle','客户托管主机提交单');
	//checkMacnum("#macnumid");
	url = '/customerMan/addCusMacBiz.action?pageSize=3&bizType=hosting&cusid='+currClickCusid+"&currCusOfMaid="+currCusOfMaid2;
	
}

//提交托管和租用的业务表单
function saveBiz() {
	var str = '确定提交客户【'+custmoerName+'】的新业务单吗？';
	//cusid,在jquery的回调方法中，一定要声明一个变量去赋值全局变量，否则无法获取值。
	var cusid = currClickCusid;
	var comproomid =$("#comproomids").combobox('getValue');
	var testMacOrNotid =$("#testMacOrNotid").val();
	var businesstypeid =$("#bt").val();
	var proNum =$("#proNumid").val();//产品编号
	$.messager.confirm('提交确认',str,function(r){
		var rensc = $("input[name=rensc]").val()
		if(rensc > 12 && rensc < 241){
			if(!confirm('确定时长 '+rensc + ' 个月')){
				return;
			}
		}else if(rensc >= 241){
			if(confirm('确定时长 '+rensc + ' 个月,SB是不是填错了！！！！')){
				alert('不好意思，因为这类sb太多，误伤到你。')
			}else{
				return;
			}
		}
		$("#getPassAId").html("客服审核中...");
		if(testMacOrNotid==''){
			$("#testMacOrNotMes").html("<font color='red'>请选则机器类型</font>");
			$("#testMacOrNotid").focus();
			return ;
		}else{
			$("#testMacOrNotMes").html("");
		}
		if(businesstypeid==''){
			$("#types").html("<font color='red'>请选择业务类型</font>");
			$("#bt").focus();
			return ;
		}else{
			$("#types").html("");
		}
		if (r){
			$('#cusmacbizfm').form('submit',{
				url: url+"&comproomid="+comproomid+"&testMacOrNotid="+testMacOrNotid+"&proNum="+proNum+"&bt="+businesstypeid,				
				onSubmit: function(){
					var comproom  = $("#comproomids").combobox('getValue');
					var ipvali1 = checkIpComproom("unip","#unicomipid",comproom);
					var ipvali2 = checkIpComproom("dxip","#dxipid",comproom);					
					//所有验证通过
					var rsvali = false;
					var vali1 = $(this).form('validate');
					if (vali1 == true && hadUnip == false && hadDxip == false && hadMacnum == false && ipvali1 == true && ipvali2 == true ) {
						rsvali = true;
					}
					return rsvali;
				},
				success: function(result){
					var rs = $.trim(result);
					if (rs > 0){
						if (url.indexOf("hosting") != -1 ) {
							//添加托管
							$('#cusmacbizfm').form('clear');
							$.messager.show({
								title: '提 示',
								msg: '已成功申请添加托管机器，待客服审核！'
							});
							initCheckinghosting();
							addHostingOfcusPage();
						} else if (url.indexOf("rent") != -1 ) {
							//添加租用
							$.messager.show({
								title: '提 示',
								msg: '已成功申请添加租用机器，待客服审核！'
							});
							initCheckingRent();
						}
						$('#cusmacbizid').dialog('close'); // close the dialog
						
					} else {
						$.messager.show({
							title: 'Error',
							msg: '主机库信息错误，请联系管理员！'
						});
					}
				}
			});
		}
	});
	//----进入用户界面后的业务提交,隐藏选择主机出租框-------
	//隐藏获取密码
	$("#oneMacToGetPassDivid").hide();
	//隐藏模糊查询 
	$("#searchDivid").hide();
}


//由业务人员付款机器
function payBizMac () {
	if (currRowObjJson) {
		if (currRowObjJson.paystatus == 0) {
			var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
			var canPayTotal = parseFloat(currRowObjJson.accbal) + parseFloat(currRowObjJson.creded);
			if (payTotal > canPayTotal) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				return;
			}
			var str = "编号:<span style='color:red;font-size:14px;'>" + currRowObjJson.macnum + "</span><br><br>" +
				"缴费总额:<span style='color:red;font-size:14px;'> " + payTotal +"元 </span><br><br>" +
				"<span style='margin-left:40px;'>确定为服务器进行付款吗？</span><br><br>";
			$.messager.confirm('Confirm',str,function(r){
				if (r){
					var url = "/customerMan/payMenoy.action";
					var params = {"cusid":currClickCusid,"payTotal":payTotal,"bizid":currRowObjJson.id,"renpayid":currRowObjJson.renpayid,"payproject":1,"testtype":currRowObjJson.testtype};
					$.post(url,params,function(result){
						var rs = $.trim(result);
						if (rs > 0) {
							//刷新当前客户余额
							queryBalance();
							//刷新当前表的数据
							reloadMyCurrCusData();
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
		} else {
			$.messager.alert("提示","此机器已付款！")
		}
	} 
}

//弹出更换资源窗口
function changRes () {
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus != 0) {
			$.messager.alert("提示","只有正常上架中的机器才能更换资源!");
		} else {
			$('#changeResDivid').dialog('open').dialog('setTitle','客户资源更换');
			loadTabContent();
		}
	}
}

//初始加载tab内容
function loadTabContent (url,param) {
	if (!param) {
		//tab样式
		var liid = "#changeIpid";
		$("#changResulid li").each (function(){
			$(this).removeClass("active");
		});
		$(liid).addClass("active");
		url = '/result/customerMan/changip.jsp';
		param = "";
	} 
	$.post(url,param,function(result){
		var rs = $.trim(result);
		$("#openContentid").html(rs);
		$("#cmacnumValid").val(currRowObjJson.macnum);
		$("#cdxipValid").val(currRowObjJson.dxip);
		$("#cunipValid").val(currRowObjJson.unicomip);
		$("#bzid").val(currRowObjJson.id);
		$("#biztype").val(currRowObjJson.biztype);
		$("#cdkid").val(currRowObjJson.dk);
		$("#cfhid").val(currRowObjJson.fh);
		$("#ccabinetid").val(currRowObjJson.cabinet);
		
	});
}

//IP更换
function openChange (checkStatu,liidparm) {
	if (checkStatu==2) {
		alert("期待开发中");
		return;
	}
	//改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#changResulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	
	//改变内容
	var url = '/result/customerMan/changip.jsp';
	var param = "";
	if (checkStatu == '2') {
		
	} else if (checkStatu == '3') {
		url = '/result/customerMan/changzy.jsp';
	}
	param = {"checkstatus":checkStatu};
	loadTabContent (url,param)
}

//综合部直接修改业务单信息
function updateInfo () {
	$('#updateBizInfo').dialog('open').dialog('setTitle','修改业务单信息');
	$("#updatebtid").html("");
	$("#uptadecpnum").val(currRowObjJson.proNum);
	//$("#updatebtid").val(currRowObjJson.businesstypeid);
	$("#updatedk").val(currRowObjJson.dk);
	$("#updatefh").val(currRowObjJson.fh);
	$("#updatedj").val(currRowObjJson.renprice);
	getbusinessIdTypes();
}

//提交修改
function subUpdateBizInfo () {
	var proNum=$("#uptadecpnum").val();
	var businesstypeid=$("#updatebtid").val();
	var dk = $("#updatedk").val();
	var fh = $("#updatefh").val();
	var renprice = $("#updatedj").val();
	var id = currRowObjJson.id;
	var url = "/customerMan/updateBizInfoByzh.action";
	if (!id) {
		$.messager.alert('Errors','错误代码：subUpdateBizInfo,获取业务单信息失败，请联系管理员');
		return;
	}
	if (!dk || !fh || !renprice) {
		$("#uErrorid").html('提示：输入框内容不能为空值.');
		return;
	} else {
		$("#uErrorid").html('');
	}
	var params = {"id":id,"dk":dk,"fh":fh,"renprice":renprice,"proNum":proNum,"businesstypeid":businesstypeid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$('#updateBizInfo').dialog('close');
			//刷新当前表的数据
			reloadMyCurrCusData();
			myMesShow ("提示","业务单信息修改成功");
		} else {
			$.messager.alert('Errors','错误代码：subUpdateBizInfo,业务单信息更新失败，请联系管理员');
			return;
		}
	});
}

function getbusinessIdTypes (){
	var url = '/customerMan/getbusinessTypes.action';
	var params = {};
	var rs = "";
	var hdaddcab=$("#updatebtid");
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {			
				for(var i = 1 ; i < result.length; i++){
					var key = result[i]["key"];
					var value =result[i]["value"];
					hdaddcab.append("<option id='id" + key + "' value='"+key+"'>"+value+"</option>");
				}
				hdaddcab.append("<option id='id" + result[0]["key"] + "' value='"+result[0]["key"]+"'>"+result[0]["value"]+"</option>");
				$("#id"+currRowObjJson.businesstypeid).attr("selected","true");
			}
		}
	});
}
//机器机柜tab列表
var danjiZhenggui ='-1';//用于区分单机整柜界面用
function tabChange2 (checkStatu,liidparm) {
	var rsjson="";
	var url="";
	var params="";
	var checkstatus = "";
	var blacklist = 0;
	//改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#tabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	
	//改变内容
	if (!checkStatu || checkStatu == '-1') {
		danjiZhenggui =checkStatu;
		$("#busDataid").show();
		$("#allMacInCab").hide();
		$("#collMacList").hide();
		$("#collCabMacList").hide();
	    loadBusDataGrid();
	    initCheckinghosting();
	    initCheckingRent();
	} else if(!checkStatu || checkStatu == '0'){
		danjiZhenggui =checkStatu;
		$("#cabinetMacListsid").show();
		$("#busDataid").hide();
		$("#allMacInCab").hide();
    	$("#oneMacToGetPassDivid").hide();
    	$("#collMacList").hide();
    	$("#collCabMacList").hide();
    	showtable = "#cabinetMacListsid";
  	  	url = "/customerMan/queryCabinetMacInfoForCus.action?cusid="+currClickCusid;
  	  	rsjson = queryInfo (url,params);
  	  	var confiditons = new Array();
		confiditons.push("checkstatus=" + checkstatus);
		confiditons.push("blacklist=" + blacklist);
  		showData(rsjson,showtable,confiditons);
	}
}


function maclook (cusidParam) {
	var params = {"cusid":cusidParam};
	url = '/customerMan/queryMacInfoForCus.action';
	$.post(url,params,function(result){
		afterLoadUI("#bgcenterid",result);
		MoveRunningDiv();
	});
}
function cabinetlook (cusidParam) {
	var params = {"cusid":cusidParam};
	url = "/customerMan/queryCabinetMacInfoForCus.action?cusid="+currClickCusid;
	$.post(url,params,function(result){
		afterLoadUI("#bgcenterid",result);
		MoveRunningDiv();
	});
}
//展示数据
function showData (data,showTableId,confiditons) {
	if (!data) {
		return;
	}
	// 表头
	var dataFiles = ["proNum","cabinetid","macnum","dxipcount","unipcount","comproomid","dk","fh","renprice","rensc","renbegintime", "renendtime","sjdate","lssc","macxjstatus","paystatus","note", [ "id","comproomname","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproom"] ];
	// 行内按钮
	var clickbutton = "";
	if (showTableId == "#cabinetMacListsid") {
		//updateCusCabInfo-升级-updateCusCabInfo-white,(先隐藏)
		//clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,goOnRenewalCab-续费-goOnRenewalCab,payBizCab-付款-payBizCab,updateCusCabInfo-备注修改-updateCusCabInfo-rosy,resourcesManage-资源管理-resourcesManage"};
		clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,updateCusCabInfo-备注修改-updateCusCabInfo-rosy,resourcesManage-资源管理-resourcesManage,openXjCabWindow-下架-openXjCabWindow-rosy"};
		 if (deptid == 2 ||deptid == 12||deptid == 13||deptid == 16) {
			//只有业务才能续费付款
			clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,goOnRenewalCab-续费-goOnRenewalCab,payBizCab-付款-payBizCab,updateCusCabInfo-备注修改-updateCusCabInfo-rosy,resourcesManage-资源管理-resourcesManage,openXjCabWindow-下架-openXjCabWindow-rosy"};
		}else if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 26 || currGroupid == 42 || currGroupid == 45) {
					//业务管理员在添加机器时，直接添加到客户原来所属的业务员名下
					currCusOfMaid2 = currCusOfMaid;
					if (currGroupid == 26) {
						clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,resourcesManage-资源管理-resourcesManage,updateResources-直接修改-updateResources,openXjCabWindow-下架-openXjCabWindow-rosy"};
						//clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,ipMan-IP管理-ipMan,updateInfo-直接修改-updateInfo,openXJMacWindow-下架-openXJMacWindow-rosy"};
					}
				} else {
					currCusOfMaid2 = undefined;
				}
	}
	// 格式化字段
	var formatFileds = {"addtype":"0-未使用,1-已使用","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州","paystatus":"0-未付款,1-已付款,2-过期未续费","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
	
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
	
	var url = "/customerMan/queryCabinetMacInfoForCus.action?cusid="+currClickCusid;
	var pageEvent = {"action":url};
	createDataGrid(showTableId, data, dataFiles, clickbutton,pageEvent, 10, formatFileds);
}

function searchCabOfAllid () {
	var ipval = $.trim($("#searchCabValid").val());
	if (!ipval) {
		$.messager.show({ // show error message
			title: '提示',
			msg: '请输入要查询的机柜编号或完整的机器IP'
		});
		return;
	}
	var url = "/customerMan/searchCabOfAllid.action";
	var params = {"cusid":currClickCusid,"searchCabValid":ipval};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头             
				//var dataFiles = [ "cabinetid","macnum","comproomname","rensc","renbegintime", "renendtime", "used", "note", [ "id,comproomid" ] ];
				var dataFiles = [ "proNum","cabinetid","macnum","dxipcount","unipcount","comproomid","dk","fh","renprice","rensc","renbegintime", "renendtime","sjdate","lssc","macxjstatus","paystatus","note", [ "id","comproomname","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproom"] ];
				//updateCusCabInfo-升级-updateCusCabInfo-white,(先隐藏)
				var clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,updateCusCabInfo-备注修改-updateCusCabInfo-rosy,resourcesManage-资源管理-resourcesManage,openXjCabWindow-下架-openXjCabWindow-rosy"};
				if (deptid == 2 || deptid ==12|| deptid ==16) {
					//只有业务才能续费付款
					clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,goOnRenewalCab-续费-goOnRenewalCab,payBizCab-付款-payBizCab,updateCusCabInfo-备注修改-updateCusCabInfo-rosy,resourcesManage-资源管理-resourcesManage,openXjCabWindow-下架-openXjCabWindow-rosy"};
				}else if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 26 ||currGroupid == 42 || currGroupid == 45) {
					//业务管理员在添加机器时，直接添加到客户原来所属的业务员名下
					currCusOfMaid2 = currCusOfMaid;
					if (currGroupid == 26) {
						clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,resourcesManage-资源管理-resourcesManage,updateResources-直接修改-updateResources,openXjCabWindow-下架-openXjCabWindow-rosy"};
					}
				} else {
					currCusOfMaid2 = undefined;
				}
				//格式化字段
				var formatFileds = {"addtype":"0-未使用,1-已使用","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州","paystatus":"0-未付款,1-已付款,2-过期未续费","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
				//分页配置
				var pageEvent = "";
				var showTableId = "#cabinetMacListsid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
				$("#cabinetMacListsidFootid").hide();
				
				
				if(result.ip !=null){
//					alert(JSON.stringify(result.ip));
//					alert(JSON.stringify(result.rows[0].cabinetid));
					$("#cabid").val(result.rows[0].cabinetid);
					$("#cabMacSearchIpValid").val(result.ip);
					$("#cabMacSearchMacnumValid").val();
					searchMacOfAllIpsOfCab();
					$("#allMacInCab").show();
				}
			}
		}
  	});
}

//刷新按钮重新调用机柜查询方法
function reloadMyCabData () {
	var cabinetid = $.trim($("#searchCabValid").val());
	var url = "/customerMan/queryCabinetMacInfoForCus.action?cusid="+currClickCusid;
	var currPage = $("#cabinetMacListsid #currPage").html().substring(3,$("#cabinetMacListsid #currPage").html().length-1);
	var params = {"cusid":currClickCusid,"currPage":currPage,"cabinetid":cabinetid};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				//var dataFiles = [ "cabinetid","macnum","comproomname","rensc","renbegintime", "renendtime", "used", "note", [ "id,comproomid" ] ];
				var dataFiles = ["proNum", "cabinetid","macnum","dxipcount","unipcount","comproomid","dk","fh","renprice","rensc","renbegintime", "renendtime","sjdate","lssc","macxjstatus","paystatus","note", [ "id","comproomname","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproom"] ];
				//updateCusCabInfo-升级-updateCusCabInfo-white,(先隐藏)
				var clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,updateCusCabInfo-备注修改-updateCusCabInfo-rosy,resourcesManage-资源管理-resourcesManage,openXjCabWindow-下架-openXjCabWindow-rosy"};
				if (deptid == 2 || deptid ==12|| deptid ==16) {
					//只有业务才能续费付款
					clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,goOnRenewalCab-续费-goOnRenewalCab,payBizCab-付款-payBizCab,updateCusCabInfo-备注修改-updateCusCabInfo-rosy,resourcesManage-资源管理-resourcesManage,openXjCabWindow-下架-openXjCabWindow-rosy"};
				}else if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 26 ||currGroupid == 42 || currGroupid == 45) {
					//业务管理员在添加机器时，直接添加到客户原来所属的业务员名下
					currCusOfMaid2 = currCusOfMaid;
					if (currGroupid == 26) {
						clickbutton = {"aMethod":"getAllMacOfCab-详情-getAllMacOfCab,resourcesManage-资源管理-resourcesManage,updateResources-直接修改-updateResources,openXjCabWindow-下架-openXjCabWindow-rosy"};
						//clickbutton = {"aMethod":"ueryMacInfo-white,ipMan-IP管理-ipMan,updateInfo-直接修改-updateInfo,openXJMacWindow-下架-openXJMacWindow-rosy"};
					}
				} else {
					currCusOfMaid2 = undefined;
				}
				//格式化字段
				var formatFileds = {"addtype":"0-未使用,1-已使用","comproomid":"1-湖南衡阳,2-东莞,3-佛山,4-沈阳,5-广东惠州","paystatus":"0-未付款,1-已付款,2-过期未续费","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中"};
				//分页配置
				var pageEvent = {"action":"/customerMan/queryCabinetMacInfoForCus.action?cusid="+currClickCusid+"&cabinetid="+cabinetid};
				var showTableId = "#cabinetMacListsid";
				$("#cabinetMacListsidFootid").show();
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

var comproomid = "";
//添加机柜
function addCabOfcusPage () {
	comproomid = 1;
	var url = "/customerMan/getCabList.action";
 	var params = {"comproomid":'1'};
 	$.post(url,params,function(result){
 		$("#showCabid").html(result);
 	});
	$('#cuscabbizid').dialog('open').dialog('setTitle','添加机柜');
	
	//默认打开第一个tab
	$("#tabulid2 li").each (function(){
 		$(this).removeClass("active");
 	});
 	$("#tab1").addClass("active");
}
function tabChange2Cab (checkStatu,liidparm){
	 hidAddCab();
     
   //改变当前选中的tab头部
 	var liid = "#" + liidparm;
 	$("#tabulid2 li").each (function(){
 		$(this).removeClass("active");
 	});
 	$(liid).addClass("active");
 	
	if (!checkStatu || checkStatu == '1') {
		comproomid = 1;
	} else if(!checkStatu || checkStatu == '2'){
		comproomid = 2;
	} else if(!checkStatu || checkStatu == '3'){
		comproomid = 3;
	} else if(!checkStatu || checkStatu == '4'){
		comproomid = 4;
	}else if(!checkStatu || checkStatu == '5'){
		comproomid = 5;
	}else if(!checkStatu || checkStatu == '6'){
		comproomid = 6;
	}else if(!checkStatu || checkStatu == '7'){
		comproomid = 7;
	}
	
	var url = "/customerMan/getCabList.action";
 	var params = {"comproomid":comproomid};
 	$.post(url,params,function(result){
 		$("#showCabid").html(result);
 	});
}



function hidAddCab(){
	$('#cabNoteId').val("");
	$('#cabRoomId').val("");
	$('#addCabId').val("");
	$("#addNewCab").hide();
	$("#rentCabinet").hide();
}
function showAddNewCabinet(){
	//loadCompRoom ();//动态获取机房
	$("#cabMes").html("");
	
	$("#rentCabinet").hide();
	$("#addNewCab").show();
	//添加机柜编号输入的焦点事件
	addEvent("addCabId",handerCabId);
	
}
function handerCabId () {
	checkCabId("#addCabId");
}
//验证机柜编号是否重复
var cabIdVali = "";
function checkCabId (id) {
	var addCabId = $(id).val();
		if (addCabId) {
			var url = '/customerMan/checkCabIdRepeat.action';
			var params = {"addCabId":addCabId};
			$.post(url,params,function(result){
				var rs = $.trim(result);
				if (rs > 0){
					$("#cabMes").html("<font color='red'>已经存在!</font>");
					cabIdVali = true;
					$(id).focus();
				} else {
					$("#cabMes").html("");
					cabIdVali = false;
				}
			});
		} 
}

//提交新憎机柜
function addCabinet() {
	var str = '确定新增机柜吗？';
	var cusid = currClickCusid;
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			$('#addCabfm').form('submit',{
				url: '/customerMan/addCabinet.action?pageSize=3&cusid='+currClickCusid+"&currCusOfMaid="+currCusOfMaid2,
				onSubmit: function(){
					//所有验证通过
					var rsvali = false;
					var vali1 = $(this).form('validate');
					if (vali1 == true  && /*hadUnip == false && hadDxip == false &&*/ cabIdVali == false) {
						rsvali = true;
					}
					return rsvali;
				},
				success: function(result){
					var rs = $.trim(result);
					if (rs > 0){
							$('#addCabfm').form('clear');
							$.messager.show({
								title: '提 示',
								msg: '已成功添加新机柜！'
							});
							addCabOfcusPage ();
							hidAddCab();
						//initCheckinghosting();
						//$('#cusmacbizid').dialog('close'); // close the dialog
						
					} else {
						$.messager.show({
							title: 'Error',
							msg: '机柜库信息错误，请联系管理员！'
						});
					}
				}
			});
		}
	});
}

function showRentCabinet(cabid,jgid){
	$('#rentCabId').val(cabid);
	$('#rentCabJgId').val(jgid);
	$("#rentCabBeginTimeId").datebox("setValue",'');
	$("#rentCabBeginTimeId").datebox("setValue",myDateformatter(new Date()));
	
	$("#addNewCab").hide();
	$("#rentCabinet").show();

}

function saveRentCabinet(){
	var proNum = $('#rentCabProNumid').val();
	var str = '确定添加租用机柜吗？';
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			$('#rentCabinetfm').form('submit',{
				url: '/customerMan/saveRentCabinet.action?pageSize=3&cusid='+currClickCusid+"&currCusOfMaid="+currCusOfMaid2+"&comproomid="+comproomid+"&proNum="+proNum,
				onSubmit: function(){
					//所有验证通过
					var rsvali = false;
					var vali1 = $(this).form('validate');
					if (vali1 == true) {
						rsvali = true;
					}
					return rsvali;
				},
				success: function(result){
					var rs = $.trim(result);
					if (rs > 0){
							$('#rentCabinetfm').form('clear');
							$.messager.show({
								title: '提 示',
								msg: '已成功申请添加租用机柜，待客服审核！'
							});
							addCabOfcusPage ();
							hidAddCab();
						//initCheckinghosting();
						//$('#cusmacbizid').dialog('close'); // close the dialog
						
					} else {
						$.messager.show({
							title: 'Error',
							msg: '机柜库信息错误，请联系管理员！'
						});
					}
				}
			});
			}
	});
}

//----------机柜详情--------
function hiddenCabDetail(){
	$("#allMacInCab").hide();
}

//单击详情按钮查看机柜详情
function getAllMacOfCab () {
	$("#collCabMacList").hide();//隐藏预备托管机器列表
	$("#zdk").val(currRowObjJson.dk);
	$("#zfh").val(currRowObjJson.fh);
	$("#cabProNumid").val(currRowObjJson.proNum);
	/*alert("当前机柜机器数量："+currRowObjJson.macnum)
	$("#macnumincab").val(currRowObjJson.macnum);*/
	$("#cabinetdetailid").html(currRowObjJson.cabinetid);
	$("#cabid").val(currRowObjJson.cabinetid);
	$("#cdComproomid").val(currRowObjJson.comproomid);
	$("#bizcabid").val(currRowObjJson.id);
	$("#comproomname").val(currRowObjJson.comproomname);
	$("#allMacInCab").show();
	var cusidParam=currClickCusid;
	var params = {"cusid":cusidParam};
	var url = "/customerMan/queryMacInfoForCusCab.action?cabinet="+currRowObjJson.cabinetid+"&comproom="+currRowObjJson.comproomid;
	$.ajax({
        	url : url,
        	data: params,
        	cache : false, 
        	async : false,
        	type : "POST",
        	dataType : 'json',
        	success : function (result){
			if (result) {
				$("#uzdk").val(result.uzdk);
				$("#uzfh").val(result.uzfh);
				//表头
				//var dataFiles = ["macnum","dk","fh","renprice","dxip","unicomip","cabinet","renbegintime","renendtime","rensc","sjdate","lssc","biztype","macxjstatus",/*"paystatus",*/"cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename"]];
				var dataFiles = ["macnum","fh"/*,"renprice"*/,"dxip","unicomip","cabinet"/*,"renbegintime","renendtime","rensc"*/,"sjdate","lssc","biztype","macxjstatus",/*"paystatus",*/"cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","dk","comproomname"]];
				//行内按钮
				//goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,changRes-更换-changRes-rosy
				var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white-rosy,openXJMacWindow-下架-openXJMacWindow-rosy,updateCusMacNote-备注修改-updateCusMacNote-rosy,macResDetail-资源查看-macResDetail-white",};
				if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 26 ||currGroupid == 42 || currGroupid == 45) {
					//业务管理员在添加机器时，直接添加到客户原来所属的业务员名下
					currCusOfMaid2 = currCusOfMaid;
					if (currGroupid == 26) {
						clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,updateInfo-直接修改-updateInfo,openXJMacWindow-下架-openXJMacWindow-rosy,macResDetail-资源查看-macResDetail-white"};
					}
				} else {
					currCusOfMaid2 = undefined;
				}
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":"/customerMan/queryMacInfoForCusCab.action?cabinet="+currRowObjJson.cabinetid+"&cusid="+currClickCusid+"&comproom="+currRowObjJson.comproomid};
				var showTableId = "#busDataidCabMac";
			$("#busDataFootidCabMac").show();
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
        }
	});
}

//重新加载机柜中机器的数据
function reloadMacOfCabData(){
	var ipval = $.trim($("#cabMacSearchIpValid").val());
	var macnumval = $.trim($("#cabMacSearchMacnumValid").val());
	var cusidParam=currClickCusid;
	var cabinet=$("#cabid").val();
	var comproom = $("#cdComproomid").val();
	var currPage = $("#busDataidCabMac #currPage").html().substring(3,$("#busDataidCabMac #currPage").html().length-1);
	var params = {"cusid":cusidParam,"currPage":currPage,"ipval":ipval,"macnumval":macnumval};
	var url = "/customerMan/queryMacInfoForCusCab.action?cabinet="+cabinet+"&comproom="+comproom;
	$.ajax({
        	url : url,
        	data: params,
        	cache : false, 
        	async : false,
        	type : "POST",
        	dataType : 'json',
        	success : function (result){
			if (result) {
				//表头
				var dataFiles = ["macnum",/*"dk",*/"fh",/*"renprice",*/"dxip","unicomip","cabinet",/*"renbegintime","renendtime","rensc",*/"sjdate","lssc","biztype","macxjstatus",/*"paystatus",*/"cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","comproom","dk","comproomname"]];
				//行内按钮
				//goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,changRes-更换-changRes-rosy
				var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white-rosy,openXJMacWindow-下架-openXJMacWindow-rosy,updateCusMacNote-备注修改-updateCusMacNote-rosy,macResDetail-资源查看-macResDetail-white"};
				if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 26 ||currGroupid == 42 || currGroupid == 45) {
					//业务管理员在添加机器时，直接添加到客户原来所属的业务员名下
					currCusOfMaid2 = currCusOfMaid;
					if (currGroupid == 26) {
						clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,updateInfo-直接修改-updateInfo,openXJMacWindow-下架-openXJMacWindow-rosy,macResDetail-资源查看-macResDetail-white"};
					}
				} else {
					currCusOfMaid2 = undefined;
				}
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":"/customerMan/queryMacInfoForCusCab.action?cabinet="+cabinet + "&cusid="+currClickCusid +"&comproom="+comproom+"&ipval="+ipval+"&macnumval="+macnumval};
				var showTableId = "#busDataidCabMac";
			$("#busDataFootidCabMac").show();
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
        }
	});
}


//封装函数作为事件参数传递
function cabmachanderDX () {
	checIPExit("cabdxip","#cabmacdxipid");
}
function cabmachanderUN () {
	checIPExit("cabunip","#cabmacunicomipid");
}
function cabmachanderMacnum () {
	checkMacnumcab("#cabmacmacnumid");
}
//添加托管主机
function collCabMacActive () {
	
	//queryJGdetail();
	//清空上柜日期
	$("#cabmacbeginTimeid").datebox("setValue",'');
	$("#cabmacformTypeid").val('hosting');
	$("#cabmaccpuid").show();
	$("#cabmacmemoryid").show();
	$("#cabmacharddiskid").show();
	//$('#comproomnameid').html(currRowObjJson.comproomname);
	$('#cabmacmacnumid').val("");
	$('#cabmacdxipid').val("");
	$('#cabmacunicomipid').val("");
	
	
	//去掉租用部份的内容.
	$("#oneMacToGetPassDividCabMac").hide();
	//$("#searchDivid").hide();
	
	//添加IP输入的焦点事件
	addEvent("cabmacdxipid",cabmachanderDX);
//addEvent("cabmacmacnumid",cabmachanderMacnum);
	addEvent("cabmacunicomipid",cabmachanderUN);
	
	addhostingmacincab();
}
function addHostingOfcusPageCabMac (){
	//去掉租用部门的内容.
//	$("#oneMacToGetPassDivid").hide();
	var comproom =$("#cdComproomid").val();
	if($("#collCabMacList").is(":hidden")){
		$("#collCabMacList").show();
	}else{
		$("#collCabMacList").hide();
		return;
	}
	var cusname = $("#nameid").html();
	var param = {"cusname":cusname,"comproom":comproom};
	var url = "/customerMan/queryCollMacWithoutActive.action";
	$.ajax({
		url:url,
		async:false,
		cache:false,
		data:param,
		dataType:'json',
		success:function(result){
			var createDataGridJsonRows = result;
			var dataFiles = ["macnum","cpu","memory","harddisk","mactype","comproom","cabinet",['machid','comproomid']];
			var clickbutton = {"aMethod":"collCabMacActive-上架-collCabMacActive"};
			var formatFileds = "";//{"status":"0-未使用,1-已经使用"};
			//分页配置
			var loadurl = "/customerMan/queryCollMacWithoutActive.action?cusname="+cusname+"&comproom="+comproom;
			var pageEvent = {"action":loadurl}; //加载数据,必须返回json数据.
			var showTableId = "#collCabMacList";
			createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,1,formatFileds);
		}
	});
}



function queryJGdetail() {
	var id = $("#bizcabid").val();
	var url = '/customerMan/queryJgDetails.action';
	var params = {"id":id};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = JSON.parse(rs);
		if (jsondata.macnum <18 ){
			$("#macnumincab").val(jsondata.macnum);
			return;
		} else {
			$.messager.alert("提示","机柜已放满18台机器，不能继续添加主机！");
			return;
		}
	});
}


function checkValcab (id,u,z,temp) {
	var uzval=$(u).val();
	var zval=$(z).val();
	var val = $(id).val();
	var left =parseInt(zval)-parseInt(uzval);
	if (val) {
		var rs = $.trim(val);
		if(temp =='dk'){
			if (rs > 0){
				if(parseInt(zval)<parseInt(rs)+parseInt(uzval)){
					$("#cabmicdkidnumMes").html("<font color='red' style='padding-left: 85px;'>已超过总带宽!  剩余可分配带宽  "+left+" M</font>");
					$(id).focus();
					return;
				}else {
					$("#cabmicdkidnumMes").html("");
				}
			}else {
				$("#cabmicdkidnumMes").html("");
			} 
		}else{
			if (rs > 0){
				if(parseInt(zval)<parseInt(rs)+parseInt(uzval)){
					$("#cabmacfhidnumMes").html("<br><font color='red'  style='padding-left: 85px;'>已超过总防护!  剩余可分配防护  "+left+" G</font>");
					$(id).focus();
					return;
				}else {
					$("#cabmacfhidnumMes").html("");
				}
			}else {
				$("#cabmacfhidnumMes").html("");
			}
		}
	} 
}

//打开添加托管机器编辑窗口
function addhostingmacincab () {
	//getAllMacOfCab();
	
	//给编窗口添加当前时间
	$("#cabmacbeginTimeid").datebox("setValue",myDateformatter(new Date()));
	$('#cabmacmacnumid').removeAttr("readonly");
	$('#cabmacunicomipid').removeAttr("readonly");
	$('#cabmacdxipid').removeAttr("readonly");
	$('#cabmaccabinetid').removeAttr("readonly");
//	$("#cabmacmacnumid").focus();
	$("#cabmaccusbiztruenameid").html(custmoerName);
	$("#cabmaccusbiznameid").html(custmoerName);
	$("#cabmacpopTitleid").html("主机托管");
	$("#cabmacbizTypeid").html("托 管");
	var cabinet =$("#cabid").val();
	$('#cabmaccabinetid').val(cabinet);
	$('#cabmacmacnumid').val(currRowObjJson.macnum);
	$("#cabmacfhid").val("30");
	$("#cabmicpriceValid").val("0");
	
	var comproom = $("#cdComproomid").val();
	var comproomname =$("#comproomname").val();
	$('#comproomnameid').html(comproomname);
	$('#cabMacProNumid').val($("#cabProNumid").val());
	$("#cabmaccpu").val(mydecode(mydecode(currRowObjJson.cpu)));
	$("#cabmacmemory").val(mydecode(mydecode(currRowObjJson.memory)));
	$("#cabmacharddisk").val(mydecode(mydecode(currRowObjJson.harddisk)));
	
	
	
	
	$('#cusmacofcabbizid').dialog('open').dialog('setTitle','客户托管主机提交单');
//	checkMacnumcab("#cabmacmacnumid");
	var macnum =$("#cabmacmacnumid").val();
	url = '/customerMan/addCusCabMacBiz.action?pageSize=3&bizType=hosting&cusid='+currClickCusid+"&currCusOfMaid="+currCusOfMaid2+"&cabinet="+cabinet+"&comproom="+comproom+"&cabmacmacnum="+macnum;
}

function checkMacnumcab (id) {
		var macnumval = $(id).val();
		if (macnumval) {
			var url2 = '/customerMan/checkMacnumRepeat.action';
			var params = {"macnum":macnumval};
			$.post(url2,params,function(result){
				var rs = $.trim(result);
				if (rs > 0){
					$("#cabmacmacnumMes").html("<font color='red'>已经存在!</font>");
					hadMacnum = true;
					$(id).focus();
					return;
				} else {
					$("#cabmacmacnumMes").html("");
					hadMacnum = false;
				}
			});
		} 
}
//获取密码，选择租用主机
/*function getPasswordMscOfCusPageCabMac () {
	if (currRowObjJson) {
		$("#cabmaccpuid").hide();
		$("#cabmacmemoryid").hide();
		$("#cabmacharddiskid").hide();
		getPasswordMscCabMac(currRowObjJson.macnum,currRowObjJson.cabinet,currRowObjJson.dxip,currRowObjJson.unicomip);
		$("#cabmacdxerrorsip").html("");
	    $("#cabmacunerrorsip").html("");
	    $("#cabmacmacnumMes").html("");
	    
	    //去除IP输入的焦点事件
	    removeEvnent("unicomipid",handerUN);
		removeEvnent("dxipid",handerDX);
		removeEvnent("macnumid",handerMacnum);
	}
}*/

//打开添加租用机器编辑窗口
/*function getPasswordMscCabMac (mannum,cabinet,dxip,unicomip) {
	var cabid=$("#cabid").val();
	var name=$("#comproomname").val();
	$('#comproomnameid').html(name);
	$("#comproomnameid").val(currRowObjJson.comproomname);
	$("#cabmicpriceValid").val('');
	$('#cabmacmacnumid').attr("readonly","readonly");
	$('#cabmacunicomipid').attr("readonly","readonly");
	$('#cabmacdxipid').attr("readonly","readonly");
	$('#cabmaccabinetid').attr("readonly","readonly");
	//$("#beginTimeid").datebox("setValue","");
	$("#cabmacbeginTimeid").datebox("setValue",myDateformatter(new Date()));
	$("#cabmaccusbiztruenameid").html(custmoerName);
	$("#cabmaccusbiznameid").html(custmoerName);
	$("#cabmacmacnumid").val(mannum);
	$("#cabmaccabinetid").val(cabinet);
	$("#cabmacdxipid").val(dxip);
	$("#cabmacunicomipid").val(unicomip);
	$("#cabmacpopTitleid").html("主机租用");
	$("#cabmacbizTypeid").html("租 用");
	
	$('#cusmacofcabbizid').dialog('open').dialog('setTitle','客户租用主机提交单');
	url = '/customerMan/addCusCabMacBiz.action?pageSize=3&bizType=rent&cusid='+currClickCusid+"&currCusOfMaid="+currCusOfMaid2+"&cabinet="+cabinet;
}*/
//提交托管和租用的业务表单
function cabmacsaveBiz() {
	var str = '确定提交客户【'+custmoerName+'】的新业务单吗？';
	checkValcab("#cabmicdkid","#uzdk","#zdk","dk");
	//checkValcab("#cabmacfhid","#uzfh","#zfh","fh");
	if($("#cabmicdkidnumMes").html()){
		return;
	}
	if($("#cabmacfhidnumMes").html()){
		return;
	}
	//cusid,在jquery的回调方法中，一定要声明一个变量去赋值全局变量，否则无法获取值。
	var cusid = currClickCusid;
	var macnum=$("#macnumincab").val();
	var proNum=$("#cabMacProNumid").val();
	var cpu=$("#cabmaccpu").val();
	var memory=$("#cabmacmemory").val();
	var harddisk=$("#cabmacharddisk").val();
	$.messager.confirm('Confirm',str,function(r){
		$("#getPassAId").html("客服审核中...");
		if (r){
			$('#cabmaccusmacbizfm').form('submit',{
				url: url+"&macnum="+macnum+"&jgmac="+"jgmac"+"&proNum="+proNum+"&cabmaccpu="+cpu+"&cabmacmemory="+memory+"&cabmacharddisk="+harddisk+"&url=true",
				onSubmit: function(){
					//所有验证通过
					var rsvali = false;
					var vali1 = $(this).form('validate');
					if (vali1 == true && hadUnip == false && hadDxip == false && hadMacnum == false) {
						rsvali = true;
					}
					return rsvali;
				},
				success: function(result){
					var rs = $.trim(result);
					if (rs > 0){
						if (url.indexOf("hosting") != -1 ) {
							//添加托管
							//$('#cabmaccusmacbizfm').form('clear');
							$.messager.show({
								title: '提 示',
								msg: '已成功申请添加托管机器，待客服审核！'
							});
							reloadMyCabData();
							addHostingOfcusPageCabMac ();
							//initCheckinghosting();
						} else if (url.indexOf("rent") != -1 ) {
							//添加租用
							$.messager.show({
								title: '提 示',
								msg: '已成功申请添加租用机器，待客服审核！'
							});
							reloadMyCabData();
							addHostingOfcusPageCabMac ();
							//initCheckingRent();
						}
						$('#cusmacofcabbizid').dialog('close'); // close the dialog
						
					} else {
						$.messager.show({
							title: 'Error',
							msg: '主机库信息错误，请联系管理员！'
						});
					}
				}
			});
		}
	});
	//----进入用户界面后的业务提交,隐藏选择主机出租框-------
	//隐藏获取密码
	$("#oneMacToGetPassDividCabMac").hide();
	//隐藏模糊查询 
	$("#searchDivid").hide();
}

//通过查询IP(包括子IP)去查询当前业务员的客户机柜中的主机.
function searchMacOfAllIpsOfCab () {
	var cabinet=$("#cabid").val();
	var ipval = $.trim($("#cabMacSearchIpValid").val());
	var macnumval = $.trim($("#cabMacSearchMacnumValid").val());
	if (!ipval && !macnumval) {
		$.messager.show({ // show error message
			title: '提示',
			msg: '请输入要查询的IP或主机编号'
		});
		return;
	}
	var url = "/customerMan/searchMacOfAllIpsOfCab.action";
	var params = {"cusid":currClickCusid,"searchIpValid":ipval,"cabinet":cabinet,"macnumval":macnumval};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头                          
				var dataFiles = ["macnum",/*"dk",*/"fh",/*"renprice",*/"dxip","unicomip","cabinet"/*,"renbegintime","renendtime","rensc"*/,"sjdate","lssc","biztype","macxjstatus",/*"paystatus",*/"cbNote",["id","customerid","paytotal","accbal","creded","renpayid","mtruename","maid","cusname","custruename","dk"]];
				//行内按钮
				//goOnRenewal-续费-goOnRenewal,payBizMac-付款-payBizMac,changRes-更换-changRes-rosy
				var clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,askQuestion-工单-askQuestion-white-rosy,openXJMacWindow-下架-openXJMacWindow-rosy,updateCusMacNote-备注修改-updateCusMacNote-rosy,macResDetail-资源查看-macResDetail-white"};
				if (currGroupid == 26) {
					clickbutton = {"aMethod":"queryMacInfo-查看-queryMacInfo-white,updateInfo-直接修改-updateInfo,openXJMacWindow-下架-openXJMacWindow-rosy,macResDetail-资源查看-macResDetail-white"};
				}
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = "";
				var showTableId = "#busDataidCabMac";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
				$("#busDataFootidCabMac").hide();
			}
		}
  	});
}

//随机获取一条主机供业务员选择(需要匹配机房位置room与机柜编号cabinet为前提)
function getpassMacidOfCusPageCabMac (searchOneMacLike) {
	$("#oneMacToGetPassDividCabMac").show();
	var cabinet=$("#cabid").val();
	var comproomid=currRowObjJson.comproomid;
	var param = {"cabinet":cabinet,"comproomid":comproomid};;
	if (searchOneMacLike) {
		var inputVal = $("#inputSearchOneMacid").val();
		param = {"cabinet":cabinet,"comproomid":comproomid,"inputVal":inputVal};
	}
	var url = "/customerMan/queryOneMacOfCuspageCabMac.action";
	$.post(url,param,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			var createDataGridJsonRows = JSON.parse(rs);
			//表头
			var dataFiles = ["macnum","cpu","memory","harddisk","mactype","cabinet","dxip","unicomip","used",['machid']];
			//行内按钮
			var clickbutton = {"aMethod":"getPasswordMscCabMac-获取密码-getPasswordMscOfCusPageCabMac"};
			//格式化字段
			var formatFileds = {"used":"0-未使用,1-已经使用"};
			//分页配置
			var loadurl = "";//"/customerMan/queryCheckingMac.action?pageSize=3&biztype=rent&cusid="+currClickCusid;
			var pageEvent = "";//{"action":loadurl}; //加载数据,必须返回json数据.
			var showTableId = "#getOneMacidCabMac";
			createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,1,formatFileds);
		}
	});
}

//---------机柜升级-----------

//弹出修改客户主机业务信息窗口,可修改并且要跑流程审核的四个元素，记录原值做对比。
var cabyfh = "";
var cabydk = "";
var cabyrenbegintime = "";
var cabyrenendtime = "";
var cabyrenprice = "";
function updateCusCabInfo () {
	if (currRowObjJson) {
		//if (currRowObjJson.paystatus == 0) {
			//$.messager.alert("提示","请先付款机器才能做升级操作");
			//return;
		//}
		var attrs = undefined;
		//赋值服务器服务项目数据
		$('#editcabfm').form('load',currRowObjJson);
		$("#cabaddpriceid").val("0");
		
		//组织清空提示的参数
		attrs = new Array("cabfunameudkId","cabudknameId","caburenbegintimeid","caburenendtimeid","cabaddpriceid","cabunewrpriceid");
		
		cabyfh = $("#cabfunameudkId").val();
		cabydk = $("#cabudknameId").val();
		cabyrenprice = $("#caburpriceid").val();
		cabyrenbegintime = $("#caburenbegintimeid").val();
		cabyrenendtime = $("#caburenendtimeid").val();
		$('#cabubizNoteid').val(mydecode(mydecode(currRowObjJson.note)));
		$('#addCabProNumid').val(currRowObjJson.proNum);
		$('#addCabProNumOldid').val(currRowObjJson.proNum);
		$("#cabinet").val(currRowObjJson.cabinetid);
		
		//清空提示
		checkAttrs (attrs,true);
		$('#editCusCab').dialog('open').dialog('setTitle','修改机柜信息');
	}
}

//提交修改信息
function saveCabBiz () {
	var fh = $("#cabfunameudkId").val();
	var dk = $("#cabudknameId").val();
	var renbegintime = $("#caburenbegintimeid").val();
	var renendtime = $("#caburenendtimeid").val();
	var addprice = $("#cabaddpriceid").val();
	var renprice = $("#cabunewrpriceid").val();
	var bizNote = $("#cabubizNoteid").val();
	var unewrprice = $("#cabunewrpriceid").val();
	var id = $("#cabsid").val();
	var proNum = $("#addCabProNumid").val();
	var oldProNum = $("#addCabProNumOldid").val();
	 var cabinet =$("#cabinet").val()
	var attrs = undefined;
	
	//非空验证
	attrs = new Array("cabfunameudkId","cabudknameId","caburenbegintimeid","caburenendtimeid","cabaddpriceid","cabunewrpriceid");
	var checkrs = checkAttrs (attrs);
	if (!checkrs) {
		return;
	}
	
	//控制提交
	//alert("addprice:"+addprice+"__"+"cabyrenprice:"+cabyrenprice+"__"+"renprice:"+renprice+"__"+"cabyfh:"+cabyfh+"__"+"__"+"fh:"+fh+"__"+"cabydk:"+cabydk+"__"+"dk:"+dk+"__"+"cabyrenbegintime:"+cabyrenbegintime+"__"+"renbegintime:"+renbegintime+"__"+"cabyrenendtime:"+cabyrenendtime+"__"+"renendtime:"+renendtime+"__");
	if (addprice == 0 && cabyrenprice == renprice && cabyfh == fh && cabydk == dk && cabyrenbegintime == renbegintime && cabyrenendtime == renendtime ) {
			//如果点击提交检测到数据全部没有做过修改，并且如果补扣费用也为0，那么就是做修改备注操作.
			//当id为0的时候，也会返回false，所以要加上此条件.
			if (id || id == 0) {
				var str = "修改机柜信息操作，确定？";
				$.messager.confirm('Confirm',str,function(r){
					if (r){
						var url = "/customerMan/updateBizInfoOfCab.action";
						var params = {"id":id,"note":bizNote,"proNum":proNum,"oldProNum":oldProNum,"cabinet":cabinet};
						queryInfo (url,params,"修改失败，请联系管理员");
						$('#editCusCab').dialog('close');
						reloadMyCabData(currRowObjJson.customerid);
					}
				})
			} else {
				myMesShow("提 示","业务单信息获取异常，请联系管理员");
			}
			return;
	}
	//修改价格
	//if (addprice == 0 && cabyrenprice == renprice && cabyfh == fh && cabydk == dk && cabyrenbegintime == renbegintime && cabyrenendtime == renendtime )
	if (addprice == 0 && cabyrenprice != renprice && cabyfh == fh && cabydk == dk && cabyrenbegintime == renbegintime && cabyrenendtime == renendtime ) {
		 myMesShow("提 示","你是在修改单价，请到续费功能处进行修改");
		return;
	}
	if (addprice && !bizNote) {
		myMesShow("提 示","你在进行其他项目扣款，请必须备注");
		return;
	}
	
	//付费前计算额度
	var payTotal = parseFloat(addprice);//补扣差价
	var canPayTotal = parseFloat(currRowObjJson.accbal) + parseFloat(currRowObjJson.creded);
	if (payTotal > canPayTotal) {
		$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
		return;
	}
	
	
	//组织标题
	var flowName = "服务器资源变更";
	if (cabydk != dk) {
		flowName += "（含带宽）";
	}
	//组织提示文字
	if (currRowObjJson){
		var str = '编号[' + currRowObjJson.cabinetid + ']的机柜申请变更如下：</br>';
		if (fh != yfh) {
			str += "</br>【防护" + cabyfh + " 改为：" + fh + "】";
		}
		if (dk != ydk) {
			str += "</br>【带宽" + cabydk + " 改为：" + dk + "】";
		}
		if (renbegintime != yrenbegintime) {
			str += "</br>【上架时间 " + cabyrenbegintime + " 改为：" + renbegintime + "】";
		}
		if (renendtime != yrenendtime) {
			str += "</br>【下架时间 " + cabyrenendtime + " 改为：" + renendtime + "】";
		}
		if (unewrprice != currRowObjJson.renprice) {
			str += "</br>【月租单价 " + currRowObjJson.renprice + " 改为：" + unewrprice + "】";
		}
		
		str += "</br><span style='color:red'>付款差额：(" + addprice + "元) <span>" + ", 确定？</br>";
		var cusid = currRowObjJson.customerid;
		/*var unip = currRowObjJson.unicomip;
		var dxip = currRowObjJson.dxip;*/
		var renpayid = currRowObjJson.renpayid;
		var cabinetid = currRowObjJson.cabinetid;
		var maid = currRowObjJson.maid;
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var parmas = {"id":id,"cabinetid":cabinetid,"cusid":cusid,"fh":fh,"dk":dk,"renbegintime":renbegintime,
							  "renendtime":renendtime,"addprice":addprice,"renprice":renprice,"note":bizNote,"flowName":flowName,
							  "yfh":cabyfh,"ydk":cabydk,"yrenbegintime":cabyrenbegintime,"yrenendtime":cabyrenendtime,"unewrprice":unewrprice,
							  "renpayid":renpayid, "maid":maid}; 
				var url = "/customerMan/updateCusBizOfCab.action";
				$.post(url,parmas,function(result){
		    		var rs = $.trim(result);
		    		$('#editCusCab').dialog('close');
		    		reloadMyCabData(currRowObjJson.customerid);
		    		if (rs > 0 ) {
		    			myMesShow("提示","申请成功，等待上一级审核");
		    		}
		    		//look(cusid);
		  		});
			}
		});
	} else {
		myMesShow("异 常","数据获取异常，请联系管理员");
	}
}

//动态显示价格
function formatPriceCab (value) {
	var rpriceid = $("#cabrpriceid").val();
	if (rpriceid) {
		return value+"月"+(rpriceid*value)+" 元";
	}
}

//修改价格
var oldpriceValCab = undefined;
function changePriceCab(inputPriceid,textid) {
	textid = "#" + textid;
	inputPriceid = "#" + inputPriceid;
	var ahtml = $(textid).html();
	
	if (ahtml == '[修改价格]') {
		$(textid).html('[取消修改]');
		$(inputPriceid).attr("disabled",false);
		oldpriceValCab = $(inputPriceid).val();
	} else if (ahtml == '[取消修改]') {
		$(textid).html('[修改价格]');
		$(inputPriceid).attr("disabled","disabled");
		$(inputPriceid).val(oldpriceValCab);
	}
}

//机柜续费
var cabrprice = undefined;
//currbizPayStatus记录当前业务单的付款状态，当业务单处理未付款状态时，不能再继续续费，只能修改价格。
var cabcurrbizPayStatus = undefined;
function goOnRenewalCab() {
	if (currRowObjJson) {
		
		cabcurrbizPayStatus = currRowObjJson.paystatus;
		$('#cabgoOnRenewalid').dialog('open').dialog('setTitle','续 费');
		$("#cabrCusTrueNameid").html(currRowObjJson.custruename);
		$("#cabcabinetid").val(currRowObjJson.cabinetid);
		$("#cabrrenscid").val(currRowObjJson.rensc);
		$("#cabrpriceid").val(currRowObjJson.renprice);
		cabrprice = currRowObjJson.renprice;
		$("#cabrrenbegintimeid").val(currRowObjJson.renbegintime);
		$("#cabrrenendtimeid").val(currRowObjJson.renendtime);
		$("#ywbizid").val(currRowObjJson.id);
		$("#mrcusid").val(currRowObjJson.customerid);
		
	}
}

//机柜提交续费
function cabsubRenewal () {
	var addsc = $('#cabaddrenscid').slider('getValue');
	var newPrice = $("#cabrpriceid").val();
	//如果当前业务单在未付款的情况下，不能继续操作续费功能
	if (cabcurrbizPayStatus == 0 ) {
		$.messager.alert("提示","当前为未付款状态，不能操作续费，请先操作付款当前机器");
		return;
	}
	//如果没有修改价格，也没有选择续费时长，则做出提示，方法停止。
	if ((!oldpriceValCab && addsc == 0) || (oldpriceValCab==newPrice && addsc == 0)) {
		$.messager.alert("提示","请修改价格或者续费时长！");
		return;
	}
	var str = '确定要续费编号为【'+$("#cabcabinetid").val()+'】的机柜吗？';
	if (addsc == 0) {
		str = '确定要修改编号为【'+$("#cabcabinetid").val()+'】的价格吗？';
	}
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var renbegintime = $("#cabrrenendtimeid").val();
			var bizid = $("#ywbizid").val();
			var url = "/customerMan/subRenewalCab.action";
			var renprice = $("#cabrpriceid").val();
			var rnote = $("#cabrnoteid").val();
			rnote = $.trim(rnote);
			var cabinetid = $("#cabcabinetid").val();
			var params = {"addsc":addsc,"begintime":renbegintime,"bizid":bizid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"cabinetid":cabinetid,"renpayid":currRowObjJson.renpayid,"payproject":4,"comproom":currRowObjJson.comproom};
			//payTot 目前续费总共要支付的费用
			var payTot = undefined;
			//如果点击过修改价格，则要跑审核流程；否则就直接续费
			if (oldpriceValCab) {
				if (renprice != oldpriceValCab) {
					//确实修改价格,跑流程所需要的参与不同，所有要重新定义params.
					params = {"oldpriceVal":oldpriceValCab,"addsc":addsc,"begintime":renbegintime,"bizid":bizid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"cabinetid":cabinetid,"goflow":"goflow","renpayid":currRowObjJson.renpayid};
					payTot = renprice * addsc;
					
				} else {
					//点击过修改价格后，又取消了，所以要记录原来的价格去计算
					payTot = oldpriceValCab * addsc;
				}
			} else {
				payTot = renprice * addsc;
			}
			//余额加信用度不够支付
			var canPay = parseInt($("#balanceValid").val()) + parseInt($("#credeValid").val());
			if (payTot > canPay) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				$('#cabaddrenscid').slider('setValue',0);
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
					$('#cabaddrenscid').slider('setValue',0);
					$('#cabaupdatePriceid2').html('[修改价格]');
					$('#cabrpriceid').attr("disabled","disabled");
					$('#cabgoOnRenewalid').dialog('close');
					//清空oldpriceValCab值
					oldpriceValCab=undefined;
					//刷新当前客户余额
					queryBalance();
					//刷新当前表的数据
					reloadMyCabData();
					//reloadMyCurrCusData($("#rcusid").val());
					//刷新机柜的机器列表
					reloadMacOfCabData();
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

//由业务人员付款机柜
function payBizCab () {
	if (currRowObjJson) {
		if (currRowObjJson.paystatus == 0) {
			var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
			var cabinetid=currRowObjJson.cabinetid;
			var canPayTotal = parseFloat(currRowObjJson.accbal) + parseFloat(currRowObjJson.creded);
			if (payTotal > canPayTotal) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				return;
			}
			var str = "编号:<span style='color:red;font-size:14px;'>" + currRowObjJson.cabinetid + "</span><br><br>" +
				"缴费总额:<span style='color:red;font-size:14px;'> " + payTotal +"元 </span><br><br>" +
				"<span style='margin-left:40px;'>确定为机柜进行付款吗？</span><br><br>";
			$.messager.confirm('Confirm',str,function(r){
				if (r){
					var url = "/customerMan/payMenoy.action";
					var params = {"cusid":currClickCusid,"payTotal":payTotal,"bizid":currRowObjJson.id,"renpayid":currRowObjJson.renpayid,"cabinetid":cabinetid,"payproject":2};
					$.post(url,params,function(result){
						var rs = $.trim(result);
						if (rs > 0) {
							//刷新当前客户余额
							queryBalance();
							//刷新当前表的数据
							reloadMyCabData();
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
		} else {
			$.messager.alert("提示","此机器已付款！")
		}
	} 
}

//综合部直接修改机柜业务的带宽和防护
function updateResources () {
	$("#updataResourcesbh").val(currRowObjJson.proNum);
	$("#updataResourcesdk").val(currRowObjJson.dk);
	$("#updataResourcesfh").val(currRowObjJson.fh);
	$("#updateResourcesdj").val(currRowObjJson.renprice);
	 var url = '/customerMan/queryUseResources.action';
	 var params = {"cabinetid":currRowObjJson.cabinetid,"customerid":currRowObjJson.customerid,"cusid":currClickCusid,"comproom":currRowObjJson.comproom};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = JSON.parse(rs);
		if (rs) {
			$("#usedkid").html(jsondata.uzdk);
			//$("#usefhid").html(jsondata.uzfh);
			$('#updateBizResources').dialog('open').dialog('setTitle','机柜资源修改');
			}
  		});
	
}

//提交修改
function subUpdateBizResources () {
	var usedk = $("#usedkid").html();
	/*var usefh = $("#usefhid").html();*/
	var proNum = $("#updataResourcesbh").val();
	var dk = $("#updataResourcesdk").val();
	var fh = $("#updataResourcesfh").val();
	var renprice = $("#updateResourcesdj").val();
	var id = currRowObjJson.id;
	var url = "/customerMan/subUpdateBizResources.action";
	if (!id) {
		$.messager.alert('Errors','错误代码：subUpdateBizInfo,获取业务单信息失败，请联系管理员');
		return;
	}
        if (!dk || !fh || !proNum) {
		//if (!dk ) {
		$("#resourcesErrorid").html('提示：输入框内容不能为空值或者输入空格');
		return;
	} else {
		$("#resourcesErrorid").html('');
	}
	if(parseInt(dk)<parseInt(usedk) /*||parseInt(fh)<parseInt(usefh)*/){
		$.messager.alert('提示','输入资源值不能小于已分配资源值！');
		return;
	}
	var params = {"id":id,"dk":dk,"fh":fh,"renprice":renprice,"proNum":proNum};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$('#updateBizResources').dialog('close');
			//刷新当前表的数据
			reloadMyCabData();
			myMesShow ("提示","修改资源成功！");
		} else {
			$.messager.alert('Errors','错误代码：subUpdateBizInfo,业务单信息更新失败，请联系管理员');
			return;
		}
	});
}

var bizid ="";
var res_cabinetid ="";
var res_customerid ="";
var res_comproomid ="";
var zdk ="";
var zfh ="";
var resType = "1";
var resTypeIp = "";
function resourcesManage () {
	if($("div[name='layout']").length!=2){
		var layout = $("div[name='layout']");
		layout[0].remove();
		layout[1].remove();		
	}	
	$("#cabid").val(currRowObjJson.cabinetid);
	$("#cdComproomid").val(currRowObjJson.comproomid);
	payMark='jgRes';
	//赋值给全局变量初始化数据
	bizid = currRowObjJson.id;
	res_cabinetid = currRowObjJson.cabinetid;
	res_customerid = currRowObjJson.customerid;
	res_comproomid = currRowObjJson.comproomid;
	zdk = currRowObjJson.dk;
	zfh = currRowObjJson.fh;
	showResDetails();
	tabChange2Resources ('1','dktab1')
	//queryRes (resType);
	/*if(resType=='1'){
		$("#fhResources").hide();
		$("#resourcesIPid").hide();
	}*/
	$('#resourcesManageid').dialog('open').dialog('setTitle','机柜资源管理');
}
//查询资源使用状况
function showResDetails() {
	 var url = '/customerMan/queryUseResources.action';
	 var params = {"cabinetid":res_cabinetid,"customerid":res_customerid,"cusid":currClickCusid,"comproom":res_comproomid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			$("#zongdk").html(jsondata.zongdk);
			$("#zongfh").html(jsondata.zongfh);
			zdk = jsondata.zongdk;
			zfh	= jsondata.zongfh;
			$("#usedk").html(jsondata.uzdk);
			$("#unusedkid").html(jsondata.zongdk-jsondata.uzdk);
			$("#usefh").html(jsondata.uzfh);
			$("#unusefhid").html(jsondata.zongfh-jsondata.uzfh);
			$("#dxziip").html(jsondata.dxipsCounts);
			$("#unziip").html(jsondata.unipsCounts);
			}
  		});
}
function queryRes (resType){
	var currPageShowTableId ="";
	if(resType=="1"){
		currPageShowTableId = "#dkResources";
	}else if(resType=="2"){
		currPageShowTableId = "#fhResources";
	}else if(resType=="3"){
		currPageShowTableId = "#dxipResources";
	}else if(resType=="4"){
		currPageShowTableId = "#unipResources";
	}
	var currPage = $(currPageShowTableId+" #currPage").html().substring(3,$(currPageShowTableId+" #currPage").html().length-1);
	var url = "/customerMan/queryCabResINfoByMacNum.action";
	var params = {"cabinet":res_cabinetid,"type":resType,"currPage": currPage};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				var dataFiles = "";
				var showTableId = "";
				//1:带宽 	2：防护		3：子IP
				if(resType=='1'){
					//表头
					dataFiles = [ /*"macnum"*/"cabinet","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP","customerid"] ];
					showTableId = "#dkResources";
					$("#dkcabinetResListsidFootid").show();
				}else if(resType=='2'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP","customerid"] ];
					showTableId = "#fhResources";
					$("#fhcabinetResListsidFootid").show();
				}else if(resType=='3'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP","customerid"] ];
					showTableId = "#dxipResources";
					$("#dxipcabinetResListsidFootid").show();
				}else if(resType=='4'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP","customerid"] ];
					showTableId = "#unipResources";
					$("#dxipcabinetResListsidFootid").show();
				}
				var clickbutton ='';
				if(deptid=='2' || deptid  ==12|| deptid  ==16){
					//deptid=2，业务部
					clickbutton = {"aMethod":"goOnRenewalRes-续费-goOnRenewalRes,payBizRes-付款-payBizRes"};
				}else if((resType=='3' || resType=='4') && deptid=='4'){
					//deptid=4， 综合部
					clickbutton = {"aMethod":"deleteIP-下架-deleteIP"};
				}  else if ((resType=='1' || resType=='2') && deptid=='4'){
					clickbutton = {"aMethod":"xjResources-下架-xjResources"};
				} else{
					clickbutton={};
				}
				//格式化字段
				var formatFileds = {"paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":url+"?cabinet="+res_cabinetid+"&type="+resType};
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//资源管理提交修改
function updateResourcesAdd () {
	var form='';
	var cusbizid= '';
	var ziIPid= '';
	var ziIp = '';
	var str ='';
	var macnum = '';
	if(resType=='1'){
		/*macnum = $('#addResMacidDk').combobox('getText');
		cusbizid = $('#addResMacidDk').combobox('getValue');*/
		form = "resourcesDkfm";
		str = '确定要为编号为【'+res_cabinetid+'】的机柜增加带宽吗？';
	}else if(resType=='2'){
		macnum = $('#addResMacidFh').combobox('getText');
		cusbizid = $('#addResMacidFh').combobox('getValue');
		form = "resourcesFhfm";
		str = '确定要为编号为【'+macnum+'】的机器增加防护吗？';
	}else if(resType=='3'){
		//子IP
		cusbizid = $('#addResMaciddxIp').combobox('getValue');
		macnum = $('#addResMaciddxIp').combobox('getText');
		ziIp = $('#resadddxipid').combobox('getText'); 
		ziIPid = $('#resadddxipid').combobox('getValue');
		form = "resourcesDxIpfm";
		str = '确定要为编号为【'+macnum+'】的机器添加电信IP吗？';
	}else if(resType=='4'){
		cusbizid = $('#addResMacidunIp').combobox('getValue');
		macnum = $('#addResMacidunIp').combobox('getText');
		ziIp = $('#resddunicomipid').combobox('getText'); 
		ziIPid = $('#resddunicomipid').combobox('getValue');
		form = "resourcesUnIpfm";
		str = '确定要为编号为【'+macnum+'】的机器添加联通IP吗？';
	}
	
	var id = bizid;
	if (!id) {
		$.messager.alert('Errors','错误代码：subUpdateBizInfo,获取业务单信息失败，请联系管理员');
		return;
	}

	var url = "/customerMan/addResourcesManage.action?id="+id+"&zdk="+zdk+"&zfh="+zfh+"&resType="+resType+"&cusbizid="+cusbizid+"&resTypeIp="+resTypeIp+"&ziIPid="+ziIPid/*+"&ziIp="+ziIp*/+"&zhuip="+dxipFormat+"&maid="+currMasterid+"&cusid="+currClickCusid;
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			if(resType=='3'||resType=='4'){
				var reg = /\d+\.\d+\.\d+\.\d+/g; 
				if(ziIPid=='' || !reg.test(ziIPid)){
					$.messager.alert("提示","子IP值有误！");
					return;
				}else{
					var ipvali = false;
					var comproom = res_comproomid;//$("#resMacComproomid").val();
					if(resType=='3'){
						ipvali = resCheckIpComproom("dxip",ziIPid,comproom);
					}else if(resType=='4'){
						ipvali = resCheckIpComproom("unip",ziIPid,comproom);
					}
					if(!ipvali){
						return;
					}
				}
			}
			$('#'+form).form('submit',{
				url: url,
				onSubmit: function(){
					//所有验证通过
					var rsvali = false;
					var vali1 = $(this).form('validate');
					if (vali1 == true ) {
						rsvali = true;
					}
					return rsvali;
				},
				success: function(result){
					var rs = $.trim(result);
					if (rs > 0){
							$('#resourcesDkfm').form('clear');
							$('#resourcesFhfm').form('clear');
							$('#resourcesDxIpfm').form('clear');
							$('#resourcesUnIpfm').form('clear');
							$.messager.show({
								title: '提 示',
								msg: '已成功增加资源！'
							});
							$('#addResourcesDkid').hide();
							$('#addResourcesFhid').hide();
							$('#addResourcesDxIPid').hide();
							$('#addResourcesUnIPid').hide();
							reloadMyCabData ();
							queryRes (resType);
							showResDetails();
							reloadMacOfCabData()
					} else if(rs=='-1'){
						$.messager.alert("提示","输入IP值有误！");
						return;
					}else {
						$.messager.show({
							title: 'Error',
							msg: '资源信息错误，请联系管理员！'
						});
					}
				}
			});
		}
	});
}
//资源管理
function tabChange2Resources (checkStatu,liidparm){
  //改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#resourcesTabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	$('#addResourcesDkid').hide();
	$('#addResourcesFhid').hide();
	$('#addResourcesDxIPid').hide();
	$('#addResourcesUnIPid').hide();
	if (!checkStatu || checkStatu == '1') {
		resType = 1;
		queryRes (resType);
		$("#dkResources").show();
		$("#fhResources").hide();
		$("#resourcesIPid").hide();
	} else if(!checkStatu || checkStatu == '2'){
		resType = 2;
		queryRes (resType);
		$("#dkResources").hide();
		$("#fhResources").show();
		$("#resourcesIPid").hide();
	} else if(!checkStatu || checkStatu == '3'){
		resType=3;
		queryRes (3);
		queryRes (4);
		$("#dkResources").hide();
		$("#fhResources").hide();
		$("#resourcesIPid").show();
	}
}
function showAddResources (addResType){
	//初始化
	$("#resourcesbeginTimeiddk").datebox("setValue",myDateformatter(new Date()));
	$("#resourcesdkid").val('');
	$("#resourcespriceValiddk").val('');
	$("#resourcesrenscdk").val('');
	$("#resNoteId").val('');
	$("#resourcesfhid").val('');
	
	searchMac (bizid);
	if(addResType=='dk'){
		$("#addResourcesDkid").toggle(500);
		//$('#addResourcesDkid').show();
		$('#addResCabinetidDk').val(res_cabinetid);
	}else if(addResType=='fh'){
		$("#resourcesbeginTimeidfh").datebox("setValue",myDateformatter(new Date()));
		$("#addResourcesFhid").toggle(500);
		//$('#addResourcesFhid').show();
	}else if(addResType=='dxip'){
		resTypeIp = addResType;
		resType='3';
		$("#resourcesbeginTimeiddxip").datebox("setValue",myDateformatter(new Date()));
		 $("#addResMaciddxIp").combobox({
			 onChange: function (n,o) {
			 checkMacIp ("#addResMaciddxIp",addResType)
			 }
			 });
		 $("#addResourcesDxIPid").toggle(500);
		//$('#addResourcesDxIPid').show();
		$('#addResourcesUnIPid').hide(500);
		
	}else if(addResType=='unicomip'){
		resTypeIp = addResType;
		resType='4';
		$("#resourcesbeginTimeidunip").datebox("setValue",myDateformatter(new Date()));
		 $("#addResMacidunIp").combobox({
			 onChange: function (n,o) {
			 checkMacIp ("#addResMacidunIp",addResType)
			 }
			 });
		 $("#addResourcesUnIPid").toggle(500);
		 $('#addResourcesDxIPid').hide(500);
		//$('#addResourcesUnIPid').show();
	}
}

//机器编号获取
function searchMac (bizid) {
	var url = "/customerMan/searchMac.action";	
	var params = {"busid":bizid,"cabinet":res_cabinetid,"cusid":currClickCusid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = eval(rs);
		if (rs) {
			if(resType=='1'){
				$("#addResMacidDk").combobox('loadData',jsondata);
			}else if (resType=='2'){
				$("#addResMacidFh").combobox('loadData',jsondata);
			}else if (resType=='3' ){
				$("#addResMaciddxIp").combobox('loadData',jsondata);
			}else if (resType=='4' ){
				$("#addResMacidunIp").combobox('loadData',jsondata);
			}
		}
  	});
}
//获取选中机器的信息
function checkMacIp (id,resType) {
	var cusbizid = $(id).combobox('getValue');
		if (cusbizid) {
			var url = '/customerMan/checkResMacIp.action';
			var params = {"id":cusbizid};
			$.post(url,params,function(result){
				var jsondata=JSON.parse(result);
				if (jsondata){
					if(resType=='dxip'){
						dxipFormat=jsondata.dxip;
						loadIps("dxip");
					}else{
						dxipFormat=jsondata.unicomip;
						loadIps("unicomip");
					}
				} else {
				//	$("#cabMes").html("");
					//cabIdVali = false;
				}
			});
		} 
}


//为资源付款
function payBizRes () {
	if (currRowObjJson) {
		if (currRowObjJson.paystatus == 0) {
			var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
			var canPayTotal;
			var num;
				$.ajax({
					url : '/customerMan/queryBalanceAndCredit.action',
					dataType : 'json',
					type : 'post',
					async: false,//使用同步的方式,true为异步方式
					data : {'custid':currRowObjJson.customerid},//这里使用json对象
					success : function(data){
						canPayTotal = parseFloat(data.accbal) + parseFloat(data.creded);
					},
					fail:function(){
						$.messager.alert("错误","与服务器数据交换出错！");
					}
					});
			var str = '';
			if(danjiZhenggui=='0' && currRowObjJson.type == 1){
				str += "机柜编号:"
				num = currRowObjJson.cabinet;
			}else{
				str += "机器编号:"
				num = currRowObjJson.macnum;
			}
			if (payTotal > canPayTotal || isNaN(canPayTotal)) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				return;
			}
				resType=currRowObjJson.type;
				var resString;
			switch(parseInt(resType)){
			case 1:
				resString = "带宽";
				break;
			case 2:
				resString = "防护";
				break;
			case 3:
				resString = "电信IP";
				break;
			case 4:
				resString = "联通IP";
				break;
			}
			str += "<span style='color:red;font-size:14px;'>" + num + "</span><br><br>" +
				"<span style='margin-left:40px;color:red;font-size:14px;'>缴费总额: " + payTotal +"元 </span><br><br>" +
				"<span style='margin-left:40px;'>确定为"+"<span style='color:red;font-size:14px;'>"+resString+"资源</span>"+"进行付款吗？</span><br><br>";
			$.messager.confirm('资源付款',str,function(r){
				if (r){
					var url = "/customerMan/payMenoyRes.action";
					//var url="";
					var params = {"cusid":currClickCusid,"payTotal":payTotal,"resourcesid":currRowObjJson.id,"renpayid":currRowObjJson.renpayid,"resType":resType,"maid":currMasterid,"paytype":"payres","id":currRowObjJson.id};
					$.post(url,params,function(result){
						var rs = $.trim(result);
						if (rs > 0) {
							//刷新当前客户余额
							queryBalance();
							//刷新当前表的数据 
							if(payMark=='danjiRes'){
								//当前刷新的是单机资源表
								queryDangJiRes (resType);
							}else{
								//当前刷新的是机柜资源
								queryRes (resType);
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
		} else {
			$.messager.alert("提示","此资源已付款！")
		}
	} 
}
//资源续费
var resrprice = undefined;
//currbizPayStatus记录当前业务单的付款状态，当业务单处理未付款状态时，不能再继续续费，只能修改价格。
var rescurrbizPayStatus = undefined;
function goOnRenewalRes() {
	var cusTruename;
	if (currRowObjJson) {
			$.ajax({
				url : '/customerMan/queryBalanceAndCredit.action',
				dataType : 'json',
				type : 'post',
				async: false,//使用同步的方式,true为异步方式
				data : {'custid':currRowObjJson.customerid},//这里使用json对象
				success : function(data){
					cusTruename = data.custruename;
				},
				fail:function(){
					$.messager.alert("错误","与服务器数据交换出错！");
				}
				});
		rescurrbizPayStatus = currRowObjJson.paystatus;
		$('#resgoOnRenewalid').dialog('open').dialog('setTitle','续 费');
		$("#resrCusTrueNameid").html(cusTruename);
		//$("#rescabinetid").val(currRowObjJson.cabinetid);
		//$("#cabrrenscid").val(currRowObjJson.rensc);
		$("#resrpriceid").val(currRowObjJson.renprice);
		resrprice = currRowObjJson.renprice;
		$("#resrrenbegintimeid").val(currRowObjJson.renbegintime);
		$("#resMacnumid").val(currRowObjJson.macnum);
		$("#resrrenendtimeid").val(currRowObjJson.renendtime);
		$("#resid").val(currRowObjJson.id);
		$("#res_mrcusid").val(currRowObjJson.customerid);
	}
}

//修改资源价格
var oldpriceValRes= undefined;
function changePriceRes(inputPriceid,textid) {
	textid = "#" + textid;
	inputPriceid = "#" + inputPriceid;
	var ahtml = $(textid).html();
	
	if (ahtml == '[修改价格]') {
		$(textid).html('[取消修改]');
		$(inputPriceid).attr("disabled",false);
		oldpriceValRes = $(inputPriceid).val();
	} else if (ahtml == '[取消修改]') {
		$(textid).html('[修改价格]');
		$(inputPriceid).attr("disabled","disabled");
		$(inputPriceid).val(oldpriceValRes);
	}
}

//动态显示价格
function formatPriceRes (value) {
	var rpriceid = $("#resrpriceid").val();
	if (rpriceid) {
		return value+"月"+(rpriceid*value)+" 元";
	}
}

//资源提交续费
function ressubRenewal () {
	var addsc = $('#resaddrenscid').slider('getValue');
	var newPrice = $("#resrpriceid").val();
	//如果当前业务单在未付款的情况下，不能继续操作续费功能
	if (rescurrbizPayStatus == 0 ) {
		$.messager.alert("提示","当前为未付款状态，不能操作续费，请先操作付款当前资源");
		return;
	}

/*	//判断子IP类型
	 if(currRowObjJson.dxip !=undefined){
			resType=3;
		}else if(currRowObjJson.unip !=undefined){
			resType=4;
		}*/
	if( isNaN(parseInt(currRowObjJson.type))){
		$.messager.alert("提示","数据异常！");
		return;
	}
	resType=currRowObjJson.type;
	//如果没有修改价格，也没有选择续费时长，则做出提示，方法停止。
	if ((!oldpriceValRes && addsc == 0) || (oldpriceValRes==newPrice && addsc == 0)) {
		$.messager.alert("提示","请修改价格或者续费时长！");
		return;
	}
	var str;
	if(!currRowObjJson.macnum){
		str = '确定要续费机柜编号为【'+currRowObjJson.cabinet+'】的资源吗？';
		if (addsc == 0) {
			str = '确定要修改机柜编号为【'+currRowObjJson.cabinet+'】资源的价格吗？';
		}
	}else{
		str = '确定要续费主机编号为【'+currRowObjJson.macnum+'】的资源吗？';
		if (addsc == 0) {
			str = '确定要修改主机编号为【'+currRowObjJson.macnum+'】资源的价格吗？';
		}
	}
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var renbegintime = $("#resrrenendtimeid").val();
			var resourcesid = $("#resid").val();//资源记录的id
			var renprice = $("#resrpriceid").val();
			var rnote = $("#resrnoteid").val();
			rnote = $.trim(rnote);
			var url = "/customerMan/subRenewalRes.action";
			var params = {"addsc":addsc,"begintime":renbegintime,"id":resourcesid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"resType":resType,"renpayid":currRowObjJson.renpayid,"goflow":"","maid":currMasterid,"paytype":"renewres","paystatus":1};
			//payTot 目前续费总共要支付的费用
			var payTot = undefined;
			//如果点击过修改价格，则要跑审核流程；否则就直接续费
			if (oldpriceValRes) {
				if (renprice != oldpriceValRes) {
					//确实修改价格,跑流程所需要的参与不同，所有要重新定义params.     "cabinetid":cabinetid,
					params = {"oldpriceVal":oldpriceValRes,"addsc":addsc,"begintime":renbegintime,"resourcesid":resourcesid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"goflow":"goflow","resType":resType,"renpayid":currRowObjJson.renpayid};
					payTot = renprice * addsc;
					
				} else {
					//点击过修改价格后，又取消了，所以要记录原来的价格去计算
					payTot = oldpriceValRes * addsc;
				}
			} else {
				payTot = renprice * addsc;
			}
			//余额加信用度不够支付
			var canPay = parseInt($("#balanceValid").val()) + parseInt($("#credeValid").val());
			if (payTot > canPay) {
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				$('#resaddrenscid').slider('setValue',0);
				return;
			}
			
			//提交
			$.post(url,params,function(result){
				var rs = $.trim(result);
				if (rs > 0) {
					if (rs == 3) {
						$.messager.show({
							title: '提 示',
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
					$('#resaddrenscid').slider('setValue',0);
					$('#resaupdatePriceid2').html('[修改价格]');
					$('#resrpriceid').attr("disabled","disabled");
					$('#resgoOnRenewalid').dialog('close');
					//清空oldpriceValRes值
					oldpriceValRes=undefined;
					//刷新当前资源表
					if(payMark=='danjiRes'){
						//当前刷新的是单机资源表
						queryDangJiRes (resType);
					}else{
						//当前刷新的是机柜资源
						queryRes (resType);
					}
					//刷新当前客户余额
					queryBalance();
					//刷新当前表的数据
					reloadMyCabData();
					reloadMyCurrCusData ();
					//reloadMyCurrCusData($("#rcusid").val());
					
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

//------------------------------机柜下机器资源查看------------------------------
var macResType='1';
var bizcabid = ''//机柜业务编号ID
var bizmacid = '';//机器业务编号id
function macResDetail	() {
	bizcabid = $("#bizcabid").val();
	bizmacid = currRowObjJson.id
	 tabChange2MacRes ('1','macdktab1');
	/*if(macResType=='1'){
		$("#macfhResources").hide();
		$("#macresourcesIPid").hide();
	}*/
	queryMacRes (macResType);
	$('#macResDetailid').dialog('open').dialog('setTitle','机器'+currRowObjJson.macnum+'资源详情');
}
function tabChange2MacRes (checkStatu,liidparm){
  //改变当前选中的tab头部
	var liid = "#" + liidparm;
	$("#macResourcesTabulid li").each (function(){
		$(this).removeClass("active");
	});
	$(liid).addClass("active");
	if (!checkStatu || checkStatu == '1') {
		macResType = 1;
		queryMacRes (macResType);
		$("#macdkResources").show();
		$("#macfhResources").hide();
		$("#macresourcesIPid").hide();
	} else if(!checkStatu || checkStatu == '2'){
		macResType = 2;
		queryMacRes (macResType);
		$("#macdkResources").hide();
		$("#macfhResources").show();
		$("#macresourcesIPid").hide();
	} else if(!checkStatu || checkStatu == '3'){
		macResType=3;
		queryMacRes (3);
		queryMacRes (4);
		$("#macdkResources").hide();
		$("#macfhResources").hide();
		$("#macresourcesIPid").show();
	}
}
//查询机器中的资源情况
function  queryMacRes (resType){
	var url = "/customerMan/queryResources.action?id="+bizcabid+"&type="+resType+"&bizmacid="+bizmacid+"&macres="+"macres";
	var params = {"cusid":currClickCusid};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				var dataFiles = "";
				var showTableId = "";
				//1:带宽 	2：防护		3：子IP
				if(resType=='1'){
					//表头
					dataFiles = [ "cabinet","dk","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","resourseIPhasNoSubIP"] ];
					showTableId = "#macdkResources";
					$("#dkcabinetMacResListsidFootid").show();
				}else if(resType=='2'){
					dataFiles = [ "macnum","fh","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","resourseIPhasNoSubIP"] ];
					showTableId = "#macfhResources";
					$("#fhcabinetMacResListsidFootid").show();
				}else if(resType=='3'){
					dataFiles = [ "macnum","dxip","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","resourseIPhasNoSubIP"] ];
					showTableId = "#macdxipResources";
					$("#dxipcabinetMacResListsidFootid").show();
				}else if(resType=='4'){
					dataFiles = [ "macnum","unip","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","resourseIPhasNoSubIP"] ];
					showTableId = "#macunipResources";
					$("#dxipcabinetMacResListsidFootid").show();
				}
				//var clickbutton = {"aMethod":"goOnRenewalRes-续费-goOnRenewalRes,payBizRes-付款-payBizRes"};
				var clickbutton = "";
				//格式化字段
				var formatFileds = {"paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":url};
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}
//----------------------------单机资源管理--------------------------------------------
//var macBizResType='1';
//var resType='1';
var cusMacid='';
var addMacRes ='';
var payMark ='';
function macResoucesMan (){
	if($("div[name='layout']").length!=2){
		var layout = $("div[name='layout']");
		layout[0].remove();
		layout[1].remove();
	}
	res_cabinetid='';
	payMark='danjiRes';
	//赋值给全局变量初始化数据
	cusMacid=currRowObjJson.id;
	addMacRes=currRowObjJson.macnum;
	dxipFormat = currRowObjJson.dxip;
	unipFormat = currRowObjJson.unicomip;
	$("#resMacComproomid").val(currRowObjJson.comproomid)
	queryMacResDetail();
	tabChangeMacRes ('1','dktabm');
	resType='1';
	//queryDangJiRes (resType);
	/*if(resType=='1'){
		$("#fhMacResources").hide();
		$("#macResourcesIPid").hide();
	}*/
	$('#macResourcesManageid').dialog('open').dialog('setTitle','单机资源管理');
}

function  queryMacResDetail( ){
	var url = '/customerMan/queryMacResDetail.action';
	var params = {"id":cusMacid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			$("#maczongdk").html(jsondata.zongdk);
			$("#maczongfh").html(jsondata.zongfh);
			$("#macdxziip").html(jsondata.dxipsCounts);
			$("#macunziip").html(jsondata.unipsCounts);
			}
  		});
}

function tabChangeMacRes (checkStatu,liidparm){
	
	  //改变当前选中的tab头部
		var liid = "#" + liidparm;
		$("#macResourcesTabulid li").each (function(){
			$(this).removeClass("active");
		});
		$(liid).addClass("active");
		
		$('#addMacResourcesDkid').hide();
		$('#addMacResourcesFhid').hide();
		$('#addMacResourcesDxIPid').hide();
		$('#addMacResourcesUnIPid').hide();
		if (!checkStatu || checkStatu == '1') {
			resType = 1;
			queryDangJiRes (resType);
			$("#dkMacResources").show();
			$("#fhMacResources").hide();
			$("#macResourcesIPid").hide();
		} else if(!checkStatu || checkStatu == '2'){
			resType = 2;
			queryDangJiRes (resType);
			$("#dkMacResources").hide();
			$("#fhMacResources").show();
			$("#macResourcesIPid").hide();
		} else if(!checkStatu || checkStatu == '3'){
			resType=3;
			queryDangJiRes (3);
			queryDangJiRes (4);
			$("#dkMacResources").hide();
			$("#fhMacResources").hide();
			$("#macResourcesIPid").show();
		}
	}
function  queryDangJiRes (resType){
	var currPageShowTableId ="";
	if(resType=="1"){
		currPageShowTableId = "#dkMacResources";
	}else if(resType=="2"){
		currPageShowTableId = "#fhMacResources";
	}else if(resType=="3"){
		currPageShowTableId = "#dxipMacResources";
	}else if(resType=="4"){
		currPageShowTableId = "#unipMacResources";
	}
	var currPage = $(currPageShowTableId+" #currPage").html().substring(3,$(currPageShowTableId+" #currPage").html().length-1);
	//var url = "/customerMan/queryResources.action?type="+resType+"&cusbizid="+cusMacid+"&macbiz="+"macbiz";
	var url = "/customerMan/queryResInfoByMacNum.action";
	//var params = {"cusid":currClickCusid};
	var params = {'type':resType,'macnum':currRowObjJson.macnum,"currPage": currPage};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				var dataFiles = "";
				var showTableId = "";
				//1:带宽 	2：防护 3：子IP
				if(resType=='1'){
					//表头
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "customerid","id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP"] ];
					showTableId = "#dkMacResources";
					$("#dkcabinetMacBizResListsidFootid").show();
				}else if(resType=='2'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "customerid","id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP"] ];
					showTableId = "#fhMacResources";
					$("#fhcabinetMacBizResListsidFootid").show();
				}else if(resType=='3'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "customerid","id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP"] ];
					showTableId = "#dxipMacResources";
					$("#dxipcabinetMacBizResListsidFootid").show();
				}else if(resType=='4'){
					dataFiles = [ "macnum","res","renprice","renbegintime", "renendtime","rensc","bydate","lssc","paystatus","renote", [ "customerid","id","bizid","cusbizid","cusname","custruename","paytotal","accbal","creded","renpayid","type","resourseIPhasNoSubIP"] ];
					showTableId = "#unipMacResources";
					$("#unipcabinetMacBizResListsidFootid").show();
				}
				var clickbutton ='';
					if(deptid=='2' || deptid ==12|| deptid ==16){
						//deptid=2，业务部
						clickbutton = {"aMethod":"goOnRenewalRes-续费-goOnRenewalRes,payBizRes-付款-payBizRes"};
					}else if((resType=='3' || resType=='4') && deptid=='4'){
						//deptid=4， 综合部
						clickbutton = {"aMethod":"deleteIP-下架-deleteIP,xgResources-直接修改-xgResources"};
					} else if ((resType=='1' || resType=='2') && deptid=='4'){
						clickbutton = {"aMethod":"xjResources-下架-xjResources,xgResources-直接修改-xgResources"};
					} else{
						clickbutton={};
					}
				//格式化字段
				var formatFileds = {"paystatus":"0-未付款,1-已付款,2-过期未续费"};
				//分页配置
				var pageEvent = {"action":url+'?type='+resType+'&macnum='+currRowObjJson.macnum};
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}
//资源修改按钮
function xgResources(){
	$('#updateResourcesInfo').dialog('open').dialog('setTitle','修改单机资源信息');	
	/*$("#updaterensc").val(currRowObjJson.rensc);
	alert(currRowObjJson.rensc);*/
	$("#updatejg").val(currRowObjJson.renprice);
}
//修改资源价格
function updateResourcesInfo(){
	var renprice=$("#updatejg").val();
	var id=currRowObjJson.renpayid;
	var url="/customerMan/updateResourcesInfo.action";
	var params={'id':id,'renprice':renprice};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs) {
			queryDangJiRes (currRowObjJson.type);
			$.messager.show({
				title: '提 示',
				msg: '已成功修改资源价格！'
			});
			$('#updateResourcesInfo').dialog('close');
			}
  		});
}
//资源增加按钮
function showAddMacResources (addResType){
	if(addResType=='dk'){
		$("#macResourcesbeginTimeiddk").datebox("setValue",myDateformatter(new Date()));
		$('#addMacResiddk').val( addMacRes);
		$("#addMacResourcesDkid").toggle(500);
		//$('#addMacResourcesDkid').show();
	}else if(addResType=='fh'){
		$("#macResourcesbeginTimeidfh").datebox("setValue",myDateformatter(new Date()));
		$('#addMacResidfh').val( addMacRes);
		$("#addMacResourcesFhid").toggle(500);
		//$('#addMacResourcesFhid').show();
	}else if(addResType=='dxip'){
		resTypeIp = addResType;
		resType='3';
		$("#macResourcesbeginTimeiddxip").datebox("setValue",myDateformatter(new Date()));
		$('#addMacResiddxip').val( addMacRes);
		loadIps("dxip");
		$("#addMacResourcesDxIPid").toggle(500);
		//$('#addMacResourcesDxIPid').show();
		$('#addMacResourcesUnIPid').hide(500);
		
	}else if(addResType=='unicomip'){
		resTypeIp = addResType;
		resType='4';
		$("#macResourcesbeginTimeidunip").datebox("setValue",myDateformatter(new Date()));
		$('#addMacResidunip').val( addMacRes);
		loadIps("unicomip");
		$("#addMacResourcesUnIPid").toggle(500);
		$('#addMacResourcesDxIPid').hide(500);
		//$('#addMacResourcesUnIPid').show();
	}
}

//资源管理提交修改
function updateMacResourcesAdd () {
	var form='';
	var ziIPid= '';
	var ziIp = '';
	var str ='';
	if(resType=='1'){
		form = "macResourcesDkfm";
		str = '确定要为编号为【'+addMacRes+'】的机器增加带宽吗？';
	}else if(resType=='2'){
		form = "macResourcesFhfm";
		str = '确定要为编号为【'+addMacRes+'】的机器增加防护吗？';
	}else if(resType=='3'){
		//子IP
		ziIp = $('#macResadddxipid').combobox('getText'); 
		ziIPid = $('#macResadddxipid').combobox('getValue');
		form = "macResourcesDxIpfm";
		str = '确定要为编号为【'+addMacRes+'】的机器添加电信IP吗？';
	}else if(resType=='4'){
		ziIp = $('#macResddunicomipid').combobox('getText'); 
		ziIPid = $('#macResddunicomipid').combobox('getValue');
		form = "macResourcesUnIpfm";
		str = '确定要为编号为【'+addMacRes+'】的机器添加联通IP吗？';
	}
	
	//var id = "";//机柜业务ID
	//机器业务ID
	if (!cusMacid) {
		$.messager.alert('Errors','错误代码：subUpdateBizInfo,获取业务单信息失败，请联系管理员');
		return;
	}
	var url = "/customerMan/addMacResourcesManage.action?cusbizid="+cusMacid+"&resType="+resType+"&resTypeIp="+resTypeIp+"&ziIPid="+ziIPid/*+"&ziIp="+ziIp*/+"&zhuip="+dxipFormat+"&maid="+currMasterid+"&cusid="+currClickCusid;
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			if(resType=='3'||resType=='4'){
				var reg = /\d+\.\d+\.\d+\.\d+/g; 
				if(ziIPid=='' || !reg.test(ziIPid)){
					$.messager.alert("提示","子IP值有误！");
					return;
				}else{
					var ipvali = false;
					var comproom = $("#resMacComproomid").val();
					if(resType=='3'){
						ipvali = resCheckIpComproom("dxip",ziIPid,comproom);
					}else if(resType=='4'){
						ipvali = resCheckIpComproom("unip",ziIPid,comproom);
					}
					if(!ipvali){
						return;
					}
				}
			}
			$('#'+form).form('submit',{
				url: url,
				onSubmit: function(){
					//所有验证通过
					var rsvali = false;
					var vali1 = $(this).form('validate');
					if (vali1 == true ) {
						rsvali = true;
					}
					return rsvali;
				},
				success: function(result){
					var rs = $.trim(result);
					if (rs > 0){
							$('#macResourcesDkfm').form('clear');
							$('#macResourcesFhfm').form('clear');
							$('#macResourcesDxIpfm').form('clear');
							$('#macResourcesUnIpfm').form('clear');
							$('#addMacResourcesDkid').hide();
							$('#addMacResourcesFhid').hide();
							$('#addMacResourcesDxIPid').hide();
							$('#addMacResourcesUnIPid').hide();
							$.messager.show({
								title: '提 示',
								msg: '已成功增加资源！'
							});
							reloadMyCurrCusData ();
							queryDangJiRes (resType);
							queryMacResDetail();
					} else if(rs=='-1'){
						$.messager.alert("提示","输入IP值有误！");
						return;
					}else {
						$.messager.show({
							title: 'Error',
							msg: '资源信息错误，请联系管理员！'
						});
					}
				}
			});
		}
	});
}
/**
 * 检测IP是否存在以及是否合法
 * *//*
function checkIp (zhuIp,addip) {
	var url = '/customerMan/checkIp.action';
	var params = {"zhuIp":zhuIp,"addip":addip};
	var rs='0';
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				alert(result.id+"-----------")
				alert(result.ip)
			}else{
				$.messager.alert("提示","输入IP值有误！");
				return ;
			}
        }
	});
}*/


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
			$("#comproomids").combobox('loadData',jsondata);
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
					$("#addcabinetid").combobox('loadData',jsondata);
				} 
			});
		} 
}


/**
 * 资源管理删除副IP功能
 */
function deleteIP (){
	
	var reason = dotran($("#resReason").val());
//	if(!reason){
//		checkImgShow("#resReasonMes",-1,'必填');
//		return;
//	}else{
//		checkImgShow("#resReasonMes",2);
//	}
	
	
	var str='';
		if (currRowObjJson.type=='3'){
			str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
			"电信副IP:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span>  删除吗？";
		}else if(currRowObjJson.type=='4'){
			str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
			"联通副IP:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span>  删除吗？";
		}
	
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var shelvesOperatorId = currMasterid;
			var url = "/customerMan/deleteIP.action";
			var params;
				params = {"resourcesid":currRowObjJson.id,"dxip":currRowObjJson.res,"unip":currRowObjJson.res,"type":currRowObjJson.type,"cusbizid":currRowObjJson.cusbizid,"renpayid":currRowObjJson.renpayid,"maid":currMasterid,"shelvesOperatorId":shelvesOperatorId,"reason":reason};
			$.post(url,params,function(result){
				var rs = $.trim(result);
				$("#xjResWindow").dialog('close');
				$("#resReason").val('');				
				if (rs > 0) {
					if(danjiZhenggui=='-1'){
						//刷新单机列表
						queryDangJiRes (currRowObjJson.type);//刷新单机IP资源列表
						queryMacResDetail();//刷新资源情况
						reloadMyCurrCusData ( );//刷新单机机器列表
					}else {
						//刷新整柜列表
						queryRes (currRowObjJson.type);//刷新整柜IP资源列表
						showResDetails();//刷新资源情况
						reloadMacOfCabData()//机柜机器列表
					}
					$.messager.show({
						title: '提 示',
						msg: '删除成功！'
					});
				} else {
					 $.messager.alert("操作提示", "删除失败！","error"); 
				}
			 	});
		}
	});
} 
 
/**
 * 资源下架
 * */
function xjResources ( ) {
	
	var reason = dotran($("#resReason2").val());
//	if(!reason){
//		checkImgShow("#resReasonMes2",-1,'必填');
//		return;
//	}else{
//		checkImgShow("#resReasonMes2",2);
//	}
	

	var str='';
	if(danjiZhenggui=='-1'){
		if (currRowObjJson.type=='1'){
			str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
			"带宽资源:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span>M  下架吗？";
		}else if(currRowObjJson.type=='2'){
			str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
			"防护资源:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span> G 下架吗？";
		}
	}else{
		if (currRowObjJson.type=='1'){
			str = "确定要把机柜编号为【"+currRowObjJson.cabinet+"】的<br>"+
			"带宽资源:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span>M  下架吗？";
		}else if(currRowObjJson.type=='2'){
			str = "确定要把主机编号为【"+currRowObjJson.macnum+"】的<br>"+
			"防护资源:<span style='color:red;font-size:14px;'> " + currRowObjJson.res +" </span> G 下架吗？";
		}
	}
	
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var shelvesOperatorId = currMasterid;
			var url = "/customerMan/xjResources.action";
			var params = {"id":currRowObjJson.id,"danjiZhenggui":danjiZhenggui,"bizid":currRowObjJson.bizid,"cusbizid":currRowObjJson.cusbizid,"dk":currRowObjJson.res,"fh":currRowObjJson.res,"type":currRowObjJson.type,"reason":reason,"shelvesOperatorId":shelvesOperatorId};
			
			$.post(url,params,function(result){
				$('#xjResWindow2').dialog('close');
				$('#resReason2').val('')
				var rs = $.trim(result);
				if (rs > 0) {
					if(danjiZhenggui=='-1'){
						//刷新单机列表
						queryDangJiRes (currRowObjJson.type);//刷新单机资源列表
						queryMacResDetail();//刷新资源情况
						reloadMyCurrCusData ( );//刷新单机机器列表
					}else {
						//刷新整柜列表
						queryRes (currRowObjJson.type);//刷新整柜资源列表
						reloadMyCabData ()//刷新机柜列表
						showResDetails();//刷新资源情况
						reloadMacOfCabData()//机柜机器列表
					}
					$.messager.show({
						title: '提 示',
						msg: '资源下架成功！'
					});
				} else {
					 $.messager.alert("操作提示", "资源下架失败！","error"); 
				}
			 	});
		}
	});
	
}
/**
 * 添加一台租用机器，获取机器列表中的获取机房搜索
 */
function loadCompRoomByOneMac (){
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	var rs = "";
	var sladdcab=$("#inputSearchOneMacRoomid");
	var colladdcab = $("#inputSearchCollRoomid");
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
					sladdcab.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
					colladdcab.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
				}
			}
		}
	});
}


//返回客户信息列表
function backedToCustomer () {
	var params = "";
	url = '/customerMan/queryMycustomer.action';
	$.post(url,params,function(result){
		afterLoadUI("#bgcenterid",result);
		MoveRunningDiv();
	});
}

/**
 * 子IP所在机房与选择的机房是否匹配
 * 
 * @iptype ip类型（dxip，unip）
 * @ipValid ip文本框的id，用了获取ip 的值
 * @comproom 选择的机房id
 * 
 * */
function resCheckIpComproom (iptype,ipVal,comproom) {
	var url = '/customerMan/checkIpComproom.action';
	var params = {"iptype":iptype,"ipVal":ipVal,"comproom":comproom};
	var ipvali = false;
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "POST",
		dataType : 'json',
		success : function (result){
			var rs = $.trim(result);
			if(rs== 0 ){
				if(iptype=='unip') {
					$.messager.alert("提示","子IP所属机房与选择的机房不相符");
					ipvali= false;
				}else if (iptype == 'dxip') {
					$.messager.alert("提示","子IP所属机房与选择的机房不相符");
					 ipvali= false;
				}
			}else{
				ipvali =true;
			}
		}
	});
	return ipvali;
}

function checkall(tab){
   var hobbys = $(tab+" #payment");
   var ids = [];
     for(var i=0;i<hobbys.length;i++){
       hobbys[i].checked="true";
   }
}

function notcheckall(tab){
   var hobbys = $(tab+" #payment");
    for(var i=0;i<hobbys.length;i++){
       hobbys[i].checked="";
   }
}
function batchpayment(tab){
   var hobbys = $(tab+" #payment");
   var sum = parseInt(0);
   var resourcesids = "{";
   var renpayids = "{";
   var expenses = "{";
   var object1 = "";
   var object2 = "";
   var object3 = "";
   if($("input[type='checkbox']").is(':checked')){
       for(var i=0;i<hobbys.length;i++){
    	   if(hobbys[i].checked){
    		  myDataRow(hobbys[i].value,tab);
	 		  if(currRowObjJson.paystatus != 0){
	 			 $.messager.alert("提示","编号："+currRowObjJson.macnum+"机器已付款！")
	 			 return;
	 		  }
	 		 object1 = object1+"'"+i+"':'"+currRowObjJson.id+"'";
	 		 object2 = object2+"'"+i+"':'"+currRowObjJson.renpayid+"'";

	 		  var payTotal = parseFloat(currRowObjJson.renprice) * parseInt(currRowObjJson.rensc);
	 		  object3 = object3+"'"+i+"'"+":'"+payTotal+"'";
	 		  sum = parseInt(sum) + parseInt(payTotal);
	 		 
	 		 if(i < hobbys.length-1){
	 			object1 += ",";
	 			object2 += ",";
	 			object3 += ",";
	 		 }
	 		 
    	   }
 		  
 	   }
       resourcesids += object1 + "}";
       renpayids　+=　object2 + "}";
       expenses += object3 + "}";     
       var canPayTotal = parseFloat(currRowObjJson.accbal) + parseFloat(currRowObjJson.creded);
       if (sum > canPayTotal) {
			$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
			return;
	   }
       var str = "批量缴费总额:<span style='color:red;font-size:14px;'> " + sum +"元 </span><br><br>" +
		"<span style='margin-left:40px;'>确定为服务器进行付款吗？</span><br><br>";
       $.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerMan/batchPayMoneyRes.action";
				var params = {"cusid":currClickCusid,"payTotal":sum,"expenses":expenses,"resourcesids":resourcesids,"renpayids":renpayids,"resType":resType,"maid":currMasterid,"paytype":"payres"};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					if (rs > 0) {
						//刷新当前客户余额
						queryBalance();
						//刷新当前表的数据 
						if(payMark=='danjiRes'){
							//当前刷新的是单机资源表
							queryDangJiRes (resType);
						}else{
							//当前刷新的是机柜资源
							queryRes (resType);
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
   }else{
	   $.messager.alert("提示","无选中项")
   }
   
}

/**
 * 打开机器修改备注弹窗
 * 初始化窗口信息
 * @author QF
 * */
var updateMacNote_bizid='';
function updateCusMacNote(){
	updateMacNote_bizid = currRowObjJson.id;
	$("#addmacnum").val(currRowObjJson.macnum);
	$("#addProNumid").val(currRowObjJson.proNum);
	$("#cabinetId").val(currRowObjJson.cabinet);
	$("#comproomnameforNoteid").val(currRowObjJson.comproomname);
	$("#ubizNoteid").val(mydecode(mydecode(currRowObjJson.cbNote)));
	$('#editCusMac').dialog('open').dialog('setTitle','服务器备注修改');
}


/**
 * 修改机器备注信息保存提交
 * @author QF
 * */
function saveMacNote(){
	var id = updateMacNote_bizid;
	var bizNote = $("#ubizNoteid").val();
	var proNum = $("#addProNumid").val();
	var str = "修改机器信息操作，确定？";
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var url = "/customerMan/updateBizInfo.action";
			var params = {"id":id,"note":bizNote,"proNum":proNum};
			queryInfo (url,params,"修改失败，请联系管理员");
			$('#editCusMac').dialog('close');
	    	if(danjiZhenggui=='-1'){
	    		//单机中的机器列表
	    		reloadMyCurrCusData(currRowObjJson.customerid);
	    	}else {
	    		//整柜中的机器列表
	    		reloadMacOfCabData();
	    	}		
		}
	});
}

function manualConsume(){
	//先清空
	$("#consumetypeid").html("");
	$("#manConMacid").html("");
	$("#manConpriceid").val("");
	$("#manConNoteid").val("");
	getconsumeTypes ();//再获取KV表中消费类型
	getManConMacNum (currClickCusid);//再获取客户名下机器的编号信息
	$("#manConCusNameid").html(custmoerName);
	$('#manualConsumeForm').dialog('open').dialog('setTitle','手动消费');
}
/**
 * 获取客户名下机器的编号信息
 */
function getManConMacNum(cusid){
	var url = '/customerMan/getManConMacNum.action';
	var params = {"cusid":cusid};
	var rs = "";
	var sladdcab=$("#manConMacid");
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				sladdcab.append("<option value=''>---请选择---</option>");
				for(var i = 0 ; i < result.length; i++){
					var id = result[i]["id"];
					var macnum =result[i]["macnum"];
					sladdcab.append("<option value='"+id+"'>"+macnum+"</option>");
				}
			}
		}
	});
}


/**
 * 获取KV表中消费类型数据（关联值：other_expense）
 */
function getconsumeTypes (){
	var url = '/customerMan/getconsumeTypes.action';
	var params = {};
	var rs = "";
	var sladdcab=$("#consumetypeid");
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				sladdcab.append("<option value=''>---请选择---</option>");
				for(var i = 0 ; i < result.length; i++){
					var key = result[i]["key"];
					var value =result[i]["value"];
					if(key ==4 || key ==3 ){
						continue;
					}
					sladdcab.append("<option value='"+key+"'>"+value+"</option>");
				}
			}
		}
	});
}

/**
 * 获取KV表中业务类型数据（关联值：business_type） 
 */
function getbusinessTypes (){
	var url = '/customerMan/getbusinessTypes.action';
	var params = {};
	var rs = "";
	var hdaddcab=$("#bt");
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				hdaddcab.append("<option value=''>---请选择---</option>");
				for(var i = 1 ; i < result.length; i++){
					var key = result[i]["key"];
					var value =result[i]["value"];
					hdaddcab.append("<option value='"+key+"'>"+value+"</option>");
				}
				hdaddcab.append("<option value='"+result[0]["key"]+"'>"+result[0]["value"]+"</option>");
			}
		}
	});
}

function saveOtherExpense(){
	var bizid = $("#manConMacid").val();
	var consumetype = $("#consumetypeid").val();
	var manConprice = $("#manConpriceid").val();
	var manConNote = $("#manConNoteid").val();
	if (!bizid || !consumetype || !manConprice || !manConNote ) {
		$(function () {
            $.messager.alert('操作提示','带 <span id="manConpriceMesid" class="mes">*</span> 值不能为空',"warning");  
        });  
		return;
	}
	if (manConprice > cuaccount ) {
		$.messager.alert("账户提示","你的账户余额不足扣取本次费用！","warning");
		return;
	}
	if (manConprice == 0 ) {
		$.messager.alert("账户提示","消费金额不能为0元！","warning");
		return;
	}
	
	var url = '/customerMan/saveManualConsume.action';
	var params = {"bizid":bizid,"consumetype":consumetype,"manConprice":manConprice,"manConNote":manConNote,"cusid":currClickCusid};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$.messager.show({
				title: '提 示',
				msg: '操作消费成功'
			});
			queryBalance();
			$('#manualConsumeForm').dialog('close');
		} else {
			$.messager.show({
				title: 'Error',
				msg: '操作消费失败，请联系管理员!'
			});
		}
	});
}


function dropDownList(){
	//查询问题第一层分类信息
	$('#question-first-type option').remove();
	$('#question-second-type option').remove();
	$('#question-second-type').hide();
	$.post('/members/queryQTypeInfoList.action?parentId=0', null, function(text, status) {
		var questionTypeInfo = $.parseJSON(text);
		$.each(questionTypeInfo, function(n, value) {
			$('#question-first-type').append(
					"<option value='"+value.id+"'>" + value.name + "</option>");
		});
	});
	
}



//查询问题分类信息
$("#question-first-type").change(function(){
	$('#question-second-type option').remove();
	$('#question-second-type').hide();
	$.post('/members/queryQTypeInfoList.action?parentId=' + $('#question-first-type').val(), null, function(text, status) {
		var questionTypeInfo = $.parseJSON(text);
		
		var length = 0;
		
		$.each(questionTypeInfo, function(n, value) {
			$('#question-second-type').append(
					"<option value='"+value.id+"'>" + value.name + "</option>");
					length+=1;
		});
		//alert(text);
		if(length > 0){
			$('#question-second-type').show();
		}
	});
});


//按条件查询
function serchcollMacList(){
	
	var cusname = $("#nameid").html();
	var collMacnum = $('#inputSearchcollMacNum').val();
	var comproom = $('#inputSearchCollRoomid').val();
	
	var param = {"cusname":cusname,"collMacnum":collMacnum,"comproom":comproom};

	var url = "/customerMan/queryCollMacWithoutActive.action";
	$.ajax({
		url:url,
		async:false,
		cache:false,
		data:param,
		dataType:'json',
		success:function(result){
			var createDataGridJsonRows = result;
			var dataFiles = ["macnum","cpu","memory","harddisk","mactype","comproom","cabinet",['machid','comproomid']];
			var clickbutton = {"aMethod":"collMacActive-上架-collMacActive"};
			var formatFileds = "";//{"status":"0-未使用,1-已经使用"};
			//分页配置
			var loadurl = "/customerMan/queryCollMacWithoutActive.action?cusname="+cusname + "&collMacnum=" + collMacnum + "&comproom=" + comproom;
			var pageEvent = {"action":loadurl}; //加载数据,必须返回json数据.
			var showTableId = "#collMacList";
			createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,1,formatFileds);
		}
	});
	
}

//机柜托管机器按条件查询
function serchcollCabMacList(){
	
	var cusname = $("#nameid").html();
	var collMacnum = $('#inputSearchcollCabMacNum').val();//机器编号
	var comproom = $('#cdComproomid').val();//机房ID
	
	var param = {"cusname":cusname,"collMacnum":collMacnum,"comproom":comproom};

	var url = "/customerMan/queryCollMacWithoutActive.action";
	$.ajax({
		url:url,
		async:false,
		cache:false,
		data:param,
		dataType:'json',
		success:function(result){
			var createDataGridJsonRows = result;
			var dataFiles = ["macnum","cpu","memory","harddisk","mactype","comproom","cabinet",['machid','comproomid']];
			var clickbutton = {"aMethod":"collCabMacActive-上架-collCabMacActive"};
			var formatFileds = "";//{"status":"0-未使用,1-已经使用"};
			//分页配置
			var loadurl = "/customerMan/queryCollMacWithoutActive.action?cusname="+cusname + "&collMacnum=" + collMacnum + "&comproom=" + comproom ;
			var pageEvent = {"action":loadurl}; //加载数据,必须返回json数据.
			var showTableId = "#collCabMacList";
			createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,1,formatFileds);
		}
	});
	
}

//机柜下架
function cabinetXj(){
	if (currRowObjJson) {
		if (currRowObjJson.macxjstatus == 1 || currRowObjJson.macxjstatus == 2 || currRowObjJson.macxjstatus == 4) {
			var mes = "编号["+currRowObjJson.cabinetid+"]的机柜已经申请下架!";
			$.messager.alert("提示",mes);
			return;
		}
		
		var reason = dotran($("#cabReason").val());
		if(!reason){
			checkImgShow("#cabReasonMes",-1,'必填');
			return;
		}else{
			checkImgShow("#cabReasonMes",2);
		}
		
		
		var str = '确定要把机柜编号为【'+currRowObjJson.cabinetid+'】的下架吗？';
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var shelvesOperatorId = currMasterid;
				var url = "/customerMan/cabinetXj.action";
				var cusid = currClickCusid;
				var parmas  = {"id":currRowObjJson.id,"macxjstatus":"1","cabinet":currRowObjJson.cabinetid,"comproom":currRowObjJson.comproom,"cusid":cusid,"reason":reason,"shelvesOperatorId":shelvesOperatorId};
				$.post(url,parmas,function(result){
		    		var rs = $.trim(result);
		    		$("#xjCabWindow").dialog('close');
		    		$('#cabReason').val('');
		    		if (rs > 0) {
		    			$.messager.show({
							title: '提示',
							msg: '已经把下架信息提交到客服处理......'
						});
		    			reloadMyCurrCusData(currRowObjJson.customerid);
		    			reloadMyCabData();
		    			var cabinet=$("#cabid").val();
		    			var comproom = $("#cdComproomid").val();
		    			if(!cabinet=='' && !comproom==''){
		    				reloadMacOfCabData();
		    			}
		    		} else {
		    			$.messager.show({
							title: 'Error',
							msg: '下架失败，请联系管理员！'
						});
		    		}
		    		//$.parent.$('#bgmainuiid')().layout('expand','east');
		  		});
			}
		});
	}
}


var resourcesids = undefined;
var begintime = undefined;
var renprice = undefined;
var cusTruename;
var accbal;
var creded;
//打开批量续费窗口
function openBatchRenewalWindow(tab){
	var hobbys = $(tab+" #payment");
	   var sum = parseInt(0);
	   var sumprice = 0;
	   resourcesids = "{";
	   begintime = "{";
	   renprice = "{";
	   if($("input[type='checkbox']").is(':checked')){
	       for(var i=0;i<hobbys.length;i++){
	    	   if(hobbys[i].checked){
	    		  myDataRow(hobbys[i].value,tab);
		 		  if(currRowObjJson.paystatus == 0){
		 			 $.messager.alert("提示","当前为未付款状态，不能操作续费，请先操作付款当前资源")
		 			 return;
		 		  }
		 		resourcesids = resourcesids+"'"+i+"':'"+currRowObjJson.id+"'";
		 		begintime = begintime+"'"+i+"':'"+currRowObjJson.renendtime+"'";	
		 		renprice = renprice+"'"+i+"':'"+currRowObjJson.renprice+"'";
		 		sumprice += parseInt(currRowObjJson.renprice);
		 		
		 		 if(i < hobbys.length-1){
		 			resourcesids += ",";
		 			begintime += ",";
		 			renprice += ",";
		 		 }
		 		 
	    	   }
	 		  
	 	   }
	       resType = currRowObjJson.type;
	       resourcesids += "}";
	       begintime += "}";
	       renprice += "}";
	       //alert(resourcesids)
	       //alert(begintime)
	       //alert(renprice)
	       //alert(sumprice)

	       
	   }else{
		   $.messager.alert("提示","无选中项")
		   return;
	   }
	
	   //查询账户余额、信用额度和真实名字
	   $.ajax({
			url : '/customerMan/queryBalanceAndCredit.action',
			dataType : 'json',
			type : 'post',
			async: false,//使用同步的方式,true为异步方式
			data : {'custid':currClickCusid},//这里使用json对象
			success : function(data){
				cusTruename = data.custruename;
				accbal = data.accbal;
				creded = data.creded;
			},
			fail:function(){
				$.messager.alert("错误","与服务器数据交换出错！");
			}
			});
	   
	   
	$('#BatchResgoOnRenewalid').dialog('open').dialog('setTitle','续 费');
	$("#BatchResrCusTrueNameid").html(cusTruename);
	$("#BatchResMacnumid").val(currRowObjJson.macnum);
	$("#BatchAccbal").val(accbal);
	$("#BatchCreded").val(creded);
	$("#BatchResrpriceid").val(sumprice);
	
	
}


//动态显示价格
function BatchFormatPriceRes (value) {
	var rpriceid = $("#BatchResrpriceid").val();
	if (rpriceid) {
		return value+"月"+(rpriceid*value)+" 元";
	}
}

//提交批量续费
function BatchRessubRenewal(){

	var addsc = $('#BatchResaddrenscid').slider('getValue');
	var newPrice = $("#BatchResrpriceid").val();
	
	if (addsc==0) {
		$.messager.alert("提示","请选择续费时长！");
		return;
	}
	
	var str;
	if(!res_cabinetid){
		str = '确定要续费主机编号为【'+currRowObjJson.macnum+'】的资源吗？';
	}else{
		str = '确定要续费机柜编号为【'+res_cabinetid+'】的资源吗？';
	}
	
	$.messager.confirm("Confirm",str,function(r){
		if(r){
			var payCount = parseFloat(newPrice)*parseInt(addsc);
			var canPayCount = parseFloat(accbal)+parseFloat(creded);
			if(payCount>canPayCount){
				$.messager.alert("账户提示","你的账户余额加上信用额度不足扣取本次费用！");
				return;
			}
			
			
			//var params = {"addsc":addsc,"begintime":renbegintime,"resourcesid":resourcesid,"renprice":renprice,"cusid":currClickCusid,"note":rnote,"resType":resType,"renpayid":currRowObjJson.renpayid,"maid":currMasterid,"paytype":"renewres"};
			var url ="/customerMan/batchSubRenewalRes.action";
			var params = {"addsc":addsc,"begintime":begintime,"resourcesid":resourcesids,"renprice":renprice,"cusid":currClickCusid,"resType":resType,"maid":currMasterid,"paytype":"renewres"};
			$.post(url,params,function(result){
				var rs = $.trim(result);
				if(rs==1){
					$.messager.show({
						title: '提 示',
						msg: '续费支付成功!'
					});
					
					$('#BatchResaddrenscid').slider('setValue',0);
					$('#BatchResgoOnRenewalid').dialog('close');

					//刷新当前资源表
					if(payMark=='danjiRes'){
						//当前刷新的是单机资源表
						queryDangJiRes (resType);
					}else{
						//当前刷新的是机柜资源
						queryRes (resType);
					}
					//刷新当前客户余额
					queryBalance();
					//刷新当前表的数据
					reloadMyCabData();
					reloadMyCurrCusData ();

				}else {
					$.messager.show({
						title: 'ERROR',
						msg: '续费失败，请联系管理员!'
					});
				}
			});
		}
	});
	

}

//机器刷新按钮
function clickReloadMyCurrCusData(){
	$.trim($("#searchIpValid").val(""));
	$.trim($("#searchMacnumValid").val(""));
	reloadMyCurrCusData();
}

//机柜刷新按钮
function clickReloadMyCabData(){
	$.trim($("#searchCabValid").val(""));
	reloadMyCabData();
}

//机柜里的机器刷新
function clickReloadMacOfCabData(){
	$.trim($("#cabMacSearchIpValid").val(""));
	$.trim($("#cabMacSearchMacnumValid").val(""));
	reloadMacOfCabData();
}

//打开下架机器弹框
function openXJMacWindow(){
	$("#xjMacaddmacnum").val(currRowObjJson.macnum);
	$("#xjMacaddProNumid").val(currRowObjJson.proNum);
	$("#xjMaccabinetId").val(currRowObjJson.cabinet);
	$("#xjMaccomproomnameforNoteid").val(currRowObjJson.comproomname);
	$("#xjMacreasonsid").val("");
	$('#xjMacWindow').dialog('open').dialog('setTitle','机器下架');
}

//打开下架机柜弹框
function openXjCabWindow(){
	$('#xjCabaddCabProNumid').val(currRowObjJson.proNum);
	$("#xjCabcabinet").val(currRowObjJson.cabinetid);
	$("#xjCabcabcomproomnameid").val(currRowObjJson.comproomname);
	$('#xjCabWindow').dialog('open').dialog('setTitle','机柜下架');	
}

//打开下架资源弹框
function openXjResWindow(){
	$('#xjResWindow').dialog('open').dialog('setTitle','资源下架');
}

//打开下架资源弹框
function openXjResWindow2(){
	$('#xjResWindow2').dialog('open').dialog('setTitle','资源下架');
}

function checkAskQuestion(){
	var macnum = currRowObjJson.macnum;
	var url = "/members/checkAskQuestion.action";
	var params = {"macnum":macnum};
	var result = "false";
	$.ajax({
        type : "post",  
         url : url,  
         data : params,  
         async : false,  
         success : function(data){
        	 if(data == "1"){
        		 result = "true";
        	 }else{
        		 result = "false";
        	 }
         }  
    });
	return result;
}