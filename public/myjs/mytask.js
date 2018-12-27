

//初始化菜单
$(function(){
	if ($('#mytaskListTab')) {
		$('#mytaskListTab').datagrid({loadFilter:pagerFilter});
		dblClickRows("#mytaskListTab");
	}
	
});

//展示任务列表
var showTaskType = undefined;
function showTaskList(type,flowid) {
	showTaskType = type;
	var params = {"ftype":type,"contentType":currContentType,"flowid":flowid};
	$.post("/login/mytaskList.action",params,function(result){
		afterLoadUI("#showTaskid",result);
  	});
	
}

//按钮选中切换样式(个性化按钮)
function changeButtonCss (butName,butId,contentType) {
	$("a[name="+butName+"]").each(function(i){
		var id = $(this).attr("id");
		if (id == butId) {
			$(this).removeClass();
			$(this).toggleClass("button orange bigrounded");
		} else {
			$(this).removeClass();
			$(this).addClass("button blue bigrounded");
		}
	});
	changeContents(contentType);
}

//更改当前显示内容
var currContentType = undefined;
function changeContents (contentType) {
	currContentType = contentType;
	$("#currTypeid").val(contentType);
	var params = {"contentType":contentType};
	var url = "/login/loadTasks.action";
	$.post(url,params,function(result){
		$("#showTaskid").html(result);
  	});
}

//查询当条申请的详情情况
function showTaskDetailed (tableid) {
	document.getElementById("task-but").style.display = "block";
	var row = $(tableid).datagrid('getSelected');
	if (row) {
		//解析出业务id的值
		var otherattr = row.otherattr;
		var attrid = otherattr.split("@")[0];
		var id = attrid.split("=")[1];
		var params = {"id":id};
		$.post("/login/queryTaskDeatil.action",params,function(result){
			var jsondata = eval(result)[0]; 
			var biztype = jsondata['biztype'];
			if (biztype == 0) {
				biztype = "托管";
			} else {
				biztype = "租用";
			}
			$("#fgoid").val(row.fgid);
			$("#fwid").val(row.flowworkid);
			$("#currroleid").val(row.roleid);
			$("#flowid").val(row.flowid);
			$("#otherattrid").val(row.otherattr);
			$("#tmacnumid").html(jsondata['macnum']);
			$("#tcabinetid").html(jsondata['cabinet']);
			$("#trenbegintimeid").html(jsondata['renbegintime']);
			$("#trenscid").html(jsondata['rensc']+"月");
			$("#tdkId").html(jsondata['dk']+"M");
			$("#trpriceid").html(jsondata['renprice']+"元");
			$("#tfhid").html(jsondata['fh']+"G");
			$("#biztypeId").html(biztype);
			
			var updatedesc = "[业务员:" + row.fqrname + "]--" + row.fwnote;
			$("#updatedescid").html(updatedesc);
			//流程图加载(还没做完)
			loadFlowPic(row.flowid);
			//如果是当前用户查看自己的申请，不提供任何操作按钮,currTypeid为空是默认选中的，所以参数为空.
			var currTypeid = $("#currTypeid").val();
			if (!currTypeid || currTypeid == 1) {
				document.getElementById("task-but").style.display = "block";
				$("#tnoteid").attr("disabled",false);
				
			} else {
				document.getElementById("task-but").style.display = "none";
				$("#tnoteid").attr("disabled","disabled");
			}
			$('#taskDetailedDiv').dialog('open').dialog('setTitle','业务申请的详细内容');
			
  		});
	}
}

//加载工作流程
function loadFlowPic (flowid) {
	if (flowid) {
		var url = "/rcworks/loadFlows.action";
		var params = {"flowid":flowid};
		$.post(url,params,function(result){
			var flowJson = eval(result)[0];
			//赋值角色流程ID顺序
			$("#flowgoid").val(flowJson["flowroles"]);
			
			//判断当前用户是否为最后一个用户，如果是就禁用下一级按钮
			var roles = flowJson["flowroles"].split("-");
			var currroleid = $("#currroleid").val();
			if (roles[roles.length-1] == currroleid) {
				//$("#oknextid").attr("disabled","disabled");
				document.getElementById("oknextid").style.display = "none";
			} else {
				document.getElementById("oknextid").style.display = "block";
				//$("#oknextid").attr("disabled",true);
			}
			loadDeptDatas(flowJson["flowroles"]);
		});
	} else {
		$.messager.alert("提示","加载流程图失败!");
	}
	
}

function loadDeptDatas (deptids) {
	var flowid = $("#fwid").val();
	var params = {"groupids":deptids,"flowid":flowid};
	$.post("/role/queryGroupOfids.action",params,function(result){
    	var rs = $.trim(result);
    	if (rs) {
    		var jsondata = rs.split(',');
    		var str = "";
    		for (var i = 0 ; i < jsondata.length - 1; i++) {
    			if (i >= jsondata.length -2 ) {
    				str += jsondata[i];
    			} else {
    				str += jsondata[i] + " -> ";
    			}
    			
    		}
    		//显示当前整个流程顺序走向
    		$("#flowGosid").html(str);
    		//显示当前的处理部门
    		$("#currDealRole").html(jsondata[jsondata.length-1]);
    		loadRoleCheckInfo();
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

//加载所有上一级的审核信息
function loadRoleCheckInfo() {
	var url = "/rcworks/loadRolecheckInfo.action";
	var flowworkid = $("#fwid").val();
	var params = {"flowworkid":flowworkid};
	$.post(url,params,function(result){
		var flowgoJson = eval(result);
		var htmlStr = "";
		for (var i = 0; i < flowgoJson.length; i++) {
			//显示所有的审核备注
			var obj = flowgoJson[i];
			if (obj["note"]) {
				var str = '<table><tr style="color:red;"><td>'+obj["rolename"] + "("+obj["dealname"]+")审核备注："+
					"</td><td>[" + obj["note"] + "]</td></tr></table>";
				htmlStr += str;
				$("#allNotesid").html(htmlStr);
			}
		}
	});
}

//审核任务
function checkTasks (checkType) {
	//防止二次提交
	document.getElementById("task-but").style.display = "none";
	var tnote = $("#tnoteid").val();
	var fgoid = $("#fgoid").val();
	var fwid = $("#fwid").val();
	var flowid = $("#flowid").val();
	var nextroles = $("#flowgoid").val();
	var otherattr = $("#otherattrid").val();
	var params = {"checkType":checkType,"tnote":tnote,"fgoid":fgoid,"fwid":fwid,"nextroles":nextroles,"otherattr":otherattr,"flowid":flowid};
	$.post("/rcworks/checkTask.action",params,function(result){
		$('#taskDetailedDiv').dialog('close');
		var mes = "";
		if (isInChn(result)) {
			mes = result;
		}
		if (result == -1) {
			mes = "提交异常，请联系管理员!";
			
		} else if (result == 1) {
			mes = "已成功提交到下一级处理!";
			
		} else if (result == 2) {
			mes = "审核成功通过，流程到此结束!"
			
		} else if (result == 3) {
			mes = "审核已经成功驳回!"
				
		} else if (result == 4){
			mes = '价格修改成功!';
			
		} else if (result == -101){
			mes = '服务器资源更换失败，请联系管理员';
			
		} else if (result == -102){
			mes = '服务器资源更换后，时间价格部分异常，请联系管理员';
			
		} else if (result == -103){
			mes = '服务器资源更换后，日志记录失败，请联系管理员';
			
		} else if (result == -104){
			mes = '服务器资源更换后，账户扣款步骤失败，请联系管理员';
			
		}  else if (result == -105){
			mes = '服务器硬件设配更新失败，请联系管理员';
		} 
		$.messager.show({
			title: '提示',
			msg: mes
		});
		showTaskList(showTaskType);
	});
	
}



//双击
function dblClickRows (tableid) {
	$(tableid).datagrid({  
		onDblClickRow:function(data){  
		  showTaskDetailed(tableid);
	    }  
    });
}

//分页
function pagerFilter(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#mytaskListTab");           
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
