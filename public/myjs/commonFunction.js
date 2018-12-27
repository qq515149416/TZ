
//让宽度自动按照百分比适应
function getWidth(percent){ 
   return document.body.clientWidth*percent; 
}

//js字符串判断
function checkStr (str) {
	if (str != null && str != undefined && str != "null" && str != "undefined" && $.trim(str) != "" ) {
		return true;
	} else {
		return false;
	}
}

//判断json格式对象
function isJosn (obj){
    var isjson = typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
    return isjson;
}

//判断json格式字符串
function isJsonStr (str) {
	var isjson = str.indexOf ("{") != -1 && str.indexOf ("}") != -1;
	return isjson
}

//统一验证非空的值，传递数组对象
function checkAttrs (attrArrs,toempty) {
	if (attrArrs instanceof Array) {
		var rs = 0;
		$.each(attrArrs, function(i) {
			var key = attrArrs[i];
			var id = "#" + key;
			var mes = "#" + key + "Mes";
			var val = $(id).val();
			if (toempty) {
				//清楚验证标识
				checkImgShow(mes,2);
			} else {
				//验证非空
				if (checkStr(val)) {
					checkImgShow(mes,0);
				} else {
					checkImgShow(mes,-1," *必填");
					rs++;
				}
			}
		});
		if (rs > 0) {
			return false;
		} else {
			return true;
		}
	} else {
		myMesShow("错误","传递参数错误，应该为数组，请联系管理员");
		return false;
	}
}

//统一提示
function myMesShow (titleType,message) {
	$.messager.show({
		title: titleType,
		msg: message,
		timeout: 7000
	});
}

//正确图标 0表示正确, -1标示错误
function checkImgShow (attr,rs,mes) {
	var htmstr = "";
	 if (rs == 0) {
		htmstr = "<img src='/images/onCorrect.gif'/>";
	} else if (rs == -1) {
		htmstr = "<img src='/images/onError.gif'/>";
		if (mes) {
			htmstr += ("<span style='color:red;font-size:12px;'>" + mes + "</span>");
		}
	} else if (rs == 2) {
		htmstr = "";
	}
	 if ($(attr)) {
		 $(attr).html(htmstr);
	 }
	
}

//添加遮罩和提示框
function AddRunningDiv(str) {
	if (!str) {
		str = "拼命加载中...";
	}
	$("<div class=\"datagrid-mask\"></div>").css({ display: "block", width: "100%", height: $(document).height() }).appendTo("body");
	$("<div class=\"datagrid-mask-msg\"></div>").html(str).appendTo("body").css({ display: "block", left: ($(document.body).outerWidth(true) - 190) / 2, top: ($(document).height() - 45) / 2 });
}

//取消遮罩和提示框
function MoveRunningDiv() {
	if ($("div[class='datagrid-mask']")) {
		 $("div[class='datagrid-mask']").remove();
    	$("div[class='datagrid-mask-msg']").remove();
	}
   
}

//加载部门数据
function loadDept () {
	$.post("/rcworks/actionQueryByUser.action",{},function(result){
    	var rs = $.trim(result);
		$("#bgmeunid").html(rs);
		
  	});
}

//UI时间控件格式化
function myDateformatter(date) {

	var y = date.getFullYear();
	var m = date.getMonth() + 1;
	var d = date.getDate();
	return y + '-' + (m < 10 ? ('0' + m) : m) + '-'+ (d < 10 ? ('0' + d) : d);
}

//UI时间控件格式化
function myDateparser(s) {
	if (!s)
		return new Date();
		var ss = (s.split('-'));
		var y = parseInt(ss[0], 10);
		var m = parseInt(ss[1], 10);
		var d = parseInt(ss[2], 10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
		return new Date(y, m - 1, d);

	} else {
		return new Date();
	}
}

//主要是将json无法识别的字符进行转义
function dotran(rs) {
	if (rs) {
		var reg = new RegExp("\r\n","g");
		var newstr = rs.replace(reg, '<br/>');
		reg = new RegExp("\n","g");
		newstr = newstr.replace(reg, '<br/>');
		reg = new RegExp(" ","g");
		newstr = newstr.replace(reg, '&nbsp;');
		reg = new RegExp("&","g");
		newstr = newstr.replace(reg, '&amp;');
		reg = new RegExp("<","g");
		newstr = newstr.replace(reg, '&lt;');
		reg = new RegExp(">","g");
		newstr = newstr.replace(reg, '&gt;');
		reg = new RegExp('"',"g");
		newstr = newstr.replace(reg, '&quot;');
		reg = new RegExp("'","g");
		newstr = newstr.replace(reg, '&apos;');
	    return newstr;
	 } else {
		 return "";
	 }
}

function mydecode(rs) {
	if (rs) {
		var reg = new RegExp("<br/>","g");
		var newstr = rs.replace(reg, '\r\n');
		reg = new RegExp("&amp;","g");
		newstr = newstr.replace(reg, '&');
		reg = new RegExp("&nbsp;","g");
		newstr = newstr.replace(reg, ' ');
		reg = new RegExp("&lt;","g");
		newstr = newstr.replace(reg, '<');
		reg = new RegExp("&gt;","g");
		newstr = newstr.replace(reg, '>');
		reg = new RegExp('&quot;',"g");
		newstr = newstr.replace(reg, '"');
		reg = new RegExp("&apos;","g");
		newstr = newstr.replace(reg, "'");
	    return newstr;
    } else {
		 return "";
	 }
}

//因为在封装一行数据为json对象时，已经把标签转换成代码，所以

function htmlEncode (str){
	var div = document.createElement("div");
	var text = document.createTextNode(str);
	div.appendChild(text);
	return div.innerHTML;
}
function htmlDecode (str){
	var div = document.createElement("div");
	div.innerHTML = str;
	return div.innerHTML;
}


//渲染结束后才显示UI
function afterLoadUI (id,rs) {
	rs = $.trim(rs);
	$(id).css({"visibility":"hidden"});
	//document.getElementById("bgcenterid").innerHTML = rs;
	$(id).html(rs);
	$.parser.parse();
	$(id).css({"visibility":"visible"});
}

//封装函数作为事件参数传递,只要按照规则传递参数,就可以直接动态生成对应元素ID的blur事件进行输入验证.
//验证dxip
function handerDxip (inputid) {
	if (inputid) {
		return checIPExit("dxip",inputid);
	} else {
		return checIPExit("dxip","#dxipid");
	}
	
}
//验证unip
function handerUnip (inputid) {
	if (inputid) {
		return checIPExit("unip",inputid);
	} else {
		return checIPExit("unip","#unicomipid");
	}
	
}
//验证主机编号
function haderMacnumber (inputid) {
	if (inputid) {
		return checkMacnumber(inputid);
	} else {
		return checkMacnumber("#macnumid");
	}
	
}

//检查输入编号是否重复
function checkMacnumber (id) {
	var macnumVali = false;
	//$(id).blur(function(){
	var macnumval = $(id).val();
	if (macnumval) {
		var url = '/customerMan/checkMacnumRepeat.action';
		var params = {"macnum":macnumval};
		$.ajax({
	        url : url,
	        data: params,
	        cache : false, 
	        async : false,
	        type : "POST",
	        dataType : 'json',
	        success : function (result){
				var rs = $.trim(result);
				if (rs > 0){
					$("#macnumMes").html("<font color='red'>已经存在!</font>");
					macnumVali = true;
					$(id).focus();
				} else {
					$("#macnumMes").html("");
					macnumVali = false;
				}
			}
		});
	}
	//});
	return macnumVali ;
}

//标识IP检查验证结果
var hadUnip = false;
var hadDxip = false;
//ajax同步请求,判断IP在IP库中是否已经存在并且为可用状态.iptype(电信或者联通),ipVal(IP值或者段的开始值),ipEndVal(IP段的结束值),ipStatus(ip使用状态,注意传递必须要字符串"0""1")
function checIPisexit (iptype,ipVal,ipEndVal,ipStatus) {
	//ipIsNotExit标识是否存在相同IP.
	var ipIsNotExit = false;
	var url = "/customerserv/searchIps.action";
	var params = {"iptypeSearchIP":iptype,"ipValSearchIP":ipVal,"checkIpExit":"checkIpExit"};
	if (ipEndVal) {
		//ipEndVal结束IP值，即IP段录入，检测只要此段其中的一个IP已经存在，整段都禁止录入。
		params = {"iptypeSearchIP":iptype,"ipValSearchIP":ipVal,"checkIpExit":"checkIpExit","ipEndVal":ipEndVal};
	}
	if (ipStatus) {
		//ipStatus,标识查询IP是否存在IP库中，以及使用状态.
		params = {"iptypeSearchIP":iptype,"ipValSearchIP":ipVal,"checkIpExit":"checkIpExit","checkIPStatus":ipStatus};
	}
	//同步请求.
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
            var rs = $.trim(result);
            if (ipStatus) {
            	//为客户添加机器时,录入IP的检查,存在与否和使用状态.
            	if (rs == 0) {
            		if (iptype == 'dxip') {
            			checkImgShow("#dxerrorsip",-1,'非法IP,或IP已被使用');
            			hadDxip = true;
            		} else if (iptype == 'unip') {
            			checkImgShow("#unerrorsip",-1,'非法IP,或IP已被使用');
            			hadUnip = true;
            		}else if (iptype == 'cabdxip') {
            			checkImgShow("#cabmacdxerrorsip",-1,'非法IP,或IP已被使用');
            			hadUnip = true;
            		}else {
            			checkImgShow("#cabmacunerrorsip",-1,'非法IP,或IP已被使用');
            			hadUnip = true;
            		}
					ipIsNotExit = true;
				
				} else {
					if (iptype == 'dxip') {
            			$("#dxerrorsip").html("");
            			hadDxip = false;
            		} else if (iptype == 'unip') {
            			$("#unerrorsip").html("");
            			hadUnip = false;
            		} else if (iptype == 'cabdxip') {
            			$("#cabmacdxerrorsip").html("");
            			hadUnip = false;
            		} else {
            			$("#cabmacunerrorsip").html("");
            			hadUnip = false;
            		}
				}
            } else {
            	//IP库的IP录入.
            	if (rs > 0) {
					checkImgShow("#errorsip",-1,'IP或者IP段中有已存在的IP');
					ipIsNotExit = true;
					
				}  else {
					$("#errorsip").html("");
				}
            	$("#beginipvalidImg").html("");
            	
            	//IP是否存在认证，不考虑使用状态
            	if (rs == 0) {
        			hadDxip = false;
        			hadUnip = false;
					ipIsNotExit = false;
				
				} else {
        			hadDxip = true;
        			hadUnip = true;
					ipIsNotExit = true;
				}
            }
        }
    });
	return ipIsNotExit;
}


//检查输入的IP是否存在并且为可用状态,iptype电信或者联通的标识,inputId输入框的ID.
function checIPExit (iptype,inputId) {
	var unipVal = $(inputId).val();
	var dxip = $(inputId).val();
	if (iptype == 'unip') {
		if (!unipVal) {
			return;
		}
		ipVal = unipVal;
		
	} else {
		if (!dxip) {
			return;
		}
		ipVal = dxip;
	}
	var checkrs = checIPisexit (iptype,ipVal,undefined,"0");
	if (checkrs == true) {
		//$(inputId).focus();  同时有两个以上的输入框，会导致死循环
		return true;
	}
	return false;
}

//直接查询IP个数，返回数值
function searchIPCounts (iptype,inputId,showMesid,ipstatus) {
	var inputIpVal = $(inputId).val();
	var url = "/customerserv/searchIPCounts.action";
	var params = {"iptype":iptype,"ipVal":inputIpVal,"ipstatus":ipstatus};
	var returnVal = false;
	//同步请求.
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
            var rs = $.trim(result);
            	if (rs > 0) {
            		checkImgShow(showMesid,2);
            		returnVal = true;
            	} else {
            		checkImgShow(showMesid,-1,'IP不存在或使用中！');
            	}
            }
        });
	return returnVal;
}


//根据当前业务单ID获取当前主机绑定的域名
function queryDomains (bizid) {
	var returnRs = "";
	if (bizid) {
		var url = "/customerserv/queryDomains.action";
		var params = {"bizid":bizid};
		returnRs = queryInfo(url,params,'获取域名失败,请重新登录');
	}
	return returnRs;
}

//动态去除元素事件,id(元素标识ID),hander(函数名称),eventName事件名称如blur.
function removeEvnent(id,hander) {
	var obj = document.getElementById(id);
	if (window.removeEventListener) {
    	obj.removeEventListener('blur',hander, false);
	} else {
    	obj.detachEvent('onblur',hander);
    }
}
function removeEvnents(id,hander,eventName) {
	var obj = document.getElementById(id);
	if (window.removeEventListener) {
    	obj.removeEventListener(eventName,hander, false);
	} else {
    	obj.detachEvent(eventName,hander);
    }
}
//动态添加元素事件
function addEvent(id,hander) {
	var obj = document.getElementById(id);
	if (window.addEventListener) {
	    //其它浏览器的事件代码: Mozilla, Netscape, Firefox
	    //添加的事件的顺序即执行顺序 //注意用 addEventListener 添加带on的事件，不用加on
	    obj.addEventListener('blur', hander , false);
	}
	else {
	    //IE 的事件代码 在原先事件上添加 add 方法
	    obj.attachEvent('onblur', hander);
	}
}


//隐藏
function hideElem (id) {
	document.getElementById(id).style.display = "none";
}
//显示
function showElem (id) {
	document.getElementById(id).style.display = "block";
}


//自定义字典对象
//d.put("CN", "China");
//d.put("US", "America");
function myDictionary(){
	this.data = new Array();
	this.put = function(key,value){
		this.data[key] = value;
	};
	
	this.get = function(key){
		return this.data[key];
	};
	
	this.remove = function(key){
		this.data[key] = null;
	};
	 
	this.isEmpty = function(){
		return this.data.length == 0;
	};
}

//判断字符是否有中文字符  
function isHasChn(str)  {   
    var patrn= /[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/gi;   
    if (!patrn.exec(str)){   
        return false;   
    }else{   
        return true;   
    }   
}   

//字符串 str 中含有汉字
function isInChn (str) {
	if (escape(str).indexOf("%u") < 0) {
	//字符串 str 中含有汉字
		return true;
	} 
	return false;
}

  
//判断字符是否全是中文字符  
function isAllChn(str){   
    var reg = /^[\u4E00-\u9FA5]+$/;   
    if(!reg.test(str)){   
        return false;   
    }   
    lert("中文");   
    return true;   
}

//反正中文的字节数,一个中文两个字节
function getChnByteCounts (str) {
	str = str.replace(/[^\x00-\xff]/g, 'xx');
	return str.length;
}

//获取所有的业务员菜单树,右侧展示
function getRigthTree (url) {
	var divstr = "<div id='treeDivId'><ul id='treeid' class='easyui-tree' data-options='checkbox:true,onlyLeafCheck:true,animate:true'></ul></div>";
	$('#bgrightid').html(divstr);
	var rightHtml = $('#bgrightid').html();
	var params = {};
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsonrs = JSON.parse(result);
		//为树加载数据
		$('#treeid').tree({
			data: jsonrs
		});
	});
	$('#bgmainuiid').layout('expand','east');
}

//获取树形选择的人员,返回ID
function getCheckedid(){
    var nodes = $('#treeid').tree('getChecked');
    var s = '';
    for(var i=0; i<nodes.length; i++){
        if (s != '') s += ',';
        s += nodes[i].id;
    }
    return s;
}

//获取树形选择的人员,返回文本
function getCheckedText(){
    var nodes = $('#treeid').tree('getChecked');
    var s = '';
    for(var i=0; i<nodes.length; i++){
        if (s != '') s += ',';
        s += nodes[i].text;
    }
    return s;
}

//分解字符串格式{1-2,3-4,5-6},index决定获取的位置默认第一位,返回Json
function fgStrOfJson (str,index) {
	if (!index) {
		index = 0;
	}
	var arrys = str.split(",");
	var rs = "{";
	var count = 0;
	for (var i = 0 ; i < arrys.length; i++) {
		var temp = arrys[i].split("-");
		var val = temp[index];
		count++;
		if (count == 1) {
			rs += val;
		} else {
			rs += "," + val;
		}
	}
	rs += "}";
	return JSON.parse(rs);
}

//分解字符串格式{1-2,3-4,5-6},index决定获取的位置默认第一位,返回文本
function fgStrOfStr (str,index) {
	if (!index) {
		index = 0;
	}
	var arrys = str.split(",");
	var rs = "";
	var count = 0;
	for (var i = 0 ; i < arrys.length; i++) {
		var temp = arrys[i].split("-");
		var val = temp[index];
		count++;
		if (count == 1) {
			rs += val;
		} else {
			rs += "," + val;
		}
	}
	return rs;
	
}

//获取当前部门的全局搜索权限{"showColumns":"macnum,dk"}
function getGbqx (deptidParam) {
	var params = {"deptid":deptidParam};
    var url = "/role/loadGbqx.action";
    var returnRs = undefined;
   $.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'text',
        success : function (result){
    		result = $.trim(result);
			if (result) {
				try{
					returnRs = JSON.parse($.trim(result));
				}catch(e){ 
					$.messager.show({ // show error message
						title: '异 常',
						msg: '当前部门信息获取异常,可能是登录失效,请刷新当前页面',
						timeout:5000
					});
				}
			}
    	}
    });
   return returnRs;
}

//全局搜索
function qjSearch () {
	AddRunningDiv(); 
	if (!(currUserDeptid+"")) {
		$.messager.show({ // show error message
			title: '异 常',
			msg: '当前部门信息获取异常,可能是登录失效,请刷新当前页面'
		});
		MoveRunningDiv();
		return;
	}
	//获取全局搜索的权限限制
	var gbqxJson = getGbqx(currUserDeptid);
	if (gbqxJson) {
		var gbqx = fgStrOfStr(gbqxJson["showColumns"]);
		var showTitles = fgStrOfStr(gbqxJson["showColumns"],1);
		
		//开始搜索结果
		var gbval = $.trim($("#qjvalid").val());
		if (!gbval) {
			MoveRunningDiv();
			return;
		}
		if (gbval.length < 4 && !isHasChn(gbval)) {
			$.messager.alert("提示","输入内容过少");
			MoveRunningDiv();
			return;
		}
		var url = "/customerMan/gbSearch.action";
		var params = {"gbval":gbval};
		$.post(url,params,function(result){
			MoveRunningDiv();
			var rs = $.trim(result);
			if (rs) {
				$("#bgcenterid").html(rs);
				//创建中文表头
				createTh(showTitles);
				//开始创建数据
				var hideColumns = ["id","customerid","renpayid","maid"];
				var showColumns = gbqx.split(",");
				var dataFiles = new Array();
				for (var i =0 ; i < showColumns.length; i++) {
					dataFiles[i] = showColumns[i];
				}
				//表头字段
				dataFiles[showColumns.length] = hideColumns;
				//行内按钮
				var clickbutton ="";
				//分页配置
				if (isHasChn(gbval)) {
					//url中文处理
					gbval = encodeURI(encodeURI(gbval));
				}
				var pageEvent = {"action":"/customerMan/loadGbSearchData.action?gbval="+gbval};
				//格式化字段
				var formatFileds = {"biztype":"1-租用,0-托管","macxjstatus":"0-已上架,1-客服下架审核中,2-客服已通知机房,4-机房下架清空处理中","paystatus":"0-<font style='color:red'>未付款</font>,1-已付款,2-<font style='color:white'>过期未续费</font>"};
				var showTableId = "#gbsearchDiv";
				if (createDataGridJsonRows['total'] == 0) {
					$("#bgcenterid").html("<div style='margin-top:30px;' align='center'><img src='/images/zwsj.png' /></div>");
					MoveRunningDiv();s
					return;
				}
				var makeLink = {ipOrder:"makelink",macInfo:"queryMacInfo_gb",custName:"gotoCustInfoPage"};
				createDataGrid(showTableId,createDataGridJsonRows,dataFiles,clickbutton,pageEvent,10,formatFileds,makeLink);
			}
		});
	} else {
		$("#bgcenterid").html("<div style='margin-top:30px;' align='center'><img src='/images/myqx.png' /></div>");
		MoveRunningDiv();
	}
}

//生成中文表头
function createTh (str) {
	var showTh = str.split(",");
	var title = "<th>#</th>";
	for (var i =0 ; i < showTh.length; i++) {
		if (title == "操作") {
			title += "<th width='15%'>" + showTh[i] + "</th>";
		} else {
			title += "<th>" + showTh[i] + "</th>";
		}
	}
	$("#gbSearchTHid").html(title);
}

//通过主IP搜索子IP
function querySubIps (busid) {
	var returnRs = "";
	var url = "/customerserv/querySubIps.action";
	var params = {"busid":busid};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'text',
        success : function (result){
    		result = $.trim(result);
			if (result) {
				try{
					returnRs = JSON.parse($.trim(result));
				}catch(e){ 
					$.messager.show({ // show error message
						title: '异 常',
						msg: '当前部门信息获取异常,可能是登录失效,请刷新当前页面',
						timeout:5000
					});
				}
			}
    	}
    });
	return returnRs;
}

//统一的js请求方法返回值,异步无法在函数结束后返回
function queryInfo (url,params,errorsMessages) {
	var returnRs = "";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'text',
        success : function (result){
			if (checkStr(result)) {
				try{
					var rs = $.trim(result);
					if (isJsonStr(rs)) {
						returnRs = JSON.parse(rs);
					} else {
						returnRs = rs;
					}
					
				}catch(e){
					if (errorsMessages) {
						$.messager.alert("Errors",errorsMessages);
					}
				}
			}
    	}
    });
	return returnRs;
	
}


//统一的js请求方法返回值,异步无法在函数结束后返回
function queryInfoJson (url,params,errorsMessages) {
	var returnRs = "";
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
			if (checkStr(result)) {
				returnRs = result;
			} else {
				if (errorsMessages) {
					$.messager.show({ // show error message
						title: '提 示',
						msg: errorsMessages,
						timeout:6000
					});
				}
			}
    	}
    });
	return returnRs;
	
}

//用于时间控件输入时间段查询，判断输入时间段的合法性,date1开始时间，date2结束时间
function compareDate (date1,date2) {
	if (!date1 && !date2) {
		return "";
	}
	if (!date1) {
		return "请输入开始时间";
	}
	if (!date2) {
		return "请输入结束时间";
	}
	var d1=new Date(Date.parse(date1));
	var d2 = new Date(Date.parse(date2));
	
	if (d1 > d2) {
		return "开始时间大于结束时间";
	}
	return "";
}

//浏览器判断
function getOs()
{
   if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) {
        var obj = window.open("http://se.360.cn/");
        window.top.close(obj);
        return "MSIE";
   }
   if(isFirefox=navigator.userAgent.indexOf("Firefox")!=-1){
        return "Firefox";
   }
   if(isChrome=navigator.userAgent.indexOf("Chrome")!=-1){
        return "Chrome";
   }
   if(isSafari=navigator.userAgent.indexOf("Safari")!=-1) {
        return "Safari";
   } 
   if(isOpera=navigator.userAgent.indexOf("Opera")!=-1){
        return "Opera";
   }

}

//弹出层
function openwin (id,width,height,title) {
	var contentparam = $(id).html();
	layer.open({
        type: 1,
        skin: 'layui-layer-lan',
        title: title,
        fix: false,
        btn:'关闭',
        shadeClose: false,
        maxmin: true,
        area: [width, height],
        content: contentparam,
        end: function(){
            //layer.tips('服务器信息', id, {tips: 1})
 	    }
	});
}

// 给日期类对象添加日期差方法，返回日期与diff参数日期的时间差，单位为天
Date.prototype.diff = function(date){
  return (this.getTime() - date.getTime())/(24 * 60 * 60 * 1000);
}
// 构造两个日期，分别是系统时间和自定义日期,返回天数.
function diffDate (date) {
	var now = new Date();
	var date = new Date(date);
	var diffDays = parseInt(now.diff(date));
	//alert(now+"---"+date+"*****"+diffDays+">-5?");
	return diffDays;
}


/**
 * IP所在机房与选择的机房是否匹配
 * 
 * @iptype ip类型（dxip，unip）
 * @ipValid ip文本框的id，用了获取ip 的值
 * @comproom 选择的机房id
 * 
 * */
function checkIpComproom (iptype,ipValid,comproom) {
	//alert("iptype:"+iptype+"                   ipValid:"+ipValid+"             comproom:"+comproom)
	var ipVal = $(ipValid).val();
	var url = '/customerMan/checkIpComproom.action';
	var params = {"iptype":iptype,"ipVal":ipVal,"comproom":comproom};
	var ipvali = false;
	$.ajax({
		url : url,
		data : params,
		cache : false,
		async : false,
		type : "POST",
		dataType : 'json',
		success : function (result){
			var rs = $.trim(result);
			if(rs== 0 ){
				if(iptype=='unip') {
					checkImgShow("#unerrorsip",-1,'IP所属机房与选择的机房不相符');
					checkImgShow("#Machouse #unerrorsip",-1,'IP所属机房与选择的机房不相符');
					ipvali= false;
				}else if (iptype == 'dxip') {
					checkImgShow("#dxerrorsip",-1,'IP所属机房与选择的机房不相符');
					checkImgShow("#Machouse #dxerrorsip",-1,'IP所属机房与选择的机房不相符');
					 ipvali= false;
				}
			}else{
				ipvali =true;
			}
		}
	});
	return ipvali;
}