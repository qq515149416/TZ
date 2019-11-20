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
    <title>秦式防御-智慧联动防火墙，腾正科技为您筑起安全防御的万里长城</title>
<meta name="Keywords" content="腾正科技,西安机房,秦式防御"/>
<meta name="Description" content="秦式防御-智慧联动防火墙，腾正科技为您筑起安全防御的万里长城" /> 
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/thai_network_index.css"/>
</head>
<body style="font-family: '微软雅黑';">
    <%@ include file="hear.jsp"%>
    <div style="height: 124px;">

    </div>
    <div id="thai_network_root">
        <header class="root-header">

        </header>
        <section class="root-body">
            <aside class="introduction">
                <h5>腾正科技西安机房最新推出秦式防御服务器</h5>
                <p>会“思考”的防火墙系统，全G口高速带宽，闪电式对抗CC，多层智慧联动防御，支撑网络安全防御突破99.99%的可能。腾正科技西安机房最新推出具有秦式防御功能服务器，清除您的业务最后0.01%的网络安全威胁。</p>
            </aside>
            <div class="recommend">
                <header class="recommend-head">
                    <h3>西安秦式防御服务器推荐</h3>
                </header>
                <article class="recommend-content">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h4 class="product-title">
                                        西安高防产品
                                    </h4>
                                    <section class="config">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-4 config-item">
                                                    <span class="key">CPU</span>
                                                    <span class="value">8核</span>
                                                </div>
                                                <div class="col-xs-4 config-item">
                                                    <span class="key">内存</span>
                                                    <span class="value">8G</span>
                                                </div>
                                                <div class="col-xs-4 config-item">
                                                    <span class="key">硬盘</span>
                                                    <span class="value">300G/1T</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-4 config-item">
                                                    <span class="key">防御</span>
                                                    <span class="value">100G</span>
                                                </div>
                                                <div class="col-xs-4 config-item">
                                                    <span class="key">带宽</span>
                                                    <span class="value">10M</span>
                                                </div>
                                                <div class="col-xs-4 config-item">
                                                    <span class="key">线路</span>
                                                    <span class="value">电信</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </section>
                                </div>
                                <div class="col-xs-6">
                                    <div class="price-block">
                                        <span class="price">888</span><span class="unit">元/月</span>
                                    </div>
                                    <div class="original-price">
                                        <s class="del-decoration">原价：1199元</s>
                                    </div>
                                    <div class="contact-us">
                                        <a href="javascript:;" onclick="randomqq()">点击购买</a>
                                    </div>
                                    <p class="prompt">活动时间：2018.9.15-2018.10.15</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="firewall">
                <header class="firewall-head">
                    <h3>防火墙</h3>
                    <p>智慧联动防火墙更好的保障企业/游戏等应用安全</p>
                </header>
                <article class="firewall-content">
                    <h2>智慧联动防火墙</h2>
                    <p>
                            是会“思考”的智慧联动防火墙，安全防护系统和安全管理终端，在面对威胁能够做到精准发现高级威胁、分析溯源威胁以及一键处置安全威胁。多层次协同联动，联合处置网络攻击，确保网络安全。
                    </p>
                </article>
            </div>
        </section>
    </div>
    <%@ include file="bottom.jsp"%>
</body>
</html>