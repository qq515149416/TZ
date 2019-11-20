<%@ page language="java" import="java.util.*,com.ze.web.bean.*,com.ze.common.util.*,com.ze.web.pojo.HotlineList" pageEncoding="utf-8"%>
<%
Customer c = (Customer)request.getSession().getAttribute(Constants.CUSSERINFO);
%>
<link rel="stylesheet" href="/tz/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/tz/css/hear.css">
<link rel="stylesheet" type="text/css" href="/tz/css/zynavigation.css">
<link rel="stylesheet" href="css/game.css?v=0.0.24"/>
<script type="text/javascript" src="/tz/js/top.js"></script>
<script type="text/javascript" src="/tz/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/tz/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/tz/js/bgjs/fdnews.js"></script> <!-- 新闻 -->
<script type="text/javascript" src="/tz/js/bgjs/zynavigation.js"></script> 
<script type="text/javascript" src="/tz/js/bgjs/login.js"></script> 
<script type="text/javascript" src="/myjs/front/index.js?version=0402"></script><!-- 登录 -->
<script type="text/javascript" src="/myjs/myrule.js"></script>
<script type="text/javascript" src="/myjs/commonFunction.js"></script>

<style>
	.container-fluid {
		padding: 0;
		font-family: "黑体";
	}
<!--
.container {
}

.navbar-collapse.collapse {
	display: block !important;
	height: auto !important;
	overflow: visible !important;
	padding-bottom: 0;
	visibility: visible !important;
}

.li_page {
	float: left;
	height: 65px;
}
.navbar-brand{
	float: left;
	height: 76px;
}
-->
</style>
<div style="background: #595758;height: 45px;color:#FFF;line-height: 45px;font-family: Microsoft YaHei;position: fixed;z-index: 99999;width: 100%">
	<div style="position: fixed;z-index: 999999;height: 45px;width: 1300px;margin:auto;left:0; right:0;padding-left:47px ">
		<div style="float:left">
			<!--<a href="http://www.tengzheng.net/" target="_blank" style="color: #fff;text-decoration: none;">
					<img src="/tz/images/tengzhengLOGO.png"  alt="腾正集团" title="腾正集团" style="margin-top: -7px"/>
					腾正集团
			</a>-->
		</div>
		<div style="float:left;margin-left: 20px;">
			<a href="http://yun.zeisp.com/" target="_blank" style="color: #fff;text-decoration: none;">
					<img src="/tz/images/tzCloudLOGO.png"  alt="腾正云" title="腾正云" style="margin-top: -7px"/>
					腾正云
			</a>
		</div>
		<!-- <div style="float:left;margin-left: 20px;">
			<a href="http://www.15cdn.com/" target="_blank" style="color: #fff;text-decoration: none;" >
				<img src="/tz/images/15CDNlogo.png"  alt="15CDN" title="15CDN" style="margin-top: -7px"/>
				15CDN
			</a>
		</div> -->
		<div style="float:left;margin-left: 20px;">
			<a href="http://www.15cdn.com" target="_blank" style="color: #fff;text-decoration: none;" >
				<img src="/tz/images/fcdunlogo.png"  alt="安全加速" title="安全加速" style="margin-top: -7px;width: 76px;"/>&nbsp;
			</a>
		</div>
		<!-- <div style="float:left;margin-left: 50px;">
			分支机构：
		</div>
		
		<div style="float:left;margin-left: 10px;">
			 东莞
		</div>
		
		<div style="float:left;margin-left: 20px;">
			 惠州
		</div>
		
		<div style="float:left;margin-left: 20px;">
			衡阳
		</div> -->
		<div  style="float:right;">
			<%
		if (null != c) {
			//System.out.println(c);
		%>
			<div style="float: left;">
				欢迎用户:[<%=c.getCusname() %>]登录!
				<span style="padding-left: 20px;"></span>
				<a href="javascript:cusLoginOut()">注销</a>
				<span style="padding-left: 5px;">|</span>
				<a href="javascript:gotosystemMan()" style="margin-left: 5px;margin-right: 5px;">后台管理</a>|
			</div>
		<%		
			} else {
		%>
		<span style="float: left;">账号<input type="text" size="10" id="cusnameid" style="color: black;line-height:normal;"><span id="nameImgId"></span></span>
		<span style="float: left;">密码 <input type="password" size="10" id="cuspasswordid" style="color: black;line-height:normal;"><span id="passImgId"></span></span>
		<span style="float: left;"><a style="color: #fff;" href="javascript:getLoginCode()">获取验证码</a><input type="text" size="5" id="loginCode" style="color: black;line-height:normal;"><span id="codeImgId"></span></span>
		<div style="width: 300px;height: 100px;position: absolute;margin-left: 183px;margin-top: 45px;display: none;" id="codeImgBg"></div>
		<a class="login" href="javascript:cusLogin()">登录<!-- <img src="/images/denglu1.png" /> --></a>
		<%		
			}
		%>
			<!-- <a class="login">
				登录
			</a> -->
			<a class="login">
				注册
			</a>
		</div>
	</div>
</div>

<div class="navbar navbar-default navbar-fixed-top u-navbar">
	<div class="container" style="width: 1300px;max-width: none !important;margin: 0 auto;min-width: 1300px;padding-left: 40px;height: 76px;">
		<div class="navbar-header" style="height: 76px;float: left;">
			<!-- <button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button> -->
			<a class="navbar-brand" href="http://www.tzidc.com/"> <img alt="" src="/tz/images/index/logo.png"></a>

		</div>
		<div class="navbar-collapse collapse" style="height: 76px;float: left;margin: 0 auto;border: 0;">
			<ul class="nav navbar-nav" style="height: 76px;margin: 0 auto;padding-left: 0px;padding-top: 11px;float: left;">
				<li class="li_page"><a href="/" class="hears">首页</a>
				</li>
				<li class="li_page"><a href="/tz/proser.jsp" class="hear">服务器租用与托管</a>
					<div id="menuone" class="navi_children" style="">
						<div style="padding-top: 45px;">
							<div class="menu" style="float:left">
								<img alt="" src="/tz/images/index/boro.png" width="100%">
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<img alt="" src="/tz/images/index/xian2.png">
							</div>
					
							<div style="float:left;margin-left: 30px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 110px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="/tz/images/index/product.png">
											</div>
											<div style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">
												<a href="/tz/proser.jsp" style="color:#000;text-decoration:none;">产品中心</a>
											</div>
										</div></li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 10px;">
										<a href="/tz/zygfzy.jsp" style="color:#000;text-decoration:none;">服务器租用</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px;">
										<a href="/tz/zytg.jsp" style="color:#000;text-decoration:none;">服务器托管</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px; ">
										<a href="/tz/zyddk.jsp" style="color:#000;text-decoration:none;">机柜大宽带</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px; ">
										<a href="/tz/solutions.jsp" style="color:#000;text-decoration:none;">解决方案</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px; ">
										<a href="/tz/easy.jsp" style="color:#000;text-decoration:none;">无忧盾</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px; ">
										<a href="/tz/anti.jsp" style="color:#000;text-decoration:none;">超高防系列</a>
									</li>
								</ul>
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 110px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="/tz/images/index/data.png">
											</div>
											<div style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">
												<a href="/tz/dcenter.jsp" style="color:#000;text-decoration:none;">数据中心</a>
											</div>
										</div>
										</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:10px;margin-top: 10px;">
										<a href="/tz/dcenter.jsp" style="color:#000;text-decoration:none;">惠州数据中心</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:10px;margin-top: 5px;">
										<a href="/tz/dcenter.jsp?dc=hy" style="color:#000;text-decoration:none;">衡阳数据中心</a></li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:10px;margin-top: 5px;">
										<a href="/tz/dcenter.jsp?dc=xian" style="color:#000;text-decoration:none;">西安数据中心</a></li>
								</ul>
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 70px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="/tz/images/index/data.png">
											</div>
											<div
												style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">服务</div>
										</div></li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 10px;">
										<a href="/tz/record.jsp" style="color:#000;text-decoration:none;">备案</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px;">
										<a href="/tz/whitelist.jsp" style="color:#000;text-decoration:none;">白名单</a>
									</li>
								</ul>
							</div>
					
						</div>
					</div>
				</li>
				<!-- <li class="li_page"><a href="/tz/anti.jsp" class="hear">超高防系列</a>
				</li> -->
				<li class="li_page"><a href="/tz/preferential.jsp" class="hear">优惠促销</a>
				</li>
				<li class="li_page"><a href="/tz/tzCloud.jsp" class="hear">腾正云</a>
				</li>
				<li class="li_page"><a href="/tz/15cdn.jsp" class="hear">安全加速</a>
				</li>
				<!-- <li class="li_page"><a href="/tz/fcdun.jsp" class="hear">防C盾</a>
				</li> -->
				<li class="li_page"><a href="/tz/introduction.jsp" class="hear">关于我们</a>
					<div id="menutwo" class="navi_children" style="">
						<div style="width:100%;margin-top: 45px;">
							<div class="menu" style="float:left">
								<img alt="" src="/tz/images/index/about.jpg" width="100%">
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<img alt="" src="/tz/images/index/xian2.png">
							</div>
					
							<div style="float:left;margin-left: 30px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 110px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="/tz/images/index/tu_01.png">
											</div>
											<div style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">
												<a href="/tz/introduction.jsp" style="color:#000;text-decoration:none;">公司简介</a>
											</div>
										</div>
									</li>
									<li style="font-size: 15px;font-family: Microsoft YaHei;margin-left:25px;margin-top: 10px;">
										<a href="/tz/about.jsp" style="color:#000;text-decoration:none;">公司介绍</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:25px;margin-top: 5px;">
										<a href="/tz/contact.jsp" style="color:#000;text-decoration:none;">联系我们</a>
									</li>
								</ul>
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 110px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="/tz/images/index/tu_02.png">
											</div>
											<div
												style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">新闻中心</div>
										</div></li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:25px;margin-top: 10px;">
										<a href="javascript:void(0)" onClick="findsid(2)" style="color:#000;text-decoration:none;">公司新闻</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:25px;margin-top: 5px;">
										<a href="javascript:void(0)"  onClick="findsid(1)" style="color:#000;text-decoration:none;">公司公告</a></li>
<!-- 										<a href="javascript:void(0)"  onClick="findsid(4)" style="color:#000;text-decoration:none;">媒体报道</a></li> -->
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:25px;margin-top: 5px;">
										<a href="javascript:void(0)"  onClick="findsid(3)" style="color:#000;text-decoration:none;">行业新闻</a></li>
								</ul>
							</div>
					
						</div>
					</div>
				</li>
				<li class="li_page"><a href="/tz/paycenter.jsp" class="hear">支付中心</a>
				</li>
				<!-- <li class="li_page"><a target="_blank" href="http://yun.zeisp.com/" class="hear">腾正云</a>
				</li>
				<li class="li_page"><a target="_blank" href="http://www.15cdn.com/" class="hear">15CDN</a>
				</li> -->
					<li style="width: 400px;margin-left:  810px;position: absolute;">
							<div style="margin-top: 5px;">
									<div  class="on" style="float: left;">
										<a style="float: left;">
											<img alt="" src="/tz/images/index/phone.png">
										</a>
										<div class="phone" style="display:none;font-size: 18px;color: #f9c500;float: left;padding-top: 7px;">0769-22226555<!-- <img alt="" src="tz/images/index/dianhua.png"> --></div>
									</div>
									<div class="ons" style="float: left;margin-left: 10px">
										<a style="float: left;">
											<img alt="" src="/tz/images/index/map.png">
										</a>
										<div class="dizhi" style="display:none;font-size: 18px;color: #f9c500;float: left;padding-top: 7px;">广东省东莞松山湖科技十路2栋B座</div>
									</div>
									<div style="float: left;margin-left: 5px">
										<a href="/tz/contact.jsp"><img alt="" src="/tz/images/index/help.png"></a>
									</div>
							</div>
					</li>
			</ul>
			

		</div>


	</div>
	<span class="spinner sk-rotating-plane u-loading"></span>
</div>

	<div class="floating_ck">
	<dl>
        <dd class="consult chi-parent ic1"  id="hideid">
        	<span>在线咨询</span>
				<!-- <i class="ar1"></i> <span class="icons"></span> -->
				<div class="kf-chi">
					<ul>
						<li class='curs'>
							<div class="fir">
								<span class="icon"></span> <span class="txt">售前QQ</span>
							</div>
							<div class="chiqq oneq" id="contactsqqid">
							</div>
						</li>
						<li>
							<div class="shzx-fir">
								<span class="icon"></span> <span class="txt" style="font-size: 18px;color: #fff;padding-top:0px; ">7*24小时技术支持</span>
							</div>
							<div class="shzx oneq" id="contactsqqid">
								<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=800093515&site=qq&menu=yes" id="gfqq_1"> 
										<img border="0" alt="给我发消息" src="http://wpa.qq.com/pa?p=1:800093515:4"> 
										800093515
								</a> 
								<br />
								<a href="javascript:void(0)" id="gfqq_1"> 
										<img border="0" alt="Call me" src="/tz/images/index/shzx-p.png" style="padding-right: 5px;"> 
										0769-22385558
								</a> 
								<br />
								<a href="javascript:void(0)" id="gfqq_1"> 
											<img border="0" alt="call me" src="/tz/images/index/shzx-m.png" style="padding-right: 5px;padding-left: 6px"> 
										15399941777
								</a> 
							 <br />
							</div>
						</li>
						<li>
							<div class="bmd">
								<span style="padding-top:5px;color: #fff;font-size: 23px;">白名单</span>
							</div>
							<div class="shzx oneq" id="contactsqqid">
								<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=800093515&site=qq&menu=yes" id="gfqq_1"> 
										<img border="0" alt="给我发消息" src="http://wpa.qq.com/pa?p=1:800093515:4"> 
										800093515
								</a> 
									 <br /> <br />
							</div>
						</li>	
					</ul>
									<!-- <div class="nullclss">
									</div> -->
				</div>
        </dd>
	        <dd class="jssh">
		        	<span>微信公众号</span>
		        	<div  class="jssh-m ">
							<ul style="width: 233px;overflow: hidden;padding-left: 0px">
								<li>
									<div class="">
										<img alt="weixin" src="/tz/images/index/ss_03.jpg" width="233px;">
									</div>
								</li>
							</ul>
		        	</div>
		</dd>
	        <dd class="words">
	        		<a href="/tz/record.jsp" style="text-decoration: none;font-size: 14px;">
		        			<span>备案中心</span>
			        </a>
	        </dd>
        <dd class="return">
        	<span onClick="gotoTop();">到顶部</span>
        </dd>
    </dl>
</div>



<script>
	$(".on").hover(function(){
			$(".phone").stop(false,true).show(500);
	    },function(){
			$(".phone").stop(false,true).hide(100);
		});
    
    $(".ons").hover(function(){
   			 $(".dizhi").stop(false,true).show(500);
	    },function(){
			$(".dizhi").stop(false,true).hide(100);
	});

	/* $(".li_page1").mousedown(function() {
		$("#menuone").slideToggle();
	});

	$(".about").mousedown(function() {
		$("#menutwo").slideToggle();
	}); */
	
	
	$(".li_page").hover(
		function(){
			$(this).children("a").css("color","#000");
			$(this).children("a").css("background-color","#f5c200");
			$(".navi_children",this).stop(false,true).fadeIn();
		},
		function(){
			$(".navi_children",this).stop(false,true).fadeOut();
			$(this).children("a").css("color","#fff");
			$(this).children("a").css("background","none");
		}
	);
	
</script>


