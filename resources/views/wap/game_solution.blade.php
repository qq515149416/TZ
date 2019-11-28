@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<!-- 游戏云解决方案 -->

<div id="game_solution">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/游戏云海报.png") }}" alt="">
                        <a class="posters-btn">立即咨询</a>
                    </div>
                    <div class="title">
                        <p>行业问题</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="industry-problems">
                        <div class="tz-main">
                            <ul class="clear">
                                <li class="m p">
                                    <div class="industry-title m-b">
                                        <img src="{{ asset("/images/wap/计算性能不够.png") }}" alt="">
                                        <p>计算性能不够，游戏卡顿？</p>
                                    </div>
                                    <p class="industry-text"><span></span>百万级PPS的云服务器</p>
                                    <p class="industry-text"><span></span>资源独享的专属机</p>
                                    <p class="industry-text"><span></span>超高性能的物理机</p>

                                </li>
                                <li class="p">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/网络不稳定.png") }}" alt="">
                                        <p>网络不稳定，玩家掉线？</p>
                                    </div>
                                    <p class="industry-text"><span></span>资源充足，多线路组合</p>
                                    <p class="industry-text"><span></span>万兆冗余内网，无单点</p>
                                    <p class="industry-text"><span></span>高性能的外网共享带宽</p>

                                </li>
                                <li class="m p">
                                    <div class="industry-title">
                                        <img  src="{{ asset("/images/wap/数据量大.png") }}" alt="">
                                        <p>游戏大推，大量玩家访问？</p>
                                    </div>
                                    <p class="industry-text"><span></span>20+万IOPS高性能磁盘</p>
                                    <p class="industry-text"><span></span>数万IOPS高可靠云磁盘</p>
                                    <p class="industry-text"><span></span>极致性能缓存、数据库</p>

                                </li>
                                <li class="p">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/数据安全性.png") }}" alt="">
                                        <p>游戏安全，如何保障？</p>
                                    </div>
                                    <p class="industry-text"><span></span>高防抗D服务</p>
                                    <p class="industry-text"><span></span>HTTPS加密负载均衡</p>
                                    <p class="industry-text"><span></span>VPN/专线数据传输</p>
                                </li>
                                <li class="m p">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/单点故障处理.png") }}" alt="">
                                        <p>游戏服，监控及故障恢复？</p>
                                    </div>
                                    <p class="industry-text"><span></span>用户自定义报警</p>
                                    <p class="industry-text"><span></span>云服务器秒级热迁移</p>
                                    <p class="industry-text"><span></span>宕机，游戏分钟恢复</p>
                                </li>
                                <li class="p">
                                    <div class="industry-title m-b">
                                        <img src="{{ asset("/images/wap/成本过高.png") }}" alt="">
                                        <p>游戏有要求全国同服？</p>
                                    </div>
                                    <p class="industry-text"><span></span>多地区主句中心</p>
                                    <p class="industry-text"><span></span>机房内网T级传输带宽</p>
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
                            <img src="{{ asset("/images/wap/游戏云架构图.png") }}" alt="">
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
                        <img src="{{ asset("/images/wap/游戏云优势.png") }}" alt="">
                        <img class="backgroundimg" style="top: 0px !important;"
                            src="{{ asset("/images/wap/游戏云优势背景.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">自动DDoS清洗系统</div>
                                    <div class="fuwu-txt">
                                        10T+防御带宽,T量级超强硬件清洗平台,抵御不同类型DDoS、CC等攻击,满足游戏客户对网络安全方面的需求。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">游戏更新智能分发</div>
                                    <div class="fuwu-txt">
                                        开放存储服务与内容分发网络服务结合 ，可实现游戏升级更新包与客户端高速、低成本的分发与加速。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">游戏体验畅通无阻</div>
                                    <div class="fuwu-txt">
                                        通过DPC整合日志数据到ODPS中，实现海量日志存储查询、数据分析，为游戏云用户提供数据支撑。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">海量游戏日志存储</div>
                                    <div class="fuwu-txt">
                                        开放存储服务与内容分发网络服务结合，可实现游戏升级更新包与客户端高速、低成本的分发与加速。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">负载均衡平滑拓展</div>
                                    <div class="fuwu-txt">
                                        运营过程中,可根据用户量随时增加或合并服务器，利用负载均衡，自动分配用户流量，满足服务器平滑扩展需求。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">操作简便一键完成</div>
                                    <div class="fuwu-txt">
                                        支持多种架构的游戏用户，手游，页游，端游一键部署,轻松搞定。
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
    <script>
    if(document.body.clientWidth<330){
        for(var i=0;i<document.querySelectorAll(".p").length;i++){
            document.querySelectorAll(".p")[i].style.height="183px";
        }
        
    }
</script>
@endsection
