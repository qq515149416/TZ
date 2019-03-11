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
    <title>抢购页面</title>
</head>
<body style="font-family: '微软雅黑';">
    <%@ include file="hear.jsp"%>
    <div class="padding-height">

    </div>
    <div class="banner-head">

    </div>
    <div class="main container">
        <!-- 标签项 -->
        <ul class="nav nav-tabs mys-content-tab" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">个人用户</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">企业用户</a></li>
        </ul>

        <!-- 当前标签内容 -->
        <div class="tab-content mys-content-tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div class="instructions">
                    <h3>活动流程</h3>
                    <p>衡阳机房200M带宽产品特惠抢购，活动期间完成认证的新老用户可以999元的冰点价购买衡阳机房优质百兆产品，数量有限，抢完即止！<a href="http://www.15cdn.com/qg.php">详细规则</a></p>
                </div>
                <div class="product">
                    <!-- <h2>个人产品</h2> -->
                    <ul class="product-list clearfix">
                            <li>
                                <div class="pull-left">
                                        <h2 class="text-center">衡阳机房百兆服务器</h2>
                                        <h3>优质线路，一路放价</h3>
                                        <ul class="config clearfix">
                                            <li>
                                                <p>CPU</p>
                                                <p>8核</p>
                                            </li>
                                            <li>
                                                <p>内存</p>
                                                <p>16G</p>
                                            </li>
                                            <li>
                                                <p>带宽</p>
                                                <p>200M</p>
                                            </li>
                                            <li>
                                                <p>地区</p>
                                                <p>衡阳</p>
                                            </li>
                                        </ul>
                                </div>
                                <div class="pull-right">
                                        <div class="price-info">
                                            <p><span class="price">999.00</span>元/月</p>
                                        </div>
                                        <p class="original-price"><s>原价：3999.00元</s></p>
                                        <div class="buy text-center">
                                            <a href="http://www.15cdn.com/qg.php" target="_blank" class="btn btn-primary">点击进入抢购页</a>
                                        </div>
                                </div>
                                    
                                </li>

                    </ul>
                </div>
            </div>
  </div>
    </div>
    <script type="text/javascript" src="resources/index_ddac0a5e9ed5335c1ca3_bundle.js"></script>
<%@ include file="bottom.jsp"%>
</body>
</html>