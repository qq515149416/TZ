<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')-腾正科技有限公司</title>
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/css/swiper.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/css/animate.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/css/index.css") }}" />
</head>
<body>
    <div class="container-fluid main">
        @yield('content')
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
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    成龙
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2853978330&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    禹豪
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2885650826&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    唐康
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506995&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    秋霞
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506994&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    思恩
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506993&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    国东
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2853978331&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    帅东
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2853978334&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    嘉辉
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506997&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    小叶
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506992&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
                                    镜雄
                                </a>
                            </li>
                            <li>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2851506990&site=qq&menu=yes">
                                    <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
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
                                <img alt="给我发消息" src="http://wpa.qq.com/pa?p=1:2885655958:4">
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
                                <img alt="给我发消息" src="{{ asset("/images/info.png") }}">
                                0769-22385558
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="#">
                                <img alt="给我发消息" src="{{ asset("/images/iphone.png") }}">
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
                                <img alt="给我发消息" src="{{ asset("/images/info.png") }}">
                                0769-22385558
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
</body>
</html>
