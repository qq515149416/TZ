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
								<input type="button" id="btn" style="background-image: url({{ asset("/images/wap/搜索.png") }});">
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
								<p>{{$con->content}}</p>
							</div>

						@endforeach
						
						<div class="bottom">
							<div style="width: 95px;">
							<a href="/"><img src="{{ asset("/images/wap/第一页.png") }}" alt=""></a>
								<a href="/wap/search_results?keywords={{$keyword}}&&page={{$page_members['current_page']-1}}"><img src="{{ asset("/images/wap/上一页.png") }}" alt=""></a>
							</div>

							<div class="page" id="page">
								<span>{{$page_members['current_page']-1}}</span>/{{$page_members['current_page']+1}}
							</div>
							<div style="width: 95px;">
								<a href="/wap/search_results?keywords={{$keyword}}&&page={{$page_members['current_page']+1}}"><img src="{{ asset("/images/wap/下一页.png") }}" alt=""></a>
								<a href="/wap/search_results?keywords={{$keyword}}&&page={{$page_members['max_page']+1}}"><img src="{{ asset("/images/wap/最后一页.png") }}" alt=""></a>
								
							</div>
						</div>
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
											
											</div>
										</div>
										<div class="pre">
											上一篇：<p>上一篇</p>
										</div>
										<div class="next">
											下一篇：<p>下一篇</p>
										</div>
										<img src="{{ asset("/images/wap/上一篇.png") }}" alt="">
									</div>
							</div> 
				</div>
			</div>
		</div>
	</div>
<!-- </body> -->
<script>
// function goPage(pno, psize) {
// 	var news = document.querySelectorAll(".option-text .news");
// 	var num = news.length;
// 	var totalPage = 0;//总页数
// 	var pageSize = psize;//每页显示行数
// 	//总共分几页
// 	if (num / pageSize > parseInt(num / pageSize)) {
// 		totalPage = parseInt(num / pageSize) + 1;
// 	} else {
// 		totalPage = parseInt(num / pageSize);
// 	}
// 	var currentPage = pno;//当前页数
// 	var startRow = (currentPage - 1) * pageSize + 1;//开始显示的行  31
// 	var endRow = currentPage * pageSize;//结束显示的行   40
// 	endRow = (endRow > num) ? num : endRow;
// 	//遍历显示数据实现分页
// 	for (var i = 1; i < (num + 1); i++) {
// 		var irow = news[i - 1];
// 		if (i >= startRow && i <= endRow) {
// 			irow.style.display = "block";
// 		} else {
// 			irow.style.display = "none";
// 		}
// 	}

// 	var tempStr = "";
// 	if (currentPage > 1) {
// 		tempStr += "<div style=\"width: 90px;\">";
// 		tempStr += "<img src=\"/images/wap/第一页.png\" onClick=\"goPage(" + (1) + "," + psize + ")\">";
// 		tempStr += "<img src=\"/images/wap/上一页.png\" onClick=\"goPage(" + (currentPage - 1) + "," + psize + ")\">";
// 		tempStr += "</div>";

// 	} else {
// 		tempStr += "<div style=\"width: 90px;\">";
// 		tempStr += "<img src=\"/images/wap/第一页.png\" >";
// 		tempStr += "<img src=\"/images/wap/上一页.png\" >";
// 		tempStr += "</div>";
// 	}
// 	if (currentPage >=10 ) {
// 		tempStr += "<div class=\"page\" id=\"page\">";
// 		tempStr += "<span>"  + currentPage + "</span>"
// 	} else {
// 		tempStr += "<div class=\"page\" id=\"page\">";
// 		tempStr += "<span>" + "0" + currentPage + "</span>"
// 	}
// 	if(totalPage>=10){
// 		tempStr += "/" + totalPage;
// 		tempStr += "</div>";
// 	}else{
// 		tempStr += "/0" + totalPage;
// 		tempStr += "</div>";
// 	}
// 	if (currentPage < totalPage) {
// 		tempStr += "<div style=\"width: 90px;\">";
// 		tempStr += "<img src=\"/images/wap/下一页.png\" onClick=\"goPage(" + (currentPage + 1) + "," + psize + ")\">";
// 		tempStr += "<img src=\"/images/wap/最后一页.png\" onClick=\"goPage(" + (totalPage) + "," + psize + ")\">";
// 		tempStr += "</div>";
// 	} else {
// 		tempStr += "<div style=\"width: 90px;\">";
// 		tempStr += "<img src=\"/images/wap/下一页.png\" >";
// 		tempStr += "<img src=\"/images/wap/最后一页.png\">";
// 		tempStr += "</div>";
// 	}

// 	document.getElementById("bottom").innerHTML = tempStr;
// }
</script>

@endsection