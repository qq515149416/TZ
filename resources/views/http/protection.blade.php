@extends('layouts.layout')

@section('title', '网络安全防护-网站安全防护-DDOS防火墙-CC攻击防御-安全解决方案[腾正科技]')

@section('keywords', '网络安全防护,网站安全防护,DDOS防火墙,防CC攻击,DDOS防御，CC攻击防御,安全解决方案')

@section('description', '网络信息安全问题日趋严重，涉及经济，政治、私隐等领域。腾正科技为您量身构建IDC安全防护解决方案,隐藏源站IP+T级集群防火墙+独立流量清洗+CC防御组合过滤精确识别，防御DDOS、CC等攻击，确保您业务安全持续可用。')

@section('content')

<div id="tz-protection" class="tz-protection-content">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">安全防护</h2>
                <h5 class="sub-text">
                    灵活弹性自动化的基础IT设施建设、 按需付费的服务模式以及0成本的运维IT服务体系<br/>
                    为企业及开发者用户量身构建从0到N的网站全生命周期一站式闭环服务
                </h5>
            </div>
            <a class="apply-btn" href="javascript: void(0);">立即申请</a>
        </div>
        <div class="tab">
            @foreach ($tabs as $item)
                <a class="tab-item" href="{{ $item['href'] }}">{{ $item['name'] }}</a>
            @endforeach
        </div>
    </div>
    <!--产品矩阵-->
    <div class="product-matrix">
        <h2 class="title">产品矩阵</h2>
        <img class="d-block" src="{{ asset("/images/protection/rectangle.png") }}" />
        <div class="item-container">
            <div class="row">
                <div class="item-group">
                    <div class="item-group-title">
                        <span style="position: absolute; top: 32px; left: 63px;">网络安全</span>
                        <img class="flow-line" src="{{ asset("/images/protection/flow-line-1.png") }}">
                        <img class="flow-line-hover" src="{{ asset("/images/protection/flow-line-hover-1.png") }}">
                    </div>
                    <div class="item">DDoS 基础防护</div>
                    <div class="item">DDoS 高防保护</div>
                    <div class="item">安全组</div>
                </div>
                <div style="flex-grow: 1"></div>
                <div class="item-group">
                    <div class="item-group-title" style="top: 31px; left: -155px;">
                        <span style="position: absolute; top: 32px; left: 43px;">应用安全</span>
                        <img class="flow-line" src="{{ asset("/images/protection/flow-line-2.png") }}">
                        <img class="flow-line-hover" src="{{ asset("/images/protection/flow-line-hover-2.png") }}">
                    </div>
                    <div class="item">应用防火墙 WAF</div>
                    <div class="item">安全牵引系统 BlackHole System</div>
                    <div class="item">业务安全反欺诈</div>
                </div>
            </div>
            <div class="row">
                <div class="item-group">
                    <div class="item-group-title">
                        <span style="position: absolute; top: 5px; left: 43px;">主机安全</span>
                        <img class="flow-line" src="{{ asset("/images/protection/flow-line-3.png") }}">
                        <img class="flow-line-hover" src="{{ asset("/images/protection/flow-line-hover-3.png") }}">
                    </div>
                    <div class="item">安全客户端 Hosteye</div>
                    <div class="item">隐藏源站 IP</div>
                </div>
                <div style="flex-grow: 1"></div>
                <div class="item-group">
                    <div class="item-group-title" style="top: 31px; left: -142px;">
                        <span style="position: absolute; top: 5px; left: 36px;">安全服务</span>
                        <img class="flow-line" src="{{ asset("/images/protection/flow-line-4.png") }}">
                        <img class="flow-line-hover" src="{{ asset("/images/protection/flow-line-hover-4.png") }}">
                    </div>
                    <div class="item">安全应急响应</div>
                    <div class="item">安全渗透测试</div>
                </div>
            </div>
            <div class="row">
                <div class="item-group">
                    <div class="item-group-title">
                        <span style="position: absolute; top: 30px; left: 65px;">安全管理</span>
                        <img class="flow-line" src="{{ asset("/images/protection/flow-line-5.png") }}">
                        <img class="flow-line-hover" src="{{ asset("/images/protection/flow-line-hover-5.png") }}">
                    </div>
                    <div class="item">密钥管理服务 KMS</div>
                    <div class="item">证书服务 SSL</div>
                    <div class="item">VPN</div>
                </div>
                <div style="flex-grow: 1"></div>
                <div class="item-group">
                    <div class="item-group-title" style="top: 16px; left: -171px;">
                        <span style="position: absolute; top: -10px; left: 52px;">安全合规</span>
                        <img class="flow-line" src="{{ asset("/images/protection/flow-line-6.png") }}">
                        <img class="flow-line-hover" src="{{ asset("/images/protection/flow-line-hover-6.png") }}">
                    </div>
                    <div class="item">数据库审计 DBAUDIT</div>
                    <div class="item">流量审计 IDS</div>
                    <div class="item">堡垒机</div>
                </div>
            </div>
        </div>
    </div>
    <!--产品优势-->
    <div class="product-adv">
        <h2 class="title">产品优势</h2>
        <img class="d-block" src="{{ asset("/images/protection/rectangle.png") }}" />
        <div class="card-container">
            <div class="card">
                <img class="icon" src="{{ asset("/images/protection/adv-icon-1.png") }}" />
                <img class="icon-hover" src="{{ asset("/images/protection/adv-icon-4.png") }}" />
                <h5 class="title">高防 CDN</h5>
                <p class="text">指将源站内容分发至最接近网民的节点，使用户可就近取得所需内容，提高网民访问的响应速度和成功率，同时能够保护源站。解决因地域、带宽、运营商接入等不同而带来的访问延迟问题，有效提升站点访问速度。</p>
                <img src="{{ asset("/images/protection/bottom-arrow.png") }}" />
            </div>
            <div class="card">
                <img class="icon" src="{{ asset("/images/protection/adv-icon-2.png") }}" />
                <img class="icon-hover" src="{{ asset("/images/protection/adv-icon-5.png") }}" />
                <h5 class="title" style="margin-top: 45px;">DDOS 高防 IP</h5>
                <p class="text">针对互联网服务器（包括非腾正云主机）在遭受大流量DDoS攻击后导致服务不可用的情况下，推出的付费增值服务，用户可通过配置高防IP，将攻击流量引流到高防IP，确保源站的稳定可靠，保障用户的访问质量和对内容提供商的黏度。</p>
                <img src="{{ asset("/images/protection/bottom-arrow.png") }}" />
            </div>
            <div class="card">
                <img class="icon" src="{{ asset("/images/protection/adv-icon-3.png") }}" />
                <img class="icon-hover" src="{{ asset("/images/protection/adv-icon-6.png") }}" />
                <h5 class="title">防 C 盾</h5>
                <p class="text">腾正科技自主研发针对CC攻击接入C盾进行防御的攻击防护体系，一键开启DDos和CC防御，零维护规则。具抗CC攻击，抗DDOS攻击，防入侵监测系统，硬件监控系统，网络故障分析平台，数据灾备系统，防篡改,防盗链,防访问限制,源站保护功能。</p>
                <img src="{{ asset("/images/protection/bottom-arrow.png") }}" />
            </div>
        </div>
    </div>
    <!--节点介绍-->
    <div class="node-intro">
        <h2 class="title" style="color: #fff;">节点介绍</h2>
        <img class="d-block" src="{{ asset("/images/protection/white-rectangle.png") }}" />
        <div class="item-container">
            <div class="item">
                <div style="display: inline-block; width: calc(100% - 50px);">
                    <h5 class="title">华南多线</h5>
                    <p class="desc">单IP对接多线路，消除跨网访问延迟</p>
                </div>
                <img class="arrow-icon" src="{{ asset("/images/protection/circle-arrow.png") }}" />
                <img class="arrow-icon-active" src="{{ asset("/images/protection/circle-arrow-active.png") }}" />
            </div>
            <div class="item">
                <div style="display: inline-block; width: calc(100% - 50px);">
                    <h5 class="title">华中多线</h5>
                    <p class="desc">安全可靠，遇故障自动切换线路</p>
                </div>
                <img class="arrow-icon" src="{{ asset("/images/protection/circle-arrow.png") }}" />
                <img class="arrow-icon-active" src="{{ asset("/images/protection/circle-arrow-active.png") }}" />
            </div>
            <div class="item">
                <div style="display: inline-block; width: calc(100% - 50px);">
                    <h5 class="title">华东多线</h5>
                    <p class="desc">多线路组合，智能切换一步到位</p>
                </div>
                <img class="arrow-icon" src="{{ asset("/images/protection/circle-arrow.png") }}" />
                <img class="arrow-icon-active" src="{{ asset("/images/protection/circle-arrow-active.png") }}" />
            </div>
            <div class="item">
                <div style="display: inline-block; width: calc(100% - 50px);">
                    <h5 class="title">西北多线</h5>
                    <p class="desc">稳如磐石，T量级联防调度防护体系</p>
                </div>
                <img class="arrow-icon" src="{{ asset("/images/protection/circle-arrow.png") }}" />
                <img class="arrow-icon-active" src="{{ asset("/images/protection/circle-arrow-active.png") }}" />
            </div>
        </div>
    </div>
    <!--客户应用场景-->
    <div class="client-scene">
        <h2 class="title" style="color: #fff;">客户应用场景</h2>
        <img class="d-block" src="{{ asset("/images/protection/white-rectangle.png") }}" />
        <div class="tab" role="tablist">
            <a class="tab-item active"
               id="service-tab"
               href="javascript: void(0);"
               data-target="#service"
               role="tab"
               aria-controls="service"
               aria-selected="true">行业服务类应用</a>
            <a class="tab-item"
               id="safety-tab"
               href="javascript: void(0);"
               data-target="#safety"
               role="tab"
               aria-controls="safety"
               aria-selected="false">安全增值类应用</a>
            <a class="tab-item"
               id="operator-tab"
               href="javascript: void(0);"
               data-target="#operator"
               role="tab"
               aria-controls="operator"
               aria-selected="false">运营商类应用</a>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="service" role="tabpanel" aria-labelledby="service-tab">
                <h5 class="text">电商加速</h5>
                <p class="desc">隐藏源站IP，保护源服务器避免各种攻击带来的危害；跨ISP就近访问，提高用户访问速度和对内容提供商的黏度。</p>
                <hr class="divider">
                <h5 class="text">门户网站加速</h5>
                <p class="desc">网络攻击防御+弹性扩展的资源用量轻松应对突发流量，网站速度更快，消耗带宽流量更少，成本更低，网站更安全。</p>
                <hr class="divider">
                <h5 class="text">游戏加速</h5>
                <p class="desc">高质量节点覆盖全国，Tb级带宽承载，本地缓存加速，秒级响应，完美解决游戏运行卡顿、掉线、接入困难等问题。</p>
                <hr class="divider">
                <h5 class="text">视频加速</h5>
                <p class="desc">优质骨干网接入，自主CDN加速，用户实现就近访问，个性化打造"清晰流畅、低时延、高并发"的流媒体服务。</p>
                <hr class="divider">
                <h5 class="text">企业网站加速</h5>
                <p class="desc">提高网站访问速度，增强网站内容黏度，助力网站的宣传和推广效果，进而降低运营成本，提高营销转化率。</p>
            </div>
            <div class="tab-pane fade" id="safety" role="tabpanel" aria-labelledby="safety-tab">
                <h5 class="text">防盗链</h5>
                <p class="desc">平台化接入，支持缓存策略、缓存Key计算、回源、视频、防盗链、HTTPS等相关配置，完美解决盗链危害。</p>
                <hr class="divider">
                <h5 class="text">网络攻击防御</h5>
                <p class="desc">T级集群防火墙+独立流量清洗+CC防御组合过滤精确识别漏洞与威胁，防入侵、防篡改，防盗链等带来的危害。</p>
                <hr class="divider">
                <h5 class="text">突发流量应对</h5>
                <p class="desc">AI、5G的兴起和应用，全球数据中心流量激增，对于突发流量，腾正海量弹性带宽储备，保障用户极速体验。</p>
                <hr class="divider">
                <h5 class="text">访问区域控制</h5>
                <p class="desc">腾正自研高防御防护体系，对主体访问客体的权限或能力的监测及限制，阻止对信息系统资源的非授权访问。</p>
                <hr class="divider">
                <h5 class="text">智能调度服务</h5>
                <p class="desc">智能DNS调度算法，加速本地缓存，近原则分配最优节点服务，减少传输时间提高访问速度，实现全局加速。</p>
            </div>
            <div class="tab-pane fade" id="operator" role="tabpanel" aria-labelledby="operator-tab">
                <h5 class="text">内容加速方案</h5>
                <p class="desc">自助配置加速，只需修改域名解析即可完成15CDN加速接入，提升访问速度快的同时消耗更少的带宽流量。</p>
                <hr class="divider">
                <h5 class="text">内容引入方案</h5>
                <p class="desc">将内容分层同步到各加速节点，引入主动内容管理层和全局负载均衡，进行网络路由及协议优化提高访问速度。</p>
            </div>
        </div>
    </div>
    <!--客户案例-->
    <div class="customer-case">
        <h2 class="title">客户案例</h2>
        <img class="d-block" src="{{ asset("/images/protection/rectangle.png") }}" />
        <div class="carousel-container">
            <div id="carousel-customer" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-customer" data-slide-to="0" class="active">
                        <span class="progress"></span>
                    </li>
                    <li data-target="#carousel-customer" data-slide-to="1">
                        <span class="progress"></span>
                    </li>
                    <li data-target="#carousel-customer" data-slide-to="2">
                        <span class="progress"></span>
                    </li>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div class="image-container">
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-1.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-2.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-3.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-4.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-5.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-6.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-7.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-8.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-9.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-10.png") }}" />
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="image-container">
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-11.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-12.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-13.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-14.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-15.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-16.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-17.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-18.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-19.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-20.png") }}" />
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="image-container">
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-21.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-22.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-23.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-24.png") }}" />
                            </div>
                            <div class="image">
                                <img src="{{ asset("/images/protection/case-25.png") }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 常见问题 -->
    <div class="common-question">
        <h2 class="title">安全防护常见问题</h2>
        <h5 style="color: #666;">关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</h5>
        <div class="list-container">
            <ul class="list-group">
                <div class="list-header">
                    <img class="icon" src="{{ asset("/images/protection/question-icon-1.png") }}" />
                    <h5 class="title">高防 CDN</h5>
                    <a href="javascript: void(0);" class="more">查看更多>></a>
                </div>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">什么是CDN技术？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">CDN适用哪些场景？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">什么内容分发网络CDN？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">CDN容易遭到什么类型的攻击？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">高防产品如何支持Websocket&WSS？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
            <ul class="list-group">
                <div class="list-header">
                    <img class="icon" src="{{ asset("/images/protection/question-icon-2.png") }}" />
                    <h5 class="title">DDOS 高防 IP</h5>
                    <a href="javascript: void(0);" class="more">查看更多>></a>
                </div>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">什么是DDos高防IP？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">高防IP如何部署？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">高防IP与堡垒机的区别？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">高防IP的工作原理是什么？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">高防IP的场景应用分析</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
            <ul class="list-group">
                <div class="list-header">
                    <img class="icon" src="{{ asset("/images/protection/question-icon-3.png") }}" />
                    <h5 class="title">防 C 盾</h5>
                    <a href="javascript: void(0);" class="more">查看更多>></a>
                </div>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">什么是防C盾？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">防C盾的工作原理是？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">防C盾的场景应用分析</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">面对CC攻击企业该如何防御？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-item">
                    <a class="text" href="javascript: void(0);">黑客是如何发起CC攻击的？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
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
