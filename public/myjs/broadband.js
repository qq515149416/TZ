var url; //提交路径
//加载数据表格与表格的按钮事件
function loadMybrodDataGrid () {
	//表头
	var dataFiles = ["pronumber","proname","brand","model","serialnumber","cabinet","comproomname","note",["id","cabinetroom"]];
	//行内按钮
	var clickbutton = {"aMethod":"broadInfo-修改-broadInfo-white,deleteBroad-删除-deleteBroad-red"};
	//格式化字段
	var formatFileds = "";
	//分页配置
	var pageEvent = {"action":"/customerserv/loadBroadband.action"}; //加载数据,必须返回json数据.
	var showTableId = "#mybroadbandTid";
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//高级搜索
function searchBroadband () {
	var pronumber = $("#pronumberid").val();
	var proname = $("#pronameid").val();
	var brand = $("#brandid").val();
	var model = $("#modelid").val();
	var serialnumber = $("#serialnumberid").val();
	var cabinet = $("#cabinetid").val();
	var cabinetroom = $("#cabinetroomid").val();
	var url = "/customerserv/loadBroadband.action";
	var params = {"pronumber":pronumber,"proname":proname,"brand":brand,"model":model,"serialnumber":serialnumber,"cabinet":cabinet,"cabinetroom":cabinetroom};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			var dataFiles = ["pronumber","proname","brand","model","serialnumber","cabinet","comproomname","note",['id','cabinetroom']];
			//行内按钮
			var clickbutton = {"aMethod":"broadInfo-修改-broadInfo-white,deleteBroad-删除-deleteBroad-red"};
			//格式化字段
			var formatFileds = "";
			//分页配置
			if (pronumber) {
				pronumber = encodeURI(encodeURI(pronumber));
			}
			if (proname) {
				proname = encodeURI(encodeURI(proname));
			}
			if (brand) {
				brand = encodeURI(encodeURI(brand));
			}
			if (model) {
				model = encodeURI(encodeURI(model));
			}
			if (serialnumber) {
				serialnumber = encodeURI(encodeURI(serialnumber));
			}
			if (cabinet) {
				cabinet = encodeURI(encodeURI(cabinet));
			}
			if (cabinetroom) {
				cabinetroom = encodeURI(encodeURI(cabinetroom));
			}
			var urlParams = "/customerserv/loadBroadband.action?urlParams=urlParams" +"&pronumber="+pronumber + "&proname=" + proname+"&brand="+brand+"&model="+model+"&serialnumber="+serialnumber+"&cabinet="+cabinet+"&cabinetroom="+cabinetroom;
			var pageEvent = {"action":urlParams};
			var showTableId = "#mybroadbandTid";
			createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,10,formatFileds);
		}
	});
}


//弹出新增大带宽机器信息窗口
function addBroadbandDiv(){
	//打开新增客户窗口
	loadCompRoom ("#addcabinetroomid"); 
	$('#addbroadbanddiv').dialog('open').dialog('setTitle','新大带宽机器');
	url = '/customerserv/addBroadband.action';
}
//保存一个新增的大带宽机器信息
function addNewBroadband() {
	var pronumber = $("#addpronumberid").val();
	var proname = $("#addpronameid").val();
	var brand = $("#addbrandid").val();
	var model = $("#addmodelid").val();
	var serialnumber = $("#addserialnumberid").val();
	var cabinet = $("#addcabinetid").val();
	var cabinetroom = $("#addcabinetroomid").val();
	var note = $("#addnoteid").val();
	
	var params = {"pronumber":pronumber,"proname":proname,"brand":brand,"model":model,"serialnumber":serialnumber,"cabinet":cabinet,"note":note,"cabinetroom":cabinetroom};
	$.ajax({
		url:url,
		data:params,
		async:false,
		type:"post",
		dataType:"json",
		success:function(result){
			var rs = $.trim(result);
			if (rs > 0){
				$('#addcusfm').form('clear');
				$('#addbroadbanddiv').dialog('close');
//				searchBroadband($("#addbroadbanddiv #currPage").html().substring(3,$("#mybroadbandTid #currPage").html().length-1));
				searchBroadband();
				
			} else {
				$.messager.show({
					title: 'Error',
					msg: '大带宽机器填写错误，请联系管理员！'
				});
			}
		}
	});
}

//查看大带宽机器信息
function broadInfo () {
	if (currRowObjJson) {
		loadCompRoom("#editcabinetroomid");
		$('#broaInfodivid').dialog('open').dialog('setTitle','编辑大带宽机器信息');
		//填充表格
		$("#broaInfodivid #editmainid").val(currRowObjJson.id);
		$("#broaInfodivid #editpronumberid").val(mydecode(mydecode(currRowObjJson.pronumber)));
		$("#broaInfodivid #editpronameid").val(mydecode(mydecode(currRowObjJson.proname)));
		$("#broaInfodivid #editbrandid").val(mydecode(mydecode(currRowObjJson.brand)));
		$("#broaInfodivid #editmodelid").val(mydecode(mydecode(currRowObjJson.model)));
		$("#broaInfodivid #editserialnumberid").val(mydecode(mydecode(currRowObjJson.serialnumber)));
		$("#broaInfodivid #editcabinetid").val(mydecode(mydecode(currRowObjJson.cabinet)));
		$("#broaInfodivid #editcabinetroomid").val(currRowObjJson.cabinetroom);
		$("#broaInfodivid #editnoteid").val(mydecode(mydecode(currRowObjJson.note)));
	}
}
//更新大带宽机器信息
function updateBroadband (){
	var id = $("#editmainid").val();
	var pronumber = $("#editpronumberid").val();
	var proname = $("#editpronameid").val();
	var brand = $("#editbrandid").val();
	var model = $("#editmodelid").val();
	var serialnumber = $("#editserialnumberid").val();
	var cabinet = $("#editcabinetid").val();
	var cabinetroom = $("#editcabinetroomid").val();
	var note = $("#editnoteid").val();
	
	var url ="/customerserv/updateBroadband.action";
	var params = {"id":id,"pronumber":pronumber,"proname":proname,"brand":brand,"model":model,"serialnumber":serialnumber,"cabinet":cabinet,"note":note,"cabinetroom":cabinetroom};
	$.ajax({
		url:url,
		data:params,
		async:false,
		type:'post',
		dataType:'json',
		success:function(result){
			var rs = $.trim(result);
			if (rs > 0){
				$('#broaInfodivid').dialog('close'); // close the dialog
				$('#updateCusfm').form('clear');
//				searchBroadband();($("#mybroadbandTid #currPage").html().substring(3,$("#mybroadbandTid #currPage").html().length-1));
				searchBroadband();
				
			} else {
				$.messager.show({
					title: 'Error',
					msg: '大带宽机器填写错误，请联系管理员！'
				});
			}
		}
	})
}


//删除大带宽机器信息
function deleteBroad(){
	if(currRowObjJson){
		if(confirm("确认删除【"+currRowObjJson.pronumber+"】吗？")){
			var url = '/customerserv/delBroadband.action';
			var params = {"id":currRowObjJson.id};
			$.ajax({
				url:url,
				data:params,
				async:false,
				type:'post',
				dataType:'json',
				success:function(result){
					var rs = $.trim(result);
					if (rs > 0){
						searchBroadband();
					} else {
						$.messager.show({
							title: 'Error',
							msg: '大带宽机器删除错误，请联系管理员！'
						});
					}
				}
			})
		}
	}
}


//导出用户
function exportBroadbandWithExcel(){
	var pronumber = $("#pronumberid").val();
	var proname = $("#pronameid").val();
	var brand = $("#brandid").val();
	var model = $("#modelid").val();
	var serialnumber = $("#serialnumberid").val();
	var cabinet = $("#cabinetid").val();
	var cabinetroom = $("#cabinetroomid").val();
	
	window.location.href = "/customerserv/exportBroadbandWithExcel.action?urlParams=urlParams" +"&pronumber="+pronumber + "&proname=" + proname+"&brand="+brand+"&model="+model+"&serialnumber="+serialnumber+"&cabinet="+cabinet+"&cabinetroom="+cabinetroom;

}

//导入
function importBroadbandWithExcel(){
	$('#importExecelFilediv').dialog('open').dialog('setTitle','导入大带宽机器');
}

function loadCompRoom (ele){
	$(ele).empty();
	if(!(ele.indexOf("add")!=-1 || ele.indexOf("edit")!=-1)){
		$(ele).append("<option value=''>----请选择----</option>");
	}
	var url = '/customerMan/loadCompRoom.action';
	var params = {};
	var rs = "";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
			if (result) {
				for(var i = 0 ; i < result.length; i++){
					var comproomid = result[i]["comproomid"];
					var comproomname =result[i]["comproomname"];
					$(ele).append("<option value='"+comproomid+"'>"+comproomname+"</option>");
				}
			}
		}
	});
}