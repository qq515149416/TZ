@extends('layouts.layout')

@section('title', '游戏云解决方案-游戏服务器架构-CDN游戏加速[腾正科技]')

@section('keywords', '游戏云解决方案,游戏云面临问题,游戏云架构部署,游戏服务器,游戏服务器架构，CDN游戏加速')

@section('description', '腾正科技游戏云解决方案，利用云服务器弹性扩展、负载均衡功能、自研高防御系统及CDN加速，打造虚拟化、高可用的游戏集群，解决游戏客户运行卡顿、掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题。')

@section('content')
<div class="tz-solution">
    <div class="tab">
        <a class="tab-item active" href="/solution/game">游戏</a>
        <a class="tab-item" href="/solution/chess">棋牌</a>
        <a class="tab-item" href="/solution/finance">金融</a>
        <a class="tab-item" href="/solution/streaming_media">流媒体</a>
        <a class="tab-item" href="/solution/mobile_app">移动APP</a>
        <a class="tab-item" href="/solution/education_cloud">教育云</a>
        <a class="tab-item" href="/solution/government_cloud">政务云</a>
        <a class="tab-item" href="/solution/website_deployment">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content">
        <!-- 游戏云 -->
        <div id="game">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">游戏云解决方案</h2>
                    <h5 class="sub-text">
                        行业领先自研游戏生态系统，打造虚拟化、高可用的游戏集群，完美解决游戏客户运行卡顿、
                        <br/>
                        掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">游戏云面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon1.png") }}" />
                            <span class="text">计算性能不够，游戏卡顿？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>百万级PPS的云服务器</li>
                                <li>资源独享的专属机</li>
                                <li>超高性能的物理机</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon2.png") }}" />
                            <span class="text">网络不稳定，玩家掉线？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>资源优势10+线BGP网络</li>
                                <li>万兆冗余内网，绝无单点</li>
                                <li>高性能的外网共享带宽</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon3.png") }}" />
                            <span class="text">游戏大推，大量玩家访问？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>20+万IOPS的高性能本地盘</li>
                                <li>数万IOPS的高可靠云磁盘</li>
                                <li>极致性能的缓存、数据库</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon4.png") }}" />
                            <span class="text">游戏安全，如何保障？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>高防抗D服务</li>
                                <li>HTTPS加密负载均衡</li>
                                <li>VPN/专线安全数据传输</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon5.png") }}" />
                            <span class="text">游戏服，监控及故障恢复？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>用户自定义报警</li>
                                <li>云服务器秒级热迁移</li>
                                <li>物理机宕机，游戏分钟级恢复</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon6.png") }}" />
                            <span class="text">游戏要求全国同服？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>多地区数据中心</li>
                                <li>数据中心之间内网T级传输带宽</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/game-arch.png") }}" alt="游戏云解决方案构架部署图" />
                    <div>
                        <p class="desc">
                            腾正科技游戏云服务，从构建基础设施到游戏上线到后期精细化运营，腾正科技服务涵盖项目整个发展周期。在IT架构层面将不同功能模块，比如登录，逻辑，商城，图片服务等业务分离，业<br/>务水平扩展，利用云服务器弹性扩展和负载均衡功能，随时增减云服务器。同时增加缓存服务器、数据库读写分离、轻松应对海量玩家同时在线。在资源上，腾正科技应用业内领先的双线高防<br/>节点以及国内优质的BGP多线网络资源，隐藏源站真实IP，解决跨地域跨线路问题，为用户全面打造稳如磐石的游戏解决方案。
                        </p>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">游戏云服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>自动DDoS清洗系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    10T+防御带宽，配备T量级超强硬件清洗平台，<br/>
                                    抵御不同类型DDoS、CC等攻击坚如磐石，满足<br/>
                                    游戏客户对网络安全方面的需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>游戏更新智能分发</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    开放存储服务与内容分发网络服务结合，可实现<br/>
                                    游戏升级更新包与客户端高速、低成本的分发与<br/>
                                    加速。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>游戏体验畅通无阻</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    游戏云专属服务器集群，高IO读写性能。保证在<br/>
                                    高并发下依然能够保证稳定的IOPS，有效避免了<br/>
                                    游戏卡顿现象，提升玩家体验以及留存率。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>海量游戏日志存储</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    启用简单日志服务对游戏日志进行存储查询，通<br/>
                                    过DPC整合日志数据到ODPS中，实现海量日志<br/>
                                    数据分析。为游戏云用户提供数据支撑。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-5.png") }}" alt="adv5" />
                                <span>负载均衡平滑拓展</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    游戏运营过程中，可以根据用户量随时增加或者<br/>
                                    合并服务器，利用负载均衡，自动分配用户流量，<br/>
                                    满足服务器平滑扩展需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-6.png") }}" alt="adv6" />
                                <span>操作简便一键完成</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    支持多种架构游戏用户，手游，页游，端游一键<br/>
                                    部署轻松搞定。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--咨询-->
        <div class="consult">
            <h2 class="title">
                联系解决方案架构师定制专属方案
            </h2>
            <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
        </div>
    </div>
</div>
@endsection
