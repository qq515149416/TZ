@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

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
            <a class="card" href="/souvenir" target="_blank">
                <div class="card-image">
                    <img src="{{ asset("/images/lastestActivity/activity-5.png") }}" />
                    <span class="ongoing">活动中</span>
                </div>
                <div class="card-body">
                    <h5 class="title font-heavy">同行五载，感恩钜惠，谢谢一路有您</h5>
                    <p class="desc">腾正科技6.20成立5周年感恩钜惠，感恩一路有您的支持！本次活动一年仅有一次，错过再等一年，点击查看活动详情。</p>
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
