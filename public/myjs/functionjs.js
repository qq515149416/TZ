
$(function(){
	setInterval(realodAnswerWin,1000);
})

//针对当前主机提交问题
function subcontent (webeditSubUrl,iframName) {
	if (currRowObjJson) {
		//$(iframName).contents().find("#webeditfrm").val();
		var contents = document.getElementById('webeditfrm').contentWindow.getEditor(); 
		var qfsttype = $("#question-first-type").val();
		var qscdtype = $("#question-second-type").val();
		if ($.trim(contents)=="") {
			$.messager.show({
				title: '提示',
				msg: '请输入内容'
			});
			return;
		}
		var bizid = currRowObjJson.id;
		var macnum = currRowObjJson.macnum;
		var dxip = currRowObjJson.dxip;
		var unicomip = currRowObjJson.unicomip;
		var custid = currRowObjJson.customerid;
		var params = {"contents":contents,"macnum":macnum,"unicomip":unicomip,"dxip":dxip,"custid":custid,"bizid":bizid,"question-first-type":qfsttype,"question-second-type":qscdtype};
		$.post(webeditSubUrl,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				$.messager.show({
					title: '提示',
					msg: '已经成功提交问题！'
				});
				document.getElementById('webeditfrm').contentWindow.setContent("");
				$('#qestionWindow').dialog('close');
			} else {
				$.messager.show({
					title: '错误提示',
					msg: '提交问题失败,请联系管理员！'
				});
			}
	  	});
	}
}

//回答问题
function subAnswers (iframName) {
	var answers = document.getElementById('webeditfrm').contentWindow.getEditor(); 
	if (!answers) {
		$.messager.show({
			title: '提示',
			msg: '请输入回答内容！'
		});
		
	}else {
		if (questionId) {
			url = "/technology/addanswers.action";
			var ansQuesid = questionId;
			var questionStatus = $("#questionStatusId").val();
			var params = {"answers":answers,"quesid":ansQuesid,"questionStatus":questionStatus};
			$.post(url,params,function(result){
				
				var rs = $.trim(result);
				if (rs > 0 ) {
					document.getElementById('webeditfrm').contentWindow.setContent("");
					window.opener.reloadPageData();
					initInfo(1);
					if (questionStatus == 2) {
						//添加总结---------------------------
						initInfo(questionStatus);
					}
				} else {
					$.messager.show({
						title: 'Error',
						msg: '回复问题失败，请联系管理员！'
					});
				}
			});
		}
	}
}

function submitSummary(){

	var summary = document.getElementById('summfr').contentWindow.getEditor(); 
	var qid = questionId;
	var url = "/technology/addSummary.action";
	var params = {"questionId":qid,"summary":summary};
	$.post(url,params,function(result){
	if(result == 1){
		$.messager.show({
			title: '提示',
			msg: '总结填写成功！'
		});
		window.close();
	}else{
		$.messager.alert("提示","插入失败，请检查是否重复插入或者联系管理员！" ,"error");
	}
	});
}

//倒计时刷新当前页面
function realodAnswerWin () {
	if ($("#bottomid")) {
		var i = $("#bottomid").html();
		if (i == 1) {
			location.reload();
		}
		$("#bottomid").html (--i);
	}
}


function loadSummary(id){
	var url="/technology/querySummary.action?questionId="+id;
	$.post(url,null,function(result){
		var jsondata = JSON.parse(result);
		if(jsondata.length > 0){
			$("#summary_divid").show();
			$("#member_nameid").html(jsondata[0].member_name);
			$("#member_summaryid").html(jsondata[0].summary);
		}else{
			$("#summary_divid").show();
			$("#member_nameid").html('');
			$("#member_summaryid").html('未填写');
		}
	});
}

