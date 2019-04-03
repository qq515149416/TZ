@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="tz-program">
    <div class="tab" role="tablist">
        <a class="tab-item active"
           id="game-tab"
           href="#game"
           role="tab"
           aria-controls="game"
           aria-selected="true">游戏</a>
        <a class="tab-item"
           id="chess-tab"
           href="#chess"
           role="tab"
           aria-controls="chess"
           aria-selected="false">棋牌</a>
        <a class="tab-item"
           id="finance-tab"
           href="#finance"
           role="tab"
           aria-controls="finance"
           aria-selected="false">金融</a>
        <a class="tab-item"
           id="streaming-media-tab"
           href="#streaming_media"
           role="tab"
           aria-controls="streaming_media"
           aria-selected="false">流媒体</a>
        <a class="tab-item"
           id="mobile-app"
           href="#mobile_app"
           role="tab"
           aria-controls="mobile_app"
           aria-selected="false">移动APP</a>
        <a class="tab-item"
           id="education-cloud"
           href="#education_cloud"
           role="tab"
           aria-controls="education_cloud"
           aria-selected="false">教育云</a>
        <a class="tab-item"
           id="government-cloud"
           href="#government_cloud"
           role="tab"
           aria-controls="government_cloud"
           aria-selected="false">政务云</a>
        <a class="tab-item"
           id="smart-city"
           href="#smart_city"
           role="tab"
           aria-controls="smart_city"
           aria-selected="false">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content tab-content">
        <!-- 游戏云 -->
        <div class="tab-pane in active" id="game" role="tabpanel" aria-labelledby="game-tab">
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
                                <img class="order" src="{{ asset("/images/program/adv1.png") }}" alt="adv1" />
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
                                <img class="order" src="{{ asset("/images/program/adv2.png") }}" alt="adv2" />
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
                                <img class="order" src="{{ asset("/images/program/adv3.png") }}" alt="adv3" />
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
                                <img class="order" src="{{ asset("/images/program/adv4.png") }}" alt="adv4" />
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
                                <img class="order" src="{{ asset("/images/program/adv5.png") }}" alt="adv5" />
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
                                <img class="order" src="{{ asset("/images/program/adv6.png") }}" alt="adv6" />
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
                                <img class="order" src="{{ asset("/images/program/adv1.png") }}" alt="adv1" />
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
                                <img class="order" src="{{ asset("/images/program/adv2.png") }}" alt="adv2" />
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
                                <img class="order" src="{{ asset("/images/program/adv3.png") }}" alt="adv3" />
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
                                <img class="order" src="{{ asset("/images/program/adv4.png") }}" alt="adv4" />
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
                                <img class="order" src="{{ asset("/images/program/adv1.png") }}" alt="adv1" />
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
                                <img class="order" src="{{ asset("/images/program/adv2.png") }}" alt="adv2" />
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
                                <img class="order" src="{{ asset("/images/program/adv3.png") }}" alt="adv3" />
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
                                <img class="order" src="{{ asset("/images/program/adv4.png") }}" alt="adv4" />
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
                                <img class="order" src="{{ asset("/images/program/adv5.png") }}" alt="adv5" />
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
                                <img class="order" src="{{ asset("/images/program/adv6.png") }}" alt="adv6" />
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
                                <img class="order" src="{{ asset("/images/program/adv1.png") }}" alt="adv1" />
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
                                <img class="order" src="{{ asset("/images/program/adv2.png") }}" alt="adv2" />
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
                                <img class="order" src="{{ asset("/images/program/adv3.png") }}" alt="adv3" />
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
                                <img class="order" src="{{ asset("/images/program/adv4.png") }}" alt="adv4" />
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
                                <img class="order" src="{{ asset("/images/program/adv5.png") }}" alt="adv5" />
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
                                <img class="order" src="{{ asset("/images/program/adv6.png") }}" alt="adv6" />
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
