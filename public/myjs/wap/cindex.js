

$(document).ready(function(){
	$.post('/wap/cus/buttons.jsp',"",function(result){
		$("#wapcusContentsid").html(result);
  	});
});


//控制定时刷新用的
var timeWapcusquestions = undefined;
var timeWapcusmac = undefined;
function reloadWapcusquestions () {
	timeWapcusquestions = setInterval(wapcusquestions,600000);
}
function realodTimeWapcusmac () {
	timeWapcusmac = setInterval(wapcusmac,600000);
}
function removeTimeQues () {
	clearInterval(timeWapcusquestions);
}
function removeTimeAsk () {
	clearInterval(realodTimeWapcusmac);
}


//故障列表
function wapcusquestions () {
	var url = "/technology/wapqueryQuestions.action";
	var params = {};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
		$("#wapcusContentsid").html(rs);
  	});
}


//我的机器
function wapcusmac () {
	var url = "/members/queryMyMac.action";
	var params = {"wap":"wap"};
	$.post(url,params,function(result){
		$("#wapcusContentsid").html($.trim(result));
  	});
}

//针对当前主机提交问题
function cusSubcontent (webeditSubUrl,iframName) {
	if (currRowObjJson) {
		var contents = document.getElementById('webeditfrm').contentWindow.getEditor(); 
		if (!$.trim(contents)) {
			return;
		}
		var macnum = currRowObjJson.macnum;
		var dxip = currRowObjJson.dxip;
		var unicomip = currRowObjJson.unicomip;
		var bizid = currRowObjJson.id;
		var qfsttype = $("#question-first-type").val();
		var qscdtype = $("#question-second-type").val();
		var params = {"contents":contents,"macnum":macnum,"unicomip":unicomip,"dxip":dxip,"bizid":bizid,"question-first-type":qfsttype,"question-second-type":qscdtype};
		$.post(webeditSubUrl,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				document.getElementById('webeditfrm').contentWindow.setContent("");
			}
	  	});
	}
}

//回答问题
function subAnswers () {
	var answers = document.getElementById('webeditfrm').contentWindow.getEditor();
	if (!$.trim(answers)) {
		return;
		
	}else {
		if (currRowObjJson) {
			url = "/technology/addanswers.action";
			var ansQuesid = currRowObjJson.id;
			var questionStatus = $("#quesstatusid").html();
			var params = {"answers":answers,"quesid":ansQuesid,"questionStatus":questionStatus};
			$.post(url,params,function(result){
				var rs = $.trim(result);
				if (rs > 0 ) {
					document.getElementById('webeditfrm').contentWindow.setContent("");
					loadAnswers();
				}else{
					
				} 
			});
		}
	}
}


//白名单
function gowhitelistPage () {
	$.post('/wap/cus/whiteList.jsp','',function(result){
		var rs = $.trim(result);
		$("#wapcusContentsid").html(rs);
	});
}
