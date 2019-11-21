@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<!-- 帮助中心 -->
<div id="help_center">
        <div class="main-body">
            <div class="tz-container clear">
                <!-- 内容 -->
                <div class="main-content">
                <div class="posters">
                        <img src="{{ asset("/images/wap/帮助中心海报.png") }}" alt="">
                        <div class="search">
                            <p class="search-t">帮助中心</p>
                            <div class="search-c">
                                <input type="text" name="search" id="" placeholder="请输入关键词题的答案">
                                <a href="/wap/search_results">
                                <input type="botton" style="background-image: url({{ asset("/images/wap/搜索.png") }});">
                            </a>
                            </div>
                            <div class="search-f">
                                <p>热门：怎么选择服务器租用商 | 服务器托管好吗</p>
                                <p>云主机安全吗 | 大带宽价格 | 网络安全</p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="title">
                        <p>常见自主服务</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="independent-service">
                        <ul class="clear">
                            <li>
                                <img src="{{ asset("/images/wap/找回密码.png") }}" alt="">
                                <p>找回密码</p>
                            </li>
                            <li>
                                <img src="{{ asset("/images/wap/账户充值.png") }}" alt="">
                                <p>账户充值</p>
                            </li>
                            <li>
                                <img src="{{ asset("/images/wap/财务管理.png") }}" alt="">
                                <p>财务管理</p>
                            </li>
                        </ul>
                    </div>
                    <!-- 产品常见问题 -->
                    <div class="common-problems">
                        <div class="title">
                            <p>产品常见问题</p>
                            <div class="title-hr"></div>
                        </div>
                        <div class="help-problems">
                            <div class="tz-main">
                                <ul>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/Linux_server">
                                            <span class="dian"></span>
                                            <p>Linux服务器FAQ</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/Windows_server">
                                            <span class="dian"></span>
                                            <p>Windows服务器FAQ</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/server_rent">
                                            <span class="dian"></span>
                                            <p>服务器租用</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/server_hosting">
                                            <span class="dian"></span>
                                            <p>服务器托管</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/high_server">
                                            <span class="dian"></span>
                                            <p>高防服务器</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>    
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/DDOS_height_ip">
                                            <span class="dian"></span>
                                            <p>DDOS高防IP</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/cabinet_rent">
                                            <span class="dian"></span>
                                            <p>机柜租用</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>   
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/broadband_rent">
                                            <span class="dian"></span>
                                            <p>大带宽租用</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/network_security">
                                            <span class="dian"></span>
                                            <p>网络安全</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/CDN_speed">
                                            <span class="dian"></span>
                                            <p>CDN加速</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/height_CDN">
                                            <span class="dian"></span>
                                            <p>高防CDN</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/cloud_hosting">
                                            <span class="dian"></span>
                                            <p>云主机</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/C_shield">
                                            <span class="dian"></span>
                                            <p>防C盾</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/solution">
                                            <span class="dian"></span>
                                            <p>解决方案</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/operations">
                                            <span class="dian"></span>
                                            <p>运维咨讯</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/online_game">
                                            <span class="dian"></span>
                                            <p>网游咨讯</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    
                                    <li class="clear">
                                        <a href="/wap/help_center_home/web_site">
                                            <span class="dian"></span>
                                            <p>网站备案</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/newbie_guide">
                                            <span class="dian"></span>
                                            <p>新手指南</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                    <li class="clear">
                                        <a href="/wap/help_center_home/problem">
                                            <span class="dian"></span>
                                            <p>常见问题</p>
                                            <p>共 <span>06</span> 文档</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection