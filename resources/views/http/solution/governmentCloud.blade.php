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
        <a class="tab-item" href="/solution/mobile_app">移动APP</a>
        <a class="tab-item" href="/solution/education_cloud">教育云</a>
        <a class="tab-item active" href="/solution/government_cloud">政务云</a>
        <a class="tab-item" href="/solution/website_deployment">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content">
        <!-- 政务云 -->
        <div id="government-cloud">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">政务云安全解决方案</h2>
                    <h5 class="sub-text">
                        基于政务应用系统的综合安全防御需求，一站式解决系统利用率低、能源消耗高、各政务系统相互隔离、安全性能差等核心问题<br/>
                        构建安全、合规、互访、可靠的绿色政务云平台
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">政务云面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon23.png") }}" />
                            <span class="text">ISV安全开发能力不足</span>
                        </div>
                        <div class="card-body">
                            <p>对于应用软件源代码安全风险意识不足；容易导致Web应用系统存在安全漏洞。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon24.png") }}" />
                            <span class="text">缺乏纵深防御体系</span>
                        </div>
                        <div class="card-body">
                            <p>黑客攻击手法也非常多样化；而传统安全防护手段强调单点防护，缺乏纵深防御体系支撑。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon11.png") }}" />
                            <span class="text">缺乏未知威胁检测能力</span>
                        </div>
                        <div class="card-body">
                            <p>传统安全防护设备均基于静态策略及已知特征进行“黑白名单”式的规则匹配，无法应对复杂Web攻击。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon25.png") }}" />
                            <span class="text">缺乏整体持续监控能力</span>
                        </div>
                        <div class="card-body">
                            <p>部分政务单位具有一定的安全能力，但缺乏整体的持续监控能力；而在持续攻击时代，显然有些力不从心。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title" style="color: #fff;">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/white-rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/government-cloud-arch.png") }}"
                    alt="政务云解决方案构架部署图" />
                    <div style="max-width: 1180px; margin: 0 auto; text-align: center;">
                        <div class="desc">
                            <div style="display: inline-block;">
                                <h5 style="font-weight: 600;">多项增值安全服务内容选择</h5>
                                <p>1.支持标配安全产品能力升级</p>
                                <p>2.提供多项安全审计产品选择</p>
                                <p>3.有机结合第三方安全产品</p>
                            </div>
                            <div style="display: inline-block; margin-left: 80px;">
                                <h5 style="font-weight: 600;">典型政务应用安全架构</h5>
                                <p>腾正政务云专属客户，只需开通云资源服务，便可免费获得以下标配的多项高等级安全能力</p>
                                <p style="font-weight: 600;">标配的高等级安全能力</p>
                                <p>主机安全防御能力Web安全防御能力DDoS攻击防御能力</p>
                            </div>
                        </div>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">政务云服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>满足政府监管单位的合规要求</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    腾正科技为东莞电子政务搭建的云平台涵盖IaaS层、PaaS层、DaaS层、SaaS层（包括云盘文控、政务网信息监查平台、统一门户平台、市政信息推送平台）、安全体系、运维服务体系。有效的整合了已有资源，初步实现了全市政务信息化的统一管理。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>弹性资源按需分配成本更低</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    IT硬件零投入，云设施零维护量，随时按需开通、释放资源，快速敏捷满足不同时期政务业务需求，有效降低了政务成本。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>多层安全体系保障政务云安全</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    平台具备独特的产品架构，兼容多种品牌的服务器，通过应用安全、系统安全、数据安全、网络安全全方位控制，建立一套完备的安全体系，达到安全稳定服务高效有序便捷的管理目的，有效提升东莞政务工作效率。 </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>全生命周期一条龙服务支撑</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    专业的服务团队一对一专属架构师提供从上云培训、认证服务，到上云专业服务及云上保障服务，全面保障政务云平台数据信息安全。
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