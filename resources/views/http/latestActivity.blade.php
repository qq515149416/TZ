@extends('layouts.layout')

@section('title', '腾正最新活动-服务器限时优惠-云主机打折促销-服务器特惠[腾正科技]')

@section('keywords', '腾正最新活动,服务器特惠,打折促销,限时优惠,云主机打折促销，服务器提供商')

@section('description', '腾正最新活动汇聚了腾正科技最新的服务器租用托管，机柜大带宽，高防服务器，高防IP，CDN，云主机促销打折、限时优惠等特惠活动信息，还有各种新品的免费试用服务。')

@section('content')
<div class="tz-latest-activity">
    <!--banner-->
    <div class="banner">
        <h2 class="title font-bold">活动专题</h2>

        <h5 class="sub-title font-regular">
            最新上线、专享特惠、精选秒杀、免费体验， 助力创未来
        </h5>
    </div>
    <!--活动-->
    <div class="activity">
        <div class="card-container">
            <a class="card" href="/mid_autumn" target="_blank">
                <div class="card-image">
                    <img src="{{ asset("/images/lastestActivity/activity-8.png") }}" />
                    <span class="ongoing">活动中</span>
                </div>
                <div class="card-body">
                    <h5 class="title font-heavy">迎中秋庆国庆:腾正高防服务器高防IP买一送一，新品5折疯抢</h5>
                    <p class="desc">
                        中秋国庆双节同庆，腾正科技四重大礼钜惠全网。优惠一：买高防IP，送WAF 1个月；优惠二：买高防服务器，送100G防御流量叠加包；优惠三：一键商城系统5折特惠，助力搭建属于你的电商平台；优惠四：新注册用户10G防御云主机66元包月，送20M带宽，续费价格不变。
                    </p>
                </div>
            </a>
            <a class="card" href="/dist/highDefense.html" target="_blank">
                <div class="card-image">
                    <img src="{{ asset("/images/lastestActivity/activity-3.png") }}" />
                    <span class="ongoing">活动中</span>
                </div>
                <div class="card-body">
                    <h5 class="title font-heavy">腾正高防IP专业DDOS防御首选</h5>
                    <p class="desc">腾正高防IP专业DDOS防御首选，T+级防护系统，毫秒级过滤引擎，精准识别秒级响应，支持不同业务模式</p>
                </div>
            </a>
            <a class="card disable" href="javascript: void(0);" target="_blank">
                <div class="card-image">
                    <img src="{{ asset("/images/lastestActivity/activity-9.png") }}" />
                    <span class="end">活动结束</span>
                </div>
                <div class="card-body">
                    <h5 class="title font-heavy">92周年八一建军节：军民同庆，共筑强国</h5>
                    <p class="desc">没有网络安全 就没有国家安全，热烈庆祝中国人名解放军建军92周年，网络安全企业首选腾正科技高防服务器，防御流量包三重大礼，军民同庆，共筑强国！</p>
                </div>
                <div class="mask"></div>
            </a>
            <a class="card disable" href="javascript: void(0);" target="_blank">
                <div class="card-image">
                    <img src="{{ asset("/images/lastestActivity/activity-7.png") }}" />
                    <span class="end">活动结束</span>
                </div>
                <div class="card-body">
                    <h5 class="title font-heavy">同行五载，感恩钜惠，谢谢一路有您</h5>
                    <p class="desc">腾正科技6.20成立5周年感恩钜惠，感恩一路有您的支持！本次活动一年仅有一次，错过再等一年，点击查看活动详情。</p>
                </div>
                <div class="mask"></div>
            </a>
            <a class="card disable" href="javascript: void(0);">
                <div class="card-image">
                    <img src="{{ asset("/images/lastestActivity/activity-1.png") }}" />
                    <span class="end">活动结束</span>
                </div>
                <div class="card-body">
                    <h5 class="title font-heavy">40G真实防御高防游戏云主机只需139元，续费价格不变</h5>
                    <p class="desc">5动全网 1降到底！40G真实防御高防游戏云主机，只需139元，续费价格不变！限时抢购进行中</p>
                </div>
                <div class="mask"></div>
            </a>
            <a class="card disable" href="javascript: void(0);">
                <div class="card-image">
                    <img src="{{ asset("/images/lastestActivity/activity-2.png") }}" />
                    <span class="end">活动结束</span>
                </div>
                <div class="card-body">
                    <h5 class="title font-heavy">游戏专配爆款200G高防服务器888限时抢购进行中</h5>
                    <p class="desc">游戏专配爆款，开区保驾领航！200G高防服务器,100M独享带宽,SSD固态硬盘，机房直销888元火热抢购进行中……</p>
                </div>
                <div class="mask"></div>
            </a>
            <a class="card disable" href="javascript: void(0);">
                <div class="card-image">
                    <img src="{{ asset("/images/lastestActivity/activity-4.png") }}" />
                    <span class="end">活动结束</span>
                </div>
                <div class="card-body">
                    <h5 class="title font-heavy">腾正云春节聚惠30M独享宽带仅需39元/月</h5>
                    <p class="desc">过了双12，春节福利又来了，30M云服务器低至39元/月，再次来袭！</p>
                </div>
                <div class="mask"></div>
            </a>
            <a class="card disable" style="visibility: hidden;" href="javascript: void(0);">

            </a>
        </div>
    </div>
</div>
@endsection
