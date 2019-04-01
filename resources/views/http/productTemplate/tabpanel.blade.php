<div role="tabpanel" class="tab-pane {{ $status }}" id="{{ $id }}">
    <h3>{{ $data[$index]['room'] }}</h3>
    <p>机房概况：{{ $data[$index]['overview'] }}</p>
    <p>
        机房等级：国家 <span class="focus">{{ $data[$index]['grade'] }}</span> 级机房
        <a href="{{ $data[$index]['detail'] }}">查看机房实景</a>
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
        @foreach ($data[$index]['machines'] as $item)
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
                {{ $item["disk"] }}
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
