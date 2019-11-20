@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 移动APP云解决方案 -->

<div id="mobileapp_solution">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/移动云海报.png") }}" alt="">
                        <a class="posters-btn">立即咨询</a>
                    </div>
                    <div class="title">
                        <p>行业问题</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="industry-problems">
                        <!-- 轮播 -->
                        <div class="slideshow">
                            <ul class="slideshow-ul clear">
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/营销推广困难.png") }}" alt="">
                                    <div>营销推广困难</div>
                                    <p>移动APP推广比较难，用户下载量少，留存率低；如何提高下载量及留存率便成为每个移动应用开发企业关注的核心问题。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/投入大迭代快.png") }}" alt="">
                                    <div>投入大迭代快</div>
                                    <p>开发一款APP，团队需要统筹各个环节，资源投入要求高，开发效率难以保障，需要保障质量的同时，缩短上线及迭代周期。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/卡顿掉线.png") }}" alt="">
                                    <div>运营分析能力</div>
                                    <p>终端的种类多，适配量大；数据分散；综合性能和用户体验等问题是移动APP从开发到上线需要一直关注并且迭代改进。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/峰值访问量大moild.png") }}" alt="">
                                    <div>峰值访问量大</div>
                                    <p>业务受影响因素较多，访问量存在极大不确定性，既要保证业务可用性及高峰期的扩展性，又要避免资源浪费。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/体验难以保障.png") }}" alt="">
                                    <div>体验难以保障</div>
                                    <p>用户地域分布范围不确定，业务迅猛发展使流量分发存在瓶颈，需要覆盖全国的优质网络，来支撑良好的接入体验。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/数据安全风险moild.png") }}" alt="">
                                    <div>数据安全风险</div>
                                    <p>APP的运营过程会受到来自各方面的安全挑战，如DDoS攻击、病毒、木马等，严重威胁业务运营和数据信息安全。</p>
                                </li>
                            </ul>
                            <!-- 点 -->
                            <div class="point">
                                <ol class="clear slideshow-ol">
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="architecture-deployment">
                        <div class="tz-main">
                            <div class="title">
                                <p>架构部署</p>
                                <div class="title-hr"></div>
                            </div>
                            <img src="{{ asset("/images/wap/移动云架构图.png") }}" alt="">
                            <div class="description">
                                <div class="description-title">架构说明</div>
                                <p>在IT架构层面将不同功能模块，利用云服务器弹性扩展和负载均衡功能，随时增减云服务器。同时增加缓存服务器、数据库读写分离、轻松应对海量玩家同时在线。在资源上，腾正科技应用业内领先的双线高防节点以及国内优质的BGP多线网络资源，隐藏源站真实IP，解决抵御跨线问题，为用户全面打造稳如磐石的游戏解决方案。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="service-advantages" style="z-index: 100;">
                        <div class="title">
                            <p>服务优势</p>
                            <div class="title-hr"></div>
                        </div>
                        <img src="{{ asset("/images/wap/移动云服务优势.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">集群管理系统</div>
                                    <div class="fuwu-txt">防入侵监测系统，硬件监控系统，网络故障分析平台，数据灾备系统，保障服务器在安全的环境下运行。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">万兆带宽接入</div>
                                    <div class="fuwu-txt">采用万兆网络接入,多个CC防护集群组合，建立高效的CC攻击防护基础，满足各种类型移动APP用户运营需求。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">总出口达10T</div>
                                    <div class="fuwu-txt">海量机柜，数据中心覆盖全国，总出口规模达到10T，带宽资源充足,随时升级G口带宽,轻松满足顾客的扩展需求。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">CDN智能加速</div>
                                    <div class="fuwu-txt">自主CDN加速1000+节点网络分发服务，应对APP大量内容分发，解决地域、带宽和服务器性能造成的访问瓶颈。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">冗余机制完善</div>
                                    <div class="fuwu-txt">在设备、节点和网络三个层面上实现了完善的冗余，保证在设备或节点出现故障时，不会影响用户的正常访问。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">弹性增值服务</div>
                                    <div class="fuwu-txt">简单易用弹性云主机，海量存储，灵活部署，一对一专属客服售前咨询服务和售后跟踪服务，全面解决疑问。</div>
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
