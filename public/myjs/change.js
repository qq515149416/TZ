
//提交更换信息
function subChangeInfo () {
	var olddxip = $("#cdxipValid").val();
	var oldunip = $("#cunipValid").val();
	var dxip = $("#cdxipid").val();
	var unip = $("#cunipid").val();
	var bizid = $("#bzid").val();
	var macnum = $("#cmacnumValid").val();
	var note = $("#cnoteid").val();
	var biztype = $("#biztype").val();
	var flowName = "服务器IP地址更换";
	var str = "";
	
	//必填一个
	if (!dxip && !unip) {
		$.messager.show({
			title: '提 示',
			msg: '请正确输入要更换的IP！'
		});
		return;
	}
	
	//判断电信
	var checkdxip = true;
	var checkunip = true;
	if (dxip) {
		if (dxip == olddxip) {
			checkImgShow("#changeResFormid #dxerrorsip",-1,'新电信IP不能与原电信IP相同');
			return;
		}
		checkdxip = checIPisexit("dxip",dxip);
		if (!checkdxip) {
			checkImgShow("#changeResFormid #dxerrorsip",-1,'IP库中不存在此电信IP');
		} else {
			checkImgShow("#changeResFormid #dxerrorsip",2);
		}
		
		str += "原电信IP [" + olddxip + "] 更换为 [" + dxip + "]；  ";
	} else {
		//输入后又清空不填写,要清空之前的错误信息
		checkImgShow("#changeResFormid #dxerrorsip",2);
	}
	
	//判断联通
	if (unip) {
		if (unip == oldunip) {
			checkImgShow("#changeResFormid #unerrorsip",-1,'新联通IP不能与原联通IP相同');
			return;
		}
		checkunip = checIPisexit("unip",unip);
		str += "原联通IP [" + oldunip + "] 更换为 [" + unip + "]； ";
		if (!checkunip) {
			checkImgShow("#changeResFormid #unerrorsip",-1,'IP库中不存在此联通IP');
		} else {
			checkImgShow("#changeResFormid #unerrorsip",2);
		}
	} else {
		//输入后又清空不填写,要清空之前的错误信息
		checkImgShow("#changeResFormid #unerrorsip",2);
	}
	
	//两个二选一填写更换
	if (!checkdxip || !checkunip ) {
		return;
	}
	str += "确定？";
	
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			var url = "/customerMan/changeMacInfo.action";
			var params = {"id":bizid,"dxip":dxip,"unip":unip,"oldunip":oldunip,"olddxip":olddxip,"macnum":macnum,"note":note,"flowName":flowName,"biztype":biztype};
			$.post(url,params,function(result){
				var rs = $.trim(result);
				if (rs > 0) {
					$.messager.show({
						title: '提 示',
						msg: '更换申请已经进入下一个部门审核！'
					});
					$('#changeResDivid').dialog('close');
				} else {
					 $.messager.alert("ERROR", "更换失败,请先创建工作流！"); 
				}
			});
		}
	});
}