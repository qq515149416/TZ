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

</article>

