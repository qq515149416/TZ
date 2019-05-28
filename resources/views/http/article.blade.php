@extends('layouts.layout')

@section('title', $tdk['title'])

@section('keywords', $tdk['keywords'])

@section('description', $tdk['description'])

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
