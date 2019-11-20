@extends('layouts.layout')

@section('title', '游戏云解决方案-游戏服务器架构-CDN游戏加速[腾正科技]')

@section('keywords', '游戏云解决方案,游戏云面临问题,游戏云架构部署,游戏服务器,游戏服务器架构，CDN游戏加速')

@section('description', '腾正科技游戏云解决方案，利用云服务器弹性扩展、负载均衡功能、自研高防御系统及CDN加速，打造虚拟化、高可用的游戏集群，解决游戏客户运行卡顿、掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题。')

@section('content')
<div id="tz-program">
    <div class="tab" role="tablist">
        <a class="tab-item"
           id="game-tab"
           href="/fangan/game"
           data-target="#game"
           role="tab"
           aria-controls="game"
           aria-selected="true">游戏</a>
        <a class="tab-item"
           id="chess-tab"
           href="/fangan/chess"
           data-target="#chess"
           role="tab"
           aria-controls="chess"
           aria-selected="false">棋牌</a>
        <a class="tab-item"
           id="finance-tab"
           href="/fangan/finance"
           data-target="#finance"
           role="tab"
           aria-controls="finance"
           aria-selected="false">金融</a>
        <a class="tab-item"
           id="streaming-media-tab"
           href="/fangan/streaming_media"
           data-target="#streaming_media"
           role="tab"
           aria-controls="streaming_media"
           aria-selected="false">流媒体</a>
        <a class="tab-item"
           id="mobile-app-tab"
           href="/fangan/mobile_app"
           data-target="#mobile_app"
           role="tab"
           aria-controls="mobile_app"
           aria-selected="false">移动APP</a>
        <a class="tab-item"
           id="education-cloud-tab"
           href="/fangan/education_cloud"
           data-target="#education_cloud"
           role="tab"
           aria-controls="education_cloud"
           aria-selected="false">教育云</a>
        <a class="tab-item"
           id="government-cloud-tab"
           href="/fangan/government_cloud"
           data-target="#government_cloud"
           role="tab"
           aria-controls="government_cloud"
           aria-selected="false">政务云</a>
        <a class="tab-item"
           id="website-deployment-tab"
           href="/fangan/website_deployment"
           data-target="#website_deployment"
           role="tab"
           aria-controls="website_deployment"
           aria-selected="false">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content tab-content">
        <!-- 游戏云 -->
        <div class="tab-pane" id="game" role="tabpanel" aria-labelledby="game-tab">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">游戏云解决方案</h2>
                    <h5 class="sub-text">
                        行业领先自研游戏生态系统，打造虚拟化、高可用的游戏集群，完美解决游戏客户运行卡顿、
                        <br/>
                        掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">游戏云面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon1.png") }}" />
                            <span class="text">计算性能不够，游戏卡顿？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>百万级PPS的云服务器</li>
                                <li>资源独享的专属机</li>
                                <li>超高性能的物理机</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon2.png") }}" />
                            <span class="text">网络不稳定，玩家掉线？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>资源优势10+线BGP网络</li>
                                <li>万兆冗余内网，绝无单点</li>
                                <li>高性能的外网共享带宽</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon3.png") }}" />
                            <span class="text">游戏大推，大量玩家访问？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>20+万IOPS的高性能本地盘</li>
                                <li>数万IOPS的高可靠云磁盘</li>
                                <li>极致性能的缓存、数据库</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon4.png") }}" />
                            <span class="text">游戏安全，如何保障？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>高防抗D服务</li>
                                <li>HTTPS加密负载均衡</li>
                                <li>VPN/专线安全数据传输</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon5.png") }}" />
                            <span class="text">游戏服，监控及故障恢复？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>用户自定义报警</li>
                                <li>云服务器秒级热迁移</li>
                                <li>物理机宕机，游戏分钟级恢复</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon6.png") }}" />
                            <span class="text">游戏要求全国同服？</span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>多地区数据中心</li>
                                <li>数据中心之间内网T级传输带宽</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/game-arch.png") }}" alt="游戏云解决方案构架部署图" />
                    <div>
                        <p class="desc">
                            腾正科技游戏云服务，从构建基础设施到游戏上线到后期精细化运营，腾正科技服务涵盖项目整个发展周期。在IT架构层面将不同功能模块，比如登录，逻辑，商城，图片服务等业务分离，业<br/>务水平扩展，利用云服务器弹性扩展和负载均衡功能，随时增减云服务器。同时增加缓存服务器、数据库读写分离、轻松应对海量玩家同时在线。在资源上，腾正科技应用业内领先的双线高防<br/>节点以及国内优质的BGP多线网络资源，隐藏源站真实IP，解决跨地域跨线路问题，为用户全面打造稳如磐石的游戏解决方案。
                        </p>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">游戏云服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>自动DDoS清洗系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    10T+防御带宽，配备T量级超强硬件清洗平台，<br/>
                                    抵御不同类型DDoS、CC等攻击坚如磐石，满足<br/>
                                    游戏客户对网络安全方面的需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>游戏更新智能分发</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    开放存储服务与内容分发网络服务结合，可实现<br/>
                                    游戏升级更新包与客户端高速、低成本的分发与<br/>
                                    加速。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>游戏体验畅通无阻</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    游戏云专属服务器集群，高IO读写性能。保证在<br/>
                                    高并发下依然能够保证稳定的IOPS，有效避免了<br/>
                                    游戏卡顿现象，提升玩家体验以及留存率。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>海量游戏日志存储</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    启用简单日志服务对游戏日志进行存储查询，通<br/>
                                    过DPC整合日志数据到ODPS中，实现海量日志<br/>
                                    数据分析。为游戏云用户提供数据支撑。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-5.png") }}" alt="adv5" />
                                <span>负载均衡平滑拓展</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    游戏运营过程中，可以根据用户量随时增加或者<br/>
                                    合并服务器，利用负载均衡，自动分配用户流量，<br/>
                                    满足服务器平滑扩展需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-6.png") }}" alt="adv6" />
                                <span>操作简便一键完成</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    支持多种架构游戏用户，手游，页游，端游一键<br/>
                                    部署轻松搞定。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 棋牌云 -->
        <div class="tab-pane" id="chess" role="tabpanel" aria-labelledby="chess-tab">
            <!-- banner -->
            <div class="banner">
                <div class="title">
                    <h2 class="text">棋牌云解决方案</h2>
                    <h5 class="sub-text">
                        成熟技术团队，海量攻防实战积累，为游戏运营打造可信赖的安全解决方案，全方位解决
                        <br/>
                        卡顿掉线、欺诈作弊、外挂等常见问题，轻松应对海量玩家同时在线
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">棋牌游戏面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon7-1.png") }}" />
                            <img class="hover-icon" src="{{ asset("/images/program/icon7-2.png") }}" />
                            <h4 class="text">DDoS攻击</h4>
                            <hr class="divider"></hr>
                        </div>
                        <div class="card-body">
                            棋牌游戏在DDoS方面是行业重灾区，攻击常达百G以上，而且攻击方式复杂多变，对于服务器端的攻击，应用层的攻击以及DNS攻击是防护难题。
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon8-1.png") }}" />
                            <img class="hover-icon" src="{{ asset("/images/program/icon8-2.png") }}" />
                            <h4 class="text">欺诈作弊</h4>
                            <hr class="divider"></hr>
                        </div>
                        <div class="card-body">
                            攻击者利用自动化工具，通过扫库撞库等方式进行盗号，破解游戏客户端程序，改变游戏数据，各种外挂程序，破坏游戏生态平衡。
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon9-1.png") }}" />
                            <img class="hover-icon" src="{{ asset("/images/program/icon9-2.png") }}" />
                            <h4 class="text">卡顿掉线</h4>
                            <hr class="divider"></hr>
                        </div>
                        <div class="card-body">
                            游戏是否能给玩家良好的用户体验，首先考虑的是游戏运行时的稳定性。因此对服务器配置、性能、网络带宽有很严格的要求，腾正科技云安全为您保障业务的持续可用性。
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/white-rectangle.png") }}">
                <div class="cont">
                    <div class="arch-text">
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 15px;">架构说明</h4>
                        <p class="desc">
                            腾正科技棋牌游戏服务，从构建基础设施到游戏上线到后期精细化运营，腾正科技服务涵盖项目整个发展周期。在防御策略上采用三重防护设计，有效黑客入侵、预防恶意注册、流量作弊、撞库盗号、暴力破解、DDOS攻击、CC攻击、SYN攻击等，保障游戏交易平台及支付服务安全。
                        </p>
                        <a class="consult-btn text-center" href="javascript: void(0);">立即咨询</a>
                    </div>
                    <img class="arch-img" src="{{ asset("/images/program/chess-arch.png") }}" alt="棋牌云解决方案构架部署图" />
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">棋牌游戏服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>轻松应对DDoS攻击</span>
                            </div>
                            <div class="item-body">
                                <p style="word-break: break-all;">
                                    有效解决黑客控制僵尸网络对服务器发起的流量攻击，提供300Gbps以上的防御定制服务，支持HTTP/HTTPS/TCP/UDP，保障交易正常进行，
                                    高可用，高可信和高可靠。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>可信赖防御系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    有效防止黑客入侵，预防恶意注册、流量作弊、撞库
                                    <br/>
                                    盗号，暴力破解，保障游戏交易平台及支付服务安全。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>智能加速不卡顿</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    1000+节点网络分发服务，根据用户访问情况智能分配节点，大大提高用户访问网站的速度，解决因地域、带宽和服务器性能造成的访问瓶颈。游戏不卡顿，玩家更稳定。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>海量日志数据分析</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    启用简单日志服务对游戏日志进行存储查询，通过DPC整合日志数据到ODPS中，实现海量日志数据分析。为游戏云用户提供数据支撑。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 金融云 -->
        <div class="tab-pane" id="finance" role="tabpanel" aria-labelledby="finance-tab">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">金融云解决方案</h2>
                    <h5 class="sub-text">
                        个性化定制高防金融云解决方案，一站式服务解决金融行业互联互通、海量访问、数据安全、网页加速、成本高等问题，
                        <br/>
                        助您快速实现业务部署，抢占市场先机
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">金融云面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon10.png") }}" />
                            <span class="text">互联互通</span>
                        </div>
                        <div class="card-body">
                            <p>各金融体系、机构的数据标准、接口等有待进一步统一，以便提供更便捷的数据交换和处理；而现实是通常多机构多种标准或接口，系统整合难度大。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon3.png") }}" />
                            <span class="text">数据量大</span>
                        </div>
                        <div class="card-body">
                            <p>
                                在国外，银行客户数或账户数超过千万就属于型银行，相当于我国四大银行一些省级分行数据，而中国工行2002年完成的数据集中工程有3亿多账户。数据量太大，其存储和处理给IT带来了很大挑战。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon4.png") }}" />
                            <span class="text">数据的安全性</span>
                        </div>
                        <div class="card-body">
                            <p>金融领域对于数据安全以及用户隐私保护的需求要比其他任何行业要求都高。金融行业是具体管钱的行业，客户的隐私、企业的数据安全、产品安全等等都尤其重要。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon6.png") }}" />
                            <span class="text">成本过高</span>
                        </div>
                        <div class="card-body">
                            <p>金融体系、机构整合云端面临技术投入大，成本高，不灵活，运维难度大，交付周期长等一系列问题，使中小企业望而却步，错失市场商机。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title" style="color: #fff;">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/white-rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/finance-arch.png") }}" alt="金融云解决方案构架部署图" />
                    <div>
                        <p class="desc" style="color: #fff;">
                            金融云微金融解决方案为P2P、小贷、典当、担保、众筹等小微金融企业提供定制个性化的云计算服务。互联网微金融用户也能享有金融级的安全保障；海量计算、弹性部署能解决互联网业务
                            <br/>
                            的海量并发问题，同时大幅降低初创企业IT成本。此外，腾正科技联手合作伙伴共同打造微金融生态链，提供一站式解决方案平台。在整个产品选择和设计上，腾正科技努力为金融用户创造
                            <br/>
                            一个安全可靠的运行环境，并为用户提供一支可信赖的技术运维支持团队，可以帮助客户完成从前期规划、实施、应用迁移，到后期运维每一阶段的工作，为金融行业持续发展做出贡献。
                        </p>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">金融云服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>双重防御系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    腾正科技与金盾联合打造双重防火墙设计，有<br/>
                                    效对抗DDOS攻击，CC攻击，WAF攻击等。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>近源分流防护</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    采用智能分发平台，按照近源防护原则，提升<br/>
                                    网站数据加载和传输速度，减少单点防护的压<br/>
                                    力，更好的保证了防护效果和网民体验度。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>BGP多线线路</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    腾正科技为金融云用户提供BGP多线专线线<br/>
                                    路，由网络上的骨干路由器根据路由跳数与其它<br/>
                                    技术指标来确定的最佳访问路由，不占用服务器<br/>
                                    的任何系统资源，能真正实现高速的单IP访问。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>集群技术管理</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    腾正科技服务器基于集群技术，实现多节点共<br/>
                                    同参与计算，自动并行处理并负载均衡，轻松<br/>
                                    应对硬件故障问题。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-5.png") }}" alt="adv5" />
                                <span>自动清洗系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    10T+防御带宽，配备T量级超强硬件清洗平<br/>
                                    台，高达480G的防御能力，独立过滤CC的<br/>
                                    功能，可满足金融行业对网络安全方面的需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-6.png") }}" alt="adv6" />
                                <span>低成本高性能</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    随着机房的扩容以及业务的不断增加，信息管<br/>
                                    理系统的操作也随之变得更加复杂。腾正科技<br/>
                                    为用户研发了灵活易用的用户管理中心，让用<br/>
                                    户简单便捷灵活地管理自己业务。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 流媒体 -->
        <div class="tab-pane" id="streaming_media" role="tabpanel" aria-labelledby="streaming-media-tab">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
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
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
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
                <h2 class="title" style="color: #fff;">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/white-rectangle.png") }}">
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
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>企业级的固态硬盘</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    硬盘输出性能对流媒体点播是至关重要的因素，<br/>
                                    所以必须优化硬盘"读写"性能。腾正采用企业级<br/>
                                    固态硬盘（SSD），提高了数据I/O读写速度。
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
                                    自有机房自组内网，搭建负载均衡，高可用架构，<br/>
                                    分担流媒体服务器的负荷，消除单点故障，提升了<br/>
                                    流媒体服务的稳定性和可靠性。
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
                                    流媒体运营过程中，可根据用户量随时增加或者<br/>
                                    合并服务器，利用负载均衡，自动分配用户流量，<br/>
                                    满足服务器平滑扩展需求。
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
                                    全国骨干网6大核心交换节点，优质骨干网接入，<br/>
                                    提高线路访问速度，解决延迟、丢包现象，满足<br/>
                                    各种类型流媒体用户运营需求。
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
                                    自主CDN加速1000+节点网络分发服务，解决<br/>
                                    因地域、带宽和服务器性能造成的访问瓶颈，<br/>
                                    提升网站高并发访问时数据加载和传输速度。
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
                                    提供高防DDos服务，Web应用防护、入侵检测、<br/>
                                    Web漏洞扫描服务，支持服务器、数据库自动<br/>
                                    备份及秒级回档功能，降低企业运营风险。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 移动APP -->
        <div class="tab-pane" id="mobile_app" role="tabpanel" aria-labelledby="mobile-app-tab">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">移动APP云化解决方案</h2>
                    <h5 class="sub-text">
                        高效开发快速上云，助力业务快速发展！腾正科技旨在为开发者提供模块功能化的通用移动应用基础服务，<br/>
                        解决移动APP客户营销困难、高并发、数据安全调度不精准等难题
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">移动APP面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon13.png") }}" />
                            <h5 class="text">营销推广困难</h5>
                        </div>
                        <div class="card-body">
                            <p>移动APP推广难，用户下载量少，留存率低；如何提高下载量及留存率成为每个移动应用开发企业关注的核心问题</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon14.png") }}" />
                            <h5 class="text">投入大迭代快</h5>
                        </div>
                        <div class="card-body">
                            <p>开发一款APP，团队需统筹处理各个环节，资源投入要求高，开发效率难保障，企业需保障产品质量的同时，缩短上线及迭代周期</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon15.png") }}" />
                            <h5 class="text">运营分析能力</h5>
                        </div>
                        <div class="card-body">
                            <p>终端种类多，适配量大；数据呈现分散；综合性能、用户体验等问题是移动APP产品从开发到上线需要一直关注并迭代改进
                            <p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon16.png") }}" />
                            <h5 class="text">峰值访问量大</h5>
                        </div>
                        <div class="card-body">
                            <p>业务受影响因素较多，访问量存在极大不确定性，既要保证业务可用性，应对业务高峰做到及时扩展，又要避免资源浪费</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon17.png") }}" />
                            <h5 class="text">体验难以保障</h5>
                        </div>
                        <div class="card-body">
                            <p>用户地域分布范围不确定，业务迅猛发展使流量分发存在瓶颈，需要覆盖全国的优质网络，来支撑良好的接入体验</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon18.png") }}" />
                            <h5 class="text">数据安全风险</h5>
                        </div>
                        <div class="card-body">
                            <p>APP的运营过程会受到来自各方面的安全挑战，如DDoS攻击、病毒、木马等，严重威胁业务运营和数据信息安全</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/mobile-app-arch.png") }}"
                    alt="移动APP解决方案构架部署图" />
                    <div style="position: absolute; bottom: -30px; right: 40px;">
                        <p class="desc">
                            APP业务上线初期，时刻会面临用户爆炸式增长情况，访问量存在极大不确定性，使用腾正云服务，可根据业务需求和策略，自动计算资源<br/>
                            弹性调整应对流量波峰，为用户提供流畅的网络体验。在防御策略上采用三重防护设计，有效黑客入侵、预防恶意注册、流量作弊、撞库盗号、<br/>
                            暴力破解、DDOS攻击、CC攻击、SYN攻击等，保障平台数据信息及支付服务安全。
                        </p>
                        <br/>
                        <a class="consult-btn" style="float: right;" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">移动APP服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>集群管理系统</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    防入侵监测系统，硬件监控系统，网络故障分析平台，数据灾备系统，保障服务器在安全的环境下运行。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>万兆带宽接入</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    采用万兆网络接入，多个CC防护集群组合，建立高效的CC攻击防护基础，满足各种类型的移动APP用户运营需求。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>总出口达10T</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    海量机柜，数据中心覆盖全国，总出口规模达到10T，带宽资源充足，随时升级G口带宽，轻松满足顾客的扩展需求。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>CDN智能加速</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    自主CDN加速1000+节点网络分发服务，应对APP大量内容分发，随需使用，经济高效，解决因地域、带宽和服务器性能造成的访问瓶颈。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-5.png") }}" alt="adv5" />
                                <span>冗余机制完善</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    在设备、节点和网络三个层面上实现了完善的冗余，保证在设备或节点出现故障时，不会影响用户的正常访问。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-6.png") }}" alt="adv6" />
                                <span>弹性增值服务</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    简单易用弹性云主机，海量存储，灵活部署，一对一专属客服售前咨询服务和售后跟踪服务，全面解决疑问。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 教育云 -->
        <div class="tab-pane" id="education_cloud" role="tabpanel" aria-labelledby="education-cloud-tab">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">教育云解决方案</h2>
                    <h5 class="sub-text">
                        结合教育地域特性，为各种教育场景快速搭建智能化信息平台，将教育管理、教务、教学应用等系统集成化，<br/>
                        推进教育行业的数字化和智能化，促进行业的转型升级
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">教育云面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon19.png") }}" />
                            <span class="text">教育局</span>
                        </div>
                        <div class="card-body">
                            <p>
                                教育信息化产品品类庞杂，不能将数据统一、规整，不能实时掌握所辖地区的教育数据，如全部学生、教师人数男女生比例，班额情况等，而传统纸质的通知、审批工作，周期长、效率低，不能高效落实和收集反馈。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon20.png") }}" />
                            <span class="text">高校</span>
                        </div>
                        <div class="card-body">
                            <p>
                                应用系统较多，缺少统一认证机制，学生、教师身份信息管理复杂；网络、存储等设施设备落后于需求与技术的发展，缺乏统一管理和调度；安全、容灾、备份系统不够完善，稳定性与可靠性不够，整体效率偏低。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon21.png") }}" />
                            <span class="text">中小学</span>
                        </div>
                        <div class="card-body">
                            <p>学校管理工作仍偏传统未实现智慧化，整体效率偏低；家校沟通较不畅，家长不能及时了解学生在校学习及生活情况；教师日常事务性工作繁琐，不能全身心投入教学。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon22.png") }}" />
                            <span class="text">幼儿园</span>
                        </div>
                        <div class="card-body">
                            <p>家长不能及时掌握幼儿进园、出园动态；家长较难了解孩子在幼儿园时的表现和动态；幼儿园信息化建设较薄弱，数字化教学资源较短缺。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/education-cloud-arch.png") }}"
                    alt="教育云解决方案构架部署图" />
                    <div style="max-width: 1180px; margin: 0 auto;padding-left: 10px;padding-right: 10px;">
                        <div class="desc">
                            <h5 style="text-align: left; color: #1e2251; font-weight: 600;">
                                将教育管理、教务、教学应用等系统集成化，实现统一数据中心、统一身份认证、统一用户平台，创造“云端”服务：
                            </h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span>基础设施虚拟化（大集中）——集中管理、按需分配、并行计算、海量存储；</span>
                                </li>
                                <li class="list-group-item">
                                    <span>应用软件集成化（大集成）-----统一部署、综合服务、数据共享、便于应用；</span>
                                </li>
                                <li class="list-group-item">
                                    <span>将服务器与存储进行虚拟化管理，实现一机变多机或多机变一机的动态管理，多任务同步处理；</span>
                                </li>
                                <li class="list-group-item">
                                    <span>教育资源价值化（大数据）——资源共建、数据一致、全面统览、个性应用。</span>
                                </li>
                            </ul>
                        </div>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">教育云服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>面向教育管理者</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    利用云端办公环境，快速便捷地处理学籍、人事、资产及办公信息，提高工作效率和管理水平，减轻工作强度。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>面向家长</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    架设学校和家庭之间的沟通桥梁，加强老师、家长、学生之间的联系，通过网络促进学校教育和家庭教育的结合。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>面向教师</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    提供云端网络备课授课、课件制作、网上阅卷的平台，在更大范围内共享思想与资源，提高教学质量与教学水平。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>面向学生</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    以学生成长档案为核心，通过全新的智能式、协作式、探索式手段开展学习与评价，全面提高学生的综合素质与能力。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 政务云 -->
        <div class="tab-pane" id="government_cloud" role="tabpanel" aria-labelledby="government-cloud-tab">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">政务云安全解决方案</h2>
                    <h5 class="sub-text">
                        基于政务应用系统的综合安全防御需求，一站式解决系统利用率低、能源消耗高、各政务系统相互隔离、安全性能差等核心问题<br/>
                        构建安全、合规、互访、可靠的绿色政务云平台
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">政务云面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon23.png") }}" />
                            <span class="text">ISV安全开发能力不足</span>
                        </div>
                        <div class="card-body">
                            <p>对于应用软件源代码安全风险意识不足；容易导致Web应用系统存在安全漏洞。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon24.png") }}" />
                            <span class="text">缺乏纵深防御体系</span>
                        </div>
                        <div class="card-body">
                            <p>黑客攻击手法也非常多样化；而传统安全防护手段强调单点防护，缺乏纵深防御体系支撑。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon11.png") }}" />
                            <span class="text">缺乏未知威胁检测能力</span>
                        </div>
                        <div class="card-body">
                            <p>传统安全防护设备均基于静态策略及已知特征进行“黑白名单”式的规则匹配，无法应对复杂Web攻击。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon25.png") }}" />
                            <span class="text">缺乏整体持续监控能力</span>
                        </div>
                        <div class="card-body">
                            <p>部分政务单位具有一定的安全能力，但缺乏整体的持续监控能力；而在持续攻击时代，显然有些力不从心。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title" style="color: #fff;">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/white-rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/government-cloud-arch.png") }}"
                    alt="政务云解决方案构架部署图" />
                    <div style="max-width: 1180px; margin: 0 auto; text-align: center;">
                        <div class="desc">
                            <div style="display: inline-block;">
                                <h5 style="font-weight: 600;">多项增值安全服务内容选择</h5>
                                <p>1.支持标配安全产品能力升级</p>
                                <p>2.提供多项安全审计产品选择</p>
                                <p>3.有机结合第三方安全产品</p>
                            </div>
                            <div style="display: inline-block; margin-left: 80px;">
                                <h5 style="font-weight: 600;">典型政务应用安全架构</h5>
                                <p>腾正政务云专属客户，只需开通云资源服务，便可免费获得以下标配的多项高等级安全能力</p>
                                <p style="font-weight: 600;">标配的高等级安全能力</p>
                                <p>主机安全防御能力Web安全防御能力DDoS攻击防御能力</p>
                            </div>
                        </div>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">政务云服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>满足政府监管单位的合规要求</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    腾正科技为东莞电子政务搭建的云平台涵盖IaaS层、PaaS层、DaaS层、SaaS层（包括云盘文控、政务网信息监查平台、统一门户平台、市政信息推送平台）、安全体系、运维服务体系。有效的整合了已有资源，初步实现了全市政务信息化的统一管理。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>弹性资源按需分配成本更低</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    IT硬件零投入，云设施零维护量，随时按需开通、释放资源，快速敏捷满足不同时期政务业务需求，有效降低了政务成本。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>多层安全体系保障政务云安全</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    平台具备独特的产品架构，兼容多种品牌的服务器，通过应用安全、系统安全、数据安全、网络安全全方位控制，建立一套完备的安全体系，达到安全稳定服务高效有序便捷的管理目的，有效提升东莞政务工作效率。 </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>全生命周期一条龙服务支撑</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    专业的服务团队一对一专属架构师提供从上云培训、认证服务，到上云专业服务及云上保障服务，全面保障政务云平台数据信息安全。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 网站部署 -->
        <div class="tab-pane" id="website_deployment" role="tabpanel" aria-labelledby="website-deployment-tab">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">网站及部署解决解决方案</h2>
                    <h5 class="sub-text">
                        灵活弹性自动化的基础IT设施建设、 按需付费的服务模式以及0成本的运维IT服务体系<br/>
                        为企业及开发者用户量身构建从0到N的网站全生命周期一站式闭环服务
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">网站云面临的问题</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon26.png") }}" />
                            <span class="text">配置选型</span>
                        </div>
                        <div class="card-body">
                            <p>
                                如果用户已经拥有网站程序，那么就需要根据实际业务情况选择合适的云服务器，并在服务器上部署程序运行所需要的语言环境。如果用户初次使用云服务，那么如何选择CPU，硬盘，内存，带宽的大小就成为用户首先遇到的问题。
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon27.png") }}" />
                            <span class="text">安全隐患</span>
                        </div>
                        <div class="card-body">
                            <p>
                                网站部署OK后，如何规避网络攻击、网页内容被篡改，木马植入，数据库泄漏，黑客勒索等安全风险？如何保障网站安全稳定运行？如果自行搭建安全体系往往会让成本成倍的增长，而且很复杂。无疑给用户带来更大的成本以及时间压力。
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon28.png") }}" />
                            <span class="text">数据备份</span>
                        </div>
                        <div class="card-body">
                            <p>
                                随着网站的发展，积累的数据越来越多，比如静态文件（代码、图片等）和数据库数据。如果需要用户实时自行备份，那所花费的时间以及精力无疑也会成倍的增长。所以解决如何解决数据备份又是企业以及开发者面临的问题之一！
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon29.png") }}" />
                            <span class="text">I/O读写</span>
                        </div>
                        <div class="card-body">
                            <p>
                                大部分网站都属于交互型网站，速度快，能让多处理器的性能发挥出来。当前技术条件下，I/O是系统性能提高的瓶颈，I/O问题没有解决好，处理器数量增加不一定带来性能的提升，新增资源有可能被I/O全部消耗掉。
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title" style="color: #fff;">解决方案构架部署</h2>
                <img class="d-block" src="{{ asset("/images/program/white-rectangle.png") }}">
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/website-deployment-arch.png") }}"
                    alt="网站部署解决方案构架部署图" />
                    <div>
                        <p class="desc">
                            网站及部署解决方案为企业以及开发者用户实现灵活弹性自动化的基础IT设施建设、 按需付费的服务模式以及0成本的运维IT服务体系。
                            把传统的IDC数据中心改造成了一个高度简化、标准化、<br/>
                            自动化和弹性灵活的云数据中心。使得企业以及开发者的IT支撑系统从“成本中心”而转型成为推动企业核心业务不断发展的引擎。
                        </p>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">网站云服务优势</h2>
                <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}" />
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>弹性扩展</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    当网站用户在面对云服务器配置选型的问题时，腾正科技针对网站用户个性的配置选择需求、同时可临时资源扩展的诉求，支持产品随时随地秒级扩展IT资源，轻松解决配置选型问题，高效便捷，节约成本。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>自带防御</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    随着互联网的发展，DDOS、CC攻击已成为非常普遍的攻击模式。网站安全稳定运行成为了每个用户的愿望！腾正科技网站解决方案，针对这一问题，各个已开放的节点自带默认防御峰值。真正从根本上解决网络安全问题，保护用户网站免受攻击威胁！
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>全景备份</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    针对网站用户面临的备份问题，腾正科技推出高效便捷的实时全景备份/全景恢复功能。用户可以自定义备份事件，通过控制台一键备份，使数据安全在得到最大的保证的同时，降低用户备份成本。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>1V1专席客服</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    网站用户上云前期面临多种多样的个性化问题，随时都需要有人来协助解如环境部署、数据迁移、售后运维等问题。但行业传统工单服务模式已被用户广为诟病，因此腾正进行改革创新，每个用户配备1名专席客服，在工作时间帮助用户解决疑难杂症。
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
