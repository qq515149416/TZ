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
                    上一篇：<a href="javascript:;">云计算成本优化的六大支柱</a>
                    <!-- <span>没有了</span> -->
                </p>
                <p>
                下一篇：<a href="javascript:;">实现云计算的承诺需要一致的安全性</a>

                <!-- <span>没有了</span> -->
                </p>
            </div>
            <div class="pull-right">
                <a href="javascript:;">
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
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
            <li class="font-regular">
                <a href="javascript:;">云计算技术对大企业的影响</a>
            </li>
        </ul>
    </div>
</div>
