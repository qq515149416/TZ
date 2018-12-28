

//分页
$(function(){
	$('#newQuestionTab').datagrid({loadFilter:pagerFilter1});
	$('#dealintQuestionTab').datagrid({loadFilter:pagerFilter2});//.datagrid('loadData', getData());
	$('#dealSuccestQuestionTab').datagrid({loadFilter:pagerFilter3});
	
	dblClickRows("#newQuestionTab");
	dblClickRows("#dealintQuestionTab");
	dblClickRows("#dealSuccestQuestionTab");
	//定时执行
	setInterval(reloadPageData, 20000);
	
});

//重载我的问题列表
function reloadPageData () {
	var url = "/technology/reloadCusQues.action";
	//重载未处理问题
	$.post(url,{'quesstatus':'0'},function(result){
    	var rs = $.trim(result);
    	var jsondata = JSON.parse(rs);
    	if (jsondata) {
    		$("#newQuestionTab").datagrid("loadData",jsondata);
    		
    		//重载处理中问题
			$.post(url,{'quesstatus':'1'},function(result){
		    	var rs = $.trim(result);
		    	var jsondata = JSON.parse(rs);
		    	if (jsondata) {
		    		$("#dealintQuestionTab").datagrid("loadData",jsondata);
		    		
		    		//重载已理中问题
					$.post(url,{'quesstatus':'2'},function(result){
				    	var rs = $.trim(result);
				    	var jsondata = JSON.parse(rs);
						$("#dealSuccestQuestionTab").datagrid("loadData",jsondata);
				  	});
		    	}
		  	});
    	}
		
  	});
}


//双击问题展开问题处理详情
function dblClickRows (tableid) {
	$(tableid).datagrid({  
		onDblClickRow:function(data){  
		   cusDealQuestion(tableid);
	    }  
    });
}

//点击处理详情
function cusDealQuestion (id) {
	var row = $(id).datagrid('getSelected');
	if (row) {
/*		//新打开一个窗口后需要用到的数据
		$("#inputContentsid").val(row.contents);
		$("#inputQuesdateid").val(row.quesdate);
		$("#inputAskNameid").val(row.askName);
		$("#inputMacnumid").val(row.macnum);
		$("#inputQuestionid").val(row.qid);
		$("#inputquesstatusid").val(row.quesstatus);
		window.open("/result/technology/dealQuesWindow.jsp","cusdealWins");*/
		window.open("/result/technology/dealQuesWindow.jsp?"
				+ "id=" + row.qid
				+ "&custid=" + row.custid,"manswer");
	}
}




//------分页---------------------------------------
//--------------新问题-----------------------------
function pagerFilter1(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#newQuestionTab");           
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

//--------------处理中问题-----------------------------
function pagerFilter2(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#dealintQuestionTab");           
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

//--------------已经处理的问题-----------------------------
function pagerFilter3(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#dealSuccestQuestionTab");           
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