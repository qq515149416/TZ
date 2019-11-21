@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 菜单 -->
<div id="menu">
    <div class="main-body">
        <div class="tz-container clear">

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
                                                <a href="/wap/high_security">
                                                    <p>高防服务器</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/high_security_ip">
                                                    <p>DDOS高防ip</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/high_proof_host">
                                                    <p>高防云主机</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/high_anti_cdn">
                                                    <p>高防CDN</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/flow_stack_packet">
                                                    <p>DDOS防御流量叠加包</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/cloud_hosting">
                                                    <p>云计算</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/c_shield">
                                                    <p>防C盾</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/server_hire">
                                                    <p>服务器租用</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/server_hosting">
                                                    <p>服务器托管</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/cabinet">
                                                    <p>机柜租用</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/bandwidth">
                                                    <p>带宽租用</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/cdn_speed_up">
                                                    <p>CDN加速</p>
                                                </a>
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
                                                <a href="/wap/chess_solution">
                                                    <p>棋牌云解决方案</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/financial_solution">
                                                    <p>金融云解决方案</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/media_solution">
                                                    <p>流媒体解决方案</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/education_solution">
                                                    <p>教育云解决方案</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/deployment_solution">
                                                    <p>网站及部署解决方案</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/mobileapp_solution">
                                                    <p>移动APP云化解决方案</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/game_solution">
                                                    <p>游戏云解决方案</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/wap/government_solution">
                                                    <p>政务云解决方案</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="menu-li">
                                    <div class="menu-i">
                                        <a href="/wap/help_center">
                                            <p>帮助中心</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="menu-li ">
                                    <div class="menu-i">
                                        <p @click="console">管理控制台</p>
                                    </div>
                                </div>
                                <div class="menu-li ">
                                    <div class="menu-i">
                                        <a href="/wap/company/contact">
                                            <p>联系我们</p>
                                        </a>
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
