
$(document).ready(function () {
	loadInfo();
});

function loadInfo () {
	if (currRowObjJson) {
		$("#wapdxipid").html(currRowObjJson.dxip);
		$("#wapunipid").html(currRowObjJson.unicomip);
		$("#wapMacnumid").html(currRowObjJson.macnum);
		$("#quesdateid").html(currRowObjJson.quesdate);
		var cl = "等待技术处理";
		if (currRowObjJson.quesstatus == 1) {
			cl = "技术处理中";
			
		} else if (currRowObjJson.quesstatus == 2) {
			cl = "已经处理完成";
		}
		$("#quesstatusid").html(cl)
		loadContent();
	}
	
}
function setQuestionType(qtname1,qtname2){
	var qtype = '';
	if(qtname1!="0"){
		qtype = qtname1;
		if(qtname2 !="0" ){
			qtype = qtype+"-->"+qtname2;
		}
	$("#qtypeid").html(qtype);
	}else{
	$("#qtypeid").html("旧数据无类型匹配");
	}
}

//单独加载内容，因为json格式不兼容的原因
function loadContent () {
	var url = "/technology/queryQuesInfoOnly.action";
	var params = {"id":currRowObjJson.id};
	$.post(url,params,function(result){ 
		var jsondata = JSON.parse(result);
    	var rs = "[" + $.trim(jsondata[0].contents) + "]";
		$("#contentsid").html(rs);
		setQuestionType(jsondata[0].qtname1,jsondata[0].qtname2);
		//加载问题框内容
		loadAnswers();
  	});
}

//加载回答框内容
function loadAnswers () {
	var url = "/technology/queryAnswersInfo.action";
	var params = {"id":currRowObjJson.id};
	$.post(url,params,function(result){
    	var rs = $.trim(result);
    	if (rs) {
    		var jsondata = JSON.parse(rs);
    		var anJson = jsondata["answers"];
    		//0是客户，1是技术，2是业务员
    		var anrole = "业务人员";
			var htmls = '<div class="article3">';
			
			for (var i = 0 ; i < anJson.length; i++) {
				var an = anJson[i];
				var ansper = an.ansper;
	    		if (!ansper) {
	    			ansper = "工作人员";
	    		}
				if (an.anrole == 0) {
					anrole="[客户]";
					htmls += '<div class="demo clearfix"><div class="mes2" >'+ anrole +':'+ ansper +' &nbsp;&nbsp;时间：&nbsp;'+ an.ansdate +'</div><div class="article2">'+ an.answers +'</div></div>';
				} else if (an.anrole == 1) {
					anrole="技术人员";
					htmls += '<div class="demo clearfix fr"><div class="mes" >'+ anrole +':['+ ansper +'] &nbsp;&nbsp;时间：&nbsp;'+ an.ansdate +'</div><div class="article">'+ an.answers +'</div></div>';
				} else {
					htmls += '<div class="demo clearfix fr"><div class="mes" >'+ anrole +':['+ ansper +'] &nbsp;&nbsp;时间：&nbsp;'+ an.ansdate +'</div><div class="article">'+ an.answers +'</div></div>';
				}
			}
			htmls += '<a name="comeHere"></a></div>';
    	}
    	$("#answerContensid").html(htmls);
  	});
}



