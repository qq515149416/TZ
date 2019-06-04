<header class="banner">
    <h2 class="title font-bold">{{ $title }}</h2>
    <h4 class="sub-title font-regular">
        {{ $subtitle }}<br/>
        {{ $descripts }}
    </h4>
</header>
<article class="content-list">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        {{ $nav }}
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        {{ $slot }}
    </div>
</article>
