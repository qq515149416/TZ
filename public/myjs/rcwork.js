
//初始化菜单
$(function(){
	loadDeptData();
	$('#flowdgTabid').datagrid({loadFilter:pagerFilter});
	dblClickRows("flowpicsid","flowdgTabid");
	  
});

//双击展开
function dblClickRows (winid,tableid) {
	var tid = "#" + tableid;
	$(tid).datagrid({  
		onDblClickRow:function(data){
			showFlows();
	    }  
    });
}


//下拉框部门选中触发
function selectVal () {
	$('#groupid2').combobox({
		onSelect: function(record){
			loadFlows(record.deptid);
		}
	});
}


//加载各个部门所有的工作流
var flowHtmlFromdb = undefined;
function loadFlows (paramDeptid) {
	if (!paramDeptid) {
		//默认展示业务部的工作流
		paramDeptid = 2;
	}
	var params = {"groupid":paramDeptid}
	$.post("/rcworks/loadFlows.action",params,function(result){
    	var rs = $.trim(result);
    	if (rs) {
    		//var jsondata = eval(rs);
    		var jsondata = JSON.parse(rs);
    		flowHtmlFromdb = jsondata;
    		selectVal();
			$("#flowdgTabid").datagrid("loadData",jsondata);
    	}
  	});
}

//加载部门数据
var deptArrayJson = '';
function loadDeptData () {
	$.post("/rcworks/loadDept.action",{},function(result){
    	var rs = $.trim(result);
    	if (rs) {
    		var jsondata = JSON.parse(rs);
    		deptArrayJson = jsondata;
    		$("#groupid2").combobox('loadData',deptArrayJson);
    		$("#groupid2").combobox('setValue','业务部');
    		//加载流程数据
    		loadFlows(2);
    	}
  	});
}


//加载控件数据
function loadControlsData(id) {
	$("#"+id).toggle(500);
	$("#fdatagriddivid").toggle(500);
	$("#showFlowid").html('');
	$("#draw").html('');
	$("#draw2").html('');
	$("#groupid").combobox('loadData',deptArrayJson);
	loadRoles();
}

//加载角色数据
function loadRoles () {
	$.post("/rcworks/loadRoles.action",{},function(result){
    	var rs = $.trim(result);
    	if (rs) {
    		var rolesArray = new Array();
    		var jsondata = eval(rs);
    		var noteHtml = "";
			for (var i = 0 ; i < jsondata.length ; i++) {
				var rolename = jsondata[i]['groupnamezn'];
				var roleid = jsondata[i]['groupid'];
				rolesArray[i] = "#" + roleid;
				var noteStr = '<div id="'+roleid+'" class="drag">'+rolename+'</div>';
				noteHtml += noteStr;
			}
			$("#source").html(noteHtml);
			flowMoveDiv(rolesArray);
    	}
  	});
}

//生成流程图
//流程图的html
var flowHtml = '';
function createFlow (){
	//创建流程图节点----------------------------------
	//var finput = $("#wflowprocessid").val();
	//var vals = finput.split("，");
	var nextid = 0;
	var str = '<div id="spanBefore"><div class="before"  begin=-1 id="0" next="1">开  始</div>';
	for (var i = 0 ; i < flowRolesArray_name.length; i++) {
		var tempid = i + 1;
		nextid = tempid + 1;
		str += '<div class="before" id="'+tempid+'" next="'+nextid+'">'+flowRolesArray_name[i]+'</div>';
	}
	flowRolesArray_name = new Array();
	str += '<div class="before" id="'+nextid+'" next="-1">结  束</div></div>';
	$("#showFlowid").html(str);
	flowHtml = str;
	//生成流程图-------------------------------------
	myflow("draw");
	$("#spanBefore").flow({hover:function(){
		$(this).addClass("workhover");
	},remove:function(){
		$(this).removeClass("workhover");
	},click:function(){
		$.messager.alert("提示",$(this).attr("id") + "->" + $(this).attr("next") + " Click");
	}});
}


//提交流程图信息
function subFlowInfo () {
	var flowname = $("#wflowname").val();
	var groupid = $("#groupid").combobox('getValue');
	var groupname = $("#groupid").combobox('getText');
	var flowing = flowHtml;
	var flowroles = flowRolesArray_id.join("-");
	if (!flowname) {
		$.messager.show({
			title: '提示',
			msg: '请输入流程名称'
		});
		return;
	} else if (!groupid) {
		$.messager.show({
			title: '提示',
			msg: '请选择所属部门'
		});
		return;
	} else if (!groupname) {
		return;
	} else if (!flowing) {
		$.messager.show({
			title: '提示',
			msg: '请点击生成流程图才能建立工作流'
		});
		return;
	}
	var params = {"flowname":flowname,"groupid":groupid,"groupname":groupname,"flowing":flowing,"flowroles":flowroles};
	$.post("/rcworks/addNewFlow.action",params,function(result){
    	var rs = $.trim(result);
    	if (rs) {
    		$.messager.show({
				title: '提示',
				msg: '成功创建工作流'
			});
    	} else {
    		$.messager.show({
				title: 'ERROR',
				msg: '创建工作流失败，请联系管理员'
			});
    	}
    	$("#wflowname").val('');
  	});
}


//流程图制作的可移动层
var flowRolesArray_name = new Array();
var flowRolesArray_id = new Array();
var flowRolesArray_count = 0;
function flowMoveDiv (rolesArrays) {
	$('.drag').draggable({
		proxy:'clone',
		revert:true,
		cursor:'auto',
		onStartDrag:function(){
			$(this).draggable('options').cursor='not-allowed';
			$(this).draggable('proxy').addClass('dp');
		},
		onStopDrag:function(){
			$(this).draggable('options').cursor='auto';
		}
	});
	$('#target').droppable({
		//accept:'#1,#24,#25,#26,#27,#28,#29,#30',
		onDragEnter:function(e,source){
			$(source).draggable('options').cursor='auto';
			$(source).draggable('proxy').css('border','1px solid red');
			$(this).addClass('over');
		},
		onDragLeave:function(e,source){
			$(source).draggable('options').cursor='not-allowed';
			$(source).draggable('proxy').css('border','1px solid #ccc');
			$(this).removeClass('over');
		},
		onDrop:function(e,source){
			$(this).append(source)
			$(this).removeClass('over');
			flowRolesArray_name[flowRolesArray_count] = source.innerHTML;
			flowRolesArray_id[flowRolesArray_count] = source.id;
			flowRolesArray_count ++;
			//createFlow();
		}
	});
}

//查看单个工作流的流程图
function showFlows () {
	var row = $('#flowdgTabid').datagrid('getSelected');
	if (row) {
		var flowRows = flowHtmlFromdb['rows'];
		var currid = row.id;
		$('#flowpicsid').dialog('open').dialog('setTitle','流程图');
		for (var i = 0 ; i < flowRows.length ; i++) {
			var vals = flowRows[i];
			var tempid = vals['id'];
			if (currid == tempid) {
				$("#showFlowDivid").html(vals['flowing']);
				//重写flow函数,主要目的要重新指定渲染的目标位置
				$("#draw2").html('');
				myflow("draw2");
				$("#spanBefore").flow();
				break;
			}
		}
	}
}

//分页--------------------------
function pagerFilter(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#flowdgTabid");           
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

