<%@ page language="java" import="java.util.*" pageEncoding="utf-8"%>
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
<title>网络要和平，安全伴你行----防C盾邀您体验安全在岗的每一分钟</title>
<link rel="stylesheet" href="/tz/css/bootstrap.min.css">

<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	min-width: 1320px;
}
a{
	text-decoration: none;
}
.prom-bg01{
	background:rgba(0,0,0,0) url("tz/promotion/20170418/images/bg/bg_01.jpg")repeat scroll center center;
	width: auto;
	height: 674px;
	margin: 0 auto;
}
.prom-acts{
	background: rgba(0,0,0,0) url("tz/promotion/20170418/images/bg/bg_02.jpg") repeat scroll center center;
	width: auto;
	height: 760px;
	margin: 0 auto;
	padding-top: 32px;
}
.prom-acts-title{
	width: 165px;
	height: 43px;
	margin: 0 auto;
}
.prom-acts-w{
	width: 1080px;
	height: 540px;
	margin: 0 auto;
	color: #fff;
	padding-top: 205px;
	padding-left: 40px;
}
.prom-acts-w-l{
	float: left;
	width: 580px;
	height: auto;
}
.prom-acts-w-idc{
	width: 570px;
	height: 160px;
	font-size: 20px;
	padding: 30px;
	text-indent:2em;
	line-height: 37px;
	margin-top: 20px;
}
.free-style{
	color: red;
	font-weight: 700;
}
.prom-acts-w-cloudc{
	width: 570px;
	height: 160px;
	font-size: 20px;
	padding: 30px;
	text-indent:2em;
	line-height: 37px;
	padding-top: 110px;
}
.prom-acts-w-r{
	float: left;
	width: 345px;
	height: auto;
	margin-left: 90px;
}
.prom-acts-w-shield-s{
	font-size: 32px;
	margin-left: 5px;
	display: block;
	width: 300px;
	height: 50px;
	margin-top: 5px;
}
.prom-acts-w-shield ul{
	list-style: none;
	font-size: 25px;
	line-height: 50px;
	padding-left: 0px;
}
.acts-w-shield-d{
	width: 350px;
	height: 80px;
}
.acts-w-shield-d-s1{
	width: 70px;
	height: 60px;
	display: block;
	color: #000;
	font-size: 24px;
	float: left;
}
.acts-w-shield-d-s2{
	width: 354px;
	height: 60px;
	color: #333;
	font-size: 20px;
	display: block;
}
.pro-idc-t-bg{
	width: auto;
	height: 727px;
	background: rgba(0,0,0,0) url("tz/promotion/20170418/images/bg/bg_03.jpg")repeat scroll center center;
	padding-top: 50px;
}
.pro-idc-title{
	width: 420px;
	height: 80px;
	margin: 0 auto;
	font-size: 48px;
	color: #F9FF09;
	font-weight: 700;
	padding-left: 33px;
}
.pro-idc-t{
	width: 824px;
	height: 430px;
	margin: 0 auto;
	padding-top: 50px;
}
.pro-idc-b-bg{
	width: auto;
	height: 673px;
	background: rgba(0,0,0,0) url("tz/promotion/20170418/images/bg/bg_04.jpg")repeat scroll center center;
}
.pro-idc-b{
	width: 824px;
	height: 530px;
	margin: 0 auto;
	padding-top: 50px;
}
.pro-idc-con{
	width: 380px;
	height: 460px;
	float: left;
	border: 5px #055093 solid;
	color: #fff;
	background-color: #1B7ED9;
}
.pro-idc-con-title{
	font-size: 25px;
	font-weight: 700;
	width: 110px;
	height: 60px;
	margin: 0 auto;
	padding-top: 14px;
}
.pro-idc-con-conts{
	border-bottom: 1px #fff solid;
	border-top: 1px #fff solid;
	margin: 0 auto;
	font-size: 18px;
	line-height: 40px;
	width: 250px;
	height: 320;
}
.pro-idc-con-conts ul{
	list-style: none;
	padding-left: 0;
	
}
.pro-idc-con-fh{
	color: red;
	font-size: 20px;
	font-weight: 700;
	height: 50px
}
.pro-idc-con-le{
	border-left: 3px #fff solid;
	padding-left: 10px;
}
.pro-idc-con-btn{
	width: 130px;
	height: 35px;
	margin: 0 auto;
	margin-top: 20px;
	border: 1px red solid;
	color: #fff;
	background-color: red;
	padding: 3px 20px 0px 25px;
	font-size: 19px;
	cursor: pointer;
}
.pro-idc-know{
	width: 343px;
	height: 75px;
	margin: 0 auto;
	margin-top: 50px;
	font-size: 33px;
	color: #fff;
	padding-top: 12px;
	padding-left: 35px;
	cursor: pointer;
}
.pro-clo-bg{
	width: auto;
	height: 830px;
	background: rgba(0,0,0,0) url("tz/promotion/20170418/images/bg/bg_05.jpg")repeat scroll center center;
	padding-top: 50px;
}
.pro-clo-title{
	width: 420px;
	height: 80px;
	margin: 0 auto;
	font-size: 43px;
	color: #F9FF09;
	font-weight: 700;
	padding-left: 21px;
}
.pro-clo-con-w{
	width: 824px;
	height: 550px;
	margin: 0 auto;
	padding-top: 50px;
}
.pro-clo-con{
	width: 380px;
	height: 460px;
	float: left;
	border: 5px #055093 solid;
	color: #fff;
	background-color: #1B7ED9;
}
.pro-clo-con-title{
	font-size: 25px;
	font-weight: 700;
	width: 160px;
	height: 60px;
	margin: 0 auto;
	padding-top: 14px;
}
.pro-clo-con-conts{
	border-bottom: 1px #fff solid;
	border-top: 1px #fff solid;
	margin: 0 auto;
	font-size: 18px;
	line-height: 40px;
	width: 250px;
	height: 320;
}
.pro-clo-con-conts ul{
	list-style: none;
	padding-left: 0;
	
}
.pro-clo-con-le{
	border-left: 3px #fff solid;
	padding-left: 10px;
}
.pro-clo-con-btn{
	width: 130px;
	height: 35px;
	margin: 0 auto;
	margin-top: 20px;
	border: 1px red solid;
	color: #fff;
	background-color: red;
	padding: 3px 20px 0px 25px;
	font-size: 19px;
	cursor: pointer;
}
.pro-clo-know{
	width: 343px;
	height: 75px;
	margin: 0 auto;
	margin-top: 50px;
	font-size: 33px;
	color: #fff;
	padding-top: 12px;
	padding-left: 35px;
	cursor: pointer;
}
.purchase-notes-bg{
		width: auto;
		height: 911px;
		background: rgba(0,0,0,0) url("tz/promotion/20170418/images/bg/bg_07.jpg")repeat scroll center center;
		margin: 0 auto;
		padding-top: 65px;
	}
	.purchase-notes-title{
		width: 165px;
		height: 43px;
		margin: 0 auto;
	}
	.purchase-notes-conts{
		width: 1000px;
		height: 390px;
		margin: 0 auto;
		color: #fff;
		margin-top: 160px;
		padding-top: 50px;
		font-size: 20px;
	}
	.purchase-notes-conts-w{
		width: 1000px;
		height: 80px;
	}
	.purchase-notes-conts-l{
		width: 55px;
		height: 55px;
		float: left;
	}
	.purchase-notes-conts-r{
		margin-left: 30px;
		float: left;
		width: 822px;
		height: auto;
		margin-top: 10px;
	}
	.purchase-notes-tu{
		width: 207px;
		height: 183px;
		float: right;
		margin-top: -165px;
	}
</style>
</head>


<body>
	<%@ include file="/tz/hear.jsp" %>
	<div style="clear: both;"></div>
	<div style="height: 40px;"></div>
	
	<!--促销正文  -->
	<div class="prom-bg01"></div>
	
	<div class="prom-acts">
		<div class="prom-acts-title"><img src="tz/promotion/20170418/images/cu_01.png"></div>
		<div class="prom-acts-w">
			<div class="prom-acts-w-l">
				<div class="prom-acts-w-idc">活动期间购买任意IDC类产品（www.tzidc.com）即可<span class="free-style">免费体验</span>网站安全产品-防C盾3个月，赠送时间从赠送日起开始计算。</div>
				<div class="prom-acts-w-cloudc">活动期间购买任意云计算产品(yun.zeisp.com)即可<span class="free-style">免费体验</span>网站安全产品-防C盾3个月，赠送时间从赠送日起开始计算。</div>
			</div>
			<div class="prom-acts-w-r">
				<div class="prom-acts-w-shield">
					<span class="prom-acts-w-shield-s">防C盾体验套餐</span>
					<ul>
						<li>套餐名称：至尊体验版</li>
						<li>防护IP数：10000/小时</li>
						<li>防护峰值：50G</li>
						<li>域名数量：1个</li>
					</ul>
					<div class="acts-w-shield-d">
						<span class="acts-w-shield-d-s1">产品适用</span>
						<span class="acts-w-shield-d-s2">企业网站，论坛，小说站，游戏网站，电子商务平台等。</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- 03 -->
	<div class="pro-idc-t-bg">
		<div class="pro-idc-title">IDC产品热卖推荐</div>
		<div class="pro-idc-t">
			<div class="pro-idc-con">
				<div class="pro-idc-con-title">惠州电信</div>
				<div class="pro-idc-con-conts">
					<ul>
						<li>内存：8G IP数：1个</li>
						<li>CPU：四核8线程 Xeon X5672</li>
						<li>硬盘：240G SSD（固态）</li>
						<li>带宽：G口20M独享</li>
						<li>单机防御：<span class="pro-idc-con-fh">100G</span></li>
						<li><span class="pro-idc-con-le">月付：1600元/月</span></li>
						<li><span class="pro-idc-con-le">年付：17600元/年</span></li>
					</ul>
				</div>
				<div class="pro-idc-con-btn" onclick="randomqq()">立即咨询</div>
			</div>
			
			<div class="pro-idc-con" style="margin-left: 60px">
				<div class="pro-idc-con-title">惠州电信</div>
				<div class="pro-idc-con-conts">
					<ul>
						<li>内存：8G IP数：1个</li>
						<li>CPU：四核8线程 Xeon X5672</li>
						<li>硬盘：240G SSD（固态）</li>
						<li>带宽：G口50M独享</li>
						<li>单机防御：<span class="pro-idc-con-fh">150G</span></li>
						<li><span class="pro-idc-con-le">月付：2200元/月</span></li>
						<li><span class="pro-idc-con-le">年付：24200元/年</span></li>
					</ul>
				</div>
				<div class="pro-idc-con-btn" onclick="randomqq()">立即咨询</div>
			</div>
		</div>
	</div>
	
	<!-- 04 -->
	<div class="pro-idc-b-bg">
		<div class="pro-idc-b">
			<div class="pro-idc-con">
				<div class="pro-idc-con-title">衡阳电信</div>
				<div class="pro-idc-con-conts">
					<ul>
						<li>内存：8G IP数：1个</li>
						<li>CPU：八核16线程 Xeon E5530*2/L5630*2</li>
						<li>硬盘：1T SATA</li>
						<li>带宽：G口20M独享</li>
						<li>单机防御：<span class="pro-idc-con-fh">80G</span></li>
						<li><span class="pro-idc-con-le">月付：1200元/月</span></li>
						<li><span class="pro-idc-con-le">年付：13200元/年</span></li>
					</ul>
				</div>
				<div class="pro-idc-con-btn" onclick="randomqq()">立即咨询</div>
			</div>
			
			<div class="pro-idc-con" style="margin-left: 60px">
				<div class="pro-idc-con-title">衡阳电信</div>
				<div class="pro-idc-con-conts">
					<ul>
						<li>内存：8G IP数：1个</li>
						<li>CPU：八核16线程 Xeon E5530*2/L5630*2</li>
						<li>硬盘：1T SATA</li>
						<li>带宽：G口50M独享</li>
						<li>单机防御：<span class="pro-idc-con-fh">120G</span></li>
						<li><span class="pro-idc-con-le">月付：1800元/月</span></li>
						<li><span class="pro-idc-con-le">年付：19800元/年</span></li>
					</ul>
				</div>
				<div class="pro-idc-con-btn" onclick="randomqq()">立即咨询</div>
			</div>
		</div>
		<a href="/tz/proser.jsp"><div class="pro-idc-know">更多产品请点击了解</div></a>
	</div>
	
	
	<!-- 05 -->
	<div class="pro-clo-bg">
		<div class="pro-clo-title">腾正云热卖套餐推荐</div>
		<div class="pro-clo-con-w">
			<div class="pro-clo-con">
				<div class="pro-clo-con-title">特惠　商企云</div>
				<div class="pro-clo-con-conts">
					<ul>
						<li>8核 8GB</li>
						<li>系统盘（普通存储）30GB</li>
						<li>数据盘（普通存储）200GB</li>
						<li>公网IP 1个</li>
						<li>不限网络模式</li>
						<li>电信 50M 带宽</li>
						<li><span class="pro-clo-con-le">特惠价：699元/月</span></li>
					</ul>
				</div>
				<div class="pro-clo-con-btn" onclick="randomqq()">立即咨询</div>
			</div>
			
			<div class="pro-clo-con" style="margin-left: 60px;">
				<div class="pro-clo-con-title">特惠　媒体云</div>
				<div class="pro-clo-con-conts">
					<ul>
						<li>8核 8GB</li>
						<li>系统盘（普通存储）40GB</li>
						<li>数据盘（不限存储类型）500GB</li>
						<li>公网IP 1个</li>
						<li>不限网络模式</li>
						<li>电信 100M 带宽</li>
						<li><span class="pro-clo-con-le">特惠价：899元/月</span></li>
					</ul>
				</div>
				<div class="pro-clo-con-btn" onclick="randomqq()">立即咨询</div>
			</div>
		</div>
		<a href="http://yun.zeisp.com/"><div class="pro-clo-know">更多产品请点击了解</div></a>
	</div>
	
	<style>
	.pro-shield-bg{
		width: auto;
		height: 638px;
		background: rgba(0,0,0,0) url("tz/promotion/20170418/images/bg/bg_06.jpg")repeat scroll center center;
		padding-top: 58px;
	}
	.pro-shield-title{
		width: 435px;
		height: 80px;
		margin: 0 auto;
		font-size: 28px;
		color: #F9FF09;
		font-weight: 700;
	}
	.pro-shield-w{
		width: 1000px;
		height: 225px;
		margin: 0 auto;
		padding-top: 55px;
		padding-left: 75px;
	}
	.pro-shield-con{
		float: left;
		width: 100px;
		height: 130px;
		margin-left: 150px;
		text-align: center;
	}
	.pro-shield-con-wz{
		margin: 0 auto;
		color: #fff;
		font-size: 18px;
		margin-top: 15px;
	}
	.pro-shield-know{
		width: 343px;
		height: 75px;
		margin: 0 auto;
		margin-top: 50px;
		font-size: 33px;
		color: #fff;
		padding-top: 12px;
		padding-left: 35px;
		cursor: pointer;
	}
	</style>
	<!-- 06 -->
	<div class="pro-shield-bg">
		<div class="pro-shield-title"><img src="tz/promotion/20170418/images/logo.png">专注CC防护，安全更有保障</div>
		<div class="pro-shield-w">
			<div class="pro-shield-con" style="margin-left: 0px;">
				<img src="tz/promotion/20170418/images/tu_01.png">
				<div class="pro-shield-con-wz">硬件防火墙</div>
			</div>
			<div class="pro-shield-con">
				<img src="tz/promotion/20170418/images/tu_02.png">
				<div class="pro-shield-con-wz">近源防护</div>
			</div>
			<div class="pro-shield-con">
				<img src="tz/promotion/20170418/images/tu_03.png">
				<div class="pro-shield-con-wz">万M接入</div>
			</div>
			<div class="pro-shield-con">
				<img src="tz/promotion/20170418/images/tu_04.png">
				<div class="pro-shield-con-wz">集群防护</div>
			</div>
		</div>
		<a href="http://www.fcdun.com/"><div class="pro-shield-know">更多产品请点击了解</div></a>
	</div>
	
	<!-- 07 -->
	<dir class="purchase-notes-bg">
		<div cass="purchase-notes-title" style="width: 185px;height: 43px;margin: 0 auto;">
			<img src="tz/promotion/20170418/images/cu_02.png">
		</div>
		<div class="purchase-notes-conts">
			<div class="purchase-notes-conts-w">
				<div class="purchase-notes-conts-l"><img src="tz/promotion/20170418/images/xh/x_01.png"></div>
				<div class="purchase-notes-conts-r" style="margin-top: 0px;">每台服务器/云主机只赠送一个防护域名，防C盾开始使用之后不能更换其他域名；用户可以随时停止使用防C盾，腾正科技不再补贴其他产品的使用或者费用。</div>
			</div>
			
			<div class="purchase-notes-conts-w">
				<div class="purchase-notes-conts-l"><img src="tz/promotion/20170418/images/xh/x_02.png"></div>
				<div class="purchase-notes-conts-r">购买指定活动产品并付费后，联系您的销售人员进行防C盾产品的开通。</div>
			</div>
			
			<div class="purchase-notes-conts-w">
				<div class="purchase-notes-conts-l"><img src="tz/promotion/20170418/images/xh/x_03.png"></div>
				<div class="purchase-notes-conts-r">3个月防C盾体验期结束后，原用户继续购买防C盾的其他套餐，可以享受9折优惠。</div>
			</div>
			
			<div class="purchase-notes-conts-w">
				<div class="purchase-notes-conts-l"><img src="tz/promotion/20170418/images/xh/x_04.png"></div>
				<div class="purchase-notes-conts-r">以上活动和所有条款最终解释权归腾正科技所有。</div>
			</div>
			<div class="purchase-notes-tu"><img src="tz/promotion/20170418/images/cu_03.png"></div>
		</div>
		
	</dir>
	
	<!--促销正文  -->
	 
	
	<!-- 底部 -->
	<%@ include file="/tz/bottom.jsp" %>
	<!-- 底部 -->
</body>
</html>
