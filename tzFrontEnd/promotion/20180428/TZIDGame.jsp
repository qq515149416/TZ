<%@ page language="java" import="java.util.*" pageEncoding="utf-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>端游小霸王</title>
    
</head>
<body>
        <%@ include file="hear.jsp"%>
        <div class="root">
                <div class="server-features">
                    <ul class="clearfix">
                        <li onclick="randomqq()">
                            <div class="server-features-icon">
                                <img src="images/tubiao_1_game.png" alt="线路稳定百兆带宽" />
                            </div>
                            <h3>线路稳定百兆带宽</h3>
                            <p>
                                多线路BGP优化，智能路由，100M独享带宽直连骨干网络，端游服务器专线，网络可用性高达99.99%。低延迟，不掉线，稳定高速，保证畅快的游戏效果。
                            </p>
                        </li>
                        <li onclick="randomqq()">
                            <div class="server-features-icon">
                                <img src="images/tubiao_2_game.png" alt="性能优越高效可靠" />
                            </div>
                            <h3>性能优越高效可靠</h3>
                            <p>
                                戴尔，惠普，浪潮等品牌服务器，运算和性能匹配游戏服务器的苛刻要求，配置齐全，多种内存满足不同游戏运营规模需求，客户特殊要求可定制。一键开通，快速部署，达到高质量的游戏运行效果。
                            </p>
                        </li>
                        <li onclick="randomqq()">
                            <div class="server-features-icon">
                                <img src="images/tubiao_3_game.png" alt="秒应服务售后无忧" />
                            </div>
                            <h3>秒应服务售后无忧</h3>
                            <p>
                                经验丰富的24*7*365的端游专线售后服务团队，秒应售后服务，保障了游戏运营的稳定性和用户体验。
                            </p>
                        </li>
                        <li onclick="randomqq()">
                            <div class="server-features-icon">
                                <img src="images/tubiao_4_game.png" alt="线路稳定百兆带宽" />
                            </div>
                            <h3>线路稳定百兆带宽</h3>
                            <p>
                                多线路BGP优化，智能路由，100M独享带宽直连骨干网络，端游服务器专线，网络可用性高达99.99%。低延迟，不掉线，稳定高速，保证畅快的游戏效果。
                            </p>
                        </li>
                        <li onclick="randomqq()">
                            <div class="server-features-icon">
                                <img src="images/tubiao_5_game.png" alt="线路稳定百兆带宽" />
                            </div>
                            <h3>线路稳定百兆带宽</h3>
                            <p>
                                多线路BGP优化，智能路由，100M独享带宽直连骨干网络，端游服务器专线，网络可用性高达99.99%。低延迟，不掉线，稳定高速，保证畅快的游戏效果。
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="server-item">
                    <div class="server-item-head">
                        <h1>爆款端游服务器秒杀</h1>
                        <span>端游小霸王（两城同价）</span>
                    </div>
                    <div class="server-item-body" style="cursor: pointer;">
                        <h3>端游/手游/页游专线服务器</h3>
                        <ul class="clearfix">
                            <li>
                                <h6>CPU</h6>
                                <p>8核16G</p>
                            </li>
                            <li>
                                <h6>硬盘</h6>
                                <p>300G SAS</p>
                                <span>（可补差价更换1T硬盘）</span>
                            </li>
                            <li>
                                <h6>带宽</h6>
                                <p>100M独享</p>
                            </li>
                        </ul>
                        <div class="footer clearfix">
                            <span class="icon"></span>
                            <p class="price">5999<span class="unit">元/年</span></p>
                            <p class="c-btns">
                                <span class="buy" onclick="randomqq()">立即购买</span>
                                <a class="understand" href="http://www.tzidc.com/tz/zygfzy.jsp">了解更多产品</a>
                            </p>
                            
                        </div>
                    </div>
                </div>
                <div class="statement-item">
                    <p class="title">促销须知：</p>
                    <p>1、本次优惠活动只针对指定产品，并且一次性年付的客户才可享受活动优惠价格。</p>
                    <p>2、本次活动优惠新，老客户均可享受，老客户享受该活动优惠时原机器内容及应用必须转移到促销机器上（包括IP等）。</p>
                    <p>3、享受本活动优惠的客户，因任何自身方面的原因而发生的机器到未到期而退机的，不退还任何费用。</p>
                    <p>4、促销活动最终解释权归腾正科技所有</p>
                </div>
                <div class="game-item">
                    <ul class="clearfix">
                        <li onclick="randomqq()" style="cursor: pointer;">
                            <div class="game-item-head">
                                <img src="images/tupian_1_game.png" alt="" />
                            </div>
                            <div class="game-item-title">
                                吃鸡哥
                            </div>
                            <span class="game-item-button">
                                点击我今晚带你吃鸡
                            </span>
                            <p>
                                “无论你是东南亚服还是日韩服，能打得过我就佩服……我对服务器的要求就是不掉线，稳定是前提，玩家玩的好，服务器才是真的好”
                                “腾正科技端游小霸王专线服务器，多线路优化，智能路由，低延迟不掉线，保证用户游戏体验，单机稳定可靠。”
                            </p>
                        </li>
                        <li onclick="randomqq()" style="cursor: pointer;">
                            <div class="game-item-head">
                                <img src="images/tupian_2_game.png" alt="" />
                            </div>
                            <div class="game-item-title">
                                荣耀妹
                            </div>
                            <span class="game-item-button">
                                点击我，助你成为王者
                            </span>
                            <p>
                                “一到节假日服务器就开始罢工，各种瘫痪没有商量，用户都跑了，荣耀不起来啊”<br />
                                “端游小霸王游戏专线，满足大量用户在线并发访问需求，万人同服，轻松在线无障碍，避免用户登录高峰期服务器拥堵的情况。”
                            </p>
                        </li>
                        <li onclick="randomqq()" style="cursor: pointer;">
                            <div class="game-item-head">
                                <img src="images/tupian_3_game.png" alt="" />
                            </div>
                            <div class="game-item-title">
                                勇士团
                            </div>
                            <span class="game-item-button">
                                点击加入我们，为了正义而战
                            </span>
                            <p>
                                “战争中，经常因为玩家太多被恶意竞争受到攻击，服务器崩溃了好几次。”
                                “腾正科技端游小霸王，立体扫库防御，有效抵抗恶意竞争攻击，无视CC和DDoS，为了正义，为了用户都能在安全，公平的环境中畅享游戏的乐趣，端游小霸王，游戏专线服务器为你解决用户流失的烦恼”
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
    <!-- 底部 -->
		<%@ include file="bottom.jsp"%>
        <!-- 底部 -->
    <script>
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
    </script>
</body>
</html>