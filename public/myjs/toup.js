var isRun = undefined;
function aboutrock(){
	isRun =  $("#isRunIncomequery").val();
	if(isRun ==  "on"){
		loadToupData(0,undefined);
		setTimeout(aboutrock, 15000);
	}
}

//分页--------------------------
function pagerFilter1(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#waitdealtabid");           
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

function pagerFilter2(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#toupsuccesstabid");           
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

function pagerFilter3(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#toupexcetabid");           
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

function pagerFilter4(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#toupstarttabid");           
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

//初始加载-------------------------------------------------------
$(function(){
	clickToupTab();
	$('#waitdealtabid').datagrid({loadFilter:pagerFilter1});
	$('#toupsuccesstabid').datagrid({loadFilter:pagerFilter2});
	$('#toupexcetabid').datagrid({loadFilter:pagerFilter3});
	$('#toupstarttabid').datagrid({loadFilter:pagerFilter4});
	dblClickRows("checkToUpid","waitdealtabid");
	dblClickRows("checkToUpid","toupstarttabid");
	dblClickRows("checkToUpid","toupsuccesstabid");
	dblClickRows("checkToUpid","toupexcetabid");
});


//双击展开
function dblClickRows (winid,tableid) {
	var tid = "#" + tableid;
	$(tid).datagrid({  
		onDblClickRow:function(data){
		   showWin(winid,tableid);
		   //$("#bookedid").show();
	    }  
    });
}

//数据加载---------------------------------------------------------
//当前选中的tab
var selectTabFalg = 0;
function clickToupTab () {
	$('#toupid').tabs({
	    border:false,
	    onSelect:function(title){
	        if (title.indexOf ("待处理") != -1) {
	        	$("#isRunIncomequery").val("on");
	        	aboutrock();
	        	loadToupData(0,undefined);
	        	selectTabFalg = 0;
	        	
	        } else if (title.indexOf ("充值成功") != -1) {
	        	loadToupData(1,undefined);
	        	selectTabFalg = 1;
	        	$("#isRunIncomequery").val("off");
	        	} else if (title.indexOf ("拒绝充值") != -1) {
	        	loadToupData(2,undefined);
	        	selectTabFalg = 2;
	        	$("#isRunIncomequery").val("off");
	        } else if (title.indexOf ("星标数据") != -1) {
	        	loadToupData(3,undefined);
	        	selectTabFalg = 3;
	        	$("#isRunIncomequery").val("off");
	        }
	    }
	});
}



//加载充值记录
function loadToupData (type,param) {
	var url = "/financ/loadToupData.action";
	var params = {"paystatus":type};
	if (!param) {
		if (type == 3) {
			params = {"startfalg":1};
		} else {
			params = {"paystatus":type};
		}
		
	} else if (param){
		params = param;
	}
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs) {
			var jsondata = JSON.parse(rs);
			var tab = "";
			if (type == 0) {
				tab = "#waitdealtabid";
				
			} else if (type == 1) {
				tab = "#toupsuccesstabid";
				
			} else if (type == 2) {
				tab = "#toupexcetabid"
				
			} else if (type == 3) {
				tab = "#toupstarttabid"
				
			}
			$(tab).datagrid("loadData",jsondata);
		}
	});
}


//打开指定窗口
function showWin (winid,tabid) {
	var id = "#" + winid;
	tabid = "#" + tabid;
	var row = $(tabid).datagrid('getSelected');
	/*if(row.paystatus == 1){
		$("#moneysid").attr("readonly","readonly");
	}else{
		$("#moneysid").removeAttr("readonly");
	}*/
	addEvent("moneysid",moneyMes);
	addEvent("taxid",moneyMes);
	if (row) {
		$(id).dialog('open').dialog('setTitle','信息窗口');
		$("#payid").html(row.id);
		$("#masnameid").html(row.mastruename);
		$("#cusnameid").html(row.custruename);
		$("#moneysidhid").val(row.payamount);//金额隐藏值,用于判断是否有修改过金额
		$("#moneysid").val(row.payamount);
		$("#taxid").val(row.tax);
		$("#taxMoneyid").html(row.taxmoney);
		$("#cwnoteid").val(row.cwnote);
		$("#toupcusid").val(row.cusid);
		if(row.paystatus == 1){
			$('#touprecdateid').datetimebox('setValue',row.getdate);
		}else{
			$('#touprecdateid').datetimebox('setValue',row.paydate);
		}
		var bank = row.bank;
		var selectval = "<option selected=selected>"+bank+"</option>" +
						"<option>腾正公帐（建设银行）</option>" +
						"<option>腾正公帐（工商银行）</option>" +
						"<option>腾正公帐（招商银行）</option>" +
						"<option>腾正公帐（农业银行）</option>" +
						"<option>正易公帐（中国银行）</option>" +
						"<option>支付宝</option>" +
						"<option>公帐支付宝</option>" +
						"<option>财付通</option>" +
						"<option>微信支付</option>";
		$("#bankid").html(selectval);
		$("#bankaccountid").val(row.bankaccount);
		$("#toupnoteid").val(row.note);
		
		//判断功能按钮
		//拒绝充值   
		if (tabid == "#toupexcetabid") {
			$("#bookedid").show();
			$("#refusedToupid").hide();
			$("#startToupid").show();
			$("#editid").hide();
			
			//充值成功
		} else if(tabid == "#toupsuccesstabid"){
			$("#bookedid").hide();
			$("#refusedToupid").hide();
			$("#startToupid").show();
			$("#editid").show();
			
			//星标数据
		}else if (tabid == "#toupstarttabid") {
			$("#startToupid").hide();
			if (row.paystatus == 0) {//待充值
				$("#bookedid").show();
				$("#refusedToupid").show();
				$("#editid").hide();
			} else if (row.paystatus == 1) {//充值成功
				$("#bookedid").hide();
				$("#refusedToupid").hide();
				$("#editid").show();
			}else{//拒绝充值
				$("#bookedid").show();
				$("#refusedToupid").hide();
				$("#editid").hide();
			}
			
		//待处理
		} else {
			$("#bookedid").show();
			$("#refusedToupid").show();
			$("#startToupid").show();
			$("#editid").hide();
		}
	}
	
}
//充值焦点事件
function moneyMes () {
	var moneyval = $("#moneysid").val();//充值金额
	var taxval = $("#taxid").val();//税额
	if(moneyval =='' ){
		moneyval = 0;
	}
	if( taxval == ''){
		taxval = 0;
		$("#taxid").val(0);
	}
//	var taxmoney =  parseInt(moneyval) + parseInt(taxval);//到账金额
//	$("#taxMoneyid").html(taxmoney);
	$("#moneysid").val(parseFloat(moneyval).toFixed(2)) ;
	$("#taxid").val(parseFloat(taxval).toFixed(2)) ;
	var taxmoney =  parseFloat(moneyval) + parseFloat(taxval);//到账金额
	$("#taxMoneyid").html(taxmoney.toFixed(2));
}

//拒绝充值
function refusedToup () {
	var paystatus = 2;
	var id = $("#payid").html();
	var cwnote = $("#cwnoteid").val();
	var url = "/financ/updateToupInfo.action";
	var params = {"cwnote":cwnote,"id":id,"paystatus":paystatus};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$.messager.show({
				title: '提 示',
				msg: '系统已经拒绝充值'
			});
			$("#cwnoteid").val('');
			$("#checkToUpid").dialog("close");
			loadToupData(selectTabFalg,undefined);
		} else {
			$.messager.show({
				title: 'ERROR',
				msg: '拒绝充值失败，请联系管理员!'
			});
		}
	});
}


//星标数据
function startToup (startStatu) {
	var startfalg = 1;
	if (startfalg) {
		startfalg = startStatu;
	}
	
	var id = $("#payid").html();
	var cwnote = $("#cwnoteid").val();
	var url = "/financ/updateToupInfo.action";
	var params = {"cwnote":cwnote,"id":id,"startfalg":startfalg};
	
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$("#cwnoteid").val('');
			$("#checkToUpid").dialog("close");
			loadToupData(selectTabFalg,undefined);
		} else {
			$.messager.show({
				title: 'ERROR',
				msg: '操作失败，请联系管理员!'
			});
		}
	});
}

//提交充值入账
function booked (temp) {
	$("#bookedid").hide();
	var controlType = "";
	if(temp=='0'){
		controlType = "toupSuccess";
	}
	var payamount = $("#moneysid").val();
	var tax = $("#taxid").val();
	var taxMoney = $("#taxMoneyid").html();
	var bank = $("#bankid").val();
	var bankaccount = $("#bankaccountid").val();
	var cwnote = $("#cwnoteid").val();
	var id = $("#payid").html();
	var cusid = $("#toupcusid").val();
	var getdate = $('#touprecdateid').datetimebox('getValue');
	var paystatus = 1;
	var url = "/financ/updateToupInfo.action";
	var params = {"payamount":payamount,"tax":tax,"taxMoney":taxMoney,"bank":bank,"bankaccount":bankaccount,"cwnote":cwnote,"getdate":getdate,"id":id,"paystatus":paystatus,"cusid":cusid,"controlType":controlType};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			if(temp=='0'){
				$.messager.show({
					title: '提 示',
					msg: '入账成功'
				});
			}else{
				$.messager.show({
					title: '提 示',
					msg: '修改成功'
				});
			}
			$("#cwnoteid").val('');
			$("#checkToUpid").dialog("close");
			loadToupData(selectTabFalg,undefined);
		} else {
			if(temp=='0'){
				$.messager.show({
					title: 'ERROR',
					msg: '入账失败，请联系管理员!'
				});
			}else{
				$.messager.show({
					title: 'ERROR',
					msg: '修改失败，请联系管理员!'
				});
			}
		}
	});
}

//展示节点
function filterColumnsToup (showid) {
	var id = "#" + showid;
	$(id).show();
}


//提交条件模糊查询
function subToupFilters (divid,currtab) {
	var id = "#" + divid;
	var cusid = $(id + " #cusid").val();
	var mastruename = $(id + " #mastruename").val();
	var custruename = $(id + " #custruename").val();
	var bank = $(id + " #bank").val();
	var payamount = $(id + " #payamount").val();
	var note = $(id + " #note").val();
	var cwnote = $(id + " #cwnote").val();
	var getdate = $("#sgetdate").datebox('getValue');
	var tpaydatefalg = "";
	
 	if (currtab == 0) {
    	tpaydatefalg = "#wpaydate";
    	
    } else if (currtab == 1) {
    	tpaydatefalg = "#spaydate";
    	
    } else if (currtab == 2) {
    	tpaydatefalg = "#rpaydate";
    	
    } else if (currtab == 3) {
    	tpaydatefalg = "#tpaydate";
    }
	var paydate = $(tpaydatefalg).datebox('getValue');
	
	var params = {"paystatus":currtab,"cusid":cusid,"mastruename":mastruename,"custruename":custruename,"bank":bank,
		"payamount":payamount,"getdate":getdate,"paydate":paydate,"note":note,"cwnote":cwnote};
	loadToupData(currtab,params);
}





//格式化-------------------------------------------------
function cusnameFam (val,row) {
	if (row.startfalg == 1) {
		return '<img src="/images/xingbiao2.png"/>' + val;
	} else {
		return val;
	}
}

function ptFam (val,row) {
	if (val == 0) {
		return "待充值";
		
	} else if (val == 1) {
		return "充值成功";
		
	} else if (val == 2) {
		return "已拒绝";
	}
}


