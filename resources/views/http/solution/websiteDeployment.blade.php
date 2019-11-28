@extends('layouts.layout')

@section('title', '网站部署方案-网站解决方案-CDN网站加速[腾正科技]')

@section('keywords', '网站部署解决方案,网站解决方案,CDN网站加速,网站服务器架构,网站服务器配置')

@section('description', '腾正科技网站部署解决方案，1V1专席客服从整体架构部署、主机配置选型、环境部署、数据迁移、测试、监控、安全防御、CDN网站加速、售后运维等提供一条龙服务，帮助用户解决疑难杂症，助用户无忧上云。')

@section('content')
<div class="tz-solution">
    <div class="tab">
        <a class="tab-item" href="/solution/game">游戏</a>
        <a class="tab-item" href="/solution/chess">棋牌</a>
        <a class="tab-item" href="/solution/finance">金融</a>
        <a class="tab-item" href="/solution/streaming_media">流媒体</a>
        <a class="tab-item" href="/solution/mobile_app">移动APP</a>
        <a class="tab-item" href="/solution/education_cloud">教育云</a>
        <a class="tab-item" href="/solution/government_cloud">政务云</a>
        <a class="tab-item active" href="/solution/website_deployment">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content">
        <!-- 网站部署 -->
        <div id="website-deployment">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">网站及部署解决解决方案</h2>
                    <h5 class="sub-text font-regular">
                        灵活弹性自动化的基础IT设施建设、 按需付费的服务模式以及0成本的运维IT服务体系<br/>
                        为企业及开发者用户量身构建从0到N的网站全生命周期一站式闭环服务
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">网站云面临的问题</h2>
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon26.png") }}" />
                            <span class="text">配置选型</span>
                        </div>
                        <div class="card-body">
                            <p>
                                如果用户已经拥有网站程序，那么就需要根据实际业务情况选择合适的云服务器，并在服务器上部署程序运行所需要的语言环境。如果用户初次使用云服务，那么如何选择CPU，硬盘，内存，带宽的大小就成为用户首先遇到的问题。
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon27.png") }}" />
                            <span class="text">安全隐患</span>
                        </div>
                        <div class="card-body">
                            <p>
                                网站部署OK后，如何规避网络攻击、网页内容被篡改，木马植入，数据库泄漏，黑客勒索等安全风险？如何保障网站安全稳定运行？如果自行搭建安全体系往往会让成本成倍的增长，而且很复杂。无疑给用户带来更大的成本以及时间压力。
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon28.png") }}" />
                            <span class="text">数据备份</span>
                        </div>
                        <div class="card-body">
                            <p>
                                随着网站的发展，积累的数据越来越多，比如静态文件（代码、图片等）和数据库数据。如果需要用户实时自行备份，那所花费的时间以及精力无疑也会成倍的增长。所以解决如何解决数据备份又是企业以及开发者面临的问题之一！
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon29.png") }}" />
                            <span class="text">I/O读写</span>
                        </div>
                        <div class="card-body">
                            <p>
                                大部分网站都属于交互型网站，速度快，能让多处理器的性能发挥出来。当前技术条件下，I/O是系统性能提高的瓶颈，I/O问题没有解决好，处理器数量增加不一定带来性能的提升，新增资源有可能被I/O全部消耗掉。
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/website-deployment-arch.png") }}"
                    alt="网站部署解决方案构架部署图" />
                    <div>
                        <p class="desc">
                            网站及部署解决方案为企业以及开发者用户实现灵活弹性自动化的基础IT设施建设、 按需付费的服务模式以及0成本的运维IT服务体系。
                            把传统的IDC数据中心改造成了一个高度简化、标准化、<br/>
                            自动化和弹性灵活的云数据中心。使得企业以及开发者的IT支撑系统从“成本中心”而转型成为推动企业核心业务不断发展的引擎。
                        </p>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">网站云服务优势</h2>
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>弹性扩展</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    当网站用户在面对云服务器配置选型的问题时，腾正科技针对网站用户个性的配置选择需求、同时可临时资源扩展的诉求，支持产品随时随地秒级扩展IT资源，轻松解决配置选型问题，高效便捷，节约成本。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>自带防御</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    随着互联网的发展，DDOS、CC攻击已成为非常普遍的攻击模式。网站安全稳定运行成为了每个用户的愿望！腾正科技网站解决方案，针对这一问题，各个已开放的节点自带默认防御峰值。真正从根本上解决网络安全问题，保护用户网站免受攻击威胁！
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>全景备份</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    针对网站用户面临的备份问题，腾正科技推出高效便捷的实时全景备份/全景恢复功能。用户可以自定义备份事件，通过控制台一键备份，使数据安全在得到最大的保证的同时，降低用户备份成本。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>1V1专席客服</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    网站用户上云前期面临多种多样的个性化问题，随时都需要有人来协助解如环境部署、数据迁移、售后运维等问题。但行业传统工单服务模式已被用户广为诟病，因此腾正进行改革创新，每个用户配备1名专席客服，在工作时间帮助用户解决疑难杂症。
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
