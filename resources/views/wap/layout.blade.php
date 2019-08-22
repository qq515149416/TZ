<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ request()->path() === "/" ? '腾正科技-' : '' }}@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <link rel="shortcut icon" href="{{ asset("/favicon.ico") }}" type="image/x-icon" />
    <link rel="icon" sizes="any" mask href="{{ asset("/favicon.svg") }}">
    <link rel="stylesheet" href="{{ asset("/css/wap/main.css") }}?random_num={{ time() + random_int(100,1000) }}" />
    <meta name="keywords" content="@yield('keywords')"/>
    <meta name="description" content="@yield('description')">
</head>

<body>
    <div id="tz-menu">
        <div class="main-body">
            <div class="tz-container clear">
                <!-- 腾正二维码 -->
                <div class="qrCode">
                    <img class="closeCode" src="{{ asset("/images/wap/菜单开.png") }}" alt="">
                    <img src="{{ asset("/images/wap/腾正二维码.png") }}" alt="">
                    <div>长按/截图保存，微信识别二维码 或者关注公众号“广东腾正”</div>
                </div>

                <!-- 更多 -->
                <div class="sidebar">
                    <!-- <img src="{{ asset("/images/wap/侧栏.png") }}" alt=""> -->
                    <img class="more-btn" src="{{ asset("/images/wap/更多.png") }}" alt="">
                    <div class="more-content">
                        <ul>
                            <li style="margin-bottom: 10px;">
                                <img src="{{ asset("/images/wap/一键电话.png") }}" alt="">
                                <div>
                                    <div>一键电话</div>
                                    <div style="position: absolute; left: 35px;top: 20px;">0769-22226555</div>
                                </div>
                            </li>
                            <li class="wxCode">
                                <img src="{{ asset("/images/wap/腾正微信.png") }}" alt="">
                                <div>腾正微信</div>
                            </li>
                            <li>
                                <img src="{{ asset("/images/wap/意见反馈.png") }}" alt="">
                                <div>意见反馈</div>
                            </li>
                        </ul>
                    </div>
                    <img class="top-btn" src="{{ asset("/images/wap/置顶.png") }}" alt="">
                </div>

                <!-- 顶部 -->
                <div class="main-header">
                    <div class="tz-main">
                        <div class="nabar-header">
                            <img src="{{ asset("/images/wap/logo.png") }}" alt="">
                        </div>
                        <div class="nabar-right right">
                            <div class="close right">
                                <a href="/">
                                    <img src="{{ asset("/images/wap/菜单.png") }}" alt="">
                                </a>
                            </div>
                            <div class="user right">
                                <a href="/">
                                    <img src="{{ asset("/images/wap/登录与注册.png") }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- 未登录 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/海报.png") }}" alt="">
                    </div>
                    <!-- 产品服务 -->
                    <div class="title">
                        <p>为您提供一站式的产品服务</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="tz-fuwu">
                        <div class="tz-fuwu-box">
                            <div class="fuwu-li">
                                <div class="tz-main fuwu-li-i">
                                    <img src="{{ asset("/images/wap/基础服务（关）.png") }}" alt="">
                                    <p>基础服务</p>
                                    <div class="div-arrow">
                                        <span class="arrow"></span>
                                    </div>
                                </div>
                                <div class="tz-main items-li">
                                    <ul>
                                        <li>
                                            <div class="fuwu-title">服务器租用</div>
                                            <div class="fuwu-txt">提供服务器设备,环境到维护的一站式服务</div>
                                        </li>
                                        <li>
                                            <div class="fuwu-title">服务器托管</div>
                                            <div class="fuwu-txt">有效降低企业维护费用和机房投入</div>
                                        </li>
                                        <li>
                                            <div class="fuwu-title">机柜租用</div>
                                            <div class="fuwu-txt">自主T3+机房，安全可靠的机柜租用服务</div>
                                        </li>
                                        <li style="border: none;">
                                            <div class="fuwu-title">带宽租用</div>
                                            <div class="fuwu-txt">自主T3+机房，高质量G口、万兆大带宽资源接入</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="fuwu-li">
                                <div class="tz-main fuwu-li-i">
                                    <img src="{{ asset("/images/wap/高防基础与应用（关）.png") }}" alt="">
                                    <p>高防基础与应用</p>
                                    <div class="div-arrow">
                                        <span class="arrow"></span>
                                    </div>
                                </div>
                                <div class="tz-main items-li">
                                    <div class="items-gaofang">
                                        <ul>
                                            <li>
                                                <div class="fuwu-title">高防服务器</div>
                                                <div class="fuwu-txt">G口接入,T级流量真实防御,针对高级威胁精准识别、及时响应,抵御DDoS/CC等各种攻击。
                                                </div>
                                            </li>
                                            <li>
                                                <div class="fuwu-title">高防云主机</div>
                                                <div class="fuwu-txt">优质、高效、弹性伸缩、灵活击飞的云计算服务，有效降低IT运营成本,提高资源有效利用率。</div>
                                            </li>
                                            <li>
                                                <div class="fuwu-title">高防IP</div>
                                                <div class="fuwu-txt">10T+防御带宽,T级超强清晰平台,对不同攻击流量自动启用对应的防护策略,有效抵御各种DDoS攻击。
                                                </div>
                                            </li>
                                            <li>
                                                <div class="fuwu-title">高防CDN加速</div>
                                                <div class="fuwu-txt">自建高质节点覆盖全国30多个省份,智能DNS调度算法,加速本地缓存,为网站提供快速、稳定的访问体验。
                                                </div>
                                            </li>
                                            <li style="border: none;">
                                                <div class="fuwu-title">防C盾</div>
                                                <div class="fuwu-txt">腾正自主研发针对CC攻击接入C盾进行防御的攻击防护体系,一键开启DDOSheCC防御,零维护规则。
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="fuwu-li">
                                <div class="tz-main fuwu-li-i">
                                    <img src="{{ asset("/images/wap/专业防御，企业首选（关）.png") }}" alt="">
                                    <p>专业防御，企业首选</p>
                                    <div class="div-arrow">
                                        <span class="arrow"></span>
                                    </div>
                                </div>
                                <div class="tz-main items-li">
                                    <p class="fuwu-item-title">自主研发高级引擎防御系统，为您网络安全保驾护航</p>
                                    <ul>
                                        <li class="fangyu-li">
                                            <div class="fuwu-title">娱乐类 棋牌游戏专业型</div>
                                            <div class="fuwu-txt">为棋牌、游戏行业用户量身定制,交付周期短,助力实现棋牌、游戏的快速扩张发展,省力省钱。</div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="fangyu-li">
                                            <div class="fuwu-title">网站类 金融行业类</div>
                                            <div class="fuwu-txt">专为金融行业定制的防护产品,多线BGP网络接入,网络覆盖全面,包括电信、联通、移动、教育网等。</div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="fangyu-li">
                                            <div class="fuwu-title">网站类 数据应用</div>
                                            <div class="fuwu-txt">专为数据应用型网站加速,信息安全防护、搜索引擎优化防护,在线对话、在线播放等远高出同行的企业。</div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="fangyu-li">
                                            <div class="fuwu-title">网站类 行业门户</div>
                                            <div class="fuwu-txt">高防DDoS防护cc防护云清晰系统,可提供DDoS、DNS、CC攻击综合攻击防护,同事进行网加速。
                                            </div>
                                            <a href="/">查看详情</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <div class="fuwu-li">
                                <div class="tz-main fuwu-li-i">
                                    <img src="{{ asset("/images/wap/解决方案（关）.png") }}" alt="">
                                    <p>解决方案</p>
                                    <div class="div-arrow">
                                        <span class="arrow"></span>
                                    </div>
                                </div>
                                <div class="tz-main items-li">
                                    <p class="fuwu-item-title">根据不同行业特性，提出针对有效的行业综合解决方案助您轻松上云</p>
                                    <ul class="clear">
                                        <li class="solution m">
                                            <div style="width: 100%;">
                                                <img src="{{ asset("/images/wap/棋牌云.png") }}" alt="">
                                            </div>

                                            <div class="fuwu-title">棋牌云解决方案</div>
                                            <div class="fuwu-txt">高防御系统、负载均衡功能、弹性扩展云服务器、数据库I/O分离，轻松应对海量玩家同时在线和平台信息安全
                                            </div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="solution">
                                            <img src="{{ asset("/images/wap/游戏云.png") }}" alt="">
                                            <div class="fuwu-title">游戏云解决方案</div>
                                            <div class="fuwu-txt">自主机房专属服务器集群、负载均衡功能等，解决卡顿、掉线、攻击停服、玩家分析、直播接入困难等常见问题
                                            </div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="solution m">
                                            <img src="{{ asset("/images/wap/金融云.png") }}" alt="">
                                            <div class="fuwu-title">金融云解决方案</div>
                                            <div class="fuwu-txt">银行、P2P、小贷、典当等金融业的防护产品，解决金融行业互联互通、海量访问、数据安全、降低成本等问题
                                            </div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="solution ">
                                            <img src="{{ asset("/images/wap/流媒体.png") }}" alt="">
                                            <div class="fuwu-title">流媒体云解决方案</div>
                                            <div class="fuwu-txt">冗余架构,分布式抗D、高效分发.打造"清晰流畅.低时延.高并发"流媒体服务.应用于游戏.娱乐等流媒体场景
                                            </div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="solution m">
                                            <img src="{{ asset("/images/wap/移动云.png") }}" alt="">
                                            <div class="fuwu-title">移动APP解决方案</div>
                                            <div class="fuwu-txt">腾正移动APP解决方案，旨为开发者提供移动APP基础服务，解决营销困难、高并发、数据安全调度部精准等难题
                                            </div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="solution ">
                                            <img src="{{ asset("/images/wap/教育云.png") }}" alt="">
                                            <div class="fuwu-title">教育云解决方案</div>
                                            <div class="fuwu-txt">以"统一基础架构、统一应用支撑、统一数据标准、统一技术架构"为原则，构建面向多用户的地方教育核心体系
                                            </div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="solution m">
                                            <img src="{{ asset("/images/wap/政务云.png") }}" alt="">
                                            <div class="fuwu-title">政务云解决方案</div>
                                            <div class="fuwu-txt">基于政务系统需求，一站式解决系统利用率低、能源消耗高、各电子政务系统相互隔离、安全性能差等核心问题
                                            </div>
                                            <a href="/">查看详情</a>
                                        </li>
                                        <li class="solution ">
                                            <img src="{{ asset("/images/wap/网站部署.png") }}" alt="">
                                            <div class="fuwu-title">网站部署解决方案</div>
                                            <div class="fuwu-txt">提供从主机选型、环境部署、数据迁移、测试、监控、防御、加速、售后运维等一条龙服务，助用户无忧上云</div>
                                            <a href="/">查看详情</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 地图 -->
                    <div class="map">
                        <img src="{{ asset("/images/wap/地图.png") }}" alt="">
                    </div>
                    <!-- 新闻动态 -->
                    <div class="news">
                        <div class="title">
                            <p>新闻动态</p>
                            <div class="title-hr"></div>
                        </div>
                        <div class="tz-main">
                            <div class="news-item">
                                <img src="{{ asset("/images/wap/新闻img.png") }}" alt="">
                                <div class="news-text">
                                    <div class="news-text-title">
                                        东莞市大岭山女企业家协会莅临我司参访交流
                                    </div>
                                    <div class="news-text-content">
                                        5月29日上午，东莞市大岭山女企业家协会一行10余人莅临广东腾正计算机科技有限公司(以...
                                    </div>
                                    <div class="news-text-btn">
                                        <img src="{{ asset("/images/wap/实心.png") }}" alt="">
                                    </div>
                                    <div class="news-text-time">
                                        2019.05.29
                                    </div>
                                </div>
                            </div>
                            <div class="news-items">
                                <div class="news-text">
                                    <div class="news-text-title">
                                        高防服务器选择什么样的硬盘？
                                    </div>
                                    <div class="news-text-content">
                                        使用高防服务器,我们首先关注的必定是其防御，但有人认为只要防御合适价格合理，其...
                                    </div>
                                    <div class="news-text-btn">
                                        <img src="{{ asset("/images/wap/空心.png") }}" alt="">
                                    </div>
                                    <div class="news-text-time">
                                        2019.05.29
                                    </div>
                                </div>
                                <div class="news-text">
                                    <div class="news-text-title">
                                        东莞市大岭山女企业家协会莅临我司参访交流
                                    </div>
                                    <div class="news-text-content">
                                        美国为什么总与国内名企过不去?实际这事儿得从中美两国的信息强国战略说起,而全面冲突...
                                    </div>
                                    <div class="news-text-btn">
                                        <img src="{{ asset("/images/wap/空心.png") }}" alt="">
                                    </div>
                                    <div class="news-text-time">
                                        2019.05.29
                                    </div>
                                </div>
                            </div>
                            <div class="view-more">
                                查看更多
                            </div>
                        </div>
                    </div>
                    <!-- 底栏 -->
                    <div class="footer">
                        <div class="tz-main">
                            <div class="system-technology-service">
                                <ul>
                                    <li class="footer-items">
                                        <img src="{{ asset("/images/wap/体系.png") }}" alt="">
                                        <p class="f-title">体系</p>
                                        <p class="f-text">完善的体系,为您快速专业的部署实施</p>
                                    </li>
                                    <li class="footer-items">
                                        <img src="{{ asset("/images/wap/技术.png") }}" alt="">
                                        <p class="f-title">技术</p>
                                        <p class="f-text">专业的技术团队,为您解决疑难杂症</p>
                                    </li>
                                    <li class="footer-items">
                                        <img src="{{ asset("/images/wap/服务.png") }}" alt="">
                                        <p class="f-title">服务</p>
                                        <p class="f-text">工程师机房驻点7*24小时技术支持</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="phone-call">
                                <div class="p-text">
                                    <img src="{{ asset("/images/wap/7X24小时服务热线.png") }}" alt="">
                                    <p>7x24小时服务热线: 0769- 22226555</p>
                                </div>
                            </div>
                            <div class="record">
                                <div>总部地址: 广东省东莞市松山湖科技十路研发中心2栋B座</div>
                                <div>
                                    IDC/ISP证：湘B1-20130093 &nbsp;&nbsp;
                                    <img src="{{ asset("/images/wap/yuewang.png") }}" alt="">
                                    粤B2-200</div>
                                <div>
                                    <img src="{{ asset("/images/wap/公安.png") }}" alt="">
                                    全国IDC证：A2.B1.B2-20150233
                                </div>
                                <div>
                                    备案号：粤 15081286-2
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script src="../js/home.js"></script>
<script src="../js/index.js"></script>
