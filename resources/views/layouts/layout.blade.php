<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>腾正科技-@yield('title')</title>
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <link rel="shortcut icon" href="{{ asset("/favicon.ico") }}" type="image/x-icon" />
    <link rel="icon" sizes="any" mask href="{{ asset("/favicon.svg") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/css/swiper.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/css/animate.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/css/index.css") }}?random_num={{ time() + random_int(100,1000) }}" />
    <link rel="stylesheet" href="{{ asset("/css/layout/index.css") }}?random_num={{ time() + random_int(100,1000) }}" />
    <meta name="keywords" content="@yield('keywords')"/>
    <meta name="description" content="@yield('description')">
</head>
<body>
    <div class="container-fluid main">
    <header class="tz-main-head">
    <nav class="navbar navbar-default tz-navbar-style container">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img src="{{ asset("/images/logo.png") }}" alt="" />
            </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if (!Auth::check())
                    <li><a href="/tz/login.html" class="login">登陆</a></li>
                    <li class="register"><a href="/tz/registered.html" class="registered">注册</a></li>
                @else
                    <li>
                        <a href="/tz/member92019.html" class="member-centre">
                           <span class="glyphicon glyphicon-user user-icon"></span> 个人中心
                        </a>
                    </li>
                @endif
            </ul>
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">首页 <span class="sr-only">(current)</span></a></li>
                <li>
                    <a href="javascript:;">产品服务</a>
                    <div class="dropdown-mark">
                        <span class="dropdown-icon"></span>
                        <dl>
                            <dt>
                                <a href="/protection/index">安全防护</a>
                            </dt>
                            <dd>
                                <a href="/protection/high-defense-cdn">高防CDN</a>
                            </dd>
                            <dd>
                                <a href="/protection/high-defense-ip">DDOS高防IP</a>
                            </dd>
                            <dd>
                                <a href="/protection/c-shield">防C盾</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <a href="/zuyong/index">服务器租用</a>
                            </dt>
                            <dd>
                                <a href="/zuyong/dianxin">电信服务器租用</a>
                            </dd>
                            <dd>
                                <a href="/zuyong/liantong">联通服务器租用</a>
                            </dd>
                            <dd>
                                <a href="/zuyong/shuangxian">双线服务器租用</a>
                            </dd>
                            <dd>
                                <a href="/zuyong/sanxian">三线服务器租用</a>
                            </dd>
                            <!-- <dd>
                                <a href="/zuyong/bgp">BGP服务器租用</a>
                            </dd> -->
                        </dl>
                        <dl style="text-align: center;">
                            <dt>
                                <a href="/tuoguan">服务器托管</a>
                            </dt>
                            <dd>
                                <a href="/tuoguan#hengyang" style="margin-right: -10px;">衡阳服务器托管</a>
                            </dd>
                            <dd>
                                <a href="/tuoguan#huizhou" style="margin-right: -10px;">惠州服务器托管</a>
                            </dd>
                            <dd>
                                <a href="/tuoguan#xian" style="margin-right: -10px;">西安服务器托管</a>
                            </dd>
                        </dl>
                        <dl style="text-align: right;">
                            <dt>
                                <a style="margin-right: 38px;" href="/page/tz/15cdn">CDN</a>
                            </dt>
                            <dd>
                                <a style="margin-right: 24px;" href="/page/tz/15cdn">视频加速</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/15cdn">静态内容加速</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/15cdn">下载分发加速</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/15cdn">动态加速网络</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/15cdn">流媒体点播加速</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/15cdn">流媒体直播加速</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <a href="/page/tz/tzCloud">腾正云</a>
                            </dt>
                            <dd>
                                <a href="/page/tz/tzCloud">惠州云服务器</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/tzCloud">衡阳云服务器</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/tzCloud">西安云服务器</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <a href="/page/tz/zyddk">机柜租用</a>
                            </dt>
                            <dd>
                                <a href="/page/tz/zyddk">惠州机柜租用</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/zyddk">衡阳机柜租用</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/zyddk">西安机柜租用</a>
                            </dd>
                        </dl>
                        <dl style="text-align: center;">
                            <dt>
                                <a href="/page/tz/zyddk" style="margin-left: -14px;">带宽租用</a>
                            </dt>
                            <dd>
                                <a href="/page/tz/zyddk" style="margin-right: 4px;">惠州带宽租用</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/zyddk" style="margin-right: 4px;">衡阳带宽租用</a>
                            </dd>
                            <dd>
                                <a href="/page/tz/zyddk" style="margin-right: 4px;">西安带宽租用</a>
                            </dd>
                        </dl>
                    </div>
                </li>
                <li>
                    <a href="javascript:;">数据中心</a>
                    <div class="dropdown-mark" style="width: auto; height: auto; padding-bottom: 20px; padding-right: 20px; padding-left: 20px; text-align: center;">
                        <span class="dropdown-icon"></span>
                        <ul>
                            <li>
                                <a href="/page/tz/dcenter">惠州数据中心</a>
                            </li>
                            <li>
                                <a href="/page/tz/dcenter">衡阳数据中心</a>
                            </li>
                            <li>
                                <a href="/page/tz/dcenter">西安数据中心</a>
                            </li>
                            <li>
                                <a href="/page/tz/dcenter">嘉兴数据中心</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="javascript:;">解决方案</a>
                    <div class="dropdown-mark" style="width: auto; height: auto; padding-bottom: 20px; padding-right: 20px; padding-left: 20px; text-align: center;">
                        <span class="dropdown-icon"></span>
                        <ul>
                            <li>
                                <a href="/fangan/game">游戏</a>
                            </li>
                            <li>
                                <a href="/fangan/chess">棋牌</a>
                            </li>
                            <li>
                                <a href="/fangan/finance">金融</a>
                            </li>
                            <li>
                                <a href="/fangan/streaming_media">流媒体</a>
                            </li>
                            <li>
                                <a href="/fangan/mobile_app">移动APP</a>
                            </li>
                            <li>
                                <a href="/fangan/education_cloud">教育云</a>
                            </li>
                            <li>
                                <a href="/fangan/government_cloud">政务云</a>
                            </li>
                            <li>
                                <a href="/fangan/website_deployment">网站部署</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a href="/page/tz/preferential">最新活动</a></li>
                <li>
                    <a href="javascript:;">新闻中心</a>
                    <div class="dropdown-mark" style="width: auto; height: auto; padding-bottom: 20px; padding-right: 20px; padding-left: 20px; text-align: center;">
                        <span class="dropdown-icon"></span>
                        <ul>
                            <li>
                                <a href="/article/company">公司新闻</a>
                            </li>
                            <li>
                                <a href="/article/placard">公司公告</a>
                            </li>
                            <li>
                                <a href="/article/industry">行业动态</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="javascript:;">关于我们</a>
                    <div class="dropdown-mark" style="width: auto; height: auto; padding-bottom: 20px; padding-right: 20px; padding-left: 20px; text-align: center;">
                        <span class="dropdown-icon"></span>
                        <ul>
                            <li>
                                <a href="/aboutus/index">公司介绍</a>
                            </li>
                            <li>
                                <a href="/aboutus/rongyu">资质荣誉</a>
                            </li>
                            <li>
                                <a href="/aboutus/wenhua">企业文化</a>
                            </li>
                            <li>
                                <a href="/aboutus/fazhang">发展历程</a>
                            </li>
                            <li>
                                <a href="/aboutus/lianxi">联系我们</a>
                            </li>
                            <li>
                                <a href="/aboutus/pay">支付中心</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
        </nav>

    </header>
        @yield('content')

        <div class="footer row">
        <div class="container">
            <div class="footer-nav clearfix">
                <dl>
                    <dt>产品中心</dt>
                    <dd>
                        <a href="javascript:;">服务器租赁</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">服务器托管 </a>
                    </dd>
                    <dd>
                        <a href="javascript:;">高防服务器</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">高防IP</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">CDN加速</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">网络安全</a>
                    </dd>
                </dl>
                <dl>
                    <dt>增值服务</dt>
                    <dd>
                        <a href="javascript:;">腾正云</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">防C盾</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">15CDN</a>
                    </dd>
                </dl>
                <dl>
                    <dt>支持与服务</dt>
                    <dd>
                        <a href="javascript:;">网站备案</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">白名单审核</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">支付中心</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">帮助中心</a>
                    </dd>
                </dl>
                <dl>
                    <dt>新闻资讯</dt>
                    <dd>
                        <a href="javascript:;">公司新闻</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">公司公告</a>
                    </dd>
                    <dd>
                        <a href="javascript:;">优惠活动</a>
                    </dd>
                </dl>
                <dl class="contact-us">
                    <dt>联系我们</dt>
                    <dd>东莞总公司：广东省东莞市松山湖科技十路研发中心2栋B座</dd>
                    <dd>惠州分公司：广东省惠州市东平南路21号2栋第二层</dd>
                    <dd>陕西分公司：陕西省西安市高新区瑞吉大厦7层10701-7634</dd>
                    <dd>湖南分公司：湖南省长沙市高新开发区麓龙路209号单元402</dd>
                    <dd>上海分公司：上海市金山工业区夏宁路666弄58_59号2064室</dd>
                </dl>
                <dl class="attention wx">
                    <dt>关注我们</dt>
                    <dd>腾正官网二维码</dd>
                    <dd>
                        <img src="{{ asset("/images/logo_erweima.png") }}" alt="" />
                    </dd>
                </dl>
                <dl class="attention weibo">
                    <dt class="text-right">
                        <a href="javascript:;">加入我们</a>
                    </dt>
                    <dd>腾正官网微信二维码</dd>
                    <dd>
                        <img src="{{ asset("/images/wx_erweima.png") }}" alt="" />
                    </dd>
                </dl>
            </div>
            <div class="footer-hot-products">
                <span>热门产品：</span>
                <span>
                    <a href="#">免费套餐</a>
                </span>
                <span>
                    <a href="#">主机租用</a>
                </span>
                <span>
                    <a href="#">云计算</a>
                </span>
                <span>
                    <a href="#">防C盾</a>
                </span>
                <span>
                    <a href="#">高防CC</a>
                </span>
                <span>
                    <a href="#">网络安全</a>
                </span>
                <span>
                    <a href="#">CDN</a>
                </span>
                <span>
                    <a href="#">15CDN加速</a>
                </span>
                <span>
                    <a href="#">云主机</a>
                </span>
            </div>
            <div class="footer-popular-searches">
                <span>热门搜索：</span>
                <span>
                    <a href="#">网站备案</a>
                </span>
                <span>
                    <a href="#">白名单是什么</a>
                </span>
                <span>
                    <a href="#">CDN加速</a>
                </span>
                <span>
                    <a href="#">高防IP</a>
                </span>
                <span>
                    <a href="#">香港服务器</a>
                </span>
                <span>
                    <a href="#">服务器租用</a>
                </span>
                <span>
                    <a href="#">服务器托管</a>
                </span>
                <span>
                    <a href="#">机柜大带宽</a>
                </span>
                <span>
                    <a href="#">云服务器价格</a>
                </span>
            </div>
            <div class="footer-links">
                <span>友情链接：</span>
                <span>
                    <a href="#">IDC快讯</a>
                </span>
                <span>
                    <a href="#">IDC资源发布</a>
                </span>
                <span>
                    <a href="#">腾正云</a>
                </span>
                <span>
                    <a href="#">下载联盟</a>
                </span>
                <span>
                    <a href="#">15CDN</a>
                </span>
                <span>
                    <a href="http://www.ip138.com/idc/">IDC公司</a>
                </span>
            </div>
        </div>
    </div>
    <div class="copyright-information row">
        <div class="container">
            <p class="copyright">Copyright©2019.Company name All rights reserved.广东腾正计算机科技有限公司</p>
            <p class="cert">
                <span>IDC/ISP证：湘B1-20130093 粤B2-20051052</span>
                <span><img src="{{ asset("/images/yuewang.png") }}" alt="" />粤网文〔2016〕1106-216号</span>
                <span><img src="{{ asset("/images/gongan.png") }}" alt="" />粤公网安备44190002000106号</span>
            </p>
            <p class="filing">
                <span>
                    <a href="http://www.miitbeian.gov.cn">粤ICP备15081286号-2</a>
                </span>
                <span>全国IDC证：A2.B1.B2-20150233</span>
            </p>
            <div class="red-shield">
                <a title="企业名称：广东腾正计算机科技有限公司&#10;法定代表人：黄志昌&#10;标识状态：已激活 粤工商备P191809001261" href="http://wljg.gdgs.gov.cn/lz.ashx?vie=41BEF320E537FBF5FB05128371785C72E68E27A4AF820A5D7DDC2E150B907189EF905A25C90D5E0E0799C10B9F2E8A59" target="_blank">
                    <!-- <img style="border: 0px currentColor; border-image: none;" alt="" src="http://wljg.gdgs.gov.cn/images/logo.jpg" /> -->
                </a>
            </div>
        </div>
    </div>

    </div>
    <div class="tz-kefu">
        <div class="tz-kefu-qq tz-kefu-item">
            <span class="tz-kefu-item-btn"></span>
            <div class="tz-kefu-item-info">
                <div class="tz-kefu-dropdown">

                </div>
                <div class="item">
                    <div class="title">
                        售前QQ
                    </div>
                    <div class="content">
                        <ul class="clearfix">
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2885655958&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    成龙
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2853978330&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    禹豪
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2885650826&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    唐康
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506995&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    秋霞
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506994&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    思恩
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506993&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    国东
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2853978331&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    帅东
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2853978334&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    嘉辉
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506997&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    小叶
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506992&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    镜雄
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506990&site=qq&menu=yes">
                                    <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                    小庞
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="item m12">
                    <div class="title">
                        7*24小时技术支持
                    </div>
                    <div class="content">
                        <div class="contact-item">
                            <a href="http://wpa.qq.com/msgrd?v=3&uin=800093515&site=qq&menu=yes">
                                <img alt="给我发消息" src="{{ asset("/images/button_old_41.gif") }}">
                                800093515
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="tel:0769-22385558">
                                <img alt="给我发消息" src="{{ asset("/images/iphone.png") }}">
                                0769-22385558
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="tel:15399941777">
                                <img alt="给我发消息" src="{{ asset("/images/mobile.png") }}">
                                15399941777
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item m12">
                    <div class="title">
                        投诉方式
                    </div>
                    <div class="content">
                        <div class="contact-item">
                            <a href="#">
                                <img alt="给我发消息" src="{{ asset("/images/iphone.png") }}">
                                0769-22385558
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="#">
                                <img alt="给我发消息" src="{{ asset("/images/mobile.png") }}">
                                15399941777
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tz-kefu-wx tz-kefu-item">
            <span class="tz-kefu-item-btn"></span>
            <div class="tz-kefu-item-info">
                <div class="tz-kefu-dropdown">

                </div>
                <img alt="给我发消息" src="{{ asset("/images/kefu_erweima.png") }}">
            </div>
        </div>
        <div class="tz-kefu-beian tz-kefu-item">
            <span class="tz-kefu-item-btn"></span>
        </div>
        <div class="tz-kefu-mobile tz-kefu-item">
            <span class="tz-kefu-item-btn"></span>
            <div class="tz-kefu-item-info">
                <div class="tz-kefu-dropdown">

                </div>
                <div class="item">
                    <div class="title">
                        电话地址
                    </div>
                    <div class="content">
                        <div class="contact-item">
                            <a href="#">
                                <img alt="给我发消息" src="{{ asset("/images/iphone.png") }}">
                                0769-22226555
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="#" class="clearfix">
                                <img class="pull-left" alt="给我发消息" src="{{ asset("/images/position.png") }}">
                                <span style="width: 120px;" class="pull-right">广东省东莞松山湖科技十路2栋B座</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="tz-kefu-top tz-kefu-item">
            <span class="tz-kefu-item-btn"></span>
        </div>
    </div>
    <script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("/js/swiper.min.js") }}"></script>
    <script src="{{ asset("/js/swiper.animate1.0.3.min.js") }}"></script>
    <script src="{{ asset("/js/script.js") }}"></script>
    <script>
        var cnzz_protocol = (("https:" == document.location.protocol) ? "https://" : "http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253197097'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/c.php%3Fid%3D1253197097' type='text/javascript'%3E%3C/script%3E"));
        var rs = [{"site":3,"rank":1,"email":"2885655958@qq.com","contactname":"成龙","contactid":35,"qq":"2885655958","mobile":"13790423606"},{"site":3,"rank":1,"email":"2853978330@qq.com","contactname":"禹豪","contactid":36,"qq":"2853978330","mobile":"15622908447"},{"site":3,"rank":1,"email":"2885650826@qq.com","contactname":"唐康","contactid":38,"qq":"2885650826","mobile":"13712756033"},{"site":3,"rank":1,"email":"2851506995@qq.com","contactname":"彭秋霞","contactid":41,"qq":"2851506995","mobile":"18218649432"},{"site":3,"rank":1,"email":"2851506994@qq.com","contactname":"王思恩","contactid":42,"qq":"2851506994","mobile":"17820147491"},{"site":3,"rank":3,"email":"wgd@tzidc.com","contactname":"国东","contactid":5,"qq":"2851506993","mobile":"18566500885"},{"site":3,"rank":5,"email":"2853978331@qq.com","contactname":"帅东","contactid":33,"qq":"2853978331","mobile":"13922933992"},{"site":3,"rank":6,"email":"yjh@tzidc.com","contactname":"嘉辉","contactid":8,"qq":"2853978334","mobile":"18566153210"},{"site":3,"rank":7,"email":"ye@tzidc.com","contactname":"小叶","contactid":6,"qq":"2851506997","mobile":"18566509950"},{"site":3,"rank":9,"email":"2851506992qq.com","contactname":"镜雄","contactid":10,"qq":"2851506992","mobile":"13592703394"},{"site":1,"rank":22,"email":"2851506990@qq.com","contactname":"小庞","contactid":22,"qq":"2851506990","mobile":"123"}];
        function randomqq(){
            var num = Math.random();
            num = Math.ceil(num *rs.length)-1;
            window.location.href="http://wpa.qq.com/msgrd?v=3&uin="+rs[num].qq+"&site=qq&menu=yes";
        }
    </script>
</body>
</html>
