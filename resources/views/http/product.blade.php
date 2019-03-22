@extends('layouts.layout')

@section('title', '服务器租用，服务器托管，专业IDC服务商')

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
    </div>
@endsection
