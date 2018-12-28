
//打开单个权限编辑窗口
function editAction(actionid,actionName,groupid,deptmentid) {
	var params = {"actionid":actionid};
	var url = '/role/queryAction.action';
	//查询权限信息,如果权限限制中包含了当前的组，那就对应选择radio.
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'text',
        success : function (result){
        	var rs = $.trim(result);
        	var jsondata = JSON.parse(rs);
        	var rsqx = jsondata.rsQxxz;
			var arrs = rsqx.split(',');
			var count = 0;
			for (var i = 0 ; i < arrs[i]; i++) {
				if (arrs[i] == groupid) {
					count++;
				}
			}
			var deptqx = jsondata.deptqxxz;
			var deptarrs = deptqx.split(',');
			var deptcount = 0;
			for(var i = 0; i<deptarrs[i]; i++){
				if(deptarrs[i] == deptmentid){
					deptcount++;
				}
			}
//			alert("groupid:"+groupid+"----deptmentid:"+deptmentid);
//			alert(rsqx+"____________"+deptqx);
			if (count == 0) {
				if(deptcount ==0){
					$("#noqxxzid").prop("checked", true);  
				}else{
					$("#deptqxxzRadioid").prop("checked", true);  
				}
			} else {
				$("#qxxzRadioid").prop("checked", true);  
			}
		}
	});
	$('#editActionid').dialog('open').dialog('setTitle','权限编辑');
	$("#edit_Actionid").val(actionid);
	$("#action_Nameid").val(actionName);
	$("#edit_groupid").val(groupid);
	$("#edit_deptid").val(deptmentid);
}

//编辑单个权限
function subEditAc () {
	var actionid = $("#edit_Actionid").val();
	var actionName = $("#action_Nameid").val();
	var groupid = $("#edit_groupid").val();
	var deptid = $("#edit_deptid").val();
	if (!$.trim(actionName)) {
		$.messager.show({
			title: '提 示',
			msg: '请填写权限名称'
		});
		return;
	}
	var radioCheck = $('input[name="qxsyfw"]:checked').val();
	var params = {"actionid":actionid,"actionName":actionName,"groupid":groupid,"updateqxxz":radioCheck,"deptid":deptid};
	var url = '/role/editAction.action';
	$.post(url,params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			$.messager.show({
				title: '成 功',
				msg: '权限更新需要对应用户重新登录后生效'
			});
			$('#editActionid').dialog('close');
		} else {
			$.messager.show({
				title: '错 误',
				msg: '权限更新异常,请联系管理员'
			});
		}
  	});
}