<div class="article-content">
    <header class="article-header">
        <h1 class="font-heavy">
            {{ $data->title }}
        </h1>
        <time pubdate datetime="{{ $data->created_at }}">{{ $data->created_at }}</time>
    </header>
    <article class="article-article">
        <blockquote>
            <p>
                {{ $data->description }}
            </p>
        </blockquote>
        <div class="article-content">
            {!! $data->content !!}
        </div>
        <div class="article-footer clearfix">
            <div class="pull-left">
                <p>
                    上一篇：
                    @if ($prev_data)
                    <a href="/help/detail/{{ $prev_data->id }}">{{ $prev_data->title }}</a>
                    @else
                    <span>没有了</span>
                    @endif
                </p>
                <p>
                    下一篇：
                    @if ($next_data)
                    <a href="/help/detail/{{ $next_data->id }}">{{ $next_data->title }}</a>
                    @else
                    <span>没有了</span>
                    @endif
                </p>
            </div>
            <div class="pull-right">
                <a href="javascript:history.go(-1);">
                    <img src="{{ asset("/images/article_break.png") }}" alt="" />
                </a>
            </div>
        </div>
    </article>
    <div class="recommend">
        <h3 class="font-heavy">
            相关推荐
        </h3>
        <ul class="clearfix">
            @foreach ($recommend as $item)
            <li class="font-regular">
                <a href="/help/detail/{{ $item->id }}">{{ $item->title }}</a>
            </li>
            @endforeach
            <!-- <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li> -->
        </ul>
    </div>
</div>
