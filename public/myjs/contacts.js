$(document).ready(function () {
	loadMyQtDataGrid();
});
var url; //提交路径
function loadMyQtDataGrid() {
	//表头
	var dataFiles = ["contactname","qq","mobile","email","rank","site",["contactid"]];
	//行内按钮
	var clickbutton = {"aMethod":"openupdateWContact-修改-openupdateWContact,delectecontact-删除-delectecontact"};	
	//格式化字段
	var formatFileds = {"site":"1-左侧导航,2-联系人页,3-两侧均显示"};
	//分页配置
	var pageEvent = {"action":"/book/loadcontacts.action"};
	var showTableId = "#contactsTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

function filterSearchidBiz () {
	var contactname = $("#contactnameFilterid").val();
	var qq = $("#qqFilterid").val();
	var mobile = $("#mobileFilterid").val();
	var dimission = $("#dimissionFilterid").val();
	var email = $("#emailFilterid").val();
	var url = "/book/loadcontacts.action";
	var params = {"contactname":contactname,"qq":qq,"mobile":mobile,"email":email};
	$.ajax({
		url : url,
		data: params,
		cache : false, 
		async : false,
		type : "post",
		dataType : 'json',
		success : function (result){
			//表头
			var dataFiles = ["contactname","qq","mobile","email","rank","site",["contactid"]];
			//行内按钮
			var clickbutton = {"aMethod":"openupdateWContact-修改-openupdateWContact,delectecontact-删除-delectecontact"};
			//格式化字段
			var formatFileds = {"site":"1-左侧导航,2-联系人页,3-两侧均显示"};
			//分页配置
			if (contactname) {
				contactname = encodeURI(encodeURI(contactname));
			}
			if (qq) {
				qq = encodeURI(encodeURI(qq));
			}
			if (qq) {
				qq = encodeURI(encodeURI(qq));
			}
			if (mobile) {
				mobile = encodeURI(encodeURI(mobile));
			}
			if (email) {
				email = encodeURI(encodeURI(email));
			}
			var urlParams = "/book/loadcontacts.action?urlParams=urlParams&" + "contactname=" + contactname + "&qq=" + qq + "&mobile=" + mobile + "&email=" + email;
			var pageEvent = {"action":urlParams};
			var showTableId = "#contactsTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);

		}
	});
}

function openWContents (){
	$('#addcontactdiv').dialog('open').dialog('setTitle','新增联系人');
	//添加弹窗关闭后，清空上次输入联系人信息
	$("#addcontactdiv #contactnameid").val('');
	$("#addcontactdiv #qqid").val('');
	$("#addcontactdiv #mobileid").val('');
	$("#addcontactdiv #emailid").val('');
}
function openupdateWContact (){
	if(currRowObjJson){
		$('#updatecontactdiv').dialog('open').dialog('setTitle','修改联系人信息');
		$("#updatecontactdiv #upcontactnameid").val(currRowObjJson.contactname);
		$("#updatecontactdiv #upqqid").val(currRowObjJson.qq);
		$("#updatecontactdiv #upmobileid").val(currRowObjJson.mobile);
		$("#updatecontactdiv #upemailid").val(currRowObjJson.email);
		$("#updatecontactdiv #uprankid").val(currRowObjJson.rank);
		$("#updatecontactdiv #upsiteid").val(currRowObjJson.site);
	}
}
//修改联系人信息
function updatecontact(){
	var contactid=currRowObjJson.contactid;
	var contactname=$("#updatecontactdiv #upcontactnameid").val();
	var qq=$("#updatecontactdiv #upqqid").val();
	var mobile=$("#updatecontactdiv #upmobileid").val();
	var email=$("#updatecontactdiv #upemailid").val();
	var rank=$("#updatecontactdiv #uprankid").val();
	var rank=$("#updatecontactdiv #uprankid").val();
	var site=$("#updatecontactdiv #upsiteid").val();
	var params = {"contactid":contactid,"contactname":contactname,"qq":qq,"mobile":mobile,"email":email,"rank":rank,"site":site};
	//判断联系人信息是否修改
	$.post('/book/findThecontact.action',params,function(result){
		var rt=$.trim(result);
		if(!rt){
			//如果输入信息已经改变，则可以修改
			$.post('/book/updateContact.action',params,function(result){
				var rs = $.trim(result);
				if (rs > 0){
					$('#updatecontactdiv').dialog('close');
					$.messager.show({
						title:'Error',
						msg:'修改联系人成功'
					});
					queryAllContacts();
				}
			});
		}else {
			$.messager.show({
				title: 'Error',
				msg: '联系人信息未改变或已存在，请确认信息再修改！'
			});
		}
	});
}
function delectecontact (){
	var str='确定要删除名称为'+currRowObjJson.contactname+'的联系人吗？';
	$.messager.confirm('Confirm',str,function(r){
		if (r){
			url = '/book/contactdelete.action';
			$.post(url,{"contactid":currRowObjJson.contactid},function(result){
				$.messager.show({
					title:'Error',
					msg:'删除联系人成功'
				});
				queryAllContacts();
			});
		}
	});
}
function savecontact() {
	var contactname=$("#addcontactdiv #contactnameid").val();
	if(!contactname){
		$.messager.alert('提示','请输入联系人名称');
		return;
	}
	else{
		if(contactname.length>20){
			$.messager.alert('提示','输入联系人名称过长，请重新输入');
			return;
		}
	}
	var qq=$("#addcontactdiv #qqid").val();
	if(!qq){
		$.messager.alert('提示','请输入联系人qq');
		return;
	}else{
		if(qq.length>20){
			$.messager.alert('提示','输入联系人qq过长，请重新输入');
			return;
		}
	}
	var mobile=$("#addcontactdiv #mobileid").val();
	if(!mobile){
		$.messager.alert('提示','请输入联系人手机号');
		return;
	}
	var email=$("#addcontactdiv #emailid").val();
	if(!email){
		$.messager.alert('提示','请输入联系人邮箱');
		return;
	}
	var rank=$("#addcontactdiv #rankid").val();
	if(!rank){
		$.messager.alert('提示','请输入权重值');
		return;
	}
	var site=$("#addcontactdiv #siteid").val();
	if(!site){
		$.messager.alert('提示','选择显示位置');
		return;
	}
	var params = {"contactname":contactname,"qq":qq,"mobile":mobile,"email":email,"rank":rank,"site":site};
	//判断联系人是否存在
	$.post('/book/findThecontact.action',params,function(result){
		var rt=$.trim(result);
		if(!rt){
			//若不存在，则添加联系人
			$.post('/book/addContact.action',params,function(result){
				var rs = $.trim(result);
				if (rs > 0){
					$('#addcontactdiv').dialog('close');
					$.messager.show({
						title:'Error',
						msg:'添加联系人成功'
					});
					queryAllContacts();
				}else {
					$.messager.show({
						title: 'Error',
						msg: '请完整填写联系人信息'
					});
				}
			});
		}else{
			$.messager.show({
				title: 'Error',
				msg: '联系人已经存在，请确认并重新输入信息！'
			});
		}
	});
}
//查询联系人
function queryAllContacts(){
	var url="/book/loadMyContacts.action"
		$.ajax({
			url : url,
			cache : false, 
			async : false,
			type : "POST",
			dataType : 'json',
			success : function (result){
				if (result) {
					//表头
					var dataFiles = ["contactname","qq","mobile","email","rank","site",["contactid"]];
					//行内按钮
					var clickbutton = {"aMethod":"openupdateWContact-修改-openupdateWContact,delectecontact-删除-delectecontact"};
					//格式化字段
					var formatFileds = {"site":"1-左侧导航,2-联系人页,3-两侧均显示"};
					var pageEvent = {"action":"/book/loadMyContacts.action"};
					var showTableId = "#contactsTid";
					createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
				}
			}
		});
}