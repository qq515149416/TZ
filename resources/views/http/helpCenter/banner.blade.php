  <!--banner-->
  <div class="banner">
    <h2 class="title font-bold">帮助中心</h2>
    <div class="search-container">
        <form action="/help/search" method="get">
            <input type="text" name="keyword" class="search-input font-regular" placeholder="" value="{{ $tags[0]->name }}">
            <button class="btn search-btn font-medium" type="submit">立即咨询</button>
        </form>
    </div>
    <div class="popular-keyword">
        <span class="font-heavy" style="font-size: 14px; letter-spacing: 1.05px;">热门：</span>
        @foreach ($tags as $tag)
            <a class="keyword font-regular" href="javascript: setKeyword('{{ $tag->name }}');">{{ $tag->name }}</a>
        @endforeach
        <!-- <a class="keyword font-regular" href="javascript: void(0);">服务器托管好吗</a>
        <a class="keyword font-regular" href="javascript: void(0);">云主机安全吗</a>
        <a class="keyword font-regular" href="javascript: void(0);">大带宽价格</a>
        <a class="keyword font-regular" href="javascript: void(0);">网络安全</a> -->
    </div>
    <script>
        function setKeyword(value) {
            document.querySelector('input[name=keyword]').value=value;
        }
    </script>
</div>
