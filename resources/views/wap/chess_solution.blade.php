@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<!-- 棋牌云解决方案 -->

<div id="chess_solution">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/棋牌云海报.png") }}" alt="">
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
                            <img src="{{ asset("/images/wap/棋牌云架构图.png") }}" alt="">
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
                        <img src="{{ asset("/images/wap/棋牌云服务优势.png") }}" alt="">
                        <img class="backgroundimg" style="top: 0px !important; left: 0;"
                            src="{{ asset("/images/wap/棋牌云优势背景.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">轻松应对DDoS攻击</div>
                                    <div class="fuwu-txt">有效解决黑客控制僵尸网络对服务器发起的流量攻击，提供300Gbps以上防御服务,支持HTTP/HTTPS/TCP/UDP。
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">可信赖防御系统</div>
                                    <div class="fuwu-txt">有效防止黑客入侵，预防恶意注册、流量作弊、撞库盗号，暴力破解，保障游戏交易平台及支付服务安全。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">智能加速不卡顿</div>
                                    <div class="fuwu-txt">1000+高质网络节点,提高用户访问速度,解决地域、带宽和服务器性能造成的访问瓶颈。游戏不卡顿,玩家更稳定。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">海量日志数据分析</div>
                                    <div class="fuwu-txt">通过DPC整合日志数据到ODPS中，实现海量日志存储查询、数据分析，为游戏云用户提供数据支撑。</div>
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
