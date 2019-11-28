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
    <title>双11促销活动，衡阳电信机房与惠州电信机房推出物理服务器G口不限速产品</title>
<!-- <meta name="Keywords" content="腾正科技,西安机房,秦式防御"/> -->
<!-- <meta name="Description" content="迎中秋庆国庆，超低价格云主机促销活动" />  -->
<link href="css/index.css" rel="stylesheet" />
</head>
<body style="font-family: '微软雅黑';">
    <%@ include file="hear.jsp"%>
    <div style="height: 124px;">

    </div>
    <div class="main-container">
        <div class="content">
            <div class="item">
                <h2>G口不限速产品</h2>
                <div class="product">
                    <div class="header">
                        网络安全：衡阳机房机器送10G抗DDOS防御，惠州机房机器无防御企业高效带宽
                    </div>
                    <div class="product-content">
                        <ul>
                            <li>
                                <p>CPU</p>
                                <p>8核/16核</p>
                            </li>
                            <li>
                                <p>内存</p>
                                <p>8G/16G</p>
                            </li>
                            <li>
                                <p>硬盘</p>
                                <p>240G SSD/500G SATA/1T SATA</p>
                            </li>
                            <li>
                                <p>线路</p>
                                <p>电信</p>
                            </li>
                            <li>
                                <p>带宽</p>
                                <p>服务器上下行不限速，保底100M按流量峰值计费</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="product-description">为高带宽客户专业定制产品，解决流量突发引起的业务服务卡顿，提高用户体验。</p>
                <div class="buy">
                    <a href="javascript:;" onclick="randomqq()">立即购买</a>
                </div>
            </div>
        </div>
        <div class="footer">
        </div>
    </div>
    
    <%@ include file="bottom.jsp"%>
</body>
</html>