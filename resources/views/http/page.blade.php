@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

    <div class="row">
        <div class="iframe">
            @if (strpos($p,".html"))
            <iframe width="100%" scrolling="no" seamless frameborder="0" src="https://www.tulingit.net:8443/{{ $directory }}/{{ $p }}" height="3065px"></iframe>
            @else
            <iframe width="100%" scrolling="no" seamless frameborder="0" src="https://www.tulingit.net:8443/{{ $directory }}/{{ $p }}.jsp" height="3065px"></iframe>
            @endif
        </div>
    </div>

@endsection
