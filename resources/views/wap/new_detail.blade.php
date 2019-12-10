@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div>
<!-- 企业文化 -->
<div id="company_introduction_news">
		<div class="main-body">
			<div class="tz-container clear">

				<!-- 内容 -->
				<div class="main-content">
					<div class="posters">
						<img src="{{ asset("/images/wap/企业文化海报.png") }}" alt="">
						<a class="posters-btn">立即咨询</a>
					</div>
					<div class="drop-options">
						<div class="drop-options">  
							<p onclick="machineroom(this)">新闻公告</p>
							<span class="arrow"></span>
							<ul class="select-text clear">
								<li class="option-i" value="0" selected><a href="/wap/company/company_introduction">公司简介</a></li>
								<li class="option-i" value="1"><a href="/wap/company/news">新闻公告</a></li>
								<li class="option-i" value="2"><a href="/wap/company/honor">荣誉资质</a></li>
								<li class="option-i" value="3"><a href="/wap/company/culture">企业文化</a></li>
								<li class="option-i" value="4"><a href="/wap/company/progress">发展历程</a></li>
								<li class="option-i" value="5"><a href="/wap/company/contact">联系我们</a></li>
								<li class="option-i" value="6"><a href="/wap/company/pay">支付中心</a></li>
							</ul>
						</div>
					</div>
					<!-- 新闻公告 内容页 -->
					<div class="news-content ">
						<div class="content">
							<div class="content-title">
								{{$news->title}}
							</div>
							<div class="content-time">{{$news->created_at}}</div>
							<div class="content-main">
								{{$news->digest}}
							</div>
							<div class="content-text clear">
								{!! $news->content !!}
							</div>
						</div>
						<div class="news-more">
							<a href="/wap/new/detail/{{$pre_next['pre']['id']}}">
								<p>上一篇：{{str_limit($pre_next['pre']['title'],30,'....')}}</p>
							</a>
							<a href="/wap/new/detail/{{$pre_next['next']['id']}}">
								<p>下一篇：{{str_limit($pre_next['next']['title'],30,'....')}}</p>
							</a>

							<a href="/wap/new/detail/{{$pre_next['pre']['id']}}">
								<img src="{{ asset("/images/wap/内容页按钮.png") }}" alt="">
							</a>
						</div>
					</div>

					<!-- 蓝条 -->
					<!-- <div class="solutions-consulting">
						<img src="{{ asset("/images/wap/企业文化蓝条.png") }}" alt="">
						<a>
							立即咨询
						</a>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
var s_p = document.querySelectorAll(".content-text p");
      for(var i=0;i<s_p.length;i++){
        if(s_p[i].innerHTML==""){
		  s_p[i].style.display="none";
        }else if(s_p[i].innerHTML=="<br>"){
			s_p[i].style.display="none";
		}else if(s_p[i].innerHTML=="&nbsp;"){
			s_p[i].style.display="none";
		}else if(s_p[i].innerHTML=="　　"){
			s_p[i].style.display="none";
		}
      }
// 公司简介
machineroom();
function machineroom(){
	var arrows = document.querySelector(".drop-options .arrow");
	if(document.querySelector(".select-text").style.display=="none"){
	  document.querySelector(".select-text").style.display="block";
	  arrows.style.transform = "rotate(135deg)";
	  arrows.style.transition = "transform 0.4s";
	}else{
	  document.querySelector(".select-text").style.display="none";
	  arrows.style.transform = "rotate(-45deg)";
	  arrows.style.transition = "transform 0.4s";
	}
	document.addEventListener("touchmove", function(e){
	  if(e.target == document.querySelector(".drop-options p")||e.target ==document.querySelector(".select-text") ){
		document.querySelector(".select-text").style.display="block";
	   document.querySelector(".drop-options .arrow").style.transform = "rotate(135deg)";
	   document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
	  }else{
		moreContent.style.display = "none"
		document.querySelector(".select-text").style.display="none";
	   document.querySelector(".drop-options .arrow").style.transform = "rotate(-45deg)";
	   document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
	  }
	})
  }
</script>

@endsection
