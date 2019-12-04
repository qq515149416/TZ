@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 帮助中心 -->
<div id="help_center_home">
	<div class="main-body">
		<div class="tz-container clear">
			<!-- 内容 -->
			<div class="main-content">
				<div class="posters">
						<img src="{{ asset("/images/wap/帮助中心海报.png") }}" alt="">
						<div class="search">
							<p class="search-t">帮助中心</p>
							<div class="search-c">
								<input type="text" name="search" id="" placeholder="请输入关键词题的答案">
								<a href="/wap/search_results">
								<input type="botton" style="background-image: url({{ asset("/images/wap/搜索.png") }});">
							</a>
							</div>
							<div class="search-f">
								<p>热门：怎么选择服务器租用商 | 服务器托管好吗</p>
								<p>云主机安全吗 | 大带宽价格 | 网络安全</p>
							</div>
							
						</div>
				</div>
			
				<div class="drop-options">
						<div class="drop-options">
							<p class="helpcenter">{{$nav_now}}</p>
							<span class="arrow"></span>
							<ul class="select-text clear" style="display: none;">
								@foreach ($nav_main as $item)
									<li class="option-i">
										<a href="/wap/help_center_home/{{ $item->id }}?page=1">
											<span>{{ $item->name }}</span>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
				</div>

				<div class="option-text {{ $page=='help_center_home'?'option-e-active':'' }}" id="help-p">
						@foreach ($son_nav as $son_item)

							<div class="help-home-s news">
								<p class="help-title">
									<a href="/wap/help_center_home/{{ $son_item->id }}?page=1" >
										<span>{{ $son_item->name }}</span>
									</a>
								</p>
								<p class="help-text">
									
								</p>
								<p class="help-time"></p>
							</div>
						@endforeach

						@foreach ($content as $con)

							<div class="help-home-s news testabc" id="{{$con->id}}">
								<p class="help-title">{{$con->title}}</p>
								<p class="help-text">{{$con->description}}</p>
								<p class="help-time">{{$con->created_at}}</p>
								<p>{{$con->content}}</p>
							</div>
						@endforeach
						
						
						<div class="bottom" id="bottom">
							<div style="width: 85px;">
									<!-- <img src="{{ asset("/images/wap/第一页.png") }}" alt=""> -->
									<a href="/wap/help_center_home/{{$page_members['category_id']}}?page={{$page_members['current_page']-1}}"><img src="{{ asset("/images/wap/上一页.png") }}" alt=""></a>
								</div>

								<div class="page" id="page">
									<span>{{$page_members['current_page']-1}}</span>/{{$page_members['current_page']+1}}
								</div>
								<div style="width: 85px;">
									<a href="/wap/help_center_home/{{$page_members['category_id']}}?page={{$page_members['current_page']+1}}"><img src="{{ asset("/images/wap/下一页.png") }}" alt=""></a>
									<a href="/wap/help_center_home/{{$page_members['category_id']}}?page={{$page_members['max_page']}}"><img src="{{ asset("/images/wap/最后一页.png") }}" alt=""></a>
									
								</div>
						</div>
				</div>
				<div class="help-home-content">
						<div class="problem-conetnt">
							<p class="p-title">万人游戏服务器该如何配置</p>
							<p class="time">2019-07-01 14:43</p>
							<div class="c-main">
									一般来说在线视频网站需大带宽来保证视频在线观看流畅度和下载速度;论坛网站需大带宽和大流量，同时具备一定的防御条件;门户网站则是尽量保证大带宽和大流量。万人游戏服务器该如何配置？
							</div>
							<p class="p-text">选择多大的服务器配置，正常情况下需要看游戏站规模大小和访问量进行选择，主要可以分为以下三种：</p>
							<p class="p-text">1. 网页小游戏：玩家规模相对较小，对游戏服务器配置要求不高，选择高配置高防云服务器或是低配置高防独立服务器就可以了，没必要花大价钱租用高配置独立服务器。</p>
							<p class="p-text">2. 中小型游戏：玩家规模比较大，通常云服务器承载会有着一定的压力，此时建议选择独立游戏服务器。值得一提的是，随着游戏运营，游戏玩家规模的增长会需求服务器配置的升级，因此需要选择能够升级服务器配置。</p>
							<p class="p-text">3. 大型游戏：对服务器要求很高，在选择游戏服务器租用时需要对服务器、数据中心、IDC商进行综合的考量。美国服务器不仅需要价格优、访问速度快、网络十分的稳定，而且不会出现卡顿等情况，非常适合大型游戏。</p>
							<p class="p-text">服务器的配置价格归价格，服务器的稳定性也很重要，稳定性好的服务器体验度自然好，也就能吸引更多游戏玩家。所以对于游戏服务器的选择一定要慎重，千万不能一味的追求低价格而忽略了服务器的稳定性。另外，作为服务器提供商的售后服务也很重要，游戏服务器租用肯定会不时的出现问题，这就需要一个良好信誉的服务器提供商，能7*24小时提供技术支持，并为一系列可能出现的问题提供解决方案，腾正科技是全球顶级互联网数据中心基础服务，自主机房一手资源提供游戏服务器租用业务，详细了解更多关于游戏服务器租用配置及费用问题请点击我们的在线咨询，我们的专业人员详细为您解答。</p>
						</div>
						<div class="more">
							<div class="label">
								<div>标 &nbsp; 签：</div>
								<div><span>游戏服务器</span> <span>游戏服务器租用</span> <span>游戏服务器配置</span></div>
							</div>
							<div class="pre">
								上一篇：<p>实现共赢彼此成就 | 腾正科技...</p>
							</div>
							<div class="next">
								下一篇：<p>没有了</p>
							</div>
							<img src="{{ asset("/images/wap/上一篇.png") }}" alt="">
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--  
 <script>
	
	function goPage(pno, psize) {
			var news = document.querySelectorAll(".option-text .news");
			var num = news.length;
			var totalPage = 0;//总页数
			var pageSize = psize;//每页显示行数
			//总共分几页
			if (num / pageSize > parseInt(num / pageSize)) {
				totalPage = parseInt(num / pageSize) + 1;
			} else {
				totalPage = parseInt(num / pageSize);
			}
			var currentPage = pno;//当前页数
			var startRow = (currentPage - 1) * pageSize + 1;//开始显示的行  31
			var endRow = currentPage * pageSize;//结束显示的行   40
			endRow = (endRow > num) ? num : endRow;
			//遍历显示数据实现分页
			for (var i = 1; i < (num + 1); i++) {
				var irow = news[i - 1];
				if (i >= startRow && i <= endRow) {
					irow.style.display = "block";
				} else {
					irow.style.display = "none";
				}
			}
		
			var tempStr = "";
			if (currentPage > 1) {
				tempStr += "<div style=\"width: 90px;\">";
				tempStr += "<img src=\"/images/wap/第一页.png\" onClick=\"goPage(" + (1) + "," + psize + ")\">";
				tempStr += "<img src=\"/images/wap/上一页.png\" onClick=\"goPage(" + (currentPage - 1) + "," + psize + ")\">";
				tempStr += "</div>";
			
			} else {
				tempStr += "<div style=\"width: 90px;\">";
				tempStr += "<img src=\"/images/wap/第一页.png\" >";
				tempStr += "<img src=\"/images/wap/上一页.png\" >";
				tempStr += "</div>";
			}
			if (currentPage >=10 ) {
				tempStr += "<div class=\"page\" id=\"page\">";
				tempStr += "<span>"  + currentPage + "</span>"
			} else {
				tempStr += "<div class=\"page\" id=\"page\">";
				tempStr += "<span>" + "0" + currentPage + "</span>"
			}
			if(totalPage>=10){
				tempStr += "/" + totalPage;
				tempStr += "</div>";
			}else{
				tempStr += "/0" + totalPage;
				tempStr += "</div>";
			}
			if (currentPage < totalPage) {
				tempStr += "<div style=\"width: 90px;\">";
				tempStr += "<img src=\"/images/wap/下一页.png\" onClick=\"goPage(" + (currentPage + 1) + "," + psize + ")\">";
				tempStr += "<img src=\"/images/wap/最后一页.png\" onClick=\"goPage(" + (totalPage) + "," + psize + ")\">";
				tempStr += "</div>";
			} else {
				tempStr += "<div style=\"width: 90px;\">";
				tempStr += "<img src=\"/images/wap/下一页.png\" >";
				tempStr += "<img src=\"/images/wap/最后一页.png\">";
				tempStr += "</div>";
			}
		
			document.getElementById("bottom").innerHTML = tempStr;
	}
	</script>
-->
@endsection
