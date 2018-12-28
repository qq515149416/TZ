
$(document).ready(function () {
	loadquestionGrid();
	loadquestioninGrid();
	$('#waitshelvesTab').datagrid({loadFilter:pagerFilter4});
	dblClickRowsToShelves("#waitshelvesTab");
	//定时执行
	//setInterval(reloadPageData, 10000);
});

var url; //提交路径
//未出来问题数据加载
function loadquestionGrid() {
	//表头
	var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
	//行内按钮
	var clickbutton = {"aMethod":"dealQuestion-处理详情-dealQuestion"};
	//格式化字段
	var formatFileds = {};
	//分页配置
	var pageEvent = {"action":"/technology/loadwaitdeal.action"};
	var showTableId = "#newQuestionTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}
//处理中问题数据加载
function loadquestioninGrid() {
	//表头
	var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
	//行内按钮
	var clickbutton = {"aMethod":"dealQuestion-处理详情-dealQuestion"};
	//格式化字段
	var formatFileds = {};
	//分页配置
	var pageEvent = {"action":"/technology/loadwaitdealto.action"};
	var showTableId = "#dealingQuesid";
	createDataGrid(showTableId,createDataGridJson,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

	
//更新业务主机状态
var jsmacxjstatus = undefined;
var jsbiztype = undefined;
var jsbusid = undefined;
var cabinet = undefined;
var comproomid = undefined;
var xjtype = undefined;
function updateMacxjstatus () {
	var params = {"id":jsbusid,"macxjstatus":jsmacxjstatus,"jsbiztype":jsbiztype,"comproomid":comproomid,"cabinet":cabinet,"xjtype":xjtype};
	var url = "/customerMan/updateMacxjstatus.action";
    $.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			if (jsmacxjstatus == "4") {
				updateCabinetMacxjstatus();
				$.messager.show({
					title: '提示',
					msg: '成功接单操作......'
				});
			} else if (jsmacxjstatus == "3") {
				updateCabinetMacxjstatus();
				if (jsbiztype == "0") {
					$.messager.show({
						title: '提示',
						msg: '已成功下架托管主机'
					});
				} else if (jsbiztype == "1") {
					$.messager.show({
						title: '提示',
						msg: '已成功清空租用主机'
					});
				}
			}
			reloadShelvesData();
		} else {
			$.messager.show({
				title: 'Error',
				msg: '下架操作异常，请联系管理员！'
			});
		}
  	});
}


//双击问题进行接单或者清空下架操作
//业务主机状态：0为上架中，1为下架处理中，2为机房处理中,3为主机已下架或者清空，4技术清空或者下架中
function dblClickRowsToShelves (tableid) {
	$(tableid).datagrid({  
		onDblClickRow:function(rowIndex, rowData){
			if (rowData) {
				var busid = rowData.id;
				jsbusid = busid;
				cabinet = rowData.cabinet;
				comproomid = rowData.comproomid;
				var str = '确定要操作编号为【'+rowData.macnum+'】的主机吗？';
				$.messager.confirm('下架确认',str,function(r){
					if (r){
						//0为托管,1为租用
						var biztype = rowData.biztype;
						jsbiztype = biztype;
						//如果当前macxjstatus=4,即已经接过此工单，再次双击即为托管主机已下架或者清空macxjstatus=3.
						jsmacxjstatus = "4";
						if (rowData.macxjstatus == "4") {
							jsmacxjstatus = "3";
							if (biztype == "1") {
								//租用机器要填写表单
								popuMacInfo(rowData);
								return;
							}
						}
						if(biztype == "0"){
							xjtype = "collocation";
						}else{
							xjtype = "";
						}
						updateMacxjstatus();
					}
				});
			}
	    }
    });
}

//提交主机修改信息
function submitMacInfo () {
	var vali = $('#fm').form('validate');
	if (vali) {
		//下架后对主机信息的更新.
		var url = "/customerserv/updateMac.action";
		var macnum = $("#macnumid").val();
		var cpu = $("#cpuid").val();
		var cabinet = $("#cabinetid").val();
		var macname = $("#macnameid").val();
		var macpass = $("#macpassid").val();
		var dxip = $("#dxipid").val();
		var yunip = $("#yunipid").val();
		var unicomip = $("#unicomipid").val();
		var vali1 = false;
		if($.trim(yunip)!=$.trim(unicomip)  && $.trim(unicomip)!=""){
			vali1 = searchIPCounts("unip","#unicomipid"," #unerrorsip",0);//判断新IP是否存在可用
		}else{
			vali1 = true;
		}
		if(!vali1){
			return;
		}
		var harddisk = $('#harddiskid').combobox('getValue');
		var memory = $('#memoryid').combobox('getValue');
		var mactype = $('#mactypeid').combobox('getValue');
		//eqToColumn标识标准查询字段，因为公用一个函数和sql，不区分会出现sql查询逻辑出错。
		var eqToColumn = "macnum";
		var params = {"eqToColumn":eqToColumn,"macnum":macnum,"cpu":cpu,"memory":memory,"harddisk":harddisk,"cabinet":cabinet,"macname":macname,"macpass":macpass,"mactype":mactype,"dxip":dxip,"unip":unicomip,"status":0,"yunip":yunip,"xijiaqk":"xijiaqk"};
		
		if (macpass.indexOf("'") != -1 ) {
			$.messager.alert('提示',"禁止使用单引号!");
			return;
		}
		if (macpass.indexOf('"') != -1 ) {
			$.messager.alert('提示',"禁止使用双引号!");
			return;
		}
		if (macpass.indexOf(';') != -1 ) {
			$.messager.alert('提示',"禁止使用分号!");
			return;
		}
		$.post(url,params,function(result){
	    	var rs = $.trim(result);
	    	if (rs > 0) {
	    		//业务单中主机的下架.同时回收IP.
	    		updateMacxjstatus();
	    		//更新机器库中主机的使用状态
	    		updateMacUseStatus(macnum);
	    	} else {
	    		$.messager.show({
					title: 'Error',
					msg: '主机信息更新出错，请联系管理员'
				});
	    		//updateMacxjstatusFalg = false;
	    	}
  		});
		$('#macInfoId').dialog('close');
		
	} else {
		return false;
	}
}

//更新主机库主机状态同时回收IP.
function updateMacUseStatus (macnum) {
	var url = "/customerserv/updateMacUseStatus.action";
	var params = {"used":"0","macnum":macnum,"status":0};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
    	if (rs <= 0) {
    		$.messager.show({
				title: 'Error',
				msg: '主机主机库主机状态更新出错，请联系管理员'
			});
    	}
  	});
}

//弹出清空租用机器时所需要更新的主机信息
function popuMacInfo (rowData) {
	$('#macInfoId').dialog('open').dialog('setTitle','修改主机信息');
	$("#unerrorsip").html("");
	var url = "/customerserv/queryMacInfoToJson.action";
	var params = {"macnum":rowData.macnum};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
    	var jsondata = JSON.parse(rs);
		$('#fm').form('load',jsondata);
		$('#yunipid').val(jsondata.unicomip);
  	});
}

//点击处理详情
function dealQuestion (id) {
	if (currRowObjJson) {
		//新打开一个窗口后需要用到的数据
		window.open("/result/technology/dealQuesWindow.jsp?"
				+ "id=" + currRowObjJson.qid
				+ "&custid=" + currRowObjJson.custid,"answerpage");
	}
}

//重载清空或者下架列表数据
function reloadShelvesData () {
	var reloadUrl = "/technology/reloadShelvesData.action";
	$.post(reloadUrl,'',function(result){
    	var rs = $.trim(result);
    	var jsondata = JSON.parse(rs);
		$("#waitshelvesTab").datagrid("loadData",jsondata);
  	});
}

//重载当前页数据
/*function reloadPageData () {
	var reloadUrl = "/technology/realodQuestion.action";
	$.post(reloadUrl,{'quesstatus':'0'},function(result){
    	var rs = $.trim(result);
    	var jsondata = JSON.parse(rs);
    	if (jsondata) {
			$("#newQuestionTab").datagrid("loadData",jsondata);
			
			$.post(reloadUrl,{'quesstatus':'1'},function(result){
		    	var rs = $.trim(result);
		    	var jsondata = JSON.parse(rs);
		    	if (jsondata) {
					$("#dealintQuestionTab").datagrid("loadData",jsondata)
				}
		  	});
		}
  	});
}*/
function reloadPageData () {
	var reloadUrl = "/technology/realodQuestion.action";
	$.ajax({
        url : reloadUrl,
        data : {'quesstatus':'0'},
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
				//行内按钮
				var clickbutton = {"aMethod":"dealQuestion-处理详情-dealQuestion"};
				//格式化字段
				var formatFileds = {};
				//分页配置
				var pageEvent = {"action":"/technology/loadwaitdeal.action"};
				var showTableId = "#newQuestionTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
	
	$.ajax({
		url : reloadUrl,
		data : {'quesstatus':'1'},
		cache : false, 
		async : false,
		type : "POST",
		dataType : 'json',
		success : function (result){
			if (result) {
				//表头
				var dataFiles = ["quesdate","contents","askName","macnum","dxip","unicomip","groupnamezn","comproom",["id","askid","quesstatus","qid","custid"]];
				//行内按钮
				var clickbutton = {"aMethod":"dealQuestion-处理详情-dealQuestion"};
				//格式化字段
				var formatFileds = {};
				//分页配置
				var pageEvent = {"action":"/technology/loadwaitdealto.action"};
				var showTableId = "#dealingQuesid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
	});
}


//修改表格行颜色
$('#newQuestionTab').datagrid({
	rowStyler: function(index,row){
		return 'color:red;'; // return inline style
	}
});
$('#waitshelvesTab').datagrid({
	//rowStyler: function(index,row){
	//	return 'color:#579249;'; // return inline style
	//}
});

//单击行时触发的事件
//$('#newQuestionTab').datagrid({
//	onSelect: function(index,field,value){
	
//	}
//});

//------分页---------------------------------------

//--------------下架或清空待处理-----------------------------
function pagerFilter4(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#waitshelvesTab");           
	var opts = dg.datagrid('options');            
	var pager = dg.datagrid('getPager');            
	pager.pagination({                
		onSelectPage:function(pageNum, pageSize){                    
			opts.pageNumber = pageNum;                    
			opts.pageSize = pageSize;                    
			pager.pagination('refresh',{                        
				pageNumber:pageNum,                        
				pageSize:pageSize                    
			});                    
			dg.datagrid('loadData',data);                
		}            
	});            
	if (!data.originalRows){                
		data.originalRows = (data.rows);            
	}            
	var start = (opts.pageNumber-1)*parseInt(opts.pageSize);            
	var end = start + parseInt(opts.pageSize);            
	data.rows = (data.originalRows.slice(start, end));
	return data;        
}     
//--------格式化----------------
function biztypeFmat (val,row) {
	if (row.biztype==0) {
		return '托管';
	} else if (row.biztype==1){
		return '<span style="color:maroon;">租用</span>';
	}
}
//业务主机状态：0为上架中，1为下架处理中，2为机房处理中,3为托管主机已下架或者清空，4技术清空或者下架中
function macxjstatusFmat (val,row) {
	var biztype = row.biztype;
	if (row.macxjstatus==2){
		return '<span style="color:red">接单操作</span>';
	} else if (row.macxjstatus==4){
		if (biztype == 0)
			return '<span style="color:red">待下架完成,下架中...</span>';
		else if (biztype == 1)
			return '<span style="color:red">待清空完成,清空中...</span>';
	} 
}


//修改机柜的状态
function updateCabinetMacxjstatus(){
	var params = {"macxjstatus":jsmacxjstatus,"comproomid":comproomid,"cabinet":cabinet};
	var url = "/customerMan/updateCabinetMacxjstatus.action";
	$.post(url,params,function(result){
	});
}





