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
    <title>4月份tzidc促销活动</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/CDNpromotions.css?id=691a677"/>
</head>
<body>
        <%@ include file="hear.jsp"%>
    <div class="CDNpromotions-root container-fluid">
        <div class="CDNpromotions-head">
            <img src="images1/cx_banner.png" alt="" />
        </div>
        <img src="images1/cuoxiaotiao.png" class="CDNpromotions-headtip" alt="" />
        <div class="CDNpromotions-body">
            <div class="CDNpromotions-container container">
                <div class="CDNpromotions-product">
                    <h3>产品编号：TZ-100M04</h3>
                    <div class="CDNpromotions-container-infos">
                        <p class="emphasize-info">CPU：<span class="arial">8</span>核<span class="arial">16G</span></p>
                        <p class="emphasize-info">硬盘：<span class="arial">300G SAS</span></p>
                        <p class="emphasize-info">防护：无防</p>
                        <p>价格：<span class="emphasize arial">5999</span><span style="color: #b64535">元</span>/年</p>
                    </div>
                    <a href="javascript:;" onclick="randomqq()" class="CDNpromotions-to">立刻购买</a>
                    <p class="note">备注：可补差价更换固态硬盘</p>
                    <p class="CDNpromotions-tip">应用行业：视频流媒体企业，游戏微端，APP应用，下载站</p>
                </div>
                
            </div>
        </div>
    </div>
    <!-- 底部 -->
		<%@ include file="bottom.jsp"%>
        <!-- 底部 -->
    <script type="text/javascript" src="js/CDNpromotions.js"></script>
</body>
</html>