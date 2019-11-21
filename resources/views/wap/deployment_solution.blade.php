@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<!-- 网站及部署解决方案 -->

<div id="deployment_solution">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/网站及部署海报.png") }}" alt="">
                        <a class="posters-btn">立即咨询</a>
                    </div>
                    <div class="title">
                        <p>行业问题</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="industry-problems">
                        <div class="tz-main">
                            <ul class="clear">
                                <li class="m">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/配置选型.png") }}" alt="">
                                        <p>配置选型</p>
                                    </div>
                                    <p class="industry-text">用户上云，如何选择CPU,硬盘，内存，带宽的大小，环境部署成为用户首先遇到的问题。</p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img style="width: 22.6px;" src="{{ asset("/images/wap/安全隐患.png") }}" alt="">
                                        <p>安全隐患</p>
                                    </div>
                                    <p class="industry-text">如何规避攻击、篡改，数据库泄漏，黑客勒索等风险？无疑是用户更大的成本及时间压力。</p>
                                </li>
                                <li class="m">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/数据备份.png") }}" alt="">
                                        <p>数据备份</p>
                                    </div>
                                    <p class="industry-text">随着网站的发展，数据会越积越多，如果用户实时自行备份，则所花时间及精力无疑倍增。</p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img style="width: 24.5px;" src="{{ asset("/images/wap/IO读写速度-w.png") }}" alt="">
                                        <p>I/O读写</p>
                                    </div>
                                    <p class="industry-text">大部分站属交互型网站,故速度要快，而当前技术I/O是系统性能提高瓶颈，优化"读"性能。</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="architecture-deployment">
                        <div class="tz-main">
                            <div class="title">
                                <p>架构部署</p>
                                <div class="title-hr"></div>
                            </div>
                            <img src="{{ asset("/images/wap/网站及部署架构图.png") }}" alt="">
                            <div class="description">
                                <div class="description-title">架构说明</div>
                                <p>网站及部署解决方案为企业以及开发者用户实现灵活弹性自动化的基础IT设施建设、
                                    按需付费的服务模式以及0成本的运维IT服务体系。把传统的IDC数据中心改造成了一个高度简化、标准
                                    化、自动化和弹性灵活的云数据中心。使得企业以及开发者的IT支撑系统从“成本中心”而转型成为推动企业核心业务不断发展的引擎。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="service-advantages" style="z-index: 100;">
                        <div class="title">
                            <p>服务优势</p>
                            <div class="title-hr"></div>
                        </div>
                        <img src="{{ asset("/images/wap/网站及部署服务优势.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">弹性扩展</div>
                                    <div class="fuwu-txt">
                                        当网站用户在面对云服务器配置选型的问题时，腾正科技针对网站用户个性的配置选择需求、同时可临时资源扩展的诉求，支持产品随时随地秒级扩展IT资源，轻松解决配置选型问题，高效便捷，节约成本。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">全景备份</div>
                                    <div class="fuwu-txt">
                                        针对网站用户面临的备份问题，腾正科技推出高效便捷的实时全景备份/全景恢复功能。用户可以自定义备份事件，通过控制台一键备份，使数据安全在得到最大的保证的同时，降低用户备份成本。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">自带防御</div>
                                    <div class="fuwu-txt">
                                        随着互联网的发展，DDOS、CC攻击已成为非常普遍的攻击模式。网站安全稳定运行成为了每个用户的愿望！腾正科技网站解决方案，针对这一问题，各个以开放的节点自带默认防御峰值。真正从根本上解决网络安全问题，保护用户网站免受攻击威胁！
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">1V1专席客服</div>
                                    <div class="fuwu-txt">
                                        网站用户上云前期面临多种多样的个性化问题，随时都需要有人来协助解如环境部署、数据迁移、售后运维等问题。但行业传统工单服务模式已被用户广为诟病，因此腾正进行改革创新，每个用户配备1名专席客服，在工作时间帮助用户解决疑难杂症。
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="solutions-consulting">
                        <img src="{{ asset("/images/wap/蓝条.png") }}" alt="">
                        <a>
                            立即咨询
                        </a>
                    </div> -->

                </div>
            </div>
        </div>
    </div>

@endsection
