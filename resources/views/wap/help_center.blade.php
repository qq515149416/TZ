@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')


@if(!empty(session('help_tip')))
　　
<div class="alert alert-success" role="alert" style="z-index: 999">
	{{session('help_tip')}}
</div>
<script>
	setInterval(function(){
		$('.alert').remove();
	},3000);
</script>
@endif

<!-- 帮助中心 -->
<div id="help_center">
		<div class="main-body">
			<div class="tz-container clear">
				<!-- 内容 -->
				<div class="main-content">
				<div class="posters">
						<img src="{{ asset("/images/wap/帮助中心海报.png") }}" alt="">
						<div class="search">
							<p class="search-t">帮助中心</p>
							<div class="search-c">
								
								<form action='/wap/search_results' method='get'>
									<input type="text" name="keyword" id="" placeholder="请输入关键词题的答案" required="required">
									<input type="submit" value="" style="background-image: url({{ asset("/images/wap/搜索.png") }});">
								</form>
							</div>
							<div class="search-f">
								<p>热门：怎么选择服务器租用商 | 服务器托管好吗</p>
								<p>云主机安全吗 | 大带宽价格 | 网络安全</p>
							</div>
							
						</div>
					</div>
					<div class="title">
						<p>常见自主服务</p>
						<div class="title-hr"></div>
					</div>
					<div class="independent-service">
						<ul class="clear">
							<li>
								<img src="{{ asset("/images/wap/找回密码.png") }}" alt="">
								<p>找回密码</p>
							</li>
							<li>
								<img src="{{ asset("/images/wap/账户充值.png") }}" alt="">
								<p>账户充值</p>
							</li>
							<li>
								<img src="{{ asset("/images/wap/财务管理.png") }}" alt="">
								<p>财务管理</p>
							</li>
						</ul>
					</div>
					<!-- 产品常见问题 -->
					<div class="common-problems">
						<div class="title">
							<p>产品常见问题</p>
							<div class="title-hr"></div>
						</div>
						<div class="help-problems">
							<div class="tz-main">
								<ul>
									@foreach ($nav_main as $item)
									<li class="clear">
										<a href="/wap/help_center_home/{{ $item->id }}?page=1">
											<span class="dian"></span>
											<p>{{ $item->name }}</p>
											<p>共 <span>{{$item->num}}</span> 文档</p>
										</a>
									</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection