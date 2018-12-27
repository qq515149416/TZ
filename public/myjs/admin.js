

//初始化菜单
$(function(){
	$.post("/role/actionQueryByUser.action",{},function(result){
    	afterLoadUI("#bgmeunid",result);
  	});
	showMeunContent("/login/goManager.action");
	
	//部门id：1网维；4综合；9运维；10网管
	if(currUserDeptid=='1' ||currUserDeptid=='4' ||currUserDeptid=='9' || currUserDeptid=='10'){
		setInterval(timingNewQuesion, 20000);
	}
});


//菜单的点击事件
var action_attr = "";
function showMeunContent(action) {
	action_attr = action;
	//$("#bgcenterid").load(action, function(){$.parser.parse();});
	//获取当前的权限限制
	var url = '/role/queryAction.action';
	var params = {"action":action};
	$.ajax({
        url : url,
        data: params,
        cache : false, 
        async : false,
        type : "POST",
        dataType : 'text',
        success : function (rs){
            var qxxz = $.trim(rs);
            //请求到相应的权限功能
			$.post(action,{"qxxz":qxxz},function(result){
				if (!checkStr(result)) {
					return;
				}
				AddRunningDiv();
		    	afterLoadUI("#bgcenterid",result);
				//$("#bgcenterid").html(result);
		    	MoveRunningDiv();
		    	$("#bgrightid").html('');
		  	});
			//收起右侧框
			//$('#bgmainuiid').layout('collapse','east');
		}
	});
}

//展示工作组对应的所有权限
function showActions(groupid,groupNamezn,deptmentid) {
	$.post("/role/queryActionByGroupId.action",{"groupid":groupid,"groupNamezn":groupNamezn,"deptmentid":deptmentid},function(result){
		afterLoadUI("#bgcenterid",result);
  	});
}

//展示所有权限
function queryAllActions (groupid) {
	clickGroup = groupid;
	$.post("/role/queryAllActions.action",{"groupid":groupid},function(result){
    	afterLoadUI("#bgrightid",result);
  	});
	//展开右侧框
	//$('#bgmainuiid').layout('expand','east');
}


//为工作组添加新权限
var clickGroup = -1;
function addNewActionForGroup (acid) {
	if (clickGroup && clickGroup != -1) {
		$.post("/role/addNewActionForGroup.action",{"groupid":clickGroup,"actionid":acid},function(result){
			var rs = $.trim(result);
			if (rs > 0) {
				//刷新群组功能
				showActions(clickGroup);
				queryAllActions(clickGroup);
			}
  		});
	}
}

//为工作组删除权限
function delActionForGroup (groupid,actionid) {
	$.post("/role/delActionForGroup.action",{"groupid":groupid,"actionid":actionid},function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			//刷新群组功能
			showActions(groupid);
			queryAllActions(groupid);
		}
  	});
}

//加载部门数据
function loaddeptData () {
	$.post("/rcworks/loadDept.action",{},function(result){
    	var rs = $.trim(result);
    	if (rs) {
    		var jsondata = eval(rs);
			$("#deptid").combobox('loadData',jsondata);
    	}
  	});
}

//添加新的工作组
function addNewGroups() {
	var imageUrlId = $("#imageUrlId").val();   
	var newGdroupNamezn = $("#newGdroupNameznid").val();
	var deptmentid = $("#deptid").combobox("getValue");
	var params = {"imageUrlId":imageUrlId,"newGdroupNamezn":newGdroupNamezn,"deptmentid":deptmentid};
	$.post("/role/addNewGroups.action",params,function(result){
		var rs = $.trim(result);
		if (rs > 0) {
			//刷新工作组列表
			if(action_attr) {
				showMeunContent(action_attr);
			}
		}
  	});
}

//检查输入的工作组名称是否已经存在
function checkGroupName(val) {
	var vals = document.getElementsByName("groupNameId");
	for (var i = 0 ; i < vals.length ; i++) {
		if (val == vals[i].value) {
			$("#inputNameErrorId").html('工作组已经存在!');
			$("#newGdroupNameznid").val('');
			return false;
		}
	}
}

//删除工作组
function delGroup (id) {
	var cf = confirm("是否确认删除");
   	if (cf) {
   		//先检查群组下是否有成员,有则不能删除
   		var params = {"groupid":id};
   		$.post("/role/checkGroupPer.action",params,function(result){
			var rs = $.trim(result);
			if (rs == 0) {
				$.post("/role/delGroup.action",params,function(result){
					var rss = $.trim(result);
					if (rss > 0) {
						//刷新工作组列表
						if(action_attr) {
							showMeunContent(action_attr);
						}
					}
				});
				
			} else {
				//工作组有用户,不能删除
				alert(rs+"个用户在工作组中,不能删除")
			}
	  	});
   	}
}

//批量显示
function showElems (name) {
	var vals = document.getElementsByName(name);
	for (var i = 0 ; i < vals.length ; i++) {
		var obj = vals[i];
		obj.style.display = "block";
	}
}


//显示
function showElem (id) {
	loaddeptData();
	document.getElementById(id).style.display = "block";
}

//隐藏
function hideElem (id) {
	document.getElementById(id).style.display = "none";
}


//提醒新提交的租用或托管的业务<a href="javascript:void(0)">你有'+rs+'条上架待审核信息</a>
function timingNewQuesion () {
	var param = {};
	var str = '';
	var url = "/technology/timingNewQuesion.action";
	var ies = getOs();
	if (ies == "Firefox") {
			str = '<audio autoplay="autoplay"><source src="/ui/sound/warningtone.wav" type="audio/wav"/><source src="/ui/sound/warningtone.wav" type="audio/mpeg"/></audio>'
		}else{ 
			str = '<embed src="/ui/sound/warningtone.wav" autostart="false" loop="-1" controls="ControlPanel" width="0" height="0" >'
		} 
	$.post(url,param,function(result){
    	var rs = $.trim(result);
    	if(rs>0){
    		$.messager.show({
    			title:'新信息提示',
    			msg:'<a href="javascript:showQuestion()" id="newMessageA">你有'+rs+'条问题等待处理</a>'+str,
    			timeout:5000,
    			showType:'slide'
    		});
    	}
  	});
}

function showQuestion() {
	var params = "";
	url = '/technology/waitdeal.action';
	$.post(url,params,function(result){
		afterLoadUI("#bgcenterid",result);
		MoveRunningDiv();
	});
	
}
