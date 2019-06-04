@extends('layouts.layout')

@section('title', $tdk['title'])

@section('keywords', $tdk['keywords'])

@section('description', $tdk['description'])

@section('content')
    <div id="article" class="row">
        @aboutusLayout(['title' => '新闻中心', 'subtitle' => '腾正新闻中心第一时间为您洞悉提供IDC、云计算、网络安全、大数据、CDN加速、互联网综合应用解决方案', 'descripts' => '行业政策&解读等最新资讯及分析报告。'])
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
