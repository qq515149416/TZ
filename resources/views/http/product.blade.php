@extends('layouts.layout')

@section('title', $tdk['title'])

@section('keywords', $tdk['keywords'])

@section('description', $tdk['description'])

@section('content')
    <div id="server_product" class="row">
        <!-- banner -->
        <div class="banner">
            <div class="title" style="color: #fff;">
            <p class="text">服务器租用</p>
            <p class="sub-text">为您提供定制化硬件采购解决方案，满足您不同时期业务发展需求！</p>
            </div>
            <div class="bottom">
            <a class="btn-link {{ $page == 'dianxin' ? 'active' : '' }}" href="/zuyong/dianxin/hunan">电信服务器租用</a>
            <a class="btn-link {{ $page == 'liantong' ? 'active' : '' }}" href="/zuyong/liantong/hunan">联通服务器租用</a>
            <a class="btn-link {{ $page == 'shuangxian' ? 'active' : '' }}" href="/zuyong/shuangxian/hunan">双线服务器租用</a>
            <a class="btn-link {{ $page == 'sanxian' ? 'active' : '' }}" href="/zuyong/sanxian/hunan">三线服务器租用</a>
            <!-- <a class="btn-link {{ $page == 'bgp' ? 'active' : '' }}" href="/zuyong/bgp">BGP服务器租用</a> -->
            </div>
        </div>
        <section class="jumbotron data-center">
            <div class="versionHeart">
                <h2>数据中心</h2>
                <div class="main-content">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="{{ $room == 'hunan' ? 'active' : '' }}"><a href="/zuyong/{{$page}}/hunan">湖南衡阳机房</a></li>
                        <li role="presentation" class="{{ $room == 'guangdong' ? 'active' : '' }}"><a href="/zuyong/{{$page}}/guangdong">广东惠州机房</a></li>
                        <li role="presentation" class="{{ $room == 'xian' ? 'active' : '' }}"><a href="/zuyong/{{$page}}/xian">陕西西安机房</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        @if(count($data))
                            @tabpanel(['status' => ($room == 'hunan' ? 'active' : ''), 'id' => 'hengyang', 'index' => 'hunan'])
                            @tabpanel(['status' => ($room == 'guangdong' ? 'active' : ''), 'id' => 'huizhou', 'index' => 'huizhou'])
                            @tabpanel(['status' => ($room == 'xian' ? 'active' : ''), 'id' => 'xian', 'index' => 'xian'])
                        @endif
                    </div>

                </div>
            </div>
        </section>
        <section class="jumbotron introduction">
            <div class="versionHeart clearfix">
                <div class="pull-left">
                    <article>
                        <h4>
                            高速稳定
                        </h4>
                        <p>
                            全新戴尔，惠普，浪潮等高端品牌服务器，多种高配置XEON E5530，L5630，L5420八核16线程处理器
                        </p>
                    </article>
                    <article>
                        <h4>
                            独享宽带
                        </h4>
                        <p>
                            G口接入，独享宽带，单线，双线，三线，多种线路接入任您选择
                        </p>
                    </article>
                    <article>
                        <h4>
                            骨干网络
                        </h4>
                        <p>
                            IDC数据中心拥有以骨干网为节点的互联网网络架构
                        </p>
                    </article>
                    <article>
                        <h4>
                            三重防护
                        </h4>
                        <p>
                            金盾战略合作打造防火墙和单独CC防火墙，独立清洗功能三重防护保障，后顾无忧
                        </p>
                    </article>
                    <article>
                        <h4>
                            增值服务
                        </h4>
                        <p>
                            高速稳定的CDN内容加速和简单易用弹性云主机，海量存储，灵活部署，管家服务专业贴心的售前咨询服务和售后跟踪服务，全面解决疑问
                        </p>
                    </article>
                </div>
                <div class="pull-right">
                    <img class="icon" src="{{ asset("/images/introductionIcon.png") }}" alt="" />
                </div>
            </div>
        </section>
        <section class="jumbotron reason">
            <div class="versionHeart">
                <h4>总有一个理由让您选择我们</h4>
                <div class="container-fluid reason-content">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset("/images/product/01.png") }}" alt="" />
                            <h5>节点覆盖全国</h5>
                            <p>网络节点覆盖全国，开通多省N*40G直联链路</p>
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset("/images/product/02.png") }}" alt="" />
                            <h5>总出口达10T</h5>
                            <p>总出口规模达到10T，带宽资源充足，随时升级G口带宽</p>
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset("/images/product/03.png") }}" alt="" />
                            <h5>集群超高防御</h5>
                            <p>大带宽接入和超强防火墙集群，DDOS从此不再是噩梦</p>
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset("/images/product/04.png") }}" alt="" />
                            <h5>多节点网络监控</h5>
                            <p>多节点网络监控，随时查看服务器运行状态，故障秒级上报</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset("/images/product/05.png") }}" alt="" />
                            <h5>成熟技术团队</h5>
                            <p>拥有多年互联网安全技术研究经验的高级 网络工程师和高级研发工程师团队</p>
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset("/images/product/06.png") }}" alt="" />
                            <h5>安全防护体系</h5>
                            <p>全线采用腾正科技自主研发安全牵引系统和数据安全防护体系，有效保护客户业务数据信息安全</p>
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset("/images/product/07.png") }}" alt="" />
                            <h5>储备电力系统</h5>
                            <p>双路供电，10kv高压柴油发电机组，24h燃油储备2n后备高频UPS供电系统，电池备用时间＞2h</p>
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset("/images/product/08.png") }}" alt="" />
                            <h5>星级消防系统</h5>
                            <p>采用先进的有管网式气体消防系统，灭火介质 为FM200混合压缩气体</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="jumbotron footer">
            <h4>独立自主IDC机房，专业服务、品质保障！</h4>
            <a href="javascript:;">立即咨询</a>
        </section>
    </div>
@endsection
