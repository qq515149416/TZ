
$(document).ready(function () {
	$("#beginTimeid").datebox("setValue",myDateformatter(new Date()));
});


function saveRentBiz() {
	var str = '提交客户【'+$("#cusbiztruenameid").html()+'】的服务器租用工单，确定？';
	var cusid = $("#cusid").val();
	var currCusOfMaid = $("#currCusOfMaid").val();
	var url = '/customerMan/addCusMacBiz.action?pageSize=3&bizType=rent&cusid='+cusid+"&currCusOfMaid="+currCusOfMaid;
	if (confirm(str)) {
		$('#cusmacbizfm').form('submit',{
			url: url,
			onSubmit: function(){
				//所有验证通过
				return $(this).form('validate');
			},
			success: function(result){
				var rs = $.trim(result);
				if (rs > 0){
					//添加租用
					alert('已成功申请添加租用机器，待客服审核！');
					look(cusid);
				} else {
					alert('主机库信息错误，请联系管理员！');
				}
			}
		});
	}
}

function saveHostingBiz() {
	var str = '提交客户【'+$("#cusbiztruenameid").html()+'】的服务器托管工单，确定？';
	var cusid = $("#cusid").val();
	var currCusOfMaid = $("#currCusOfMaid").val();
	var url = '/customerMan/addCusMacBiz.action?pageSize=3&bizType=hosting&cusid='+cusid+"&currCusOfMaid="+currCusOfMaid;
	if (confirm(str)) {
		$('#cusmacbizfm').form('submit',{
			url: url,
			onSubmit: function(){
				//所有验证通过
				var rsvali = false;
				var vali =  $(this).form('validate');
				var hadMacnum = haderMacnumber();
				var hadDxip = handerDxip();
				var hadUnip = handerUnip();	
				if (vali == true && hadUnip == false && hadDxip == false && hadMacnum == false) {
					rsvali = true;
				}
				return rsvali;
			},
			success: function(result){
				var rs = $.trim(result);
				if (rs > 0){
					//添加租用
					alert('已成功申请添加租用机器，待客服审核！');
					look(cusid);
				} else {
					alert('主机库信息错误，请联系管理员！');
				}
			}
		});
	}
}


function returnJsp () {
	var cusid = $("#cusid").val();
	look(cusid);
}