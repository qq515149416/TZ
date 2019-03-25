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
        <section class="jumbotron">
            <h2>数据中心</h2>
        </section>
    </div>
@endsection
