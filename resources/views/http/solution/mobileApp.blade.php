@extends('layouts.layout')

@section('title', '游戏云解决方案-游戏服务器架构-CDN游戏加速[腾正科技]')

@section('keywords', '游戏云解决方案,游戏云面临问题,游戏云架构部署,游戏服务器,游戏服务器架构，CDN游戏加速')

@section('description', '腾正科技游戏云解决方案，利用云服务器弹性扩展、负载均衡功能、自研高防御系统及CDN加速，打造虚拟化、高可用的游戏集群，解决游戏客户运行卡顿、掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题。')

@section('content')
<div class="tz-solution">
    <div class="tab">
        <a class="tab-item" href="/solution/game">游戏</a>
        <a class="tab-item" href="/solution/chess">棋牌</a>
        <a class="tab-item" href="/solution/finance">金融</a>
        <a class="tab-item" href="/solution/streaming_media">流媒体</a>
        <a class="tab-item active" href="/solution/mobile_app">移动APP</a>
        <a class="tab-item" href="/solution/education_cloud">教育云</a>
        <a class="tab-item" href="/solution/government_cloud">政务云</a>
        <a class="tab-item" href="/solution/website_deployment">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content">
        <!-- 移动APP -->
        <div id="mobile-app">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">移动APP云化解决方案</h2>
                    <h5 class="sub-text">
                        高效开发快速上云，助力业务快速发展！腾正科技旨在为开发者提供模块功能化的通用移动应用基础服务，<br/>
                        解决移动APP客户营销困难、高并发、数据安全调度不精准等难题
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">移动APP面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon13.png") }}" />
                            <h5 class="text">营销推广困难</h5>
                        </div>
                        <div class="card-body">
                            <p>移动APP推广难，用户下载量少，留存率低；如何提高下载量及留存率成为每个移动应用开发企业关注的核心问题</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon14.png") }}" />
                            <h5 class="text">投入大迭代快</h5>
                        </div>
                        <div class="card-body">
                            <p>开发一款APP，团队需统筹处理各个环节，资源投入要求高，开发效率难保障，企业需保障产品质量的同时，缩短上线及迭代周期</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon15.png") }}" />
                            <h5 class="text">运营分析能力</h5>
                        </div>
                        <div class="card-body">
                            <p>终端种类多，适配量大；数据呈现分散；综合性能、用户体验等问题是移动APP产品从开发到上线需要一直关注并迭代改进
                            <p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon16.png") }}" />
                            <h5 class="text">峰值访问量大</h5>
                        </div>
                        <div class="card-body">
                            <p>业务受影响因素较多，访问量存在极大不确定性，既要保证业务可用性，应对业务高峰做到及时扩展，又要避免资源浪费</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon17.png") }}" />
                            <h5 class="text">体验难以保障</h5>
                        </div>
                        <div class="card-body">
                            <p>用户地域分布范围不确定，业务迅猛发展使流量分发存在瓶颈，需要覆盖全国的优质网络，来支撑良好的接入体验</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon18.png") }}" />
                            <h5 class="text">数据安全风险</h5>
                        </div>
                        <div class="card-body">
                            <p>APP的运营过程会受到来自各方面的安全挑战，如DDoS攻击、病毒、木马等，严重威胁业务运营和数据信息安全</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/mobile-app-arch.png") }}"
                    alt="移动APP解决方案构架部署图" />
                    <div style="position: absolute; bottom: -30px; right: 40px;">
                        <p class="desc">
                            APP业务上线初期，时刻会面临用户爆炸式增长情况，访问量存在极大不确定性，使用腾正云服务，可根据业务需求和策略，自动计算资源<br/>
                            弹性调整应对流量波峰，为用户提供流畅的网络体验。在防御策略上采用三重防护设计，有效黑客入侵、预防恶意注册、流量作弊、撞库盗号、<br/>
                            暴力破解、DDOS攻击、CC攻击、SYN攻击等，保障平台数据信息及支付服务安全。
                        </p>
                        <br/>
                        <a class="consult-btn" style="float: right;" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">移动APP服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>集群管理系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    防入侵监测系统，硬件监控系统，网络故障分析平台，数据灾备系统，保障服务器在安全的环境下运行。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>万兆带宽接入</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    采用万兆网络接入，多个CC防护集群组合，建立高效的CC攻击防护基础，满足各种类型的移动APP用户运营需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>总出口达10T</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    海量机柜，数据中心覆盖全国，总出口规模达到10T，带宽资源充足，随时升级G口带宽，轻松满足顾客的扩展需求。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>CDN智能加速</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    自主CDN加速1000+节点网络分发服务，应对APP大量内容分发，随需使用，经济高效，解决因地域、带宽和服务器性能造成的访问瓶颈。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-5.png") }}" alt="adv5" />
                                <span>冗余机制完善</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    在设备、节点和网络三个层面上实现了完善的冗余，保证在设备或节点出现故障时，不会影响用户的正常访问。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-6.png") }}" alt="adv6" />
                                <span>弹性增值服务</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    简单易用弹性云主机，海量存储，灵活部署，一对一专属客服售前咨询服务和售后跟踪服务，全面解决疑问。
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