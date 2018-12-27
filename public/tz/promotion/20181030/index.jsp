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
    <title>双11腾正高防服务器大促销促销，买一送二</title>
<!-- <meta name="Keywords" content="腾正科技,西安机房,秦式防御"/> -->
<!-- <meta name="Description" content="迎中秋庆国庆，超低价格云主机促销活动" />  -->
<link href="css/index.css" rel="stylesheet" />
</head>
<body style="font-family: '微软雅黑';">
    <%@ include file="hear.jsp"%>
    <div style="height: 124px;">

    </div>
    <div id="banner">
        <a href="javascript:;" onclick="randomqq()">
            <img src="images/Banner.jpg" alt="" />
        </a>
    </div>
    <div id="container">
        <div class="content">
            <div class="product">
                <div class="title">
                    赠送产品：
                </div>
                <div class="content">
                    <div class="item">
                        <span class="product-title">免费体验腾正云独立Ip云主机一台</span>
                        <span class="product-description">《湖南电信 - 企业型》</span>
                        <span class="deadline">有效期一个月</span>
                    </div>
                    <div class="item">
                        <span class="product-title">免费体验15cdn全国云加速5000G流量</span>
                        <span class="product-description">《加速_商务版》</span>
                        <span class="deadline">有效期一个月</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="footer">
                <p class="title">
                    促销须知：
                </p>
                <p class="item-content">
                    1、本次优惠活动只针对指定产品，用户每购买一台高防服务器（200G防御以上）均可以享受赠送体验。
                </p>
                <p class="item-content">
                    2、本次活动优惠新、老客户均可享受。
                </p>
                <p class="item-content">
                    3、本次活动高防产品因各种原因退款不在使用，需要收回免费体验产品。
                </p>
                <p class="item-content">
                    4、促销活动最终解释权归腾正科技所有
                </p>
                <p class="item-content">
                    5、促销时间：2018-11-1到2018-11-11
                </p>
            </div>
        </div>
    </div>
    
    <%@ include file="bottom.jsp"%>
</body>
</html>