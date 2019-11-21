@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 防御流量叠加包 -->
<div id="flow_stack_packet">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/防御流量叠加包海报.png") }}" alt="">
                        <a class="posters-btn posters-left">了解更多</a>
                    </div>
                    <div class="title">
                        <p>流量叠加包套餐</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="tz-fuwu">
                        <div class="tz-main">
                            <div class="tz-fuwu-box">
                                <div class="fuwu-li ">
                                    <div class="flow_stack-fuwu-li">
                                        <p class="flow_stack-li-t">50G防御流量</p>
                                        <div class="flow-fuwu-li-i">
                                            <ul>
                                                <li class="clear">
                                                    <div>天数</div>
                                                    <div>价格</div>
                                                    <div>
                                                        购买
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>1天</div>
                                                    <div>￥70.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>7天</div>
                                                    <div>￥210.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>30天</div>
                                                    <div>￥560.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="fuwu-li">
                                    <div class="flow_stack-fuwu-li">
                                        <p class="flow_stack-li-t">100G防御流量</p>
                                        <div class="flow-fuwu-li-i">
                                            <ul>
                                                <li class="clear">
                                                    <div>天数</div>
                                                    <div>价格</div>
                                                    <div>
                                                        购买
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>1天</div>
                                                    <div>￥126.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>7天</div>
                                                    <div>￥350.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>30天</div>
                                                    <div>￥1050.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="fuwu-li">
                                    <div class="flow_stack-fuwu-li">
                                        <p class="flow_stack-li-t">200G防御流量</p>
                                        <div class="flow-fuwu-li-i">
                                            <ul>
                                                <li class="clear">
                                                    <div>天数</div>
                                                    <div>价格</div>
                                                    <div>
                                                        购买
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>1天</div>
                                                    <div>￥210.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>7天</div>
                                                    <div>￥560.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                                <li class="clear">
                                                    <div>30天</div>
                                                    <div>￥1960.00</div>
                                                    <div onclick="buyit()">
                                                        <!-- 立即购买 -->
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 购买弹窗 -->
                    <div class="pop-buy select">
                        <div class="p-buy">
                            <div class="close" onclick="closes()"><img src="{{ asset("/images/wap/关闭按钮.png") }}" alt=""></div>
                            <p class="buy-ttitle">叠加包购买</p>
                            <div class="buy-m">名称：<p>50G防御流量</p></div>
                            <div class="buy-m">天数：<p>1天</p></div>
                            <div class="buy-m">价格：<p>70.00</p></div>
                            <input type="text" placeholder="请输入购买数量">
                            <div class="price clear">总价： <span>￥</span> <p>70.00</p> <a href="javascript:;">购买</a> </div>
                        </div>
                    </div>
                    <div class="service-advantages" style="z-index: 100;">
                        <div class="title">
                            <p>DDoS防御流量叠加包特点</p>
                            <div class="title-hr"></div>
                        </div>
                        <img src="{{ asset("/images/wap/DDoS 防御流量叠加包特点.png") }}" alt="">
                        <img class="backgroundimg" 
                        
                            src="{{ asset("/images/wap/叠加包背景.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">高可用服务</div>
                                    <div class="fuwu-txt">针对攻击流量自动启用防护策略，防御力达99.99%
                                    </div>
                                </li>
                                <li>
                                    <div class="fuwu-title">超高性价比</div>
                                    <div class="fuwu-txt">提供按天/周/月弹性模式，降低企业运维成本</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">即开即用</div>
                                    <div class="fuwu-txt">系统毫秒自动开通，无需人工入，可重复购买</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">使用范围</div>
                                    <div class="fuwu-txt">腾正防御流量叠加包。只限先高防机房IP地址</div>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <!-- 机房优势 -->
                    <div class="compouter-advantage-gn">
                        <div class="title">
                            <p style="color: #fff !important;">DDoS防御流量叠加包功能</p>
                            <div style="background-color: #fff !important;" class="title-hr"></div>
                        </div>
                        <div class="advantage-li clear">
                            <div class="tz-main">
                                <ul>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/防御弹性扩展.png") }}" alt="">
                                        <div>防御弹性扩展</div>
                                        <p>按不同业务及发展需求按天、按周、按月即买即用，防护阈值可随时弹性调整，在整个调整过程中服务无中断。</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/自动全面防护.png") }}" alt="">
                                        <div>自动全面防护</div>
                                        <p>根据攻击的流量和连接数阀值来自动触发攻击防护，对威胁进行阻断过滤，确保源站稳定安全&业务正常运行。</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/支持不同业务.png") }}" alt="">
                                        <div>支持不同业务</div>
                                        <p>支持网站和非网站业务，如各类大型游戏、支付金融平台、流媒体、政企等各类易受攻击且需高防御业务行业。</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/全景数据分析.png") }}" alt="">
                                        <div>全景数据分析</div>
                                        <p>提供多纬度实时统计报表，如流量报表、DDoS和CC防护清洗报表、流量图等，让您及时获得当前服务详情。</p>
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
                                            alt=""> </div>
                                    <p class="font-b">适用行业：金融、电商、企业门户类网站</p>
                                    <p>网站类业务最易受攻击，因黑客可通过DNS解析轻松获取网站服务器真实IP，然后对服务器IP进行大流量ddos/cc攻击，导致网站访问缓慢或直接瘫痪。</p>
                                </div>
                                <div class="application-items">
                                    <div class="clear">游戏类业务 <img src="{{ asset("/images/wap/游戏类业务.png") }}"
                                            alt=""> </div>
                                    <p class="font-b">适用行业：各类端游,手游等网络游戏,各类应用程序产品</p>
                                    <p>游戏类是攻击最严重的行业，同行恶意竞争者通过各种攻击手段，让大批量游戏玩家频繁掉线，玩游戏卡顿，攻击停服，甚至无法登陆接入游戏，最终让大批玩家流失。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="methodofuse">
                        <div class="title">
                            <p>DDoS防御流量叠加包使用方法</p>
                            <div class="title-hr"></div>
                        </div>
                        <div class="tz-main">
                            <img src="{{ asset("/images/wap/叠加包使用方法.png") }}" alt="">
                        </div>

                    </div>
                    <!-- 防御流量叠加包常见问题 -->
                    <div class="common-problems">
                        <div class="title">
                            <p>防御流量叠加包常见问题</p>
                            <div class="title-hr"></div>
                        </div>
                        <div class="problems-li">
                            <div class="tz-main">
                                <ul>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>DDoS防御流量叠加包应用场景分析 </p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>DDoS防御流量叠加包特点有哪些</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>DDoS防御流量叠加包购买流程 </p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>腾正高防御流量叠加包使用说明</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>什么是腾正高防御流量叠加包？ </p>
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
                            立即申请
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

@endsection
