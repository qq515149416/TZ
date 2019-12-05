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

							<div class="help-home-s news title2">
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
							</div>
							<div class="help-home-content" style="display: none;">
								<div class="problem-content">
									<p class="p-title">{{$con->title}}</p>
									<p class="time">{{$con->created_at}}</p>
									<div class="content-text-s">{!! $con->content !!}</div>
								</div>
								<div class="more">
										<div class="label">
											<div>标 &nbsp; 签：</div>
											<div>
											@if (count($con->keywords) != 0)
												@if ($con->keywords[0] != '')
													@for ($i = 0; $i < count($con->keywords); $i++)
														<span>{{ $con->keywords[$i] }}</span >
													@endfor
												@endif
											@endif
											</div>
										</div>
										<div class="pre">
											上一篇：<p>上一篇</p>
										</div>
										<div class="next">
											下一篇：<p>下一篇</p>
										</div>
										<a href="/wap/help_center_home/{{$page_members['category_id']}}?page={{$page_members['current_page']}}">
											<img src="{{ asset("/images/wap/上一篇.png") }}" alt="">
										</a>
									</div>
							</div>
						@endforeach
						
						
						<div class="bottom" id="bottom">
						
							<div style="width: 95px;">
								<a href="/wap/help_center_home/{{$page_members['category_id']}}?page=1"><img src="{{ asset("/images/wap/第一页.png") }}" alt=""></a>
									<a class="a-pap" href="/wap/help_center_home/{{$page_members['category_id']}}?page={{$page_members['current_page']-1}}"><img src="{{ asset("/images/wap/上一页.png") }}" alt=""></a>
								</div>
								<div class="page" id="page">
									<span>0{{$page_members['current_page']}}</span>/<span class="max-page">0{{$page_members['max_page']}}</span>      <!-- {{$page_members['current_page']+1}} -->
								</div>
								<div style="width: 95px;">
									<a class="a-next" href="/wap/help_center_home/{{$page_members['category_id']}}?page={{$page_members['current_page']+1}}"><img src="{{ asset("/images/wap/下一页.png") }}" alt=""></a>
									<a href="/wap/help_center_home/{{$page_members['category_id']}}?page={{$page_members['max_page']}}"><img src="{{ asset("/images/wap/最后一页.png") }}" alt=""></a>
								</div>
						</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
 
 <script>

	if("{{$page_members['max_page']}}"==0){
		document.querySelector(".max-page").innerHTML="01";
	}
	if("{{$page_members['current_page']}}"==1){
		document.querySelector(".a-pap").onclick = function () {
			return false;
		}
	}
	if("{{$page_members['current_page']}}"=="{{$page_members['max_page']}}"){
		document.querySelector(".a-next").onclick = function () {
			return false;
		}
	}
	var s_p = document.querySelectorAll(".content-text-s p");
      for(var i=0;i<s_p.length;i++){
        if(s_p[i].innerHTML==""){
		  s_p[i].style.display="none";
        }else if(s_p[i].innerHTML=="<br>"){
			s_p[i].style.display="none";
		}
      }
	</script>

@endsection
