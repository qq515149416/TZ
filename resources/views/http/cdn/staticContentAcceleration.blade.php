@extends('layouts.layout')

@section('title', '静态内容加速-CDN静态网页加速-静态页面加速-免费cdn申请[腾正科技]')

@section('keywords', '静态内容加速,CDN静态网页加速,静态页面加速,CDN服务商,CDN静态加速，免费cdn申请')

@section('description', '15CDN静态网页加速服务将源站网页内容如html文件、flash动画、及各种文件类型图片缓存于CDN服务商腾正15CDN中心网络中，用缓存技术将这些文件cache在15CDN边缘节点上，实现加速体验目的。')

@section('content')
<div id="tz-sca" class="tz-cdn-content common">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">静态内容加速</h2>
                <h5 class="sub-text">
                    静态网页加速服务将源站的网页内容：html文件、flash动画、及各种文件类型的图片缓存于腾正科技<br/>
                    15CDN中心网络中，且文件可定期和不定期更新，用缓存技术将这些文件cache在腾正科技15CDN的<br/>
                    边缘节点上，实现终端用户就近访问的需求，达到加速体验目的。
                </h5>
            </div>
        </div>
        <div class="tab">
            <a class="tab-item active" href="/15cdn/sca">静态内容加速</a>
            <a class="tab-item" href="/15cdn/dda">下载分发加速</a>
            <a class="tab-item" href="/15cdn/dsa">动态加速网络</a>
            <a class="tab-item" href="/15cdn/smvoda">流媒体点播加速</a>
            <a class="tab-item" href="/15cdn/smlba">流媒体直播加速</a>
        </div>
    </div>
    <!--产品优势-->
    <div class="product-adv">
        <h2 class="title">产品优势</h2>
        <img class="d-block" src="{{ asset("/images/cdn/rectangle.png") }}" />
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/staticContentAcceleration/adv-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">节点丰富</h5>
                    <p class="desc">
                        自建1000+高质量加速节点，Tb级带宽承载，带宽输出能力不低于40Tbps；可跨地域支持电信、联通、移动、教育网等主流运营商，以及多家中小型运营商，有效将用户请求精准调度至最优边缘节点。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/staticContentAcceleration/adv-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">全面防护</h5>
                    <p class="desc">
                        在服务器、节点、网络三个层面上具有完善的冗余机制，有效地预防黑客入侵以及降低各种DDOS攻击对网站的影响，确保在服务器或节点出现故障时，自动将网民访问导向其他就近的健康节点进行响应。 </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/staticContentAcceleration/adv-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">一键接入</h5>
                    <p class="desc">
                        只需前往域名服务商处把域名解析A改成分配后CNAME记录，即可完成接入。控制台支持多种自助配置,提供自主化域名管理，提供实时流量、带宽、访问数、数据统计分析，帮助客户实时了解业务波动。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/staticContentAcceleration/adv-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">性价比高</h5>
                    <p class="desc">
                        内置功能丰富，横向产品补充，自助控制台丰富的API，便捷架构扩展；支持按日、按流量、按需等灵活付费模式，可以随时切换享受低成本高质量的内容分发，满足您不同时期的业务需求。</p>
                </div>
            </div>
        </div>
    </div>
    <!--产品功能-->
    <div class="product-function">
        <h2 class="title" style="color: #fff;">产品功能</h2>
        <img class="d-block" src="{{ asset("/images/cdn/white-rectangle.png") }}" />
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/staticContentAcceleration/function-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">源站保护</h5>
                    <p class="desc">从需求分析、加速建议、效果测试，直至客户服务，都有完善的专业化流程。专业化的管理平台，让客户更直观，更实时查询各种统计数据。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/staticContentAcceleration/function-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">跨ISP访问</h5>
                    <p class="desc">15CDN在网络部署上具有完备的安全机制，可以有效地预防黑客入侵，抵御DDOS及CC攻击，在保护源站的基础上同时保证了网络质量。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/staticContentAcceleration/function-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">带宽优化</h5>
                    <p class="desc">通过内容管理技术，网站可以非常方便地实现对发布到CDN网络中的内容进行管理，保证用户看到的内容与源站完全同步。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/staticContentAcceleration/function-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">报表统计</h5>
                    <p class="desc">整个CDN网络的运行状态实行7X24小时全网监控、集中维护，保证问题能够得到及时有效的解决。</p>
                </div>
            </div>
        </div>
    </div>
    <!--使用场景-->
    <div class="usage-scenario">
        <h2 class="title">使用场景</h2>
        <img class="d-block" src="{{ asset("/images/cdn/rectangle.png") }}" />
        <div class="customer">
            <h3 class="title">客户群体</h3>
            <hr class="divider">
            <div class="item-container">
                <div class="item">
                    <img class="icon" src="{{ asset("/images/staticContentAcceleration/customer-icon-1.png") }}" />
                    <p class="text">门户类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/staticContentAcceleration/customer-icon-2.png") }}" />
                    <p class="text">电子商务类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/staticContentAcceleration/customer-icon-3.png") }}" />
                    <p class="text">企业类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/staticContentAcceleration/customer-icon-4.png") }}" />
                    <p class="text">新闻类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/staticContentAcceleration/customer-icon-5.png") }}" />
                    <p class="text">娱乐/游戏类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/staticContentAcceleration/customer-icon-6.png") }}" />
                    <p class="text">证券类网站</p>
                </div>
            </div>
        </div>
        <div class="target">
            <h3 class="title">加速对象</h3>
            <hr class="divider">
            <p class="text">网站或受经济APP静态组成部分如html文件、flash动画、css、js及各种文件类型的文字、图片类网站</p>
        </div>
    </div>
    <!--立即咨询-->
    <div class="consult">
        <h2 class="title">
            智能云端技术，CDN加速首选！免费CDN申请
        </h2>
        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
    </div>
</div>
@endsection