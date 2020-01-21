<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset("/tool/bootstrap/css/bootstrap.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/tool/bootstrap/css/bootstrap-reboot.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/tool/bootstrap/css/bootstrap-grid.min.css") }}" />    
    <link rel="stylesheet" href="{{ asset("/css/bootstrap-table.min.css") }}" />    
    <link rel="stylesheet" href="{{ asset("/css/UCFORM.css") }}" />    
    <link rel="stylesheet" href="{{ asset("/bootstrap_datetimepicker/css/bootstrap-datetimepicker.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/user_assets/css/main.css") }}" />
</head>
<body>
    <div id="user_admin" class="container-fluid px-0">
        <nav class="navbar navbar-expand-lg navbar-light navbar-bg pr-4">
            <a class="navbar-brand py-0" href="#">
                <img src="{{ asset("/user_assets/html_img/logo.png") }}" alt="" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-md-flex justify-content-end container-fluid px-0">
                    <ul class="navbar-nav mr-auto d-block d-md-none d-lg-none">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">
                                概况
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">服务器</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">高防IP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">财务信息</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">备案管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">用户信息</a>
                        </li>
                    </ul>
                    @yield('tab')
                    <ul class="navbar-nav main-nav d-none d-md-flex d-lg-flex align-items-center">
                        <li class="nav-item">
                            <a class="nav-link py-0" href="#">
                                <span class="customer-service icon"></span>
                            </a>
                            @component('layouts.component.alert')
                                <div class="kefu">
                                    <p class="font-regular my-0">您的专属客服</p>
                                    <h3 class="font-heavy my-4 global-kefu-name">帅东</h3>
                                    <p class="font-medium mb-3">
                                        <span>QQ号码</span>
                                        <span class="align-self-center ml-2 global-kefu-qq">515149416</span>
                                    </p>
                                    <p class="font-medium mb-2">
                                        <span>手机号码</span>
                                        <span class="align-self-center ml-2 global-kefu-phone">12345678901</span>
                                    </p>
                                </div>
                            @endcomponent
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-0" href="#">
                                <span class="erweima icon"></span>
                            </a>
                            @component('layouts.component.alert')
                                <div class="erweima-show">
                                    <img src="{{ asset("/user_assets/html_img/erweima.png") }}" class="mx-auto d-block" alt="二维码">
                                    <h3 class="text-center font-heavy my-3">关注腾正科技公众号</h3>
                                    <ul class="pl-1 ml-1 mx-0">
                                        <li class="font-regular">
                                            <span>购买、续费更优惠</span>
                                        </li>
                                        <li class="font-regular">
                                            <span>异常、告警先知会</span>
                                        </li>
                                        <li class="font-regular">
                                            <span>服务器资源使用实时看</span>
                                        </li>
                                    </ul>
                                </div>
                            @endcomponent
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-0" href="#">
                                <span class="wallet icon"></span>
                            </a>
                            @component('layouts.component.alert')
                                <div class="account-info">
                                    <p class="font-regular mb-3">账户余额</p>
                                    <p class="mb-4 global-balance">8888.88</p>
                                    <button type="button" class="btn btn-primary d-block w-100 font-medium" data-toggle="modal" data-target="#rechargeModal">充值</button>
                                    <ul class="list-group mt-2">
                                        <li class="list-group-item font-medium border-0 pl-2 ml-2 pr-0">
                                            <a class="ml-4 d-block" href="javascript:;">我的订单</a>
                                        </li>
                                        <li class="list-group-item font-medium border-0 pl-2 ml-2 pr-0">
                                            <a class="ml-4 d-block" href="javascript:;">收支明细</a>
                                        </li>
                                    </ul>
                                </div>
                            @endcomponent
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-0" href="#">
                                <span class="user icon"></span>
                            </a>
                            @component('layouts.component.alert')
                                <div class="account">
                                    <div class="media border-bottom pb-3">
                                        <img src="{{ asset("/user_assets/html_img/avatar_small.png") }}" class="align-self-center mr-2" alt="头像">
                                        <div class="media-body mb-1 global-user-info">
                                            <h5 class="my-0 mt-2 font-heavy d-flex">
                                                <span>黄某某</span>
                                                <span class="badge status font-medium badge-light ml-2">已认证</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <ul class="list-group mt-2">
                                        <li class="list-group-item font-medium border-0 pl-2 ml-2 pr-0">
                                            <a class="ml-4 d-block" href="javascript:;">用户中心</a>
                                        </li>
                                        <li class="list-group-item font-medium border-0 pl-2 ml-2 pr-0">
                                            <a class="ml-4 d-block" href="javascript:;">财务账户</a>
                                        </li>
                                        <li class="list-group-item font-medium border-0 pl-2 ml-2 pr-0">
                                            <a class="ml-4 d-block" href="javascript:;">修改密码</a>
                                        </li>
                                        <li class="list-group-item font-medium border-0 pl-2 ml-2 pr-0">
                                            <a class="ml-4 d-block" href="javascript:;">退出登录</a>
                                        </li>
                                    </ul>
                                </div>
                            @endcomponent
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-0 text" href="#">
                                <span class="text font-medium">
                                    跳转旧版本
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col-2 px-0 menu d-none d-sm-flex align-items-stretch">
                    <ul class="mx-0 px-0 my-0 py-0 pt-5">
                        <li class="pl-4 ml-1 pb-4">
                            <a class="{{ $page==='index' ? 'active' : '' }}" href="/user/index">
                                <span class="icon overview mr-2"></span>
                                <span class="pl-1 font-regular">概况</span>
                            </a>
                        </li>
                        <li class="pl-4 ml-1 pb-4">
                            <a class="{{ strpos($page,'server')!==false ? 'active' : '' }}" href="/user/server">
                                <span class="icon server mr-2"></span>
                                <span class="pl-1 font-regular">服务器</span>
                            </a>
                        </li>
                        <li class="pl-4 ml-1 pb-4">
                            <a href="javascript:;">
                                <span class="icon gaofang mr-2"></span>
                                <span class="pl-1 font-regular">高防IP</span>
                            </a>
                        </li>
                        <li class="pl-4 ml-1 pb-4">
                            <a href="javascript:;">
                                <span class="icon finance mr-2"></span>
                                <span class="pl-1 font-regular">财务信息</span>
                            </a>
                        </li>
                        <li class="pl-4 ml-1 pb-4">
                            <a href="javascript:;">
                                <span class="icon beian mr-2"></span>
                                <span class="pl-1 font-regular">备案管理</span>
                            </a>
                        </li>
                        <li class="pl-4 ml-1 pb-4">
                            <a href="javascript:;">
                                <span class="icon user mr-2"></span>
                                <span class="pl-1 font-regular">用户信息</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @yield('mobile_tab')
                <div class="col px-0 pt-4 align-items-stretch content overflow-hidden-x">
                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("/tool/jquery/jquery-3.4.1.min.js") }}"></script>
    <script src="{{ asset("/tool/jquery/popper.min.js") }}"></script>
    <script src="{{ asset("/tool/bootstrap/js/bootstrap.min.js") }}"></script>    
    <script src="{{ asset("/bootstrap_datetimepicker/js/bootstrap-datetimepicker.min.js") }}"></script>
    <script src="{{ asset("/bootstrap_datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js") }}"></script>

    <script src="{{ asset("/user_assets/js/main.js") }}"></script>
    <script src="{{ asset("/js/bootstrap-table.min.js") }}"></script>
    <script src="{{ asset("/js/bootstrap-table-locale-all.min.js") }}"></script>
    <script src="{{ asset("/js/extensions/bootstrap-table-mobile.min.js") }}"></script>    
    <script src="{{ asset("/js/qrcode.min.js") }}"></script>

    <script>
        $.browser = $.browser || {
            msie: /msie/.test(navigator.userAgent.toLowerCase()),
            version: 11
        };
    </script>
    <script src="{{ asset("/js/jQuery.UCSelect.js") }}"></script>
    @include('layouts.component.renew')    
    @include('layouts.component.pay')
    @include('layouts.component.recharge')
    @include('layouts.component.order_detail')
</body>
</html>
