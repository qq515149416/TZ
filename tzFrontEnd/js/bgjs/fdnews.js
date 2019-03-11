
//下一页
function newxPage(){
	var curr = $("#page").text();
	var sid =$("#typesid").val();
	var currPage = parseFloat(1)+parseFloat(curr) ;
	var allpage = $("#allpage").text();
	if(currPage>allpage){
		return;
	}
	var params = {"currPage":currPage,"sid":sid};
		$.post('/fdth/Newstype.action',params,function(data){
			$("#main-wrapper").html(data);
		});
}
//上一页
function upPage(){
	var curr = $("#page").text();
	var sid =$("#typesid").val();
	var currPage = parseFloat(curr) - parseFloat(1);
	if(currPage<1){
		return;
	}
	var params = {"currPage":currPage,"sid":sid};
	$.post('/fdth/Newstype.action',params,function(data){
		$("#main-wrapper").html(data);
	});
}
//首页
function firstPage(){
	var curr = $("#page").text();
	var sid =$("#typesid").val();
	var currPage = curr;
	if(currPage==1){
		return;
	}
	var params = {"currPage":1,"sid":sid};
	$.post('/fdth/Newstype.action',params,function(data){
		$("#main-wrapper").html('');
		$("#main-wrapper").html(data);
	});
}
//尾页
function lastPage(){
	var sid =$("#typesid").val();
	var currPage = $("#page").text();
	var allpage = $("#allpage").text();
	if(currPage==allpage){
		
		return;
	}
	var currPage = $("#allpage").text();
	var params = {"currPage":currPage,"sid":sid};
	$.post('/fdth/Newstype.action',params,function(data){
		$("#main-wrapper").html(data);
	});
}

//首页请求最新消息
function loadmore(){
	var params = {"type":"more","sid":-1};
	$.post('/fdth/loadNewstype.action',params,function(data){
		window.location.href="/tz/zynews.jsp"
	});
}
//首页请求消息详情
function loadid(value){
	var newsid = value;
	var params = {"newsid":newsid};
	$.post('/fdth/loadNewsid.action',params,function(data){
		window.location.href="/tz/zyfdcontent.jsp"
	});
}
//请求消息类型
function findsid(value){
	var sid = value;
	var params = {"sid":sid};
	$.post('/fdth/loadNewstype.action',params,function(data){
		window.location.href="/tz/zynews.jsp"
	});
}