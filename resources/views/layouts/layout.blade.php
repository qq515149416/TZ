<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ request()->path() === "/" ? '腾正科技-' : '' }}@yield('title')</title>
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

    <script>
        !function(g,d,t,e,v,n,s){if(g.gdt)return;v=g.gdt=function(){v.tk?v.tk.apply(v,arguments):v.queue.push(arguments)};v.sv='1.0';v.bt=0;v.queue=[];n=d.createElement(t);n.async=!0;n.src=e;s=d.getElementsByTagName(t)[0];s.parentNode.insertBefore(n,s);}(window,document,'script','//qzonestyle.gtimg.cn/qzone/biz/gdt/dmp/user-action/gdtevent.min.js');
        gdt('init','1109261076');
        gdt('track','PAGE_VIEW');
    </script>
    <noscript>
        < img height="1" width="1" style="display:none" src="https://a.gdt.qq.com/pixel?user_action_set_id=1109261076&action_type=PAGE_VIEW&noscript=1"/>
    </noscript>

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
            <a class="navbar-brand" href="/">
                <img src="{{ asset("/images/logo.png") }}" alt="腾正科技" />
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
                <!-- <li class="active"><a href="/">首页 <span class="sr-only">(current)</span></a></li> -->
                <li><a href="/activity">最新活动</a></li>
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
                                <a href="/dist/highDefense.html">DDOS高防IP</a>
                            </dd>
                            <dd>
                                <a href="/protection/c-shield">防C盾</a>
                            </dd>
                            <dd>
                                <a href="/zuyong/gaofang">高防服务器</a>
                            </dd>
                            <dd>
                                <a href="/overlayPackage">叠加包</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <a href="/zuyong/index">服务器租用</a>
                            </dt>
                            <dd>
                                <a href="/zuyong/dianxin/hunan">电信服务器租用</a>
                            </dd>
                            <dd>
                                <a href="/zuyong/liantong/hunan">联通服务器租用</a>
                            </dd>
                            <dd>
                                <a href="/zuyong/shuangxian/hunan">双线服务器租用</a>
                            </dd>
                            <dd>
                                <a href="/zuyong/sanxian/hunan">三线服务器租用</a>
                            </dd>
                            <dd>
                                <a href="/zuyong/HKT">港台服务器租用</a>
                            </dd>
                        </dl>
                        <dl style="text-align: center;">
                            <dt>
                                <a href="/tuoguan/hengyang">服务器托管</a>
                            </dt>
                            <dd>
                                <a href="/tuoguan/hengyang" style="margin-right: -10px;">衡阳服务器托管</a>
                            </dd>
                            <dd>
                                <a href="/tuoguan/huizhou" style="margin-right: -10px;">惠州服务器托管</a>
                            </dd>
                            <dd>
                                <a href="/tuoguan/xian" style="margin-right: -10px;">西安服务器托管</a>
                            </dd>
                        </dl>
                        <dl style="text-align: left;text-indent: 31px;">
                            <dt>
                                <a style="margin-right: 38px;" href="/15cdn/index">CDN</a>
                            </dt>
                            <!-- <dd>
                                <a style="margin-right: 24px;" href="/cdn/tz/15cdn">视频加速</a>
                            </dd> -->
                            <dd>
                                <a href="/15cdn/sca">静态内容加速</a>
                            </dd>
                            <dd>
                                <a href="/15cdn/dda">下载分发加速</a>
                            </dd>
                            <dd>
                                <a href="/15cdn/dsa">动态加速网络</a>
                            </dd>
                            <dd>
                                <a href="/15cdn/smvoda">流媒体点播加速</a>
                            </dd>
                            <dd>
                                <a href="/15cdn/smlba">流媒体直播加速</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <a href="javascript:;">腾正云</a>
                            </dt>
                            <dd>
                                <a href="/yun/huizhou">惠州云服务器</a>
                            </dd>
                            <dd>
                                <a href="/yun/hengyang">衡阳云服务器</a>
                            </dd>
                            <dd>
                                <a href="/yun/xian">西安云服务器</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <a href="javascript: void(0);">机柜租用</a>
                            </dt>
                            <dd>
                                <a href="/cabinet-rent/huizhou">惠州机柜租用</a>
                            </dd>
                            <dd>
                                <a href="/cabinet-rent/hengyang">衡阳机柜租用</a>
                            </dd>
                            <dd>
                                <a href="/cabinet-rent/xian">西安机柜租用</a>
                            </dd>
                        </dl>
                        <dl style="text-align: center;">
                            <dt>
                                <a href="javascript: void(0);" style="margin-left: -14px;">带宽租用</a>
                            </dt>
                            <dd>
                                <a href="/bandwidth-rent/huizhou" style="margin-right: 4px;">惠州带宽租用</a>
                            </dd>
                            <dd>
                                <a href="/bandwidth-rent/hengyang" style="margin-right: 4px;">衡阳带宽租用</a>
                            </dd>
                            <dd>
                                <a href="/bandwidth-rent/xian" style="margin-right: 4px;">西安带宽租用</a>
                            </dd>
                        </dl>
                        <dl style="text-align: left;text-indent: 31px;">
                            <dt>
                                <a href="/overseas" style="margin-left: 0;">海外服务器</a>
                            </dt>
                            <dd>
                                <a href="/overseas/asia">亚洲服务器</a>
                            </dd>
                            <dd>
                                <a href="/overseas/america">美洲服务器</a>
                            </dd>
                        </dl>
                    </div>
                </li>
                <li>
                    <a href="javascript: void(0);">解决方案</a>
                    <div class="dropdown-mark" style="width: auto; height: auto; padding-bottom: 20px; padding-right: 20px; padding-left: 20px; text-align: center;">
                        <span class="dropdown-icon"></span>
                        <ul>
                            <li>
                                <a href="/solution/game">游戏</a>
                            </li>
                            <li>
                                <a href="/solution/chess">棋牌</a>
                            </li>
                            <li>
                                <a href="/solution/finance">金融</a>
                            </li>
                            <li>
                                <a href="/solution/streaming_media">流媒体</a>
                            </li>
                            <li>
                                <a href="/solution/mobile_app">移动APP</a>
                            </li>
                            <li>
                                <a href="/solution/education_cloud">教育云</a>
                            </li>
                            <li>
                                <a href="/solution/government_cloud">政务云</a>
                            </li>
                            <li>
                                <a href="/solution/website_deployment">网站部署</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="javascript:;">数据中心</a>
                    <div class="dropdown-mark" style="width: auto; height: auto; padding-bottom: 20px; padding-right: 20px; padding-left: 20px; text-align: center;">
                        <span class="dropdown-icon"></span>
                        <ul>
                            <li>
                                <a href="/datacenter/huizhou">惠州数据中心</a>
                            </li>
                            <li>
                                <a href="/datacenter/hengyang">衡阳数据中心</a>
                            </li>
                            <li>
                                <a href="/datacenter/xian">西安数据中心</a>
                            </li>
                        </ul>
                    </div>
                </li>
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
                        <a href="/zuyong/index">服务器租赁</a>
                    </dd>
                    <dd>
                        <a href="/tuoguan/hengyang">服务器托管 </a>
                    </dd>
                    <dd>
                        <a href="/zuyong/gaofang">高防服务器</a>
                    </dd>
                    <dd>
                        <a href="/dist/highDefense.html">高防IP</a>
                    </dd>
                    <dd>
                        <a href="/15cdn/sca">CDN加速</a>
                    </dd>
                    <dd>
                        <a href="/protection/index">网络安全</a>
                    </dd>
                </dl>
                <dl>
                    <dt>增值服务</dt>
                    <dd>
                        <a href="/yun/huizhou">腾正云</a>
                    </dd>
                    <dd>
                        <a href="/protection/c-shield">防C盾</a>
                    </dd>
                    <dd>
                        <a href="/15cdn/index">15CDN</a>
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
                        <a href="/aboutus/pay">支付中心</a>
                    </dd>
                    <dd>
                        <a href="/help">帮助中心</a>
                    </dd>
                    <dd>
                        <a target="_blank" href="http://doc.tzidc.com">API文档</a>
                    </dd>
                </dl>
                <dl>
                    <dt>新闻资讯</dt>
                    <dd>
                        <a href="/article/company">公司动态</a>
                    </dd>
                    <dd>
                        <a href="/article/placard">公司公告</a>
                    </dd>
                    <dd>
                        <a href="/article/industry">行业动态</a>
                    </dd>
                </dl>
                <dl class="contact-us">
                    <dt>联系我们</dt>
                    <dd class="clearfix">
                        <span class="pull-left">
                            东莞总公司：
                        </span>
                        <span class="pull-left" style="width: 20em;">
                            东莞松山湖高新技术产业开发区科技十路5号国际金融IT研发中心第2栋B座
                        </span>
                    </dd>
                    <!-- <dd>惠州分公司：广东省惠州市东平南路21号2栋第二层</dd> -->
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
                @foreach ($product_links as $item)
                <span>
                    <a href="{{$item->url}}">{{$item->name}}</a>
                </span>
                @endforeach
                <!-- <span>
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
                </span> -->
            </div>
            <div class="footer-popular-searches">
                <span>热门搜索：</span>
                @foreach ($search_links as $item)
                <span>
                    <a href="{{$item->url}}">{{$item->name}}</a>
                </span>
                @endforeach
                <!-- <span>
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
                </span> -->
            </div>
            <div class="footer-links">
                <span>友情链接：</span>
                @foreach ($links as $item)
                <span>
                    <a href="{{$item->url}}" target="_blank">{{$item->name}}</a>
                </span>
                @endforeach
                <!-- <span>
                    <a href="http://bbs.idckx.com/forum.php">IDC资源发布</a>
                </span>
                <span>
                    <a href="https://yun.zeisp.com/">腾正云</a>
                </span>
                <span>
                    <a href="#">下载联盟</a>
                </span>
                <span>
                    <a href="https://www.15cdn.com/">15CDN</a>
                </span>
                <span>
                    <a href="http://www.ip138.com/idc/">IDC公司</a>
                </span> -->
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
                    <a href="http://www.beian.miit.gov.cn" target="_blank">粤ICP备15081286号</a>
                </span>
                <span>全国IDC证：A2.B1.B2-20150233</span>
            </p>
            <div class="red-shield">
                <!-- <a title="企业名称：广东腾正计算机科技有限公司&#10;法定代表人：黄志昌&#10;标识状态：已激活 粤工商备P191809001261" href="http://wljg.gdgs.gov.cn/lz.ashx?vie=41BEF320E537FBF5FB05128371785C72E68E27A4AF820A5D7DDC2E150B907189EF905A25C90D5E0E0799C10B9F2E8A59" target="_blank">
                    <img style="border: 0px currentColor; border-image: none;" alt="" src="http://wljg.gdgs.gov.cn/images/logo.jpg" />
                </a> -->
                <!-- <iframe src="http://wljg.gdgs.gov.cn/lz.ashx?vie=41BEF320E537FBF5FB05128371785C72E68E27A4AF820A5D7DDC2E150B907189EF905A25C90D5E0E0799C10B9F2E8A59" allowtransparency="true" scrolling="no" style="overflow:hidden;" frameborder="0"></iframe> -->
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
                            @foreach ($contacts as $item)
                                <li>
                                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={{$item->qq}}&site=qq&menu=yes">
                                        <img alt="给我发消息" src="{{asset('/images/button_old_41.gif')}}">
                                        {{$item->contactname}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
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
        <div class="tz-kefu-help tz-kefu-item">
            <span class="tz-kefu-item-btn"></span>
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
    var _hmt = _hmt || [];
    (function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?8deb12c6d7082ff4fe26287eb984ab3c";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
    })();
    </script>
    <script>
        var cnzz_protocol = (("https:" == document.location.protocol) ? "https://" : "http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253197097'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/c.php%3Fid%3D1253197097' type='text/javascript'%3E%3C/script%3E"));
        var rs = @getContacts("json");
        document.querySelector(".tz-kefu-help").onclick = function() {
            location.href = "/help";
        }
        function randomqq(){
            var num = Math.random();
            num = Math.ceil(num *rs.length)-1;
            // window.location.href="http://wpa.qq.com/msgrd?v=3&uin="+rs[num].qq+"&site=qq&menu=yes";
            open_blank_window("http://wpa.qq.com/msgrd?v=3&uin="+rs[num].qq+"&site=qq&menu=yes");
        }
        function open_blank_window(url) {
            if(!document.getElementById("toLink")) {
                var aElement = document.createElement("a");
                aElement.setAttribute("id","toLink");
                aElement.setAttribute("href",url);
                aElement.setAttribute("target","_blank");
                document.body.appendChild(aElement);
            }
            document.getElementById("toLink").href = url;
            document.getElementById("toLink").click();
        }
    </script>
</body>
</html>
