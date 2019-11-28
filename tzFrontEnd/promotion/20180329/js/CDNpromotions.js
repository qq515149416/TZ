var rs = null;
$(function() {
    loadContactsdata();
    $(".CDNpromotions-head").click(function() {
        $("body,html").animate({
            scrollTop: $(".CDNpromotions-body").offset().top
        },500);
    });
    $(".floating_ck").hide();
});

function loadContactsdata(){
    var url1="/fdth/loadcontactsdata.action";
    var params={"site":1};
    $.post(url1,params,function(result){
        rs=JSON.parse($.trim(result));
        var i=0;
        if(rs){
            for(var o in rs){
                //zylx.jsp包含menutemeple.jsp,menutemeple.jsp包含zynavigation.jsp
                //所以此文件函数名和变量的命名不能与zylx.js相同，否则会被覆盖
                var q=rs[o].qq;
                var name=rs[o].contactname;
                var aa=document.createElement("a");
                aa.target="_blank";
                var hrr="http://wpa.qq.com/msgrd?v=3&uin="+q+"&site=qq&menu=yes";
                aa.href=hrr;
                var im=document.createElement("img");
                im.border="0";
                im.alt="给我发消息";
                var sc="http://wpa.qq.com/pa?p=1:"+q+":4"
                im.src=sc;
                aa.appendChild(im);
                var br=document.createElement("br");
                aa.appendChild(document.createTextNode(name));
                document.getElementById('contactsqqid').appendChild(aa);
                i+=1;
                if(i%2==0){
                document.getElementById('contactsqqid').appendChild(br);
                }
            }
        }else{
            var tdd=document.createElement("td");
            var nu=document.createTextNode('暂无联系人数据！');
            tdd.appendChild(nu);
            document.getElementById('contactsqqid').appendChild(tdd);
        }
    });

}

function randomqq(){
    var num = Math.random();
    num = Math.ceil(num *rs.length)-1;
    window.location.href="http://wpa.qq.com/msgrd?v=3&uin="+rs[num].qq+"&site=qq&menu=yes";
}