@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 政务云解决方案 -->

<div id="government_solution">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/政务云海报.png") }}" alt="">
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
                                        <img src="{{ asset("/images/wap/ISV开发力不足.png") }}" alt="">
                                        <p>ISV开发力不足</p>
                                    </div>
                                    <p class="industry-text">对于应用软件源代码安全风险意识不足；容易导致Web应用系统存在安全漏洞。</p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/缺纵深防御体系.png") }}" alt="">
                                        <p>缺纵深防御体系</p>
                                    </div>
                                    <p class="industry-text">黑客攻击手法也非常多样化；而传统安全防护手段强调单点防护，缺乏纵深防御体系支撑。</p>
                                </li>
                                <li class="m">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/威胁检测能力弱 .png") }}" alt="">
                                        <p>威胁检测能力弱 </p>
                                    </div>
                                    <p class="industry-text">传统安防设备基于静态策略及已知特征进行“黑白名单”规则匹配，无法应对复杂Web攻击。</p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/持续监控能力差 .png") }}" alt="">
                                        <p>持续监控能力差 </p>
                                    </div>
                                    <p class="industry-text">部分政务单位具一定的安全能力，但缺乏整体持续监控能力；而在攻击时代，显然力不从心。</p>
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
                            <img src="{{ asset("/images/wap/政务云架构图.png") }}" alt="">
                            <div class="description">
                                <div class="description-title">架构说明</div>
                                <div>典型政务应用安全架构</div>
                                <p>腾正政务云专属客户，只需开通云资源服务，便可免费获得以下标配的多项高等级安全能力 标配的高等级安全能力 </p>
                                <div>标配的高等级安全能力</div>
                                <p>主机安全防御能力 Web安全防御能力 DDoS攻击防御能力 </p>
                                <div>多项增值安全服务内容选择</div>
                                <p>1.支持标配安全产品能力升级</p>
                                <p>2.提供多项安全审计产品选择</p>
                                <p>3.右击结合第三方安全产品</p>
                            </div>
                        </div>
                    </div>
                    <div class="service-advantages" style="z-index: 100;">
                        <div class="title">
                            <p>服务优势</p>
                            <div class="title-hr"></div>
                        </div>
                        <img src="{{ asset("/images/wap/政务云服务优势.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">满足政府监管单位的合规要求</div>
                                    <div class="fuwu-txt">
                                        腾正科技为东莞电子政务搭建的云平台涵盖IaaS层、PaaS层、DaaS层、SaaS层、安全体系、运维服务体系。有效的整合了已有资源，初步实现了全市政务信息化的统一管理。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">多层安全体系保障政务云安全</div>
                                    <div class="fuwu-txt">
                                        平台具备独特产品架构，兼容多种品牌服务器，通过应用安全、系统安全、数据安全、网络安全全方位控制，建立完备的安全体系，达到安全稳定服务高效便捷管理目的，有效提升东莞政务工作效率。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">弹性资源按需分配成本更低</div>
                                    <div class="fuwu-txt">IT硬件零投入，云设施零维护量，随时按需开通、释放资源，快速满足不同时期政务业务需求，有效降低了政务成本。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">全生命周期一条龙服务支撑</div>
                                    <div class="fuwu-txt">专业的服务团队一对一专属架构师提供从上云培训、认证服务，到上云专业服务及云上保障服务，全面保障政务云平台数据信息安全。
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
