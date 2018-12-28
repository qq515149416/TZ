$(function(){
	var customerid = custid_g;
	var qid = id_g;
	initHistoryTable(customerid,qid);
});


function initHistoryTable(customerid,qid){
	$('#orderListTable').datagrid({
		singleSelect:true,
		fitColumns:true,
		columns:[[
		  		{field:'quesdate',title:'提交时间',width:124},
		  		{field:'contents',title:'工单内容',width:470}
		  	]],
		onClickRow:function(rowIndex,rowData){
			jumpToHistoryOrder(rowData);
		 },
		  });
	loadHistory(1);
}

function jumpToHistoryOrder(rowData){
	if(rowData){
		window.open("/result/technology/dealQuesWindow.jsp?"
				+ "id=" + rowData.id
				+ "&his=1"
				+ "&custid=" + rowData.custid,"manswer_history");
	}
}
var totalPages = 1;
var currPage = 1;
function loadHistory(page){
	var customerid = custid_g;
	var qid = id_g;
	var params = {
			"custid":customerid,
			"qid":qid,
			"page":page
	}
	var url = "/technology/historyList.action";
	$.ajax({  
        type : "post",  
         url : url,  
         data : params,  
         async : false,  
         success : function(result){ 
     		var rs = $.trim(result);
     		var rsJson = JSON.parse(rs);
     		$('#orderListTable').datagrid("loadData",JSON.parse(rsJson.rows));
     		$('#total').html(rsJson.total);
     		$('#pageinfo').html(rsJson.page + '/' + rsJson.pages);
     		totalPages = rsJson.pages;
     		currPage = rsJson.page;
         }
    }); 
}

function gotoFirstPage(){
	if(parseInt(currPage) != 1){
		loadHistory(1);
	}
}

function gotoLastPage(){
	if(parseInt(currPage) != parseInt(totalPages)){
		loadHistory(totalPages);
	}
}

function nextPage(){
	if(parseInt(currPage) < totalPages){
		loadHistory(parseInt(currPage)+1);
	}
}

function prePage(){
	if(parseInt(currPage) > 1){
		loadHistory(parseInt(currPage)-1);
	}
}
