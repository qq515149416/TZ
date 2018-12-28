

$(document).ready(function(){
	if (currRowObjJson) {
		$("#wapMacnumid").html(currRowObjJson.macnum);
		$("#wapdxipid").html(currRowObjJson.dxip);
		$("#wapunipid").html(currRowObjJson.unicomip);
		dropDownList();
	}
});



function dropDownList(){
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
	
}



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
		//alert(text);
		if(length > 0){
			$('#question-second-type').show();
		}
	});
});