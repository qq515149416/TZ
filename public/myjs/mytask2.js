

//初始化
$(function(){
	loadinit();
});

//更改当前显示内容
function loadinit () {
	var params = {};
	var url = "/login/loadTasks.action";
	$.post(url,params,function(result){
		afterLoadUI("#showTaskid",result);
  	});
}

