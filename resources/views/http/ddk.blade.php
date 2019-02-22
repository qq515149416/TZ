@extends('layouts.layout')

@section('title', '服务器租用，服务器托管，专业IDC服务商')

@section('content')
<div id="ddk_promotion" class="row">
    <div class="head">
        <img src="{{ asset("/images/ddk_banner.jpg") }}" alt="" />
    </div>
    <div class="body">
        <div class="title clearfix">
            <span class="pull-left"></span>
            <h3 class="pull-left">衡阳电信机房大带宽产品促销</h3>
            <span class="pull-left"></span>
        </div>
        <div class="product">
            <h4>适用场景</h4>
            <p class="dec">CDN服务，视频流媒体，下载站等高带宽需求客户。</p>
            <div class="config">
                <h5>产品配置</h5>
                <ul class="clearfix">
                    <li>
                        <span class="attr">CPU</span>
                        <span class="value">8核</span>
                    </li>
                    <li>
                        <span class="attr">内存</span>
                        <span class="value">8G/16G</span>
                    </li>
                    <li>
                        <span class="attr">硬盘</span>
                        <span class="value">240G SSD/500G SATA/1T SATA</span>
                    </li>
                    <li>
                        <span class="attr">带宽</span>
                        <span class="value">1000M</span>
                    </li>
                    <li>
                        <span class="attr">网络</span>
                        <span class="value">G口接入</span>
                    </li>
                    <li>
                        <span class="attr">域名限制</span>
                        <span class="value">不限制域名</span>
                    </li>
                    <li>
                        <span class="attr">线路</span>
                        <span class="value">湖南电信</span>
                    </li>
                    <li>
                        <span class="attr">类型</span>
                        <span class="value">高配物理服务器</span>
                    </li>
                </ul>
            </div>

            <div class="price-information">
                <span class="price">￥5999</span>
                <span class="unit">元/月</span>
                <span class="tip">限时促销</span>
            </div>

            <a href="javascript:;" class="buy">购买咨询</a>
            <p class="activity-tip">活动时间：<span class="date">2019年2月19日 — 3月31日</span></p>
        </div>
    </div>
</div>
@endsection