<div class="list-content">
    @isset($nav)
        <h2>
            {{ $nav->name }}
        </h2>
    @endisset
    @isset($keyword)
        <div class="search-result-title font-regular">
            搜索“<span class="font-heavy">{{ $keyword }}</span>”的结果
        </div>
    @endisset
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
    @if(!isset($keyword))
        <div class="paginate">
            {{ $data->links() }}
        </div>
    @endif
</div>
