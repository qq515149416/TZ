@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 流媒体解决方案 -->

<div id="media_solution">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/流媒体海报.png") }}" alt="">
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
                                        <img src="{{ asset("/images/wap/峰值访问量大.png") }}" alt="">
                                        <p>峰值访问量大</p>
                                    </div>
                                    <p class="industry-text">业务特性，访问量存在不确定性，既要保证业务可用性，又要避免资源浪费，最大化效益。</p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/单点故障处理.png") }}" alt="">
                                        <p>单点故障处理</p>
                                    </div>
                                    <p class="industry-text">业务特性，访问量存在不确定性，既要保证业务可用性，又要避免资源浪费，最大化效益。</p>
                                </li>
                                <li class="m">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/IO读写速度.png") }}" alt="">
                                        <p>I/O读写速度</p>
                                    </div>
                                    <p class="industry-text">流媒体最重要的因素是速度要快，而当前技术I/O是系统性能提高瓶颈，优化磁盘"读"性能。</p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/数据安全风险.png") }}" alt="">
                                        <p>数据安全风险</p>
                                    </div>
                                    <p class="industry-text">客户隐私、企业数据安全、产品安全尤其重要，一旦被攻击、病毒、木马等，将受严重威胁。</p>
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
                            <img src="{{ asset("/images/wap/流媒体架构图.png") }}" alt="">
                            <div class="description">
                                <div class="description-title">架构说明</div>
                                <p>由于流媒体服务器的负载比其它应用服务器更大，下载速率必须达到解码率否则流媒体会出现卡断。单台服务器可能无法满足高并发量。腾正科技流媒体解决方案基于大规模实时流媒体计算集群和强大的音频信号处理算法，采用企业级的固态硬盘（SSD）提升了数据的读写速度，打造“清晰流畅、低时延、高并发”的音视频直播服务。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="service-advantages" style="z-index: 100;">
                        <div class="title">
                            <p>服务优势</p>
                            <div class="title-hr"></div>
                        </div>
                        <img src="{{ asset("/images/wap/流媒体服务优势.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">企业级的固态硬盘</div>
                                    <div class="fuwu-txt">采用SSD提高数据I/O读写速度, 因硬盘输出性能对流媒体点播是至关重要的因素，所以必须优化硬盘“读写"性能。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">集群消除单点故障</div>
                                    <div class="fuwu-txt">采用智能分发近源防护原则，提升网站数据加载和传输速度，减少单点防护压力，确保了防护效果和网民体验度。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">负载均衡平滑拓展</div>
                                    <div class="fuwu-txt">自主机房自组内网,搭建负载均衡，高可用架构，分担流媒体服务器的负荷，消除单点故障，提高流媒体服务体验。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">优质宽带质量接入</div>
                                    <div class="fuwu-txt">全国骨干网6大核心交换节点,优质骨干网接入，提高访问速度，解决延迟、丢包现象，满足流媒体用户运营需求。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">CDN智能分发服务</div>
                                    <div class="fuwu-txt">自主CDN加速1000+节点网络分发服务,解决地域、带宽和服务器性能造成的访问瓶颈,提升数据加载和传输速度。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">多层安全体系保障</div>
                                    <div class="fuwu-txt">高防DDos服务，Web应用防护、入侵检测、Web漏洞扫描服务，支持服务器、数据库自动备份及秒级回档功能。</div>
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
