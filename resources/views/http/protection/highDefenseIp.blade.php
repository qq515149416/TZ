@extends('layouts.layout')

@section('title', 'DDOS高防IP-隐藏源站IP-防ddos攻击-高防IP租用[腾正科技]')

@section('keywords', 'DDOS高防IP,隐藏源站IP,防ddos攻击,高防IP租用,高防IP功能')

@section('description', '腾正DDoS高防IP是针对互联网服务器在遭受大流量DDoS攻击后导致服务不可用的情况下，推出的付费增值服务，通过配置高防IP将攻击流量引到高防IP达到隐藏源站IP保护源站安全稳定，提升用户体验和对内容提供商的黏度。')

@section('content')
<div class="tz-protection" id="high-defense-ip">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">DDOS高防IP</h2>
                <h5 class="sub-text">
                    腾正DDoS高防IP是针对互联网服务器（包括非腾正云主机）在遭受大流量DDoS攻击后导致服务不可用的<br/>
                    情况下，推出的付费增值服务，用户可通过配置高防IP，将攻击流量引流到高防IP，确保源站的稳定可靠，<br/>
                    保障用户的访问质量和对内容提供商的黏度。
                </h5>
            </div>
            <a class="apply-btn" href="https://www.tzidc.com/dist/highDefense.html">立即申请</a>
        </div>
        <div class="tab">
            @foreach ($tabs as $item)
                <a class="tab-item {{$item['name'] === 'DDOS高防IP' ? 'active' : ''}}" href="{{ $item['href'] }}">{{ $item['name'] }}</a>
            @endforeach
            <!-- <a class="tab-item" href="/protection/high-defense-cdn">高防CDN</a>
            <a class="tab-item active" href="/dist/highDefense.html">DDOS高防IP</a>
            <a class="tab-item" href="/protection/c-shield">防C盾</a> -->
        </div>
    </div>
    <!-- 高防ip促销（临时） -->
    <div id="highDefensePromotion">

        <div class="hot-product">
            <div class="title">
                <h2 class="text">高防IP</h2>
                <h5 class="sub-text">12.12年终大促下单即享8.8折，续费价格不变</h5>
            </div>
            <div class="content">
                <div class="clearfix d-block-container">

                    <div class="item">

                        <div class="back">
                            <div class="card">
                                <div class="card-head">
                                    <p class="card-title top">
                                        <span>[促销]</span>
                                        高防IP业务-100G
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <p class="desc">
                                            防护：100
                                            <br/>
                                            机房：陕西西安
                                        </p>
                                        <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                                        <p class="price">
                                        <span style="font-size: 28px;font-family: 'pingFangHeavy';">1144</span> 元/月
                                        </p>
                                        <a class="detail-link" href="javascript: void(0);" onclick="randomqq()">了解详情</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">

                        <div class="back">
                            <div class="card">
                                <div class="card-head">
                                    <p class="card-title top">
                                        <span>[促销]</span>
                                        高防IP业务-200G
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <p class="desc">
                                            防护：200
                                            <br/>
                                            机房：陕西西安
                                        </p>
                                        <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                                        <p class="price">
                                        <span style="font-size: 28px;font-family: 'pingFangHeavy';">1660</span> 元/月
                                        </p>
                                        <a class="detail-link" href="javascript: void(0);" onclick="randomqq()">了解详情</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">

                        <div class="back">
                            <div class="card">
                                <div class="card-head">
                                    <p class="card-title top">
                                        <span>[促销]</span>
                                        高防IP业务-300G
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <p class="desc">
                                            防护：300
                                            <br/>
                                            机房：陕西西安
                                        </p>
                                        <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                                        <p class="price">
                                        <span style="font-size: 28px;font-family: 'pingFangHeavy';">3420</span> 元/月
                                        </p>
                                        <a class="detail-link" href="javascript: void(0);" onclick="randomqq()">了解详情</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">

                        <div class="back">
                            <div class="card">
                                <div class="card-head">
                                    <p class="card-title top">
                                        <span>[促销]</span>
                                        高防IP业务-500G
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <p class="desc">
                                            防护：500
                                            <br/>
                                            机房：陕西西安
                                        </p>
                                        <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                                        <p class="price">
                                        <span style="font-size: 28px;font-family: 'pingFangHeavy';">26400</span> 元/月
                                        </p>
                                        <a class="detail-link" href="javascript: void(0);" onclick="randomqq()">了解详情</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- 高防ip套餐 -->
    <div id="highDefenseProduct">
        <div class="highDefenseProduct text-center">
            <h2 class="title black">高防IP产品</h2>
            <p class="sub-title">
                我们基于用户的需求主导产品研发，提供丰富、安全、易用、灵活的产品
            </p>
            <div class="product">
                <div class="container">
                    <div class="row" id="highDefenseIpList">
                        @foreach ($data as $item)
                        <div class="col-md-3">
                            <div class="product-item">
                                <h2>{{ $item['name'] }}</h2>
                                <div class="product-item-price">
                                    <span>{{ $item['price'] }}</span>
                                    <span>元/月</span>
                                </div>
                                <div class="config">
                                    <p>防护：{{ $item['protection_value'] }}</p>
                                    <p>机房：{{ $item['site'] }}</p>
                                </div>
                                <div class="product-item-btn">
                                    <a class="btn btn-default" data-toggle="modal" data-target="#purchaseTime" data-id="{{ $item['id'] }}" href="javascript:;" role="button">立刻购买</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--特点-->
    <div class="feature">
        <h2 class="title black">DDOS高防IP特点</h2>
        <div class="cont">
            <img style="margin-top: -10px;" src="{{ asset("/images/highDefenseIp/feature-logo.png") }}" />
            <div class="item-container">
                <div class="item">
                    <h5 class="item-title">海量DDoS清洗能力</h5>
                    <p class="item-desc">10T+防御带宽，配备T量级超强硬件清洗平台，抵御不同类攻击坚如磐石</p>
                </div>
                <div class="item">
                    <h5 class="item-title">全业务支持</h5>
                    <p class="item-desc">支持网站和非网站业务，适合云内/云外金融、电商、游戏等各类业务场景</p>
                </div>
                <div class="item">
                    <h5 class="item-title">先进防御算法</h5>
                    <p class="item-desc">T级防护系统，抵御DDoS、CC攻击防护，隐藏源IP，保护源站不受攻击</p>
                </div>
                <div class="item">
                    <h5 class="item-title">高可用服务</h5>
                    <p class="item-desc">全自动检测，针对攻击流量自动启用相应防护策略，清洗服务可用性达99.99%</p>
                </div>
                <div class="item">
                    <h5 class="item-title">超高性价比</h5>
                    <p class="item-desc">提供按天弹性付费，按不同业务需求定制DDoS防护方案，降低运维成本</p>
                </div>
            </div>
        </div>
    </div>
    <!--功能-->
    <div class="function">
        <h2 class="title black">DDOS高防IP功能</h2>
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseIp/icon-1.png") }}"">
                <div class="text">
                    <h5 class="title">清洗模式严谨</h5>
                    <p class="desc">采用被动清洗方式为主、主动压制为辅的方式，对攻击进行综合运营托管，对不同类型DDoS攻击进行快速响应，保障用户可在攻击下高枕无忧。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseIp/icon-2.png") }}"">
                <div class="text">
                    <h5 class="title">隐藏用户服务资源</h5>
                    <p class="desc">T级防护系统，抵御DDoS、CC攻击防护，通过配置高防IP，使用高防IP资源作为源站的前置，将攻击流量引到高防IP达到隐藏源站IP，增加源站安全性。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseIp/icon-3.png") }}"">
                <div class="text">
                    <h5 class="title">防护阈值弹性扩展</h5>
                    <p class="desc">按照不同业务及发展需求定制DDoS防护方案，DDoS防护阈值可以随时弹性调整，可以随时升级到更高防护级别，在整个调整过程中服务无中断。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseIp/icon-4.png") }}"">
                <div class="text">
                    <h5 class="title">自动触发全面防护</h5>
                    <p class="desc">自动识别其保护的各个主机及其IP地址，根据攻击的流量和连接数阀值来设置自动触发防护选项，确保某台主机受到攻击不会影响其它主机的正常服务。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseIp/icon-5.png") }}"">
                <div class="text">
                    <h5 class="title">支持不同业务模式</h5>
                    <p class="desc">支持网站和非网站业务，把域名解析指向或把业务IP换成高防IP,并配置源站IP，使所有流量都经过高防IP机房，再转发到源站IP，从而确保源站IP稳定访问。</p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseIp/icon-6.png") }}"">
                <div class="text">
                    <h5 class="title">全景数据统计分析</h5>
                    <p class="desc">提供多纬度实时统计报表，例如业务流量报表、DDoS和CC防护清洗报表、流量图等，让您可以及时、准确获得当前的服务详情，助力业务拓展分析。</p>
                </div>
            </div>
        </div>
    </div>
    <!--应用场景-->
    <div class="scenario">
        <h2 class="title white">应用场景</h2>
        <div class="card-container">
            <div class="card">
                <div class="card-body-hover">
                    <h5 class="title">网站类业务</h5>
                    <img class="icon" src="{{ asset("/images/highDefenseIp/icon-7.png") }}"">
                    <p style="color: #2139b7;">适用行业：金融、电商、企业门户类网站</p>
                    <p style="line-height: 24px;">
                        网站类业务是最容易受到攻击的，因为黑客可通过DNS解析轻松获取网站服务器的真实IP，然后对服务器IP进行大流量ddos/cc攻击，导致网站访问缓慢或直接瘫痪。
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body-hover">
                    <h5 class="title">游戏类业务</h5>
                    <img class="icon" src="{{ asset("/images/highDefenseIp/icon-8.png") }}"">
                    <p style="color: #2139b7;">适用行业：各类型端游、手游等网络游戏产品，各类型应用程序产品</p>
                    <p style="line-height: 24px;">
                        游戏类是攻击最严重的行业，同行恶意竞争者通过各种攻击手段，让大批量游戏玩家频繁掉线，玩游戏卡顿，攻击停服，甚至无法登陆接入游戏，最终让大批玩家流失。
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--咨询-->
    <div class="consult">
        <h2 class="title">
            腾正高防专家，在岗 1 分钟，安全 60 秒
        </h2>
        <a class="consult-btn" href="javascript: void(0);" onclick="randomqq();">立即咨询</a>
    </div>
    <!-- 购买时长 -->
    <div class="modal fade" id="purchaseTime" tabindex="-1" role="dialog" aria-labelledby="purchaseTimeLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="purchaseTimeLabel">购买时长</h4>
                </div>
                <div class="modal-body">
                    <select class="form-control duration">
                        <option value="1">一个月</option>
                        <option value="6">六个月</option>
                        <option value="12">一个年</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary ok">确定</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
