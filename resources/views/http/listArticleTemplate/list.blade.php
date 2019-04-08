<h2>
    {{ $vars['content'] }}
    <span class="pull-right">
        <a href="#">首页</a> >
        <a href="#">新闻中心</a> >
        <a href="#" class="active">{{ $vars['content'] }}</a>
    </span>
</h2>
<ul>
    @foreach ($data as $i => $item)
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
<div class="paginate">
    {{ $data->links() }}
</div>
