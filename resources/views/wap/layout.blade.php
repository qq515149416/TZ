<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ request()->path() === "/" ? '腾正科技-' : '' }}@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}"> -->
    <link rel="shortcut icon" href="{{ asset("/favicon.ico") }}" type="image/x-icon" />
    <link rel="icon" sizes="any" mask href="{{ asset("/favicon.svg") }}">
    <link rel="stylesheet" href="{{ asset("/css/wap/main.css") }}?random_num={{ time() + random_int(100,1000) }}" />
    <meta name="keywords" content="@yield('keywords')"/>
    <meta name="description" content="@yield('description')">
</head>

<body>
    <div id="tz-menu" class="page-{{ $page }}">
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
                                @if ($page === 'menu')
                                <a href="javascript: history.back();">
                                    <img src="{{ asset("/images/wap/菜单开.png") }}" alt="">
                                </a>
                                @else
                                <a href="/wap/menu">
                                    <img src="{{ asset("/images/wap/菜单.png") }}" alt="">
                                </a>
                                @endif
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
                @yield('content')
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
<script src="{{ asset("/js/wap/main.js") }}"></script>
