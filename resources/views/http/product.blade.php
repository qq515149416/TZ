@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
    <div id="server_product" class="row">
        <!-- banner -->
        <div class="banner">
            <div class="title" style="color: #fff;">
            <p class="text">服务器托管</p>
            <p class="sub-text">您的托付，我们全力以赴！</p>
            </div>
            <div class="bottom">
            <a class="btn-link {{ $page == 'dianxin' ? 'active' : '' }}" href="/zuyong/dianxin">电信服务器租用</a>
            <a class="btn-link {{ $page == 'liantong' ? 'active' : '' }}" href="/zuyong/liantong">联通服务器租用</a>
            <a class="btn-link {{ $page == 'shuangxian' ? 'active' : '' }}" href="/zuyong/shuangxian">双线服务器租用</a>
            <a class="btn-link {{ $page == 'sanxian' ? 'active' : '' }}" href="/zuyong/sanxian">三线服务器租用</a>
            <a class="btn-link {{ $page == 'bgp' ? 'active' : '' }}" href="/zuyong/bgp">BGP服务器租用</a>
            </div>
        </div>
        <section class="jumbotron data-center">
            <div class="versionHeart">
                <h2>数据中心</h2>
                <div class="main-content">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#hengyang" aria-controls="hengyang" role="tab" data-toggle="tab">湖南衡阳机房</a></li>
                        <li role="presentation"><a href="#huizhou" aria-controls="huizhou" role="tab" data-toggle="tab">广东惠州机房</a></li>
                        <li role="presentation"><a href="#xian" aria-controls="xian" role="tab" data-toggle="tab">陕西西安机房</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="hengyang">
                            <h3>湖南衡阳机房</h3>
                            <p>机房概况：腾正科技湖南衡阳机房出口总带宽860G，直连中国电信骨干网；采用200G集群防火墙，有效防止网络攻击；机房面积达3000平方米，可容纳1288个42U国际标准机柜；电力设备方面，机房两路市电，排除电力故障带来的影响；UPS 艾默生力博特 Hipluse 系统，保证网络的持续稳定；美国卡特 2000KVA 柴油发电机组，为机房稳定运行提供强大保障。</p>
                            <p>
                                机房等级：国家 <span class="focus">AAAA</span> 级机房
                                <a href="#">查看机房实景</a>
                            </p>
                            <div class="data-table">
                                <div class="data-table-row">
                                    <div class="data-table-col">
                                        线路
                                    </div>
                                    <div class="data-table-col">
                                        规格
                                    </div>
                                    <div class="data-table-col">
                                        内存
                                    </div>
                                    <div class="data-table-col">
                                        硬盘
                                    </div>
                                    <div class="data-table-col">
                                        带宽
                                    </div>
                                    <div class="data-table-col">
                                        IP数
                                    </div>
                                    <div class="data-table-col">
                                        单机防御
                                    </div>
                                    <div class="data-table-col">
                                        月付
                                    </div>
                                    <div class="data-table-col">
                                        年付
                                    </div>
                                </div>
                                <div class="data-table-row">
                                    <div class="data-table-col">
                                        衡阳电信
                                    </div>
                                    <div class="data-table-col">
                                        八核16线程Xeon E5530*2/L5630*2
                                    </div>
                                    <div class="data-table-col">
                                        8G
                                    </div>
                                    <div class="data-table-col">
                                        1T SATA
                                    </div>
                                    <div class="data-table-col">
                                        G口20M独享
                                    </div>
                                    <div class="data-table-col">
                                        1个
                                    </div>
                                    <div class="data-table-col">
                                        40G
                                    </div>
                                    <div class="data-table-col">
                                        700
                                    </div>
                                    <div class="data-table-col">
                                        7700
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="huizhou">
                            惠州机房
                        </div>
                        <div role="tabpanel" class="tab-pane" id="xian">
                            西安机房
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
