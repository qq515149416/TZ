var url; //提交路径
//加载数据表格与表格的按钮事件
function loadMyCusDataGrid () {
	//超管登录所显示的表头
	var dataFiles = ["cusname","custruename","accbal","companyname","cussex","cusqq","cusmobile","telephone","cusemail","fax","createdate","cusaddr",'note',['cusid','deptid',"addedservstatus"]];
	if (currMasterid == 1 || currGroupid == 42 || currGroupid == 38 || currGroupid == 25  || currGroupid == 26|| currGroupid == 45) {
		dataFiles = ["cusname","custruename","accbal","companyname","cussex","cusqq","cusmobile","telephone","cusemail","fax","createdate","cusaddr","truename",'note',['cusid','maid','deptid',"addedservstatus"]];
	} 
	//行内按钮
	var clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-修改-editCus-white,addedService-增值业务-addedService-white"};
	if (currGroupid == 1 ) {
		clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-修改-editCus-white,transferCus-转移-transferCus,addedService-增值业务-addedService-white"};
	}
	if (currGroupid == 25) {
		clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,transferCus-转移-transferCus"};
	}
	//格式化字段
	var formatFileds = "";//{"biztype":"1-租用,0-托管"};
	//分页配置
	var pageEvent = {"action":"/customerMan/loadMycustomer.action"}; //加载数据,必须返回json数据.
	var showTableId = "#mycustomerTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//高级搜索
function searchMycus () {
	var custruename = $("#custruenameid").val();
	var truename = $("#truenameid").val();
	var cusname = $("#cusnameid").val();
	var others = $("#othersid").val();
	var url = "/customerMan/loadMycustomer.action";
	var params = {"custruename":custruename,"truename":truename,"cusname":cusname,"others":others};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			var dataFiles = ["cusname","custruename","accbal","companyname","cussex","cusqq","cusmobile","telephone","cusemail","fax","createdate","cusaddr",'note',['cusid','deptid',"addedservstatus"]];
			if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 25  || currGroupid == 26 || currGroupid == 42|| currGroupid == 45 ) {
				dataFiles = ["cusname","custruename","accbal","companyname","cussex","cusqq","cusmobile","telephone","cusemail","fax","createdate","cusaddr","truename",'note',['cusid','maid','deptid',"addedservstatus"]];
			} 
			//行内按钮
			var clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-修改-editCus-white,addedService-增值业务-addedService-white"};
			if (currGroupid == 1 ) {
				clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-修改-editCus-white,transferCus-转移-transferCus,addedService-增值业务-addedService-white"};
			}
			if (currGroupid == 25) {
				clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,transferCus-转移-transferCus"};
			}
			//格式化字段
			var formatFileds = "";
			//分页配置
			if (custruename) {
				custruename = encodeURI(encodeURI(custruename));
			}
			if (truename) {
				truename = encodeURI(encodeURI(truename));
			}
			var urlParams = "/customerMan/loadMycustomer.action?urlParams=urlParams&" + "custruename=" + custruename + "&truename=" + truename+"&cusname="+cusname+"&others="+others;
			var pageEvent = {"action":urlParams};
			var showTableId = "#mycustomerTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
		}
	});
}

//展开客户转移的客户人员名单
//transferCusid为了确定当期点击转移的客户ID，因为直接用currRowObjJson.cusid会导致鼠标移动到其它行就同时会改变。
var transferCusid = undefined;
var transferCusName = undefined;
function transferCus () {
	transferCusid = currRowObjJson.cusid;
	transferCusName = currRowObjJson.custruename;
	//获取所有业务员名单树
	var url = "/customerMan/querySalesmans.action";
	getRigthTree(url);
	//添加确认按钮
	var rightHtml = $('#bgrightid').html();
	rightHtml += '<br><div style="margin-left:20px;"><a href="javascript:subTransferCus();" class="button white medium" >人员转移</a></div>';
	$('#bgrightid').html(rightHtml);
}

//确认转移
function subTransferCus () {
	var selecVal = getCheckedid();
	var arrys = selecVal.split(",");
	if (arrys.length > 1) {
		$.messager.show({ // show error message
			title: '提示',
			msg: '只能选择一个业务进行转移！'
		});
		return;
	}
	var masname = getCheckedText();
	var f = confirm("是否确认转移客户["+transferCusName+"]到业务员["+masname+"]名下？");
   	if (f) {
		var url = "/customerMan/transferCus.action";
		var params = {"cusid":transferCusid,"tomaid":selecVal};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			if (rs == -2) {
				$.messager.show({ // show error message
					title: '错 误',
					msg: '客户转移失败，请联系管理员'
				});
			} else if (rs > 0) {
				$.messager.show({ // show error message
					title: '错 误',
					msg: '客户以及客户名下的机器全部转移成功'
				});
			} else {
				$.messager.show({ // show error message
					title: '错 误',
					msg: '客户转移成功，但是没有机器可移动'
				});
			}
		
		});
		$('#bgmainuiid').layout('collapse','east');
		$('#bgrightid').html("");
	}
}


//查看客户信息
function macDetail () {
	if (currRowObjJson) {
		AddRunningDiv();
		look(currRowObjJson.cusid);
	}
}

//弹出新增窗口
function popup(){
	//打开新增客户窗口，要显示密码框和非空验证
	document.getElementById("cuscomfigpassid").style.display = "block";
	document.getElementById("cuspasswordid").style.display = "block";
	//$("#cusnameid").attr("readonly",false);
	//$('#passInputid').validatebox({
    //	required: true
    //});
	$('#addcusdiv').dialog('open').dialog('setTitle','新增客户');
	url = '/customerMan/addCustomer.action';
	//$('#fm').form('clear');
}


//查询我的客户信息
function queryMycustomer (currentPage) {
	var custruename = $("#custruenameid").val();
	var truename = $("#truenameid").val();
	var cusname = $("#cusnameid").val();
	var others = $("#othersid").val();
	var url = '/customerMan/loadMycustomer.action';
	if (!currentPage) currentPage = 1;
	var param = {"currentPage":currentPage,"custruename":custruename,"truename":truename,"cusname":cusname,"others":others}
	$.ajax({
        url : url,
        data: param,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			var dataFiles = ["cusname","custruename","accbal","companyname","cussex","cusqq","cusmobile","telephone","cusemail","fax","createdate","cusaddr",'note',['cusid','deptid',"addedservstatus"]];
			if (currMasterid == 1 || currGroupid == 37 || currGroupid == 38 || currGroupid == 39 || currGroupid == 25  || currGroupid == 26 || currGroupid == 42|| currGroupid == 45 ) {
				dataFiles = ["cusname","custruename","accbal","companyname","cussex","cusqq","cusmobile","telephone","cusemail","fax","createdate","cusaddr","truename",'note',['cusid','maid','deptid',"addedservstatus"]];
			} 
			//行内按钮
			var clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-修改-editCus-white,addedService-增值业务-addedService-white"};
			if (currGroupid == 1 ) {
				clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,updateCusInfo-修改-editCus-white,transferCus-转移-transferCus,addedService-增值业务-addedService-white"};
			}
			if (currGroupid == 25) {
				clickbutton = {"aMethod":"mycusMacsInfo-详情-macDetail,transferCus-转移-transferCus"};
			}
			//格式化字段
			var formatFileds = "";
			//分页配置
			if (custruename) {
				custruename = encodeURI(encodeURI(custruename));
			}
			if (truename) {
				truename = encodeURI(encodeURI(truename));
			}
			var urlParams = "/customerMan/loadMycustomer.action?urlParams=urlParams&" + "custruename=" + custruename + "&truename=" + truename+"&cusname="+cusname+"&others="+others;
			var pageEvent = {"action":urlParams};
			var showTableId = "#mycustomerTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
		}
	});
}

//更新客户信息
function updateCusInfo () {
	var url = '/customerMan/updateCustomer.action';
	$('#updateCusfm').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var rs = $.trim(result);
			if (rs > 0){
				$('#cusInfodivid').dialog('close'); // close the dialog
				$('#updateCusfm').form('clear');
				queryMycustomer($("#mycustomerTid #currPage").html().substring(3,$("#mycustomerTid #currPage").html().length-1));
				
			} else {
				$.messager.show({
					title: 'Error',
					msg: '客户资料填写错误，请联系管理员！'
				});
			}
		}
	});
}

//检查登录名
var checkaddcusname = false;
function checkCusname() {
	var cusname = valiInput(USERNAME,"addcusdiv #cusnameid","cusnameMes","","数字和英文及下划线和.的组合，开头为字母，6-20个字符");
	if (cusname) {
		var cusnameval = $("#addcusdiv #cusnameid").val();
		var params = {"cusname":cusnameval};
		var url = "/customerMan/checkCusname.action";
		var rs = queryInfo (url,params,"检查账号异常，请联系管理员");
		if (rs > 0) {
    		$("#cusnameMes").html("<font color='red'>登录名已存在!</font>");
    		$("#cusnameid").val("");
    		$("#cusnameid").focus();
    		return false;
    	} else {
    		$("#cusnameMes").html("");
    		checkaddcusname = true;
    		return true;
    	}
	} else {
		//$("#cusnameid").focus();
		return false;
	}
	
}

//保存信息
function saveNewMac(){
	if (checkaddcusname == false) {
		return;
	}
	var checkPass = valiInput(PASSWORD,"passInputid","passMes1","","数字和英文及下划线的组合，6-20个字符");
	if (!checkPass) {
		return;
	}
	var pass1 = $("#passInputid").val();
	var pass2 = $("#comfigpassInputid").val();
	if (pass1 != pass2) {
		var htmstr = "<img src='/images/onError.gif'/><span style='color:red;font-size:12px;'>两次密码输入不一致</span>";
		$("#passMes2").html(htmstr);
		return;
	}
	
	$('#addcusfm').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var rs = $.trim(result);
			if (rs > 0){
				$('#addcusfm').form('clear');
				$('#addcusdiv').dialog('close'); // close the dialog
				queryMycustomer($("#mycustomerTid #currPage").html().substring(3,$("#mycustomerTid #currPage").html().length-1));
				
			} else {
				$.messager.show({
					title: 'Error',
					msg: '客户资料填写错误，请联系管理员！'
				});
			}
		}
	});
}


//检查当前删除的客户在数据库业务表中是否存在上架机器
var delCus = undefined;
function checkCusInBus (cusid) {
	var url = '/customerMan/checkCusInBus.action';
	var params = {"cusid":cusid,"macxjstatus":3};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0){
			$.messager.show({ // show error message
				title: '提示',
				msg: '该用户仍有主机使用中，不能删除！'
			});
			return false;
		}
	});
}


//加载并且显示一条可用的空主机信息供业务员操作(租用类型中)
function addrentmac() {
	document.getElementById("showrentmacid").style.display = "block";
}


//弹出编辑客户信息窗口
function editCus(){
	if (currRowObjJson) {
		$('#cusInfodivid').dialog('open').dialog('setTitle','编辑客户信息');
		//填充表格
		$("#cusInfodivid #cusid").val(currRowObjJson.cusid);
		$("#cusInfodivid #cusnameid").val(currRowObjJson.cusname);
		$("#cusInfodivid #custruenameid").val(mydecode(currRowObjJson.custruename));
		$("#cusInfodivid #companynameid").val(mydecode(currRowObjJson.companyname));
		$("#cusInfodivid #cussexid").val(currRowObjJson.cussex);
		$("#cusInfodivid #cusmobileid").val(currRowObjJson.cusmobile);
		$("#cusInfodivid #telephoneid").val(currRowObjJson.telephone);
		$("#cusInfodivid #cusemailid").val(currRowObjJson.cusemail);
		$("#cusInfodivid #cusqqid").val(currRowObjJson.cusqq);
		$("#cusInfodivid #faxid").val(currRowObjJson.fax);
		$("#cusInfodivid #cusaddrid").val(currRowObjJson.cusaddr);
		//这里转义注意,假如存在<br/>,currRowObjJson.note这是转义后的字符即&gt;br/&quot;,第一次转成<br/>，第二次再转为\r\n，才能在文本域中显示格式.
		$("#cusInfodivid #noteid").val(mydecode(mydecode(currRowObjJson.note)));
	}
	
}

//检查输入编号是否重复
var hadMacnum = false;
function checkMacnum (id) {
	//$(id).blur(function(){
		var macnumval = $(id).val();
		if (macnumval) {
			var url2 = '/customerMan/checkMacnumRepeat.action';
			var params = {"macnum":macnumval};
			$.post(url2,params,function(result){
				var rs = $.trim(result);
				if (rs > 0){
					$("#macnumMes").html("<font color='red'>已经存在!</font>");
					hadMacnum = true;
					$(id).focus();
					return;
				} else {
					$("#macnumMes").html("");
					hadMacnum = false;
				}
			});
		} 
	//});
}


//查看客户主机情况
function look (cusidParam) {
	var params = {"cusid":cusidParam};
	url = '/customerMan/queryMacInfoForCus.action';
	$.post(url,params,function(result){
		afterLoadUI("#bgcenterid",result);
		MoveRunningDiv();
	});
}


//时间控件的日期格式
$.fn.datebox.defaults.formatter = function(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return y+'-'+m+'-'+d;
}


//增值业务
function addedService(){
	
	var status = currRowObjJson.addedservstatus;
	var str="";
	if(status == 0){
		str = "确定为客户:<span style='color:red;font-size:14px;'>" + currRowObjJson.custruename + "</span>" +
		"<br/><span style='color:red;font-size:14px;'>开通</span>增值业务吗？<br><br>" ;
		status= 1;
	}else{
		str = "确定为客户:<span style='color:red;font-size:14px;'>" + currRowObjJson.custruename + "</span>" +
		"<br/><span style='color:red;font-size:14px;'>关闭</span>增值业务吗？<br><br>" ;
		status= 0;
	}
	$.messager.confirm('Confirm',str,function(r){
	if (r){
		var url = "/customerMan/addedService.action";
		var params = {"cusid":currRowObjJson.cusid,"addedservstatus":status};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				//刷新当前表的数据
				queryMycustomer($("#mycustomerTid #currPage").html().substring(3,$("#mycustomerTid #currPage").html().length-1));
				if(status==1){
					$.messager.show({
						title: '提 示',
						msg: "增值业务<span style='color:red;font-size:14px;'>开通</span>成功！"
					});
				}else{
					$.messager.show({
						title: '提 示',
						msg: "增值业务<span style='color:red;font-size:14px;'>关闭</span>成功！"
					});
				}
			} else {
				 $.messager.alert("操作提示", "操作失败，请联系系统管理员！","error"); 
			}
	  	});
	}
});
}

//导出用户
function exportCustomerWithExcel(){
	var custruename = encodeURI(encodeURI($("#custruenameid").val()));
	var truename =encodeURI(encodeURI($("#truenameid").val()));
	var cusname =encodeURI(encodeURI($("#cusnameid").val()));
	var others = encodeURI(encodeURI($("#othersid").val()));
	window.location.href = "/customerMan/exportCustomerWithExcel.action?custruename="+custruename+"&truename="+truename+"&cusname="+cusname+"&others="+others+"&currMasterid="+currMasterid+"&currGroupid="+currGroupid;

}

