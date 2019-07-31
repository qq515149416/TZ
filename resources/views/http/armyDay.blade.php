@extends('layouts.layout')

@section('title', $tdk['title'])

@section('keywords', $tdk['keywords'])

@section('description', $tdk['description'])

@section('content')
<div id="armyDay" class="row">
    <div class="container">
        <div class="product-idc">
            <h3 class="font-bold">腾正5周年庆特惠三重大礼</h3>
            <ul class="clearfix">
                <li class="pull-left">
                    <header>
                        <h4 class="font-medium">游戏专配爆款开区保驾领航</h4>
                        <ul>
                            <li class="font-medium">200G高防服务器</li>
                        </ul>
                    </header>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <div class="row">
                                    <div class="key">
                                        CPU
                                    </div>
                                    <div class="value font-bold">
                                        8核
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="row">
                                    <div class="key">
                                        内存
                                    </div>
                                    <div class="value font-bold">
                                        8G
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="row">
                                    <div class="key">
                                        硬盘
                                    </div>
                                    <div class="value font-bold">
                                        300GSAS/1TSATA
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="row">
                                    <div class="key">
                                        带宽
                                    </div>
                                    <div class="value font-bold">
                                        100M
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="row">
                                    <div class="key">
                                        防御
                                    </div>
                                    <div class="value font-bold">
                                        200G
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="clearfix">
                            <div class="price-info pull-left">
                                <span class="price">￥<b>888</b></span>
                                <span class="unit">元/月</span>
                            </div>
                            <a class="buy pull-right" href="javascript:randomqq();">立刻购买</a>
                        </footer>
                    </div>
                </li>
                <li class="pull-right">
                    <header>
                        <h4 class="font-medium">棋牌、手游、端游发展初期首选</h4>
                        <ul>
                            <li class="font-medium">性价比高服务器</li>
                        </ul>
                    </header>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <div class="row">
                                    <div class="key">
                                        CPU
                                    </div>
                                    <div class="value font-bold">
                                        E5530
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="row">
                                    <div class="key">
                                        内存
                                    </div>
                                    <div class="value font-bold">
                                        8G
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="row">
                                    <div class="key">
                                        硬盘
                                    </div>
                                    <div class="value font-bold">
                                        240GSSD
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="row">
                                    <div class="key">
                                        带宽
                                    </div>
                                    <div class="value font-bold">
                                        10M
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="row">
                                    <div class="key">
                                        防御
                                    </div>
                                    <div class="value font-bold">
                                        40G
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="clearfix">
                            <div class="price-info pull-left">
                                <span class="price">￥<b>450</b></span>
                                <span class="unit">元/月</span>
                            </div>
                            <a class="buy pull-right" href="javascript:randomqq();">立刻购买</a>
                        </footer>
                    </div>
                </li>
            </ul>
        </div>
        <div class="product-superimposed">
            <h3 class="font-bold">防御流量叠加包一律七折</h3>
            <div class="product-content">
                <!-- <header class="font-medium">
                    防御流量叠加包套餐
                </header> -->
                <div class="content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="content-item">
                                <h4>50G防御流量</h4>
                                <p class="font-medium">
                                    <span class="original"><del>原价：100元/天</del></span>
                                    <span class="indulgence">特惠价：<b>70</b></span>
                                    元/天
                                </p>
                                <p class="font-medium">
                                    <span class="original">
                                        <del>原价：300元/周</del>
                                    </span>
                                    <span class="indulgence">特惠价：<b>210</b></span>
                                    元/周
                                </p>
                                <p class="font-medium">
                                    <span class="original">
                                        <del>原价：800元/月</del>
                                    </span>
                                    <span class="indulgence">特惠价：<b>560</b></span>
                                    元/月
                                </p>
                                <a href="javascript:randomqq();" class="buy">立即购买</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="content-item">
                                <h4>100G防御流量</h4>
                                <p class="font-medium">
                                    <span class="original">
                                        <del>原价：180元/天</del>
                                    </span>
                                    <span class="indulgence">特惠价：<b>126</b></span>
                                    元/天
                                </p>
                                <p class="font-medium">
                                    <span class="original">
                                        <del>原价：500元/周</del>
                                    </span>
                                    <span class="indulgence">特惠价：<b>350</b></span>
                                    元/周
                                </p>
                                <p class="font-medium">
                                    <span class="original">
                                        <del>原价：1500元/月</del>
                                    </span>
                                    <span class="indulgence">特惠价：<b>1050</b></span>
                                    元/月
                                </p>
                                <a href="javascript:randomqq();" class="buy">立即购买</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="content-item">
                                <h4>200G防御流量</h4>
                                <p class="font-medium">
                                    <span class="original">
                                        <del>原价：300元/天</del>
                                    </span>
                                    <span class="indulgence">特惠价：<b>210</b></span>
                                    元/天
                                </p>
                                <p class="font-medium">
                                    <span class="original">
                                        <del>原价：800元/周</del>
                                    </span>
                                    <span class="indulgence">特惠价：<b>560</b></span>
                                    元/周
                                </p>
                                <p class="font-medium">
                                    <span class="original">
                                        <del>原价：2800元/月</del>
                                    </span>
                                    <span class="indulgence">特惠价：<b>1960</b></span>
                                    元/月
                                </p>
                                <a href="javascript:randomqq();" class="buy">立即购买</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-remind">
                <ul>
                    <li class="font-medium" data-index="1">
                        活动时间：<span>6.13-8.13</span>
                    </li>
                    <li class="font-medium" data-index="2">
                        活动对象：所有新老客户
                    </li>
                    <li class="font-medium" data-index="3">
                        活动内容：活动期间，活动用户可以以页面所示特惠价格购买产品，具体操作流程详询客服
                    </li>
                    <li class="font-medium" data-index="4">
                        本活动不与其他活动同享
                    </li>
                </ul>
        </div>
    </div>
</div>
@endsection
