function makelink(ip) {
	//根据人员身份信息跳转
	if(userGroup == 'business' || userGroup == "superuser" ||　userGroup == 'wwman' ||　userGroup == 'ywjl'  ||　userGroup == 'dkhbjl' ||　userGroup == 'dkhbry' ||　userGroup == 'scbjl'  ||　userGroup == 'wgman' ){
		askQuestion_gb(ip);
	}
}
$(function(){
	$('#question-first-type-gb option').remove();
	$('#question-second-type-gb option').remove();
	$('#question-second-type-gb').hide();
});

// 弹出提问输入窗口
function askQuestion_gb(ip) {
	var temp = checkAskQuestion();
	if( temp == "true"){
		$.messager.show({
			title: '提示',
			msg: '此机器已有工单正在处理...'
		});
		return;
	}
	cleanInfo_gb();
	//由ip得主机信息
	$('#addOrder').dialog('open').dialog('setTitle', '提问问题窗口');
	$.ajax({ 
        type : "post",  
         url : 'customerMan/searchInfobyIP.action?ip_info='+ip,  
         data : null,  
         async : false,  
         success : function(text) {
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
    			var cinfo = {
    				"masterid" : masterid,
    				"bizid" : bizid,
    				"customerid" : customerid,
    				"truename" : truename,
    				"dxip" : dxip,
    				"custruename" : custruename,
    				"macnum" : macnum,
    				"unicomip" : unicomip
    			};
    			$('#cinfo_gb').val(JSON.stringify(cinfo));
    			var str = "#客户名：" + custruename + " #机器编号：" + macnum + " #电信ip:" + dxip + " #联通ip:" + unicomip + " #业务姓名：" + truename;
    			$("#askMacInfoid-gb").html(str);
    		}else{
    			alert("无此信息");
    			cleanInfo_gb();
    			$('#addOrder').dialog('close');
    			}
    		} 
    }); 
	// 查询问题第一层分类信息
	$('#question-first-type-gb option').remove();
	$('#question-second-type-gb option').remove();
	$('#question-second-type-gb').hide();
	
	$.ajax({  
        type : "post",  
         url : '/members/queryQTypeInfoList.action?parentId=0',  
         data : null,  
         async : false,  
         success :function(
     			text, status) {
     		var questionTypeInfo = $.parseJSON(text);
     		$.each(questionTypeInfo, function(n, value) {
     			$('#question-first-type-gb').append(
     					"<option value='" + value.id + "'>" + value.name
     							+ "</option>");
     		});
     	}
    }); 
	
}
// 查询问题分类信息
$("#question-first-type-gb").change(function() {
			$('#question-second-type-gb option').remove();
			$('#question-second-type-gb').hide();
			$.ajax({  
		         type : "post",  
		          url : '/members/queryQTypeInfoList.action?parentId='
						+ $('#question-first-type-gb').val(),  
		          data : null,  
		          async : false,  
		          success :function(text,
							status) {
					var questionTypeInfo = $.parseJSON(text);
					var length = 0;
					$.each(questionTypeInfo, function(n, value) {
						$('#question-second-type-gb').append(
								"<option value='" + value.id + "'>" + value.name
										+ "</option>");
						length += 1;
					});
					if (length > 0) {
						$('#question-second-type-gb').show();
					}
				}
		     }); 
			

		});

//针对当前主机提交问题
function cusSubcontent_gb() {
	var contents = document.getElementById('webeditfrm-gb').contentWindow.getEditor(); 
	var qftype = $("#question-first-type-gb").val();
	var qstype = $("#question-second-type-gb").val();
	var cinfo = $('#cinfo_gb').val();
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
					$('#addOrder').dialog("close");
					document.getElementById('webeditfrm-gb').contentWindow.setContent("");
					$.messager.show({
									title: '提 示',
									msg: '提交成功，请待审核....',
									timeout:3000
									});
					//根据人员身份信息跳转
					if(userGroup == 'business' ||userGroup == 'ywjl'  ||　userGroup == 'dkhbjl' ||　userGroup == 'dkhbry' ||　userGroup == 'scbjl'){
						var url = "/customerMan/mycusques.action";
					}else if(userGroup == 'wwman' || userGroup == "superuser"|| userGroup == "wgman"){
						var url = "/technology/waitdeal.action";
					}else{
						alert("没有操作权限，请联系管理员");
						return;
					}
					$.post(url,params,function(result){
						AddRunningDiv();
						afterLoadUI("#bgcenterid",result);
						MoveRunningDiv();
					});
				}else{
					alert("数据插入有误，请联系管理员");
					document.getElementById('webeditfrm-gb').contentWindow.setContent("");
				}
				
			});
		
	}else{
		alert("录入信息有误,请仔细核对");
		document.getElementById('webeditfrm-gb').contentWindow.setContent("");
	}
}

function cleanInfo_gb(){
	$('#question-second-type-gb option').remove();
	$('#question-second-type-gb').hide();
	$("#askMacInfoid-gb").html("");
	$('#cinfo_gb').val('');
	document.getElementById('webeditfrm-gb').contentWindow.setContent("");
}

//查看主机信息
function queryMacInfo_gb (v) {
	if (currRowObjJson) {
		var params = {"macnum":currRowObjJson.macnum,"biztype":currRowObjJson.biztype,"id":currRowObjJson.id};
		url = '/customerserv/queryMacInfo.action';
		$.post(url,params,function(result){
			$("#gbmacInfoDivId").html(result);
    		openwin('#gbWindowInfo','300px','550px','主机信息');
  		});
	}
}

//查看客户主机情况
function gotoCustInfoPage (v) {
	//部门是网管的不加
	if(currUserDeptid != 10){
		if(currRowObjJson){
		var params = {"cusid":currRowObjJson.customerid};
		url = '/customerMan/queryMacInfoForCus.action';
		$.post(url,params,function(result){
			AddRunningDiv();
			afterLoadUI("#bgcenterid",result);
			MoveRunningDiv();
		});
	}
	}
	

}

function checkAskQuestion(){
	var macnum = currRowObjJson.macnum;
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
