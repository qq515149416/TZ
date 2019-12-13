<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset("/tool/bootstrap/css/bootstrap.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/tool/bootstrap/css/bootstrap-reboot.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("/tool/bootstrap/css/bootstrap-grid.min.css") }}" />
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
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link py-0" href="#">
                                <span class="customer-service icon"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-0" href="#">
                                <span class="erweima icon"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-0" href="#">
                                <span class="wallet icon"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-0" href="#">
                                <span class="user icon"></span>
                            </a>
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
                            <a class="active" href="javascript:;">
                                <span class="icon overview mr-2"></span>
                                <span class="pl-1 font-regular">概况</span>
                            </a>
                        </li>
                        <li class="pl-4 ml-1 pb-4">
                            <a href="javascript:;">
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
                <div class="col px-0 pt-4 align-items-stretch content overflow-hidden-x">
                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("/tool/jquery/jquery-3.4.1.min.js") }}"></script>
    <script src="{{ asset("/tool/jquery/popper.min.js") }}"></script>
    <script src="{{ asset("/tool/bootstrap/js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("/user_assets/js/main.js") }}"></script>
</body>
</html>