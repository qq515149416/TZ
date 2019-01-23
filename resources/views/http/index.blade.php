
@extends('layouts.layout')

@section('title', '服务器租用，服务器托管，专业IDC服务商')

@section('content')
    <!-- <div class="row">
        <div class="iframe">
            <iframe width="100%" frameborder="0" src="http://175.6.248.62:8080/" height="100%"></iframe>
        </div>
    </div> -->
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
                <li><a href="#" class="login">登陆</a></li>
                <li><a href="#" class="registered">注册</a></li>
            </ul>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">首页 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">产品服务</a></li>
                <li><a href="#">数据中心</a></li>
                <li><a href="#">解决方案</a></li>
                <li><a href="#">最新活动</a></li>
                <li><a href="#">新闻中心</a></li>
                <li><a href="#">关于我们</a></li>
                <!-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li> -->
            </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
        </nav>

    </header>
    <div class="banner row">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{ asset("/images/banner/cdnNewYear.jpg") }}" alt="...">
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <img src="{{ asset("/images/banner/newYear.png") }}" alt="...">
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <img src="{{ asset("/images/banner/yunNewYear.png") }}" alt="...">
                <div class="carousel-caption">
                </div>
            </div>
        </div>

        <!-- Controls -->
        <!-- <a class="left carousel-control" href="javascript:;" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="javascript:;" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a> -->
        </div>
    </div>
    <div class="hot-products row">
        <div class="container clearfix">
            <div class="hot-products-item">
                <a href="javascript:;">
                    <h3>安全防护</h3>
                    <p>抵御SYN、CC、DNS等 多种攻击，实现有效防护</p>
                    <span class="more"></span>
                </a>
            </div>
            <div class="hot-products-item">
                <a href="javascript:;">
                    <h3>服务器托管</h3>
                    <p>多线路组合，多城布点， 7×24的专人维护以及监控服务</p>
                    <span class="more"></span>
                </a>
            </div>
            <div class="hot-products-item">
                <a href="javascript:;">
                    <h3>服务器租用</h3>
                    <p>品牌服务器，根据行业特点、 客户规模量身打造租用方案</p>
                    <span class="more"></span>
                </a>
            </div>
            <div class="hot-products-item">
                <a href="javascript:;">
                    <h3>智能高防IP</h3>
                    <p>隐藏真实源服务器IP，安全 稳定全程保驾护航源服务器</p>
                    <span class="more"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="service row">
        <div class="service-head">
            <div class="container">
                <h2>腾正科技一站式产品服务</h2>
                <p>关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</p>
            </div>
        </div>
        <div class="service-body">

        </div>
    </div>

@endsection
