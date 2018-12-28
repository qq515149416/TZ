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
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>高防服务器激情放价</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/defense.css" />
</head>
<body style="font-family: '微软雅黑';">
    <%@ include file="hear.jsp"%>
    <div style="height: 125px;">

    </div>
    <div class="header">
            <img src="images/BG_banner.png" alt="" />
    </div>
    <div class="content">
        <div class="products">
            <div class="product">
                <h3 class="product-head text-center">衡阳促销产品</h3>
                <h4 class="product-description text-center">高性能秒解服务器年度限时特惠</h4>
                <div class="product-component">
                    <div class="pull-left">
                        <p class="product-component-title text-center">衡阳产品</p>
                        <ul class="config clearfix">
                            <li>
                                <p class="attr text-center">CPU</p>
                                <p class="value text-center">16核</p>
                            </li>
                            <li>
                                <p class="attr text-center">内存</p>
                                <p class="value text-center">16G</p>
                            </li>
                            <li>
                                <p class="attr text-center">硬盘</p>
                                <p class="value text-center">1T</p>
                            </li>
                            <li>
                                <p class="attr text-center">防御</p>
                                <p class="value text-center">20G</p>
                            </li>
                            <li>
                                <p class="attr text-center">带宽</p>
                                <p class="value text-center">独享10M</p>
                            </li>
                            <li>
                                <p class="attr text-center">线路</p>
                                <p class="value text-center">电信</p>
                            </li>
                        </ul>
                    </div>
                    <div class="pull-right">
                        <div class="consume">
                            <span class="price">599</span>元/月
                        </div>
                        <p class="text-center original-price">
                            <s>原价：899元</s>
                        </p>
                        <div class="text-center">
                            <button type="button" onclick="randomqq()" class="btn btn-primary buy">立刻购买</button>
                        </div>
                        <p class="activityTime">促销时间：2018.8.15-8.31</p>
                    </div>
                </div>
            </div>

            <div class="product m96 try">
                <h3 class="product-head text-center">西安高防产品特价尝新</h3>
                <h4 class="product-description text-center">真实200G高防找腾正，杠杠滴，帮你扛</h4>
                <div class="product-component">
                    <div class="pull-left">
                        <p class="product-component-title text-center">西安产品</p>
                        <ul class="config clearfix">
                            <li>
                                <p class="attr text-center">CPU</p>
                                <p class="value text-center">8核</p>
                            </li>
                            <li>
                                <p class="attr text-center">内存</p>
                                <p class="value text-center">8G</p>
                            </li>
                            <li>
                                <p class="attr text-center">硬盘</p>
                                <p class="value text-center">300G/1T</p>
                            </li>
                            <li>
                                <p class="attr text-center">防御</p>
                                <p class="value text-center">200G</p>
                            </li>
                            <li>
                                <p class="attr text-center">带宽</p>
                                <p class="value text-center">100M</p>
                            </li>
                            <li>
                                <p class="attr text-center">线路</p>
                                <p class="value text-center">电信</p>
                            </li>
                        </ul>
                    </div>
                    <div class="pull-right">
                        <div class="consume">
                            <span class="price">2099</span>元/月
                        </div>
                        <p class="text-center original-price">
                            <s>原价：2599元</s>
                        </p>
                        <div class="text-center">
                            <button type="button" onclick="randomqq()" class="btn btn-primary buy">立刻购买</button>
                        </div>
                        <p class="activityTime">促销时间：2018.8.20-9.30</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="features text-center">
            <div class="features-title">
                特色功能
            </div>
            <img src="images/gongneng_.png" alt="" />
        </div>
        <div class="superiority">
            <h3 class="text-center">六大优势</h3>
            <h4 class="text-center">新国内顶级骨干机房：优质、稳定、安全</h4>
            <ul class="superiority-list clearfix">
                <li class="text-center">
                    <img class="superiority-item-icon" src="images/6_TB1.png" alt="" />
                    <p class="superiority-item-title">网络资源更优质</p>
                    <p class="superiority-item-description">西安机房具有优质的网络资源，处于“八纵八横”传输干缆，线路稳定，并直连省级互联网骨干网，更有百兆带宽独享，网络稳定畅通，保证游戏视频畅行无阻！</p>
                    <button type="button" onclick="randomqq()" class="btn btn-primary superiority-item-advisory">点击咨询</button>
                </li>
                <li class="text-center">
                    <img class="superiority-item-icon" src="images/6_TB2.png" alt="" />
                    <p class="superiority-item-title">带宽独享更优惠</p>
                    <p class="superiority-item-description">独享的带宽，共享的价格。带宽价格高昂不再是烦恼，用百兆带宽共享的价格即可享受百兆带宽独享的服务！</p>
                    <button type="button" onclick="randomqq()" class="btn btn-primary superiority-item-advisory">点击咨询</button>
                </li>
                <li class="text-center">
                    <img class="superiority-item-icon" src="images/6_TB3.png" alt="" />
                    <p class="superiority-item-title">防御能力更强悍</p>
                    <p class="superiority-item-description">超强西安高防机房，并结合腾正科技480G集群防火墙和完备的网络安全机制部署，有效防DDOS，SYN等多种类型攻击，无视CC，UDP攻击，确保用户业务安全，稳定运行。</p>
                    <button type="button" onclick="randomqq()" class="btn btn-primary superiority-item-advisory">点击咨询</button>
                </li>
                <li class="text-center">
                    <img class="superiority-item-icon" src="images/6_TB4.png" alt="" />
                    <p class="superiority-item-title">资质认可更保障</p>
                    <p class="superiority-item-description">腾正科技获得工信部认可的IDC、ISP、CDN、云计算等接入资质，提供服务正规有保障。</p>
                    <button type="button" onclick="randomqq()" class="btn btn-primary superiority-item-advisory">点击咨询</button>
                </li>
                <li class="text-center">
                    <img class="superiority-item-icon" src="images/6_TB5.png" alt="" />
                    <p class="superiority-item-title">品牌机器更可靠</p>
                    <p class="superiority-item-description">腾正科技采用采用国际品牌服务器，高性能更稳定，实现用户数据的高效处理，保障用户业务稳定运行。</p>
                    <button type="button" onclick="randomqq()" class="btn btn-primary superiority-item-advisory">点击咨询</button>
                </li>
                <li class="text-center">
                    <img class="superiority-item-icon" src="images/6_TB6.png" alt="" />
                    <p class="superiority-item-title">售后服务更安心</p>
                    <p class="superiority-item-description">腾正科技为所有的用户都配备了3个售后 人员组成的专属跟进服务团队，真正做到 7*24小时，全年无休，确保服务请求第一时间得到处理。</p>
                    <button type="button" onclick="randomqq()" class="btn btn-primary superiority-item-advisory">点击咨询</button>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1;
            var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
            if(isiOS||isAndroid) {
                $(".header img").css({
                    "width": "1300px"
                });
                $(".content").css({
                    "width": "1300px"
                });
            }
        });
    </script>
    <%@ include file="bottom.jsp"%>
</body>
</html>