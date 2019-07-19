<div class="collection">
    @foreach ($nav as $item)
    <div class="paper">
        <h3 class="font-medium">
            {{ $item->name }}
        </h3>
        <ul class="font-regular">
            @foreach ($list_data->where('category_id',$item->id)->get() as $item)
            <li>
                <a href="/help/detail/{{ $item->id }}">
                    {{ $item->title }}
                </a>
            </li>
            @endforeach
            <!-- <li>
                <a href="javascript:;">
                    CentOS查看硬件信息命令
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    CentOS查看硬件命令总汇
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    CentOS查看硬件命令总汇
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    CentOS查看硬件命令总汇
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    CentOS查看硬件命令总汇
                </a>
            </li> -->
        </ul>
        <a class="font-regular" href="/help/category/{{ $item->id }}">查看更多</a>
    </div>
    @endforeach
</div>
