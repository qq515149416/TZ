
//currRowObjJson 鼠标移到当前行的行对象.
var currRowObjJson = undefined;
//自定义字典
var mytableArray = new myDictionary ();

//统一加载数据的方法
function loadMyMDataForPage (action,params) {
	var rs = "";
	$.ajax({
        url : action,
        data: params,
        cache : false, 
        async : false,
        type : "post",
        dataType : 'json',
        success : function (result){
            rs = result;
		}
	});
	return rs;
}



/**
 * 统一生成表格函数
 * @param {Object} rowsJson     (必填)格式如:{"total":1,"rows":[{"creded":2000,"truename":"业务伟"}]},后台返回的json数据集合
 * @param {Object} dataFiles    (必填)格式如:["dxip","rensc","biztype",["fh","id"]]二维数组,数组元素位置不限制,建议统一放在最后一个元素中;显示的字段名称,要与数据库查询语句中的字段名称相符合,最后一个元素数组是隐藏字段;
 * @param {Object} formatFileds (可选)格式如:{"biztype":"1-租用,0-托管"},格式化字段json参数,biztype为字段名称,后面是多个不同值得判断;
 * @param {Object} clickbutton  (必填)格式如:{"aMethod":"aMacInfo-配置-queryMacInfo-white,aAskQus-提问-askQuestion"};按钮json参数,其中aMacInfo作为按钮的ID,askQuestion作为方法名称,white按钮颜色默认橙色;
 * @param {Object} pageEvent    (必填)格式如:{"action":"/members/loadMyMac.action"},分页事件请求路径;
 * @param {Object} makeLink     (可选)格式如:"funcName" //函数默认参数为字段值
 */
function createDataGrid (showTableId,rowsJson,dataFiles,clickbutton,pageEvent,psize,formatFileds,makeLink) {
	if (rowsJson) {
		var pageSize = undefined;
		if (!psize) {
			pageSize = 10;
		} else {
			pageSize = psize;
		}
		var tableObject = createTable (showTableId,rowsJson,dataFiles,clickbutton,pageSize,formatFileds,makeLink);
		var currPage = tableObject.currPage;
		var pageCount = tableObject.pageCount;
		pageSize = tableObject.pageSize;
		//添加分页事件
		if (pageEvent) {
			//移除事件,防止事件递归叠加.
			var loadAction = pageEvent.action;
			var firstPageid = showTableId+" #firstPage";
			var upPageid = showTableId+" #upPage";
			var nextPageid = showTableId+" #nextPage";
			var lastPageid = showTableId+" #lastPage";
			
			//重新绑定事件
			if ($(firstPageid)) {
				$(firstPageid).unbind ( 'click' ).bind ( 'click' , function(){ 
					AddRunningDiv();
					currPage = 1;
					var rs = loadMyMDataForPage(loadAction,{"currPage":currPage});
					createTable (showTableId,rs,dataFiles,clickbutton,pageSize,formatFileds,makeLink);
					currPage = rs['currPage'];
					
				});
			}
			
			$(upPageid).unbind ( 'click' ).bind ( 'click' , function(){ 
				AddRunningDiv();
				currPage = currPage - 1;
				var rs = loadMyMDataForPage(loadAction,{"currPage":currPage});
				createTable (showTableId,rs,dataFiles,clickbutton,pageSize,formatFileds,makeLink);
				currPage = rs['currPage'];
			});
			
			$(nextPageid).unbind ( 'click' ).bind ( 'click' , function(){ 
				AddRunningDiv();
				currPage = currPage + 1;
				var rs = loadMyMDataForPage(loadAction,{"currPage":currPage});
				createTable (showTableId,rs,dataFiles,clickbutton,pageSize,formatFileds,makeLink);
				currPage = rs['currPage'];
			});
			if ($(lastPageid)) {
				$(lastPageid).unbind ( 'click' ).bind ( 'click' , function(){ 
					AddRunningDiv();
					currPage = pageCount;
					var rs = loadMyMDataForPage(loadAction,{"currPage":currPage});
					createTable (showTableId,rs,dataFiles,clickbutton,pageSize,formatFileds,makeLink);
					currPage = rs['currPage'];
				});
			}
		}
	}
}

//创建表格
function createTable (showTableId,rowsJson,dataFiles,clickbutton,pageSize,formatFileds,makeLink) {
		var htmls = "";
		var rows = rowsJson['rows'];
		if (!rows) {
			rows = new Array();
		}
		var totalRows = rowsJson['total'];
		if (!totalRows) {
			totalRows = 0;
		}
		var currPage = rowsJson['currPage'];
		if (!currPage) {
			currPage = 0 ;
		}
		var pageCount = rowsJson['pageCount'];
		if (!pageCount) {
			pageCount = 0;
		}
		if (!pageSize) {
			pageSize = 10;
		}
		var totalMes = "共" + pageCount + "页&nbsp;共" + totalRows + "条记录";
		var currPageMes = "当前第" + currPage + "页";
		var totalMesid = showTableId+" #totalMes";
		var currPageid = showTableId+" #currPage";
		$(totalMesid).html(totalMes);
		$(currPageid).html(currPageMes);
		
		//为了处理多个table同时存在的情况,把table封装对象,放到自定义的字典中,为了当鼠标移动到数据行时,通过table的id标识去准确获取当前的行数据对象值.
		var tableOject = new Object();
		tableOject.dataRows = rows;
		tableOject.dataFiles = dataFiles;
		mytableArray.put(showTableId,tableOject);
		//循环结果集的数据
		for (var i = 0 ; i < rows.length ; i++) {
			var rowData = rows[i];		
			//计算即将到期的机器行数据显示颜色,trcolor行的颜色设置，flagColor标识是否同时是未付款而且又到期或逾期
			var trcolor = "";
			var flagColor1 = 0;
			var flagColor2 = 0;
			for (var c = 0 ; c < dataFiles.length ; c++) {
				var filed = dataFiles[c];
				
				if (filed == "renendtime") {
					var renendtime = rowData["renendtime"];
					var diffdays = diffDate(renendtime);
					//alert(renendtime + (diffdays >= -5));
					if (diffdays >=0 ) {
						trcolor = "#E36358";
						flagColor1 = 1 ;
					} else if(diffdays >=-5 && diffdays < 0){
						trcolor = "#FF99FF";
						flagColor1 = 2 ;
					}else {
						flagColor1 = 0 ;
					}
				} 
				if (filed == "paystatus") {
					var paystatus = rowData["paystatus"];
					if (paystatus == 0) {
						trcolor = "#5ACF00";
						flagColor2 = 1 ;
					} else {
						flagColor2 = 0 ;
					}
				} 
				
				if (flagColor1 == 1 && flagColor2 == 1) {
					trcolor = "#F8E8B0";
				}
			}
			//批量付款续费的资源表格增加复选框
			if(showTableId == "#dkMacResources" || showTableId == "#fhMacResources" || showTableId == "#dxipMacResources" || showTableId == "#unipMacResources" || showTableId == "#dkResources" || showTableId == "#fhResources" || showTableId == "#dxipResources" || showTableId == "#unipResources"){
				htmls += "<tr height='30px;' onmouseover=myDataRow('" + i + "','"+ showTableId +"')><td>" + (i + 1) + "&nbsp;&nbsp;&nbsp;<input type='checkbox' id='payment' value='"+i+"'>" + "</td>";
			//在table中显示有附加资源展开按钮
			}else if(showTableId == "#busDataid" ){
				//查找机器资源中的
				var rescount = selectMacResCount(rowData["id"]);
				if(rescount > 0 ){
					htmls += "<tr height='30px;' onmouseover=myDataRow('" + i + "','"+ showTableId +"')><td>" + (i + 1) 
					+ "<span style='width:15px;height:15px;display:block;cursor:pointer;' class='datagrid-row-expander datagrid-row-expand' id='row-"+rowData["id"]+"' onclick='showResources("+rowData["id"]+")'></td>";
				}else{
					htmls += "<tr height='30px;' onmouseover=myDataRow('" + i + "','"+ showTableId +"')><td>" + (i + 1) + "</td>";
				}
			}else{
				htmls += "<tr height='30px;' onmouseover=myDataRow('" + i + "','"+ showTableId +"')><td>" + (i + 1) + "</td>";
			}
			//循环字段值
			//subIps为子IP的Json对象.
			var subIps = "";
			//domains为此工单的IP地址绑定的域名
			var domains = "";
			for (var b = 0 ; b < dataFiles.length ; b++) {
				var filed = dataFiles[b];
				//valFiled原值,textFiled文本展示值
				var valFiled = rowData[filed];
				if (checkStr(valFiled) == false) {
					//查询结果中没有参数的字段值，而是从另一个字段值去获取所需要显示的结果时，就会出现这种情况。例如查询结果中只是需要id,但是显示结果却是由id查询出域名的延伸结果.
					valFiled = "";
				}
				var textFiled = valFiled;
				//ff,要格式化的字段,参数格式{"biztype":"0-租用,1-托管"};
				var ff = formatFileds[filed];
				if (formatFileds && ff) {
					var vals = ff.split(",");
					for (var c = 0 ; c < vals.length ; c++) {
						var vals1 = vals[c];
						var arr = vals1.split("-");
						if (valFiled == arr[0]) {
							textFiled = arr[1];
						} 
					}
				}
				
				//判断是否有隐藏字段需要渲染,如果存在隐藏字段,则当前的元素为二维数组中的数组元素.
				if (filed instanceof Array) {
					//隐藏字段数组
					for (var f = 0 ; f < filed.length ; f++) {
						var hiddenFiled = filed[f];
						htmls += ("<td style='display:none'><input id='"+hiddenFiled+"' value='"+rowData[hiddenFiled]+"'></td>");
					}
					
				} else {
					var resourseIPhasNoSubIP ="";
					if((JSON.stringify(dataFiles).indexOf("resourseIPhasNoSubIP")>0)){
						resourseIPhasNoSubIP="resourseIPhasNoSubIP";
					}
					//----判断是否IP,rowData['id']业务单ID,返回0则要显示子IP,这里还要想办法控制内循环的多次请求----------
					var isIp = compareReAndText(valFiled,IP);
					if(filed=="unicomip" && valFiled==""){
						isIp=0
					}
					if (isIp == 0 && rowData['id']) {
						if(resourseIPhasNoSubIP!="resourseIPhasNoSubIP"){
							//获取子IPs.
							if (subIps == "") {
								//这里是根据业务单编号获取子IP
								var bizid = rowData['id'];
								subIps = querySubIps(bizid);
							}
							var subDxips = subIps['subDxips'];
							var subUnips = subIps['subUnips'];
							var textfieldSubip = "";
							if (filed == "dxip") {
								//分解字符串
								if(typeof(makeLink) != 'undefined' && typeof(makeLink) != 'undefined'){
									for (var c = 0 ; c < subDxips.length; c++)
										textfieldSubip += ("<br>" + "<a style='color: black;font-weight:600;' onclick=\'" + makeLink.ipOrder +"(\""+subDxips[c]+"\")\'>" + subDxips[c] + "</a>");
									}else{
									for (var c = 0 ; c < subDxips.length; c++) {
										textFiled += ("<br><span style='color:black;font-weight:600;'>" + subDxips[c]+"</span>");
									}
								}

							} else {
								//分解字符串
								if(typeof(makeLink) != 'undefined' && typeof(makeLink) != 'undefined'){
									for (var c = 0 ; c < subUnips.length; c++) {
										textfieldSubip += ("<br>" + "<a style='color:black;font-weight:600;' onclick=\'" + makeLink.ipOrder +"(\""+subUnips[c]+"\")\'>" + subUnips[c] + "</a>");
									}
								}else{
									for (var c = 0 ; c < subUnips.length; c++) {
										textFiled += ("<br><span style='color:black;font-weight:600;'>" + subUnips[c]+"</span>");
									}
								}
							}
						}
					}
					
					//-----获取IP下绑定的域名,以业务单ID为标准,而不是以IP为条件.为了不影响以后有可能要做的历史记录问题.--------showTableId == "#xiajiaTid"限制只是下架审核表格的域名展示.
					if (filed == "domain" && showTableId == "#xiajiaTid") {
						//domains==''防止读取同一行数据时重复执行,影响效率.
						if (domains == "") {
							domains = queryDomains(rowData['id']);
							var arrayJson = domains["domains"];
							for (var c = 0 ; c < arrayJson.length; c++) {
								textFiled += (arrayJson[c] + "<br>" );
							}
							if (valFiled == "") {
								valFiled = textFiled;
							}
						}
					}
					
					//展示字段
					//if (textFiled && typeof(textFiled) == "string") {
					//	textFiled = mydecode(textFiled);
					//} style='background-color:"+trcolor+"'
					
					var showTd;
					if(typeof(makeLink) != 'undefined'){
						if((typeof(makeLink.ipOrder) != 'undefined' && filed == "dxip") || (typeof(makeLink.ipOrder) != 'undefined' && filed == "unicomip")){
							showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'>" + "<a onclick=\'" + makeLink.ipOrder +"(\""+valFiled+"\")\'>" + textFiled + "</a>" + textfieldSubip + "</td>";
						}
						else if(typeof(makeLink.macInfo)!= 'undefined' && filed == "macnum"){
							showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'>" + "<a onclick=\'" + makeLink.macInfo +"(\""+valFiled+"\")\'>" + textFiled + "</a>" + "</td>";
						}else if(typeof(makeLink.custName)!= 'undefined' && filed == "custruename"){
							showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'>" + "<a onclick=\'" + makeLink.custName +"(\""+valFiled+"\")\'>" + textFiled + "</a>" + "</td>";
						}
						else{					
							showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'>" + textFiled + "</td>";
						}
					}else{	
							if(filed=="cusname"&&((rowData['flag1']==3&&rowData['flag2']==3)||(rowData['flag1']==null&&typeof rowData['flag1'] != typeof undefined))){
								showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'>" +"<font color='red'>"+textFiled + "</font>"+"</td>";
							}else if(filed == "paystatus"){
								var paystatus = rowData["paystatus"];
								if(paystatus==0){
									showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'><font style='color:red'>" +textFiled + "</font></td>";
								}else if (paystatus==2) {
									showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'><font style='color:white'>" +textFiled + "</font></td>";
								}else{
									showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'>" +textFiled + "</td>";
								}
							}else{
								showTd = "<td style='border: 1px solid #dddddd;background-color:"+trcolor+"'><input type='hidden' id='"+filed+"' value='"+valFiled+"'>" +textFiled + "</td>";
							}
					}
					htmls += showTd;
				}
			}
			//添加按钮
			if (clickbutton) {
				//获取要添加的按钮和事件参数
				var ck = clickbutton.aMethod;

				//数据的类型
				var type = clickbutton.bizType;
				var  rescount ="";
				if(type=="mac"){
					var id = rowData['id'];
					if(id){
						//查找机器资源中的
						rescount = selectMacResCount(id);
					}
				}
				
				var butstr = "<td style='border: 1px solid #dddddd'>";
				if (ck) {
					//分割字符串,获取按钮和事件参数字符串
					var buts = ck.split(",");
					for (var d = 0 ; d < buts.length ; d++) {
						var buts1 = buts[d];
						//分割字符串,获取按钮和事件参数数组
						var butarr = buts1.split("-");
						//渲染按钮
						if (butarr[3]) {
							if(butarr[4]){
								if(rescount>0){
									butstr += "<a style='margin-bottom:5px;' href='javascript:void(0)' name='"+butarr[0]+"' id='"+butarr[0]+"' class='button red small'>"+butarr[1]+"</a>";
								}else{
									butstr += "<a style='margin-bottom:5px;' href='javascript:void(0)' name='"+butarr[0]+"' id='"+butarr[0]+"' class='button white small'>"+butarr[1]+"</a>";
								}
							}else{
								//自定义颜色
								butstr += "<a style='margin-bottom:5px;' href='javascript:void(0)' name='"+butarr[0]+"' id='"+butarr[0]+"' class='button "+butarr[3]+" small'>"+butarr[1]+"</a>";
							}
						} else {
							//默认橙色
							butstr += "<a style='margin-bottom:5px;' href='javascript:void(0)' name='"+butarr[0]+"' id='"+butarr[0]+"' class='button orange small'>"+butarr[1]+"</a>";
						}
						
					}
					butstr += "</td>";
					htmls += butstr;
				}
			}
			htmls += "</tr>";
		}
		
		if (rows.length == 0) {
			var tdCounts = dataFiles.length;
			if (clickbutton) {
				tdCounts += 1;
			}
			htmls += "<tr height='30px;' ><td colspan=" + tdCounts +" style='border: 1px solid #dddddd;text-align: center;'>暂 无 数 据 ！</td></tr>" ;
		}
		
		//不够指定的行数,就用空白行填充.
		//if (i < pageSize) {
		//	for (var a = 0 ; a < (pageSize - i) ; a++ ) {
		//		htmls += "<tr height='30px;'>" ;
		//		var tdCounts = dataFiles.length;
		//		if (clickbutton) {
		//			tdCounts += 1;
		//		}
		//		for( var c = 0 ; c < tdCounts; c++) {
		//			htmls += "<td style='border: 1px solid #dddddd'></td>";
		//		}
		//		htmls += "</tr>";
		//	}
		//}
		var showid = showTableId+" #createMyTableid";
		$(showid).html(htmls);
		//添加行按钮事件
		bingRowEvent (clickbutton);
		var rs = {"currPage":currPage,"pageCount":pageCount,"pageSize":pageSize};
		MoveRunningDiv();
		return rs;
}

//添加行按钮事件,注意：必须要把按钮渲染到页面后,再调用此方法进行绑定才能起效果.
function bingRowEvent(clickbutton) {
	//添加按钮事件
	if (clickbutton) {
		//获取要添加的按钮和事件参数
		var ck = clickbutton.aMethod;
		if (ck) {
			//分割字符串,获取按钮和事件参数字符串
			var buts = ck.split(",");
			for (var d = 0 ; d < buts.length ; d++) {
				var buts1 = buts[d];
				//分割字符串,获取按钮和事件参数数组
				var butarr = buts1.split("-");
				var selectorid = '[id=' + butarr[0] + ']';
				var butMethodName = eval(butarr[2]);
				var allByIds = document.getElementsByName(butarr[0]);
				//动态添加事件
				for (var c = 0 ; c < allByIds.length ; c++) {
					var obj = allByIds[c];
					if (window.attachEvent) {
					    //IE 的事件代码
						obj.attachEvent("onclick",butMethodName);
					}
					else {
					    //其它浏览器的事件代码
						obj.addEventListener("click",butMethodName, false);
					}
				}
				
			}
		}
	}
}


//创建dataRow数据行对象
function myDataRow (currRowIndex,showTableId) {
	//myDataRows数据集,myDataFiles数据列,两者都用于用于数据表格的生成。
	var myDataRows = mytableArray.get(showTableId).dataRows;
	var myDataFiles = mytableArray.get(showTableId).dataFiles;
	var jsonVal = "[";
	var tempStr = "";
	
	if (myDataFiles && myDataRows) {
		for (var i = 0 ; i < myDataRows.length ; i++) {
			var rowData = myDataRows[i];
			tempStr += "{";
			//循环字段值
			for (var b = 0 ; b < myDataFiles.length ; b++) {
				var filed = myDataFiles[b];
				var valFiled = rowData[filed];
				if (typeof(valFiled) == "string") {
					valFiled = dotran(valFiled);
				}
				
				if (filed instanceof Array) {
					//添加封装隐藏字段数组的值
					for (var f = 0 ; f < filed.length ; f++) {
						var hiddenFiled = filed[f];
						tempStr += "'" + hiddenFiled + "':" + "'" + rowData[hiddenFiled] + "'";
						//每次封装完一个元素的键值,就添加一个逗号,最后一个值逗号省略.
						if (f < filed.length -1) {
							tempStr += ",";
						}
					}
				} else {
					//添加封装正常字段值
					tempStr += "'" + filed + "':" + "'" + valFiled + "'";
					if (b < myDataFiles.length -1 ) {
						tempStr += ",";
					}
				}
			}
			tempStr += "}";
			if (i < myDataRows.length - 1) {
				tempStr += ",";
			}
		}
	}
	jsonVal += tempStr + "]";
	jsonVal = eval(jsonVal.replace('\\','\\\\'));
	currRowObjJson = jsonVal[currRowIndex];
}

/**
 * 查找机器是否存在资源
 * */
function selectMacResCount(id){
	var count = 0;
	var url = "/customerMan/selectMacResCount.action";
	var params = {'id':id,"resstatus":0};
	$.ajax({
		url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
        	count = result.rescount
        }
	});
	return count;
}

/**
 * 判断是否联通主IP
 * */
function checkIfMainUnip(id){
	var temp = false;
	var url = "/members/checkIfMainUnip.action";
	var params = {'id':id};
	$.ajax({
		url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
        	temp = result;
        }
	});
	return temp;
}


/**
 * 查找机器资源
 * */
function showResources(cusbizid){
	var thisNode = $("#row-"+cusbizid);
	var check = thisNode[0].isExpand || 0;
	var resHtmlr = getResBycusbizid(cusbizid);
	switch (check) {
	case 0:
		thisNode.removeClass('datagrid-row-expand');
		thisNode.addClass('datagrid-row-collapse');
		thisNode.parent().parent().after('<tr><td style="" colspan="999">'+resHtmlr+'</td></tr>');
		thisNode[0].isExpand = 1;
		break;
	case 1:
		thisNode.removeClass('datagrid-row-collapse');
		thisNode.addClass('datagrid-row-expand');
		thisNode.parent().parent().next().hide();
		console.log(thisNode.parent().parent().next())
		thisNode[0].isExpand = 2;
		break;
	case 2:
		thisNode.removeClass('datagrid-row-expand');
		thisNode.addClass('datagrid-row-collapse');
		thisNode.parent().parent().next().show();
		thisNode[0].isExpand = 1;
		break;
	default:
		break;
	}
}

function getResBycusbizid(cusbizid){
	var temp = false;
	var url = "/customerMan/getResBycusbizid.action";
	var params = {'cusbizid':cusbizid};
	$.ajax({
		url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'json',
        success : function (result){
        	temp="<table style='margin:0 auto;'>";
        	for(var i = 0; i<result.res.length ; i++){
        		var resOb = result.res[i];
        		temp += "<tr><td>"+resOb.restype+"</td><td>"+resOb.res+"</td><td>"+resOb.price+"</td><td>"+resOb.renbegintime+"</td><td>"+resOb.renendtime+"</td><td>"+resOb.respaystatus+"</td></tr>"
        	}
        	temp +="</table>";
        	//temp = result;
        }
	});
	return temp;
}

