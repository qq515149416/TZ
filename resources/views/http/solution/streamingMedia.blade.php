@extends('layouts.layout')

@section('title', '流媒体解决方案-流媒体服务器架构-流媒体加速CDN[腾正科技]')

@section('keywords', '流媒体解决方案,流媒体服务器架构,流媒体存储方案，流媒体架构部署,流媒体加速CDN')

@section('description', '腾正科技流媒体解决方案基于大规模实时流媒体计算集群和强大的音视频信号处理算法+企业级固态硬盘（SSD）+自研高防御系统+CDN加速，打造"清晰流畅、低时延、高并发"流媒体服务。')

@section('content')
<div class="tz-solution">
    <div class="tab">
        <a class="tab-item" href="/solution/game">游戏</a>
        <a class="tab-item" href="/solution/chess">棋牌</a>
        <a class="tab-item" href="/solution/finance">金融</a>
        <a class="tab-item active" href="/solution/streaming_media">流媒体</a>
        <a class="tab-item" href="/solution/mobile_app">移动APP</a>
        <a class="tab-item" href="/solution/education_cloud">教育云</a>
        <a class="tab-item" href="/solution/government_cloud">政务云</a>
        <a class="tab-item" href="/solution/website_deployment">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content">
        <!-- 流媒体 -->
        <div id="streaming-media">
            <!-- banner -->
            <div class="banner">
                <div class="title">
                    <h2 class="text">流媒体解决方案</h2>
                    <h5 class="sub-text">
                        个性化打造"清晰流畅、低时延、高并发"的流媒体服务，自研高性能防火墙确保数据安全，自主CDN加速<br/>
                        缩短用户等待时间，增强了用户体验质量和对内容提供商的黏度
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">流媒体面临的问题</h2>
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon11.png") }}" />
                            <span class="text">峰值访问量大</span>
                        </div>
                        <div class="card-body">
                            <p>业务受影响因素较多，访问量存在极大不确定性，既要保证业务可用性，应对业务高峰做到及时扩展，又要避免资源浪费，实现以最优配置，产出最大化效益。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon5.png") }}" />
                            <span class="text">单点故障处理</span>
                        </div>
                        <div class="card-body">
                            <p>流媒体服务器的负载比其它应用服务器更大，单台服务器无法满足高并发量。如何实现负载均衡，高可用架构，分担流媒体服务器的负荷，消除单点故障是一个运营难题。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon12.png") }}" />
                            <span class="text">I/O读写速度</span>
                        </div>
                        <div class="card-body">
                            <p>
                                流媒体最重要的因素是速度要快，所以必须优化磁盘的"读"性能。而当前技术条件I/O是系统性能提高瓶颈，I/O问题没解决好，处理器数量增加不一定带来性能的提升，新增资源可能被I/O全部耗掉。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon4.png") }}" />
                            <span class="text">数据安全风险</span>
                        </div>
                        <div class="card-body">
                            <p>流媒体平台客户的隐私、企业的数据安全、产品安全等等都尤其重要，一旦被DDoS攻击、病毒、木马等，其业务运营和数据信息将受到严重的安全威胁。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/streaming-media-arch.png") }}"
                    alt="流媒体解决方案构架部署图" />
                    <div>
                        <p class="desc" style="color: #fff;">
                            流媒体对宽带要求比较苛刻，下载速率必须达到解码率否则流媒体会出现卡断。磁盘I/O速率对流媒体也是至关重要的，流媒体主要是通过数据传输完成的。由于流媒体服务器的负载比其它应用<br/>
                            服务器更大，单台服务器可能无法满足高并发量。腾正科技流媒体解决方案基于大规模实时流媒体计算集群和强大的音视频信号处理算法，采用企业级的固态硬盘（SSD）提升了数据的读写速度，<br/>
                            打造"清晰流畅、低时延、高并发"的音视频直播服务。
                        </p>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">流媒体云服务优势</h2>
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>企业级的固态硬盘</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    硬盘输出性能对流媒体点播是至关重要的因素，所以必须优化硬盘"读写"性能。腾正采用企业级固态硬盘（SSD），提高了数据I/O读写速度。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>集群消除单点故障</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    自有机房自组内网，搭建负载均衡，高可用架构，分担流媒体服务器的负荷，消除单点故障，提升了流媒体服务的稳定性和可靠性。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>负载均衡平滑拓展</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    流媒体运营过程中，可根据用户量随时增加或者合并服务器，利用负载均衡，自动分配用户流量，满足服务器平滑扩展需求。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>优质宽带质量接入</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    全国骨干网6大核心交换节点，优质骨干网接入，提高线路访问速度，解决延迟、丢包现象，满足各种类型流媒体用户运营需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-5.png") }}" alt="adv5" />
                                <span>CDN智能分发服务</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    自主CDN加速1000+节点网络分发服务，解决因地域、带宽和服务器性能造成的访问瓶颈，提升网站高并发访问时数据加载和传输速度。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-6.png") }}" alt="adv6" />
                                <span>多层安全体系保障</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    提供高防DDos服务，Web应用防护、入侵检测、Web漏洞扫描服务，支持服务器、数据库自动备份及秒级回档功能，降低企业运营风险。
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
