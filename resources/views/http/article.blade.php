@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
    <div id="article" class="row">
        @aboutusLayout(['title' => '新闻中心', 'subtitle' => '互联网行业资讯', 'descripts' => '帮你了解行业情况，介绍我们的情况'])
        @slot('nav')
            <li role="presentation" class="{{ $type === 'company' ? 'active' : '' }}"><a href="#company" aria-controls="company" role="tab" data-toggle="tab">公司动态</a></li>
            <li role="presentation" class="{{ $type === 'placard' ? 'active' : '' }}"><a href="#placard" aria-controls="placard" role="tab" data-toggle="tab">公司公告</a></li>
            <li role="presentation" class="{{ $type === 'industry' ? 'active' : '' }}"><a href="#industry" aria-controls="industry" role="tab" data-toggle="tab">行业动态</a></li>
        @endslot
            <div role="tabpanel" class="tab-pane {{ $type === 'company' ? 'active' : '' }} clearfix" id="company">
                <h2>
                    公司动态
                    <span class="pull-right">
                        <a href="#">首页</a> >
                        <a href="#">新闻中心</a> >
                        <a href="#" class="active">公司动态</a>
                    </span>
                </h2>
                <ul>
                    @foreach ($data['company'] as $i => $item)
                    <li>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <span class="date-day">
                                    {{ date("d",strtotime($item->createdate)) }}
                                    </span>
                                    <span class="date-years">
                                    {{ date("Y.m",strtotime($item->createdate)) }}
                                    </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="#">
                                    <h4 class="media-heading">
                                        @if ($item->status)
                                            <span class="top">置顶</span>
                                        @endif
                                        {{ $item->titles }}
                                    </h4>
                                    <p>
                                    {{ $item->digest }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                {{ $data['company']->links() }}
            </div>
            <div role="tabpanel" class="tab-pane {{ $type === 'placard' ? 'active' : '' }} clearfix" id="placard">
                <h2>
                    公司公告
                    <span class="pull-right">
                        <a href="#">首页</a> >
                        <a href="#">新闻中心</a> >
                        <a href="#" class="active">公司公告</a>
                    </span>
                </h2>
                <ul>
                    @foreach ($data['placard'] as $i => $item)
                    <li>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <span class="date-day">
                                    {{ date("d",strtotime($item->createdate)) }}
                                    </span>
                                    <span class="date-years">
                                    {{ date("Y.m",strtotime($item->createdate)) }}
                                    </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="#">
                                    <h4 class="media-heading">
                                        @if ($item->status)
                                            <span class="top">置顶</span>
                                        @endif
                                        {{ $item->titles }}
                                    </h4>
                                    <p>
                                    {{ $item->digest }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane {{ $type === 'industry' ? 'active' : '' }} clearfix" id="industry">
                <h2>
                    行业动态
                    <span class="pull-right">
                        <a href="#">首页</a> >
                        <a href="#">新闻中心</a> >
                        <a href="#" class="active">行业动态</a>
                    </span>
                </h2>
                <ul>
                    @foreach ($data['industry'] as $i => $item)
                    <li>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <span class="date-day">
                                    {{ date("d",strtotime($item->createdate)) }}
                                    </span>
                                    <span class="date-years">
                                    {{ date("Y.m",strtotime($item->createdate)) }}
                                    </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="#">
                                    <h4 class="media-heading">
                                        @if ($item->status)
                                            <span class="top">置顶</span>
                                        @endif
                                        {{ $item->titles }}
                                    </h4>
                                    <p>
                                    {{ $item->digest }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endaboutusLayout
    </div>
@endsection
