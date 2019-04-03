<header class="banner">
    <h2>{{ $title }}</h2>
    <h3>{{ $subtitle }}</h3>
    <p>{{ $descripts }}</p>
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
