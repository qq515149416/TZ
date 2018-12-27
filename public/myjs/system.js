$(document).ready(function () {
	loadManDataGrid();
});
var url; //提交路径
function loadManDataGrid() {
	//表头
	var dataFiles = ["truename","name","qq","worknum","mobile","sex","deptname","groupnamezn","email","createdate","lastlogindate",["maid"]];
	//行内按钮
	var clickbutton = {"aMethod":"staffInfo-详情-staffInfo-white,returnPass-恢复密码-returnPass,removeit-删除-removeit-white"};
	//格式化字段
	var formatFileds = {};
	//分页配置
	var pageEvent = {"action":"/role/loadmasterMan.action"};
	var showTableId = "#manTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//重新加载数据
function loadinfo () {
	var url = "/role/loadmasterMan.action";
	$.ajax({
        url : url,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				//表头
				var dataFiles = ["truename","name","qq","worknum","mobile","sex","deptname","groupnamezn","email","createdate","lastlogindate",["maid"]];
				//行内按钮
				var clickbutton = {"aMethod":"staffInfo-详情-staffInfo-white,returnPass-恢复密码-returnPass,removeit-删除-removeit-white"};
				//格式化字段
				var formatFileds = {};
				//分页配置
				var pageEvent = {"action":"/role/loadmasterMan.action"};
				var showTableId = "#manTid";
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			}
		}
  	});
}

//详情
function staffInfo(){
	var maid = currRowObjJson.maid;
	window.open("/role/editInfo.action?maid="+maid);
}


//高级查询
function filterSearchidBiz () {
	var truename = $("#trueNameFilterid").val();
	var name = $("#loginNameFilterid").val();
	var qq = $("#qqFilterid").val();
	var worknum = $("#worknumFilterid").val();
	var mobile = $("#mobileFilterid").val();
	var sex = $("#sexid").val();
	var groupnamezn = $("#groupFilterid").val();
	var email = $("#emailFilterid").val();
	var createdate = $("#createdateid").val();
	var lastlogindate = $("#lastlogindateid").val();
	
	var url = "/role/loadmasterMan.action";
	var params = {"truename":truename,"name":name,"qq":qq,"worknum":worknum,"mobile":mobile,"sex":sex,"groupnamezn":groupnamezn,"email":email,"createdate":createdate,"lastlogindate":lastlogindate};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
        	//表头
        	var dataFiles = ["truename","name","qq","worknum","mobile","sex","deptname","groupnamezn","email","createdate","lastlogindate",["maid"]];
        	//行内按钮
        	var clickbutton = {"aMethod":"staffInfo-详情-staffInfo-white,returnPass-恢复密码-returnPass,removeit-删除-removeit-white"};
        	//格式化字段
        	var formatFileds = {};
			//分页配置
			if (truename) {
				truename = encodeURI(encodeURI(truename));
			}
			if (name) {
				name = encodeURI(encodeURI(name));
			}
			if (qq) {
				qq = encodeURI(encodeURI(qq));
			}
			if (worknum) {
				worknum = encodeURI(encodeURI(worknum));
			}
			if (mobile) {
				mobile = encodeURI(encodeURI(mobile));
			}
			if (sex) {
				sex = encodeURI(encodeURI(sex));
			}
			if (groupnamezn) {
				groupnamezn = encodeURI(encodeURI(groupnamezn));
			}
			if (email) {
				email = encodeURI(encodeURI(email));
			}
			if (createdate) {
				createdate = encodeURI(encodeURI(createdate));
			}
			if (lastlogindate) {
				lastlogindate = encodeURI(encodeURI(lastlogindate));
			}
			var urlParams = "/role/loadmasterMan.action?urlParams=urlParams&" + "truename=" + truename + "&name=" + name + "&qq=" + qq + "&worknum=" + worknum+ "&mobile=" + mobile + "&sex=" + sex + "&groupnamezn=" + groupnamezn + "&email=" + email+ "&createdate=" + createdate + "&lastlogindate=" + lastlogindate;

			var pageEvent = {"action":urlParams};
			var showTableId = "#manTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
			
		}
	});
}
//恢复密码
function returnPass () {
	if (currRowObjJson != undefined && currRowObjJson.maid) {
		var maid = currRowObjJson.maid;
		var cf = confirm("是否确认恢复【"+currRowObjJson.truename+"】的密码");
		if (cf) {
			var params = {"newPass":"12344321","returnPassMaid":maid};
			var actiontemp = "/login/updateLoginPass.action";
			$.post(actiontemp,params,function(result){
		    	var rs = $.trim(result);
		    	if( rs > 0 ) {
		    		$.messager.alert("提示","更新成功!");
				} else {
					$.messager.alert("提示","更新失败,请联系管理员!");
				}
	  		});
		}
	}
}
//删除
function removeit(){
	//判断此人员下是否还存在业务，如果有则不能删除
	var url2 = '/customerMan/checkMasterCus.action';
	var params = {"masterid":currRowObjJson.maid};
	$.post(url2,params,function(result){
		var rs = $.trim(result);
		if (rs > 0){
			$.messager.show({ // show error message
				title: '提示',
				msg: '该用户仍有客户存在，不能删除！'
			});
			return;
		} else {
			//删除数据库数据
			var str = '确定要删除人员【'+currRowObjJson.truename+'】吗？';
			$.messager.confirm('Confirm',str,function(r){
				if (r){
					if (currRowObjJson.maid) {
						var actionUrl = "/role/delMaster.action";
						var params = {"maid":currRowObjJson.maid};
						$.post(actionUrl,params,function(result){
					    	var rs = $.trim(result);
					    	if (rs > 0) {
					    		//刷新人员列表
					    		//if (action_attr) showMeunContent(action_attr);
					    		$.messager.alert("提示","删除成功");
					    		loadinfo();
					    	} else {
					    		$.messager.alert("提示","人员删除失败，请联系技术人员！");
					    	}
					    	
				  		});
					}
				}
			});
		}
	});
}
