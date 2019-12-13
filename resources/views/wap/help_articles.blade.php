@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<div id="Help_articles">
    <div class="news-content ">
		<div class="content">
			<div class="content-title">
				{{$content['title']}}
			</div>
			<div class="content-time">{{$content['created_at']}}</div>
			<div class="content-main">
				{{$content['description']}}
			</div>
			<div class="content-text clear">
				{!! $content['content'] !!}
			</div>
		</div>
		<div class="news-more">
			<a href="/wap/help_articles/{{$pre_next['pre']['id']}}">
				<p>上一篇：{{$pre_next['pre']['title']}}</p>
			</a>
			<a href="/wap/help_articles/{{$pre_next['next']['id']}}">
				<p>下一篇：{{$pre_next['next']['title']}}</p>
			</a>
			<a href="/wap/help_center_home/{{$content['category_id']['id']}}?page=1">
				<img src="{{ asset("/images/wap/内容页按钮.png") }}" alt="">
			</a>
		</div>
	</div>
</div>

@endsection