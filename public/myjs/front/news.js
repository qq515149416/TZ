$(document).ready(function () {
	loadMyNewsDataGrid();
});
var url = undefined; //提交路径
function loadMyNewsDataGrid() {
	//表头
	var dataFiles = ["name","titles","newsstatus","status","createdate",["newsid","sid"]];
	//行内按钮
	var clickbutton = {"aMethod":"updateNewsInfo-修改-editNews-white,newsdelete-删除-newsdelete"};
	//格式化字段
	var formatFileds = {"newsstatus":"0-是,1-否","status":"1-是,0-否"};
	//分页配置
	var pageEvent = {"action":"/fdth/loadMyNews.action"};
	var showTableId = "#newsTid";
	//alert(JSON.stringify(createDataGridJsonRows));
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}
//删除消息
function newsdelete(){
	var str = '确定要删除【'+currRowObjJson.titles+'】消息吗？';
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			url = '/fdth/newsdelete.action';
			$.post(url,{"newsid":currRowObjJson.newsid},function(result){
				queryAllNews();
			});
		}
	});
}
	
//弹出新增窗口
function openWContents(){
	$('#addnewsdiv').dialog('open').dialog('setTitle','发布消息');
	$("#addnewsdiv #titlesid").val('');
}

//查询消息
function queryAllNews (currentPage) {
	//alert(currentPage);
	var url = "/fdth/loadMyNews.action";
	$.ajax({
        url : url,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["name","titles","newsstatus","status","createdate",["newsid","sid"]];
				//行内按钮
				var clickbutton = {"aMethod":"updateNewsInfo-修改-editNews-white,newsdelete-删除-newsdelete"};
				//格式化字段
				var formatFileds = {"newsstatus":"0-是,1-否","status":"1-是,0-否"};
				//分页配置
				var pageEvent = {"action":"/fdth/loadMyNews.action"};
				var showTableId = "#newsTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//更新消息信息
function updateNewsInfo () {
	var content = document.getElementById('webedit').contentWindow.getEditor();
	if (!content) {
		$.messager.alert('提示','内容不能为空！');
		return;
	} else {
		if (content.length <= 20) {
			$.messager.alert('提示','内容不能少于一个中文字或者20个字符！');
			return;
		}
	}
	var titles = $("#newsInfodivid #titlesid").val();
	if (!titles | titles.length > 32) {
		$.messager.alert('提示','标题不能为空和标题不能大于32个中文或者字符！');
		return;
	} else {
		if (titles.length <= 2) {
			$.messager.alert('提示','标题不能少于一个中文字或者2个字符！');
			return;
		}
	}
	var digest = $("#newsInfodivid #digestid").val();
	if(!digest || digest.length >200){
		$.messager.alert('提示','摘要内容不能为空或者过长！');
		return;
	}
	var newsstatus = $("#newsInfodivid #newsstatusid").val();
	var status = $("#newsInfodivid #statusid").val();
	var sid = $("#newsInfodivid #sidid").val();
	var newsid = $("#newsInfodivid #newsid").val();
	var seoKeywords = $("#newsInfodivid #seoKeywordsid").val();
	var seoTitle = $("#newsInfodivid #seoTitleid").val();
	var seoDescription = $("#newsInfodivid #seoDescriptionid").val();
	var params = {"content":content,"titles":titles,"newsstatus":newsstatus,"sid":sid,"newsid":newsid,"status":status,"seoKeywords":seoKeywords,"seoTitle":seoTitle,"seoDescription":seoDescription,"digest":digest};
	$.post('/fdth/upNews.action',params,function(result){
			$('#newsInfodivid').dialog('close');
			document.getElementById('webeditfrm').contentWindow.setContent("");
			queryAllNews();
  	});
}


//保存信息
function saveNews () {
		var content = document.getElementById('webeditfrm').contentWindow.getEditor();
		if (!content) {
			$.messager.alert('提示','内容不能为空！');
			return;
		} else {
			if (content.length <= 20) {
				$.messager.alert('提示','内容不能少于一个中文字或者20个字符！');
				return;
			}
		}
		var titles = $("#addnewsdiv #titlesid").val();
		if (!titles | titles.length > 32) {
			$.messager.alert('提示','标题为空或者标题过长！');
			return;
		}else {
			if (titles.length <= 2) {
				$.messager.alert('提示','标题不能少于一个中文字或者2个字符！');
				return;
			}
		}
		var digest = $("#addnewsdiv #digestid").val();
		if(!digest || digest.length >200){
			$.messager.alert('提示','摘要内容不能为空或者过长！');
			return;
		}
		var newsstatus = $("#addnewsdiv #newsstatusid").val();
		var seoKeywords = $("#addnewsdiv #seoKeywordsid").val();
		var seoTitle = $("#addnewsdiv #seoTitleid").val();
		var seoDescription = $("#addnewsdiv #seoDescriptionid").val();
		var sid = $("#addnewsdiv #sidid").val();
		var status = $("#addnewsdiv #statusid").val();
		var params = {"content":content,"titles":titles,"newsstatus":newsstatus,"sid":sid,"status":status,"seoKeywords":seoKeywords,"seoTitle":seoTitle,"seoDescription":seoDescription,"digest":digest};
		$.post('/fdth/addNews.action',params,function(result){
				$('#addnewsdiv').dialog('close');
				document.getElementById('webeditfrm').contentWindow.setContent("");
				var jsonResult = JSON.parse(result);
				var jsonInfo = JSON.parse(jsonResult.reInfo);
				if(jsonResult.statusCode == 200){
					alert("推送成功，剩余条数为"+jsonInfo.remain);
				}else{
					alert("推送失败，原因是"+jsonInfo.message);
				}
				queryAllNews();
	  	});
}

//弹出编辑客户信息窗口
function editNews(){
	if (currRowObjJson) {
		$('#newsInfodivid').dialog('open').dialog('setTitle','编辑消息'); 
		//填充表格
		//alert(currRowObjJson.newsid);
		$("#newsInfodivid #newsid").val(currRowObjJson.newsid);
		
		$.post('/fdth/queryNewsByIdForEdit.action',{"newsid":currRowObjJson.newsid},function(result){
			var newsinfo = JSON.parse(result);
			$("#newsInfodivid #titlesid").val(mydecode(newsinfo[0].titles));
			$("#newsInfodivid #newsstatusid").val(newsinfo[0].newsstatus);
			$("#newsInfodivid #statusid").val(newsinfo[0].status);
			$("#newsInfodivid #sidid").val(newsinfo[0].sid); 
			$("#newsInfodivid #seoKeywordsid").val(newsinfo[0].seoKeywords); 
			$("#newsInfodivid #seoTitleid").val(newsinfo[0].seoTitle); 
			$("#newsInfodivid #seoDescriptionid").val(newsinfo[0].seoDescription); 
			$("#newsInfodivid #digestid").val(newsinfo[0].digest); 
			document.getElementById('webedit').contentWindow.setContent(mydecode(newsinfo[0].content));
		});
	}
	
}

//搜索功能
function filterSearchidBiz () {
	var name = $("#typeNameFilterid").val();
	var titles = $("#titlesFilterid").val();
	var createdate = $("#createdateFilterid").datebox('getValue'); 
	
	var url = "/fdth/loadMyNews.action";
	var params = {"name":name,"titles":titles,"createdate":createdate};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["name","titles","newsstatus","status","createdate",["newsid","sid","content"]];
        	//行内按钮
        	var clickbutton = {"aMethod":"updateNewsInfo-修改-editNews-white,newsdelete-删除-newsdelete"};
        	//格式化字段
        	var formatFileds = {"newsstatus":"0-是,1-否","status":"1-是,0-否"};
			//分页配置
			if (name) {
				name = encodeURI(encodeURI(name));
			}
			if (titles) {
				titles = encodeURI(encodeURI(titles));
			}
			if (createdate) {
				createdate = encodeURI(encodeURI(createdate));
			}
			var urlParams = "/fdth/loadMyNews.action?urlParams=urlParams&" + "name=" + name + "&titles=" + titles + "&createdate=" + createdate;

			var pageEvent = {"action":urlParams};
			var showTableId = "#newsTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			
		}
	});
}
//时间控件的日期格式
$.fn.datebox.defaults.formatter = function(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return y+'-'+m+'-'+d;
}





