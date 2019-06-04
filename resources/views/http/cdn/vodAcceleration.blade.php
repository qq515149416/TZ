@extends('layouts.layout')

@section('title', '流媒体点播加速-视频点播CDN加速-视频CDN-视频CDN解决方案[腾正科技]')

@section('keywords', '流媒体点播加速,视频点播CDN加速,视频CDN,视频CDN解决方案,CDN流媒体点播加速')

@section('description', '15CDN流媒体点播加速将源站大量的流媒体内容（视频、声音和数据等）通过最佳链路传输到腾正流媒体专用存储设备中，再利用15CDN网络的协同性能，实现视频点播CDN加速，达到用户自由定位提升访问粘性。')

@section('content')
<div id="tz-voda" class="tz-cdn-content common">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">流媒体点播加速</h2>
                <h5 class="sub-text font-regular">
                    15CDN流媒体点播加速是将源站大量的流媒体内容（视频、声音和数据等）通过最佳的链路传输到腾正科技<br/>
                    流媒体专用存储设备中，并利用15CDN网络自身的协同性能，将这些大流量流媒体文件快速分层同步传输到<br/>
                    全国各加速节点上，实现为用户提供稳定可靠的音视频点播服务。
                </h5>
            </div>
        </div>
        <div class="tab">
            <a class="tab-item" href="/15cdn/sca">静态内容加速</a>
            <a class="tab-item" href="/15cdn/dda">下载分发加速</a>
            <a class="tab-item" href="/15cdn/dsa">动态加速网络</a>
            <a class="tab-item active" href="/15cdn/smvoda">流媒体点播加速</a>
            <a class="tab-item" href="/15cdn/smlba">流媒体直播加速</a>
        </div>
    </div>
    <!--产品优势-->
    <div class="product-adv">
        <h2 class="title black">产品优势</h2>
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/adv-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">节点丰富</h5>
                    <p class="desc">
                        自建1000+高质量加速节点，Tb级带宽承载，可承载百万用户同时请求；可跨地域跨运营商实现互联互通，实现用户就近访问。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/adv-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">兼容性强</h5>
                    <p class="desc">
                        支持Windows Media、Real Media、Apple QuickTime等多种流媒体格式，支持HTTP、RMTP流媒体协议的FLV和MPEG4播放格式。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/adv-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">全面防护</h5>
                    <p class="desc">
                        服务器、节点、网络三个层面上具完善的冗余机制，预防黑客入侵以及各种DDOS攻击对网站的影响，确保在服务器或节点出现故障时网民亦正常访问。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/adv-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">一键接入</h5>
                    <p class="desc">
                        使用15CDN加速服务，无需更改网站设置，只需前往域名服务商处把域名解析A改成分配后CNAME记录，即可完成接入。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/adv-icon-5.png") }}" />
                <div class="text">
                    <h5 class="title">性价比高</h5>
                    <p class="desc">
                        不需要投入建设高标准的系统以及网络环境，依据按日、按流量、按需等多重付费模式，来满足您不同时期的业务需求。
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--产品功能-->
    <div class="product-function">
        <h2 class="title white">产品功能</h2>
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/function-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">安全配置</h5>
                    <p class="desc">
                        支持缓存策略、缓存Key计算、回源、视频、防盗链、HTTPS等相关的配置，完美解决盗链危害和用户等待时间。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/function-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">自动适配</h5>
                    <p class="desc">
                        专业的编转码技术，自动适应各种网络环境，自动适配多种终端及平台，支持实时转码和离线转码。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/function-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">源站保护</h5>
                    <p class="desc">
                        利用CDN节点替代源站被直接访问，达到隐藏源站IP的效果，有效保护源服务器避免遭到黑客攻击带来的危害。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/function-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">负载均衡</h5>
                    <p class="desc">
                        采用负载均衡技术，当Cache节点出现宕机时，能够自动屏蔽该Cache节点并切换到健康节点，保证用户正常访问。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/vodAcceleration/function-icon-5.png") }}" />
                <div class="text">
                    <h5 class="title">报表统计</h5>
                    <p class="desc">
                        提供带宽流量、流量缓存、节点流量比例、页面访问的统计数据及日志下载等数据统计报表，助力业务拓展分析。
                    </p>
                </div>
            </div>
            <div class="item" style="border: none; line-height: 81px; text-align: center;">
                <img src="{{ asset("/images/vodAcceleration/ellipsis-icon.png") }}" />
            </div>
        </div>
    </div>
    <!--使用场景-->
    <div class="usage-scenario">
        <h2 class="title black">使用场景</h2>
        <div class="customer">
            <h3 class="title">客户群体</h3>
            <hr class="divider">
            <div class="item-container">
                <div class="item">
                    <img class="icon" src="{{ asset("/images/vodAcceleration/customer-icon-1.png") }}"">
                    <p class="text">多媒体新闻网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/vodAcceleration/customer-icon-2.png") }}"">
                    <p class="text">影视类视频网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/vodAcceleration/customer-icon-3.png") }}"">
                    <p class="text">视频分享类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/vodAcceleration/customer-icon-4.png") }}"">
                    <p class="text">在线教育类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/vodAcceleration/customer-icon-5.png") }}"">
                    <p class="text">在线医疗类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/vodAcceleration/customer-icon-6.png") }}"">
                    <p class="text">音乐类网站</p>
                </div>
            </div>
        </div>
        <div class="target">
            <h3 class="title">加速对象</h3>
            <hr class="divider">
            <p class="text">
                提供PC端、移动端、TV端多种文件格式、编码格式的音视频内容点播网站
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