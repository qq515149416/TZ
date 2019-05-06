@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="tz-dsa" class="tz-cdn-content common">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">动态加速网络</h2>
                <h5 class="sub-text">
                    动态加速网络是针对网站网页中通过程序接口提取放在数据库或其他存储媒体中的内容而产生的服务，<br/>
                    这些内容需不断更新保持新鲜，因此终端每次访问内容都有所不同，利用基础CDN缓存技术无法解决<br/>
                    动态加速需求。而15CDN网络智能系统+自研的最优链路算法完美解决这一难题。
                </h5>
            </div>
        </div>
        <div class="tab">
            <a class="tab-item" href="/15cdn/sca">静态内容加速</a>
            <a class="tab-item" href="/15cdn/dda">下载分发加速</a>
            <a class="tab-item active" href="/15cdn/dsa">动态加速网络</a>
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
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/adv-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">网状互联 海量传输</h5>
                    <p class="desc">
                        腾正自研链路优化技术和最优传输路径快速分发技术 + 自建高质量动态加速节点，使动态加速节点两两进行网状互联，可传输海量数据让您发布的内容更快地触达用户，提高用户对平台的黏度。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/adv-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">链路优化 冗余传输</h5>
                    <p class="desc">
                        针对动态请求高并发、小文件的传输特点，15CDN通过多链路优化技术冗余传输，有效提升传输链路利用率，降低传输耗时和弱环境下的传输成本，保障数据传输过程中的可靠性和稳定性。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/adv-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">操作简单 一键接入</h5>
                    <p class="desc">
                        只需前往域名服务商处把域名解析A改成分配后CNAME记录，即可完成接入。控制台支持多种自助配置,提供自主化域名管理，提供实时流量、带宽、访问数、数据统计分析，帮助客户实时了解业务请求情况。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/adv-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">功能丰富 性价比高</h5>
                    <p class="desc">
                        内置功能丰富，横向产品补充，自助控制台丰富API，支持FTP、API接口等多种资源上传方式；支持按日、按流量、按需等灵活付费模式，可随时切换享受低成本高质量内容分发，满足您不同时期的业务需求。
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
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/function-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">源站保护</h5>
                    <p class="desc">
                        利用CDN节点替代源站被直接访问，达到隐藏源站IP的效果，有效保护源服务器避免遭到黑客攻击带来的危害。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/function-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">带宽优化</h5>
                    <p class="desc">
                        用户直接在cache节点获取所需数据，在提高访问速度的同时也减少了源站点的带宽使用率，保障链路质量的同时节省了带宽费用。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/function-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">稳定高效</h5>
                    <p class="desc">
                        用户的请求接入动态加速网络后，转换为可靠的腾正私有协议进行数据加密及传输，比传统TCP协议更高效、更稳定。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/function-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">秒级响应</h5>
                    <p class="desc">
                        本地缓存加速，秒级缓存更新响应，提高了企业站点的访问速度，增强了用户体验质量和对内容提供商的黏度。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/function-icon-5.png") }}" />
                <div class="text">
                    <h5 class="title">报表统计</h5>
                    <p class="desc">
                        提供带宽流量、流量缓存、节点流量比例、页面访问的统计数据及日志下载等多样式全景数据统计报表，助力业务拓展分析。
                    </p>
                </div>
            </div>
            <div style="margin: 0 auto; line-height: 170px;">
                <img src="{{ asset("/images/dynamicSiteAcceleration/ellipsis-icon.png") }}" />
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
                    <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/customer-icon-1.png") }}"">
                    <p class="text">新闻门户类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/customer-icon-2.png") }}"">
                    <p class="text">电子商务类平台</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/customer-icon-3.png") }}"">
                    <p class="text">金融支付类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/customer-icon-4.png") }}"">
                    <p class="text">游戏娱乐类网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/customer-icon-5.png") }}"">
                    <p class="text">SNS社交网站</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/customer-icon-6.png") }}"">
                    <p class="text">BBS社区论坛</p>
                </div>
                <div class="item">
                    <img class="icon" src="{{ asset("/images/dynamicSiteAcceleration/customer-icon-7.png") }}" />
                    <p class="text">在线医疗等</p>
                </div>
            </div>
        </div>
        <div class="target">
            <h3 class="title">加速对象</h3>
            <hr class="divider">
            <p class="text">
                提供实时、动态内容的各类网站
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