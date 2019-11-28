<header class="article-header">
    <h1>
        {{ $data->titles }}
    </h1>
    <time pubdate datetime="{{ $data->createdate }}">{{ $data->createdate }}</time>
</header>
<article class="article-article">
    <blockquote>
        <p>{{ $data->digest }}</p>
    </blockquote>
    <div class="article-content">
        {!! $data->content !!}
    </div>
    <div class="article-footer clearfix">
        <div class="pull-left">
            <p>
                上一篇：
                @if ($prev_data)
                    <a href="/detail/{{ $reverse_type[$prev_data->sid] }}/{{ $prev_data->newsid }}">{{ $prev_data->titles }}</a>
                @else
                    <span>没有了</span>
                @endif
            </p>
            <p>
            下一篇：
            @if ($next_data)
                <a href="/detail/{{ $reverse_type[$next_data->sid] }}/{{ $next_data->newsid }}">{{ $next_data->titles }}</a>
            @else
                <span>没有了</span>
            @endif
            </p>
        </div>
        <div class="pull-right">
            <a href="/article/{{ $vars['name'] }}">
                <img src="{{ asset("/images/article_break.png") }}" alt="" />
            </a>
        </div>
    </div>
</article>

