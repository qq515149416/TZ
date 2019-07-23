<div class="list-content">
    <h2>
        {{ $nav->name }}
    </h2>
    <!-- <div class="search-result-title font-regular">
        搜索“<span class="font-heavy">服务器</span>”的结果
    </div> -->
    <ul>
        @foreach ($data as $item)
        <li>
            <div class="media">
                <div class="media-left">
                    <a href="/help/detail/{{ $item->id }}">
                        <span class="date-day">
                            {{ date("d",strtotime($item->created_at)) }}
                        </span>
                        <span class="date-years">
                            {{ date("Y.m",strtotime($item->created_at)) }}
                        </span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="/help/detail/{{ $item->id }}">
                        <h4 class="media-heading">
                            <!-- <span class="top">置顶</span> -->
                            {{ $item->title }}
                        </h4>
                        <p>
                        {{ $item->description }}
                        </p>
                    </a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
