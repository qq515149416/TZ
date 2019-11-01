@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="overseas" class="row">
    <div class="banner">
        <div class="version-heart">
            <h3>海外服务器<span>| 全球服务器租用</span></h3>
            <div class="description">
                <ul>
                    <li>高品质标准：T级机房，接入国际骨干</li>
                    <li>多配置可选：配置丰富，多配置扩展</li>
                    <li>高性价比：性能＞价格，谁用谁知道</li>
                </ul>
            </div>
            <div class="bottom">
                <a class="btn-link" href="javascript:;">亚洲服务器</a>
                <!-- <a class="btn-link" href="javascript:;">欧洲服务器</a> -->
                <a class="btn-link" href="javascript:;">美洲服务器</a>
                <!-- <a class="btn-link" href="javascript:;">非洲服务器</a> -->

            </div>
        </div>
    </div>
    <!-- 热销产品 -->
    <div class="hot-product">
        <div class="title">
            <h2 class="text">热销产品</h2>
            <h5 class="sub-text">超值特惠多种高性能组合套餐，满足您核心应用场景需求</h5>
        </div>
        <div class="content">
            <div class="d-block-container version-heart">
                <div class="item">
                    <div class="card">
                        <div class="card-head">
                            <h4 class="card-title">
                                新加波
                                <span>下单即享<em>9</em>折</span>
                            </h4>
                            <div class="price">
                                <span class="amount">990</span>
                                <span class="unit">元/月</span>
                                <span class="original-price">
                                    (原价：<del>1100元/月</del>)
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <ul class="desc">
                                    <li>
                                        <span>
                                            CPU：E3
                                        </span>
                                        <span>
                                            型号：1230V3
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            内存：8G
                                        </span>
                                        <span>
                                            硬盘类型：HDD
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            I P 数量：1
                                        </span>
                                        <span>
                                            硬盘大小：1T
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            线程：4核8线程
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            支持硬件升级：是
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            带宽：
                                            <span>
                                                · 20M独享接入<br />
                                                （包含5M回国优质）<br />
                                                · 20M纯国际带宽
                                            </span>
                                        </span>
                                    </li>
                                </ul>
                                <a class="detail-link" href="javascript: void(0);">了解详情</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
