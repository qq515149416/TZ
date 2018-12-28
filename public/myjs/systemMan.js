//重新加载数据
function loadinfo () {
	alert(1);
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

//修改教育信息
function editschool(value){
	var day = $("input[name="+value+"][id='day']").val();
	var education = $("input[name="+value+"][id='education']").val();
	var professional = $("input[name="+value+"][id='professional']").val();
	var endschool = $("input[name="+value+"][id='endschool']").val();
	var id = value;
	var maid = $(".schoolClass").attr('id');
	var params = {"id":id,"maid":maid,"day":day,"education":education,"professional":professional,"endschool":endschool};  
		$.ajax({
			url :'/role/editschool.action',
			data : params,
			cache : false,
			async : false,
			type : "post",
			dataType : 'json',
			success : function(result) {
				var rs = $.trim(result);
				if (rs > 0) {
				checkImgShow("#schoolMes",-1,'修改成功');
				} else {
				checkImgShow("#schoolMes",-1,'修改失败，请联系管理员');
				}
			}
		});
}

//修改培训信息
function edittrain(value){
	var trainname = $("input[name="+value+"][id='trainname']").val();
	var date = $("input[name="+value+"][id='date']").val();
	var pjname = $("input[name="+value+"][id='pjname']").val();
	var give = $("input[name="+value+"][id='give']").val();
	var id = value;
	var maid = $(".trainClass").attr('id');
	var params = {"id":id,"maid":maid,"trainname":trainname,"date":date,"pjname":pjname,"give":give};  
	$.ajax({
		url :'/role/edittrain.action',
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		success : function(result) {
			var rs = $.trim(result);
			if (rs > 0) {
				checkImgShow("#trainMes",-1,'修改成功');
			} else {
				checkImgShow("#trainMes",-1,'修改失败，请联系管理员');
			}
		}
	});
}

//修改技能信息
function editskill(value){
	var language = $("input[name="+value+"][id='language']").val();
	var skilled = $("input[name="+value+"][id='skilled']").val();
	var kname = $("input[name="+value+"][id='kname']").val();
	var bookname = $("input[name="+value+"][id='bookname']").val();
	var computer = $("input[name="+value+"][id='computer']").val();
	var cname = $("input[name="+value+"][id='cname']").val();
	var givename = $("input[name="+value+"][id='givename']").val();
	var specialty = $("input[name="+value+"][id='specialty']").val();
	var id = value;
	var maid = $(".skillClass").attr('id');
	var params = {"id":id,"maid":maid,"language":language,"skilled":skilled,"kname":kname,"bookname":bookname,"computer":computer,"cname":cname,"givename":givename,"specialty":specialty};  
	$.ajax({
		url :'/role/editskill.action',
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		success : function(result) {
			var rs = $.trim(result);
			if (rs > 0) {
				checkImgShow("#skillMes",-1,'修改成功');
			} else {
				checkImgShow("#skillMes",-1,'修改失败，请联系管理员');
			}
		}
	});
}

//修改工作信息
function editwork(value){
	var jobday = $("input[name="+value+"][id='jobday']").val();
	var workname = $("input[name="+value+"][id='workname']").val();
	var jobname = $("input[name="+value+"][id='jobname']").val();
	var whyout = $("input[name="+value+"][id='whyout']").val();
	var id = value;
	var maid = $(".workClass").attr('id');
	var params = {"id":id,"maid":maid,"jobday":jobday,"workname":workname,"jobname":jobname,"whyout":whyout};  
	$.ajax({
		url :'/role/editwork.action',
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		success : function(result) {
			var rs = $.trim(result);
			if (rs > 0) {
				checkImgShow("#workMes",-1,'修改成功');
			} else {
				checkImgShow("#workMes",-1,'修改失败，请联系管理员');
			}
		}
	});
}

//修改人员信息
function edit(value){
	//基本信息参数
	var maid = value;
	var truename = $("#truename").val();
	if (!truename) {
		checkImgShow("#truenameMes",-1,'*必填');
		return;
	} else{
		checkImgShow("#truenameMes",2);
	}
	var groupnamezn = $("#groupnamezn").val();
	if (!groupnamezn) {
		checkImgShow("#groupnameznMes",-1,'*必填');
		return;
	} else{
		checkImgShow("#groupnameznMes",2);
	}
	var sex = $("#sex").val();
	var mobile = $("#mobile").val();
	if (!mobile) {
		checkImgShow("#mobileMes",-1,'*必填');
		return;
	} else{
		checkImgShow("#mobileMes",2);
	} 
	var email = $("#email").val();
	var createdate = $("#createdate").val();
	var qq = $("#qq").val();
	var worknum = $("#worknum").val();
	var age = $("#age").val();
	var nation = $("#nation").val();
	var face = $("#face").val();
	var birthday = $("#birthday").val();
	var culture = $("#culture").val();
	var title = $("#title").val();
	var workday = $("#workday").val();
	var place = $("#place").val();
	var bookplace = $("#bookplace").val();
	var daplace = $("#daplace").val();
	var marriage = $("#marriage").val();
	var idnum = $("#idnum").val();
	if (!idnum) {
		checkImgShow("#idnumMes",-1,'*必填');
		return;
	} else{
		checkImgShow("#idnumMes",2);
	}if(!isCardNo(idnum)){
		checkImgShow("#idnumMes",-1,'*不正确');
		return;
	}
	var healthy = $("#healthy").val();
	var banknum = $("#banknum").val();
	var placenew = $("#placenew").val();
	var tele = $("#tele").val();
	var fplace = $("#fplace").val();
	var qttele = $("#qttele").val();
	//其他信息参数
	var country = $("#country").val();
	var fname = $("#fname").val();
	var fwork = $("#fwork").val();
	var fpolitics = $("#fpolitics").val();
	var ftele = $("#ftele").val();
	var mname = $("#mname").val();
	var mwork = $("#mwork").val();
	var mpolitics = $("#mpolitics").val();
	var mtele = $("#mtele").val();
	var num = $("#num").val();
	var home = $("#home").val();
	var fire = $("#fire").val();
	var crime = $("#crime").val();
	var find = $("#find").val();
	var jperple = $("#jperple").val();
	var guanxi = $("#guanxi").val();
	var jtele = $("#jtele").val();
	var jplace = $("#jplace").val();
	
	var params = {"maid":maid,"groupnamezn":groupnamezn,"name":name,"truename":truename,"sex":sex,"mobile":mobile,"email":email,"createdate":createdate,"qq":qq,"worknum":worknum,"age":age,"nation":nation,"face":face,"birthday":birthday,"culture":culture,"title":title,"workday":workday,"place":place,"bookplace":bookplace,"daplace":daplace,"marriage":marriage,"idnum":idnum,"healthy":healthy,"banknum":banknum,"placenew":placenew,"tele":tele,"fplace":fplace,"qttele":qttele,"country":country,"fname":fname,"fwork":fwork,"fpolitics":fpolitics,"ftele":ftele,"mname":mname,"mwork":mwork,"mpolitics":mpolitics,"mtele":mtele,"num":num,"home":home,"fire":fire,"crime":crime,"find":find,"jperple":jperple,"guanxi":guanxi,"jtele":jtele,"jplace":jplace};  
	$.ajax({
		url :'/role/edit.action',
		data : params,
		cache : false,
		async : false,
		type : "post",
		dataType : 'json',
		success : function(result) {
			var rs = $.trim(result);
			if (rs > 0) {
				$.messager.show({ // show error message
					title: '提示',
					msg: "修改成功"
				});
				 window.opener.loadinfo();
				
			} else {
				$.messager.show({ // show error message
					title: '提示',
					msg: "修改失败，请联系管理员"
				});
			}
		}
	});
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

//保存
function save(){
		//基本信息参数
		var name = $("#name").val();
		if (!name) {
			checkImgShow("#nameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#nameMes",2);
		}
		var truename = $("#truename").val();
		if (!truename) {
			checkImgShow("#truenameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#truenameMes",2);
		}
		var groupnamezn = $("#groupnamezn").val();
		if (!groupnamezn) {
			checkImgShow("#groupnameznMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#groupnameznMes",2);
		}
		var sex = $("#sex").val();
		var mobile = $("#mobile").val();
		if (!mobile) {
			checkImgShow("#mobileMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#mobileMes",2);
		} 
		var email = $("#email").val();
		var createdate = $("#createdate").val();
		var qq = $("#qq").val();
		var worknum = $("#worknum").val();
		var age = $("#age").val();
		var nation = $("#nation").val();
		var face = $("#face").val();
		var birthday = $("#birthday").val();
		var culture = $("#culture").val();
		var title = $("#title").val();
		var workday = $("#workday").val();
		var place = $("#place").val();
		var bookplace = $("#bookplace").val();
		var daplace = $("#daplace").val();
		var marriage = $("#marriage").val();
		var idnum = $("#idnum").val();
		if (!idnum) {
			checkImgShow("#idnumMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#idnumMes",2);
		}if(!isCardNo(idnum)){
			checkImgShow("#idnumMes",-1,'*不正确');
			return;
		}
		var healthy = $("#healthy").val();
		var banknum = $("#banknum").val();
		var placenew = $("#placenew").val();
		var tele = $("#tele").val();
		var fplace = $("#fplace").val();
		var qttele = $("#qttele").val();
		//教育程度参数
		var day = $("#day").val();
		var education = $("#education").val();
		var professional = $("#professional").val();
		var endschool = $("#endschool").val();
		//技能表参数
		var language = $("#language").val();
		var skilled = $("#skilled").val();
		var kname = $("#kname").val();
		var bookname = $("#bookname").val();
		var computer = $("#computer").val();
		var cname = $("#cname").val();
		var givename = $("#givename").val();
		var specialty = $("#specialty").val();
		//培训经历参数
		var trainname = $("#trainname").val();
		var date = $("#date").val();
		var pjname = $("#pjname").val();
		var give = $("#give").val();
		//工作经历参数
		var jobday = $("#jobday").val();
		var workname = $("#workname").val();
		var jobname = $("#jobname").val();
		var whyout = $("#whyout").val();
		//其他信息参数
		var country = $("#country").val();
		var fname = $("#fname").val();
		var fwork = $("#fwork").val();
		var fpolitics = $("#fpolitics").val();
		var ftele = $("#ftele").val();
		var mname = $("#mname").val();
		var mwork = $("#mwork").val();
		var mpolitics = $("#mpolitics").val();
		var mtele = $("#mtele").val();
		var num = $("#num").val();
		var home = $("#home").val();
		var fire = $("#fire").val();
		var crime = $("#crime").val();
		var find = $("#find").val();
		var jperple = $("#jperple").val();
		var guanxi = $("#guanxi").val();
		var jtele = $("#jtele").val();
		var jplace = $("#jplace").val();

		var params = {"groupnamezn":groupnamezn,"name":name,"truename":truename,"sex":sex,"mobile":mobile,"email":email,"createdate":createdate,"qq":qq,"worknum":worknum,"age":age,"nation":nation,"face":face,"birthday":birthday,"culture":culture,"title":title,"workday":workday,"place":place,"bookplace":bookplace,"daplace":daplace,"marriage":marriage,"idnum":idnum,"healthy":healthy,"banknum":banknum,"placenew":placenew,"tele":tele,"fplace":fplace,"qttele":qttele,"day":day,"education":education,"professional":professional,"endschool":endschool,"language":language,"skilled":skilled,"kname":kname,"bookname":bookname,"computer":computer,"cname":cname,"givename":givename,"specialty":specialty,"trainname":trainname,"date":date,"pjname":pjname,"give":give,"jobday":jobday,"workname":workname,"jobname":jobname,"whyout":whyout,"country":country,"fname":fname,"fwork":fwork,"fpolitics":fpolitics,"ftele":ftele,"mname":mname,"mwork":mwork,"mpolitics":mpolitics,"mtele":mtele,"num":num,"home":home,"fire":fire,"crime":crime,"find":find,"jperple":jperple,"guanxi":guanxi,"jtele":jtele,"jplace":jplace};
		$.ajax({
			url :'/role/addMaster.action',
			data : params,
			cache : false,
			async : false,
			type : "post",
			dataType : 'json',
			success : function(result) {
				var rs = $.trim(result);
				if (rs > 0) {
					$.messager.show({ // show error message
						title: '提示',
						msg: "保存成功"
					});
					 window.opener.loadinfo();
					$("#save").hide();
					$("#addgz").attr('disabled',"true");
					$("#addjy").attr('disabled',"true");
					$("#addpx").attr('disabled',"true");	
					$("#addtc").attr('disabled',"true");	
				} else {
					$.messager.show({ // show error message
						title: '提示',
						msg: "保存失败，请联系管理员"
					});
				}
			}
		});
}		

		
//增加教育程度
function addschool(){
	if(!$("#day").val()){
		checkImgShow("#dayMes",-1,'*必填');
		return;
	} else{
		checkImgShow("#dayMes",2);
	}
	if(!$("#education").val()){
		checkImgShow("#educationMes",-1,'*必填');
		return;
	} else{
		checkImgShow("#educationMes",2);
	} 
	if(!$("#professional").val()){
		checkImgShow("#professionalMes",-1,'*必填');
		return;
	} else{
		checkImgShow("#professionalMes",2);
	} 
	if(!$("#endschool").val()){
		checkImgShow("#endschoolMes",-1,'*必填');
		return;
	} else{
		checkImgShow("#endschoolMes",2);
	}
		//基本信息参数
		var name = $("#name").val();
		if (!name) {
			checkImgShow("#nameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#nameMes",2);
		}
		var truename = $("#truename").val();
		if (!truename) {
			checkImgShow("#truenameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#truenameMes",2);
		}
		var groupnamezn = $("#groupnamezn").val();
		if (!groupnamezn) {
			checkImgShow("#groupnameznMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#groupnameznMes",2);
		}
		var sex = $("#sex").val();
		var mobile = $("#mobile").val();
		if (!mobile) {
			checkImgShow("#mobileMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#mobileMes",2);
		} 
		var email = $("#email").val();
		var createdate = $("#createdate").val();
		var qq = $("#qq").val();
		var worknum = $("#worknum").val();
		var age = $("#age").val();
		var nation = $("#nation").val();
		var face = $("#face").val();
		var birthday = $("#birthday").val();
		var culture = $("#culture").val();
		var title = $("#title").val();
		var workday = $("#workday").val();
		var place = $("#place").val();
		var bookplace = $("#bookplace").val();
		var daplace = $("#daplace").val();
		var marriage = $("#marriage").val();
		var idnum = $("#idnum").val();
		if (!idnum) {
			checkImgShow("#idnumMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#idnumMes",2);
		}if(!isCardNo(idnum)){
			checkImgShow("#idnumMes",-1,'*不正确');
			return;
		}
		var healthy = $("#healthy").val();
		var banknum = $("#banknum").val();
		var placenew = $("#placenew").val();
		var tele = $("#tele").val();
		var fplace = $("#fplace").val();
		var qttele = $("#qttele").val();

		var day = $("#day").val();
		var education = $("#education").val();
		var professional = $("#professional").val();
		var endschool = $("#endschool").val();
		var params = {"groupnamezn":groupnamezn,"name":name,"truename":truename,"sex":sex,"mobile":mobile,"email":email,"createdate":createdate,"qq":qq,"worknum":worknum,"age":age,"nation":nation,"face":face,"birthday":birthday,"culture":culture,"title":title,"workday":workday,"place":place,"bookplace":bookplace,"daplace":daplace,"marriage":marriage,"idnum":idnum,"healthy":healthy,"banknum":banknum,"placenew":placenew,"tele":tele,"fplace":fplace,"qttele":qttele,"day":day,"education":education,"professional":professional,"endschool":endschool};
		$.post('/role/addschool.action',params,function(result){
				
		});
		//把前一个保存数据id清空
		$("#day").attr("id","null");
		$("#education").attr("id","null");
		$("#professional").attr("id","null");
		$("#endschool").attr("id","null");

		var obj = $('<tr><td><input name="day" id="day" value="" type="text" class="inputClass" size="15px"/><span id="dayMes"></span></td><td><input name="education" id="education" value="" type="text" class="inputClass" size="15px"/><span id="educationMes"></span></td><td><input name="professional" id="professional" value="" type="text" class="inputClass" size="15px"/><span id="professionalMes"></span></td><td colspan="2"><input name="endschool" id="endschool" value="" type="text" size="30px" class="inputClass" /><span id="endschoolMes"></span></td></tr>');
		$("#jycd").after(obj);
	
	
}
//增加培训经历
function addtrain(){
		if(!$("#trainname").val()){
			checkImgShow("#trainnameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#trainnameMes",2);
		}
		if(!$("#date").val()){
			checkImgShow("#dateMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#dateMes",2);
		} 
		if(!$("#pjname").val()){
			checkImgShow("#pjnameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#pjnameMes",2);
		} 
		if(!$("#give").val()){
			checkImgShow("#giveMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#giveMes",2);
		}
		//基本信息参数
		var name = $("#name").val();
		if (!name) {
			checkImgShow("#nameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#nameMes",2);
		}
		var truename = $("#truename").val();
		if (!truename) {
			checkImgShow("#truenameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#truenameMes",2);
		}
		var groupnamezn = $("#groupnamezn").val();
		if (!groupnamezn) {
			checkImgShow("#groupnameznMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#groupnameznMes",2);
		}
		var sex = $("#sex").val();
		var mobile = $("#mobile").val();
		if (!mobile) {
			checkImgShow("#mobileMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#mobileMes",2);
		} 
		var email = $("#email").val();
		var createdate = $("#createdate").val();
		var qq = $("#qq").val();
		var worknum = $("#worknum").val();
		var age = $("#age").val();
		var nation = $("#nation").val();
		var face = $("#face").val();
		var birthday = $("#birthday").val();
		var culture = $("#culture").val();
		var title = $("#title").val();
		var workday = $("#workday").val();
		var place = $("#place").val();
		var bookplace = $("#bookplace").val();
		var daplace = $("#daplace").val();
		var marriage = $("#marriage").val();
		var idnum = $("#idnum").val();
		if (!idnum) {
			checkImgShow("#idnumMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#idnumMes",2);
		}if(!isCardNo(idnum)){
			checkImgShow("#idnumMes",-1,'*不正确');
			return;
		}
		var healthy = $("#healthy").val();
		var banknum = $("#banknum").val();
		var placenew = $("#placenew").val();
		var tele = $("#tele").val();
		var fplace = $("#fplace").val();
		var qttele = $("#qttele").val();
		
		var trainname = $("#trainname").val();
		var date = $("#date").val();
		var pjname = $("#pjname").val();
		var give = $("#give").val();
		var params = {"groupnamezn":groupnamezn,"name":name,"truename":truename,"sex":sex,"mobile":mobile,"email":email,"createdate":createdate,"qq":qq,"worknum":worknum,"age":age,"nation":nation,"face":face,"birthday":birthday,"culture":culture,"title":title,"workday":workday,"place":place,"bookplace":bookplace,"daplace":daplace,"marriage":marriage,"idnum":idnum,"healthy":healthy,"banknum":banknum,"placenew":placenew,"tele":tele,"fplace":fplace,"qttele":qttele,"trainname":trainname,"date":date,"pjname":pjname,"give":give};
		$.post('/role/addpxjl.action',params,function(result){
				
		});
		//把前一个保存数据id清空
		$("#trainname").attr("id","null");
		$("#date").attr("id","null");
		$("#pjname").attr("id","null");
		$("#give").attr("id","null");
	var obj = $('<tr><td><input name="trainname" id="trainname" value="" type="text" class="inputClass"size="15px"/><span id="trainnameMes"></span></td><td><input name="date" id="date" value="" type="text" class="inputClass"size="15px"/><span id="dateMes"></span></td><td><input name="pjname" id="pjname" value="" type="text" class="inputClass"size="15px"/><span id="pjnameMes"></span></td><td colspan="2"><input name="give" id="give" value="" type="text" size="30px" class="inputClass"/><span id="giveMes"></span></td></tr>');
	$("#pxjl").after(obj);	
}
	
//增加主要技能和特长
function addskill(){
		if(!$("#language").val()){
			checkImgShow("#languageMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#languageMes",2);
		}
		if(!$("#skilled").val()){
			checkImgShow("#skilledMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#skilledMes",2);
		} 
		if(!$("#kname").val()){
			checkImgShow("#knameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#knameMes",2);
		} 
		if(!$("#bookname").val()){
			checkImgShow("#booknameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#booknameMes",2);
		}
		if(!$("#computer").val()){
			checkImgShow("#computerMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#computerMes",2);
		}
		if(!$("#cname").val()){
			checkImgShow("#cnameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#cnameMes",2);
		} 
		if(!$("#givename").val()){
			checkImgShow("#givenameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#givenameMes",2);
		} 
		if(!$("#specialty").val()){
			checkImgShow("#specialtyMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#specialtyMes",2);
		}
		//基本信息参数
		var name = $("#name").val();
		if (!name) {
			checkImgShow("#nameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#nameMes",2);
		}
		var truename = $("#truename").val();
		if (!truename) {
			checkImgShow("#truenameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#truenameMes",2);
		}
		var groupnamezn = $("#groupnamezn").val();
		if (!groupnamezn) {
			checkImgShow("#groupnameznMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#groupnameznMes",2);
		}
		var sex = $("#sex").val();
		var mobile = $("#mobile").val();
		if (!mobile) {
			checkImgShow("#mobileMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#mobileMes",2);
		} 
		var email = $("#email").val();
		var createdate = $("#createdate").val();
		var qq = $("#qq").val();
		var worknum = $("#worknum").val();
		var age = $("#age").val();
		var nation = $("#nation").val();
		var face = $("#face").val();
		var birthday = $("#birthday").val();
		var culture = $("#culture").val();
		var title = $("#title").val();
		var workday = $("#workday").val();
		var place = $("#place").val();
		var bookplace = $("#bookplace").val();
		var daplace = $("#daplace").val();
		var marriage = $("#marriage").val();
		var idnum = $("#idnum").val();
		if (!idnum) {
			checkImgShow("#idnumMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#idnumMes",2);
		}if(!isCardNo(idnum)){
			checkImgShow("#idnumMes",-1,'*不正确');
			return;
		}
		var healthy = $("#healthy").val();
		var banknum = $("#banknum").val();
		var placenew = $("#placenew").val();
		var tele = $("#tele").val();
		var fplace = $("#fplace").val();
		var qttele = $("#qttele").val();
		
		var language = $("#language").val();
		var skilled = $("#skilled").val();
		var kname = $("#kname").val();
		var bookname = $("#bookname").val();
		var computer = $("#computer").val();
		var cname = $("#cname").val();
		var givename = $("#givename").val();
		var specialty = $("#specialty").val();
		var params = {"groupnamezn":groupnamezn,"name":name,"truename":truename,"sex":sex,"mobile":mobile,"email":email,"createdate":createdate,"qq":qq,"worknum":worknum,"age":age,"nation":nation,"face":face,"birthday":birthday,"culture":culture,"title":title,"workday":workday,"place":place,"bookplace":bookplace,"daplace":daplace,"marriage":marriage,"idnum":idnum,"healthy":healthy,"banknum":banknum,"placenew":placenew,"tele":tele,"fplace":fplace,"qttele":qttele,"language":language,"skilled":skilled,"kname":kname,"bookname":bookname,"computer":computer,"cname":cname,"givename":givename,"specialty":specialty};  
		$.post('/role/addskill.action',params,function(result){
				
		});
		//把前一个保存数据id清空
		$("#language").attr("id","null");
		$("#skilled").attr("id","null");
		$("#kname").attr("id","null");
		$("#bookname").attr("id","null");
		$("#computer").attr("id","null");
		$("#cname").attr("id","null");
		$("#givename").attr("id","null");
		$("#specialty").attr("id","null");
	var obj = $('<tr><td><input name="language" id="language" value="" type="text" class="inputClass" size="15px"/><span id="languageMes"></span></td><td><input name="skilled" id="skilled" value="" type="text" class="inputClass" size="15px"/><span id="skilledMes"></span></td><td><input name="kname" id="kname" value="" type="text" class="inputClass" size="15px"/><span id="knameMes"></span></td><td colspan="2"><input name="bookname" id="bookname" value="" type="text"size="30px" class="inputClass"/><span id="booknameMes"></span></td></tr>');
	$("#jineng").after(obj);
	var objto = $('<tr><td><input name="computer" id="computer" value="" type="text" class="inputClass" size="15px"/><span id="computerMes"></span></td><td><input name="cname" id="cname" value="" type="text" class="inputClass" size="15px"/><span id="cnameMes"></span></td><td><input name="givename" id="givename" value="" type="text" class="inputClass" size="15px"/><span id="givenameMes"></span></td><td colspan="2"><input name="specialty" id="specialty" value="" type="text" size="30px" class="inputClass"/><span id="specialtyMes"></span></td></tr>');
	$("#techang").after(objto);

}
//增加工作经历
function addwork(){
		if(!$("#jobday").val()){
			checkImgShow("#jobdayMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#jobdayMes",2);
		}
		if(!$("#workname").val()){
			checkImgShow("#worknameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#worknameMes",2);
		} 
		if(!$("#jobname").val()){
			checkImgShow("#jobnameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#jobnameMes",2);
		} 
		if(!$("#whyout").val()){
			checkImgShow("#whyoutMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#whyoutMes",2);
		}
		//基本信息参数
		var name = $("#name").val();
		if (!name) {
			checkImgShow("#nameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#nameMes",2);
		}
		var truename = $("#truename").val();
		if (!truename) {
			checkImgShow("#truenameMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#truenameMes",2);
		}
		var groupnamezn = $("#groupnamezn").val();
		if (!groupnamezn) {
			checkImgShow("#groupnameznMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#groupnameznMes",2);
		}
		var sex = $("#sex").val();
		var mobile = $("#mobile").val();
		if (!mobile) {
			checkImgShow("#mobileMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#mobileMes",2);
		} 
		var email = $("#email").val();
		var createdate = $("#createdate").val();
		var qq = $("#qq").val();
		var worknum = $("#worknum").val();
		var age = $("#age").val();
		var nation = $("#nation").val();
		var face = $("#face").val();
		var birthday = $("#birthday").val();
		var culture = $("#culture").val();
		var title = $("#title").val();
		var workday = $("#workday").val();
		var place = $("#place").val();
		var bookplace = $("#bookplace").val();
		var daplace = $("#daplace").val();
		var marriage = $("#marriage").val();
		var idnum = $("#idnum").val();
		if (!idnum) {
			checkImgShow("#idnumMes",-1,'*必填');
			return;
		} else{
			checkImgShow("#idnumMes",2);
		}if(!isCardNo(idnum)){
			checkImgShow("#idnumMes",-1,'*不正确');
			return;
		}
		var healthy = $("#healthy").val();
		var banknum = $("#banknum").val();
		var placenew = $("#placenew").val();
		var tele = $("#tele").val();
		var fplace = $("#fplace").val();
		var qttele = $("#qttele").val();
		
		var jobday = $("#jobday").val();
		var workname = $("#workname").val();
		var jobname = $("#jobname").val();
		var whyout = $("#whyout").val();
		var params = {"groupnamezn":groupnamezn,"name":name,"truename":truename,"sex":sex,"mobile":mobile,"email":email,"createdate":createdate,"qq":qq,"worknum":worknum,"age":age,"nation":nation,"face":face,"birthday":birthday,"culture":culture,"title":title,"workday":workday,"place":place,"bookplace":bookplace,"daplace":daplace,"marriage":marriage,"idnum":idnum,"healthy":healthy,"banknum":banknum,"placenew":placenew,"tele":tele,"fplace":fplace,"qttele":qttele,"jobday":jobday,"workname":workname,"jobname":jobname,"whyout":whyout};
		$.post('/role/addwork.action',params,function(result){
				
		});
		//把前一个保存数据id清空
		$("#jobday").attr("id","null");
		$("#workname").attr("id","null");
		$("#jobname").attr("id","null");
		$("#whyout").attr("id","null");
	var obj = $('<tr><td><input name="jobday" id="jobday" value="" type="text" class="inputClass" size="15px"/><span id="jobdayMes"></span></td><td><input name="workname" id="workname" value="" type="text" class="inputClass" size="15px"/><span id="worknameMes"></span></td><td><input name="jobname" id="jobname" value="" type="text" class="inputClass" size="15px"/><span id="jobnameMes"></span></td><td colspan="2"><input name="whyout" id="whyout" value="" type="text" size="30px" class="inputClass"/><span id="whyoutMes"></span></td></tr>');
	$("#works").after(obj);
}
//验证身份证号
function isCardNo(card){  
   // 身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X  
   var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;  
   if(reg.test(card) === false)  
   {   
       return  false;  
   } else{
	   return true
   }
}  

//正确图标 0表示正确, -1标示错误
function checkImgShow (attr,rs,mes) {
	var htmstr = "";
	 if (rs == 0) {
		htmstr = "";
	} else if (rs == -1) {
		htmstr = "";
		if (mes) {
			htmstr += ("<span style='color:red;font-size:14px;'>" + mes + "</span>");
		}
	} else if (rs == 2) {
		htmstr = "";
	}
	 if ($(attr)) {
		 $(attr).html(htmstr);
	 }
	
}

//验证账号
function verification(){
	var name = $("#name").val();
	var param = {"name":name};
		$.ajax({
			url : '/role/findMasterid.action',
			data : param,
			cache : false,
			async : false,
			type : "post",
			dataType : 'text',
			success : function(result) {
				var rs = $.trim(result);
				if ("true"==rs) {
				$("#save").show();
				$("#addgz").removeAttr("disabled");	
				$("#addjy").removeAttr("disabled");
				$("#addpx").removeAttr("disabled");	
				$("#addtc").removeAttr("disabled");
				} else {
				checkImgShow("#nameMes",-1,'已存在');
				$("#save").hide();
				$("#addgz").attr('disabled',"true");
				$("#addjy").attr('disabled',"true");
				$("#addpx").attr('disabled',"true");	
				$("#addtc").attr('disabled',"true");
			}
		}
	});
}

