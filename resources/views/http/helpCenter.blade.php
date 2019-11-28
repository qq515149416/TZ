@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="tz-help-center">
    @include('http.helpCenter.banner')
    <div class="content-container">
        <nav class="category">
            <ul>
                @foreach ($nav_main as $item)
                <li>
                    <a href="/help/{{ $item->id }}">
                        {{ $item->name }}
                    </a>
                </li>
                @endforeach
                <!-- <li>
                    <a href="javascript:;">
                        Windows服务器FAQ
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        服务器租用
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        服务器托管
                    </a>
                </li> -->
            </ul>
        </nav>
        <div class="main">
            <div class="breadcrumbs font-medium">
                <a href="javascript:;">首页</a>
                <span class="arrow">></span>
                <span class="current">帮助中心</span>
                <!-- <a href="javascript:;">首页</a>
                <span class="arrow">></span>
                <a href="javascript:;">帮助中心</a>
                <span class="arrow">></span>
                <span class="current">服务器租用</span> -->
            </div>
            @include($template)
            <!-- <div class="list-content">
                <h2>
                    服务器租用
                </h2>
                <div class="search-result-title font-regular">
                    搜索“<span class="font-heavy">服务器</span>”的结果
                </div>
                <ul>
                    <li>
                        <div class="media">
                            <div class="media-left">
                                <a href="javascript:;">
                                    <span class="date-day">
                                        31
                                    </span>
                                    <span class="date-years">
                                        2019/01
                                    </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="javascript:;">
                                    <h4 class="media-heading">
                                        <span class="top">置顶</span>
                                        松山湖台湾招商局副局长与厚街侨留会荣誉会长莅临腾正科技参观交流
                                    </h4>
                                    <p>
                                        6月19日，松山湖台湾招商局曾副局长和厚街侨留会荣誉王会长莅临腾正科技参观交流，腾正科技董事长黄志昌、产品部总监涂泽波、运行部经理陈真陪同参观交流，并为到访来宾介绍了相关情况。
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div> -->
            <!-- <div class="collection">
                <div class="paper">
                    <h3 class="font-medium">
                        Linux服务器FAQ
                    </h3>
                    <ul class="font-regular">
                        <li>
                            <a href="javascript:;">
                                为什么我们要使用linux系统？
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件信息命令
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                    </ul>
                    <a class="font-regular" href="javascript:;">查看更多</a>
                </div>
                <div class="paper">
                    <h3 class="font-medium">
                        Linux服务器FAQ
                    </h3>
                    <ul class="font-regular">
                        <li>
                            <a href="javascript:;">
                                为什么我们要使用linux系统？
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件信息命令
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                    </ul>
                    <a class="font-regular" href="javascript:;">查看更多</a>
                </div>
                <div class="paper">
                    <h3 class="font-medium">
                        Linux服务器FAQ
                    </h3>
                    <ul class="font-regular">
                        <li>
                            <a href="javascript:;">
                                为什么我们要使用linux系统？
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件信息命令
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                    </ul>
                    <a class="font-regular" href="javascript:;">查看更多</a>
                </div>
                <div class="paper">
                    <h3 class="font-medium">
                        Linux服务器FAQ
                    </h3>
                    <ul class="font-regular">
                        <li>
                            <a href="javascript:;">
                                为什么我们要使用linux系统？
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件信息命令
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                    </ul>
                    <a class="font-regular" href="javascript:;">查看更多</a>
                </div>
                <div class="paper">
                    <h3 class="font-medium">
                        Linux服务器FAQ
                    </h3>
                    <ul class="font-regular">
                        <li>
                            <a href="javascript:;">
                                为什么我们要使用linux系统？
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件信息命令
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                    </ul>
                    <a class="font-regular" href="javascript:;">查看更多</a>
                </div>
                <div class="paper">
                    <h3 class="font-medium">
                        Linux服务器FAQ
                    </h3>
                    <ul class="font-regular">
                        <li>
                            <a href="javascript:;">
                                为什么我们要使用linux系统？
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件信息命令
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                    </ul>
                    <a class="font-regular" href="javascript:;">查看更多</a>
                </div>
                <div class="paper">
                    <h3 class="font-medium">
                        Linux服务器FAQ
                    </h3>
                    <ul class="font-regular">
                        <li>
                            <a href="javascript:;">
                                为什么我们要使用linux系统？
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件信息命令
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                    </ul>
                    <a class="font-regular" href="javascript:;">查看更多</a>
                </div>
                <div class="paper">
                    <h3 class="font-medium">
                        Linux服务器FAQ
                    </h3>
                    <ul class="font-regular">
                        <li>
                            <a href="javascript:;">
                                为什么我们要使用linux系统？
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件信息命令
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                CentOS查看硬件命令总汇
                            </a>
                        </li>
                    </ul>
                    <a class="font-regular" href="javascript:;">查看更多</a>
                </div>
            </div> -->
        </div>
    </div>
    @include('http.helpCenter.footer')

</div>
@endsection
