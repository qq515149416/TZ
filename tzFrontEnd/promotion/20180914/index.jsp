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
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>迎中秋庆国庆，超低价格云主机促销活动</title>
<!-- <meta name="Keywords" content="腾正科技,西安机房,秦式防御"/> -->
<meta name="Description" content="迎中秋庆国庆，超低价格云主机促销活动" /> 
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/index.css" rel="stylesheet" />
</head>
<body style="font-family: '微软雅黑';">
    <%@ include file="hear.jsp"%>
    <div style="height: 124px;">

    </div>
    <div id="root">
        <!-- 头部banner区域 start -->
    <div class="head-banner">
        <img src="images/midAutumn_banner.png" alt="banner"/>
    </div>
    <!-- 头部banner区域 end -->
    <!-- 内容容器 start -->
    <div class="container-fluid content-body">
        <!-- 开通流程 start -->
        <div class="opening-process">
            <div class="title">
                <h4>自助开通流程</h4>
            </div>
            <ul class="clearfix">
                <li>
                    <div class="icon icon1 active"></div>
                    <p class="step">
                        <span data-index="1">STEP</span>
                    </p>
                    <p class="step-content">注册云后台帐号登录</p>
                </li>
                <li>
                    <div class="icon icon2"></div>
                    <p class="step">
                        <span data-index="2">STEP</span>
                    </p>
                    <p class="step-content">通过支付宝充值金额到后台</p>
                </li>
                <li>
                    <div class="icon icon3"></div>
                    <p class="step">
                        <span data-index="3">STEP</span>
                    </p>
                    <p class="step-content">选择产品</p>
                </li>
            </ul>
            <div class="time">
                活动时间:2018.9.12——10.7
            </div>
        </div>
        <!-- 开通流程 end -->
        <!-- 促销产品 start -->
        <div class="product">
            <div class="title">
                <h4>迎中秋庆国庆，超低价格云主机促销活动</h4>
            </div>
            <div class="product-introduction">
                <div class="config">
                    <div class="container-fluid config-table">
                        <div class="row">
                            <div class="col-md-3 col-xs-3">
                                <p class="key">CPU</p>
                                <p class="value">1核</p>
                            </div>
                            <div class="col-md-3 col-xs-3">
                                <p class="key">内存</p>
                                <p class="value">2G</p>
                            </div>
                            <div class="col-md-3 col-xs-3">
                                <p class="key">硬盘</p>
                                <p class="value">100G</p>
                            </div>
                            <div class="col-md-3 col-xs-3">
                                <p class="key">带宽</p>
                                <p class="value">10M</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-xs-3">
                                <p class="key">线路</p>
                                <p class="value">电信单线</p>
                            </div>
                            <div class="col-md-3 col-xs-3">
                                <p class="key">备份集</p>
                                <p class="value">1份快照备份</p>
                            </div>
                            <div class="col-md-3 col-xs-3">
                                <p class="key">防御</p>
                                <p class="value">20G抗DDOS攻击</p>
                            </div>
                            <div class="col-md-3 col-xs-3">
                                <p class="key">IP</p>
                                <p class="value">独立IP</p>
                            </div>
                        </div>
                        <p class="tip">(限定：每个注册用户只能购买两台，续费价格不变。)</p>
                    </div>
                </div>
                <div class="price-info">
                    <div class="price-component">
                        <span class="price">39</span>
                        <span class="unit">元</span>
                    </div>
                    <div class="buy-component">
                        <a href="http://yun.zeisp.com/cloud.html?mobile=true">立即购买</a>
                    </div>
                    <p class="tip">应用场景：适用于访问量较小的个人网站初级阶段，需要固定独立IP应用远程桌面。轻量应用服务、建站、学习、挂机为轻量应用专属定制，简单易用。</p>
                </div>
            </div>
        </div>
        <!-- 促销产品 end -->
        <!-- 售后说明 start -->
        <div class="after-sale">
            <div class="title">
                <h4>售后故障响应</h4>
            </div>
            <div class="content">
                <ul>
                    <li>自助管理：云主机提供Web控制面板，用户可通过控制面板随时重启、重装、升级智云主机，而不需要拨打任何电话或提交工单。</li>
                    <li>专人7X24小时机房驻点人员值班。</li>
                </ul>
            </div>
        </div>
        <!-- 售后说明 end -->
    </div>
    <!-- 内容容器 end -->
    </div>
    
         <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
     <script src="js/jquery.min.js"></script>
     <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
     <script src="js/bootstrap.min.js"></script>
     <script>
         $(function() {
             console.log($(".opening-process .icon"));
             $(".opening-process .icon").mouseover(function() {
                $(".opening-process .icon").removeClass("active");
                 $(this).addClass("active");

             });
         });
     </script>
    <%@ include file="bottom.jsp"%>
</body>
</html>