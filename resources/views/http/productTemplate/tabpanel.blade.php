<div role="tabpanel" class="tab-pane {{ $status }}" id="{{ $id }}">
    <h3>{{ $machine_room->name }}</h3>
    <p>机房概况：{{ $machine_room->overview }}</p>
    <p>
        <!-- 国家 <span class="focus">AAA</span> 级机房 -->
        机房等级：{{ $machine_room->grade }}
        <a href="{{ $machine_room->detail_url }}">查看机房实景</a>
    </p>
    <div class="data-table">
        <div class="data-table-row">
            <div class="data-table-col thead">
                线路
            </div>
            <div class="data-table-col thead">
                规格
            </div>
            <div class="data-table-col thead">
                内存
            </div>
            <div class="data-table-col thead">
                硬盘
            </div>
            <div class="data-table-col thead">
                带宽
            </div>
            <div class="data-table-col thead">
                IP数
            </div>
            <div class="data-table-col thead">
                单机防御
            </div>
            <div class="data-table-col thead">
                月付
            </div>
            <div class="data-table-col thead">
                年付
            </div>
        </div>
        @foreach ($data as $item)
        <div class="data-table-row">
            <div class="data-table-col thead">
                {{ $item["line"] }}
            </div>
            <div class="data-table-col">
                {{ $item["format"] }}
            </div>
            <div class="data-table-col">
                {{ $item["ram"] }}
            </div>
            <div class="data-table-col">
                {{ $item["hardDisk"] }}
            </div>
            <div class="data-table-col">
                {{ $item["bandwidth"] }}
            </div>
            <div class="data-table-col">
                {{ $item["ip"] }}
            </div>
            <div class="data-table-col">
                {{ $item["defense"] }}
            </div>
            <div class="data-table-col">
                {{ $item["monthlyPay"] }}
            </div>
            <div class="data-table-col">
                {{ $item["annualFee"] }}
            </div>
        </div>
        @endforeach
    </div>
</div>
