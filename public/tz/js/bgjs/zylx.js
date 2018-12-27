//加载联系人信息数据，返回JSON数据
$(function(){
	loadContactsData();
});

function loadContactsData(){
	var url="/fdth/loadcontactsdata.action";
	var param={"site":2};
	$.post(url,param,function(result){
		var rt=JSON.parse($.trim(result));				
		if(rt){
			var table=document.createElement("table");
			table.cellspacing="0";
			table.cellpadding="0";
			table.style="width:100%;";
			var tbody=document.createElement("tbody");
			for(var o in rt){
				var tr=document.createElement("tr");
				tbody.appendChild(tr);
				var contactname=rt[o].contactname;
				var td1=document.createElement("td");
				td1.className="textCenter";
				td1.width="20%";
				td1.appendChild(document.createTextNode(contactname));
				tr.appendChild(td1);

				var qq=rt[o].qq;
				var td2=document.createElement("td");
				td2.className="textCenter";
				td2.width="25%";
				var img=document.createElement("img");
				var sr="http://wpa.qq.com/pa?p=1:"+qq+":4";
				img.src=sr;
				img.width="24";
				img.height="16";
				td2.appendChild(img);
				var a=document.createElement("a");
				var hr="tencent://message/?uin="+qq;
				a.href=hr;
				a.appendChild(document.createTextNode(qq));
				td2.appendChild(a);
				tr.appendChild(td2);

				var mobile=rt[o].mobile;
				var td3=document.createElement("td");
				td3.className="textCenter";
				td3.width="25%";
				td3.appendChild(document.createTextNode(mobile));
				tr.appendChild(td3);

				var email=rt[o].email;
				var td4=document.createElement("td");
				td4.className="textCenter";
				td4.width="35%";
				td4.appendChild(document.createTextNode(email));
				tr.appendChild(td4);
			}
			table.appendChild(tbody);
			document.getElementById('contactsdataid').appendChild(table);
		}else{
			var td5=document.createElement("td");			
			var nu=document.createTextNode('暂无联系人数据！');
			td5.appendChild(nu);
			document.getElementById('contactsdataid').appendChild(td5);
		}
	});
}
