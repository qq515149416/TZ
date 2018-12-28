


//-----------------分页--------------------------------
function pagerFilter(data){
	if (typeof data.length == 'number' && typeof data.splice == 'function'){
		// is array                
		data = {                    
			total: data.length,                    
			rows: data                
		}            
	}            
	var dg = $("#shelvedTab");           
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
	$('#shelvedTab').datagrid({loadFilter:pagerFilter});//.datagrid('loadData', getData());        
});


//--------格式化-------------
function biztypeFmat (val,row) {
	if (row.biztype==0) {
		return '托管';
	} else if (row.biztype==1){
		return '租用';
	}
}

function macxjstatusFmat (val,row) {
	if (row.macxjstatus==0) {
		return '已上架';
	} else if (row.macxjstatus==1){
		return '客服下架处理中...';
	} else if (row.macxjstatus==3){
		return '已下架';
	} else if (row.macxjstatus==2){
		return '机房处理中...';
	}
}