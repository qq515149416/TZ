@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

	<!-- 搜索结果 -->
	<div id="search_results">
		<div class="main-body">
			<div class="tz-container clear">
				<!-- 内容 -->
				<div class="main-content">
					<div class="posters">
						<img src="{{ asset("/images/wap/帮助中心海报.png") }}" alt="">
						<div class="search">
							<p class="search-t">帮助中心</p>
							<div class="search-c">
								<input type="text" name="search" id="searchwords" placeholder="请输入关键词题的答案">
								<a>
									<input type="button" id="btn" style="background-image: url({{ asset("/images/wap/搜索.png") }});">
								</a>
							</div>
							<div class="search-f">
								<p>热门：怎么选择服务器租用商 | 服务器托管好吗</p>
								<p>云主机安全吗 | 大带宽价格 | 网络安全</p>
							</div>
						</div>
					</div>
					<div class="feedback">
						从搜索框搜索“ <p id="keywords">{{$keyword}} </p> ”后的页面如下
					</div>
					<div class="option-text" id="option-text help-search">

						@foreach ($data as $con)

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
									<!-- <div class="pre">
										上一篇：<p>上一篇</p>
									</div>
									<div class="next">
										下一篇：<p>下一篇</p>
									</div>
									<a href="/wap/search_results?keyword={{$keyword}}&&page={{$page}}">
										<img src="{{ asset("/images/wap/上一篇.png") }}" alt="">
									</a> -->
								</div>
							</div> 
						@endforeach
						
						<div class="bottom" id="bottom">
							<div style="width: 90px;">
							<a href="/wap/search_results?keyword={{$keyword}}&&page=1"><img src="{{ asset("/images/wap/第一页.png") }}" alt=""></a>
								<a class="a-pap" href="/wap/search_results?keyword={{$keyword}}&&page={{$page_members['current_page']-1}}"><img src="{{ asset("/images/wap/上一页.png") }}" alt=""></a>
							</div>

							<div class="page" id="page">
								<span class="current-page">{{$page_members['current_page']}}</span>/<span class="max-page">{{$page_members['max_page']}}</span>
							</div>
							<div style="width: 90px;">
								<a class="a-next" href="/wap/search_results?keyword={{$keyword}}&&page={{$page_members['current_page']+1}}"><img src="{{ asset("/images/wap/下一页.png") }}" alt=""></a>
								<a href="/wap/search_results?keyword={{$keyword}}&&page={{$page_members['max_page']}}"><img src="{{ asset("/images/wap/最后一页.png") }}" alt=""></a>
								
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
<!-- </body> -->
<script>
var help_home_s = document.querySelectorAll(".option-text .help-home-s");
var testabc = document.querySelectorAll(".testabc")
for(var i=0;i<help_home_s.length;i++){
    help_home_s[i].addEventListener("click",function(){
        for(var i=0;i<testabc.length;i++){
            testabc[i].style.display="none";
        }
       document.querySelector(".help-home-content").style.display="block";
       document.querySelector( "#bottom").style.display="none";
      })
}
if("{{$page_members['max_page']}}"==0){
		document.querySelector(".max-page").innerHTML="1";
	}
	if("{{$page_members['current_page']}}"==1){
		document.querySelector(".a-pap").onclick = function () {
			return false;
		}
	}
	if(document.querySelector(".current-page").innerHTML==document.querySelector(".max-page").innerHTML){
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
		}else if(s_p[i].innerHTML=="&nbsp;"){
			s_p[i].style.display="none";
		}
      }
</script>

@endsection