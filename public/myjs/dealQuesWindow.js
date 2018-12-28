
$(function(){
	initInfo(1);
	var customerid = custid_g;
	loadHistoryPage (customerid);

});
//初始化
var questionId = undefined;
var quesstatus_g = undefined;
function initInfo (temp) {
		url = '/technology/queryOrderInfo.action';
		var params = {"id":id_g,"custid":custid_g};
		$.ajax({  
	         type : "post",  
	          url : url,  
	          data : params,  
	          async : false,  
	          success : function(data){  
	        	var result = JSON.parse(data);
	  			var macnum = result.macnum;
	  			var askName = result.askName;
	  			var quesdate = result.quesdate;
	  			var contents = result.contents;
	  			var id = result.id;
	  			var quesstatus = result.quesstatus;
	  			quesstatus_g = quesstatus;
	  			searchBusMacInfo(macnum,askName,quesdate,contents,id,quesstatus,temp);
	          }  
	     }); 
		questionId = id_g;
		
}

//查询业务主机信息
function searchBusMacInfo (macnum,askName,quesdate,contents,id,quesstatus,temp) {
	url = '/technology/dealdetails.action';
	var params = {"macnum":macnum,"id":id};
	$.ajax({  
        type : "post",  
         url : url,  
         data : params,  
         async : false,  
         success : function(result){ 
        	var rs = $.trim(result);
        	$("#answerQuestionsid").html(rs)
     		$("#askNameid").html(askName);
     		$("#quesdateid").html(quesdate);
			 $("#contentsid").html(mydecode(contents));
			 $("#issuedDepid").append('<option value="西安运维人员">西安运维</option>');
     		//如果当前问题状态为已经成功处理状态，则问题关闭不能再继续提交回复
     		if (temp == 2) {
//     			$("#submitAnswersButId").hide();
//     			$("#inputAnswersId").hide();
     			$("#inputQuestionid").hide();
     			$("#summary").show();
     		} else if ($("#questionStatusId").get(0)) {
     			//客户改变问题状态的权限
     			//$("#questionStatusId").get(0).selectedIndex = quesstatus;
     		}
         }  
    }); 
}






//故障转发相关部门处理
function gotootherDept () {
	var dept = $("#issuedDepid").val();
	url = '/technology/gotootherDept.action';
	var params = {"questionId":questionId,"dept":dept};
	$.post(url,params,function(result){
		//var dept2 = '问题已经成功转交到' + dept;
		var rs = $.trim(result);
		if (rs >0) {
			if (window.opener) {
				window.opener.reloadPageData();
			} else {
				$.messager.show({
					title: '错误',
					msg: '此浏览器不兼容window.opener获取对象'
				});
			}
			window.close();
		} else {
			alert("问题转交失败，请联系管理员");
		}
	})
}


function loadSummary(id){
	var url="/technology/querySummary.action?questionId="+id;
	$.post(url,null,function(result){
		var jsondata = JSON.parse(result);
		$("#summary_divid").show();
		$("#member_nameid").html(jsondata[0].member_name);
		$("#member_summaryid").html(jsondata[0].summary);
	});
}

//查询客户历史工单信息
function loadHistoryPage (customerid) {
	url = '/technology/historyListPage.action?custid=' + customerid;
	$.ajax({  
        type : "post",  
         url : url,  
         data : null,  
         async : false,  
         success : function(result){ 
        	 var rs = $.trim(result);
     		$("#history").html(rs);	
         }
    }); 
	
}
