@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 防C盾 -->
<div id="C_shield">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/防C盾海报.png") }}" alt="">
                        <a class="posters-btn posters-left">了解更多</a>
                    </div>
                    <div class="title">
                        <p>防C盾产品</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="slideshow-one">
                        <div class="slideshow-ul-one clear">
                            <div class="slideshow-li-one">
                                <div>安全防御200G</div>
                                <div>
                                    <div>
                                        <p>防御</p>
                                        DDOS(200G)/CC
                                        <p>域名</p>
                                        1个
                                    </div>
                                    <div>
                                        产品说明：分布式防御流量200G，无限防御CC攻击。
                                    </div>
                                </div>
                                <div>
                                    <p>2000</p>
                                    <p>元/月</p>
                                </div>
                                <!-- <a href="/">立即购买</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="package">
                        <div class="title back-w">
                            <p>企业服务器+CDN热销套餐</p>
                            <div class="title-hr"></div>
                        </div>
                        <div class="slideshow-package tz-main">
                            <div class="package-item">
                                <p class="package-n">IDC + CDN热销套餐优惠套 1</p>
                                <img src="{{ asset("/images/wap/优惠套餐.png") }}" alt="">
                                <div class="clear">
                                    <div class="package-item-i">
                                        <div>衡阳电信80G防御</div>
                                        <ul>
                                            <li>
                                                <p>CPU</p>XeomE5530*2 <span>L5630*2</span> 
                                            </li>
                                            <li>
                                                <p>内存</p>8G
                                            </li>
                                            <li>
                                                <p>硬盘</p>1T SATA
                                            </li>
                                            <li class="clear">
                                                <p>带宽</p><span class="Gkou">G口（20M独享）</span> 
                                            </li>
                                            <li>
                                                <p>价格</p><span>1200</span>元/月
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="package-item-i">
                                        <div>CDN加速企业版</div>
                                        <ul>
                                            <li>
                                                <p>流量</p>5TB
                                            </li>
                                            <li>
                                                <p>域名</p>2个
                                            </li>
                                            <li>
                                                <p>价格</p><span>500</span>元/月
                                            </li>
                                        </ul>
                                        <p>产品说明：网页静态资源优化加速,全站HTTPS保证网站访问安全，适用于文学类站点、小型图片站等</p>
                                        
                                    </div>
                                </div>
                                <a href="/">了解详情</a>
                            </div>
                            <div class="package-item">
                                    <p class="package-n">IDC + CDN热销套餐优惠套 2</p>
                                    <img src="{{ asset("/images/wap/优惠套餐.png") }}" alt="">
                                    <div class="clear">
                                        <div class="package-item-i">
                                            <div>惠州 100G防御</div>
                                            <ul>
                                                <li>
                                                    <p>CPU</p>
                                                    XeonX5672  
                                                </li>
                                                <li>
                                                    <p>内存</p>8G
                                                </li>
                                                <li>
                                                    <p>硬盘</p>
                                                    240GSSD
                                                    <span>（固态）</span>
                                                </li>
                                                <li class="clear">
                                                    <p>带宽</p><span class="Gkou">G口（20M独享）</span>  
                                                </li>
                                                <li>
                                                    <p>价格</p><span>1600</span>元/月
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="package-item-i">
                                            <div>CDN加速企业版</div>
                                            <ul>
                                                <li>
                                                    <p>流量</p>5TB
                                                </li>
                                                <li>
                                                    <p>域名</p>2个
                                                </li>
                                                <li>
                                                    <p>价格</p><span>500</span>元/月
                                                </li>
                                            </ul>
                                            <p>产品说明：网页静态资源优化加速,全站HTTPS保证网站访问安全，适用于文学类站点、小型图片站等</p>
                                            
                                        </div>
                                    </div>
                                    <!-- <a href="/">立即购买</a> -->
                                </div>
                        </div>
                    </div>

                    <div class="back-w">
                        <div class="title">
                            <p>防C盾特点</p>
                            <div class="title-hr"></div>
                        </div>
                        <!-- 轮播 -->
                        <div class="slideshow" id="slideshow">
                            <ul class="slideshow-ul clear">
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/独立流量清洗系统.png") }}" alt="">
                                    <div>独立流量清洗系统</div>
                                    <p>针对高度依赖网络和易受DDOS攻击等带来营业损失的客户，有效给予用户经济上和网络安全方面的保障。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/独立CC防火墙.png") }}" alt="">
                                    <div>独立CC防火墙</div>
                                    <p>独立CC防火墙设计，配合T级的集群防火墙，防护能力显著，有效防DDOS，SYN等多种类型攻击，无视CC，UDP等攻击。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/国际品牌服务器 .png") }}" alt="">
                                    <div>国际品牌服务器 </div>
                                    <p>采用戴尔、惠普、浪潮等国际高端品牌服务器，性能卓越运行稳定，实现用户数据的快速、高效处理。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/万兆大带宽接入.png") }}" alt="">
                                    <div>万兆大带宽接入</div>
                                    <p>多个CC防护集群组合，采用万兆网络接入，建立高效CC攻击防护基础，一站式解决因CC攻击使服务器带宽占用而无法正常工作。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/安全牵引系统.png") }}" alt="">
                                    <div>安全牵引系统</div>
                                    <p>自主研发的BlackHole System，最大程序优化了自由的防护体系，对各种攻击的监控和检测更加灵敏，防护更快捷更高效。</p>
                                </li>
                                <li class="slideshow-li">
                                    <img src="{{ asset("/images/wap/高性能CDN辅助.png") }}" alt="">
                                    <div>高性能CDN辅助</div>
                                    <p>在网络部署上具完备的安全机制，数百个CDN加速点负载，可以有效地预防各类黑客入侵，确保源站安全的同时更保证了网络质量。</p>
                                </li>
                            </ul>
                            <!-- 点 -->
                            <div class="point">
                                <ol class="clear slideshow-ol">
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- 防C盾特点 -->
                    <div class="compouter-advantage-gn">
                        <div class="title">
                            <p style="color: #fff !important;">防C盾特点</p>
                            <div style="background-color: #fff !important;" class="title-hr"></div>
                        </div>
                        <div class="advantage-li clear">
                            <div class="tz-main">
                                <ul>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/支持不同业务.png") }}" alt="">
                                        <div>分流防护</div>
                                        <p>采用智能分发平台，按照近源防护原则，对于特殊事件或时间段的突发大流量进行分流，减少单点防护的压力，更好的保证了防护效果。</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/冗余机制.png") }}" alt="">
                                        <div>IP负载均衡</div>
                                        <p>单节点数十台服务器机组负载均衡，保证了硬件运行的顺畅，减少CUP运行压力，全方位解决服务器性能不足的问题，提升防护效果。</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/防御弹性扩展.png") }}" alt="">
                                        <div>网络攻击防御</div>
                                        <p>利用CNAME特性隐藏源站IP，防止源站真实IP暴露，节点式分布承载DDOS/CC等网络攻击，确保在加速前提下提升网站安全性。</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/自动触发全面防护.png") }}" alt="">
                                        <div>跨地域跨机房使用</div>
                                        <p>全球领先云集群技术,通过T级集群防火墙+独立流量清洗+CC防御组合过滤精确识别,完美防御各种类型攻击,零误封,可跨地域跨机房使用。</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/性能优化.png") }}" alt="">
                                        <div>操作简单一键完成</div>
                                        <p>简单易懂的操作界面，可根据实际的情况自主更换防护信息；平台化接入，自助配置加速，只需修改域名解析即可实现接入。</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/全景数据统计分析 .png") }}" alt="">
                                        <div>全景数据统计分析 </div>
                                        <p>提供多纬度统计报表，如业务流量报表、新建和并发连接报表、DDoS和CC防护清洗报表，用户对业务和攻击情况实时掌握。</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 应用场景 -->
                    <div class="application-scenarios">
                        <div class="title">
                            <p>应用场景</p>
                            <div class="title-hr"></div>
                        </div>
                        <div class="application-box">
                            <div class="tz-main">
                                <div class="application-items">
                                    <div class="clear">网站类业务 <img src="{{ asset("/images/wap/网站类业务.png") }}"
                                            alt="">
                                    </div>
                                    <p class="font-b">适用行业：金融、电商、软件下载、企业门户类网站 </p>
                                    <p>网站类业务最易受攻击，因黑客可通过DNS解析轻松获取网站服务器真实IP，然后对服务器IP进行大流量ddos/cc攻击，导致网站访问缓慢或直接瘫痪。</p>
                                </div>
                                <div class="application-items">
                                    <div class="clear">存储分发 <img src="{{ asset("/images/wap/游戏类业务.png") }}" alt="">
                                    </div>
                                    <p class="font-b">适用行业：各类端游,手游等网络游戏,各类应用程序产品 </p>
                                    <p>游戏类是攻击最严重的行业，同行恶意竞争者通过各种攻击手段，让大批量游戏玩家频繁掉线，玩游戏卡，甚至无法登陆游戏，最终让大批玩家流失。</p>
                                </div>
                                <div class="application-items">
                                    <div class="clear">视频点播 <img src="{{ asset("/images/wap/视频点播.png") }}" alt="">
                                    </div>
                                    <p class="font-b">适用行业：在线影音、小视频类网站 </p>
                                    <p>基于腾正云海量存储、高效转码、极速分发和多端安全播放等服务打造一站式视频点播解决方案，为您提供“安全可靠、高可定制”的视频点播服务。</p>
                                </div>
                                <div class="application-items">
                                    <div class="clear">视频直播 <img src="{{ asset("/images/wap/视频直播.png") }}" alt="">
                                    </div>
                                    <p class="font-b">适用行业：视频直播品台 </p>
                                    <p>基于大规模实时流媒体计算集群和强大的音视频信号处理算法，打造"清晰流畅、低时延、高并发"的音视频直播服务。助您轻松搭建企业级在线直播平台。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 防C盾常见问题 -->
                    <div class="common-problems">
                        <div class="title">
                            <p>防C盾常见问题</p>
                            <div class="title-hr"></div>
                        </div>
                        <div class="problems-li">
                            <div class="tz-main">
                                <ul>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>防C盾适用场景分析</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>防C盾应用实例分析</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>防C盾真的能防CC吗？</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>防C盾防御原理、功能图解</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>什么是防C盾？有什么作用？</p>
                                        <p>2019.06.01</p>
                                    </li>
                                </ul>
                                <div class="view-more">
                                    查看更多
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 蓝条 -->
                    <!-- <div class="solutions-consulting">
                        <img src="{{ asset("/images/wap/防御流量叠加包蓝条.png") }}" alt="">
                        <a>
                            立即咨询
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

@endsection
