@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
    <div id="article" class="row">
        @aboutusLayout(['title' => '新闻中心', 'subtitle' => '互联网行业资讯', 'descripts' => '帮你了解行业情况，介绍我们的情况'])
        @slot('nav')
            @foreach ($list['nav'] as $i => $item)
                <li role="presentation" class="{{ $type === $item['name'] ? 'active' : '' }}"><a href="{{ $item['url'] }}" aria-controls="{{ $item['name'] }}" role="tab" data-toggle="tab">{{ $item['content'] }}</a></li>
            @endforeach
        @endslot
            @foreach ($list['content_list'] as $i => $item)
                <div role="tabpanel" class="tab-pane {{ $type === $item['name'] ? 'active' : '' }} clearfix" id="{{ $item['name'] }}">
                    @include($item['template'],['data' => $data[$item['name']], 'vars' => $item])
                </div>
            @endforeach
        @endaboutusLayout
    </div>
@endsection
