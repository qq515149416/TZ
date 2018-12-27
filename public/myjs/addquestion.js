$(function(){
	$('#add_question').click(function(){
		cleanInfo();
		$('#ip_info').val('请输入IP');
		$('#qestionWindow-ww').dialog("setTitle","追加用户信息").dialog('open');
		
		$("#askMacInfoid").html("请输入机器ip得到用户信息");
		//获得问题分类
		//查询问题第一层分类信息
		$('#question-first-type option').remove();
		$('#question-second-type option').remove();
		$('#question-second-type').hide();
		
		$.post('/members/queryQTypeInfoList.action?parentId=0', null, function(text, status) {
			var questionTypeInfo = $.parseJSON(text);
			$.each(questionTypeInfo, function(n, value) {
				$('#question-first-type').append(
						"<option value='"+value.id+"'>" + value.name + "</option>");
			});
		});
	});
	
	
	$('#ip_info').focus(function(){
		var inbox = $(this).get(0)
		if(inbox.value=='请输入IP'){
			inbox.value='';
		}
			
	});
});

//查询问题分类信息
$("#question-first-type").click(function(){
	$('#question-second-type option').remove();
	$('#question-second-type').hide();
	$.post('/members/queryQTypeInfoList.action?parentId=' + $('#question-first-type').val(), null, function(text, status) {
		var questionTypeInfo = $.parseJSON(text);
		
		var length = 0;
		
		$.each(questionTypeInfo, function(n, value) {
			$('#question-second-type').append(
					"<option value='"+value.id+"'>" + value.name + "</option>");
					length+=1;
		});
		
		if(length > 0){
			$('#question-second-type').show();
		}
	});
	
});

//通过ip得到工单相关信息
$("#search_cus_info").click(function(){
	if($("#ip_info").val() == ''){
		$("#askMacInfoid").html('请输入机器ip得到用户信息');
		 cleanInfo();
		return;
	}
	$.post('customerMan/searchInfobyIP.action?ip_info='+$("#ip_info").val(), null, function(text, status) {
		var ipinfo = JSON.parse(text);
		if(ipinfo.length > 0){
			masterid = ipinfo[0].masterid;
			bizid = ipinfo[0].id;
			customerid = ipinfo[0].customerid;
			truename = ipinfo[0].truename;
			dxip = ipinfo[0].dxip;
			custruename = ipinfo[0].custruename;
			macnum = ipinfo[0].macnum;
			unicomip = ipinfo[0].unicomip;
			
			var str = "#客户名：" + custruename + " #机器编号：" + macnum + " #电信ip:" + dxip + " #联通ip:" + unicomip + " #业务姓名：" + truename;
			$("#askMacInfoid").html(str);
			//检查机器是否有工单未处理完
			var temp = checkAskQuestion(macnum);
			if( temp == "true"){
				$.messager.show({
					title: '提示',
					msg: '此机器已有工单正在处理...'
				});
				$("#submitBtnid").hide();
				return;
			}
			$("#submitBtnid").show();
			var cinfo = 
				{"masterid":masterid
				,"bizid":bizid
				,"customerid":customerid
				,"truename":truename
				,"dxip":dxip
				,"custruename":custruename
				,"macnum":macnum
				,"unicomip":unicomip
				};
			$('#cinfo').val(JSON.stringify(cinfo));
		}else{
			alert("无此信息");
			cleanInfo();
		}
	});
});

//清空相关数据
function cleanInfo(){
	$("#submitBtnid").show();
	$('#cinfo').val('');
	$('#ip_info').val('');
	document.getElementById('webeditfrm').contentWindow.setContent("");
	$("#askMacInfoid").html("请输入机器ip得到用户信息");
}


//针对当前主机提交问题
function cusSubcontent () {
	var contents = document.getElementById('webeditfrm').contentWindow.getEditor(); 
	var qftype = $("#question-first-type").val();
	var qstype = $("#question-second-type").val();
	var cinfo = $('#cinfo').val();
	if(cinfo != ''){
		jcinfo = JSON.parse(cinfo);
		var url = '/members/addQuestion.action';
		var params = 
			{
				"contents":contents,
				"qftype":qftype,
				"qstype":qstype,
				"bizid":jcinfo.bizid,
				"macnum":jcinfo.macnum,
				"unicomip":jcinfo.unicomip,
				"dxip":jcinfo.dxip,
				"customerid":jcinfo.customerid,
				"custruename":jcinfo.custruename
			};
		
			$.post(url,params,function(result){
				if(result){
					$('#qestionWindow-ww').dialog("close");
					document.getElementById('webeditfrm').contentWindow.setContent("");
					showQuestion();
				}else{
					alert("数据插入有误，请联系管理员");
				}
				
			});
		
	}else{
		alert("录入信息有误,请仔细核对");
	}
}


function checkAskQuestion(macnum){
	var url = "/members/checkAskQuestion.action";
	var params = {"macnum":macnum};
	var result = "false";
	$.ajax({
        type : "post",  
         url : url,  
         data : params,  
         async : false,  
         success : function(data){
        	 if(data == "1"){
        		 result = "true";
        	 }else{
        		 result = "false";
        	 }
         }  
    });
	return result;
}
