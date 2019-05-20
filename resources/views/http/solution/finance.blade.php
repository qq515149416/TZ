@extends('layouts.layout')

@section('title', '游戏云解决方案-游戏服务器架构-CDN游戏加速[腾正科技]')

@section('keywords', '游戏云解决方案,游戏云面临问题,游戏云架构部署,游戏服务器,游戏服务器架构，CDN游戏加速')

@section('description', '腾正科技游戏云解决方案，利用云服务器弹性扩展、负载均衡功能、自研高防御系统及CDN加速，打造虚拟化、高可用的游戏集群，解决游戏客户运行卡顿、掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题。')

@section('content')
<div class="tz-solution">
    <div class="tab">
        <a class="tab-item" href="/solution/game">游戏</a>
        <a class="tab-item" href="/solution/chess">棋牌</a>
        <a class="tab-item active" href="/solution/finance">金融</a>
        <a class="tab-item" href="/solution/streaming_media">流媒体</a>
        <a class="tab-item" href="/solution/mobile_app">移动APP</a>
        <a class="tab-item" href="/solution/education_cloud">教育云</a>
        <a class="tab-item" href="/solution/government_cloud">政务云</a>
        <a class="tab-item" href="/solution/website_deployment">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content">
        <!-- 金融云 -->
        <div id="finance">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">金融云解决方案</h2>
                    <h5 class="sub-text">
                        个性化定制高防金融云解决方案，一站式服务解决金融行业互联互通、海量访问、数据安全、网页加速、成本高等问题，
                        <br/>
                        助您快速实现业务部署，抢占市场先机
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">金融云面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon10.png") }}" />
                            <span class="text">互联互通</span>
                        </div>
                        <div class="card-body">
                            <p>各金融体系、机构的数据标准、接口等有待进一步统一，以便提供更便捷的数据交换和处理；而现实是通常多机构多种标准或接口，系统整合难度大。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon3.png") }}" />
                            <span class="text">数据量大</span>
                        </div>
                        <div class="card-body">
                            <p>
                                在国外，银行客户数或账户数超过千万就属于型银行，相当于我国四大银行一些省级分行数据，而中国工行2002年完成的数据集中工程有3亿多账户。数据量太大，其存储和处理给IT带来了很大挑战。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon4.png") }}" />
                            <span class="text">数据的安全性</span>
                        </div>
                        <div class="card-body">
                            <p>金融领域对于数据安全以及用户隐私保护的需求要比其他任何行业要求都高。金融行业是具体管钱的行业，客户的隐私、企业的数据安全、产品安全等等都尤其重要。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon6.png") }}" />
                            <span class="text">成本过高</span>
                        </div>
                        <div class="card-body">
                            <p>金融体系、机构整合云端面临技术投入大，成本高，不灵活，运维难度大，交付周期长等一系列问题，使中小企业望而却步，错失市场商机。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title" style="color: #fff;">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/white-rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/finance-arch.png") }}" alt="金融云解决方案构架部署图" />
                    <div>
                        <p class="desc" style="color: #fff;">
                            金融云微金融解决方案为P2P、小贷、典当、担保、众筹等小微金融企业提供定制个性化的云计算服务。互联网微金融用户也能享有金融级的安全保障；海量计算、弹性部署能解决互联网业务
                            <br/>
                            的海量并发问题，同时大幅降低初创企业IT成本。此外，腾正科技联手合作伙伴共同打造微金融生态链，提供一站式解决方案平台。在整个产品选择和设计上，腾正科技努力为金融用户创造
                            <br/>
                            一个安全可靠的运行环境，并为用户提供一支可信赖的技术运维支持团队，可以帮助客户完成从前期规划、实施、应用迁移，到后期运维每一阶段的工作，为金融行业持续发展做出贡献。
                        </p>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">金融云服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>双重防御系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    腾正科技与金盾联合打造双重防火墙设计，有<br/>
                                    效对抗DDOS攻击，CC攻击，WAF攻击等。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>近源分流防护</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    采用智能分发平台，按照近源防护原则，提升<br/>
                                    网站数据加载和传输速度，减少单点防护的压<br/>
                                    力，更好的保证了防护效果和网民体验度。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>BGP多线线路</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    腾正科技为金融云用户提供BGP多线专线线<br/>
                                    路，由网络上的骨干路由器根据路由跳数与其它<br/>
                                    技术指标来确定的最佳访问路由，不占用服务器<br/>
                                    的任何系统资源，能真正实现高速的单IP访问。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>集群技术管理</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    腾正科技服务器基于集群技术，实现多节点共<br/>
                                    同参与计算，自动并行处理并负载均衡，轻松<br/>
                                    应对硬件故障问题。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-5.png") }}" alt="adv5" />
                                <span>自动清洗系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    10T+防御带宽，配备T量级超强硬件清洗平<br/>
                                    台，高达480G的防御能力，独立过滤CC的<br/>
                                    功能，可满足金融行业对网络安全方面的需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-6.png") }}" alt="adv6" />
                                <span>低成本高性能</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    随着机房的扩容以及业务的不断增加，信息管<br/>
                                    理系统的操作也随之变得更加复杂。腾正科技<br/>
                                    为用户研发了灵活易用的用户管理中心，让用<br/>
                                    户简单便捷灵活地管理自己业务。
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