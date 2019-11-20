//首页初始化完毕加载消息
window.onload=loads;
function loads(){
	loadstype("cdynamic");//公司动态
	loadstype("announcement");//公告
//	loadstype("mtynamic")//媒体报道---无
	loadstype("idynamic")//行业动态
}
//按类型加载消息
function loadstype(typevalue){
	if(typevalue=="cdynamic"){
		$.post(typevalue,null,function(data){
			$("#news-gsdt").html(data);
		});
	}
	if(typevalue=="mtynamic"){
		$.post(typevalue,null,function(data){
			$("#news-mtbd").html(data);
		});
	}
	if(typevalue=="idynamic"){
		$.post(typevalue,null,function(data){
			$("#news-hydt").html(data);
		});
	}
	if(typevalue=="announcement"){
		$.post(typevalue,null,function(data){
			$("#news-mtbd").html(data);
		});
	}
}