<%@ page language="java" import="java.util.*,com.ze.web.bean.*,com.ze.common.util.*,com.ze.web.pojo.HotlineList" pageEncoding="utf-8"%>
<link rel="stylesheet" href="../../../tz/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../../tz/css/hear.css">
<link rel="stylesheet" type="text/css" href="../../../tz/css/bottom.css">
<script type="text/javascript" src="../../../tz/js/top.js"></script>
<script type="text/javascript" src="../../../tz/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../../../tz/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../tz/js/bgjs/fdnews.js"></script> <!-- 新闻 -->
<script type="text/javascript" src="../../../tz/js/bgjs/login.js"></script> 
<script type="text/javascript" src="../../../myjs/front/index.js?version=0402"></script><!-- 登录 -->
<script type="text/javascript" src="../../../myjs/myrule.js"></script>
<script type="text/javascript" src="../../../myjs/commonFunction.js"></script>

<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<base href="<%=basePath%>">
<title>百兆服务器|百兆独享—腾正科技</title>
<link rel="stylesheet" href="../../../tz/css/bootstrap.min.css">
<meta name="Keywords"
	content="百兆独享|百兆服务器|百兆独享服务器|电信百兆独享|直播服务器|音视频服务器|app服务器|素材网站|企业服务器|惠州机房 ">
<meta name="description"
	content="百兆独享服务器特惠活动：八核至强CPU+4G内存 +240G SSD硬盘，百兆独享服务器租用仅需699元！！稳定、流畅、快速，适合企业用户 、流媒体用户等">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<style type="text/css">
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
	height: 50px;
}
.navbar-brand{
	float: left;
	height: 50px;
}
.navbar-default{
width:1900px;
height:65px;
margin-top: 0px;
border-top: 0px;
background-color:#202125;

}
.navbar-nav{
background-color:#202125;

}
body {
	margin: 0;
	padding: 0;
	min-width: 1900px;
	font-family: "微软雅黑" !important;

}

a {
	text-decoration: none;
}

.haoli {
	background: url(tz/promotion/20170901/images/chanpcxiao.png) no-repeat;
	position: absolute;
	width: 1194px;
	height: 294px;
	left: 365px;
	top: 565px;
	box-shadow:5px 5px 5px rgba(0,0,0,.4);

}

.haoli-left {
	position: absolute;
	left: 168px;
	top: 198px;
}

.haoli-right {
	position: absolute;
	left: 769px;
	top: 198px;
}
.div-inline {
	float: left;
}

</style>
</head>


<body>
	<div class="navbar navbar-default navbar-fixed-top u-navbar" >
	<div class="container" style="width: 1300px;max-width: none !important;margin: 0 auto;min-width: 1300px;padding-left: 40px;height: 50px;">
		<div class="navbar-header" style="height: 50px;float: left;">
			<a class="navbar-brand" href="http://www.tzidc.com/"> <img alt="" src="tz/images/index/logo.png"></a>

		</div>
		<div class="navbar-collapse collapse" style="height: 50px;float: left;margin: 0 auto;border: 0;">
			<ul class="nav navbar-nav" style="height: 50px;margin: 0 auto;padding-left: 0px;padding-top: 11px;float: left;">
				<li class="li_page"><a href="/" class="hears">首页</a>
				</li>
				<li class="li_page"><a href="tz/proser.jsp" class="hear">服务器租用与托管</a>
					<div id="menuone" class="navi_children" style="">
						<div style="padding-top: 45px;">
							<div class="menu" style="float:left">
								<img alt="" src="tz/images/index/boro.png" width="100%">
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<img alt="" src="tz/images/index/xian2.png">
							</div>
					
							<div style="float:left;margin-left: 30px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 110px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="tz/images/index/product.png">
											</div>
											<div style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">
												<a href="tz/proser.jsp" style="color:#000;text-decoration:none;">产品中心</a>
											</div>
										</div></li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 10px;">
										<a href="tz/zygfzy.jsp" style="color:#000;text-decoration:none;">服务器租用</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px;">
										<a href="tz/zytg.jsp" style="color:#000;text-decoration:none;">服务器托管</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px; ">
										<a href="tz/zyddk.jsp" style="color:#000;text-decoration:none;">机柜大宽带</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px; ">
										<a href="tz/solutions.jsp" style="color:#000;text-decoration:none;">解决方案</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px; ">
										<a href="tz/easy.jsp" style="color:#000;text-decoration:none;">无忧盾</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px; ">
										<a href="tz/anti.jsp" style="color:#000;text-decoration:none;">超高防系列</a>
									</li>
								</ul>
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 110px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="tz/images/index/data.png">
											</div>
											<div style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">
												<a href="tz/dcenter.jsp" style="color:#000;text-decoration:none;">数据中心</a>
											</div>
										</div>
										</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:10px;margin-top: 10px;">
										<a href="tz/dcenter.jsp" style="color:#000;text-decoration:none;">惠州数据中心</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:10px;margin-top: 5px;">
										<a href="tz/dcenter.jsp?dc=hy" style="color:#000;text-decoration:none;">衡阳数据中心</a></li>
								</ul>
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 70px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="tz/images/index/data.png">
											</div>
											<div
												style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">服务</div>
										</div></li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 10px;">
										<a href="tz/record.jsp" style="color:#000;text-decoration:none;">备案</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:15px;margin-top: 5px;">
										<a href="tz/whitelist.jsp" style="color:#000;text-decoration:none;">白名单</a>
									</li>
								</ul>
							</div>
					
						</div>
					</div>
				</li>
				<li class="li_page"><a href="tz/preferential.jsp" class="hear">优惠促销</a>
				</li>
				<li class="li_page"><a href="tz/tzCloud.jsp" class="hear">腾正云</a>
				</li>
				<li class="li_page"><a href="tz/15cdn.jsp" class="hear">安全加速</a>
				</li>
				<li class="li_page"><a href="tz/introduction.jsp" class="hear">关于我们</a>
					<div id="menutwo" class="navi_children" style="">
						<div style="width:100%;margin-top: 45px;">
							<div class="menu" style="float:left">
								<img alt="" src="tz/images/index/about.jpg" width="100%">
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<img alt="" src="tz/images/index/xian2.png">
							</div>
					
							<div style="float:left;margin-left: 30px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 110px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="tz/images/index/tu_01.png">
											</div>
											<div style="float:left;font-size: 18px;font-family: Microsoft YaHei;margin-left:10px; ">
												<a href="tz/introduction.jsp" style="color:#000;text-decoration:none;">公司简介</a>
											</div>
										</div>
									</li>
									<li style="font-size: 15px;font-family: Microsoft YaHei;margin-left:25px;margin-top: 10px;">
										<a href="tz/about.jsp" style="color:#000;text-decoration:none;">公司介绍</a>
									</li>
									<li
										style="font-size: 15px;font-family: Microsoft YaHei;margin-left:25px;margin-top: 5px;">
										<a href="tz/contact.jsp" style="color:#000;text-decoration:none;">联系我们</a>
									</li>
								</ul>
							</div>
					
							<div style="float:left;margin-left: 40px;">
								<ul style="list-style-type: none;padding: 0;">
									<li>
										<div
											style="border-bottom: 2px solid #595758;width: 110px;height: 30px;">
											<div style="float:left;margin-top: 2px;">
												<img alt="" src="tz/images/index/tu_02.png">
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
				<li class="li_page"><a href="tz/paycenter.jsp" class="hear">支付中心</a>
				</li>
			</ul>
			

		</div>


	</div>
	<span class="spinner sk-rotating-plane u-loading"></span>
	<div>
	
	</div>
</div>
	<div style="clear: both;"></div>
	<div>
		<a href="http://www.tzidc.com/tz/proser.jsp"> <img
			src="tz/promotion/20170901/images/banner.png" width="1900px"></img> </a>
	</div>
	<div style="width: 100%;height: 285px">&nbsp;</div>
	<!-- 底部 -->
	<div>
	<div>
		<img src="tz/promotion/20170901/images/dibu_changtu.png" width="1900px"></img>
	</div>

	<div
		style="background: #202125;max-width: none !important;width: 1900px;position: relative;padding-bottom: 480px;padding-top: 30px;">

		<div class="div-inline" style="width: 450px;">&nbsp;</div>
		<div class="div-inline"
			style="text-align: left;color:#FFF;font-size: 18px;font-family: Microsoft YaHei;">
			<ul>
				<li>本次促销产品均为独立服务器，云服务器客户与其他产品线客户不享受此次活动内容。</li>
				<br />
				<li>本次活动产品和价格请参考官网产品列表，享受其他价格优惠的渠道客户不再享受本次活动优惠。</li>
				<br />
				<li>双重好礼一和双重好礼二满足条件的情况下可以同时享受，两个优惠内容均有数量限制，额满即止。</li>
				<br />
				<li>买3送1的优惠内容中赠送的服务器使用权按照所上架服务器中最低配置/最低价格的同类别产品为准。</li>
				<br />
				<li>服务器租用买3送1仅限在促销期间任意连续7天内累计上架租用服务器满3台的客户，即可获得1台租用服务器的免费使用权。
				<br />
				<br />
				例如在9月1日至9月7日内连续上架租用服务器3台，第四台租用服务器免费。以此类推，多买多送。</li>
				<br />
				<li>服务器充值多送1个月只针对促销期间租用/托管的客户一次性支付6个月或以上的客户，所支付的租用/托管服务器使用时间多送一个月。
				<br />
				<br />
				即一次性付款6个月，该服务器的使用时长为7个月；一次性付款12个月，该服务器的使用时长为14个月，以此类推。</li>
				<br />
				<li>促销活动所有内容的最终解释权归腾正科技所有</li>

			</ul>
		</div>


	</div>
</div>
	<!-- 底部 -->
	<!-- 浮动DIV -->
	<div class="haoli">
		<div class="haoli-left">
		<a href="http://www.tzidc.com/tz/zygfzy.jsp"><img src="tz/promotion/20170901/images/anniu.png"></img></a>
		</div>
		<div class="haoli-right">
		<a href="http://www.tzidc.com/tz/zytg.jsp"><img src="tz/promotion/20170901/images/anniu.png"></img></a>
		</div>
	</div>

	<!-- 浮动DIV -->
</body>

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

</html>
