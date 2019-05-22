@extends('layouts.layout')

@section('title', '高防CDN-集群高防cdn-棋牌游戏cdn高防-免备案高防cdn加速[腾正科技]')

@section('keywords', '高防CDN,集群高防cdn,棋牌游戏cdn高防,免备案高防cdn,抗ddos高防CDN')

@section('description', '高防CDN将源站内容分发至最接近网民的节点，使用户就近取得所需内容，在加速同时保护源站。腾正提供优质抗DDOS、CC攻击集群高防CDN，免备案高防CDN及游戏棋牌CDN高防等服务。')

@section('content')
<div class="tz-protection" id="high-defense-cdn">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">高防 CDN </h2>
                <h5 class="sub-text">
                    高防 CDN 是指将源站内容分发至最接近网民的节点，使用户可就近取得所需内容，提高网民访问的响应速度<br/>
                    和成功率，同时能够保护源站。解决因地域、带宽、运营商接入等不同而带来的访问延迟问题，有效提升站点<br/>
                    访问速度。适用于站点加速、游戏、点播、直播等场景。
                </h5>
            </div>
            <a class="apply-btn" href="javascript: void(0);">立即申请</a>
        </div>
        <div class="tab">
            @foreach ($tabs as $item)
                <a class="tab-item {{$item['name'] === '高防CDN' ? 'active' : ''}}" href="{{ $item['href'] }}">{{ $item['name'] }}</a>
            @endforeach
            <!-- <a class="tab-item active" href="/protection/high-defense-cdn">高防CDN</a>
            <a class="tab-item" href="/dist/highDefense.html"> DDOS高防IP</a>
            <a class="tab-item" href="/protection/c-shield">防C盾</a> -->
        </div>
    </div>
    <!--特点-->
    <div class="feature">
        <h2 class="title black">高防 CDN 特点</h2>
        <div class="cont">
            <img src="{{ asset("/images/highDefenseCdn/feature-logo.png") }}" />
            <div class="item-container">
                <div class="item">
                    <h5 class="item-title">稳定</h5>
                    <p class="item-desc">自建高质量节点覆盖全国30多个省市，Tb级带宽承载，支持国内主流运营商。</p>
                </div>
                <div class="item">
                    <h5 class="item-title">极速</h5>
                    <p class="item-desc">毫秒级时间响应，智能导航路径分发，优质高速网络搭配SSD存储更流畅。</p>
                </div>
                <div class="item">
                    <h5 class="item-title">易扩展</h5>
                    <p class="item-desc">内置功能丰富，横向产品补充，自助控制台丰富API，便捷架构扩展。</p>
                </div>
                <div class="item">
                    <h5 class="item-title">易操作</h5>
                    <p class="item-desc">平台化接入，内置功能丰富，横向产品补充，自助配置加速，一键刷新缓存。</p>
                </div>
                <div class="item">
                    <h5 class="item-title">低成本</h5>
                    <p class="item-desc">支持按日、按流量、按需等付费模式，可随时切换享受低成本高质量内容分发。</p>
                </div>
            </div>
        </div>
    </div>
    <!--功能-->
    <div class="function">
        <h2 class="title white">高防 CDN 功能</h2>
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-1.png") }}"">
                <div class="text">
                    <h5 class="title">稳定</h5>
                    <p class="desc">智能DNS调度算法，加速本地缓存，近原则分配最优节点服务，减少传输时间提高访问速度。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-2.png") }}"">
                <div class="text">
                    <h5 class="title">冗余机制</h5>
                    <p class="desc">服务器，节点，网络三层面实现了完善的冗余，保证了设备节点出现故障时不会影响用户正常访问。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-3.png") }}"">
                <div class="text">
                    <h5 class="title">超强防御</h5>
                    <p class="desc">利用多节点的优势隐藏源站IP，有效抵御不同类型DDoS、CC攻击，保障源站服务器安全稳定。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-4.png") }}"">
                <div class="text">
                    <h5 class="title">安全配置</h5>
                    <p class="desc">支持缓存策略、缓存Key计算、回源、视频、防盗链、HTTPS等相关的配置，完美解决盗链危害。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-5.png") }}"">
                <div class="text">
                    <h5 class="title">性能优化</h5>
                    <p class="desc">页面优化、智能压缩功能，为您减少传输内容节约开销的同时提升加速效果。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-6.png") }}"">
                <div class="text">
                    <h5 class="title">数据监控</h5>
                    <p class="desc">全景数据监控，实时采集分析，提供带宽流量、请求次数等全景数据报表及分析，提供日志下载和转储。</p>
                </div>
            </div>
        </div>
    </div>
    <!--应用场景&使用步骤-->
    <div class="scenario">
        <div>
            <h2 class="title black">应用场景</h2>
            <div class="card-container">
                <div class="card">
                    <div class="card-body">
                        <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-7.png") }}"">
                        <h5 class="title">网站加速</h5>
                    </div>
                    <div class="card-body-hover">
                        <h5 class="title">网站加速</h5>
                        <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-7-1.png") }}"">
                        <p style="color:#2139b7;">适用行业：图片、素材、金融、电商、企业门户类网站</p>
                        <p>采用替身防御模式隐藏源站IP，阻断黑客针对源站的 DDoS 、CC 攻击及恶意SQL注入，保障网站正常服务。</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-8.png") }}"">
                        <h5 class="title">存储分发</h5>
                    </div>
                    <div class="card-body-hover">
                        <h5 class="title">存储分发</h5>
                        <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-8-1.png") }}"">
                        <p style="color:#2139b7;">适用行业：各类型端游、手游、下载站、应用程序等网络产品</p>
                        <p>不同粒度文件全国分发加速，解决在线游戏、音乐、视频、软件等大型文件传输慢及传输不稳定等问题。</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-9.png") }}"">
                        <h5 class="title">视频点播</h5>
                    </div>
                    <div class="card-body-hover">
                        <h5 class="title">视频点播</h5>
                        <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-9-1.png") }}"">
                        <p style="color:#2139b7;">适用行业：在线影音、小视频类网站</p>
                        <p>基于腾正云海量存储、高效转码、极速分发和多端安全播放等服务打造一站式音乐、视频点播解决方案。</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-10.png") }}"">
                        <h5 class="title">视频直播</h5>
                    </div>
                    <div class="card-body-hover">
                        <h5 class="title">视频直播</h5>
                        <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-10-1.png") }}"">
                        <p style="color:#2139b7;">适用行业：视频直播平台</p>
                        <p>基于大规模实时流媒体计算集群和强大的音视频信号处理算法，打造“清晰流畅、低时延、高并发”的音视频直播服务。</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 50px">
            <h2 class="title black">使用步骤</h2>
            <img class="step-diagram" src="{{ asset("/images/highDefenseCdn/step-diagram.png") }}" alt="高防CDN使用步骤" />
        </div>
    </div>
    <!--咨询-->
    <div class="consult">
        <h2 class="title">
            腾正高防专家，在岗 1 分钟，安全 60 秒
        </h2>
        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
    </div>
</div>
@endsection
