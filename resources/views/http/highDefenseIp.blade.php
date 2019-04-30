@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div class="tz-protection-content" id="high-defense-ip">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">DDOS 高防 IP</h2>
                <h5 class="sub-text">
                    腾正DDoS高防IP是针对互联网服务器（包括非腾正云主机）在遭受大流量DDoS攻击后导致服务不可用的<br/>
                    情况下，推出的付费增值服务，用户可通过配置高防IP，将攻击流量引流到高防IP，确保源站的稳定可靠，<br/>
                    保障用户的访问质量和对内容提供商的黏度。
                </h5>
            </div>
            <a class="apply-btn" href="javascript: void(0);">立即申请</a>
        </div>
        <div class="tab">
            <a class="tab-item" href="/protection/high-defense-cdn">高防CDN</a>
            <a class="tab-item active" href="/protection/high-defense-ip">DDOS高防IP</a>
            <a class="tab-item" href="/protection/c-shield">防C盾</a>
        </div>
    </div>
    <!--特点-->
    <div class="feature">
        <h2 class="title"> DDOS 高防 IP 特点</h2>
        <img class="d-block" src="{{ asset("/images/highDefenseIp/rectangle.png") }}" />
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
        <h2 class="title"> DDOS 高防 IP 功能</h2>
        <img class="d-block" src="{{ asset("/images/highDefenseIp/rectangle.png") }}" />
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
        <h2 class="title" style="color: #fff;">应用场景</h2>
        <img class="d-block" src="{{ asset("/images/highDefenseIp/white-rectangle.png") }}" />
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
        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
    </div>
</div>
@endsection
