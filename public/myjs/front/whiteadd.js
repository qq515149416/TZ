
$(function(){
	checkwlInput();
	//loadmac();
	//loadCusIps("dxip");
	//loadCusIps("unicomip");
})

//用于保存当前客户的IP的Json数据
var cusdxips = undefined;
var cusunips = undefined;

//加载客户当前拥有的机器
function loadmac () {
	var url = "/members/laodMacList.action";
	var params = {};
	var rs = queryInfo (url,params,'服务器资源加载异常');
	var options = "";
	//initid初始化加载IP
	var initid = "";
	if (rs) {
		for(var i = 0 ; i < rs.length; i++) {
			var id = rs[i]['id'];
			var macnum = rs[i]['macnum'];
			options += '<option value="' + id +'">' + macnum + '</option>';
			if (!initid) {
				initid = id;
			}
		}
		loadDxUnIps(initid);
		$("#macnumid").html(options);
	}
}

//根据业务单ID加载当前机器的所有IP
function loadDxUnIps (id) {
	var url = "/members/loadDxUnIps.action";
	var params = {"bizid":id};
	var rs = queryInfo (url,params,'IP加载异常');
	var options = "";
	if (rs) {
		var dxips = rs['dxips'];
		var unips = rs['unips'];
		for(var i = 0 ; i < dxips.length; i++) {
			var dxip = dxips[i];
			options += '<option value="' + dxip +'">' + dxip + '</option>';
		}
		$("#dxipidcombox").html(options);
		options = "";
		
		for(var a = 0 ; a < unips.length; a++) {
			var unip = unips[a];
			options += '<option value="' + unip +'">' + unip + '</option>';
		}
		$("#unipidcombox").html(options);
	}
}


//初始加载客户的所有IP,hadbingIPForCus标识客户是否有IP可以提交白名单.
function loadCusIps (iptype) {
	var url = "";
	var params = "";
	if (iptype == "dxip") {
		//params = {"iptype":"dxip"};
		url = "/members/loadCusdxIps.action";
	} else if (iptype == "unicomip") {
		//params = {"iptype":"unicomip"};
		url = "/members/loadCusunIps.action";
	}
	
	$.post(url,params,function(result){
		var rs = $.trim(result);
		var jsondata = eval(rs);
		if (jsondata.length != 0) {
			$("#subwlid").show();
			if (iptype == "dxip") {
				cusdxips = jsondata;
				$("#dxipidcombox").combobox('loadData',jsondata);
				$("#dxipidcombox").combobox("setValue",jsondata[0]["ip"]);
				
			} else if (iptype == "unicomip"){
				cusunips = jsondata;
				$("#unipidcombox").combobox('loadData',jsondata);
				$("#unipidcombox").combobox("setValue",jsondata[0]["ip"]);
			}
		} else {
			$("#subwlid").hide();
			$.messager.show({
				title: '提 示',
				msg: '客户没有可提交的IP'
			});
		}
  	});
}

//提交白名单
var macnumOfIP = "";
function subWhiteList () {
	if ( recnumF&&urlF && bip && checkStr(macnumOfIP)) {
		//$("#subwlid").attr("disabled",true);
		//var dxip = $('#dxipidcombox').combobox("getValue");
		//var unip = $('#unipidcombox').combobox("getValue");
		//var dxip = $('#dxipidcombox').val();
		//var unip = $('#unipidcombox').val();
		//var unitname = $("#unitnameid").val();
		//var tel = $("#telid").val();
		//var addr = $("#addrid").val();
		//var email = $("#emailid").val();
		//var zjnum = $("#zjnumid").val();
		//var bizid = $("#macnumid").val();
		var domain = $("#domainid").val();
		var recnum = $("#recnumid").val();
		var ip = $("#ipid").val();
		var submitnote = $("#submitnoteid").val();
		var url = "/members/addWhiteList.action";
		var params = {"domain":domain,"ip":ip,"macnum":macnumOfIP,"submitnote":submitnote,"recnum":recnum};
		$.post(url,params,function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				$.messager.show({
					title: '提 示',
					msg: '提交成功，请待审核....'
				});
				//刷新
				//$.post('/cusresult/whiteList.jsp','',function(result){
				//	var rs = $.trim(result);
				//	$("#frontMainid").html(rs)
				//});
				//清空
				$("#domainid").val('');
				$("#recnumid").val('');
				$("#submitnoteid").val('');
				//$("#unitnameid").val('');
				//$("#telid").val('');
				//$("#addrid").val('');
				//$("#emailid").val('');
				//$("#zjnumid").val('');
				checkImgShow("#domainmesid",2);
				//checkImgShow("#emailmesid",2);
				//checkImgShow("#telmesid",2);
				checkImgShow("#recnummesid",2);
				//checkImgShow("#unitnamemesid",2);
				//checkImgShow("#addrmesid",2);
				//checkImgShow("#zjnummesid",2);
				urlF = false;
				recnumF = false;
				bip = false;
			}
			//$("#subwlid").attr("disabled",false);
		});
		
	} else {
		$.messager.show({
			title: 'Error',
			msg: '必填项不能为空或者输入信息有误'
		});
	}
}

//检查白名单输入的字段
//var unF = true;
//var dxF = false;
var urlF = false;
//var unitnameF = false;
//var telF = false;
//var addrF = false;
//var zjnumF = false;
//var emailF = false;
var recnumF = false;
var bip = false;
function checkwlInput () {
	$("#domainid").focus();
	//检查域名输入
	$("#domainid").blur (function(){
		var domain = $("#domainid").val();
		var rex = "http://";
		var rex1 = "/";
		var rex2 = "\\";
		var rex3 = "www";
		var str = domain.split(".");
		var temp = valiInput(DOMAIN,"domainid","");
		if (!temp || !domain || str[0] == rex3 || domain.indexOf(rex2) >= 0 || domain.indexOf(rex1) >= 0 || domain.indexOf(rex) >= 0) {
			$("#domainid").val('');
			checkImgShow("#domainmesid",-1,"*必填");
		} else {
			//检查是否黑名单
			var url = "/customerserv/blacklist.action";
			var params = {"domain":domain,"rs":"json"};
			var rs = queryInfo (url,params,"域名检查异常");
			if (rs.total > 0) {
				checkImgShow("#domainmesid",-1,"黑名单域名");
				
			} else {
				urlF = true;
				checkImgShow("#domainmesid",0);
			}
			
		}
	});
	
	//检查IP
	//$("#dxipidcombox").combobox ({
	//	onChange:function(){  
	//		var dxval = $('#dxipidcombox').combobox("getValue");
	//		//检查非空
	//		if (dxval) {
	//			//检查输入的IP是否存在
	//			for (var i = 0 ; i < cusdxips.length ; i++) {
	//				var iptemp = cusdxips[i]["ip"];
	//				if (dxval == iptemp) {
	//					dxF = true;
	//					checkImgShow("#dxipmesid",0);
	//					break;
	//				} else {
	//					dxF = false;
	//					checkImgShow("#dxipmesid",-1);
	//				}
	//			}
	//		} else {
	//			checkImgShow("#dxipmesid",-1);
	//		}
	//    }
	//});
	
	//联通IP，不是必填,但是如果填写了，就要验证
	//$("#unipidcombox").combobox ({
	//	onChange:function(){  
	//		var unval = $('#unipidcombox').combobox("getValue");
	//		//检查非空
	//		if (unval) {
	//			//检查输入的IP是否存在
	//			unF = false;
	//			for (var i = 0 ; i < cusunips.length ; i++) {
	//				var iptemp2 = cusunips[i]["ip"];
	//				if (unval == iptemp2) {
	//					unF = true;
	//					checkImgShow("#unipmesid",0);
	//					break;
	//				} else {
	//					unF = false;
	//					checkImgShow("#unipmesid",-1);
	//				}
	//			}
	//		} else {
	//			checkImgShow("#unipmesid",-1);
	//		}
	//    }
	//});
	
	//备案编号
	$("#recnumid").blur(function(){
		var recnum = $("#recnumid").val();
		recnum = $.trim(recnum);
		if (recnum) {
			recnumF = true;
			checkImgShow("#recnummesid",0);
		} else {
			checkImgShow("#recnummesid",-1,"*必填");
		}
	});
	
	
	//IP验证
	$("#ipid").blur(function(){
		var ip = $("#ipid").val();
		if (ip) {
			var url = "/members/queryMacInfoOfIP.action";
			var params = {"ip":ip};
			var rs = queryInfo(url,params);
			if (typeof(rs) == 'object' && rs.length > 0) {
				bip = true;
				macnumOfIP = rs[0].macnum;
				$("#macnumid").val(macnumOfIP);
				var customerid = rs[0].customerid;
				url = "/customerMan/queryMycustomerForCon.action";
				params = {"cusid":customerid};
				rs = queryInfo(url,params);
				if (rs.length > 0) {
					var cusqq = rs[0].cusqq;
					var custruename = rs[0].custruename;
					$("#cusQQid").val(cusqq);
					$("#custruenameid").val(custruename);
				}
				checkImgShow("#ipMesid",0);
			} else {
				checkImgShow("#ipMesid",-1,"IP有误");
				$("#macnumid").val('');
				$("#cusQQid").val('');
				$("#custruenameid").val('');
			}
			
		} else {
			checkImgShow("#ipMesid",-1,"*必填");
			$("#macnumid").val('');
			$("#cusQQid").val('');
			$("#custruenameid").val('');
		}
	});
	
	$('#orderid').tabs({
      border:false,   
      onSelect:function(title){   
		  var checkstatus = "";
		  var showtable = "";
		  var blacklist = "";
          if(title == "审核中"){
        	  checkstatus = 0;
        	  showtable = "#checkWhiteListsid";
        	  
          }else if (title == "审核通过") {
        	  checkstatus = 1;
        	  showtable = "#passWhiteListsid";
        	  
          } else if (title == "审核不通过") {
        	  checkstatus = 2;
        	  showtable = "#fialWhiteListsid";
        	  
          } else if (title == "黑名单") {
        	  checkstatus = -1;
        	  blacklist = 1;
        	  showtable = "#blackWhiteListsid";
          }
          
          var url = "/customerserv/loadWhiteData.action";
    	  var params = {"checkstatus":checkstatus,"blacklist":blacklist};
    	  var rs = queryInfo (url,params);
    	  showData(rs,showtable,checkstatus);
      }   
  });
	
	
	//主办单位
	//$("#unitnameid").blur(function(){
	//	var unitname = $("#unitnameid").val();
	//	if (unitname) {
	//		unitnameF = true;
	//		checkImgShow("#unitnamemesid",0);
	//	} else {
	//		checkImgShow("#unitnamemesid",-1);
	//	}
	//});
	
	//联系电话
	//$("#telid").blur(function(){
	//	var tel = $("#telid").val();
	//	if (tel) {
	//		telF = true;
	//		checkImgShow("#telmesid",0);
	//	} else {
	//		checkImgShow("#telmesid",-1);
	//	}
	//});
	
	//联系地址
	//$("#addrid").blur(function(){
	//	var addr = $("#addrid").val();
	//	if (addr) {
	//		addrF = true;
	//		checkImgShow("#addrmesid",0);
	//	} else {
	//		checkImgShow("#addrmesid",-1);
	//	}
	//});
	
	//证件号码
	//$("#zjnumid").blur(function(){
	//	var zj = $("#zjnumid").val();
	//	if (zj) {
	//		zjnumF = true;
	//		checkImgShow("#zjnummesid",0);
	//	} else {
	//		checkImgShow("#zjnummesid",-1);
	//	}
	//});
	
	//邮箱地址
	//$("#emailid").blur(function(){
	//	var email = $("#emailid").val();
	//	if (email) {
	//		emailF = true;
	//		checkImgShow("#emailmesid",0);
	//	} else {
	//		checkImgShow("#emailmesid",-1);
	//	}
	//});
}


//展示数据
function showData (data,showTableId,confiditons) {
	if (!data) {
		return;
	}
	// 表头
	var dataFiles = [ "domain", "mname", "cname", "addtype", "addtime", "passdate","submitnote","note", [ "id","bizid","cusid","masid" ] ];
	if(confiditons == 0){
		dataFiles = [ "domain", "mname", "cname", "addtype", "addtime","submitnote", [ "id","bizid","cusid","masid" ] ];
	}else{
		dataFiles = [ "domain", "mname", "cname", "addtype", "addtime", "passdate","submitnote","note", [ "id","bizid","cusid","masid" ] ];
	}
	// 行内按钮
	var clickbutton = "";
	// 格式化字段
	var formatFileds = {"addtype":"0-业务员,1-客户"};
	// 分页配置
	var url = "/customerserv/loadWhiteData.action?checkstatus="+confiditons;
	var pageEvent = {"action":url};
	createDataGrid(showTableId, data, dataFiles, clickbutton,pageEvent, 10, formatFileds);
}

