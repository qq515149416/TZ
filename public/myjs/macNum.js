$(document).ready(function(){
	loadMacnum();
});
//初始化业务数据表格与表格的按钮事件
function loadMacnum () {
	$("#nowdateid").html(createDataGridJsonRows['nowdate']);
	
	//表头
	var dataFiles = ["p_name","comp_hy","comp_hz","comp_ot","comp_sum",["date"]];
	//行内按钮
	var clickbutton = {};
	//格式化字段
	var formatFileds ='';
	//分页配置
	var pageEvent = '';
	var showTableId = "#resultstjid";
	var pz = createDataGridJsonRows['pageSize'];
	createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,pz,formatFileds);
}

/**
 * 页面点击上/下一月触发此函数
 * 处理日期参数并访问后台查询数据
 * @temp:操作类型（last：上一个月；next：下一个月）
 * @author yqf
 * */
function othermonth (temp ){
	//获取系统当前时间年月
	var date= new Date();
	var month = date.getMonth()+1;
	month = month < 10 ? '0' + month : '' + month;
	var nowdate=date.getFullYear()+'-'+(month);
	//获取列表年月
	var oldmonth =$("#nowdateid").html(); 
	var newdate='';
	if(temp=='next'){//下个月
		newdate=solveDate(oldmonth,temp);
		var startNum = parseInt(newdate.replace(/-/g,''),10); 
		var endNum = parseInt(nowdate.replace(/-/g,''),10); 
		if(startNum>endNum){
			$.messager.alert("操作提示", "当前已经是最新月份！"); 
			return false; 
		}
	}else if (temp=='last') {//上个月
		newdate=solveDate(oldmonth,temp);
	}

	var params = {"newdate":newdate};
	var url = "/financ/loadMacStatistical.action";
	$.ajax({
        	url : url,
        	data: params,
        	cache : false, 
        	async : false,
        	type : "POST",
        	dataType : 'json',
        	success : function (result){
			if (result) {
				//表头
				var dataFiles = ["p_name","comp_hy","comp_hz","comp_ot","comp_sum",["date"]];
				//行内按钮
				var clickbutton = {};
				//格式化字段
				var formatFileds = "";
				//分页配置
				var pageEvent = '';
				var showTableId = "#resultstjid";
				var pz = createDataGridJsonRows['pageSize'];
				createDataGrid(showTableId,result,dataFiles,clickbutton,pageEvent,pz,formatFileds);
				$("#nowdateid").html( result['nowdate']);
			}
        }
	});
} 

/**
 * 处理日期函数
 * @date: 需要处理的日期
 * @temp:操作类型（last：上一个月；next：下一个月）
 * @author yqf
 * */
function solveDate(date,temp){
	var ss = (date.split('-'));
	var y = parseInt(ss[0], 10);
	var m = parseInt(ss[1], 10);
	if(temp=='next'){
		m +=1;
		if(m > 12){
			m ='01';
			y += 1;
		}
	}else if (temp=='last'){
		m -=1;
		if(m==0){
			m=12;
			y -= 1;
		}
	}
	var s = "00" + m;
	m= s.substr(s.length-2);
	date=y+'-'+m;
	return date;
}

//导出数据
function exportMacStatistical(){
	var nowdate = $("#nowdateid").html();
	window.location.href = "/financ/exportMacStatistical.action?newdate="+nowdate;
}