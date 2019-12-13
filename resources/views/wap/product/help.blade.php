<div class="problems-li">
	<div class="tz-main">
		<ul>
			@foreach ($help as $item)
				
				<li class="clear">
					
					<img src="{{ asset("/images/wap/问题.png") }}" alt="">
					<a href="/wap/help_articles/{{$item->id}}">
						<p>{{ str_limit($item->title , 26 ,'...')}}</p>
					</a>
					<p class="time-p">{{ str_limit($item->created_at , 10 ,'')}}</p>
					
				</li>
				
			@endforeach 
		</ul>
		<div class="view-more">
			@if ($help_id == 0)
				<a href="/wap/help_center">
					查看更多
				</a>
			@else
				<a href="/wap/help_center_home/{{$help_id}}?page=1">
					查看更多
				</a>
			@endif
			
		</div>
	</div>
</div>