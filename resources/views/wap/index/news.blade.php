 <div class="news">
	<div class="title">
		<p>新闻动态</p>
		<div class="title-hr"></div>
	</div>
	<div class="tz-main">
		<!-- <div class="news-item">
			<img src="{{ asset("/images/wap/新闻img.png") }}" alt="">
			<div class="news-text">
				<div class="news-text-title">
					东莞市大岭山女企业家协会莅临我司参访交流
				</div>
				<div class="news-text-content">
					5月29日上午，东莞市大岭山女企业家协会一行10余人莅临广东腾正计算机科技有限公司(以...
				</div>
				<div class="news-text-btn">
					<img src="{{ asset("/images/wap/实心.png") }}" alt="">
				</div>
				<div class="news-text-time">
					2019.05.29
				</div>
			</div>
		</div> -->
		<div class="news-items">
			@foreach ($news as $item)
			<li>
				<div class="news-text">
					<div class="news-text-title">
						{{$item->title}}
					</div>
					<div class="news-text-content">
						{{str_limit($item->digest,100,'....')}}
					</div>
					<div class="news-text-btn">
						<a href="/wap/detail/new/{{$item->id}}">
							<img src="{{ asset("/images/wap/空心.png") }}" alt="">
						</a>	
					</div>
					<div class="news-text-time">
						{{$item->created_at}}
					</div>
				</div>
			</li>
			@endforeach
			
		</div>
		<div class="view-more">
			<a href="/wap/company/news">
				查看更多
			</a>
		</div>
	</div>
</div>