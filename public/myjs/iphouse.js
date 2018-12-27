$(document).ready(function() {
	 loadIPnum( );
	 loadCompRoom ();//加载机房下拉
});
function loadIPnum( ){ 
	$("#dxipz").html(dxJsonRows.ipnum.totalz);
	$("#dxips").html(dxJsonRows.ipnum.locktotal);
	$("#dxipw").html(dxJsonRows.ipnum.notUsedtotal);
	$("#dxipy").html(dxJsonRows.ipnum.usedtotal);
	
	$("#unipz").html(unJsonRows.ipnum.totalz);
	$("#unips").html(unJsonRows.ipnum.locktotal);
	$("#unipw").html(unJsonRows.ipnum.notUsedtotal);
	$("#unipy").html(unJsonRows.ipnum.usedtotal);
}
//--------格式化-------------
function ipstatusFmat (val,row) {
	if (row.ipstatus==0) {
		return '未使用';
	} else if (row.ipstatus==4){
		return '锁 定';
	} else {
		return '已使用';
	} 
}

//----分页-----------------------------------------------
function pagerFilter(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#dxipTab");           
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

function pagerFilter1 (data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#unipTab");           
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

$(function(){            
	$('#dxipTab').datagrid({loadFilter:pagerFilter});//.datagrid('loadData', getData());
	$('#unipTab').datagrid({loadFilter:pagerFilter1});
});

//高级查询控件
function showgj (id) {
	var sh = document.getElementById(id).style.display;
	if (sh) {
	  	if (sh == "none") {
	  		sh = "block";
	  	} else {
	  		sh = "none";
	  	}
	  	document.getElementById(id).style.display = sh;
	}
}

//修改IP信息
function updateIP (iptype) {
	var row = undefined;
	var iptext = "修改联通IP信息";
	if (iptype == "dxip") {
		 iptext = "修改电信IP信息";
		 $("#uipTextId").html('电信IP：');
		 $("#uiptypeId").val('dxip');
		 row = $('#dxipTab').datagrid('getSelected');
		 if (row) {
			 $("#ubeginipvalid").val(row.dxip);
		 }
		 
	} else {
		$("#uipTextId").html('联通IP：');
		$("#uiptypeId").val('unip');
		row = $('#unipTab').datagrid('getSelected');
		if (row) {
			$("#ubeginipvalid").val(row.unip);
		}
	}
	loadCompRoom2();
	$("#comprooms").combobox("setValue",mydecode(row.comproomid));
	$("#comprooms").combobox("setText",mydecode(row.comproom));
	if (row) {
		$("#uvlanid").val(row.vlan);
		$("#uipNoteid").val(row.note);
		$('#updateipdiv').dialog('open').dialog('setTitle',iptext);
	}
}

//更新IP信息
function updateIpInfo () {
	var iptype = $("#uiptypeId").val();
	var note = $("#uipNoteid").val();
	var vlan = $("#uvlanid").val();
	var comproom = $("#comprooms").combobox('getValue');
	var row = $('#unipTab').datagrid('getSelected');
	if (!row) {
		 row = $('#dxipTab').datagrid('getSelected');
	}
	if (row) {
		var params = {};
		if (iptype == "dxip") {
			params = {"note":note,"vlan":vlan,"iptype":"dxip","id":row.id,"comproom":comproom};
		} else if (iptype == "unip") {
			row = $('#unipTab').datagrid('getSelected');
			params = {"note":note,"vlan":vlan,"iptype":"unip","id":row.id,"comproom":comproom};
		}
		var str = "确定要修改IP的信息吗？";
		$.messager.confirm('Confirm',str,function(r){
			if (r) {
				var url = "/customerserv/updateIpInfo.action";
				$.post(url,params,function(result){
					var rs = $.trim(result);
					var jsondata = JSON.parse(rs);
					if (iptype == "unip") {
						$("#unipTab").datagrid("loadData",jsondata);
						
					} else if (iptype == "dxip") {
						$("#dxipTab").datagrid("loadData",jsondata);
					}
					
				});
			}
		});
		$('#updateipdiv').dialog('close');
	}
	
}


//新增IP
function showAddIp (iptype) {
	var iptext = "新增联通IP";
	if (iptype == "dxip") {
		 iptext = "新增电信IP";
		 $("#ipTextId").html('电信IP：');
		 $("#iptypeId").val('dxip');
	} else {
		$("#ipTextId").html('联通IP：');
		$("#iptypeId").val('unip');
	}
	$("#comproomid3").val('');
	$("#comproomidTisp").html('');
	$('#addipdiv').dialog('open').dialog('setTitle',iptext);
}

//提交新增ip
function addIp () {
	//选择机房
	var comproom = $("#comproomid3").val();
	if(comproom==''){
		$("#comproomidTisp").html('*请选择机房');
		return;
	}
	//验证输入格式
	var checkbeginIp = valiInput(IP,"beginipvalid","beginipvalidImg",true,'IP格式有误');
	//checkendIp,非必填项,所有初始化为true,为了通过验证.
	var checkendIp = true;
	var endip = $("#endipvalid").val();
	var beginip = $("#beginipvalid").val();
	var addiptype = $("#iptypeId").val();
	var vlan = $("#vlanid").val();
	var note = $("#ipNoteid").val();
	if (!vlan) {
		vlan = 1;
	}
	var str = '是否添加IP [' + beginip +"]?";
	//用于分解IP验证IP段
	var endipsp = "";
	var beginipsp = "";
	if (endip) {
		//endipsp如果结束框也输入了IP地址，表示将要添加多个IP，即IP段添加。
		checkendIp = valiInput(IP,"endipvalid","endipvalidImg");
		endipsp = endip.split(".");
		str = '是否批量添加IP从 [' + beginip +"] 到 [" +endip+ "]?";
	}
	
	if (checkbeginIp && checkendIp) {
		//批量添加时,判断IP是否同一段
		beginipsp = beginip.split(".");
		
		//判断是否合法的IP段
		if (endipsp) {
			if (beginipsp[0]!=endipsp[0] || beginipsp[1]!=endipsp[1] || beginipsp[2]!=endipsp[2]) {
				$("#errorsip").html('输入的为非法IP段!');
				checkImgShow("#beginipvalidImg",0);
				checkImgShow("#endipvalidImg",0);
				$("#endipvalid").focus();
				return;
			}
			//判断库中是否有已经在的IP，分两种情况，此处是IP段录入.
			ipIsNotExit = checIPisexit(addiptype,beginip,endip);
			if (ipIsNotExit == true) {
				return;
			}
			
		} else {
			//判断库中是否有已经在的IP，分两种情况，此处是单IP录入.
			var ipIsNotExit = checIPisexit(addiptype,beginip);
			if (ipIsNotExit == true) {
				return;
			}
		}
		//所有验证成功
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerserv/addIpWarehouse.action";
				var params = {"iptype":addiptype,"beginip":beginip,"endip":endip,"vlan":vlan,"note":note,"comproom":comproom};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					var jsondata = JSON.parse(rs);
					if (addiptype == "unip") {
						$("#unipTab").datagrid("loadData",jsondata);
						$("#unipz").html(jsondata.ipnum.totalz);
						$("#unips").html(jsondata.ipnum.locktotal);
						$("#unipw").html(jsondata.ipnum.notUsedtotal);
						$("#unipy").html(jsondata.ipnum.usedtotal);
						
					} else if (addiptype == "dxip") {
						$("#dxipTab").datagrid("loadData",jsondata);
						$("#dxipz").html(jsondata.ipnum.totalz);
						$("#dxips").html(jsondata.ipnum.locktotal);
						$("#dxipw").html(jsondata.ipnum.notUsedtotal);
						$("#dxipy").html(jsondata.ipnum.usedtotal);
					}
					$("#endipvalid").val('');
					$("#beginipvalid").val('');
					$('#addipdiv').dialog('close');
				});
			}
		});
		$("#errorsip").html('');
		checkImgShow("#beginipvalidImg",1);
		checkImgShow("#endipvalidImg",1);
	}
}


//锁定IP
function lockIp (iptype) {
	var row = undefined;
	if (iptype == "unip" || iptype == "unlockunip") {
		row = $('#unipTab').datagrid('getSelected');
		
	} else if (iptype == "dxip" || iptype == "unlockdxip") {
		row = $('#dxipTab').datagrid('getSelected');
	}
	if (row) {
		//ipstatus=4锁定，ipstatus=0解锁.
		var ipstatusParam = 4;
		//点击了解锁
		if (iptype == "unlockunip" || iptype == "unlockdxip") {
			if (row.ipstatus && row.ipstatus != 4) {
				$.messager.alert("提示","此IP没有锁定，不能解锁！");
				return;
			}
			ipstatusParam = 0;
			//后台统一读取这个参数名称，标识为操作联通IP.
			if (iptype == "unlockunip") {
				iptype = "unip";
				
			} else {
				iptype = "dxip";
			}
			
		} else {
			//点击锁定,只有为未使用的IP才能锁定.
			if (row.ipstatus && row.ipstatus != 0) {
				$.messager.alert("提示","此IP已经使用中，不能锁定！");
				return;
			}
			//后台统一读取这个参数名称，标识为操作电信IP.
			if (iptype == "unip") {
				iptype = "unip";
				
			} else {
				iptype = "dxip";
			}
		}
		
		var url = "/customerserv/ipStatus.action";
		var params = {"iptype":iptype,"ipstatus":ipstatusParam,"id":row.id};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			var jsondata = JSON.parse(rs);
			if (iptype == "unip") {
				$("#unipTab").datagrid("loadData",jsondata);
				$("#unipz").html(jsondata.ipnum.totalz);
				$("#unips").html(jsondata.ipnum.locktotal);
				$("#unipw").html(jsondata.ipnum.notUsedtotal);
				$("#unipy").html(jsondata.ipnum.usedtotal);
				
			} else if (iptype == "dxip") {
				$("#dxipTab").datagrid("loadData",jsondata);
				$("#dxipz").html(jsondata.ipnum.totalz);
				$("#dxips").html(jsondata.ipnum.locktotal);
				$("#dxipw").html(jsondata.ipnum.notUsedtotal);
				$("#dxipy").html(jsondata.ipnum.usedtotal);
			}
		});
	}
}


//高级查询
function searchIP(iptype) {
	var ipVal = undefined;
	var comproomVal = undefined;
	if (iptype) {
		if (iptype == "dxip") {
			ipVal = $("#dxipId").val();
			comproomVal = $("#comproomid1").val();
			
		} else if (iptype == "unip") {
			ipVal = $("#unipId").val();
			comproomVal = $("#comproomid2").val();
		}
		/*if (!ipVal) {
			return;
		}*/
		var url = "/customerserv/searchIps.action";
		var params = {"iptypeSearchIP":iptype,"ipValSearchIP":ipVal,"searchip":"searchip","comproom":comproomVal};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			var jsondata = JSON.parse(rs);
			if (iptype == "unip") {
				$("#unipTab").datagrid("loadData",jsondata);
				
			} else if (iptype == "dxip") {
				$("#dxipTab").datagrid("loadData",jsondata);
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
	var sl1=$("#comproomid1");
	var sl2=$("#comproomid2");
	var sl3=$("#comproomid3");
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
					sl1.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
					sl2.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
					sl3.append("<option value='"+comproomid+"'>"+comproomname+"</option>");
				}
			}
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
			$("#comprooms").combobox('loadData',jsondata);
		}
  	});
}
