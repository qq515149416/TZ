@extends('layouts.layout')

@section('title', '流媒体直播加速-视频直播CDN加速-视频CDN-视频CDN解决方案')

@section('keywords', '流媒体直播加速,视频直播CDN加速,视频CDN,视频CDN解决方案,视频CDN价格')

@section('description', '15CDN流媒体直播加速将源站采用广播方式通过网络为用户提供实时采集的视频流，并通过最佳链路传输到腾正流媒体专用存储设备中，再15CDN网络自身的协同性能，实现视频直播CDN加速。')

@section('content')
<div id="tz-lba" class="tz-cdn-content common">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">流媒体直播加速</h2>
                <h5 class="sub-text">
                    15CDN流媒体直播加速是将源站采用广播方式通过网络为用户提供实时采集的视频流，通过最佳链路传输<br/>
                    到腾正科技流媒体专用存储设备中，并利用15CDN网络自身的协同性能，将这些大流量流媒体文件进行快<br/>
                    速分层同步传输到全国各加速节点上，为用户提供稳定可靠的音视频点播服务。
                </h5>
            </div>
        </div>
        <div class="tab">
            <a class="tab-item" href="/15cdn/sca">静态内容加速</a>
            <a class="tab-item" href="/15cdn/dda">下载分发加速</a>
            <a class="tab-item" href="/15cdn/dsa">动态加速网络</a>
            <a class="tab-item" href="/15cdn/smvoda">流媒体点播加速</a>
            <a class="tab-item active" href="/15cdn/smlba">流媒体直播加速</a>
        </div>
    </div>
    <!--产品优势-->
    <div class="product-adv">
        <h2 class="title">产品优势</h2>
        <img class="d-block" src="{{ asset("/images/cdn/rectangle.png") }}" />
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/adv-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">更快速</h5>
                    <p class="desc">
                        自建1000+高质量加速节点，Tb级带宽承载，可承载百万用户同时请求，助力内容直播的时间、空间范围。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/adv-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">更稳定</h5>
                    <p class="desc">
                        分层分发保证直播流的传输质量，最大程度减少传输环节对直播效果的影响，提高用户体验度和访问黏度。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/adv-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">更灵活</h5>
                    <p class="desc">
                        支持RTMP/HTTP FLV/HTTP TS/HLS/HDS等协议转换、码率转换，支持直播定位时移，满足多终端多平台的用户需求。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/adv-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">更简单</h5>
                    <p class="desc">
                        使用15CDN，无需更改网站设置，只需前往域名服务商处把域名解析A改成分配后CNAME记录，即可完成接入。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/adv-icon-5.png") }}" />
                <div class="text">
                    <h5 class="title">更经济</h5>
                    <p class="desc">
                        无需投入建设高标准的系统及网络环境，依据按流量、按日等多重付费模式，不必顾虑非直播期间带来的成本压力。
                    </p>
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
                <img class="icon" src="{{ asset("/images/liveAcceleration/function-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">安全配置</h5>
                    <p class="desc">
                        支持缓存策略、缓存Key计算、回源、视频、防盗链、HTTPS等相关的配置，完美解决盗链危害和用户等待时间。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/function-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">自动适配</h5>
                    <p class="desc">
                        专业的编转码技术，自动适应各种网络环境，自动适配多种终端及平台，支持实时转码和离线转码。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/function-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">源站保护</h5>
                    <p class="desc">
                        利用CDN节点替代源站被直接访问，达到隐藏源站IP的效果，有效保护源服务器避免遭到黑客攻击带来的危害。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/function-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">负载均衡</h5>
                    <p class="desc">
                        采用负载均衡技术，当Cache节点出现宕机时，能够自动屏蔽该Cache节点并切换到健康节点，保证用户正常访问。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/liveAcceleration/function-icon-5.png") }}" />
                <div class="text">
                    <h5 class="title">报表统计</h5>
                    <p class="desc">
                        提供带宽流量、流量缓存、节点流量比例、页面访问的统计数据及日志下载等数据统计报表，助力业务拓展分析。
                    </p>
                </div>
            </div>
            <div class="item" style="border: none; line-height: 81px; text-align: center;">
                <img src="{{ asset("/images/liveAcceleration/ellipsis-icon.png") }}" />
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
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-1.png") }}"">
                    <p class="text">新闻直播类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-2.png") }}"">
                    <p class="text">电视直播类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-3.png") }}"">
                    <p class="text">体育赛事类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-4.png") }}"">
                    <p class="text">远程教育类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-5.png") }}"">
                    <p class="text">远程医疗类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-6.png") }}"">
                    <p class="text">游戏直播网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-7.png") }}"">
                    <p class="text">实时视频会议</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-8.png") }}"">
                    <p class="text">访谈类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/liveAcceleration/customer-icon-9.png") }}"">
                    <p class="text">音乐类网站</p>
                </div>
            </div>
        </div>
        <div class="target">
            <h3 class="title">加速对象</h3>
            <hr class="divider">
            <p class="text">
                提供PC端、移动端、TV端多种文件格式、编码格式的音频视频流媒体直播服务的网站
            </p>
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