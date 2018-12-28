$(function(){
	loadMyCusDataGrid();
});

//加载数据表格与表格的按钮事件
function loadMyCusDataGrid (data) {
	var showData = "";
	if (data) {
		//传递的json数据集合
		showData = data;
	} else {
		//初始数据
		showData = createDataGridJsonRows;
	}
	var dataFiles = ["cusname","custruename","accbal","truename","worknum","companyname","cussex","cusmobile","telephone","cusemail","cusqq","fax","createdate","cusaddr",'note',['cusid','maid']];
	//行内按钮
	var clickbutton = {"aMethod":"restoreCus-恢复-restoreCus"};
	//格式化字段
	var formatFileds = "";//{"biztype":"1-租用,0-托管"};
	//分页配置
	var pageEvent = {"action":"/customerMan/recordDelCus.action?returnJson=json"}; //加载数据,必须返回json数据.
	var showTableId = "#mydelcustomerTid";
	createDataGrid(showTableId,showData,dataFiles,clickbutton,pageEvent,10,formatFileds);
}

//高级搜索
function searchDelcus () {
	var custruename = $("#custruenameid").val();
	var cusname = $("#cusnameid").val();
	var truename = $("#truenameid").val();
	var url = "/customerMan/recordDelCus.action";
	var params = {"custruename":custruename,"cusname":cusname,"truename":truename,"returnJson":"json"};
	var rs = queryInfoJson (url,params,"人员获取失败，请联系管理员!");
	if (rs) {
		loadMyCusDataGrid(rs);
	}
}

//恢复客户
function restoreCus () {
	if (currRowObjJson) {
		var str = "确定恢复客户[" + currRowObjJson.custruename + "]吗？";
		$.messager.confirm('Confirm',str,function(r){
			if (r){
				var url = "/customerMan/updateCustomers.action";
				var params = {"cusid":currRowObjJson.cusid,"status":0};
				$.post(url,params,function(result){
					var rs = $.trim(result);
					if (rs > 0) {
						searchDelcus();
						$.messager.show({ // show error message
							title: '提 示',
							msg: '客户已经成功恢复',
							timeout:6000
						});
					} else {
						$.messager.alert('Error','恢复失败，请联系管理员')
					}
				});
			}
		});
	}
}