@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 金融云解决方案 -->
<div id="financial_solution">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/金融云海报.png") }}" alt="">
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
                                        <img src="{{ asset("/images/wap/互联互通.png") }}" alt="">
                                        <p>互联互通</p>
                                    </div>
                                    <p class="industry-text">各金融体系、机构的数据标准、接口存在多机构多标准状态，系统整合统一难度系数大。 </p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/数据量大.png") }}" alt="">
                                        <p>数据量大</p>
                                    </div>
                                    <p class="industry-text">银行数据庞大，仅工行2002年完成的数据有3亿多账户，其存储处理给IT带来了很大挑战。 </p>
                                </li>
                                <li class="m">
                                    <div class="industry-title">
                                        <img style="width: 18.5px;" src="{{ asset("/images/wap/数据安全性.png") }}"
                                            alt="">
                                        <p>数据的安全性</p>
                                    </div>
                                    <p class="industry-text">金融领域对数据安全及用户隐私保护需求比其他任何行业要求都高，安全是重点选择要素。 </p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img style="width: 21.2px;" src="{{ asset("/images/wap/成本过高.png") }}"
                                            alt="">
                                        <p>成本过高</p>
                                    </div>
                                    <p class="industry-text">金融体系、机构整合云端面临技术投入大，不灵活，运维难度大，交付周期长等成本问题。 </p>
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
                            <img src="{{ asset("/images/wap/金融云架构图.png") }}" alt="">
                            <div class="description">
                                <div class="description-title">架构说明</div>
                                <p>金融云微金融解决方案为银行、证券、P2P、小贷、典当、众筹等金融企业提供个性化定制的高防御、智能CDN加速金融云解决方案，一站式解决金融行业互联互通、海量访问、数据安全、网页加速、成本高等问题。帮助客户完成从前期计划、实施、应用迁移，到后期运维每一阶段的工作，共同打造稳定安全的微金融生态链。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="service-advantages" style="z-index: 100;">
                        <div class="title">
                            <p>服务优势</p>
                            <div class="title-hr"></div>
                        </div>
                        <img src="{{ asset("/images/wap/金融云服务优势.png") }}" alt="">
                        <img class="backgroundimg" src="{{ asset("/images/wap/金融云优势背景.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">双重防御系统</div>
                                    <div class="fuwu-txt">腾正科技与金盾联合打造双重防火墙的设计，能有效对抗DDOS攻击，CC攻击，WAF攻击等。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">近源分流防护</div>
                                    <div class="fuwu-txt">采用智能分发近源防护原则，提升网站数据加载和传输速度，减少单点防护压力，确保了防护效果和网民体验度。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">自动清洗系统</div>
                                    <div class="fuwu-txt">10T+防御带宽,T量级超强硬件清洗平台，高达480G的防御能力，独立过滤CC功能，确保金融行业网络安全需求。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">BGP多线线路</div>
                                    <div class="fuwu-txt">提供BGP多线专线线路,骨干路由器根据路由跳数与其它技术指标来确定最佳访问路由，真正实现高速的单IP访问。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">集群技术管理</div>
                                    <div class="fuwu-txt">腾正科技服务器基于集群技术，实现多节点共同参与计算，自动并行处理并负载均衡，轻松应对硬件故障问题。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">低成本高性能</div>
                                    <div class="fuwu-txt">灵活易用的用户管理中心,可随业务需求随时弹性扩容,让用户对自己业务态势一目了然，实现快速业务管理分析。</div>
                                </li>
                            </ul>
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
    </div>

@endsection
