@extends('layouts.layout')

@section('title', '游戏云解决方案-游戏服务器架构-CDN游戏加速[腾正科技]')

@section('keywords', '游戏云解决方案,游戏云面临问题,游戏云架构部署,游戏服务器,游戏服务器架构，CDN游戏加速')

@section('description', '腾正科技游戏云解决方案，利用云服务器弹性扩展、负载均衡功能、自研高防御系统及CDN加速，打造虚拟化、高可用的游戏集群，解决游戏客户运行卡顿、掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题。')

@section('content')
<div class="tz-solution">
    <div class="tab">
        <a class="tab-item" href="/solution/game">游戏</a>
        <a class="tab-item active" href="/solution/chess">棋牌</a>
        <a class="tab-item" href="/solution/finance">金融</a>
        <a class="tab-item" href="/solution/streaming_media">流媒体</a>
        <a class="tab-item" href="/solution/mobile_app">移动APP</a>
        <a class="tab-item" href="/solution/education_cloud">教育云</a>
        <a class="tab-item" href="/solution/government_cloud">政务云</a>
        <a class="tab-item" href="/solution/website_deployment">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content">
        <!-- 棋牌云 -->
        <div id="chess">
            <!-- banner -->
            <div class="banner">
                <div class="title">
                    <h2 class="text">棋牌云解决方案</h2>
                    <h5 class="sub-text font-regular">
                        成熟技术团队，海量攻防实战积累，为游戏运营打造可信赖的安全解决方案，全方位解决
                        <br/>
                        卡顿掉线、欺诈作弊、外挂等常见问题，轻松应对海量玩家同时在线
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">棋牌游戏面临的问题</h2>
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon7-1.png") }}" />
                            <img class="hover-icon" src="{{ asset("/images/program/icon7-2.png") }}" />
                            <h4 class="text">DDoS攻击</h4>
                            <hr class="divider"></hr>
                        </div>
                        <div class="card-body">
                            棋牌游戏在DDoS方面是行业重灾区，攻击常达百G以上，而且攻击方式复杂多变，对于服务器端的攻击，应用层的攻击以及DNS攻击是防护难题。
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon8-1.png") }}" />
                            <img class="hover-icon" src="{{ asset("/images/program/icon8-2.png") }}" />
                            <h4 class="text">欺诈作弊</h4>
                            <hr class="divider"></hr>
                        </div>
                        <div class="card-body">
                            攻击者利用自动化工具，通过扫库撞库等方式进行盗号，破解游戏客户端程序，改变游戏数据，各种外挂程序，破坏游戏生态平衡。
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon9-1.png") }}" />
                            <img class="hover-icon" src="{{ asset("/images/program/icon9-2.png") }}" />
                            <h4 class="text">卡顿掉线</h4>
                            <hr class="divider"></hr>
                        </div>
                        <div class="card-body">
                            游戏是否能给玩家良好的用户体验，首先考虑的是游戏运行时的稳定性。因此对服务器配置、性能、网络带宽有很严格的要求，腾正科技云安全为您保障业务的持续可用性。
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <div class="cont">
                    <div class="arch-text">
                        <h4 style="font-size: 16px; font-family: 'pingFangBold'; margin-bottom: 15px;">架构说明</h4>
                        <p class="desc">
                            腾正科技棋牌游戏服务，从构建基础设施到游戏上线到后期精细化运营，腾正科技服务涵盖项目整个发展周期。在防御策略上采用三重防护设计，有效黑客入侵、预防恶意注册、流量作弊、撞库盗号、暴力破解、DDOS攻击、CC攻击、SYN攻击等，保障游戏交易平台及支付服务安全。
                        </p>
                        <a class="consult-btn text-center" href="javascript: void(0);">立即咨询</a>
                    </div>
                    <img class="arch-img" src="{{ asset("/images/program/chess-arch.png") }}" alt="棋牌云解决方案构架部署图" />
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">棋牌游戏服务优势</h2>
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>轻松应对DDoS攻击</span>
                            </div>
                            <div class="item-body">
                                <p style="word-break: break-all;">
                                    有效解决黑客控制僵尸网络对服务器发起的流量攻击，提供300Gbps以上的防御定制服务，支持HTTP/HTTPS/TCP/UDP，保障交易正常进行，高可用，高可信和高可靠。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>可信赖防御系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    有效防止黑客入侵，预防恶意注册、流量作弊、撞库盗号，暴力破解，保障游戏交易平台及支付服务安全。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>智能加速不卡顿</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    1000+节点网络分发服务，根据用户访问情况智能分配节点，大大提高用户访问网站的速度，解决因地域、带宽和服务器性能造成的访问瓶颈。游戏不卡顿，玩家更稳定。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>海量日志数据分析</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    启用简单日志服务对游戏日志进行存储查询，通过DPC整合日志数据到ODPS中，实现海量日志数据分析。为游戏云用户提供数据支撑。
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
