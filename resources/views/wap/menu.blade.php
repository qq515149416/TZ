@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 菜单 -->
<div id="menu">
    <div class="main-body">
        <div class="tz-container">
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
                                <img src="{{ asset("/images/wap/菜单开.png") }}" alt="">
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
            <div class="main-content">
                <div class="user-navbar-collapse">
                    <div class="collapses">
                        <div class="tz-fuwu">
                            <div class="tz-fuwu-box">
                                <div class="menu-li ">
                                    <div class="menu-i">
                                        <p>最新活动</p>
                                    </div>
                                </div>
                                <div class="menu-li">
                                    <div class="menu-i Yun-fuwu-li-i ">
                                        <p>产品</p>
                                        <div class="div-arrow">
                                            <span class="arrow"></span>
                                        </div>
                                    </div>
                                    <div class="Yun-items-li tz-main">
                                        <ul>
                                            <li>
                                                <p>高防服务器</p>
                                            </li>
                                            <li>
                                                <p>DDOS高防ip</p>
                                            </li>
                                            <li>
                                                <p>高防云主机</p>
                                            </li>
                                            <li>
                                                <p>高防CDN</p>
                                            </li>
                                            <li>
                                                <p>DDOS防御流量叠加包</p>
                                            </li>
                                            <li>
                                                <p>云计算</p>
                                            </li>
                                            <li>
                                                <p>防C盾</p>
                                            </li>
                                            <li>
                                                <p>服务器租用</p>
                                            </li>
                                            <li>
                                                <p>服务器托管</p>
                                            </li>
                                            <li>
                                                <p>机柜租用</p>
                                            </li>
                                            <li>
                                                <p>带宽租用</p>
                                            </li>
                                            <li>
                                                <p>CDN加速</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="menu-li">
                                    <div class="menu-i Yun-fuwu-li-i ">
                                        <p>解决方案</p>
                                        <div class="div-arrow">
                                            <span class="arrow"></span>
                                        </div>
                                    </div>
                                    <div class="Yun-items-li tz-main">
                                        <ul>
                                            <li>
                                                <p>棋牌云解决方案</p>
                                            </li>
                                            <li>
                                                <p>金融云解决方案</p>
                                            </li>
                                            <li>
                                                <p>流媒体解决方案</p>
                                            </li>
                                            <li>
                                                <p>棋牌云解决方案</p>
                                            </li>
                                            <li>
                                                <p>网站及部署解决方案</p>
                                            </li>
                                            <li>
                                                <p>移动APP云化解决方案</p>
                                            </li>
                                            <li>
                                                <p>游戏云解决方案</p>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="menu-li">
                                    <div class="menu-i">
                                        <p>帮助中心</p>
                                    </div>
                                </div>
                                <div class="menu-li ">
                                    <div class="menu-i">
                                        <p>管理控制台</p>
                                    </div>
                                </div>
                                <div class="menu-li ">
                                    <div class="menu-i">
                                        <p>联系我们</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapses">
                        <div class="tz-main">
                            <div class="collapses-img">
                                <img src="{{ asset("/images/wap/网络安全bg.png") }}" alt="">
                                <div class="img-t">
                                    网络安全，企业首选 —— 腾正科技
                                </div>
                                <div class="img-btn">
                                    <div class="btn">立即咨询</div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="sidebar">
                                    <img src="{{ asset("/images/wap/侧栏.png") }}" alt="">
                                </div> -->
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
